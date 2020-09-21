<script type="text/javascript"  src="js/touch.js"></script>

<script type="text/javascript" src="js/Master.js?v=1.1" ></script>

<script>



function BeginJs(){

	if(typeof Fooddudesdelivery === 'undefined' || typeof $ === 'undefined') {

		//console.log('loading deliverhopsdelivery...');

		setTimeout(BeginJs,33);

		return false;

	}

	//console.log('deliverhopsdelivery loaded');

	window.ohm={};

	ohm= new Fooddudesdelivery();

	ohm.initilize('<?php $this->printJsonInit() ?>'); 

	

}




$(document).ready(function(e) {

    function receiveMessage(event)

	{

			//console.log('got event at base');

			

			 if(event.origin!='http://localhost' && event.origin!='<?php echo $this->Config['restaurant_url']; ?>' ){

				//console.log('not us');

				return;

			}

			//console.log( event.origin);

			window.send_to = event.source;

			window.send_from = event.origin;

			//console.log( window.send_to,'gotit');

			if(event.origin!='http://localhost'){

				event.source.postMessage("msg",event.origin);

			}

			

	}

	window.addEventListener("message", receiveMessage, false);

});



$( document ).bind( "pageshow", function( e, data ) {



if(data.toPage[0].id=='delivery-contact-page'){
	console.log(ohm.Config);
		if(ohm.Config.delivery.active && !ohm.Config.pickup.active ){
			setTimeout(mapStuff,1500);
		}else{
			mapStuff();
		}
		


}



});

function mapStuff(){
			var mapDiv = document.getElementById("gmap");

			var latlng = new google.maps.LatLng(ohm.Config.restaurant_coordinates.lat, ohm.Config.restaurant_coordinates.lng);

			var mapOptions = 

			{

				zoom: 15,

				center:latlng,

				//backgroundColor: '#ff0000',

				mapTypeId: google.maps.MapTypeId.ROADMAP,

				//imageDefaultUI: true

			};

			window.Mainmap = new google.maps.Map(mapDiv, mapOptions);

			var marker = new google.maps.Marker({

			  position: latlng,

			  map: Mainmap,

			  title: ohm.Config.restaurant_name

			});
	
}

$(document).ready(function(e) {
    $('.header_switch').click(function(){
		$('.header_switch').removeClass('header_active');
		$(this).addClass('header_active');
		$('.toggletime').hide();
		$($(this).attr('data-show')).show();
	});
});



</script>

