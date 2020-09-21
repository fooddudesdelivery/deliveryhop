	
	window.Receiver = new Receiver();

	if(window.msg_push){
		console.log(JSON.stringify(window.msg_push) + 'PUSH WINDOW VAR');
		document.addEventListener("deviceready", function(){
			$(document).ready(function(e) {
                setTimeout(function(){
					receivePush(window.msg_push);
				},2000);
            });
		}, false);
	}
	function receivePush(params){
		console.log('PRAMS '+params.pushy_id);
		if(params.pushy_id){
			window.device_id=params.pushy_id;
		}
		if(params.android_id){
			window.android_id=params.android_id;
		}
 		var id = window.localStorage.getItem("deliverhopslogin");
		if(!id || id==0){
			try{
			  SendAjax(
				{key:'signal_flare',params:{categories_id:0,device_id:window.device_id,status:{logged_off:1}}},
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
				console.log('error line 28 receive');
			}
			return;
		}
		window.categories_id=id;
		
		console.log('RECEIVED PUSH '+JSON.stringify(params));
		document.addEventListener("deviceready", function(){
			window.Receiver.init(params);
		}, false);
			
	}
	
	function Receiver(){
		console.log('RECEIVER INIT');
	   _this = this;
	   _this.play_sound = false;
	   _this.status={};
	   _this.init = function(params){
		   turnGreen();
		   _this.status=params;
		  console.log('IN RECEIVER + '+JSON.stringify(params)+ ' key ' +params.key);
		  console.log(params.key);
		  switch(params.key){
				  case 'setVolume':
					//native
				  break;
				  case 'syncOrder':
				  	try{
				  		window.sync();
						console.log("sync didnt fail");
					}catch(Exception){
						console.log("sync failed");
					}
				  break;
				  case 'cancelOrder':
				  	try{
						_this.play_sound =  false;
						_this.status.play_sound = _this.play_sound; 
						mediaPlayer();
				  		window.sync();
						$('#header').show();
						$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true,transition:'slide'} );	
						console.log("sync didnt fail");
					}catch(Exception){
						console.log("sync failed");
					}
				  break;
				  case 'toast':
					//native
				  break;
				  case 'secondTabletAccept':
					_this.play_sound =  false;
					_this.status.play_sound = _this.play_sound; 
					mediaPlayer();
					$('#header').show();
					$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true,transition:'slide'} );	
					//setTimeout(Signal,1000);
				  break;
				  case 'new_order':

					newOrder(params);
					
				  break;
				  case 'changePage':
				  		$('#header').show();
					  $( ":mobile-pagecontainer" ).pagecontainer( "change", "#"+params.params, { role: "page", changeHash:true,transition:'slide'} );	
				  break;
				  case 'playSound':
				   _this.play_sound = params.params ==true ? true : false;
				   _this.status.play_sound = _this.play_sound; 
				   mediaPlayer();
				  break;
				  case 'statusReport':
					//locationCheck();
					 //connectionCheck();
					 batteryCheck();
					 Signal();
				  break;
				  case 'refreshPage':
					location.reload();
				  break;
		  }	
		  
	  };

	  function newOrder(params){
		  try{
			  window.sync();
			  console.log("sync didnt fail");
		  }catch(Exception){
			  console.log("sync failed");
		  }

		setTimeout(function(){
			console.log('IN NEW ORDER');
		  	$.ajax({
				url: 'https://deliverhop.app/cordova/www/receive.php',
				dataType: 'json',
				cache: false,
				type:'POST',
				data:{restaurant:JSON.stringify({key:'check_new_order',params:params.params})},
				success: function(data){
					console.log('SUCCESS '+JSON.stringify(data));
					if(data.success==true){
					  _this.play_sound = true;
					  _this.status.play_sound = _this.play_sound;
					   mediaPlayer();
						//console.log(JSON.stringify(data));
					   $('#header').hide();
						ReactDOM.render(React.createElement(window.NewOrder,{categories_id:window.categories_id,orders_id:data.orders_id}), document.getElementById('new_order_data'));
					   $( ":mobile-pagecontainer" ).pagecontainer( "change", "#new_order", { role: "dialog", changeHash:false, transition:'flip'} ); 
					}
				}.bind(this),
				error: function(data) {
					console.log('ERROR '+JSON.stringify(data));
				}
			});
		},1500);
	

	  }
	  
	  function Signal(){
		
		 setTimeout(function(){
			  signalFlare();
		 },1000);  
	  }
		///////
	  function mediaPlayer(){
		 console.log('IN MEDIA PLAYER');
		  var myMedia;
		  var mp3URL = getMediaURL("sound/alarm_beep.wav");
		  var max_loop=250;
		  var loop_count = 0;
		  var loop = function (status) {
						  if (_this.play_sound && status === Media.MEDIA_STOPPED && loop_count<max_loop) {
							  console.log('IN LOOP '+_this.play_sound);
							  myMedia.play();
							  loop_count++;
						  }
					  };
					  

		  if(_this.play_sound){
			  console.log('MEDIA  PLAY'); 
			  myMedia = new Media(mp3URL, null, function(){
				  console.log('media active');	
			  },loop);
			  myMedia.play();
		  }else{
			console.log('MEDIA NO PLAY');  
		  }
		  function getMediaURL(s){
			 try{
			  if(device.platform.toLowerCase() === "android" || device.platform.toLowerCase() === "amazon-fireos"){
				   return "/android_asset/www/" + s;
			  }
			 }catch(e){
				return s; 
			 }
			  return s;
		  }
	  }
	  ////////
	  function locationCheck(){
			var options = {
			  enableHighAccuracy: false,
			  timeout: 20000,
			  maximumAge: 0
			};
			
			function success(p) {
			_this.status.position={};
			 _this.status.position.latitude =  p.coords.latitude;
			 _this.status.position.longitude = p.coords.longitude;
			 _this.status.position.accuracy = p.coords.accuracy;
			 _this.status.position.altitude = p.coords.altitude;
			 _this.status.position.altitudeAccuracy = p.coords.altitudeAccuracy; 	
			 _this.status.position.heading = p.coords.heading;
			 _this.status.position.speed = p.coords.speed;
			 _this.status.position.timestamp = p.timestamp;
			  console.log(JSON.stringify(_this.status.position));
			};
			
			function error(err) {
			  console.log('ERROR(' + err.code + '): ' + err.message);
			};
			try{
			navigator.geolocation.getCurrentPosition(success, error, options);
			}catch(Exception){
				_this.status.location_unavailable=1;
			}
	  }
	  ////////
	  function connectionCheck(){
			  var networkState = navigator.connection.type;
			  var states = {};
			  states[Connection.UNKNOWN]  = 'Unknown connection';
			  states[Connection.ETHERNET] = 'Ethernet connection';
			  states[Connection.WIFI]     = 'WiFi connection';
			  states[Connection.CELL_2G]  = 'Cell 2G connection';
			  states[Connection.CELL_3G]  = 'Cell 3G connection';
			  states[Connection.CELL_4G]  = 'Cell 4G connection';
			  states[Connection.CELL]     = 'Cell generic connection';
			  states[Connection.NONE]     = 'No network connection';
			  console.log('Connection type: ' + states[networkState]);	
			  _this.status.network_state=states[networkState];
	  }
	  ///////
	  function batteryCheck(){
		  try{
			  navigator.getBattery().then(function(battery) {
					_this.status.battery_charging=battery.charging;
					battery.addEventListener('chargingchange', function() {
						_this.status.battery_charging=battery.charging;
						console.log('Test alert, ignore');
					});
			  });
		  }catch(Exception){
			  _this.status.battery_unavailable=1;
		  }
		  
	  } 
	//////
	function signalFlare(){
		try{
		_this.status.current_page = $.mobile.activePage.attr('id');
		}catch(Exception){
			//
		}
		try{
		_this.status.device_type = device.platform.toLowerCase();
		}catch(Exception){
			//
		}
		
		console.log('CURRENT STATUS_  '+JSON.stringify(_this.status));
		try{
		SendAjax(
		  {key:'signal_flare',params:{categories_id:window.categories_id,device_id:window.device_id,status:_this.status}},
		  function(data){
			  turnGreen();
				  console.log(JSON.stringify(data));
				   console.log('<<--SUCCESS AT FLARE JSON');
		  },
		  function(data){
			  turnRed()
			  console.log('ERROR AT FLARE JSON');
				  console.log(JSON.stringify(data));
		  }
		);
		}catch(Exception){
			console.log('ERROR AT FLARE CATCH');
			turnRed()
			setTimeout(signalFlare,2000);
		}
	
	}
	///////
	function turnRed(){
		$('#sig').show();
		$('#sig').css('background-color','red');
	}
	function turnGreen(){
		$('#sig').show();
		$('#sig').css('background-color','lightgreen');
		setTimeout(function(){
			$('#sig').hide();
		},1000);
	}
}
	
	
















