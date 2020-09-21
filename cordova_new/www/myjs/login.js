	
	window.onerror = function(msg, url, line, col, error) {
	   // Note that col & error are new to the HTML 5 spec and may not be 
	   // supported in every browser.  It worked for me in Chrome.
	   
	   var extra = !col ? '' : ' column: ' + col;
	   extra += !error ? '' : ' error: ' + error;
		var err="JAVASCRIPT Error: " + msg + " url: " + url + " line: " + line + extra;
	   // You can view the information in an alert to see things working like this:
	   console.log(err);
		if(msg.search("receivePush")!=-1){
		   return true;
	   }
	   // TODO: Report this error via ajax so you can keep track
	   //       of what pages have JS issues
	   if(window.device_id){
		   try{
		    SendAjax(
				{key:'signal_flare',params:{categories_id:0,device_id:window.device_id,status:{fatal_error:err}}},
				function(data){
					//turnGreen();
						console.log('LOGGED OFF success'+JSON.stringify(data));
				},
				function(data){
					//turnRed()
						console.log('LOGGED OFF error '+JSON.stringify(data));
				}
			  );
		   }catch(Exception){
			   
		   }
	   }
		alert('There has been an error, refreshing');
		location.reload();
	   var suppressErrorAlert = true;
	   // If you return true, then error alerts (like in older versions of 
	   // Internet Explorer) will be suppressed.
	   return suppressErrorAlert;
	};
	
	 function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}
	
	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
		}
		return "";
	}
	$(document).ready(function() {
		// window.device_id=window.localStorage.getItem("device_id");
		window.device_id=getCookie("device_id");
		// are we running in native app or in a browser?
		function reversePush(){
			var cat_id = window.localStorage.getItem("deliverhopslogin");
			if(!cat_id || cat_id ==0){
				return;
			}
			if(window.android_id){
				//return;
			}
			var d = new Date();
			var n = d.getHours();
			//var gol=false;
			//if(n>9 && n <21){
			//	gol=true;
			//}
			//console.log('it is '+n+' so '+gol );
			//gol && 
			
			if(window.device_id){
			  try{
				SendAjax(
				  {key:'reverse_signal_flare',params:{device_id:window.device_id}},
				  function(data){
					  console.log('reverse_signal_flare success'+JSON.stringify(data));
					  if(data.success==false){
						  console.log('SUCCESS IS FALSE RUNNING COMMAND');
						  window.Receiver.init({key:data.command,params:true});
						  //location.reload();
					  }
						  
				  },
				  function(data){
					  //turnRed()
						  console.log('reverse_signal_flare error '+JSON.stringify(data));
				  }
				);
			  }catch(Exception){
	  
			  }
			}
		}
		//setTimeout(reversePush,5000);
		//setInterval(reversePush,133333);
		window.isphone = false;
		if(document.URL.indexOf("http://") === -1 && document.URL.indexOf("https://") === -1) {
			window.isphone = true;
		}
	
		if( window.isphone ) {
			console.log('Is Phone');
			document.addEventListener("deviceready", onDeviceReady, false);
		} else {
			console.log('Is Browser');
			onBrowserReady();
		}
		
		if( window.categories_id>0 ) {
			checkRestaurantStatus();
		}
		
		$(document).delegate('#logoutbtn', 'touchend click',function(){
			if( window.isphone ) {
			  if(window.device_id){
				  SendAjax({key:'logout',params:{device_id:window.device_id}},function(){
					  console.log('new_Way');
					  window.localStorage.setItem("deliverhopslogin", 0);
					  window.localStorage.setItem("admin_id", 0);
					  location.reload();
				  });
			  }
			  
			}else{
				console.log('new_Way');
			  	setCookie('deliverhopslogin',0,99);
			  	setCookie('admin_id',0,99);
			  	location.reload();
			} 
		});


		$(document).delegate('#restaurant-availability', 'touchend click', function(e){
			e.preventDefault();
			// var deviceId = window.localStorage.getItem("device_id");
			if($('#restaurant-availability').hasClass('on')){
				//$("#status-message").html("Please confirm that you'd like to stop taking orders temporarily. You may turn back on and start taking orders again when you are ready or remain off for current day. If you need to be offline longer then today please contact support.");
				$("#status-message").html("Please confirm that you'd like to stop taking orders. You can turn back ON when ready or remain OFF for today. If you need to be OFF longer then today please contact <a data-transition='slide' href='javascript:void(Tawk_API.toggle())'>customer service</a>.");
			}else if($('#restaurant-availability').hasClass('off')){
				$("#status-message").html("Please confirm that you'd like to start taking orders for current day.");
			}

			$('#availability-confirm').modal('show');

		});

		$(document).delegate('#confirm-no', 'touchend click', function(e){
			e.preventDefault();
			$('#availability-confirm').modal('hide');
		});

		$(document).delegate('#confirm-yes', 'touchend click', function(e){
			e.preventDefault();
			toggleRestaurantStatus();
		});

		$(document).delegate('#forgot_password_link', 'touchend click', function(e){
            $('.passwordSection').show();
            $('.loginSection').hide();
            $('#loginerror').hide();
            $('#forgotPasswordsuccess').hide();
            $('#forgotPassworderror').hide();
            $('#forgot_password_email').val('');
        });

        $(document).delegate('#forgot_password_cancel', 'touchend click', function(e){
            $('.passwordSection').hide();
            $('.loginSection').show();
            $('#loginerror').hide();
            $('#forgotPasswordsuccess').hide();
            $('#forgotPassworderror').hide();
        });

        $(document).delegate('#forgot_password_request_reset', 'touchend click', function(e){
            var forgot_password_email = $('#forgot_password_email').val();

            $('#loginerror').hide();
            $('#forgotPasswordsuccess').hide();
            $('#forgotPassworderror').hide();

            if(forgot_password_email.trim() == ''){
                // validate for email
                $('#forgotPassworderror').html('<b>Error! </b> Please Enter Email address!').show();
            } else if(!validateEmail(forgot_password_email)) {
                $('#forgotPassworderror').html('<b>Error! </b> Please Enter Valid Email address!').show();
            } else {
                $.ajax({
                    url: 'https://staging.deliverhop.app/change_password.php?email='+forgot_password_email,
                    dataType: 'json',
                    cache: false,
                    type:'GET',
                    success: function(data){
                        if(data.success==true){
                            $('#forgotPasswordsuccess').html(data.message).show();
                            setTimeout(function(){
                                $('#loginerror').hide();
                                $('#forgotPasswordsuccess').hide();
                                $('#forgotPassworderror').hide();
                                $('.passwordSection').hide();
                                $('.loginSection').show();
                            }, 1300);
                        } else {
                            $('#forgotPassworderror').html('<b>Error! </b> '+data.message).show();
                        }
                    }, error: function(data){
                        $('#forgotPassworderror').html('<b>Error! </b> internal server error please try again later.').show();
                    }
                });
            }
	});
	});

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

	function onBrowserReady(){
		// window.device_id=0;  // Commented because we are getting device id via pushy.me
		bindLogin();

	}
	function onDeviceReady(){
		var prefs = plugins.appPreferences;
		prefs.fetch (
		function(id){
			window.device_id=getCookie('device_id'); //id; 
			console.log('DEVICE ID '+id);
			bindLogin();
			
		}, 
		function(e){
			alert('Error please try again. 8 '+e.toString());
		}, 
		'deliverhops_device_id');
		
	}
	function bindLogin(){
		function logged_in(){
			//$(document).ready(function(e) {
                 //window.init();
            //});
			$('#mainPanel').panel().show();
			$('#header').toolbar().show();
			$('#showTwak').removeClass('hideBlock');
			//$(document).ready(function(e) {
                //init();
           // });
			console.log(' LOGGED IN ' );
			
		}
		
		var id = 0;
		var admin_id = 0;
		if(window.isphone){
 			id = window.localStorage.getItem("deliverhopslogin");
			admin_id = window.localStorage.getItem("admin_id");
		}else{
			id = getCookie('deliverhopslogin');
			admin_id = getCookie('admin_id');
		}
		console.log(id+' CATEGORIES ID' +admin_id);

		if(parseInt(id) > 0){
				//window.location.hash = 'current';
			//if(!window.isphone){
				window.admin_id = admin_id;
				window.categories_id=id;
				$.mobile.initializePage();
				logged_in();
			//}else{
				
			//}
			
		}else{
			console.log(' NOT LOGGED IN ' );
			$('#logincontent').show();
			window.location.hash = 'login';
			$.mobile.initializePage();	
			
			$('#login_btn').click(function(){
				var data={};
				data.password=$('#password').val();
				data.username=$('#username').val();
				data.device_id=getCookie('device_id');

				// console.log('DATA '+JSON.stringify(data));
				//$('#circularG').show();
				$.ajax({
					url: 'https://deliverhop.app/cordova_new/www/ajax.php',
					dataType: 'json',
					cache: false,
					type:'POST',
					data:{login:JSON.stringify(data)},
					success: function(data){
						//$('#circularG').hide();
						// console.log(JSON.stringify(data)+' JSON RETURN');
						if(data.success==true){
							if(window.isphone){
								window.localStorage.setItem("deliverhopslogin", data.categories_id);
								window.localStorage.setItem("admin_id", data.admin_id);

								window.localStorage.setItem('category_name',data.category_name);
								window.localStorage.setItem('category_address',data.category_address);
								window.localStorage.setItem('category_phone',data.category_phone);
								window.localStorage.setItem('category_email',data.category_email);

								window.localStorage.setItem('login_email',data.login_email);
                   				window.localStorage.setItem('report_email',data.report_email);

                   				window.localStorage.setItem('other_restaurants',data.other_restaurants);
                   				window.localStorage.setItem('show_restaurants',data.show_restaurants);
							}else{
								setCookie('deliverhopslogin',data.categories_id,99);
								setCookie('admin_id',data.admin_id,99);

								setCookie('category_name',data.category_name,99);
								setCookie('category_address',data.category_address,99);
								setCookie('category_phone',data.category_phone,99);
								setCookie('category_email',data.category_email,99);

								setCookie('login_email',data.login_email,99);
								setCookie('report_email',data.report_email,99);

								setCookie('other_restaurants',data.other_restaurants,99);
								setCookie('show_restaurants',data.show_restaurants,99);
							}
							window.admin_id=data.admin_id;
							window.categories_id=data.categories_id;
							
							window.category_name = data.category_name;
							window.category_address = data.category_address;
							window.category_phone = data.category_phone;
							window.category_email = data.category_email;

							window.login_email = data.login_email;
                 			window.report_email = data.report_email;

                 			window.other_restaurants = data.other_restaurants;
                 			window.show_restaurants = data.show_restaurants;

							if(window.login_email != ""){
							$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true} );	
							}else{
								$( ":mobile-pagecontainer" ).pagecontainer( "change", "#mysettings", { role: "page", changeHash:true} );
								setTimeout(function(){
									$("#header .ui-title").html("Settings")
								},200);
							}

							//$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true} );	
							logged_in();
							if( window.categories_id>0 ) {
								checkRestaurantStatus();
							}
						}else{
							$('#loginerror').show();
							setTimeout(function(){
								$('#loginerror').hide();
							},10000);	
						}
					},error: function(data){
						alert('Error please try again. 9 '+JSON.stringify(data));
					}
				});
			});
		}
	}


	function toggleRestaurantStatus(){
		$('#availability-confirm').modal('hide');
		var status = 0;
		var data={};
		data.categories_id = window.categories_id;

		if($('#restaurant-availability').hasClass('on')) {          	
	        data.status = 0;
       	} else if($('#restaurant-availability').hasClass("off")){
	        data.status = 1;
        }

        $.ajax({
			url: 'https://deliverhop.app/cordova_new/www/ajax.php',
			dataType: 'json',
			cache: false,
			type:'POST',
			data:{restaurant_status:JSON.stringify(data)},
			success: function(data){
				//$('#circularG').hide();
				// console.log(JSON.stringify(data)+' JSON RETURN');
				if(data.success==true){
					if(data.status==1){
						$('#restaurant-availability').attr('checked', 'checked')
						$('#restaurant-availability').removeClass('off');
						$('#restaurant-availability').addClass('on');
						$('#restaurant-availability').prop('checked', true);
					}else{
						$('#restaurant-availability').removeAttr('checked')
						$('#restaurant-availability').removeClass('on');
						$('#restaurant-availability').addClass('off');
						$('#restaurant-availability').prop('checked', false);
					}
					// alert('Success '+JSON.stringify(data));
				}else{
					// alert('Error '+JSON.stringify(data));
				}
			},error: function(data){
				alert('Error please try again. 9 '+JSON.stringify(data));
			}
		});       
    }

    function checkRestaurantStatus(){
		
		var data={};
		data.categories_id = window.categories_id;
		data.device_id = window.device_id;
		data.admin_id = window.admin_id;

        $.ajax({
			url: 'https://deliverhop.app/cordova_new/www/ajax.php',
			dataType: 'json',
			cache: false,
			type:'POST',
			data:{check_restaurant_status:JSON.stringify(data)},
			success: function(data){
				//$('#circularG').hide();
				// console.log(JSON.stringify(data)+' JSON RETURN');
				if(data.success==true){
					if(window.isphone){
						window.localStorage.setItem('fast_order',data.fast_order);
						window.localStorage.setItem('show_restaurants',data.show_restaurants);
					}else{
						setCookie('fast_order',data.fast_order,99);
						setCookie('show_restaurants',data.show_restaurants,99);
					}
					window.fast_order = data.fast_order;
					window.show_restaurants = data.show_restaurants;

					if(data.fast_order == "0"){
						$("#fastorder").hide();
					}
					if(!data.show_restaurants){
						$("#my_profile").hide();
					}
					
					if(data.status==1){
						$('#restaurant-availability').attr('checked', 'checked')
						$('#restaurant-availability').removeClass('off');
						$('#restaurant-availability').addClass('on');
						$('#restaurant-availability').prop('checked', true);
					}else{
						$('#restaurant-availability').removeClass('on');
						$('#restaurant-availability').addClass('off');
						$('#restaurant-availability').prop('checked', false);
					}
					// alert('Success '+JSON.stringify(data));
				}else{
					// alert('Error '+JSON.stringify(data));
				}
			},error: function(data){
				alert('Error please try again. 9 '+JSON.stringify(data));
			}
		});
    }