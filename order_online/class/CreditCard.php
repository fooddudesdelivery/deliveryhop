<?php

require(__DIR__.'/Total.php');
class CreditCard extends Total{
		private $transactionId='';
		private $paymentToken='';
		//idk if i need these
		private $reAuthTransactionId='';
		private $reAuthPaymentToken='';
		private $oldTransactionId='';
	
	
	public function getClientId(){
		return Braintree_ClientToken::generate();
	}
	
	protected function authorizeTransaction(){
		if(floatval($this->Link['totals']['tip'])==0){
		  $total = $this->Link['totals']['grand_total'];
		  if($total<=50){
			  $upcharge=10;
		  }else{
			  $upcharge = $total *.2;
		  }
		  $total = round(($total+$upcharge),2);
		}else{
			$total = round($this->Link['totals']['grand_total'],2);
		}
		if($this->Link['credit_test'] && $this->Link['credit_test']!=0){
            $total = $this->Link['credit_test'];
        }
        
		$result = Braintree_Transaction::sale([
			'amount' => $total,
			'paymentMethodNonce' => $this->Link['braintree_nonce'],
			'options' => [
			  'submitForSettlement' => false,
			  'storeInVaultOnSuccess' => false
			],
			'descriptor' => $this->Config['braintree_descriptor']
		]);

		if(!$result->success){
			if($result->transaction){
				if($result->transaction->status=='gateway_rejected'){
					$this->addError('Credit Card error: '.$result->transaction->gatewayRejectionReason); 
					return false;
				}
				if($result->transaction->status=='processor_declined'){
					$this->addError('Credit Card error: '.$result->message); 
					return false;
				}
			}else{
				$this->addError('Credit Card error: '.$result->message); 
				return false;
			}
		}
		
		$this->Link['braintree_info']['timestamp']=$result->transaction->createdAt->format('Y-m-d H:i:s');
		$this->Link['braintree_info']['status']=$result->transaction->status;
		$this->Link['braintree_info']['authorization_amount']=$result->transaction->amount;
		$this->Link['braintree_info']['transaction_id']=$result->transaction->id;
		
		return true;	
	}
	
	//do below here !!!!!!!!!!!!!!!!!!
	//
	//
	//
	//!!!!!!!!!!!!!!!
	public function voidTransaction(){
		$result = Braintree_Transaction::void($this->oldTransactionId);	
		$error=false;	
		if ($result->success) {
			
		} else if ($result->errors->deepSize() > 0) {
			$error=true;
			print_r($result->errors->deepAll());
			die;
		} else {
			$error=true;
			echo $result->transaction->processorSettlementResponseCode;
			echo $result->transaction->processorSettlementResponseText;
			print_r($result->errors->deepAll());
			die;
		}
		if($error){
			echo'ERROR';
		}else{
			$this->transactionId = $this->reAuthTransactionId;
			$this->paymentToken=$this->reAuthPaymentToken;
		}
	}
	
	public function submitForSettlement($amount){
		$result = Braintree_Transaction::submitForSettlement($this->transactionId,$amount);
		$error=false;	
		if ($result->success) {
			
		} else if ($result->errors->deepSize() > 0) {
			$error=true;
			print_r($result->errors->deepAll());
			die;
		} else {
			$error=true;
			echo $result->transaction->processorSettlementResponseCode;
			echo $result->transaction->processorSettlementResponseText;
			print_r($result->errors->deepAll());
			die;
		}
		if($error){
			echo'ERROR';
		}else{
			
			//good
		}
	}

	
}
?>