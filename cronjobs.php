<?php
/**
 * cron jobs for automation front controller
 *
 * @package templateSystem
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson   New in v1.5.4 $
 */
require ('includes/configure.php');
global $db;
date_default_timezone_set('America/Chicago');
$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
/*
  1. Find orders that are in new status, not a pickup order, delivery date must match current date, and order must have timestamp of 2 min or greater from time when order was placed
  2. Check to see if order has been suggested to a driver if so determine if the order should be send to the suggested driver. Order can be sent to suggested driver if driver is on 0 orders or on 1 order and in picked up status
  3. If order not suggested then check for drivers within 2 miles of restaurant location and dispatch to driver that has been available the longest and and is not on any orders
  4. If not drivers available within 2 miles of restaurant then check the whole zone for available drivers and send to driver closest to restaurant that is not on any other orders
*/
if(isset($_GET['type']) && $_GET['type']=='autodispatch'){
  resetOrder();
  writeRequestResponseLog($_GET['type']);
  $today = date('Y-m-d');
  $lastModify =date("Y-m-d H:i:s", strtotime("-60 seconds")); //ex. -90 seconds, -2 minutes, -3 minutes, -4 minutes, -5 minutes
  $suggestedOrders = $db->query("SELECT * FROM orders WHERE 
      orders_status = '1' 
      AND date_deliver > '".$today." 00:00:00'
      AND date_deliver < '".$today." 23:59:00'
      AND pickup_order != '1'
      AND suggested_admin != '0'  
      AND 1 = (SELECT orders_status_id FROM `orders_status_history` WHERE `orders_id` = orders.orders_id ORDER BY `orders_status_history`.`orders_status_history_id` DESC limit 1)     
    ")->fetchAll(PDO::FETCH_ASSOC);
  $sugArray= array();
  foreach ($suggestedOrders as $key => $order) {
    $sugArray[$order['suggested_admin']][]=$order;
  }
  if(!empty($sugArray)){
    foreach ($sugArray as $adminid => $orderArray) {
//      $flg = checkPickupOrder($adminid);
    $flg=1;
      if($flg){
        foreach($orderArray as $key => $order){
          $driverId = $order['suggested_admin'];
          dispatchOrderSuggested($order['orders_id'],$driverId);
        }
      }else{
        foreach($orderArray as $key => $order){
          $nflg = checkorderWithoutpickup($order['suggested_admin']);
          if($nflg){
            $driverId = $order['suggested_admin'];
            dispatchOrderSuggested($order['orders_id'],$driverId);
          }
        }
      }
    }
  }
  $orders = $db->query("SELECT * FROM orders WHERE 
      orders_status = '1' 
      AND date_deliver > '".$today." 00:00:00'
      AND date_deliver < '".$today." 23:59:00'
      AND pickup_order != '1'
      AND suggested_admin = '0'
      AND date_purchased <= '".$lastModify ."' 
      AND 1 = (SELECT orders_status_id FROM `orders_status_history` WHERE `orders_id` = orders.orders_id ORDER BY `orders_status_history`.`orders_status_history_id` DESC limit 1) 
      ORDER BY date_purchased ASC            
    ")->fetchAll(PDO::FETCH_ASSOC);
  foreach ($orders as $key => $order) {
      writeRequestResponseLog('order-'.$order['orders_id']);
      $categoryId = $order['categories_id'];
      writeRequestResponseLog('Not suggested category id   -'. $categoryId);
      $category = $db->query("SELECT * FROM categories c, categories_description cd WHERE c.categories_id = '".$categoryId."' AND cd.categories_id = c.categories_id")->fetch(PDO::FETCH_ASSOC);
      writeRequestResponseLog($category);
    // no cash flag
    $cod_flag = ($order["payment_module_code"] == "cod" )?" AND no_cash_flag='0' ":"";
      $adminList = $db->query("SELECT * FROM admin WHERE 
          categories_id = '".$category['parent_id']."'
          AND admin_status = 1 ".$cod_flag."")->fetchAll(PDO::FETCH_ASSOC);
      writeRequestResponseLog($adminList);
      $less2miles = $greater2miles = array();
      foreach ($adminList as $keyadmin => $admin) {
          $driverTrack = $db->query("SELECT * FROM driver_tracking WHERE admin_id= '".$admin['admin_id']."' ORDER BY timestamp DESC")->fetch(PDO::FETCH_ASSOC);
           writeRequestResponseLog('driver tracking');
           writeRequestResponseLog($driverTrack);
          if(!empty($driverTrack)){
            $distance = distance($category['lat'],$category['lng'],$driverTrack['lat'],$driverTrack['lng'],'M');
            $to_time = strtotime(date("Y-m-d H:i:s"));
            $from_time = strtotime($driverTrack['timestamp']);
            $minutes = round(abs($to_time - $from_time) / 60,2); //. " minute";
            if($distance<=2){
              $less2miles[$admin['admin_id']] = $minutes;
            }else{
              $greater2miles[$admin['admin_id']] = $distance;
            }
          }
      }
      if(!empty($less2miles)){ //check longest time idol driver when deiver in 2 miles
        arsort($less2miles);
        writeRequestResponseLog('less2miles');
        writeRequestResponseLog($less2miles);
        foreach ($less2miles as $adminId => $minues) {
          $conditionHistory = $db->query("SELECT * FROM orders_history WHERE 
            orders_id = '".$order['orders_id']."' AND dispatch_to = '".$adminId."' 
          ")->fetchAll(PDO::FETCH_ASSOC);
          if(empty($conditionHistory)){
            $flge=checkorderexist($adminId);
            if($flge){
              $driverId = $adminId;
              dispatchOrder($order['orders_id'],$driverId);
              writeRequestResponseLog('in 2 miles dispatch to -'.$driverId);
              break;
            }
          }
        }
      }else if(!empty($greater2miles)){ //check nearest driver when driver greater then 2 miles
        asort($greater2miles);
        writeRequestResponseLog('greater2miles');
        writeRequestResponseLog($greater2miles);
        foreach ($greater2miles as $adminId => $dist) {
          $conditionHistory = $db->query("SELECT * FROM orders_history WHERE 
            orders_id = '".$order['orders_id']."' AND dispatch_to = '".$adminId."' 
          ")->fetchAll(PDO::FETCH_ASSOC);
          if(empty($conditionHistory)){
            $flge=checkorderexist($adminId);
            if($flge && $adminId!=$order['orders_admin_id']){
              $driverId = $adminId;
              dispatchOrder($order['orders_id'],$driverId);
              writeRequestResponseLog('greater then 2 miles dispatch to -'.$driverId);
              writeRequestResponseLog('greater then 2 miles flag '.$flge.', deiverId-'.$adminId . ', order admin id -'.$order['orders_admin_id']);
              break;
            }else{
              writeRequestResponseLog('greater then 2 miles flag '.$flge.', deiverId-'.$adminId . ', order admin id -'.$order['orders_admin_id']);
            }
          }
        }
      }
  }
}
function checkPickupOrder($admin_id){
  global $db;
    $today = date('Y-m-d');
    $conditionOne = $db->query("SELECT * FROM orders WHERE 
        orders_admin_id = '".$admin_id."'
        AND orders_status != '10' AND last_modified > '".$today." 00:00:00'
        AND last_modified < '".$today." 23:59:00'
        ORDER BY last_modified DESC
      ")->fetchAll(PDO::FETCH_ASSOC);
    $flg=0;
    if(empty($conditionOne)){ // 0 order
      $flg=1;
    }else{
      foreach ($conditionOne as $key => $value) {
        if($value['orders_status']==8){ // 1 order in picked up status
          $flg=1;
        }else{
          $flg=0;
          break;
        }
      }
    }
    return $flg;
}
function checkorderWithoutpickup($admin_id){
  global $db;
  $today = date('Y-m-d');
  $conditionOne = $db->query("SELECT * FROM orders WHERE 
      orders_admin_id = '".$admin_id."'
      AND orders_status != '10' AND last_modified > '".$today." 00:00:00'
      AND last_modified < '".$today." 23:59:00'
      ORDER BY last_modified DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
  writeRequestResponseLog('checkorderexist');
  writeRequestResponseLog($conditionOne );
  $flg=0;
  if(empty($conditionOne)){ // 0 order
      $flg=1;
  }else{
    $oCount = count($conditionOne);
    $pOrder = 0;
    $npick = 0;
    foreach ($conditionOne as $key => $value) {
      if($value['orders_status']==8){ // 1 order in picked up status
        $pOrder = $pOrder+1;
        $npick=1;
      }else{
        //$flg=0;  
        //break;
      } 
    }
    if($pOrder != $oCount && $npick==0){
      foreach ($conditionOne as $key => $value) {
        if((in_array($value['orders_status'], [2,3,5]) && $value['orders_admin_id']==$value['suggested_admin'])){
          $flg=1;  
          break;
        }
      }
    }
  }
  return $flg;
}
function checkorderexist($admin_id,$isSuggested=0){  // check driver is on 0 orders or on 1 order and in picked up status
    global $db;
    $today = date('Y-m-d');
    $conditionOne = $db->query("SELECT * FROM orders WHERE 
        orders_admin_id = '".$admin_id."'
        AND orders_status != '10' AND last_modified > '".$today." 00:00:00'
        AND last_modified < '".$today." 23:59:00'
        ORDER BY last_modified DESC        
      ")->fetchAll(PDO::FETCH_ASSOC);
    writeRequestResponseLog('checkorderexist');
    writeRequestResponseLog($conditionOne );
    $flg=0;
    if(empty($conditionOne)){ // 0 order
      $flg=1;
    }else{
      writeRequestResponseLog('checkorderexist1');
      writeRequestResponseLog($conditionOne);
        if(count($conditionOne)==1){
          $lastModify =date("Y-m-d H:i:s", strtotime("-4 minutes")); //ex. -90 seconds, -2 minutes, -3 minutes, -4 minutes, -5 minutes
          if($conditionOne[0]['orders_status']==8 && $conditionOne[0]['last_modified'] < $lastModify){ // 1 order in picked up status
            $flg=1;  
          }
        }
    }
    return $flg;
}
function dispatchOrderSuggested($order_id, $admin_id){
  global $db;
  $orders = $db->query("SELECT * FROM orders WHERE 
      orders_status = '1' AND orders_id = '".$order_id."'
    ")->fetch(PDO::FETCH_ASSOC);
  if($orders['suggested_admin']==$admin_id){
    updateOrdersTrueHistory('1',$order_id,3,$admin_id);
    insert_driver_db($order_id, $admin_id);  
    sendDriverAppNewOrder($order_id, $admin_id);
    sendNotification($order_id, $admin_id);
  }
}
function dispatchOrder($order_id, $admin_id){
  global $db;
  $orders = $db->query("SELECT * FROM orders WHERE 
      orders_status = '1' AND orders_id = '".$order_id."'
    ")->fetch(PDO::FETCH_ASSOC);
  if($orders['suggested_admin']==0){
     $today = date('Y-m-d');
    $isSuggested = $db->query("SELECT * FROM orders WHERE 
      orders_status in (1,2,3,4,5,7,8) AND suggested_admin = '".$admin_id."'
      AND last_modified > '".$today." 00:00:00'
        AND last_modified < '".$today." 23:59:00'
    ")->fetch(PDO::FETCH_ASSOC);
    if(empty($isSuggested)){
      updateOrdersTrueHistory('1',$order_id,3,$admin_id);
      insert_driver_db($order_id, $admin_id);  
      sendDriverAppNewOrder($order_id, $admin_id);
      sendNotification($order_id, $admin_id);
    }
  }
}
// function dispatchOrder($order_id, $admin_id){
//   global $db;
//   $orders = $db->query("SELECT * FROM orders WHERE 
//       orders_status = '1' AND orders_id = '".$order_id."'
//     ")->fetch(PDO::FETCH_ASSOC);
//   if($orders['suggested_admin']==0 || $orders['suggested_admin']==$admin_id){
//     updateOrdersTrueHistory('1',$order_id,3,$admin_id);
//     insert_driver_db($order_id, $admin_id);  
//     sendDriverAppNewOrder($order_id, $admin_id);
//     sendNotification($order_id, $admin_id);
//   }
// }
function sendNotification($orderId, $driverId){
  global $db;
  $driver_sql = $db->query("SELECT admin_id,admin_email,admin_phone,admin_phone_extension from admin where admin_id='".$driverId."'")->fetch(PDO::FETCH_ASSOC);
  $email_address=$driver_sql['admin_email'];
  $phone_email = $driver_sql['admin_phone'].$driver_sql['admin_phone_extension'];
  $email_message = "<a href ='".SITE_ADMIN_URL."driver_index.php'>Click to Accept ".SITE_NAME." Order #".$orderId."</a> "."<br /> ";
  $phone_message = "New Order #".$orderId;
  $subject =SITE_NAME;
  send_email($email_address, $subject, $email_message, $orderId);
  send_text($phone_email,$phone_message,$subject);
}
function send_text($email,$message,$subject ){
  $phone_message = $message;
  writeRequestResponseLog( 'send_text');
  $new_name = explode(' ',get_admin_name(1));
  if(getEnableSms($email)==0){
    return;
  }
  writeRequestResponseLog( 'send_text-true');
  $sms_to=preg_replace("/[^0-9]/","",$email);
  $sms_message=$phone_message;
  smsSinchMsg('+1'.$sms_to,$sms_message);
  writeRequestResponseLog( 'send_text-sms');
}
function getEnableSms($admin_phone){
  global $db;
  $sms_to=preg_replace("/[^0-9]/","",$admin_phone);
  $info = $db->query('select enable_sms from admin where admin_phone = '.$sms_to)->fetch(PDO::FETCH_ASSOC);
  return (int)$info['enable_sms'];
}
function send_email($email_to,$subject,$message,$orders_id){
  writeRequestResponseLog( 'send_email');
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $param = '-f '._SERVICE_EMAIL;
  $sent = mail($email_to, $subject, $message,$headers,$param);
  writeRequestResponseLog('send_email -'.$email_to.$subject.$message.$headers.$param);
  if ($sent){
    writeRequestResponseLog('sent');
  }else{
    writeRequestResponseLog('not sent');
  }
}
function updateOrdersTrueHistory($admin_id,$orders_id,$orders_status_id,$dispatch_to=0){
  global $db;
  $admin_id=intval($admin_id);
  $orders_id=intval($orders_id);
  $orders_status_id=intval($orders_status_id);
  $dispatch_to=intval($dispatch_to);
  if($admin_id==0 || $orders_id==0 || $orders_status_id==0){
    return false;
  }
  $db->query("INSERT INTO orders_history (admin_id,orders_id,orders_status_id,dispatch_to) VALUES ($admin_id,$orders_id,$orders_status_id,$dispatch_to)");
  return true;
}
function insert_driver_db($ID,$dID){
  global $db;
  $query_raw=   $db->query("select orders_admin_id,orders_id,customers_name,customers_street_address,customers_city, customers_postcode,customers_state,customers_telephone from orders where orders_id ='".$ID."'")->fetchAll(PDO::FETCH_ASSOC);;
  if(!empty($query_raw)){          
    foreach ($query_raw as $key => $fields) {
      $customer_info_array = array( 'orders_id' => $fields['orders_id'],
        'customers_name' => $fields['customers_name'],
                       'customers_street_address' => $fields['customers_street_address'],
         'customers_city' => $fields['customers_city'],
         'customers_postcode' => $fields['customers_postcode'],
         'customers_state' => $fields['customers_state'],
          'orders_admin_id' => $fields['orders_admin_id'],
         'customers_telephone' => $fields['customers_telephone']
      );
    }
  }
  if($customer_info_array['orders_admin_id']!=0){
    send_text_update($customer_info_array['orders_admin_id'],'Order #'.$ID.' has been canceled');
  }
  $db->query("update driver_delivery_info set decline = '1' where order_id = '".$ID."'");
  $customer_telephone = '';//$customer_info_array['customers_telephone'];
  $customer_name =  '';//zm_sanitize_string($customer_info_array['customers_name']);
  $customer_address = ''; //$customer_info_array['customers_street_address']." ".$customer_info_array['customers_city']." ". $customer_info_array['customers_state']." ".$customer_info_array['customers_postcode'];
  $customer_address ='';//zm_sanitize_string($customer_address);
  $db->query("insert into driver_delivery_info (order_id,admin_id,customer_name,customer_address,order_status,customer_telephone)
      values('".$ID."','".$dID."','".$customer_name."','".$customer_address."','0','".$customer_telephone."')");
  $db->query("update orders_status_history set orders_status_id='3' where orders_status_id in('5','7','8','10') and orders_id ='".$ID."'");
  $db->query("update admin set last_modified = now(), admin_status = '0' where admin_id = '" . $dID . "'");
  $db->query('insert into orders_status_history (orders_id,orders_status_id,date_added,updated_by,comments) values ("'.$ID.'","3",now(),"'.get_admin_name(1).'","to '.get_admin_name($dID).'")');   
  $db->query("update orders set orders_admin_id=$dID, orders_status='3', last_modified = now() where orders_id= $ID");  
}
function send_text_update($id,$message){
  global $db;
  writeRequestResponseLog('send_text_update');
  $message= str_replace('number','#',$message);
  if($id){
  // if($id<10000){
  //     $email_sql = $db->query('select enable_sms,admin_id,admin_phone, admin_phone_extension from admin where admin_id ="'.$id.'"')->fetch(PDO::FETCH_ASSOC);
  //     $email = $email_sql['admin_phone'].$email_sql['admin_phone_extension'];
  // }else{
      $email_sql = $db->query('select enable_sms,admin_id,admin_phone, admin_phone_extension from admin where admin_id =(select admin_id from driver_delivery_info as d inner join orders as o on d.order_id = o.orders_id  where orders_id="'.$id.'" and d.order_status !=1 and decline !=1)')->fetch(PDO::FETCH_ASSOC);
      $email = $email_sql['admin_phone'].$email_sql['admin_phone_extension'];
  //}
  $aid = $email_sql['admin_id'];
  driverAppNotify($aid,$message,'system');
    if($email_sql['enable_sms']==0){
        return;
    }
  if($email){
      // if($_SESSION['backup_config']['text']==1){
      $sms_to= $email_sql['admin_phone']; //preg_replace("/[^0-9]/","",$email);
      $sms_message='System- '.$message;
      smsSinchMsg('+1'.$sms_to,$sms_message);
      writeRequestResponseLog('mail -'.$message);
  }
  }
}
function driverAppNotify($admin_id,$message,$type = 'dispatch'){
  $admin_id = intval($admin_id);
  if($admin_id < 1){
    return;
  }
  $send =  json_encode(array('key' => 'notify','params'=>array('admin_id'=>$admin_id,'message'=>$message,'type'=>$type)));
  $ch = curl_init(SITE_FRONT_URL.':3335/dispatch');
  curl_setopt($ch,CURLOPT_POST, 1);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$send);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_exec($ch);
  writeRequestResponseLog('notify -'.$message);
  return;
}
function get_admin_name($id){
  global $db;
  $info = $db->query('select admin_display_name from admin where admin_id ="'.$id.'"')->fetch(PDO::FETCH_ASSOC);
  return $info['admin_display_name'];
}
function sendDriverAppNewOrder($orders_id,$admin_id){
  $orders_id = intval($orders_id);
  $admin_id = intval($admin_id);
  if($orders_id < 1){
    return;
  }
  if($admin_id < 1){
    return;
  }
  $send =  json_encode(array('key' => 'new_order','params'=>array('admin_id'=>$admin_id,'orders_id'=>$orders_id)));
  $ch = curl_init(SITE_FRONT_URL.':3335/dispatch');
  curl_setopt($ch,CURLOPT_POST, 1);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$send);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_exec($ch);
  writeRequestResponseLog('app new order notify -');
  return;
}
function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);
  if ($unit == "K") { //Kilometers
      return ($miles * 1.609344);
  } else if ($unit == "N") { //Nautical Miles
      return ($miles * 0.8684);
  } else { //Miles
      return $miles;
  }
}

/* 
  * 1. Initiate auto call to restaurant for orders that are in driver accepted status 5 and last_modififed within 10 min of current time
*/
if(isset($_GET['type']) && $_GET['type']=='call_restaurant_order'){
 // global $db;
  writeRequestResponseLog($_GET['type']);
  $current = date('Y-m-d H:i:s',strtotime("-45 seconds"));
  $lessFiveMin =date("Y-m-d H:i:s", strtotime("-5 minutes"));
  $orders = $db->query("SELECT orders_id,categories_id FROM orders WHERE 
      orders_status = '5' 
      AND last_modified >= '".$lessFiveMin ."'
      AND last_modified <= '".$current ."'      
      AND NOT EXISTS (SELECT * FROM orders_status_history WHERE orders_id = orders.orders_id AND orders_status_id = '4' )
    ")->fetchAll(PDO::FETCH_ASSOC);
  writeRequestResponseLog( $orders);
  foreach ($orders as $key => $order) {
    $category = $db->query("SELECT * FROM categories c, categories_description cd WHERE c.categories_id = '".$order['categories_id']."' AND cd.categories_id = c.categories_id")->fetch(PDO::FETCH_ASSOC); 
    writeRequestResponseLog( $category);
    if(substr((string)$category['send_method_code'], -1)==1){
    callNumber('+1'.$category['phone'],'hi this is food dudes, please accept order number '.$order['orders_id'].' on your device, thank you');
    logged($order['orders_id']); //Create Sinch Auto Call Logs
    }
  }
}
/* 
  * 2. Initiate auto call to restaurant for pickup order if order table column pickup equals 1 and the order status is not in 4 or 13 and must be current date within 10 min of current time
*/
if(isset($_GET['type']) && $_GET['type']=='call_restaurant_pickup'){
  writeRequestResponseLog($_GET['type']);
  $current = date('Y-m-d H:i:s',strtotime("-45 seconds"));
  $lessFiveMin =date("Y-m-d H:i:s", strtotime("-5 minutes"));
  $orders = $db->query("SELECT orders_id,categories_id FROM orders WHERE 
      orders_status = '2'
      AND pickup_order = '1' 
      AND last_modified >= '".$lessFiveMin ."'
      AND last_modified <= '".$current ."'      
    ")->fetchAll(PDO::FETCH_ASSOC);
  writeRequestResponseLog($orders);
  foreach ($orders as $key => $order) {
    $category = $db->query("SELECT * FROM categories c, categories_description cd WHERE c.categories_id = '".$order['categories_id']."' AND cd.categories_id = c.categories_id")->fetch(PDO::FETCH_ASSOC); 
    writeRequestResponseLog($category);
    if(substr((string)$category['send_method_code'], -1)==1){
      callNumber('+1'.$category['phone'],'hi this is food dudes, please accept order number '.$order['orders_id'].' on your device, thank you');
      logged($order['orders_id']); //Create Sinch Auto Call Logs 
    }
  }
}
/*
  * calling function
*/
function callNumber($phone_number='+13203106216',$message='Hello this is food dudes, your device is currently offline, Please make sure the device is powered on, and has network connectivity, Thank you')
{
  writeRequestResponseLog('calling-'.$phone_number);
    $key = "558c03ac-9bdd-4241-a0ea-750113f6385c";
    $secret = "2x/yUy5SJ0eyhZ6/n76C1A==";
    $where_to_send['type']="number";
    $where_to_send['endpoint']=$phone_number;
    $info_send['destination']=$where_to_send;
    $info_send['cli']="+18722289704";
    $info_send['domain']="pstn";
    $info_send['text']=$message;
    $top_send['method']="ttsCallout";
    $top_send['ttsCallout']=$info_send;
    $body = json_encode($top_send);
    $timestamp = date("c");
    $path                  = "/v1/callouts";
    $content_type          = "application/json";
    $canonicalized_headers = "x-timestamp:".$timestamp;
    $content_md5 = base64_encode( md5( utf8_encode($body), true ));
    $string_to_sign =
      "POST\n".
      $content_md5."\n".
      $content_type."\n".
      $canonicalized_headers."\n".
      $path;
    $signature = base64_encode(hash_hmac("sha256", utf8_encode($string_to_sign), base64_decode($secret), true));
    $authorization = "Application " . $key . ":" . $signature;
    //Curl to do the request to the server
    $service_url = 'https://callingapi.sinch.com'.$path;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'content-type: '.$content_type,
      'x-timestamp:' . $timestamp,
      'authorization:' . $authorization
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $curl_response = curl_exec($curl);
    if (curl_errno($curl)) {
      //return false;
    } else {
      //echo $curl_response.'<br>';
      //return true;
    }
    curl_close($curl);
}
function smsSinchMsg($phone_number='+13203106216',$message='Hello this is food dudes,Thank you')
{
    $key = "558c03ac-9bdd-4241-a0ea-750113f6385c";
    $secret = "2x/yUy5SJ0eyhZ6/n76C1A==";
    $info_send['from']="+16123453007";    
    $info_send['message']=$message;
    $body = json_encode($info_send);
    $timestamp = date("c");
    $path                  = "/v1/sms/".$phone_number;
    $content_type          = "application/json";
    $canonicalized_headers = "x-timestamp:".$timestamp;
    $content_md5 = base64_encode( md5( utf8_encode($body), true ));
    $string_to_sign =
      "POST\n".
      $content_md5."\n".
      $content_type."\n".
      $canonicalized_headers."\n".
      $path;
    $signature = base64_encode(hash_hmac("sha256", utf8_encode($string_to_sign), base64_decode($secret), true));
    $authorization = "Application " . $key . ":" . $signature;
    //Curl to do the request to the server
    $service_url = 'https://messagingapi.sinch.com'.$path;
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'content-type: '.$content_type,
      'x-timestamp:' . $timestamp,
      'authorization:' . $authorization
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    /* complete within 5 seconds */
    curl_setopt($curl, CURLOPT_TIMEOUT, "5L");
    $curl_response = curl_exec($curl);
    if (curl_errno($curl)) {
      //return false;
    } else {
      //echo $curl_response.'<br>';
      //return true;
    }
    curl_close($curl);
}
/*
  * if a driver does not accept the order within 2 min reset order status to new (1)
*/
function resetOrder(){
  global $db;
  $driverStatusOrder = $db->query("SELECT orders_admin_id FROM orders WHERE 
            orders_status in (2,3,4,5,7) 
            AND last_modified > '".date('Y-m-d')." 00:00:00'
              AND last_modified < '".date('Y-m-d')." 23:59:00'
          ")->fetchAll(PDO::FETCH_ASSOC);
  foreach ($driverStatusOrder as $key => $value) {
    if($value['orders_admin_id']!=0){
      $db->query('update admin set admin_status = 0 where admin_id ="'.$value['orders_admin_id'].'"');
    }
  }
  $today = date('Y-m-d');
  $lastModify =date("Y-m-d H:i:s", strtotime("-90 seconds")); //ex. -2 minutes, -3 minutes
  $result = $db->query("SELECT last_modified,orders_id FROM orders WHERE 
      orders_status = '3' 
      AND date_deliver > '".$today." 00:00:00'
      AND date_deliver < '".$today." 23:59:00'
      AND last_modified <= '".$lastModify ."'
      AND 3 = (SELECT orders_status_id FROM `orders_history` WHERE `orders_history`.`orders_id` = orders.orders_id ORDER BY `orders_history`.`orders_history_id` DESC limit 1)  
      AND 3 = (SELECT orders_status_id FROM `orders_status_history` WHERE `orders_id` = orders.orders_id ORDER BY `orders_status_history`.`orders_status_history_id` DESC limit 1)
    ")->fetchAll(PDO::FETCH_ASSOC);
  $now = strtotime('now');
  foreach ($result as $key => $order) {
    $status_time =  strtotime($order['last_modified']);
    $difference = ($now - $status_time)/60; 
    $email_sql = $db->query('select enable_sms,admin_id,admin_phone, admin_phone_extension from admin where admin_id =(select admin_id from driver_delivery_info as d inner join orders as o on d.order_id = o.orders_id  where orders_id="'.$order['orders_id'].'" and d.order_status !=1 and decline !=1)')->fetch(PDO::FETCH_ASSOC);
    $smsTo = $email_sql['admin_phone'];
    $get_id = $db->query('select admin_id from driver_delivery_info where decline=0 and order_id="'.$order['orders_id'].'"')->fetch(PDO::FETCH_ASSOC);
    $ad_id=$get_id['admin_id'];
    $db->query('update driver_delivery_info set decline="1" where order_id="'.$order['orders_id'].'"');
    if($db->query('update orders_status_history set orders_status_id=1  where orders_id="'.$order['orders_id'].'" and orders_status_id =3')){
      if($db->query('update orders set orders_status = "1", last_modified=now(),updated_from_dispatched=1,orders_admin_id = 0, suggested_admin = 0 where orders_status = 3 AND orders_id ="'.$order['orders_id'].'"')) {
        updateOrdersTrue(9,$order['orders_id'],1);
        $driverHasOrder = $db->query("SELECT * FROM orders WHERE 
            orders_status in (2,3,4,5,7) AND orders_admin_id = '".$ad_id."'
            AND last_modified > '".date('Y-m-d')." 00:00:00'
              AND last_modified < '".date('Y-m-d')." 23:59:00'
          ")->fetch(PDO::FETCH_ASSOC);
        if(empty($driverHasOrder)){
          $db->query('update admin set admin_status =1 where admin_id ="'.$ad_id.'"');
        }
        $db->query('insert into orders_status_history (orders_id,orders_status_id,updated_by,comments,date_added) values ('.$order['orders_id'].',1,"MAT-CRON","Mins: '.$difference.'",now())');
        smsSinchMsg('+1'.$smsTo,'Order #'.$order['orders_id'].' has been timed out');
        writeRequestResponseLog('Order #'.$order['orders_id'].' has been timed out');
      } 
    }
  }
}
function updateOrdersTrue($admin_id,$orders_id,$orders_status_id,$dispatch_to=0){
  global $db;
  $admin_id=intval($admin_id);
  $orders_id=intval($orders_id);
  $orders_status_id=intval($orders_status_id);
  $dispatch_to=intval($dispatch_to);
  if($admin_id==0 || $orders_id==0 || $orders_status_id==0){
    return false;
  }
  $db->query("INSERT INTO orders_history (admin_id,orders_id,orders_status_id,dispatch_to) VALUES ($admin_id,$orders_id,$orders_status_id,$dispatch_to)");
  return true;
}
/**
  * also have future orders change to new status (1) when within 55 min of delivery time
*/
if(isset($_GET['type']) && $_GET['type']=='set_future_to_new'){
  global $db;
  writeRequestResponseLog($_GET['type']);
  $future = array();
  $now = strtotime('now');
  $future_sql = $db->query('select c.categories_id,date_deliver,orders_id,parent_id,order_total from orders as o inner join categories as c on c.categories_id = o.categories_id where orders_status=9')->fetchAll(PDO::FETCH_ASSOC);
  $tz_list = array();
  foreach ($future_sql as $key => $value) {
    $future[] = array(
      'orders_id' => $value['orders_id'],
      'date_deliver' => $value['date_deliver'],
      'parent_id' => $value['parent_id'],
      'order_total' => $value['order_total']
    );
  }
  foreach($future as $rr){
    $tz_list[]=$rr['parent_id'];
  }
  if(count($tz_list)>0){
    $sqff = 'select categories_id, timezone from categories_description where categories_id in ('.implode($tz_list,',').')';
    $tz_grap = $db->query($sqff)->fetchAll(PDO::FETCH_ASSOC);
    $tz_sort = array();
    foreach ($tz_grap as $key => $value) {
      foreach($future as &$ff){
        if($ff['parent_id'] === $value['categories_id']){
          $ff['timezone'] = $value['timezone'];
        }
      }
    }
  }
  $email_msg='';
  if(count($future)>0){
    for($t=0;$t<count($future);$t++){
      switch($future[$t]['timezone']){
         case 'mountain':
             $future[$t]['date_deliver'] = date('Y-m-d H:i:s',strtotime($future[$t]['date_deliver'])+3600);
         break;
         case 'eastern':
             $future[$t]['date_deliver'] = date('Y-m-d H:i:s',strtotime($future[$t]['date_deliver'])-3600);
         break;
         case 'western':
             $future[$t]['date_deliver'] = date('Y-m-d H:i:s',strtotime($future[$t]['date_deliver'])+(3600*2));
         break;
      }
      $future_time =  strtotime($future[$t]['date_deliver']);
      $future_difference = ($now-$future_time )/60;
      /* time condition start */
        $future_change_limit = 60; // this is default time (in minutes)
        if($future[$t]['order_total']<75){ 
          $future_change_limit = 50;
        }
        if($future[$t]['order_total']>=75){ 
          $future_change_limit = 60;
        }
      /* time condition end */
      writeRequestResponseLog(date('Y-m-d H:i:s',strtotime('now')).' future_change_limit '.$future_change_limit.' = future_difference '.$future_difference);
      $current = date("Y-m-d H:i:s", strtotime("+".$future_change_limit." minutes"));
      $delevery = date($future[$t]['date_deliver']);
      if($delevery<=$current){
        $output ='FUTURE '.$future[$t]['orders_id'].' DIFFERENCE:'.$future_difference.' LIMIT:'.$future_change_limit.' '.$future[$t]['date_deliver'].' '.$future_time;
        if($db->query('update orders set orders_status = 1,last_modified ="'.date('Y-m-d H:i:s',strtotime('now')).'",updated_from_future=1 where orders_id='.$future[$t]['orders_id'])){
          writeRequestResponseLog($output);
          updateOrdersTrue(9,$future[$t]['orders_id'],1);
          if($db->query('insert into orders_status_history (orders_id,orders_status_id,date_added,updated_by) values('.$future[$t]['orders_id'].',1,"'.date('Y-m-d H:i:s',strtotime('now')).'","MAT-CRON")')){}
        }
      }
    } 
  }
}
if(isset($_GET['type']) && $_GET['type']=='set_order_to_complete'){
  writeRequestResponseLog($_GET['type']);
  $lastModify =date("Y-m-d H:i:s", strtotime("-10 minutes")); //ex. -2 minutes, -3 minutes
  $db->query("UPDATE orders SET orders_status='13', last_modified = now() WHERE 
      orders_status = '4'
      AND pickup_order = '1' 
      AND last_modified <= '".$lastModify ."'");
}
if(isset($_GET['type']) && $_GET['type']=='set_place_zuppler_pickup_order'){
  global $db; 
  $today = date('Y-m-d');
  $sql ="SELECT orders_id, categories_id from orders WHERE 
      orders_status = '1'
      AND date_deliver > '".$today." 00:00:00'
      AND date_deliver < '".$today." 23:59:00'
      AND online_order = '0' 
      AND pickup_order = '1'";
  $orders= $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  foreach($orders as $key => $order){
      $db->query("UPDATE orders SET orders_status='2', last_modified = now() WHERE orders_id = '".$order['orders_id']."'");
      $db->query('insert into orders_status_history (orders_id,orders_status_id,date_added,updated_by) values  ('.$order['orders_id'].',2,now(),"'.get_admin_name(1).'")');
      updateOrdersTrueHistory('1',$order['orders_id'],2);
      sendPushSetPlaceZupplerPickupOrder($order['orders_id'], $order['categories_id'], $push=array('key'=>'new_order','params'=>$order['orders_id']), $db);
    }
  }
function sendPushSetPlaceZupplerPickupOrder($orders_id, $category_id, $push=array('key'=>'syncOrder','params'=>true), $db){
  $check_category_query1 = "SELECT * FROM categories_description WHERE categories_id = ".$category_id;
  $category_check = $db->query($check_category_query1)->fetchAll(PDO::FETCH_ASSOC);
  if(!empty($category_check) && !empty($category_check[0]['send_method_code']) && $category_check[0]['send_method_code'][4] == 1){
      $push_sql="SELECT device_id FROM push_info AS p inner join orders AS o ON o.categories_id = p.categories_id WHERE o.orders_id = $orders_id AND last_info_json!='loggedoff'";
      $push_infotmp= $db->query($push_sql)->fetchAll(PDO::FETCH_ASSOC);
    if(!$push_infotmp){
        return false;
      }
      $push_infotmp=array_values($push_infotmp);
      $push_info=[];
      foreach($push_infotmp as $innekey => $devicevalue){
          $push_info[] = $devicevalue['device_id'];
      }
      $apiKey = '579fe3f9ac99145d7bf6a548878bdc97e8fa798b8684aaaf52b97333821c2e77'; // Dev
      //$apiKey = 'fcf2a3c898f6d794d66da23d3409f0e0c22f8e493fba3f45b45a4a7f60f86d0c'; //com.food_dude
      //$apiKey = '177265edf4083eb47be5941dea1ebf0a860124a40176834243fc848f15f623db'; //staging_restaurant
      //$apiKey = 'c41a0766e45072a2897720ddbb13fe877e28847f7f958621ce4f46df35d80b0a'; // Live
      $url = 'https://api.pushy.me/push?api_key=' . $apiKey;
      $post = array(
        'registration_ids'  => $push_info,
        'data'              => array(
            'json_link'=>json_encode($push),
              "title" => SITE_NAME, // Notification title
              "message" => "Hello, Please accept order number ".$orders_id, // Notification body text
              "url" => SITE_FRONT_URL // Opens when clicked
            ),
          "notification"=> array(
              "body"=> "Hello, Please accept order number ".$orders_id,
              "badge"=> 1,
              "sound"=> "ping.aiff"
            ),
            'time_to_live' => 1800
      );
      $headers = array('Content-Type: application/json');
      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_URL, $url );
      curl_setopt( $ch, CURLOPT_POST, true );
      curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
      $result = curl_exec( $ch );
      if(curl_errno($ch)){
        return false; 
      }
      curl_close( $ch );
  }
  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_URL, SITE_FRONT_URL.'/zupler_order_mail.php?order_id='.$orders_id );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  $result = curl_exec( $ch );
  curl_close( $ch );
  return true;
}
function sendPush($orders_id,$push=array('key'=>'syncOrder','params'=>true)){
  global $db;
  $push_sql="SELECT device_id FROM push_info AS p inner join orders AS o ON o.categories_id = p.categories_id WHERE o.orders_id = $orders_id AND last_info_json!='loggedoff'";
  $push_info= $db->query($push_sql)->fetchAll(PDO::FETCH_ASSOC);
  if(!$push_info){
    return false;
  }
  $push_info=array_values($push_info);
  //echo '<pre>';
  //print_r($push_info);
  $push_infonew=array();
  foreach($push_info as $value){
    $push_infonew[]=$value['device_id'];
  }
  //$apiKey = '579fe3f9ac99145d7bf6a548878bdc97e8fa798b8684aaaf52b97333821c2e77'; //Live server
  //$apiKey = 'bb3cc6dfc39536504a013208810eb2c2b774cc39657c2b114805ae827e1e29db'; //Test server
  //$apiKey = 'fcf2a3c898f6d794d66da23d3409f0e0c22f8e493fba3f45b45a4a7f60f86d0c'; //com.food_dude
  //$apiKey = '177265edf4083eb47be5941dea1ebf0a860124a40176834243fc848f15f623db'; //staging_restaurant
  $apiKey = 'c41a0766e45072a2897720ddbb13fe877e28847f7f958621ce4f46df35d80b0a'; // Delivery hop
  $url = 'https://api.pushy.me/push?api_key=' . $apiKey;
  $post = array(
    'registration_ids'  => $push_infonew,
    'data'              => array(
         'json_link'=>json_encode($push),
          "title" => "Fooddudes Delivery", // Notification title
          "message" => "Hello, Please accept order number ".$orders_id, // Notification body text
          "url" => SITE_FRONT_URL // Opens when clicked
        ),
      "notification"=> array(
          "body"=> "Hello, Please accept order number ".$orders_id,
          "badge"=> 1,
          "sound"=> "ping.aiff"
        ),
        'time_to_live' => 1800
  );
  $headers = array
  (
    'Content-Type: application/json'
  );
  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_POST, true );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
  $result = curl_exec( $ch );
  if ( curl_errno( $ch ) )
  {
    //echo curl_error( $ch );
    return false; 
  }
  curl_close( $ch );
  //print_r($result); 
  return true;
}
if(isset($_GET['type']) && $_GET['type']=='set_zuppler_order_to_complete'){  
  $lastModify =date("Y-m-d H:i:s", strtotime("-1 minutes")); //ex. -2 minutes, -3 minutes  
  $sql ="SELECT orders_id  from orders WHERE 
      orders_status = '13'
      AND pickup_order = '1' 
      AND zuppler_id !='0'
      AND last_modified >= '".$lastModify ."'";
  $orders= $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  foreach ($orders as $key => $order) {    
    zupplerOrderUpdateStatus($order['orders_id'],13);
  }
}
function zupplerOrderUpdateStatus($order_id=0,$order_status=0){
  global $db;
  $order_s = 'SELECT zuppler_order_uid, payment_module_code, shipping_method FROM orders WHERE orders_id =' . (int)$order_id;
  $order_data =  $db->query($order_s)->fetch(PDO::FETCH_ASSOC);     
  if(!empty($order_data['zuppler_order_uid'])){
    $url = 'https://posaas.zuppler.com/webhooks/update_status';
      $post = array(
        'zuppler_order_uid'  => $order_data['zuppler_order_uid'],
        'order_status'  => (int)$order_status
      );
      $headers = array(
        "authorization: Basic ".base64_encode("9ZzTdUmesPcL6:K#9kwswgX&zENWgr0$7CLhW27"),
        "cache-control: no-cache",
        "Content-Type: application/json"
      );
      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_URL, $url );
      curl_setopt( $ch, CURLOPT_POST, true );
      curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
      $result = curl_exec( $ch );
      if ( curl_errno( $ch ) )
      {        
        $zupplerError = curl_error( $ch ); 
        eo_log('Zuppler order update error: '.$zupplerError);       
      }else{
        $me = 1;
        $sql = "INSERT INTO notes (order_id,note_type,note,made_by,admin_id,timestamp) values('".(int)$order_id."','5','Zuppler Response:".$result."','".$me."','".$me."',now())";          
        $db->query($sql);      
      }
      curl_close( $ch );          
  }
}
function writeRequestResponseLog($data)    {        
    // $apiLog = fopen("cache/API-Log.txt", "a+");    
    // $text = "\n\n\n**************************************************************************************************\n";
    // $text .= '"Date":'.date('Y-m-d H:i:s')."\n";            
    // $text .= json_encode($data);     
    // //$text .= $data;        
    // fwrite($apiLog, $text);   
    // fclose($apiLog);    
}

/* Sinch Auto Call Logs - Start*/
function logged($orders_id){
    global $db;

    $orders_status_ = $db->query("SELECT orders_status_id, date_added, updated_by, tracking_time FROM orders_status_history WHERE orders_id = '$orders_id' ORDER BY tracking_time DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    $orders_status_json  = "cronjobs.php ";
    $orders_status_json .= !empty($orders_status_)?json_encode($orders_status_):'';
    
    $db->query("INSERT INTO auto_call_log (orders_id, orders_status_history_json) VALUES ($orders_id, '$orders_status_json')"); 
}
/* Sinch Auto Call Logs - End*/

/* Update Restaurant Status After 24 Hours*/
if(isset($_GET['type']) && $_GET['type']=='set_restaurant_app_status'){
    global $db;
    //$db->query("UPDATE categories set categories_status=1, categories_status_app=1 Where categories_status_app='0'");s
    $res = $db->query("SELECT * FROM categories WHERE categories_status_app='0'")->fetchAll(PDO::FETCH_ASSOC);

    foreach($res as $key => $cat){
        $postData = array(
          'update_type' => 'restaurant',
          'restaurant_id' => $cat['categories_id'],
          'restaurant_status' => true
        );
        zuppler_update_restaurant_status($postData);
        $db->query("UPDATE categories set categories_status_app='1', categories_status='1' Where categories_status_app='0' AND categories_id='".$cat['categories_id']."'");
    }
}
/* Update Restaurant Status On Zuppler in 24 Hours*/
function zuppler_update_restaurant_status($postData=array()){
  //$url = 'http://posaas.zuppler.com/webhooks/sync'; //Live
  $url = "http://posaas.biznettechnologies.com/webhooks/sync"; //dev  
  $post = $postData;  
  $headers = array( 
    //"authorization: Basic ".base64_encode("9ZzTdUmesPcL6:K#9kwswgX&zENWgr0$7CLhW27"), // Live
    'Authorization: Basic '.base64_encode("Zuppler:ZupplerSecure@2019"), // Local
    "cache-control: no-cache",  
    "Content-Type: application/json"  
  );

  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_POST, true );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
  $result = curl_exec( $ch );

  if(curl_errno($ch)){
      $zupplerError = curl_error( $ch );
  }
  curl_close( $ch );
}
/* Update Restaurant Status On Zuppler*/