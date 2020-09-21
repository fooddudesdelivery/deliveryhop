

	

	

	//

	///

	///

	/// this is the base class

	///

	///

	//

  var Fooddudesdelivery = function(){

	  'use strict';

	  var _this = this;

	  

	  //classes

	  _this.Navigation={};

	  _this.GoogleProcess={};

	  _this.CreditCard={};

	  _this.Display={};

	  _this.Cart={};

	  _this.Footer={};

	  

	  

	  //default link

	  _this.start_link={};

	  

	  //main data model

	  _this.Link={};

		

	  //main configuration  

	  _this.Config={};

		

  

  

		_this.addError = function(params){

		

			document.body.style.cursor='default';

		   $('#'+DEFINE.ID_GOOGLE_ADDRESS_SEARCH_TEXT).val(''); 

			var time_to_close=6000;

			if(params==DEFINE.JS_ERROR_NO_OPEN_MENUS){

				time_to_close=6000;

			}

			

			_this.Navigation.pageMod('#'+$('.main-page.show_page').attr('id'));

			$('.'+DEFINE.ID_ERROR_MESSAGE).html(params+'<span style="float:right;margin-right:20px">x</span>').show();

			setTimeout(function(){

				

				$('.'+DEFINE.ID_ERROR_MESSAGE).hide();

			},time_to_close);

			console.log(params);

		};

		

		

  

	   

		_this.initilize=function(params){

			  try{

				  params=JSON.parse(params);

			  }catch(e){

				  console.log('serious error');

				  return false;

			  }

			  //console.log(params);

			_this.Link=params.Link;

			_this.start_link=params.Link;

			_this.Config=params.Config

  

			if(!_this.validateConfig()){

				  _this.addError(DEFINE.JS_ERROR_CONFIG);

				  return false;

			}

			

			

			_this.Navigation= new Navigation();

			_this.Display= new Display();

			_this.Footer = new Footer();

			_this.Cart= new Cart();

			

			if(_this.Config.delivery.active){

				_this.GoogleProcess= new GoogleProcess();

			}

			

			if(_this.Config.delivery.active && _this.Config.delivery.credit || _this.Config.pickup.active && _this.Config.pickup.credit){

				_this.CreditCard = new CreditCard();

			}

			

			

			if(_this.Config.delivery.active){

				_this.GoogleProcess.setSuper(_this);

			}

			if(_this.Config.delivery.active && _this.Config.delivery.credit || _this.Config.pickup.active && _this.Config.pickup.credit){

				_this.CreditCard.setSuper(_this);

			}

			_this.Navigation.setSuper(_this);

			_this.Display.setSuper(_this);

			_this.Footer.setSuper(_this);

			_this.Cart.setSuper(_this);

		  

		  

		  

		  

			_this.Navigation.initilize();

			_this.Display.initilize();

			if(_this.Config.delivery.active){

				_this.GoogleProcess.initilize();

			}

			if(_this.Config.delivery.active && _this.Config.delivery.credit || _this.Config.pickup.active && _this.Config.pickup.credit){

				_this.CreditCard.initilize();

			}

  

  

			  return true;

		};

		

		

		

		_this.validateConfig = function(){

			  //complete this

			  

		   //check restaurant address

			if(!_this.Config.restaurant_address || typeof _this.Config.restaurant_address !== 'string' || _this.Config.restaurant_address.length<5){

				_this.addError(DEFINE.JS_ERROR_BAD_ADDRESS);

				return false;

			}

			

		   //check json range

			if(!_this.Config.json_range || Object.prototype.toString.call( _this.Config.json_range ) !== '[object Array]' || _this.Config.json_range.length<3) {

				_this.addError(DEFINE.JS_ERROR_BAD_JSON_RANGE);

				return false;

			}

  

			return true;

		};

  

  

  

  

	   _this.sendLink=function(key){

		   _this.Link.key=key;

		   $.ajax(

		   {

			   async:true,

			   dataType:"JSON",

			   cache:false,

			   timeout:8000,

			   url:"",

			   type:"POST",

			   data:{"Link":JSON.stringify(_this.Link)},

			   beforeSend: function(data){

				   //console.log(data);

			   },

			   success: function(data){

				   //console.log(data);

				   document.body.style.cursor='default';

				  

				   switch(key){
						case DEFINE.KEY_CHECKTIME:
						    _this.Link=data;	
							if(_this.Link.open_menus.length==0){

								_this.addError(DEFINE.JS_ERROR_NO_OPEN_MENUS);

							}
						break;
					   case DEFINE.KEY_CALCULATETOTAL:

					    if(data.error){

							

								  _this.addError(data.error);

								  return false; 

							   }

							  _this.Link=data;		

							  _this.Display.syncTotalsToLabel();

							  _this.Display.updateDisplayCartHeader();

							  _this.Display.updateDisplayCartCheckout();

							  //console.log('added to cart post');

							  //console.log(_this.Link);

							  if(_this.Link.cart.length>0){

								  //console.log('has cart');

								  $('.main_cart_button').show();

							  }

							  

					   break;

					   case DEFINE.KEY_PLACEORDER:

							  if(data.error){

								   $('.footer_words','#checkout-page').text('Place Order');

								 $('.main_footer','#checkout-page').attr('data-function','place_order');

								  _this.addError(data.error);

								  return false; 

							   }

							  if(data.order_complete){

								  _this.Display.updateDisplayCartThankyou();

								  _this.Display.syncPaymentTypeToLabel();

								  $('#'+DEFINE.ID_FINAL_ORDERS_ID).text(data.orders_id);

								  //_this.Navigation.changePage('#'+DEFINE.ID_PAGE_THANKYOU);

								   $.mobile.pageContainer.pagecontainer("change", "#"+DEFINE.ID_PAGE_THANKYOU, {transition: "flip"});

									_this.Link=_this.start_link;

									var hisleng = $.mobile.navigate.history.stack.length;

							  for(var kk=0;kk<hisleng;kk++){

								  //console.log( $.mobile.navigate.history.stack[kk]);

								 delete $.mobile.navigate.history.stack[kk];

							  }

							  }else{

								  //TODO

								  //check this for sure

								  this.error();

							  }

					   break;

					   default:

						  return false; 

					   break;

				   }

				  

			  },

			  error: function(data){

				  document.body.style.cursor='default';

				  switch(key){

					   case DEFINE.KEY_CALCULATETOTAL:

							  _this.addError('There has been an error adding to cart please try again');

							  return false; 

					   break;

					   case DEFINE.KEY_PLACEORDER:

				

					   		  $('.footer_words','#checkout-page').text('Place Order');

							  $('.main_footer','#checkout-page').attr('data-function','place_order');

							  _this.Link.braintree_nonce='';

							  _this.addError('There has been an error with your order please try again');

							  return false; 

					   break;

					   default:

						   //console.log('default link send error');

						   return false; 

					   break;

				   }

			  }

		  });

		   

		   

		   return true;

	   };

	//end of base

  };

  

  //

  //

  //

  // this is the navigation class

  //

  //

  //

  

  var Navigation = function(){

		'use strict';

		var _super = {};

		var _this = this;

		

	

		_this.setSuper=function(extend_base){

			_super=extend_base;

		};

	  _this.initilize=function(){

		  if(_super.Config.delivery.active && !_super.Config.pickup.active){

			  $.mobile.pageContainer.pagecontainer("change", "#"+DEFINE.ID_PAGE_DELIVERY_CONTACT, {transition: "none"});

		  }else if(!_super.Config.delivery.active && _super.Config.pickup.active){

			  $.mobile.pageContainer.pagecontainer("change", "#"+DEFINE.ID_PAGE_MAIN_MENU, {transition: "none"});

		  }

				//var script='';

//				script=document.createElement('script');

//				script.type='text/javascript';

//				script.src='js/history.js';

//				script.async='true';

//				document.getElementsByTagName('head')[0].appendChild(script);  

//				setTimeout(_this.historyOnload,33);

	  };

	  _this.historyOnload=function(){

		  return;

		  if(typeof History === 'undefined' || typeof History.Adapter === 'undefined') {

			  		  setTimeout(_this.historyOnload,100);

					  //console.log('loading history');

					  //_super.addError(DEFINE.JS_ERROR_NO_GOOGLE);

					  return false;

		  }

		  //console.log('history loaded');

		  var main_start ='#'+$('.main-page.show_page').attr('id');

		  ////console.log(main_start);

			var mainlink = _this.getCookie(DEFINE.LINK_COOKIE_NAME);

			if(mainlink && false){

				//console.log('aquired link');

				_super.Link=JSON.parse(mainlink);

				_super.Display.syncDeliveryAddressToLabel();

				_super.Display.syncCustomerToLabel();

				_super.Display.updateDisplayCartCheckout();

				_super.Display.updateDisplayCartHeader();

				_this.setCookie(DEFINE.LINK_COOKIE_NAME,'',-1);

				if(_super.Link.cart.length>0){

					$('.main_cart_button').show();

					_super.Footer.changeFooter('checkout');

				}

				if(_super.Link.delivery===1){

					 _super.Display.toDelivery();

					 _super.Display.syncTotalsToLabelDelivery();

				}else if(_super.Link.delivery===0){

					 _super.Display.toPickup();

					 _super.Display.syncTotalsToLabelPickup();

				}

				if(_super.Link.payment_type){

					$("#"+DEFINE.ID_PAYMENT_SELECTOR+" option").filter(function() {

						return $(this).val() === _super.Link.payment_type; 

					}).prop('selected', true);

					_super.Display.changePayment();

				}

			}else{

				//console.log(_super.Link);

				//console.log(_super.Config);

				if(_super.Link.delivery===1){

					 _super.Display.toDelivery();

				}else if(_super.Link.delivery===0){

					 _super.Display.toPickup();

				}	

			}

	//		

//		 History.Adapter.bind(window,'statechange',function(){ 

//			$(window).scrollTop(0);

//			var State = History.getState();

//			var next_page=State.data.state;

//			if(typeof next_page === 'undefined') {

//				next_page=main_start;

//			}

//			//console.log('State change: '+next_page);

//			_this.pageMod(next_page);

//		});

//	

		//History.pushState({state:main_start});

	

		

		

		$(document).on('click','.change-page',function(){

			//_this.changePage($(this).attr('data-location'));

		});	

	

		$( window ).on('beforeunload',this,function() {

			//_this.setCookie(DEFINE.LINK_COOKIE_NAME,JSON.stringify(_super.Link),1);

		});

	  };

	  

	 _this.setCookie=function(cname, cvalue, exdays) {

		  var d = new Date();

		  d.setTime(d.getTime() + (exdays*24*60*60*1000));

		  var expires = "expires="+d.toUTCString();

		  document.cookie = cname + "=" + cvalue + "; " + expires;

	 };

	 

	 

	  _this.getCookie=function(cname) {

		  var name = cname + "=";

		  var ca = document.cookie.split(';');

		  for(var i=0; i<ca.length; i++) {

			  var c = ca[i];

			  while (c.charAt(0)==' ') c = c.substring(1);

			  if (c.indexOf(name) == 0) return c.substring(name.length,c.length);

		  }

		  return "";

	 };

		 

		 

	  _this.changePage=function(next_page){

			//History.pushState({state:next_page});

	  };

	  

	  

	  

	  _this.pageMod=function(page){

		  $('.show_page').removeClass('show_page');

		  $(page).addClass('show_page');

		  //console.log(page);

		  switch(page){

			  case '#'+DEFINE.ID_PAGE_DELIVERY_CONTACT:

				  $('#'+DEFINE.ID_FOOTER).text('Save').attr('data-function','save_address');

				  if(_super.Link.delivery_address.zipcode){

					  $('#'+DEFINE.ID_FOOTER).show();

				  }

				  break;

				  

			  case '#'+DEFINE.ID_PAGE_CHECKOUT:

				  

				  _super.Display.syncDeliveryAddressToLabel();

				  _super.Display.syncCustomerToLabel();

				  _super.Display.syncTotalsToLabel();

				  _super.Display.updateDisplayCartCheckout();

				  _super.Display.updateDisplayCartHeader();

				  

				  _super.Footer.changeFooter('place_order');

				  break;

				  

			  case '#'+DEFINE.ID_PAGE_THANKYOU:

				  _super.Link=_super.start_link;

				  $('#'+DEFINE.ID_FOOTER).hide();

							  

				  break;

				  

			  case '#'+DEFINE.ID_PAGE_MAIN_MENU:

			  case '#'+DEFINE.ID_PAGE_START:

				  if(_super.Link.cart.length){

					  _super.Footer.changeFooter('checkout');

				  }else{

					  $('#'+DEFINE.ID_FOOTER).hide();

				  }

				  break;

				  

			  default:

				  $('#'+DEFINE.ID_FOOTER).hide();

				  break;

		  }

		};

		//end of navigation

	};



  

  

  

  

  	//

	//

	//

	// this is the display class

	//

	//

	//

	var Display = function(){

		'use strict';

		var _super = {};

		var _this = this;

		

		

		_this.setSuper=function(extend_base){

			_super=extend_base;

		};

		

		_this.initilize = function(){

			//bind those elements

			var touchmethod='pointerdown';

			//setInterval(function(){

				//$('.row').text($(window).scrollTop()) ;	

			//},100);

// or
if($(window).width()>992){
			$(document).on('click','.menu-header',function(){
				setTimeout(function(){
					$('#scrollme').height($('.ui-page-active').height()+30);
				},500);
			});
}

			

			window.onbeforeunload = function(event) {

				window.location.hash='';

				if(_super.Link.cart.length>0){

					//return 'If you exit you will lose your cart';

				}

			};

		

			$(document).on(touchmethod,'#start_del_btn',function(){

				$.mobile.pageContainer.pagecontainer("change","#"+DEFINE.ID_PAGE_DELIVERY_CONTACT, {transition: "slide",role:"page"});

			});

			$(document).on(touchmethod,'#start_pick_btn',function(){

				$.mobile.pageContainer.pagecontainer("change","#main-menu-page", {transition: "slide",role:"page"});

			});

//			$( document ).bind( "pageshow", function( e, data ) {

//		

//				if($(window).width()>992){

//				setTimeout(function(){

//					var hheight = $('.ui-page','.ui-page-active').height();

//					hheight= (hheight*1.1)+20;

//					console.log(hheight);

//					if(hheight<900){

//						hheight=900;

//					}

//				  //$('#scrollme').css('height',hheight);

//				 },300);

//				}

//			});

//			$(document).resize(function(){

//				console.log($(document).height());

//				var seint = setInterval(function(){

//					//$('#scrollme').css('height',$(document).height());

//				 },100);

//				 setTimeout(function(){

//					 clearInterval(seint);

//				 },500);

//				

//			});

//			$(document).on(touchmethod,'add_t.menu-header',function(){

//				//if($(window).width()>992){

//					var seint = setInterval(function(){

//					

//				 },100);

//				 setTimeout(function(){

//					 clearInterval(seint);

//				 },500);

//				//}

//				

//			});

			//if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i) || true)) {

				 //$('.main_footer').attr('data-position','');

			//}

		//straight button to function clicks

			$(document).on('focus','.qty-box',function(){

				this.value='';

			});

			$(document).on('keyup','input[data-type="search"]','.ui-filterable',function(){

					//console.log('click');

					var src = $('.search-item');

					//src.addClass('search-item-display');

					//src.removeClass('search-item');

					src.show();

			});

			$(document).on('blur','input[data-type="search"]','.ui-filterable',function(){

				

					//console.log('click');

					setTimeout(function(){

						var src =$('.search-item');

					src.hide();

					$('input[data-type="search"]').val('');

					},400);

					

			});

			//$(document).on(touchmethod,'.product-edit',_super.Cart.editCart);

			$(document).on(touchmethod,'.product-delete',_super.Cart.deleteFromCart);

			$(document).on(touchmethod,'.undo-delete',_super.Cart.unDelete);

			$(document).on('click','.menu-header',_this.menuHeaderClick);

			//$(document).on(touchmethod,'.product-panel-drop',_this.hideProductPanel);

			$(document).on(touchmethod,'.'+DEFINE.CLASS_TOGGLE_TODELIVERY,_this.toDelivery);

			$(document).on(touchmethod,'.'+DEFINE.CLASS_TOGGLE_TOPICKUP,_this.toPickup);

			$(document).on('change','#'+DEFINE.ID_PAYMENT_SELECTOR,_this.changePayment);

			$(document).on('change keyup','#tip-option-val',_super.Cart.calcTipDisplay);

			//button to function with params

			$(document).on('focus','.products_quantity',function(){

				$(this).val('');

			});

			//$(document).on('click','#'+DEFINE.ID_CHECKOUT_CREDIT_CARD_INFO,function(){



				//$(window).scrollTop($(this).offset().top-82);

			//});

			$(document).on('focus','.form-control',function(){

				if($(window).width()<900){

					//console.log('jump');

					//$(window).animate({ scrollTop:$(this).offset().top-82});



				}

			});

			$(document).on(touchmethod,'.top-menu-select',function(){

				$('.top-menu-select').removeClass('active');

				$(this).addClass('active');

				$('.top-menu').hide();

				$($(this).attr('data-target')).show();

			});	

			

			$(document).on(touchmethod,'.'+DEFINE.ID_ERROR_MESSAGE,function(){

				$('.'+DEFINE.ID_ERROR_MESSAGE).slideUp(1);

			});

			

			$(document).on(touchmethod,'.product-row',function(){

				//var products_id = this.id.split('-');

				//_this.showProductPanel(products_id[1]);

				//_super.Footer.changeFooter('add_to_cart');

			});

			

			$(document).on(touchmethod,'.checkdelivery',function(){

				if(!_super.Link.delivery_address.zipcode){

					$.mobile.pageContainer.pagecontainer("change", "#"+DEFINE.ID_PAGE_DELIVERY_CONTACT, {transition: "slideup",role:"page"});

				}

			});

			

			$(document).on(touchmethod,'.tip-btn',function(){

				  $('.tip-btn').removeClass('active');

				  $(this).addClass('active');	

				  if(this.id==="other_tip"){

					  $('#custom-tip').slideDown(300);

				  }else{

					  $('#custom-tip').slideUp(300);

				  }

				  _super.Cart.calcTipDisplay();

			 });

			  

			 $(document).on(touchmethod,'#tip-percent',function(){

				  $('#tip-option').text('% ').attr('data-value','percent');	

				  _super.Cart.calcTipDisplay();

			 });

			  

			 $(document).on(touchmethod,'#tip-flat',function(){

				  $('#tip-option').text('$ ').attr('data-value','flat');

				  _super.Cart.calcTipDisplay();	

			 });

			

			$(document).on(touchmethod,'.close_modal_mobile,#close_modal_main,#close_x',function(){

				window.send_to.postMessage({key:'close'},window.send_from);

			});

		

				

				

			$(document).on(touchmethod,'#menu_header_icon',function(){

				$('.main-menu').addClass('main-menu-show');

				$('.main-menu-inner').addClass('main-menu-inner-show');

				$('#close_header').show();

			});

			

			$(document).on(touchmethod,'#close_header',function(){

				$('.main-menu').removeClass('main-menu-show');

				$('.main-menu-inner').removeClass('main-menu-inner-show');

				$('#close_header').hide();

			});

	

			$(document).on('focus','#tip-option-val',function(){

					this.value='';

			});

			  

			  

		  ///

		  // most important bindings

		  ///

		  		

			$(document).on(touchmethod,'.cartbox ',function(){

				$('#popupCart').popup("open",{transition:'flip'});

				

			  });

			  $(document).on(touchmethod,'.main_footer ',function(){

				//console.log('footer click');

				 // $(this).blur().hide();

				  

				  if($(this).attr('data-function')){

					  _super.Footer[$(this).attr('data-function')]();

				  }

			  });

			  $(document).on(touchmethod,'.imain_footer ',function(){

				//console.log('footer click');

				 // $(this).blur().hide();

				  

				  if($(this).attr('data-function')){

					  _super.Footer[$(this).attr('data-function')]();

				  }

			  });

			  $(document).on(touchmethod,'.checkoot ',function(){

				//console.log('footer click');

				 // $(this).blur().hide();

				  

				  if($(this).attr('data-function')){

					  _super.Footer[$(this).attr('data-function')]();

				  }

			  });

			  

				

			return true;

		};

		

		

		

		_this.changePayment=function(){

			if(this.value){

				_super.Link.payment_type=this.value;	

			}

			if( _super.Link.payment_type===DEFINE.PAYMENT_CREDIT){

				if(_super.Link.delivery){

				  $('.'+DEFINE.CLASS_TOGGLE_ISDELIVERY_ANDCREDIT).show();	

				  _super.Cart.calcTipDisplay();

				}else{

				  $('.'+DEFINE.CLASS_TOGGLE_ISDELIVERY_ANDCREDIT).hide();

				  $('.'+DEFINE.CLASS_TOTALS_TIP).text('$'+(0).toFixed(2));

				  $('.'+DEFINE.CLASS_TOTALS_GRAND_TOTAL).text('$'+(_super.Link.totals.grand_total).toFixed(2));	 

				}

				$('#'+DEFINE.ID_CHECKOUT_CREDIT_CARD_INFO).slideDown(200);

                if(_super.Link.delivery){


                    $('#'+DEFINE.ID_CHECKOUT_TIP_FOOTER).slideDown(200);

                    if($('#other_tip').hasClass('active')){

                        $('#custom-tip').slideDown(200);

                    }  
                }

			}else{

				$('.'+DEFINE.CLASS_TOGGLE_ISDELIVERY_ANDCREDIT).hide();

				 $('.'+DEFINE.CLASS_TOTALS_TIP).text('$'+(0).toFixed(2));

				  $('.'+DEFINE.CLASS_TOTALS_GRAND_TOTAL).text('$'+(_super.Link.totals.grand_total).toFixed(2));	 

				$('#custom-tip').slideUp(200);

				$('#'+DEFINE.ID_CHECKOUT_CREDIT_CARD_INFO).slideUp(200);

				$('#'+DEFINE.ID_CHECKOUT_TIP_FOOTER).slideUp(200);

			}

			return true;

		};

		

		

		_this.toDelivery=function(){

			if(_super.Link.payment_type===DEFINE.PAYMENT_INSTORE){

				$("#"+DEFINE.ID_PAYMENT_SELECTOR+" option").filter(function() {

							return $(this).val() === 'x'; 

						}).prop('selected', true);

				_super.Link.payment_type='';

			}

			 _super.Link.delivery=1;

			

			

			if(_super.Link.payment_type==DEFINE.PAYMENT_CREDIT){

				$('.'+DEFINE.CLASS_TOGGLE_ISDELIVERY_ANDCREDIT).show();	

				

				_super.Cart.calcTipDisplay();

			}else{

				$('.'+DEFINE.CLASS_TOGGLE_ISDELIVERY_ANDCREDIT).hide();	

			}

			

			$('.'+DEFINE.CLASS_TOGGLE_TOPICKUP).removeClass('active');

			$('.'+DEFINE.CLASS_TOGGLE_TODELIVERY).addClass('active');

			$('.'+DEFINE.CLASS_TOGGLE_ISPICKUP).hide();

			$('.'+DEFINE.CLASS_TOGGLE_ISDELIVERY).show();

			$('#'+DEFINE.ID_CHECKOUT_ADDRESS).slideDown(300);

			$('#checkout-address-footer').slideDown(300);

			$('#pickup_contact').slideUp(300);

			_this.syncTotalsToLabel();

			

			var appen = '';

			if(_super.Config.delivery.credit){

				appen+='<option value="credit">Credit Card</option>';

			}

			if(_super.Config.delivery.cash){

				appen+='<option value="cash">Cash</option>';	

			}

			$('#'+DEFINE.ID_PAYMENT_SELECTOR).html('')
			.append('<option value="x">Select Payment Method</option>'+appen);
			
			try{
				$('#'+DEFINE.ID_PAYMENT_SELECTOR).val('x').selectmenu('refresh');		
			}catch(e){
				
			}
            
            _super.sendLink(DEFINE.KEY_CHECKTIME);
            
			return true;

		};

		

		_this.toPickup=function(){


			_super.Link.delivery=0;	

			//todo
			_super.Link.payment_type=DEFINE.PAYMENT_INSTORE;
			_super.sendLink(DEFINE.KEY_CHECKTIME);
			

			$('.'+DEFINE.CLASS_TOGGLE_TODELIVERY).removeClass('active');

			$('.'+DEFINE.CLASS_TOGGLE_TOPICKUP).addClass('active');

			$('.'+DEFINE.CLASS_TOGGLE_ISDELIVERY).hide();

			$('.'+DEFINE.CLASS_TOGGLE_ISDELIVERY_ANDCREDIT).hide();

			$('.'+DEFINE.CLASS_TOGGLE_ISPICKUP).show();

			$('#checkout-address-footer').slideUp(300);

			$('#'+DEFINE.ID_CHECKOUT_ADDRESS).slideUp(300);

			$('#pickup_contact').slideDown(300);

			_this.syncTotalsToLabel();

			

			var appen = '';

			if(_super.Config.pickup.credit){

				appen+='<option value="credit">Credit Card</option>';

			}

			if(_super.Config.pickup.instore){

				appen+='<option value="instore" selected="selected">In Store Payment</option>';	

			}

			$('#'+DEFINE.ID_PAYMENT_SELECTOR).html('').append(appen);

			//if(!_super.Link.payment_type){

				

			//}

			try{
		    $('#'+DEFINE.ID_PAYMENT_SELECTOR).val('instore').selectmenu('refresh');		
			}catch(e){
				
			}
			$('#credit-card-info').hide();	
           
            
			return true;

		};

		_this.menuHeaderClick = function(){

			var first_element = $(this);

			if($(window).width()>992){

			  //$('.menu-active').each(function(index, element) {

//				  if(first_element!=this){

//				  var this_element = $(this);

//				  this_element.removeClass('menu-active');

//					this_element.prev('span').show();

//					this_element.next().next('span').show();

//					this_element.prev().prev().css('border-bottom','2px solid '+_super.Config.primary_color);

//					

//					$('.circlegl',this_element).addClass('circlegl1');

//					$('.circlegl',this_element).removeClass('circlegl');

//					this_element.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-left');

//					$(this_element.attr('data-target')).removeClass('in');

//				  }

//					//console.log(this_element.attr('data-toggle'));

//			  });

			}

			var this_element = $(this);

			setTimeout(function(){

			  if($(this_element.attr('data-target')).attr('aria-expanded')==='false'){

				  this_element.removeClass('menu-active');

				  this_element.prev('span').show();

				  this_element.next().next('span').show();

				  this_element.prev().prev().css('border-bottom','2px solid '+_super.Config.primary_color);

				  

				  $('.circlegl',this_element).addClass('circlegl1');

				  $('.circlegl',this_element).removeClass('circlegl');

				  this_element.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-left');

			  }else{

				  this_element.addClass('menu-active');

				  this_element.prev('span').hide();

				  this_element.next().next('span').hide();

				  $('.circlegl1',this_element).addClass('circlegl');

				  $('.circlegl1',this_element).removeClass('circlegl1');

				 // console.log(this_element.prev('.menu-header'));

				  this_element.prev().prev().css('border-bottom','2px solid transparent');

				  this_element.find('i').removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-down');

			  }

			},10);

			 return true;

		};

		

		 _this.hideProductPanel=function(){

		//	 return;

//			$('#main-menu-page').addClass('show_page');

//			$('#product-panel-spacer').hide();

//			$('#product-panel-backdrop').hide();

//			$('.in-panel').removeClass('in-panel');

//			$('#header_spacer').show();

//			$('#main_header_container').show();

//			//var State = History.getState();

//			//var next_page='#'+DEFINE.ID_PAGE_MAIN_MENU;

//			//if(State.data.state){

//				//next_page=State.data.state;

//			//}

//			//_super.Navigation.pageMod(next_page);

//			 return true;

	

		};

		

		_this.showProductPanel=function(products_id){

			//return;

//			$(window).scrollTop(0);

//			$('.show_page').removeClass('show_page');

//			$('#header_spacer').hide();

//			$('#main_header_container').hide();

//			$('#product-panel-'+products_id).addClass('in-panel');

//			 return true;

		};

		

		_this.updateDisplayCartHeader=function(){

			var header_cart = $('#popupCart');

			header_cart.html('');

			var cart_length = _super.Link.cart.length;

			var header_string='';

			if(cart_length>0){

				for(var i=0;i<cart_length;i++){

					header_string+='<div class="container-fluid">';

					  header_string+='<span class="col-xs-2">'+_super.Link.cart[i][1]+'x</span>';

					  header_string+='<span class="col-xs-6">'+_super.Link.cart[i][6]+'</span>';

					  header_string+='<span class="col-xs-4">$'+(parseFloat(_super.Link.cart[i][4])*parseFloat(_super.Link.cart[i][1])).toFixed(2)+'</span>';

					header_string+='</div>';

				}

				header_cart.append(header_string);

				//$('#header_cart_count').text(cart_length);

			}

			 return true;

		};

		

		

		_this.updateDisplayCartCheckout=function(){

			//console.log(_super.Link.cart);

			var checkout_cart = $('#'+DEFINE.ID_CHECKOUT_CART);

			checkout_cart.html('');

			var cart_length = _super.Link.cart.length;

			var checkout_string='';

			if(cart_length>0){

				for(var i=0;i<cart_length;i++){

					checkout_string+=' '+

						'<div id="deleted_'+_super.Link.cart[i][8]+'" class="undo-delete text-right" style="display:none"><i class="glyphicon glyphicon-refresh"></i></div>'+

						'<div id="checkout-panel-'+_super.Link.cart[i][8]+'" class="panel panel-default">'+

							  '<div class="panel-heading container-fluid checkout-heading">'+

							  '<div class="row">'+

								  '<span class="col-xs-3 text-left" style="padding-right:0px;">'+_super.Link.cart[i][1]+'x</span>'+

								  '<span class="col-xs-6 text-center">'+_super.Link.cart[i][6]+'</span>'+

								  '<span class="col-xs-3 text-right" style="padding-left:0px;">$'+(parseFloat(_super.Link.cart[i][4])*parseFloat(_super.Link.cart[i][1])).toFixed(2)+'</span>'+

							  '</div>'+

							  '</div>'+

							  '<div class="panel-body">';

							  var option_length = _super.Link.cart[i][7].length;

							  for(var x=0;x<option_length;x++){

				   checkout_string+='<div class="product_option_checkout">'+_super.Link.cart[i][7][x]+'</div>';

							  }

							   if(_super.Link.cart[i][2].length>2){

								  checkout_string+='<div class="product_option_checkout">'+_super.Link.cart[i][2]+'</div>';

							  }

			checkout_string+='</div>'+

							  '<div class="panel-footer container-fluid checkout-footer">'+

							  '<span data-cart-id="'+_super.Link.cart[i][8]+'" class="product-edit col-xs-6 text-left"></span>'+

							  '<span data-cart-id="'+_super.Link.cart[i][8]+'" class="product-delete text-right col-xs-6"><i class="glyphicon glyphicon-remove"></i></span>'+

							  '</div>'+

						  //<i class="glyphicon glyphicon-cog"></i>

						'</div>';

				}

				checkout_cart.append(checkout_string);

			}

			 return true;

		};

		

		

		

		

		_this.updateDisplayCartThankyou=function(){

			var thankyou_cart = $('#'+DEFINE.ID_THANKYOU_CART);

			thankyou_cart.html('');

			var cart_length = _super.Link.cart.length;

			var thankyou_string='';

			if(cart_length>0){

				for(var i=0;i<cart_length;i++){

					thankyou_string+=' '+

					   

						'<div class="panel panel-default">'+

							  '<div class="panel-heading container-fluid checkout-heading">'+

		

							  '<div class="row">'+

								  '<span class="col-xs-3 text-left" style="padding-right:0px;">'+_super.Link.cart[i][1]+'x</span>'+

								  '<span class="col-xs-6 text-center">'+_super.Link.cart[i][6]+'</span>'+

								  '<span class="col-xs-3 text-right" style="padding-left:0px;">$'+(parseFloat(_super.Link.cart[i][4])*parseFloat(_super.Link.cart[i][1])).toFixed(2)+'</span>'+

							  '</div>'+

							  '</div>'+

							  '<div class="panel-body">';

							  

							 

							  var option_length = _super.Link.cart[i][7].length;

							  for(var x=0;x<option_length;x++){

				   thankyou_string+='<div class="product_option_checkout">'+_super.Link.cart[i][7][x]+'</div>';

							  }

							   if(_super.Link.cart[i][2].length>2){

								  thankyou_string+='<div class="product_option_checkout">'+_super.Link.cart[i][2]+'</div>';

							  }

			thankyou_string+='</div>'+

						'</div>';

				}

				thankyou_cart.append(thankyou_string);

	

			}

			 return true;

		};

		

		//get info from dom

		_this.syncDeliveryAddressToWindow=function(){

			//regex this

			 var address = $('#'+DEFINE.ID_DELIVERY_STREET_AND_NUMBER).val();

			 var splode = address.split(' ');

			_super.Link.delivery_address.street_number=splode[0];

			_super.Link.delivery_address.street=address.replace(splode[0]+' ','');

			

			_super.Link.delivery_address.apt = $('#'+DEFINE.ID_DELIVERY_APT).val(); 

			_super.Link.delivery_address.city = $('#'+DEFINE.ID_DELIVERY_CITY).val(); 

			_super.Link.delivery_address.state = $('#'+DEFINE.ID_DELIVERY_STATE).val(); 

			_super.Link.delivery_address.zipcode = $('#'+DEFINE.ID_DELIVERY_ZIPCODE).val(); 

			 return true;

		  };

		  

		  _this.syncCustomerToWindow=function(){

			  //regex this

			_super.Link.customer.name = $('#'+DEFINE.ID_CUSTOMER_NAME).val(); 

			_super.Link.customer.phone = $('#'+DEFINE.ID_CUSTOMER_PHONE).val(); 

			_super.Link.customer.email = $('#'+DEFINE.ID_CUSTOMER_EMAIL).val(); 

			 return true;

		  };

		

		//put info on dom

		  _this.syncCustomerToLabel=function(){

			  $('.'+DEFINE.LABEL_CUSTOMER_NAME).text(_super.Link.customer.name);

			  $('.'+DEFINE.LABEL_CUSTOMER_PHONE).text(_super.Link.customer.phone);

			  $('.'+DEFINE.LABEL_CUSTOMER_EMAIL).text(_super.Link.customer.email);

			  return true;

		  };

		  _this.syncDeliveryAddressToLabel=function(){	

		  //console.log(_super.Link);

			$('.'+DEFINE.LABEL_DELIVERY_STREET_AND_NUMBER).text(_super.Link.delivery_address.street_number+' '+_super.Link.delivery_address.street);

			$('.'+DEFINE.LABEL_DELIVERY_APT).text(_super.Link.delivery_address.apt);

			$('.'+DEFINE.LABEL_DELIVERY_CITY).text(_super.Link.delivery_address.city);

			$('.'+DEFINE.LABEL_DELIVERY_STATE).text(_super.Link.delivery_address.state);

			$('.'+DEFINE.LABEL_DELIVERY_ZIPCODE).text(_super.Link.delivery_address.zipcode);

			return true;

		  };

		  _this.syncDeliveryAddressToInput=function(){

			$('#'+DEFINE.ID_DELIVERY_STREET_AND_NUMBER).val(_super.Link.delivery_address.street_number+' '+_super.Link.delivery_address.street);

			$('#'+DEFINE.ID_DELIVERY_APT).val(_super.Link.delivery_address.apt);

			$('#'+DEFINE.ID_DELIVERY_CITY).val(_super.Link.delivery_address.city);

			$('#'+DEFINE.ID_DELIVERY_STATE).val(_super.Link.delivery_address.state);

			$('#'+DEFINE.ID_DELIVERY_ZIPCODE).val(_super.Link.delivery_address.zipcode);

			 return true;

		  };

		  

		  

		  _this.syncTotalsToLabel=function(){

			  //validate all these

			  _super.Link.totals.delivery_fee=parseFloat(_super.Link.totals.delivery_fee);

			  if(_super.Link.delivery===1){

				   _this.syncTotalsToLabelDelivery();

			  }else{

				   _this.syncTotalsToLabelPickup();

			  }

		  };

		  

		  _this.syncTotalsToLabelPickup=function(){

			$('.'+DEFINE.CLASS_TOTALS_SUBTOTAL).text('$'+_super.Link.totals.subtotal.toFixed(2));

			$('.'+DEFINE.CLASS_TOTALS_TAX).text('$'+_super.Link.totals.tax.toFixed(2));

			$('.'+DEFINE.CLASS_TOTALS_DELIVERY_FEE).text('$'+(0).toFixed(2));

			$('.'+DEFINE.CLASS_TOTALS_TIP).text('$'+(0).toFixed(2));

			$('.'+DEFINE.CLASS_TOTALS_GRAND_TOTAL).text('$'+(_super.Link.totals.grand_total-_super.Link.totals.delivery_fee-_super.Link.totals.tip).toFixed(2));

			return true;

		  };

		  _this.syncTotalsToLabelDelivery=function(){

	

			$('.'+DEFINE.CLASS_TOTALS_SUBTOTAL).text('$'+_super.Link.totals.subtotal.toFixed(2));

			$('.'+DEFINE.CLASS_TOTALS_TAX).text('$'+_super.Link.totals.tax.toFixed(2));

			$('.'+DEFINE.CLASS_TOTALS_DELIVERY_FEE).text('$'+_super.Link.totals.delivery_fee.toFixed(2));

			$('.'+DEFINE.CLASS_TOTALS_TIP).text('$'+_super.Link.totals.tip.toFixed(2));

			$('.'+DEFINE.CLASS_TOTALS_GRAND_TOTAL).text('$'+_super.Link.totals.grand_total.toFixed(2));

			return true;

		  };

		  

		  _this.syncPaymentTypeToLabel=function(){

			  var payment_text='';

			  switch(_super.Link.payment_type){

				  case DEFINE.PAYMENT_CASH:

				  payment_text='Cash';

				  break;

				  case DEFINE.PAYMENT_CREDIT:

				  payment_text='Credit Card';

				  break;

				  case DEFINE.PAYMENT_INSTORE:

				  payment_text='In Store Payment';

				  break;

				  default:

				  payment_text='';

				  break;

			  }

			  

			$('.'+DEFINE.LABEL_PAYMENT_TYPE).text(payment_text);  

			  return true;

		  };

		//end of display

	};

	

	

	//

	//

	//

	// this is the footer class

	//

	//

	//

	var Footer = function(){

		  'use strict';

		  var _super = {};

		  var _this = this;

		  

			  _this.setSuper=function(extend_base){

				  _super=extend_base;

			  };

			  

			  _this.add_to_cart= function(e){

				  //console.log('added to cart');





				  _super.Cart.addToCart();

				  

				  

				  //$( ":mobile-pagecontainer" ).pagecontainer("change", "#main-menu-page", {transition: "flip"});

				  //_super.Display.hideProductPanel();

				  return true;

			  };

			  

			  _this.update_cart= function(){

				  //console.log('#update-cart');

				  $('.update_spacer').remove();

				 // $('.product-panel-drop','.in-panel').show();

				  _super.Cart.addToCart();

				  _super.Display.hideProductPanel();

				  return true;

			  };

			  

			  _this.checkout= function(){

				  //console.log('checkout');

				  if(_super.Link.delivery==1){

					  if(parseFloat(_super.Link.totals.subtotal)<parseFloat(_super.Config.min_order)){

						   _super.addError(DEFINE.JS_ERROR_BELOW_MIN);

						  // _this.changeFooter('checkout');

						  //console.log('error');

						   return false;

					  }

				  }

				  $.mobile.pageContainer.pagecontainer("change", "#"+DEFINE.ID_PAGE_CHECKOUT, {transition: "slide",role:"page"});

				  //_super.Navigation.changePage('#'+DEFINE.ID_PAGE_CHECKOUT);

				  return true;

			  };

			  

			  _this.place_order= function(){

				  document.body.style.cursor='wait';

				  if(_super.Link.delivery==0){

					  var cust_name = $('#pickup_name').val();

					  if(!cust_name){

						   _super.addError('Please add a name for your order');

						   $('#pickup_name').focus();

						   return;

					  }

					_super.Link.customer.name = cust_name;

			 		_super.Link.customer.phone = $('#pickup_number').val();  

				  }

				  $('.footer_words','#checkout-page').text('Loading...');

				  $('.main_footer','#checkout-page').attr('data-function','');

				  _super.Cart.placeOrder();	

				  return true;

			  };

			  

			  _this.save_address= function(e){

				  //do stuff

				 if(!$('#'+DEFINE.ID_DELIVERY_ZIPCODE).val()){
				 	_super.addError('Please enter a zipcode');
				 	return false;
				 }
				 
				 if(!$('#'+DEFINE.ID_DELIVERY_STATE).val()){
				 	_super.addError('Please enter State');
				 	return false;
				 }
				 
				 if(!$('#'+DEFINE.ID_DELIVERY_CITY).val()){
				 	_super.addError('Please enter City');
				 	return false;
				 }
				 if(!$('#'+DEFINE.ID_CUSTOMER_NAME).val()){
				 	_super.addError('Please enter a Name');
				 	return false;
				 }
				 
				 if(!$('#'+DEFINE.ID_CUSTOMER_PHONE).val()){
				 	_super.addError('Please enter Phone');
				 	return false;
				 }

				 if(!$('#'+DEFINE.ID_DELIVERY_STREET_AND_NUMBER).val()){
				 	_super.addError('Please enter Address');
				 	return false;
				 }

				  _super.Display.syncCustomerToWindow();

				  _super.Display.syncDeliveryAddressToWindow();

				  _super.Display.toDelivery();

				  _super.Display.syncCustomerToLabel();

				  _super.Display.syncDeliveryAddressToLabel();



				   $.mobile.pageContainer.pagecontainer("change", "#main-menu-page", {transition: "slide",role:"page"});

				  //_super.Navigation.changePage('#'+DEFINE.ID_PAGE_MAIN_MENU);

				  return true;

			  };

			  

			  _this.loading=function(){

				  return true;

			  };

			  _this.changeFooter=function(func){

				  if (typeof _this[func] !== 'function') {

					  _super.addError('err no func');

					  return false;

				  }

				  var display='';

				  switch(func){

					  case 'add_to_cart':display="Add to Cart"; break;

					  case 'place_order':display="Place Order";break;

					  case 'save_address':display="Save";break;

					  case 'checkout':display="Checkout";break;

					  case 'update_cart':display="Update";break;

					  case 'loading':display="Loading...";func='';break;

					  case 'default': 
					  //console.log('default change footer');
					  break;

				  }

				  setTimeout(function(){

					  $('#'+DEFINE.ID_FOOTER).text(display).attr('data-function',func).show();

				  },50);

				  document.body.style.cursor='default';

				  return true;

			  };

	  //end of footer

	  };

	  

	  

	  //

	  //

	  //

	  // this is the cart class

	  //

	  //

	  //

	  var Cart = function(){

			'use strict';

			var _super = {};

			var _this = this;

			

			_this.setSuper=function(extend_base){

				_super=extend_base;

			};

			

			_this.addToCart=function(){

				var new_cart_item = [];

				

				var options_array=[];

				var display_options_array=[];

				var current_panel = $('.panelpage');

				var id =current_panel.attr('id').split('-');

				var menu_id = parseInt(id[3]);

				if(_super.Link.open_menus.indexOf(menu_id)===-1){

					//console.log('menu closed');

					_super.addError('Sorry the menu for that item is closed');

					return false;

					

				}

				//console.log(menu_id);

				id=id[2];

		

				$('.select-option-'+id+' option:selected','.in-panel').each(function() {

					options_array.push($(this).attr('data-option-key'));

					display_options_array.push($(this).attr('data-option-name'));

				});

				

				$('.check_checked:checked','.panelpage').each(function() {

					options_array.push($(this).attr('data-option-key'));

					display_options_array.push($(this).attr('data-option-name'));

				});

				if(options_array.length===0){

					options_array.push(0);

				}

				

				var product_quantity= $('#product_quantity-'+id).val();

				$('#product_quantity-'+id).val(1);

				if(product_quantity<1){

					product_quantity=1;

				}

				var product_special=$('#product_spec-'+id).val();

				if(!product_special){

					product_special='';

				}

				if(!_super.Link.cart_count){

					_super.Link.cart_count=0;

				}

				_super.Link.cart_count=parseInt(_super.Link.cart_count);

				

				new_cart_item.push(id);

				new_cart_item.push(product_quantity);

				new_cart_item.push(product_special);

				new_cart_item.push(options_array);

				new_cart_item.push(0);

				new_cart_item.push(0);

				new_cart_item.push($('#product_name-'+id).attr('data-product-name'));

				new_cart_item.push(display_options_array);

				new_cart_item.push(_super.Link.cart_count++);

				$('#cart_count').text(_super.Link.cart_count);

				_super.Link.cart.push(new_cart_item);

				

				$('.product_option.active','.in-panel').removeClass('active');

				//return this to defaults

				$('#menu-footer').removeClass('hide_footer');

				

				_this.calcTotal();

				return true;

			};

			

		

			

			_this.deleteFromCart=function(){

				

				if(_super.Link.cart.length<=1){

					_super.addError('You cant delete the last item');

					return false;

				}

			

				if(!window.deleted_cart){

					window.deleted_cart=[];	

				}

		

				var cart_id = $(this).attr('data-cart-id');

				var cart_item = _this.findCartItem(cart_id);

				window.deleted_cart.push( cart_item);

		

				var grandparent = $('#checkout-panel-'+cart_id);

				grandparent.addClass('delete-product');

				grandparent.prev('.undo-delete').addClass('undo-delete-animate');

		

				setTimeout(function(){

					grandparent.prev('.undo-delete').show();

				},250);	

		

				setTimeout(function(){

					grandparent.hide();

				},500);	

				

				_this.calcTotal();

				return true;

			};

			

			

			_this.unDelete=function(){

				$(this).hide().removeClass('undo-delete-animate');

				$(this).next('.delete-product').show().removeClass('delete-product');

				

				var cart_id = this.id.split('_');

				cart_id=parseInt(cart_id[1]);

				var cart_length = window.deleted_cart.length;

				var cart_item=[];

				for(var i =0;i<cart_length;i++){

					if(window.deleted_cart[i][8]===cart_id){

						 cart_item =window.deleted_cart.splice(i, 1 )[0];

						  break;

					}

				}

				

				_super.Link.cart.push(cart_item);

				_this.calcTotal();

				return true;

			};

			

			

			_this.calcTotal=function(){

				_super.sendLink(DEFINE.KEY_CALCULATETOTAL);

				return true;

			};

			

			

			_this.calcTipDisplay=function(){

				var tip=_this.actualTipCalc();

				$('.'+DEFINE.CLASS_TOTALS_TIP).text('$'+tip.toFixed(2));

				$('.'+DEFINE.CLASS_TOTALS_GRAND_TOTAL).text('$'+(_super.Link.totals.grand_total+tip).toFixed(2));

				return true;

			};

			

			

			_this.aquireTip=function(){

				_super.Link.totals.tip=_this.actualTipCalc();

				return true;

			};

			

			

			_this.actualTipCalc=function(){
                    
                if(_super.Link.delivery===0){
                    return;
                }
				var tip=0;

				var data_value = $('.tip-btn.active').attr('data-value');

				if(data_value!=='other'){

					data_value=parseFloat(data_value)/100;

					tip = _super.Link.totals.grand_total * data_value;

				}else{

					var tip_option = $('#tip-option').attr('data-value');

					var tip_option_value = parseFloat($('#tip-option-val').val());

					if(tip_option==='percent'){

						tip = _super.Link.totals.grand_total * (tip_option_value/100);

					}else if(tip_option==='flat'){

						tip = tip_option_value;

					}

				}

				if(!tip || tip<0){

					tip=0;	

				}

				return tip;

			};

			

			

			_this.findCartItem=function(cart_id){

				cart_id=parseInt(cart_id);

				var cart_length = _super.Link.cart.length;

				for(var i =0;i<cart_length;i++){

					if(parseInt(_super.Link.cart[i][8])===cart_id){

						 return _super.Link.cart.splice(i, 1 )[0];

					}

				}

				_super.addError('couldnt find cart item');

				return false;

			};

			

			

			_this.editCart=function(){

				var cart_item = _this.findCartItem($(this).attr('data-cart-id'));

				_super.Display.showProductPanel(cart_item[0]);

				_super.Footer.changeFooter('update_cart');

				

				var op_length = cart_item[3].length;

				//$('.product-panel-drop','.in-panel').hide().after('<div class="update_spacer" style="height:30px"></div>');

				$('.product_option','.in-panel').removeClass('active');

				

				$('#product_quantity-'+cart_item[0]).val(cart_item[1]);

				$('#product_spec-'+cart_item[0]).val(cart_item[2]);

				

				for(var i =0;i<op_length;i++){

					var op = $('.in-panel').find('[data-option-key="'+cart_item[3][i]+'"]');

					if(op.hasClass('select_option')){

					}else if(op.hasClass('product_option')){

						op.addClass('active');

					}

				}	

				return true;

			};

			

			_this.placeOrder=function(){

				//console.log(_super.Link.payment_type);

				if(_super.Link.payment_type!==DEFINE.PAYMENT_CASH && _super.Link.payment_type!==DEFINE.PAYMENT_CREDIT && _super.Link.payment_type!==DEFINE.PAYMENT_INSTORE){

					_super.addError('Please select a payment type');

					$('.footer_words','#checkout-page').text('Place Order');

				  $('.main_footer','#checkout-page').attr('data-function','place_order');

		

					return false;

				}

				if(_super.Link.delivery==1){

				  if(_super.Link.totals.subtotal<_super.Config.min_order){

					   _super.addError(DEFINE.JS_ERROR_BELOW_MIN);

					   $('.footer_words','#checkout-page').text('Place Order');

					$('.main_footer','#checkout-page').attr('data-function','place_order');

					   //_super.Navigation.changePage('#'+DEFINE.ID_PAGE_MAIN_MENU);

					  return false;

				  }

				}

		

			//	_super.Footer.changeFooter('loading');

				_super.Link.orders_comments=$('#'+DEFINE.ID_SPECIAL_INSTUC).val();

				if(_super.Link.delivery && _super.Link.payment_type===DEFINE.PAYMENT_CREDIT){

					_super.Cart.aquireTip();

				}

				if(_super.Link.payment_type===DEFINE.PAYMENT_CREDIT){

					//eh

					$('#'+DEFINE.ID_BRAINTREE_SUBMIT).click();

				}else{

					_super.sendLink(DEFINE.KEY_PLACEORDER);

				}

				return true;	

			};

			//end of cart

		};

		

		//

		//

		// this is the google class

		//

		//

		//

		//

		var GoogleProcess =function(){

			'use strict';

			var _super = {};

			var _this = this;

			_this.autocomplete={};

			_this.customer_place ={};

	  

			

			_this.setSuper=function(extend_base){

				  _super=extend_base;

				  return true;

			 };

			 

			_this.initilize=function() {

				if(typeof google === 'undefined' || typeof google.maps.places === 'undefined') {

				  setTimeout(function(){

					var script='';

					script=document.createElement('script');

					script.type='text/javascript';

					script.src='https://maps.googleapis.com/maps/api/js?key='+DEFINE.GOOGLE_MAP_KEY_1+'&libraries=places,geometry&callback=ohm.GoogleProcess.googleOnload';

					script.async='true';

					document.getElementsByTagName('head')[0].appendChild(script);

				  },33);

				}

				//_this.googleOnload();

			};

			

			_this.googleOnload=function(){



				

		//		setTimeout(function(){

//					var script='';

//					script=document.createElement('script');

//					script.type='text/javascript';

//					script.src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';

//					script.async='true';

//					document.getElementsByTagName('head')[0].appendChild(script);

//				  },100);

				  if(typeof google === 'undefined' || typeof google.maps.places === 'undefined') {

					  _super.addError(DEFINE.JS_ERROR_NO_GOOGLE);

					  return false;

				  }

				 $(document).on('focus','#'+DEFINE.ID_GOOGLE_ADDRESS_SEARCH_TEXT,function(){

					  if($(window).width()>992){

						// $("html, body").animate({ scrollTop: "150px" });

					  }

					 if(!window.located){

						 window.located=1;

						 _this.geolocate();

					 }

				 });

				  var main_input =document.getElementById(DEFINE.ID_GOOGLE_ADDRESS_SEARCH_TEXT);


               // _this.autocomplete  = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} *///(main_input),
           // {types: ['geocode']}); updated 4/28/2019
				
				_this.autocomplete  = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(main_input),
            {fields: ["name", "geometry.location", "place_id", "formatted_address", "address_components"]});
				  _this.autocomplete.addListener('place_changed',_this.findCorrectPlaceText);

				  google.maps.event.addDomListener(main_input, 'keydown', function(e) { 

					  if (e.keyCode === 13 && !$('.pac-item').hasClass('pac-item-selected')) { 

						  $('#'+DEFINE.ID_GOOGLE_ADDRESS_SEARCH_TEXT).blur();

						  _this.mainGeocode();

					  }

				  }); 

				  $(document).on('click','#'+DEFINE.ID_GOOGLE_ADDRESS_SEARCH_BUTTON,_this.mainGeocode);

				  _this.geolocate();

				  //console.log('google ready');

				  return true;

			};

			

			

			_this.mainGeocode=function(){

				  document.body.style.cursor='wait';

				  var address_text = $('#'+DEFINE.ID_GOOGLE_ADDRESS_SEARCH_TEXT).val();

				  //console.log(address_text);

				  if(!address_text){

					  _super.addError(DEFINE.JS_ERROR_NO_ADDRESS_ENTERED);

					  return false;

				  }

				  if(address_text==='begindebug'){

					  //console.log('begin debug');

					  return true;

				  }

				  $.ajax({

					  async:true,

					  dataType:"JSON",

					  data:{"components":"country:US","address":address_text,key:DEFINE.GOOGLE_MAP_KEY_2},

					  url:"https://maps.googleapis.com/maps/api/geocode/json?",

					  type:"GET",

					  success: _this.findCorrectPlaceButton,

					  error: function(){

						  _super.addError('erro at googlejax');

						  return false;

					  }

				  });

				  return true;

			};

	  

			

			_this.findCorrectPlaceButton=function(receive_places){

				 //DO SOMTHIGN HERE

				 //console.log('clicked button or pushed enter');

				if(receive_places.status!='OK'){

					_super.addError(DEFINE.JS_ERROR_ADDRESS_NOT_OK); 

					return false;

				}

				receive_places= receive_places.results;

				if(receive_places.length>0){

					_this.customer_place.lat=receive_places[0].geometry.location.lat;

					_this.customer_place.lng=receive_places[0].geometry.location.lng;

					_this.customer_place.address_components=receive_places[0].address_components;

					_this.customer_place.formatted_address=receive_places[0].formatted_address;

					_this.processAddress();

					return true;

				}else{

					  _super.addError(DEFINE.JS_ERROR_BAD_ADDRESS); 

					  return false;

				}

			};

			

			_this.findCorrectPlaceText=function(){

			  document.body.style.cursor='wait';

			  //console.log('clicked address from dropdown');

			   var receive_places =  _this.autocomplete.getPlace();

			   if(receive_places.hasOwnProperty("address_components")){

				   _this.customer_place.lat=receive_places.geometry.location.lat();

				   _this.customer_place.lng=receive_places.geometry.location.lng();

				   _this.customer_place.address_components=receive_places.address_components;

				   _this.customer_place.formatted_address=receive_places.formatted_address;

				   

				   _this.processAddress();

				   return true;

			   }else{

					_super.addError(DEFINE.JS_ERROR_BAD_ADDRESS);

				   return false; 

			   }

			};

			

			_this.validateCustomerPlace=function(){

				//console.log(_this.customer_place);

				var places_length = _this.customer_place.address_components.length;

				//console.log(places_length);

				if(!_this.customer_place ){

					return false;

				}

				if(!_this.customer_place.lat){

					return false;

				}

				if(!_this.customer_place.lng){

					return false;

				}

				if(!_this.customer_place.address_components || places_length<3){

					return false;

				}

				if(!_this.customer_place.formatted_address){

					return false;

				}

				

				var zip=false;

				for(var i=0;i<places_length;i++){

					//console.log(_this.customer_place.address_components[i].long_name);

					if(_this.customer_place.address_components[i].types[0]=='postal_code'){

						var tmpzip = parseInt(_this.customer_place.address_components[i].long_name);

						if(tmpzip>501){

							_this.customer_place.address_components[i].long_name=tmpzip;

							_this.customer_place.address_components[i].short_name=tmpzip;

							zip=true;

						}

					}

				}

				if(!zip){

					return false;

				}

				$('#'+DEFINE.ID_GOOGLE_ADDRESS_SEARCH_TEXT).val(_this.customer_place.formatted_address);

				return true;

			};

			

			

			_this.processAddress=function() {

				if(!_this.validateCustomerPlace()){

					_super.addError(DEFINE.JS_ERROR_BAD_VALIDATION);

					return false;   

				}

			   var marker = new google.maps.Marker({

		  position: new google.maps.LatLng(_this.customer_place.lat, _this.customer_place.lng),

		  map: Mainmap,

		  title: 'You'

		});

		Mainmap.panTo(new google.maps.LatLng(_this.customer_place.lat, _this.customer_place.lng));

				var google_poly = [];

				for(var key in _super.Config.json_range){

					var latlng = _super.Config.json_range[key].split(',');

					google_poly.push(new google.maps.LatLng(latlng[0], latlng[1]));

				}

				var rangePolygon = new google.maps.Polygon({paths: google_poly});

				var is_in_polygon = google.maps.geometry.poly.containsLocation(new google.maps.LatLng(_this.customer_place.lat, _this.customer_place.lng) , rangePolygon);

				if(!is_in_polygon){

					_super.addError(DEFINE.JS_ERROR_ADDRESS_NOT_IN_POLYGON);

					return false;

				}

		  

				var service = new google.maps.DistanceMatrixService();

				service.getDistanceMatrix(

				  {

					origins: [_this.customer_place.formatted_address],

					destinations: [_super.Config.restaurant_address],

					travelMode: google.maps.TravelMode.DRIVING,

					unitSystem: google.maps.UnitSystem.METRIC,

					durationInTraffic: true,

					avoidHighways: false

				  }, _this.distanceTimeCallback);

				  

				  return true;

			};

			

			_this.distanceTimeCallback=function(response, status) {

				var duration=response.rows[0].elements[0].duration.value;

				var distance=response.rows[0].elements[0].distance.value;

				if(distance>(_super.Config.max_travel_distance/0.621371)*1000){

					 _super.addError(DEFINE.JS_ERROR_ABOVE_MAX_DISTANCE);

					return false;

				}

				if(duration>_super.Config.max_travel_duration){

					 _super.addError(DEFINE.JS_ERROR_ABOVE_MAX_DURATION);

					return false;

				}

				var tier_count = _super.Config.tiers.length;

				var delivery_fee = 0;

				for(var i =0;i<tier_count;i++){

					if(distance>=(_super.Config.tiers[i].distance/0.621371)*1000 || duration>=_super.Config.tiers[i].duration){

						delivery_fee=_super.Config.tiers[i].price;

					}

				}

				

				

				

				_this.addAddress();//where to put this idk

				$('#'+DEFINE.ID_CUSTOMER_NAME).focus();

				//_super.Footer.changeFooter('save_address');

				$('#address-footer').removeClass('hide_footer');

				_super.Link.totals.delivery_fee=delivery_fee;

				_super.Link.duration=duration;

				_super.Link.distance=distance;

				_super.Link.customer_coordinates.lat = _this.customer_place.lat;

				_super.Link.customer_coordinates.lng = _this.customer_place.lng;

				//console.log( _super.Link);

				//console.log(_this.customer_place);

				document.body.style.cursor='default';

				$("#mapcont").animate({ height: 175 });

				if($(window).width()>900){

					$('#scrollme').css('height',$('#delivery-contact-page').height());

				}

				

				//document.body.style.cursor='default';

				return true;

			};

	  

	  

			_this.addAddress = function(){

				  _this.removeAddress();//where to put this idk

				 for (var i = 0; i < _this.customer_place.address_components.length; i++) {

					var addressType = _this.customer_place.address_components[i].types[0];

					  var val = _this.customer_place.address_components[i].long_name;

					  switch(addressType){

						 case 'street_number':

							_super.Link.delivery_address.street_number=val;

						 break;

						 case 'route':

							_super.Link.delivery_address.street=val;

						 break;

						 case 'subpremise':

							_super.Link.delivery_address.apt=val;

						 break;

						 case 'locality':

							_super.Link.delivery_address.city=val;

						 break;

						 case 'administrative_area_level_1':

							_super.Link.delivery_address.state=val;

						 break;

						 case 'postal_code':

							_super.Link.delivery_address.zipcode=val;

						 break;

						 case 'point_of_interest':

						 case 'establishment':

							_super.Link.delivery_address.establishment=val;

						 break;

						 default:

							if(addressType!='administrative_area_level_2' && addressType!='country'){

								_super.Link.delivery_address[addressType]=val;

							}

						 break;

					}

					

				}

				

				//last step

				_super.Display.syncDeliveryAddressToInput();

				//change to add class

				$('#'+DEFINE.ID_CONTACT_FORM).show();

				return true;

			};

			

			_this.removeAddress=function(){

				_super.Link.delivery_address.street_number='';

				_super.Link.delivery_address.street='';

				_super.Link.delivery_address.apt='';

				_super.Link.delivery_address.city='';

				_super.Link.delivery_address.state='';

				_super.Link.delivery_address.zipcode='';

				_super.Link.delivery_address.establishment='';

				return true;

			};

	  

			

			

			_this.geolocate=function () {

				var geolocation = {

					lat: _super.Config.restaurant_coordinates.lat,

					lng: _super.Config.restaurant_coordinates.lng

				  };

				  var circle = new google.maps.Circle({

					center: geolocation,

					radius: 5

				  });

				  _this.autocomplete.setBounds(circle.getBounds());

				  return true;

			};

			

	  //end of google

	  };

	  

	  //

	  //

	  //

	  //this is the credit class

	  //

	  //

	  //

	  //

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

					setTimeout(_this.beginSetup,100);	

					//console.log('braintree injected'); 

				 },5000);

			  }

		  };

		  _this.beginSetup=function(){



			  if(typeof braintree === 'undefined') {

				  //console.log('no braintree, uncaught');

				  setTimeout(_this.beginSetup,100);

				  //_super.addError(DEFINE.JS_ERROR_NO_BRAINTREE);

				  return false;

			  }



		

			   braintree.setup(DEFINE.BRAINTREE_JS_KEY, "custom", {

				  id: DEFINE.ID_BRAINTREE_FORM,

				  onPaymentMethodReceived: _this.receivePaymentNonce,

				  onReady: function(data){

					  //console.log('braintree ready');

					  return true;

				  },

				  onError: function(data){

					  //posssibly check these errors

					  //console.log('credit error');

					 $('.footer_words','#checkout-page').text('Place Order');

					 $('.main_footer','#checkout-page').attr('data-function','place_order');

					  _super.addError(data.message);

					  return true;

				  },

				  hostedFields: {

					number: {

					  selector: "#"+DEFINE.ID_BRAINTREE_CREDIT_CARD,

					  placeholder: "Credit Card Number"

					},

					expirationMonth: {

					  selector: "#"+DEFINE.ID_BRAINTREE_MONTH,

					  placeholder: "Month"

					},

					expirationYear: {

					  selector: "#"+DEFINE.ID_BRAINTREE_YEAR,

					  placeholder: "Year"

					},

					cvv: {

					  selector: "#"+DEFINE.ID_BRAINTREE_CVV,

					  placeholder: "On the back"

					},

					onFieldEvent: _this.onEvent,

					styles:{

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

							}

					

				  }

				});

				return true;

		  };

		  

		  

		  _this.receivePaymentNonce=function(data){

			  //console.log(data);

			  if(data.nonce){

				  _super.Link.braintree_nonce=data.nonce;

				  _super.sendLink(DEFINE.KEY_PLACEORDER);

				  return true;

			  }else{

				  _super.addError('Error please try again');

				  return false;

			  }

			  

		  };

		  

	  

		  

		  _this.onEvent = function(event){

			  if (event.type === "focus") {

	  

			  } else if (event.type === "blur") {

	  

			  } else if (event.type === "fieldStateChange") {

				//console.log(event.isValid); // true|false

				if (event.card) {

				  //console.log(event.card.type);

				  // visa|master-card|american-express|diners-club|discover|jcb|unionpay|maestro

				}

			  }	

			  return true;	

		  };

		  

	

		  

		  

	  // end of credit card	

	  };

	  

