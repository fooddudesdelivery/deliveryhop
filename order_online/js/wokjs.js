 var CreditCard = function(){
		  'use strict';
		  var _super = {};
		  var _this = this;
		  
		  _this.setSuper=function(extend_base){
			  _super=extend_base;
		  };
		  
		  _this.initilize=function(){
			  if(typeof braintree === 'undefined') {
				 setTimeout(function(){
					var script='';
					script=document.createElement('script');
					script.type='text/javascript';
					script.src='https://js.braintreegateway.com/js/beta/braintree-hosted-fields-beta.18.js';
					script.async='true';	
					document.getElementsByTagName('head')[0].appendChild(script);
					setTimeout(_this.beginSetup,75);	
					console.log('braintree injected'); 
				 },1);
			  }
			
		  };
		  _this.beginSetup=function(){

			  if(typeof braintree === 'undefined') {
				  console.log('no braintree, uncaught');
				  setTimeout(_this.beginSetup,100);
				  //_super.addError(DEFINE.JS_ERROR_NO_BRAINTREE);
				  return false;
			  }

		
			   braintree.setup(DEFINE.BRAINTREE_JS_KEY, "custom", {
				  id: 'gwok',
				  onPaymentMethodReceived: _this.receivePaymentNonce,
				  onReady: function(data){
					  console.log('braintree ready');
					  return true;
				  },
				  onError: function(data){
					  console.log(data);
					  alert(data.message);
					  //posssibly check these errors
					  //_super.Footer.changeFooter('place_order');
					  //_super.addError(data.message);
					  return true;
				  },
				  hostedFields: {
					number: {
					  selector: "#bcredit",
					  placeholder: "Credit Card Number"
					},
					expirationMonth: {
					  selector: "#bmonth",
					  placeholder: "Month"
					},
					expirationYear: {
					  selector: "#byear",
					  placeholder: "Year"
					},
					cvv: {
					  selector: "#bcvv",
					  placeholder: "On the back"
					},
					onFieldEvent: _this.onEvent,
					styles:_this.styles()
					
				  }
				});
				return true;
		  };
		  
		  
		//  _this.receivePaymentNonce=function(data){
//			  console.log(data);
//			  if(data.nonce){
//				  _super.Link.braintree_nonce=data.nonce;
//				  _super.sendLink(DEFINE.KEY_PLACEORDER);
//				  return true;
//			  }else{
//				  _super.addError('add error here');
//				  return false;
//			  }
//			  
//		  };
		  
	  
		  _this.receivePaymentNonce=function(data){
			  //if($('#type').val()=='Credit'){
				  $('#main').append('<input type="hidden" name="payment_method_nonce" value="'+data.nonce+'">');
			  //}
			  $('#main_submit').click();

		  };
		  _this.onEvent = function(event){
			  if (event.type === "focus") {
	  
			  } else if (event.type === "blur") {
	  
			  } else if (event.type === "fieldStateChange") {
				console.log(event.isValid); // true|false
				if (event.card) {
				  console.log(event.card.type);
				  // visa|master-card|american-express|diners-club|discover|jcb|unionpay|maestro
				}
			  }	
			  return true;	
		  };
		  
		  
		  _this.styles=function(){
			  return {
				  // Style all elements
				  "input": {
					"font-size": "14pt",
					"color": "#3A3A3A"
				  },
				  // Styling element state
				  ":focus": {
					"color": "#3A3A3A",
					"border-color": "red",
					"box-shadow": "0 0 0 red inset, 0 0 8px red"
				  },
				  ".valid": {
					"color": "green"
				  },
				  ".invalid": {
					"color": "red"
				  },
				  // Note that these apply to the iframe, not the root window.
				  "@media screen and (max-width: 700px)": {
					"input": {
					  "font-size": "14pt"
					}
				  }
				};//end of style
		  };
		  
		  
	  // end of credit card	
	  };