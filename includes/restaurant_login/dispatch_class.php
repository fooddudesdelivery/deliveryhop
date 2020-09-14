<?php

include_once dirname(__FILE__) . '/../../db_config.php';

class Dispatch{
	function __construct($email='',$subject='Reprint',$message,$from='orders')
    {
		$this->from=$from;
        $this->email=$email;
		$this->subject=$subject;
		$this->message=$message;
    }
	function set_dispatch_info($dispatch){
		$this->send_method_code=$dispatch['send_method_code'];
		$this->cloud_print_id=$dispatch['cloud_print_id'];
		$this->email=$dispatch['email'];
		$this->fax=$dispatch['fax'];

	}
	
	function get_dispatch_info(){
		$disp[]=$this->send_method_code;
		$disp[]=$this->cloud_print_id;
		$disp[]=$this->email;
		$disp[]=$this->fax;
		return $disp;
	}
	
	function set_orders_id($orders_id){
		$this->orders_id=$orders_id;
	}
	function reprint(){

		if($this->orders_id && $this->send_method_code){
			$this->get_invoice();
			$this->message=$this->invoice;
			$send_method = str_split($this->send_method_code);

			
			if($send_method[0]){
				$this->send_email();
				
			}
			if($send_method[1]){
				$this->send_pdf_fax();
			}
		}else{
			return false;	
		}
	}
	function send_text()
	{
		$sent = mail($this->email,$this->subject,$this->message,"",'-f '.$this->from);
		if ($sent){
			return true;
		}else{
			return false;
		}
	}
	
	function send_email(){
		$this->subject='Food Dudes Delivery #'.$this->orders_id;
		$this->from='orders';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$param = '-f '.$this->from;
		
		$sent = mail($this->email,$this->subject,$this->message,$headers,$param);
		if($sent){
			$this->success('Email sent to '.$this->email);
		}else{
			
		}
		
		
	}
	
	function send_pdf_email(){
		$this->create_pdf();
		$to = $this->email;
		$from = $this->from; 
		$subject = $this->subject; 
		$message = "The weekly sales report is attached, please contact us if you have any questions.";
		$message.=" -Regards, Food Dudes Delivery  ".$dates;
		$separator = md5(time());
		$eol = PHP_EOL;
		$filename .='FoodDudesDelivery.pdf';
		$data = $this->pdf->Output("","E");
		$data = explode('filename=""',$data);
		$attachment = $data[1];
		$headers  = "From: ".$from.$eol;
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
		$sent = mail($to, $subject, $body, $headers);	
		if($sent){
			$this->success('PDF email sent to '.$this->email);
		}else{

		}
	}
	
	
	
	function send_pdf_fax(){
		//$this->from='service@staging.fooddudesdelivery.com';
		$this->from=_SERVICE_EMAIL;
		$this->create_pdf();
		$to = $this->fax.'@rcfax.com';
		$from = $this->from; 
		$subject = ''; 
		$message = "";
		$separator = md5(time());
		$eol = PHP_EOL;
		$filename .='FoodDudesDelivery.pdf';
		$data = $this->pdf->Output("","E");
		$data = explode('filename=""',$data);
		$attachment = $data[1];
		$headers  = "From: ".$from.$eol;
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
		if($sent){
			$this->success('PDF fax sent To: '.$to.',From: '.$from);

		}else{

		}
	}	
	
	
	function create_pdf()
    {
		require('includes/restaurant_login/tcpdf/custompdf.php');
		$this->pdf=new Custom_PDF();
		if($id!=0){
			$this->setFooterText('Order: '.$id);	
		}
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('David Carlson');
		$this->pdf->SetTitle('Food Dudes Delivery');
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
		$this->pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $this->message, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    }
	
	
	function get_invoice(){
		require('includes/restaurant_login/restaurant_invoice.php');
			
	}
}// EOF CLASS


?>