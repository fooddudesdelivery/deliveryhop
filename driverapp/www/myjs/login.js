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
		
		$(document).on('click','#logoutbtn',function(){
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

			$('#mainPanel').panel().show();
			$('#header').toolbar().show();
			
			init();
			console.log(' LOGGED IN ' );
		}
		
		var id = 0;
		if(window.isphone){
 			id = window.localStorage.getItem("deliverhopslogin");
		}else{
			id = getCookie('deliverhopslogin');
		}
		console.log(id+' CATEGORIES ID' );

		if(parseInt(id) > 0){
	
				window.admin_id=id;
				$.mobile.initializePage();
				logged_in();

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
					url: 'https://deliverhop.app/driverapp/www/ajax.php',
					dataType: 'json',
					cache: false,
					type:'POST',
					data:{login:JSON.stringify(data)},
					success: function(data){
						//$('#circularG').hide();
						console.log(JSON.stringify(data)+' JSON RETURN');
						if(data.success==true){
							if(window.isphone){
								window.localStorage.setItem("deliverhopslogin", data.admin_id);
							}else{
								setCookie('deliverhopslogin',data.admin_id,99);
							}
							window.admin_id=data.admin_id;
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

