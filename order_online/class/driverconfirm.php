<?php
	require(__DIR__."/../../aAsd23fadfAd2565Hccxz/includes/configure.php");
//}else{
	require(__DIR__.'/../configure.php');

require(__DIR__.'/../public_configure.php');
require(__DIR__.'/../vendor/autoload.php');
class newCreditSubmit{
	private $braintreeinfo=array();
	
		function __construct(){
		ini_set('display_errors',false);
		ini_set('memory_limit', '-1');
		ini_set("log_errors", 1);
		ini_set("error_log", "logs/php_error.txt");
		date_default_timezone_set('America/Chicago');
		error_reporting(E_ALL);

		try {
			$this->db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			$this->addError("Connection failed: " . $e->getMessage());
		}
		
		Braintree_Configuration::environment(BRAINTREE_ENVIROMENT);
		Braintree_Configuration::merchantId(BRAINTREE_MERCHANT_ID);
		Braintree_Configuration::publicKey(BRAINTREE_PUBLIC_KEY);
		Braintree_Configuration::privateKey(BRAINTREE_PRIVATE_KEY);
	}
	
	public function shittyerror($error_message){
		$error_m = date('m-d-Y g:i:s').' -'.$_SERVER['REMOTE_ADDR'].'-> '.$error_message."\n";
			error_log($error_m,3,"logs/class_error_log.txt");	
	}
public function completeOrder($orders_id){
		$orders_id=intval($orders_id);
		if($orders_id==0){
			$this->shittyerror('error bad catgories id');
			return false;
		}
		$braintree_info = $this->db->query("
		SELECT ot.value, bi.orders_id, transaction_id , credit_card_token , authorization_amount , settlement_amount , status , timestamp
		FROM braintree_info AS bi
		INNER JOIN orders_total AS ot ON ot.orders_id = bi.orders_id
		WHERE class = 'ot_total'
		AND bi.orders_id = $orders_id
		LIMIT 0 , 1")->fetch(PDO::FETCH_ASSOC);

		if(
		  !isset($braintree_info) ||
		  !isset($braintree_info['credit_card_token']) || 
		  !isset($braintree_info['transaction_id']) || 
		  !isset($braintree_info['authorization_amount']) || 
		  !isset($braintree_info['status'])){
			  $this->shittyerror('error does have values');
			  return false;
		}
		
		if($braintree_info['status']==='submitted_for_settle'){

			 $this->shittyerror('error already submitted for settlement');
			return true;
		}
		$braintree_info['value'] = round($braintree_info['value'],2);
		
		$this->braintreeinfo=$braintree_info;
		if(floatval($this->braintreeinfo['value'])>floatval($this->braintreeinfo['authorization_amount'])){
			if($this->initiateBackupProtocol()){
				return true;
			}else{
				return false;
			}
		}else{
			if($this->submitForSettlement()){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function initiateBackupProtocol(){
		$reauth = $this->reAuthorizeTransaction();
		if($reauth){
			if($this->voidTransaction()){
				return true;	
			}else{
				return false;	
			}
		}else{
			if($this->submitForSettlement()){
				return true;
			}else{
				return false;
			}
		}
	}
	
	
	protected function reAuthorizeTransaction(){
		$result = Braintree_Transaction::sale([
			'amount' => $this->braintreeinfo['value'],
			'paymentMethodToken' => $this->braintreeinfo['credit_card_token'],
			'options' => [
			  'submitForSettlement' => true
			],
			'descriptor' => $this->Config['braintree_descriptor']
		]);
		//
		if(!$result->success){
			if($result->transaction){
				if($result->transaction->status=='gateway_rejected'){
					 $this->shittyerror('gateway_rejected');
					//$this->addError($result->transaction->gatewayRejectionReason); 
					return false;
				}
				if($result->transaction->status=='processor_declined'){
					 $this->shittyerror('processor_declined');
					//$this->addError($result->message); 
					return false;
				}
			}else{
				//$this->addError($result->message); 
				return false;
			}
		}

		if($this->finalize($result)){
			return true;
		}else{
			return false;
		}
			
	}
	
	
	public function submitForSettlement(){
		$result = Braintree_Transaction::submitForSettlement($this->braintreeinfo['transaction_id'],$this->braintreeinfo['value']);
		if ($result->success==0) {
			if ($result->errors->deepSize() > 0) {
				 $this->shittyerror($result->errors->deepAll());
				return false;
			} else {

				 $this->shittyerror($result->errors->deepAll());
				return false;
			}
		}
		if($this->finalize($result)){
			return true;
		}else{
			return false;
		}
	}
	
	public function finalize($result){
		$update=$this->db->query('
		UPDATE braintree_info SET 
		settlement_amount='.floatval($result->transaction->amount).',
		status="'.$result->transaction->status.'"
		WHERE orders_id="'.$this->braintreeinfo['orders_id'].'"');
		if(!$update){
			 $this->shittyerror('error with finalization');
	
			
			return false;
		}else{
			return true;	
		}
	}
	
	public function voidTransaction(){
		$result = Braintree_Transaction::void($this->braintreeinfo['transaction_id']);	
		if ($result->success==0) {
			if ($result->errors->deepSize() > 0) {
				$this->shittyerror($result->errors->deepAll());
				return false;
			} else {
				$this->shittyerror($result->errors->deepAll());
				return false;
			}
		}else{
			return true;	
		}
	}	
	
	
}


?>