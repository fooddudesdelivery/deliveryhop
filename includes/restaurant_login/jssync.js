var Zojo = function ()
	{
		var Z = this;
		Z.send_method_code=1000;
		Z.orders_id=94706 ;
		Z.adjustment=0;
		Z.payment_code='';
		Z.orders_comment='';
		Z.orders_status=0;
		Z.orders_status_name='';
		Z.adjustment_limit=.2;
		Z.debug=true;
		Z.time_sync='';
		Z.cloud_print_id='';
		Z.function_trace=[];
		Z.orders={};
		Z.categories_id=0;
		Z.data=JSON.stringify({action:'sync'});
		Z.page_id='current-orders';
		//Z.slide_toggle_rate=200;
		Z.sync_rate=8000;
		if(window.Android){
			Z.is_android=true;
		}else{
			Z.is_android=false;	
		}
			
			
		
			Z.set_orders_status_name=function(orders_status_name){
				
				Z.orders_status_name=JSON.parse(orders_status_name);
				
			}
		
			Z.set_orders = function (orders_object){
				Z.orders=JSON.parse(orders_object);
			};
			
			Z.click_handle = function(e){
				Z.function_trace.push('click_handle');

					var class_list = e.classList;
					var class_length = class_list.length;
					var click_action='';

					for(var i =0;i<class_length;i++){
						if(click_action!=''){
							break;
						}
							switch(class_list[i]){
								case 'z_order':
									var unwrap = e.id.split('-');
									Z.orders_id = unwrap[0];
									click_action = unwrap[1];
									break;
								case 'z_function':
									click_action = e.id;
									break;
								//case 'z_drop':
//									click_action = 'dropdown';
//									break;
								case 'z_nav_select':
									click_action = 'nav_select';
									break;
							}
						
					}
					if(click_action!=''){
						switch(click_action){
//							case 'screen_refresh':
//								Z.screen_refresh();
//								break;
							case 'reprint':
								//Z.reprint();
								break; 
							case 'toggle_price_modal':
								Z.toggle_price_modal(e);
								break;
							//case 'dropdown':
//								Z.dropdown(e);
//								break;
							case 'nav_select':
								Z.nav_select(e);
								break;
						}		
					}

			};
			Z.set_categories_id = function (categories_id){
				Z.categories_id=categories_id;
			};
			Z.set_sync_rate = function (sync_rate){
				Z.sync_rate=sync_rate;
			};
			Z.set_send_method_code = function (send_method_code){
				Z.send_method_code=send_method_code;
			};
			Z.set_cloud_print_id = function (cloud_print_id){
				Z.cloud_print_id=cloud_print_id;
			};
			
			Z.change_date=function(start_date,end_date){				
				Z.sync_data({start_date:start_date,end_date:end_date,action:'change_page',page:'past'});
				Z.send();
			};
			
			
			Z.nav_select=function(e){
				$('.nav-bar-btn').removeClass('active');
				$(e).addClass('active');
				$('#navbar').removeClass('in');

				var tmp = Z.page_id;
				Z.page_id=e.id;

				switch(Z.page_id){
					case 'current-orders':
						$('#time-select').hide();
						Z.sync_data({action:'change_page',page:'current'});
						//if(tmp=='current-orders' && e.id=='current-orders'){
						//	Z.android_input('display','Refresh');	
						//}
						break;
					case 'past-orders':
						$('#time-select').show();
						Z.sync_data({action:'change_page',page:'past'});
						break;
				}
				Z.send();
			};
			Z.toggle_price_modal = function(e){
				if(Z.orders[Z.orders_id].payment_module_code=='paypalwpp'){
					$('#price-modal-alert').text('This is a paypal order and the price cannot be modified');
					$('#price-modal-alert').show();
				}else{
					$('#price-modal-alert').text('');
					$('#price-modal-alert').hide();
				}
				if(Z.orders[Z.orders_id].adjustment==0){
					$('#adjustment-input').attr('placeholder','0');
				}else{
					$('#adjustment-input').val(Z.orders[Z.orders_id].adjustment);
				}
				
				$('#modal-order-number').text(Z.orders_id);
				$('#price-modal').modal('show');
				
			};
//			Z.dropdown = function(e){
//				$($(e).attr('data-drop-z')).slideToggle(Z.slide_toggle_rate);
//				
//			}
			Z.screen_refresh=function(){
				if(Z.is_android){
					Z.android_input('reload');
				}else{
					location.reload();
				}

			};
			
			Z.o=function(data){
				Z.function_trace.push('o');
				//if(Z.debug){
					//console.log(data);
				//}
			};
			Z.trace = function(){
				Z.o(Z.function_trace);
				
			},
		
		
			Z.send = function ()
			{
				Z.function_trace.push('send');
				$.ajax({
					type: 'POST',
					dataType:'JSON',
					url: "restaurant_index.php",
					data: {sync:Z.data}
				})
				.done(Z.receive);
				Z.sync_data({action:'sync'});
			};
		
			Z.sync_data = function (json){
				Z.function_trace.push('sync_data');
				Z.data = JSON.stringify(json);
			}
			
			
			Z.receive = function (transfer)
			{
				
				//console.log('VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV');
				//console.log("RECEIVING TRANSMISSION");
				//console.log(Z);
				//console.log(JSON.stringify(Z));
			//remove_restaurant_panel
			//add_restaurant_panel
			//error_message
			//success_message
			//orders_status
			//sync_test
			//console.log(JSON.stringify(transfer));
			//console.log('TRANSFER....'+JSON.stringify(transfer));
			if(transfer.action){
				//console.log(transfer);
				Z.function_trace.push('receive');
				Z.transfer = transfer;
				
				//transfer.action.push('add_restaurant_panel');
				//transfer.action.push('remove_restaurant_panel');
				//var keys = Object.keys(transfer);
				
				var key_length = transfer.action.length;
				//console.log('KEYS-->>'+JSON.stringify(transfer.action));
				//Z.android_input('display','KEYS-->>'+JSON.stringify(transfer.action));
				for(var i=0;i<key_length;i++){
					//console.log('ACTION-->>'+transfer.action[i]);
					switch(transfer.action[i]){
						case 'remove_restaurant_panel':
							Z.remove_restaurant_panel();
							break;
						case 'add_restaurant_panel':
							Z.add_restaurant_panel();
							
							break;
						case 'add_orders_object':
							Z.add_orders_object();
							break;
						case 'sync_orders_status':
							Z.sync_orders_status();
							break;
						case 'price_change_return':
							location.reload();
							break;
						case 'success_message':
							Z.success_message();
							break;
						case 'error_message':
							Z.error_message();
							break;
						case 'sync_test':
							if(Z.transfer.sync_test){
								console.log('Sync Success');
							}
							break;
					
					}
				}
				}
				if(Z.time_sync){
					clearTimeout(Z.time_sync);
				}
				//console.log("END OF TRANSMISSION");
				//console.log('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
				Z.time_sync = setTimeout(Z.send,Z.sync_rate);
			};
			
			
			
			
			Z.remove_restaurant_panel =function(){	
			console.log('REMOVE_PANEL-->>'+JSON.stringify(Z.transfer.remove_restaurant_panel));

				if(Z.page_id=='current-orders'){
				var remove_length=Z.transfer.remove_restaurant_panel.length;
				console.log('IN CURRENT ORDERS....');
				for(var i=0;i<remove_length;i++){
					console.log(Z.transfer.remove_restaurant_panel[i]+'-->>REMOVE BEGIN');
					$('#'+Z.transfer.remove_restaurant_panel[i]+'-main-panel').remove();
					delete Z.orders[Z.transfer.remove_restaurant_panel[i]];
					console.log(Z.transfer.remove_restaurant_panel[i]+'-->>REMOVE COMPLETED');
				}
				}
				console.log('--END OF REMOVE_RESTAURANT_PANEL--');
			};
			
			Z.add_restaurant_panel =function(){
				
				//Z.transfer.add_restaurant_panel='<div id="77-main-panel" class="btn btn-default">x</div>';
				console.log('START-->>ADD_PANEL-->>'+JSON.stringify(Z.transfer.add_restaurant_panel));
				
				if(Z.page_id=='current-orders'){
					console.log('IN_CURRENT_ORDERS');
					if(Z.is_android){
						console.log('IS_ANDROID');
						Z.android_input('reload');
					}
					// TODO remove this ^^
					$('#main_order_container').append(Z.transfer.add_restaurant_panel);
					console.log('ADD_PANEL-->>ADDED');
				}else{
					console.log('IN_PAST_ORDERS');
					if(Z.transfer.dont_sound){
						$('#main_order_container').html(Z.transfer.add_restaurant_panel);
					}
					
				}
				console.log('--END OF ADD_RESTAURANT_PANEL --');
			};
			
			Z.add_orders_object = function(){
				console.log('START-->>ADD_OBJECT-->>'+JSON.stringify(Z.transfer.add_orders_object));
				var play_sound = false;
				for (var key in Z.transfer.add_orders_object){
					if(!Z.transfer.add_orders_object[key].order_is_accepted){
						play_sound=true;
					}
                }
				if(!Z.transfer.dont_sound && play_sound){
						Z.play_sound();
				}
				$.extend(Z.orders,Z.transfer.add_orders_object);

				console.log('--END OF ADD_OBJECT --');
			};
			
			Z.sync_orders_status =function(){
				console.log('SYNC_STATUS-->>'+JSON.stringify(Z.transfer.sync_orders_status));
				var status_length = Z.transfer.sync_orders_status.length;
				for(var i=0;i<status_length;i++){
					var status_div = $('#'+Z.transfer.sync_orders_status[i].orders_id+'-orders_status');
					status_div.text(Z.orders_status_name[Z.transfer.sync_orders_status[i].orders_status]);
					status_div.css('color','#ef6f00');
					console.log(Z.transfer.sync_orders_status[i].orders_id+'-->>SYNC_STATUS');
					setTimeout(function(){
						status_div.css('color','black');
					},2000);
				}
			};
		
			Z.success_message =function(){
				//console.log('PHP-->>'+JSON.stringify(Z.transfer.success_message));
				//Z.android_input('display',Z.transfer.success_message.toString());
				//Z.o(Z.transfer.success_message);
			};
			Z.error_message =function(){
				Z.o(Z.transfer.error_message);
			};
			
			Z.sync_test = function()
			{
				Z.function_trace.push('sync_test');
				Z.sync_data({action:'sync_test'});
				Z.send();
				console.log('Sent sync test');
			};
			
			Z.set_orders_id = function (orders_id){
				Z.function_trace.push('set_orders_id');
				console.log(orders_id);
				Z.orders_id=orders_id;
				
			};
			
			Z.reprint = function (){
				console.log('reprint');
				Z.function_trace.push('reprint');
				Z.sync_data({action:'reprint',orders_id:Z.orders_id});
				if(Z.send_method_code[2]==1){
					Z.cloud_print();
				}
				Z.send();
			};
			
			Z.cloud_print = function (){
				console.log('reprint');
				Z.function_trace.push('cloud_print');
				$.ajax({
				type: 'POST',
				url: "restaurant_index.php",
				data: {sync:JSON.stringify({action:'invoice',orders_id:Z.orders_id})},
				dataType: 'json',
				error: function(){
					Z.error_message('Error please try again');
				},
				success: function(data){
					var message = window.btoa(unescape(encodeURIComponent(data.invoice)));
						$.ajax({
							type: 'POST',
							url: "aAsd23fadfAd2565Hccxz/cloud.php",
							data: { order_info_cloud:message,categories_id:Z.categories_id,orders_id:Z.orders_id},
							dataType: 'text',
							error: function(){
								r_alert_show_hide('Error please try again');
							},
							success: function(invoice){
								if(data=='sent'){
									Z.android_input('display','Printing...');
								}else{
									
								}
								
							}
						});
				}
				});	
			}
			
			Z.set_orders_comment = function(orders_comment){
				Z.function_trace.push('set_orders_comment');
				Z.orders_comment=orders_comment;
				
			};
			
			Z.set_adjustment= function(adjustment){
				Z.function_trace.push('set_adjustment');
				Z.adjustment=adjustment;
				
			};
			
			Z.set_payment_code= function(payment_code){
				Z.function_trace.push('set_payment_code');
				Z.payment_code=payment_code;
				
			};
			
			Z.price_change = function (){
				Z.function_trace.push('price_change');
				
				if(Z.orders_comment==''){
					Z.error_message('Please enter a reason for the price change before you save');
					return;
				}
				if(isNaN(Z.adjustment)){
					Z.error_message('Please enter a number');
					return;
				}
			
				if(Z.orders[Z.orders_id].payment_module_code=='paypalwpp'){
					Z.error_message('This is a paypal order and the price cannot be modified');
					return;
				}
				var adj = $('#adjustment-input').val();
				Z.adjustment=adj;
				
				
				Z.sync_data({action:'change_restaurant_adjustment',orders_id:Z.orders_id,adjustment:Z.adjustment,orders_comment:Z.orders_comment});
				Z.send();
		    };
	
		Z.error_message =function(txt){
			Z.function_trace.push('error_message');
			
			if(Z.is_android){
					Z.android_input('display',txt.toString());
			}else{
					if(!window.modal_error){
						$('#price-modal-alert').text(txt);
						$('#price-modal-alert').hide();
						$('#price-modal-alert').slideToggle(200);
						window.modal_error = setTimeout(function(){
							$('#price-modal-alert').slideToggle(200);
							delete window.modal_error;
						},5000);
					}
			}
			  
		};
		//
		
		Z.play_sound = function () {
			Z.function_trace.push('play_sound');
			if(Z.is_android){
				Z.android_input('start');
				return;
			}


			try{
				window.timer = setInterval(function(){
					document.getElementById('rocknroll').play();
				},500);
				setTimeout(function(){
					clearTimeout(window.timer);
				},30000);
			}catch(e){	
			console.log(e);
			}
		};
		Z.logout = function(){
			if(Z.is_android){
				//Z.android_input('logout');
				window.location.replace("https://staging.fooddudesdelivery.com/restaurant_index.php?logout=1");
			}else{
				window.location.replace("https://staging.fooddudesdelivery.com/restaurant_index.php?logout=1");
			}
		};
		
		Z.android_input=function(string,message) {
			Z.function_trace.push('android_input');
			message = typeof message !== 'undefined' ?  message : '';
			if(Z.is_android){
				window.Android.receive_input(string,message);
			}
		};
		Z.set_orders_status=function(orders_status){
			Z.function_trace.push('set_orders_status');
			Z.orders_status=orders_status;
			
		};
		Z.change_orders_status=function(){
			Z.function_trace.push('change_orders_status');
			
			$('#confirm-'+Z.orders_id).hide();
			$('#'+Z.orders_id+'-adjust_btn').show();
			Z.sync_data({action:'change_orders_status',orders_id:Z.orders_id,orders_status:Z.orders_status});
			Z.send();
			if(window.Android){
				window.Android.receive_input('display','Order Accepted');
			}
			
		};
		
Z.modify_adjustment = function(id){

		Z.function_trace.push('modify_adjustment');
		if(id=='increase-total'){

			var adj_amount = 1;
		}else if(id=='decrease-total'){
			var adj_amount = -1;
		}
		
		var old_total = parseFloat(Z.orders[Z.orders_id].orders_total);
		console.log(Z.orders[Z.orders_id].adjustment);
		Z.adjustment = Z.orders[Z.orders_id].adjustment+adj_amount;
		console.log(Z.adjustment);
		
		var abosolute =Z.adjustment/(old_total);
		console.log(old_total);
		if(abosolute > Z.adjustment_limit && id=='increase-total'){
			Z.adjustment = Z.adjustment-1;
				Z.error_message('You cannot increase the order anymore');

				

			return false;
		}else if(abosolute*-1 > Z.adjustment_limit && id=='decrease-total'){
			Z.adjustment=Z.adjustment+1;
			Z.error_message('You cannot decrease the order anymore');
			return false;
		}else{
			
			Z.orders[Z.orders_id].adjustment=Z.adjustment;
			$('#adjustment-input').val(Z.adjustment.toFixed(2));
			$('#adjustment-input').attr('data-adjustment',Z.adjustment);
			return true;
		}
	}
		
};// EOCLASS
	
	
z_ = new Zojo();