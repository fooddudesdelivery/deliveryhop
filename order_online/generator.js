
var Generator = function (){

	'use strict';

	var _this = this;



	_this.generate = function(){

		setTimeout(function(){

			window.should_close=0;

			if (typeof $ === 'undefined') {

				console.log('No jQuery');

				var script='';

				script=document.createElement('script');

				script.type='text/javascript';

				script.src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js';

				document.getElementsByTagName('head')[0].appendChild(script);

				_this.genJqueryCheck();

			}else{

				//console.log('Has jQuery');

				_this.appendToBody();

			}

			return true;

		},500);

	};

	

	_this.genJqueryCheck = function(){

		//console.log('jQuery Check');

		var time = setTimeout(function(){

			if (typeof $ !== 'undefined') {

				_this.appendToBody();

				clearTimeout(time);

				return true;

			}else{

				_this.genJqueryCheck();

				return false;

			}

		},111);

	};

	

	

	_this.appendToBody = function(){

		$(document).ready(function() {
			if(window.location.href.search('http://woodennickelsportsbar.com/')!==-1){
				
                
            }

			var deliverhopsbtn =$('#deliverhops-order-btn');
			
			console.log(window.location.href );

			if($(window).width()<900 && window.location.href=='http://www.starofindiamn.com/'){

				$('#deliverhops-order-btn').css({'border': '3px solid white','background-color': '#c52109','text-shadow': '0 2px 0 black'});	

			}

			var data_key = deliverhopsbtn.attr('data-key');

			var data_instore = deliverhopsbtn.attr('data-instore');

			var data_invoice = deliverhopsbtn.attr('data-invoice');

			var addons='';

			if(data_instore){

				addons += '&instore_ordering=1';

			}

			if(data_invoice){

				addons += '&invoice_payment=1';

			}

			addons+='&purl='+window.location.href+'&erfrischen='+new Date().getTime();

			window.main_url = 'https://deliverhop.app/order_online/future_index.php?key='+data_key+addons;

	

			var frame= '<div id="fdpackage" style="display:none"><iframe  id="ifood" name="ifood" onload="generator.attach()" seamless src="'+window.main_url+'" '+

'style="top:0px;left:0px;height:100%;min-height:100%;border:0px;background-color:transparent;opacity:1;z-index:9999;position:absolute;overflow-y:hidden;" '+

' width="100%"></iframe><div id="deliverhop_backdrop" style="position:absolute;background-color:black;opacity:.8;width:100%;height:2000px;z-index:9000; '+

' top: 0;left: 0;right: 0;bottom: 0;"></div></div>';

	

		

			

			

           

			

			

			if($('#deliverhops-order-btn').attr('data-auto-open')==='true'){

				_this.showOnlineOrder(frame);

			}

			$(document).on('click','#deliverhops-order-btn',function(){

				_this.showOnlineOrder(frame);

			});



			

			return true;

        });

	};



	_this.showOnlineOrder=function(frame){

		

			$('body,.body,html').css('overflow','hidden');

		

			$('head').append('<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0;'+ 

			'user-scalable=no;target-densityDpi=device-dpi" />');

			$('body').append(frame);

			$('#fdpackage').show();

		return true;

	};

	

	

	_this.attach = function(){

		//console.log('iframe attched');

		var frame = document.getElementById('ifood').contentWindow;

		frame.postMessage({url:window.location.href,key:'begin'}, window.main_url);

		 window.receiveMessage=function(event)

		{

			//console.log('got event at proxy');

			

		  // Do we trust the sender of this message?  (might be

		  // different from what we originally opened, for example).

		  //if (event.origin !== 'https://deliverhop.app'){

			//  return;

		  //}

		  if(event.data && event.data.key){

			  switch(event.data.key){

				  case 'close':

					  location.reload();

				  break;

			  }

		  }

			

		  // event.source is popup

		  // event.data is "hi there yourself!  the secret response is: rheeeeet!"

		};

		window.addEventListener("message", window.receiveMessage, false);

		//$('#deliverhops-order-btn').show();

		//if(!window.should_close || window.should_close===0){

//			window.should_close=1;

//		}else if(window.should_close===1){

//			location.reload();

//		}

	};

	

};



var generator={};

generator = new Generator();

generator.generate();