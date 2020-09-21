	
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
		
/*		$(document).on('click','#logoutbtn',function(){
				
					  if( window.isphone ) {
						  if(window.device_id){
							  SendAjax({key:'logout',params:{device_id:window.device_id}},function(){
								  console.log('new_Way');
								  window.localStorage.setItem("deliverhopslogin", 0);
								  location.reload();
							  });
						  }
						  
					  }else{
						  setCookie('deliverhopslogin',0,99);
						  location.reload();
					  } 
					  
		}); */

$(document).delegate('#logoutbtn', 'click',function() {			
    if( window.isphone ) {
        if(window.device_id){
            SendAjax({key:'logout',params:{device_id:window.device_id}},function(){
                console.log('new_Way');
                window.localStorage.setItem("deliverhopslogin", 0);
                location.reload();
            });
        }
    } else {
        setCookie('deliverhopslogin', 0, 99);
        location.reload();
    } 
});

	});
	function onBrowserReady(){
		window.device_id=0;
		bindLogin();
	}
	function onDeviceReady(){
		
		var prefs = plugins.appPreferences;
		prefs.fetch (
		function(id){
			window.device_id=id; 
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
				data.device_id=window.device_id;

				console.log('DATA '+JSON.stringify(data));
				//$('#circularG').show();
				$.ajax({
					url: 'https://deliverhop.app/cordova/www/ajax.php',
					dataType: 'json',
					cache: false,
					type:'POST',
					data:{login:JSON.stringify(data)},
					success: function(data){
						//$('#circularG').hide();
						console.log(JSON.stringify(data)+' JSON RETURN');
						if(data.success==true){
							if(window.isphone){
								window.localStorage.setItem("deliverhopslogin", data.categories_id);
								window.localStorage.setItem("admin_id", data.admin_id);
							}else{
								setCookie('deliverhopslogin',data.categories_id,99);
								setCookie('admin_id',data.admin_id,99);
							}
							window.admin_id=data.admin_id;
							window.categories_id=data.categories_id;
							$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true} );	
							logged_in();
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

