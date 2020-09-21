<?php
	require_once('includes/configure.php');
	date_default_timezone_set(SITE_TIMEZONE);
	$db_custom = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	class AutoSendNew{
		private $orders_id;
		private $send_info;
		private $db;
		private $invoice;
		private $pdf;
		private $from = SERVICE_EMAIL;

		function __construct(){
			try{
				$this->db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				print_r($e->getMessage());
			}
		}

		public function send($orders_id,$put_placed=false,$send_push=true){
			//das ist ein primary function
			$this->orders_id = intval(preg_replace('/[^0-9]/s', '', $orders_id));
			$this->db->query("INSERT into auto_send_history (orders_id,json_history) VALUES ($this->orders_id, '".strtotime('now')."')");
			$auto_send_history_id=intval($this->db->lastInsertId());

			if($this->orders_id<1){
				echo 'No orders id';
				return false;
			}

			if(!$this->getSendInfo()){
				echo 'No send info';
				return false;
			}

			$this->getRestaurantInvoice();
			$this->createPdf();

			$status=array();
			if($this->send_info['send_method_code'][1]==1){
				//echo 'fax';
				$status['fax']=$this->sendPdfFax();
			}
			if($this->send_info['send_method_code'][2]==1){
				//echo 'cloud';
				$status['cloud']=$this->sendCloud();
			}

			$update = addslashes(
				json_encode(
					array(
						'send_response'=>$status,
						'send_info'=>$this->send_info,
						'timestamp'=>strtotime('now')
					)
				)
			);

			$st = (isset($_GET["auto_disabled"]) && $_GET["auto_disabled"]=="1")?"Manual":"Auto";

			$auto_update = "UPDATE auto_send_history SET json_history='$update' WHERE auto_send_history_id=$auto_send_history_id";

			$orders_status_history_sql="INSERT INTO orders_status_history ( orders_id, orders_status_id, comments, updated_by, date_added) VALUES ($this->orders_id,'2','','$st', NOW())";

			$orders_sql = "UPDATE orders set orders_status=2,last_modified=NOW() where orders_id = $this->orders_id";

			$this->db->query($auto_update);

			if($put_placed){
				$this->db->query($orders_sql);
			}

			$this->db->query($orders_status_history_sql);

			try{
				if(isset($_GET['from_driver']) && $_GET['from_driver']==1){
					include (__DIR__."/node/phpsocks/driveraccept.php");
				}
			}catch(Exception $e){}
		}

		private function getSendInfo(){
			$info_sql = "SELECT send_method_code,email,cloud_print_id,fax,categories_name,cd.categories_id
			FROM categories_description AS cd INNER JOIN orders AS o ON o.categories_id = cd.categories_id 
			WHERE o.orders_id = $this->orders_id LIMIT 0,1";
			$this->send_info= $this->db->query($info_sql)->fetch(PDO::FETCH_ASSOC);
			if(!isset($this->send_info['send_method_code'])){
				return false;
			}else{
				return true;
			}
		}

		private function getNotes(){
			$info_sql = "SELECT note from notes where note_type in (1,4) and order_id=".$this->orders_id;
			$info_sql = $this->db->query($info_sql)->fetchAll(PDO::FETCH_ASSOC);
			return $info_sql ;
		}

		private function sendCloud(){
			$token_sql="SELECT refresh_token FROM google_cloud_print_refresh_tokens AS g INNER JOIN orders AS o ON o.categories_id = g.categories_id WHERE o.orders_id = $this->orders_id LIMIT 0,1";
			$ref_token= $this->db->query($token_sql)->fetch(PDO::FETCH_ASSOC);
			$api_info = $this->db->query('select * from google_cloud_print')->fetch(PDO::FETCH_ASSOC);
			$refresh_array = array(
				'client_id' => $api_info["client_id"],
				'client_secret' => $api_info["client_secret"],
				'refresh_token'=>$ref_token['refresh_token'],
				'grant_type'=>'refresh_token'
			);

			$curl_connection = curl_init('https://www.googleapis.com/oauth2/v3/token');
			curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl_connection, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl_connection, CURLOPT_POSTFIELDS, http_build_query($refresh_array));
			$result_refresh = curl_exec($curl_connection);
			$result_refresh = json_decode($result_refresh, true);
			curl_close($curl_connection);

			if(isset($result_refresh['error'])){
				print_r('Not Printed: '.$result_refresh['error'].' '.$result_refresh['error_description']);
				return false;
			}

			$curl_connection = curl_init('https://www.google.com/cloudprint/search');
			curl_setopt($curl_connection,CURLOPT_HTTPHEADER,array('Authorization: OAuth '.$result_refresh['access_token']));
			curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl_connection, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
			$result_search = curl_exec($curl_connection);
			$result_search = json_decode($result_search, true);
			curl_close($curl_connection);

			if(!$result_search['xsrf_token'] || $result_search['xsrf_token']==""){
				print_r('Something went wrong, order possibly didnt print');
				return false;
			}

			$data = $this->pdf->Output("","E");
			$data = explode('filename=""',$data);
			$post_data = array(
				'xsrf' => $result_search['xsrf_token'], 
				'printerid' => $this->send_info['cloud_print_id'],
				'ticket' => '{"version": "1.0", "print": {}}',
				'contentType' => 'application/pdf',
				'contentTransferEncoding' => 'base64',
				'content' => $data[1]
			);

			$curl_connection =curl_init('https://www.google.com/cloudprint/submit');
			curl_setopt($curl_connection,CURLOPT_HTTPHEADER,array('Authorization: OAuth '.$result_refresh['access_token']));
			curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl_connection, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl_connection, CURLOPT_POSTFIELDS, http_build_query($post_data));
			$result_submit = curl_exec($curl_connection);
			$result_submit = json_decode($result_submit,true);
			curl_close($curl_connection);
			if($result_submit['success']==1){
				return true;
			}else{
				if($result_submit['message']){
					print_r($result_submit['message']);
				}
				return false;
			}
		}

		private function sendPdfFax(){
			$main_backup_check=null;
			try{
				$main_backup_check = $this->db->query("select backup_config from switch_backups where switch_backups_id=1")->fetch(PDO::FETCH_ASSOC);
				$main_backup_check=json_decode($main_backup_check['backup_config'],true);
				$tmp=array();
				foreach($main_backup_check as $b){
					$tmp[$b['type']]=$b['value'];
				}
				$main_backup_check=$tmp;
			}catch(Exception $e){}

			if($main_backup_check['fax']==1 || $main_backup_check==null){
				$fax_to='@rcfax.com';
				$fax_from='fax@deliverhop.app';
			}else{
				$fax_to='@rcfax.com';
				$fax_from='deliverhop@server.deliverhop.app';
			}
			$this->send_info['fax']=intval(preg_replace('/[^0-9]/s', '', $this->send_info['fax']));
			$to = $this->send_info['fax'].$fax_to;
			$subject = '';
			$message = "";
			$separator = md5(time());
			$eol = PHP_EOL;
			$filename = SITE_NAME.'.pdf';
			$data = $this->pdf->Output("","E");
			$data = explode('filename=""',$data);
			$attachment = $data[1];
			$headers = "From: ".$fax_from.$eol;
			$headers .= "MIME-Version: 1.0".$eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";
			$body = "--".$separator.$eol;
			$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
			$body .= "".$eol;
			$body .= "--".$separator.$eol;
			$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
			$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$body .= $message.$eol;
			$body .= "--".$separator.$eol;
			$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
			$body .= "Content-Transfer-Encoding: base64".$eol;
			$body .= "Content-Disposition: attachment".$eol.$eol;
			$body .= $attachment.$eol;
			$body .= "--".$separator."--";
			$sent=mail($to, $subject, $body, $headers);
			return $sent;
		}

		private function sendPdfEmail(){
			$subject = SITE_NAME;
			$message = "The weekly sales report is attached, please contact us if you have any questions.";
			$message.=" -Regards, ".SITE_NAME." ".$dates;
			$separator = md5(time());
			$eol = PHP_EOL;
			$filename .= SITE_NAME.'.pdf';
			$data = $this->pdf->Output("","E");
			$data = explode('filename=""',$data);
			$attachment = $data[1];
			$headers = "From: ".$this->from.$eol;
			$headers .= "MIME-Version: 1.0".$eol; 
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";
			$body = "--".$separator.$eol;
			$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
			$body .= "".$eol;
			$body .= "--".$separator.$eol;
			$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
			$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$body .= $message.$eol;
			$body .= "--".$separator.$eol;
			$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
			$body .= "Content-Transfer-Encoding: base64".$eol;
			$body .= "Content-Disposition: attachment".$eol.$eol;
			$body .= $attachment.$eol;
			$body .= "--".$separator."--";
			$sent = mail($this->send_info['email'], $subject, $body, $headers);
			return $sent;
		}

		private function createPdf(){
			require('aAsd23fadfAd2565Hccxz/includes/tcpdf/newpdf.php');
			$this->pdf=new Custom_PDF();
			if($this->orders_id!=0){
				$this->pdf->setFooterText('Order: '.$this->orders_id);
			}
			$this->pdf->SetCreator(PDF_CREATOR);
			$this->pdf->SetAuthor(AUTHOR_NAME);
			$this->pdf->SetTitle(SITE_NAME);
			$this->pdf->SetSubject('Report');
			$this->pdf->SetKeywords('');
			$this->pdf->SetFont('helvetica', 'I', 10);
			$this->pdf->setFooterData(array(0,64,0), array(0,64,128));
			$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$this->pdf->setFontSubsetting(true);
			$this->pdf->AddPage();
			$this->pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $this->invoice, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		}

		private function getRestaurantInvoice(){
			$oID = $this->orders_id;
			$order_array = array();
			$order_array_sql = $this->db->query("SELECT op.pickup_order,o.products_price as products_price,updated_from_future,o.onetime_charges,op.duration_to_deliver,o.products_name,o.products_quantity,op.date_purchased,op.date_deliver,o.orders_products_id,
			op.customers_name,op.customers_telephone, op.orders_status
			FROM orders_products AS o
			LEFT JOIN orders AS op ON op.orders_id = o.orders_id
			WHERE o.products_model != 'BEVERAGE'
			AND o.products_model != 'FOODDUDEMISC'
			AND op.orders_id =". (int)$oID);

			foreach($order_array_sql as $os){
				$order_array[] = array(
					'products_price'=>$os['products_price'],
					'products_quantity'=>$os['products_quantity'],
					'date_deliver'=>$os['date_deliver'],
					'pickup_order'=>$os['pickup_order'],
					'updated_from_future'=>$os['updated_from_future'],
					'onetime_charges'=>$os['onetime_charges'],
					'duration_to_deliver'=>$os['duration_to_deliver'],
					'date_purchased'=>$os['date_purchased'],
					'customers_name'=>$os['customers_name'],
					'customers_telephone'=>$os['customers_telephone'],
					'orders_products_id'=>$os['orders_products_id'],
					'products_name'=>$os['products_name'],
					'orders_status'=>$os['orders_status']
				);
			}

			$orders_total = $this->db->query('SELECT * FROM `orders_total` where  orders_id="'.$oID.'"');
			$orders_total_arr = [];
			foreach($orders_total as $order_total_value){
				$orders_total_arr[$order_total_value['class']] = [
					'text' => $order_total_value['text'],
					'value' => $order_total_value['value']
				];
			}

			$note_string='';
			$note_sql=$this->db->query('select note from notes where note_type="1" and order_id="'.$oID.'"');
			foreach($note_sql as $nq) {
				$note_string.=', '.$nq['note'];
			}

			$category_description = $this->db->query('select c.categories_name, c.address from categories_description as c inner join orders o on o.categories_id=c.categories_id where o.orders_id="'.$oID.'"');
			$restaurant_address = '';
			$name = '';
			foreach($category_description as $n){
				$restaurant_address=$n['address'];
				$name=$n['categories_name'];
			}

			$order_atr = array();
			$order_atr_sql = $this->db->query("SELECT pa.orders_products_id,pa.products_options, pa.products_options_values,pa.options_values_price,pa.price_prefix from orders_products_attributes as pa where pa.orders_id =". (int)$oID);

			foreach($order_atr_sql as $oas){
				$order_atr[] = array('orders_products_id'=>  $oas['orders_products_id'], 
				'products_options'=>  $oas['products_options'], 
				'price_prefix'=>  $oas['price_prefix'], 
				'options_values_price'=>  $oas['options_values_price'], 
				'products_options_values'=>  $oas['products_options_values']);
			}
			$tmp = $this->db->query('select limit_value from limits where limit_name="time_difference_to_be_future"');
			foreach($tmp as $tt){
				$limit = -$tt['limit_value'];
			}

			$del_est = floatval($order_array[0]['duration_to_deliver'])+300;
			if($del_est<1200){
				$del_est=1200;
			}

			if($order_array[0]['pickup_order']==1){
				$format_date = date('m/d/y g:ia',strtotime($order_array[0]['date_deliver']));
				$format_date_asap = date('m/d/y',strtotime($order_array[0]['date_deliver']));
			}else{
				$format_date = date('m/d/y g:ia',strtotime($order_array[0]['date_deliver'])-$del_est);
				$format_date_asap = date('m/d/y',strtotime($order_array[0]['date_deliver'])-$del_est);
			}

			$true_date = strtotime($order_array[0]['date_deliver']);
			$now = strtotime('now');
			$difference = ($now - $true_date)/60;
			if($difference<$limit){
				$asap=false;
				$when_to_make = "";
				$when_to_format=$format_date;
			}else{
				$asap=true;
				$when_to_make = "";
				$when_to_format=$format_date_asap.' ASAP';
			}

			$grand_total=0;
			$r_invoice='';
			$r_invoice.='<table width="100%" border="0">';
			$r_invoice.='<tr style="text-align:center">
			<th colspan="3" style="font-size:16px;text-align:center">Order: '.$oID.'</th>';
			$r_invoice.='</tr>';
			if($order_array[0]['pickup_order']==1){
				$pord = 'Pickup @ '.$restaurant_address;
			}else{
				$pord = 'Delivery @ '.$restaurant_address;
			}

			$r_invoice.='<tr style="text-align:center"><th colspan="3" style="font-size:16px;text-align:center">'.$pord.'</th>';
			$r_invoice.='</tr>';
			if($order_array[0]['pickup_order']==1){
				$r_invoice.='<tr style="text-align:center">
				<th  colspan="3" style="font-size:16px;text-align:center">
				'.$order_array[0]['customers_name'].' - '.$order_array[0]['customers_telephone'].'
				</th>';
				$r_invoice.='</tr>';
			}

			$r_invoice.='<tr style="text-align:center"><th colspan="3" style="font-size:16px">'.$when_to_make;
			if($asap){
				$r_invoice.=$when_to_format; 
			}else{
				$r_invoice.='<b style="font-size:18px">'.$when_to_format.'</b>' ;
			}

			$r_invoice.='</th>
			</tr>
			<tr>
				<td colspan="3" width="97%"><hr /></td>
			</tr>';
			for($r=0;$r<count($order_array);$r++){
				if(intval($order_array[$r]['products_quantity'])>1){
					$si='18px;font-weight:bold;';
				}else{
					$si='14px;';
				}
				$r_invoice.=' <tr >
				<td style="font-size:'.$si.'" width="9%">'.$order_array[$r]['products_quantity'].'&nbsp; x</td>
				<td style="font-size:14px" width="59%" >'.$order_array[$r]['products_name'].'</td>
				<td style="font-size:14px;padding-left:10px" width="29%">'.money_format('$%i', floatval($order_array[$r]['products_quantity'])*$order_array[$r]['products_price']).'</td>
				</tr>';

				if($order_array[$r]['onetime_charges']!=0){
					$r_invoice.= '<tr>';
					$r_invoice.= '<td></td><td style="font-size:14px">Order Adjustment</td><td style="font-size:14px;padding-left:10px">'.money_format('$%i', $order_array[$r]['onetime_charges']).'</td>';
					$r_invoice.='</tr>';
				}
				$grand_total= $grand_total + floatval($order_array[$r]['products_quantity'])*$order_array[$r]['products_price']+$order_array[$r]['onetime_charges'] ;

				for($ra=0;$ra<count($order_atr);$ra++){
					if($order_atr[$ra]['orders_products_id']==$order_array[$r]['orders_products_id']){
						$r_invoice.='<tr>
							<td></td>
							<td style="font-size:14px;padding-left:10px">-'.$order_atr[$ra]['products_options_values'].'</td>';
						if($order_atr[$ra]['options_values_price'] !=0){
							if($order_atr[$ra]['price_prefix']=='+' || $order_atr[$ra]['price_prefix']==''){
								$grand_total= $grand_total + $order_array[$r]['products_quantity']*floatval($order_atr[$ra]['options_values_price']);
							}else{
								$grand_total= $grand_total -$order_array[$r]['products_quantity']*floatval($order_atr[$ra]['options_values_price']);
							}

							$r_invoice.= '<td style="font-size:14px;padding-left:10px">'.$order_atr[$ra]['price_prefix'].money_format('$%i', $order_array[$r]['products_quantity']*$order_atr[$ra]['options_values_price']).'</td>';
						}
						$r_invoice.=' </tr>';
					}
				}
				$r_invoice.='<tr >
				<td><hr /></td>
				<td><hr /></td>
				<td><hr /></td>
				</tr>';
			}

			if($order_array[0]['pickup_order']==1){
				// Total remove for delivery. from orders_table add these lines

				if(!empty($orders_total_arr['ot_subtotal'])){
					$r_invoice.='<tr>
						<td></td>
						<td style="font-size:14px">Subtotal: </td>
						<td style="font-size:14px">&nbsp;'.$orders_total_arr['ot_subtotal']['text'].'</td>
					</tr>';
				}

				if(!empty($orders_total_arr['ot_tax'])){
					$r_invoice.='<tr>
						<td></td>
						<td style="font-size:14px">Sales Tax: </td>
						<td style="font-size:14px">&nbsp;'.$orders_total_arr['ot_tax']['text'].'</td>
					</tr>';
				}

				if(!empty($orders_total_arr['ot_total'])){
					$r_invoice.='<tr>
						<td></td>
						<td style="font-size:14px">Total: </td>
						<td style="font-size:14px">&nbsp;'.$orders_total_arr['ot_total']['text'].'</td>
					</tr>';
				}
			} else {
				if(!empty($orders_total_arr['ot_subtotal'])){
					$r_invoice.='<tr>
						<td></td>
						<td style="font-size:14px">Total: </td>
						<td style="font-size:14px">&nbsp;'.$orders_total_arr['ot_subtotal']['text'].'</td>
					</tr>';
				}
				// Pickup total remove fetch subtotal from orders and name as total
			}

			$note = $this->getNotes();
			$ns = array();

			foreach($note as $n){
				$ns[]=$n['note'];
			}

			$r_invoice.='<tr>
			<td></td>
			<td  style="font-size:14px">Special Instructions:&nbsp; '. implode(',  ',$ns) .'</td>
			<td></td>
			</tr>';

			$r_invoice.='</table>';
			$this->invoice=utf8_encode(urldecode(urlencode(preg_replace('/\s+/', ' ',$r_invoice))));
			
		}
	}

	$autoNew = new AutoSendNew;
	$res = $autoNew->send($_GET['order_id']);
?>