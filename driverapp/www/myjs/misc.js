function init(){
	
    function socks(){
	
	  var user_id = window.admin_id;
	  var info_class = ['driver'];
      var socket = io('https://deliverhop.app:3333/');
	  console.log(user_id);
	  console.log(info_class);
	  socket.on('authorize', function(msg){
		socket.emit('authorize',{user_id:user_id,info_class:info_class});
      });
	  
	  socket.on('info_update', function(msg){
		  console.log();
		    msg = JSON.parse(msg);
		  	if(msg.key){
				
				receivePush(msg);
			}	
      });
	}
	socks();
	

	$('#header').append('<div id="ref" href="" class="glyphicon glyphicon-refresh" data-role="button"></div>');
	$('#header').append('<div id="sig" href="" data-role="button"></div>');
	$('#header').append('<div id="charge_alert" class="alert alert-danger alert-dismissible" role="alert"><b>Please plug in the charger</b></div>');
	//addScript('https://deliverhop.app/cordova/www/myjs/socketio.js');
	
	$(document).on('click', '#charge_alert', function () {
		$(this).hide();
	});
	
	try {
		navigator.getBattery().then(function (battery) {
			if (battery.charging == 1) {
				$('#charge_alert').hide();
			} else if (battery.level < 0.2) {
				$('#charge_alert').show();
			}
			battery.addEventListener('chargingchange', function () {
				if (battery.charging == 1) {
					$('#charge_alert').hide();
				} else if (battery.level < 0.2) {
					$('#charge_alert').show();
				}
			});
		});
	} catch (Exception) {}
	//$('body').append('<div class="loader"></div>');
	$(document).on('click', '#ref', function () {
		location.reload();
	});
	$(document).on('click', '.order-action', function () {
		var _this = $(this);
		_this.css('color', '#ef6f00');
		setTimeout(function () {
			_this.css('color', 'black');
		}, 1000);
	});
}