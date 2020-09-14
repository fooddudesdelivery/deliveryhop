var bigarray;
var arrayOfArrays = [];
var arraysize = 60;
var origin;
var mapquest_call_cnt = 0;
var bigResultArray = [];
	
	
	var GoogleProcess =function(){
			'use strict';
			var _this = this;
			_this.autocomplete={};
			_this.customer_place ={};
	  		_this.address_separated={};
			_this.categories_id=[];
			_this.old_routes=[];
			_this.rates=[];
			_this.ranges=[];
			_this.mapquest_error=false;
			_this.mapquest_timeout={};
			
			_this.main_error = 'Sorry, we could not find your address.<br>';
			_this.main_error += 'Enter full address and zip code<br>Remove business name, apartment or suite numbers';
			
			_this.initilize=function() {
				//if(false && typeof google === 'undefined' || typeof google.maps.places === 'undefined') {
				if(false){
				  setTimeout(function(){
					var script='';
					script=document.createElement('script');
					script.type='text/javascript';
					script.src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCQXkXmuVgxtvbM6OmMEZV3oexUfCSb35o&libraries=places,geometry&callback=goog.googleOnload';
					script.async='true';
					document.getElementsByTagName('head')[0].appendChild(script);
				  },1);
				}
				window.onload = function () { 
					console.log('ready to check');
					setTimeout(function(){
						if(typeof google === 'undefined' || typeof google.maps.places === 'undefined') {
							console.log('no google');
							if(window.fooddudestaging_login==1){
								alert('Google error, refreshing');
							}
						  
							location.reload();
						}else{
							console.log('has google');
						}
					},3000);
				}
		
				
			};
			
			_this.addError=function(err){
				console.log(err);
				$('#circularG').hide();
				$('#new_js_error').html(err).slideToggle(200);
				
				//setTimeout(function(){
					//$('#new_js_error').text('').slideToggle(200);
				//},10000);
			};
			_this.googleOnload=function(){
				  if(typeof google === 'undefined' || typeof google.maps.places === 'undefined') {
					  return false;
				  }

				  var main_input =document.getElementById('pac-input');
				 // _this.autocomplete  = new google.maps.places.SearchBox(main_input); google update 3/1/2018
			     // _this.autocomplete  = new google.maps.places.Autocomplete(main_input,{types: ['geocode']});	updated 4/28/2019		 
				 // _this.autocomplete.addListener('places_changed',_this.findCorrectPlaceText); google update 3/1/2018
				    _this.autocomplete  = new google.maps.places.Autocomplete(main_input,{fields: ["name", "geometry.location", "place_id", "formatted_address", "address_components"]});	
				    _this.autocomplete.addListener('place_changed',_this.findCorrectPlaceText); 
				  google.maps.event.addDomListener(main_input, 'keydown', function(e) { 
					  if (e.keyCode === 13 && !$('.pac-item').hasClass('pac-item-selected')) { 
						  $('#pac-input').blur();
						  _this.mainGeocode();
					  }
				  }); 
				  $('#search-btn-txt').click(_this.mainGeocode);
				  $('#search_icon').click(_this.mainGeocode);
				  _this.geolocate();
				  console.log('Google Loaded');
				  //setTimeout(_this.mainGeocode,1000);
				  return true;
			};
			
			
			_this.mainGeocode=function(){
				  var address_text = $('#pac-input').val();
				  //console.log(address_text);
				  if(!address_text){
					 _this.addError('Invalid address. Please enter an address.');
					  return false;
				  }
				  if(window.fooddudestaging_login==1){
					/*   console.log('XXXXXXXXXXXXXXXX');
					  _this.proceedRedirect();
					  return false; */
				  }
				  $.ajax({
					  async:true,
					  dataType:"json",
					  data:{"components":"country:US","address":address_text,key:"AIzaSyDyDkz5mawsvUp6YC6pDU9KZuYx15GLOmU"},
					  url:"https://maps.googleapis.com/maps/api/geocode/json?",
					  type:"GET",
					  success: _this.findCorrectPlaceButton,
					  error: function(data){
						  console.log('ERROR AT GEOCODE',data);
						 _this.addError(_this.main_error);
						  return false;
					  }
				  });
				  //console.log('AFTER AJAC');
				  return true;
			};
	  
			
			_this.findCorrectPlaceButton=function(receive_places){
				console.log('GEOCODE COMPLETE');
				if(receive_places.status!=='OK'){
					console.log(receive_places);
					_this.addError('Sorry we couldnt find your address');
					return false;
				}
				receive_places= receive_places.results;
				if(receive_places.length>0){
					_this.customer_place.lat=receive_places[0].geometry.location.lat;
					_this.customer_place.lng=receive_places[0].geometry.location.lng;
					_this.customer_place.address_components=receive_places[0].address_components;
					_this.customer_place.formatted_address=receive_places[0].formatted_address;
					_this.customer_place.place_id=receive_places[0].place_id;
					_this.processAddress();
					return true;
				}else{
					 _this.addError(_this.main_error);
					  return false;
				}
			};
			
			_this.findCorrectPlaceText=function(){
			  // var receive_places =  _this.autocomplete.getPlaces();  google update 3/1/2018
			   var receive_places =  _this.autocomplete.getPlace();			   
			   //console.log(receive_places);
			   if(receive_places.hasOwnProperty("address_components")){
				   _this.customer_place.lat=receive_places.geometry.location.lat();
				   _this.customer_place.lng=receive_places.geometry.location.lng();
				   _this.customer_place.address_components=receive_places.address_components;
				   _this.customer_place.formatted_address=receive_places.formatted_address;
				   _this.customer_place.place_id=receive_places.place_id;
				   _this.processAddress();
				   return true;
			   }else{
					_this.addError(_this.main_error);
				   return false; 
			   }
			};
			

			
			
			_this.processAddress=function() {
				$('#circularG').show();
				
				if(!_this.validateCustomerPlace()){
					 
					 
					var coun = _this.customer_place.address_components.length;
					var cityname = false;
					for(var c=0; c<coun; c++){
						if(_this.customer_place.address_components[c].types[0]=='locality'){
							cityname = _this.customer_place.address_components[c].long_name;
						}
					}
					if(cityname===false){
						_this.addError(_this.main_error);
						return false;  
					}else{
						cityname = cityname.toLowerCase().replace(/ /g,'');
				
						var citylist = window.city_name_array_from_php.map(function(e){
							return e.toLowerCase().replace(/ /g,'');
						});
						// now 100% more dynamic
						if(citylist.indexOf(cityname)!==-1){
							window.location.href = 'https://staging.fooddudesdelivery.com/'+cityname.toLowerCase().replace(/ /g,'');	
							return true;
						}else{
							_this.addError(_this.main_error);
							return false;
						}
						
					}
					 
				}

			    for (var i = 0; i < _this.customer_place.address_components.length; i++) {
					var addressType = _this.customer_place.address_components[i].types[0];
					  var val = _this.customer_place.address_components[i].long_name;
					  switch(addressType){
						 case 'street_number':
							_this.address_separated.street_number=val;
						 break;
						 case 'route':
							_this.address_separated.street=val;
						 break;
						 case 'subpremise':
							_this.address_separated.apt=val;
						 break;
						 case 'locality':
							_this.address_separated.city=val;
						 break;
						 case 'administrative_area_level_1':
							_this.address_separated.state=val;
						 break;
						 case 'postal_code':
							_this.address_separated.zipcode=val;
						 break;
						 case 'point_of_interest':
						 case 'establishment':
							_this.address_separated.establishment=val;
						 break;
						 default:
							//console.log(val);
						 break;
					}
					
				}
				_this.address_separated.lat=_this.customer_place.lat;
				_this.address_separated.lng=_this.customer_place.lng;
				_this.address_separated.google_place_id=_this.customer_place.place_id;
				_this.getAddressMatrix();
			};

			_this.getAddressMatrix=function(){
				console.log(_this.address_separated);
				//////
				//if(window.fooddudestaging_login==1){
					//var new_send = {"address_info":JSON.stringify(_this.address_separated)};
				//}else{
					var new_send = {"address_info_new":JSON.stringify(_this.address_separated)};
				//}
				//alert($('#pac-inputtest').val().length);
				
				if($('#pac-inputtest').val().length>3){
				setTimeout(function(){
						$.ajax({
						  async:true,
						  dataType:"json",
						  data:new_send,
						  url:"https://staging.fooddudesdelivery.com/location_landing.php",
						  type:"POST",				
						  success: _this.addressMatrixCallback,
						  error: function(data){
							 console.log(data);
							 _this.addError(_this.main_error);
							 return false;
						  }
					  });

				},50);
				}else{
					$('#circularG').hide();
					return false;
				}
				
			};
			_this.addressMatrixCallback=function(data){
				//console.log(data);
				if(data.code){
					switch(data.code){
						case 'closest_city_closed_note':
							_this.addError(data.note);
						break;
						case 'closest_city_closed':
							_this.addError('Sorry '+data.categories_name+' is currently closed please try again later.');
						break;
						case 'mapquest':
							_this.categories_id=data.categories_id;
							_this.old_routes=data.old_routes;
							_this.rates=data.rates;
							_this.ranges=data.ranges;
							_this.mapquest(data.ranges);
						break;	
						case 'all_routes_available':
						$('#circularG').hide(100);
						var customers_lat_lng=[_this.address_separated.lat,_this.address_separated.lng];
                           $.ajax({
								type: 'POST',
								cache: false,
								url: "zm_ajax.php",
								data: {zm_create_address_separated:JSON.stringify(_this.address_separated),routes:JSON.stringify(data.routes),latlng:JSON.stringify(customers_lat_lng)},
								dataType: 'text',
								async:true,
								error: function(data){
									console.log(data);
									_this.addError('Sorry, an unexpected error has occurred please re-enter your address.');
								},
								success: function(data){
									console.log(data);
									_this.proceedRedirect();
								}
							});
     
							
						break;	
						case 'error':
							_this.addError(data.message);
						break;
					}
				}
				
			};
			
			_this.mapquest=function(ranges){
				var json_data = {
					'locations':ranges,
					'options':{'manyToOne':false}
				};
				/*origin = ranges.slice(0,1);
				bigarray = ranges.slice(1,ranges.length);
				for (var i=0; i<bigarray.length; i+=arraysize) {
					var pic_1 = [];
					var pic_2 = [];
					var pic_3 = [];

					pic_1 = origin;

					pic_2 = bigarray.slice(i,i+arraysize);

					pic_3 = pic_1.concat(pic_2);

					arrayOfArrays.push(pic_3)
				}
				console.log("origin");
				console.log(origin);
				console.log("bigarray");
				console.log(bigarray);
				console.log(arrayOfArrays);
				//console.log(_this.address_separated.city);
				alert(_this.address_separated.city);*/
				
				if(_this.address_separated.city=='St. Cloud'||_this.address_separated.city=='Sartell'||_this.address_separated.city=='Waite Park'||_this.address_separated.city=='Saint Joseph'||_this.address_separated.city=='Sauk Rapids'||_this.address_separated.city=='Baxter'||_this.address_separated.city=='Brainerd'||_this.address_separated.city=='Breezy Point'||_this.address_separated.city=='Crosby'||_this.address_separated.city=='East Gull Lake'||_this.address_separated.city=='Ironton'||_this.address_separated.city=='Lake Hubert'||_this.address_separated.city=='Lake Shore'||_this.address_separated.city=='Merrifield'||_this.address_separated.city=='Nisswa'||_this.address_separated.city=='Pequot Lakes'||_this.address_separated.city=='Pillager'||_this.address_separated.city=='Alexandria'||_this.address_separated.city=='Brandon'||_this.address_separated.city=='Carlos'||_this.address_separated.city=='Farwell'||_this.address_separated.city=='Forada'||_this.address_separated.city=='Garfield'||_this.address_separated.city=='Glenwood'||_this.address_separated.city=='Holmes City'||_this.address_separated.city=='Kensington'||_this.address_separated.city=='Lowry'||_this.address_separated.city=='Miltona'||_this.address_separated.city=='Nelson'||_this.address_separated.city=='Osakis'||_this.address_separated.city=='Starbuck'||_this.address_separated.city=='Villard'||_this.address_separated.city=='Duluth'||_this.address_separated.city=='Hermantown'||_this.address_separated.city=='Proctor'||_this.address_separated.city=='Superior'||_this.address_separated.city=='Mankato'||_this.address_separated.city=='North Mankato'||_this.address_separated.city=='Skyline'||_this.address_separated.city=='Eagle Lake'||_this.address_separated.city=='Brooklyn Park'||_this.address_separated.city=='Minneapolis'||_this.address_separated.city=='Blaine'||_this.address_separated.city=='Coon Rapids'||_this.address_separated.city=='Andover'||_this.address_separated.city=='Fridley'||_this.address_separated.city=='Champlin'||_this.address_separated.city=='Mounds View'||_this.address_separated.city=='Maple Grove'||_this.address_separated.city=='Spring Lake Park'||_this.address_separated.city=='New Brighton'||_this.address_separated.city=='Plymouth'||_this.address_separated.city=='Anoka'||_this.address_separated.city=='Ham Lake'||_this.address_separated.city=='Lino Lakes'||_this.address_separated.city=='Circle Pines'||_this.address_separated.city=='Brooklyn Center'||_this.address_separated.city=='Medina'||_this.address_separated.city=='Rogers'||_this.address_separated.city=='New Hope'||_this.address_separated.city=='Osseo'||_this.address_separated.city=='Minnetonka'||_this.address_separated.city=='Hopkins'||_this.address_separated.city=='Corcoran'||_this.address_separated.city=='Dayton'||_this.address_separated.city=='Crystal'||_this.address_separated.city=='Ramsey'||_this.address_separated.city=='Wayzata'||_this.address_separated.city=='Maple Gove'||_this.address_separated.city=='Robbinsdale'||_this.address_separated.city=='Oak Grove'||_this.address_separated.city=='Kandiyohi'||_this.address_separated.city=='Willmar'||_this.address_separated.city=='Pennock'||_this.address_separated.city=='Raymond'||_this.address_separated.city=='Blomkest'||_this.address_separated.city=='West Fargo'||_this.address_separated.city=='Fargo'||_this.address_separated.city=='Moorhead'||_this.address_separated.city=='Dilworth'||_this.address_separated.city=='Oakport'||_this.address_separated.city=='Prairie Rose'||_this.address_separated.city=='Horace'||_this.address_separated.city=='Frontier'||_this.address_separated.city=='Briarwood'||_this.address_separated.city=='Grand Forks'||_this.address_separated.city=='East Grand Forks'||_this.address_separated.city=='Mandan'||_this.address_separated.city=='Bismarck'||_this.address_separated.city=='Lincoln'||_this.address_separated.city=='Rock Haven'||_this.address_separated.city=='Minot'||_this.address_separated.city=='Surrey'||_this.address_separated.city=='Burlington'||_this.address_separated.city=='Ruthville'||_this.address_separated.city=='Sioux Falls'||_this.address_separated.city=='Brandon'||_this.address_separated.city=='Tea'||_this.address_separated.city=='Harrisburg'||_this.address_separated.city=='Ellis'||_this.address_separated.city=='Appleton'||_this.address_separated.city=='Greenville'||_this.address_separated.city=='Grand Chute'||_this.address_separated.city=='Mackville'||_this.address_separated.city=='Freedom'||_this.address_separated.city=='Little Chute'||_this.address_separated.city=='Kimberly'||_this.address_separated.city=='Menasha'||_this.address_separated.city=='Neenah'||_this.address_separated.city=='Harrison'||_this.address_separated.city=='Kaukauna'||_this.address_separated.city=='Green Bay'||_this.address_separated.city=='Little Rapids'||_this.address_separated.city=='De Pere'||_this.address_separated.city=='Chicago Corners'||_this.address_separated.city=='Oneida'||_this.address_separated.city=='Howard'||_this.address_separated.city=='Bellevue'||_this.address_separated.city=='Seymour'||_this.address_separated.city=='Suamico'||_this.address_separated.city=='Ashwaubenon'||_this.address_separated.city=='Pine Grove'||_this.address_separated.city=='Humboldt'||_this.address_separated.city=='Two Rivers'||_this.address_separated.city=='Manitowoc'||_this.address_separated.city=='Clover'||_this.address_separated.city=='Alverno'||_this.address_separated.city=='Shoto'||_this.address_separated.city=='Branch'||_this.address_separated.city=='Norwalk'||_this.address_separated.city=='Cumming'||_this.address_separated.city=='Orilla'||_this.address_separated.city=='West Des Moines'||_this.address_separated.city=='Des Moines'||_this.address_separated.city=='Waukee'||_this.address_separated.city=='Clive'||_this.address_separated.city=='Windsor Heights'||_this.address_separated.city=='Urbandale'||_this.address_separated.city=='Pleasant Hill'||_this.address_separated.city=='Lovington'||_this.address_separated.city=='Johnston'||_this.address_separated.city=='Grimes'||_this.address_separated.city=='Granger'||_this.address_separated.city=='Herrold'||_this.address_separated.city=='Ankeny'||_this.address_separated.city=='Saylorville'||_this.address_separated.city=='Marquisville'||_this.address_separated.city=='Berwick'||_this.address_separated.city=='Enterprise'||_this.address_separated.city=='Norwoodville'||_this.address_separated.city=='Capital Heights'||_this.address_separated.city=='Altoona'||_this.address_separated.city=='Bondurant'||_this.address_separated.city=='North Sioux City'||_this.address_separated.city=='Sioux City'||_this.address_separated.city=='South Sioux City'||_this.address_separated.city=='Dakota City'||_this.address_separated.city=='Sergeant Bluff'||_this.address_separated.city=='Grand Junction'||_this.address_separated.city=='Mack'||_this.address_separated.city=='Lorna'||_this.address_separated.city=='Fruita'||_this.address_separated.city=='Redlands'||_this.address_separated.city=='Glade Park'||_this.address_separated.city=='Orchard Mesa'||_this.address_separated.city=='Clifton'||_this.address_separated.city=='Palisade'||_this.address_separated.city=='Montrose'||_this.address_separated.city=='Olathe'||_this.address_separated.city=='Vernal'||_this.address_separated.city=='Colona'||_this.address_separated.city=='Eldredge'||_this.address_separated.city=='Rapid City'||_this.address_separated.city=='Black Hawk'||_this.address_separated.city=='Green Valley'||_this.address_separated.city=='Rapid Valley'||_this.address_separated.city=='Ashland Heights'||_this.address_separated.city=='Box Elder'||_this.address_separated.city=='Colonial Pine Hills'||_this.address_separated.city=='Rochester'||_this.address_separated.city=='Simpson'||_this.address_separated.city=='Predmore'||_this.address_separated.city=='Chester'||_this.address_separated.city=='Douglas'||_this.address_separated.city=='Byron'||_this.address_separated.city=='Genoa'){
				//if(false){
					console.log(_this.address_separated.city);
					var send_data = {
						//'key':'T56t7PzxzeDWyNQvAJN6kV02Em6RMMLb', //live
						'key':'XQBRLKOviV2wN8njJAD94UcGheHyIg0g', //staging

						//'key':'iWtagMfwf2smjHAxHUbdNxJZHZgQdwGf',
						//'key':'G2F1WRcJATAyBBCrNGAkZXOs0p5sHjzD',
						'json': JSON.stringify(json_data)
					};
				}else{
					var send_data = {
						//'key':'T56t7PzxzeDWyNQvAJN6kV02Em6RMMLb', //live
						'key':'XQBRLKOviV2wN8njJAD94UcGheHyIg0g', //staging
						//'key':'iWtagMfwf2smjHAxHUbdNxJZHZgQdwGf',
						//'key':'G2F1WRcJATAyBBCrNGAkZXOs0p5sHjzD',
						'json': JSON.stringify(json_data)
					};
					_this.mapquestError();
					return;
				}

				/*for (var i = 0; i < arrayOfArrays.length; i++) {
					alert(i)
					console.log(arrayOfArrays[i]);
					var tmp_json = { "locations": arrayOfArrays[i] };

					console.log(tmp_json);
					var send_data = {
						'key':'XQBRLKOviV2wN8njJAD94UcGheHyIg0g', //staging
						'json': JSON.stringify(tmp_json)
					};
					console.log(send_data);
					$.ajax({
						  async:true,
						  dataType:"JSONP",
						  data:send_data,
						  beforeSend: function(){
							  //_this.mapquest_timeout = setTimeout(_this.mapquestError,6000);
						  },
						  crossDomain:true,
						  url:"https://open.mapquestapi.com/directions/v2/routematrix",
						  type:"POST",
						  jsonpCallback:"goog.mapquestCallback"
					  });
				}*/
	
				
				$.ajax({
					  async:true,
					  dataType:"JSONP",
					  data:send_data,
					  beforeSend: function(){
						  _this.mapquest_timeout = setTimeout(_this.mapquestError,6000);
					  },
					  crossDomain:true,
					  url:"https://open.mapquestapi.com/directions/v2/routematrix",
					  type:"POST",
					  jsonpCallback:"goog.mapquestCallback"
				  });
			};
			
			
			_this.mapquestError=function(){
				_this.mapquest_error=true;
				var send = {};
				send.address=_this.address_separated;
				send.old_routes=_this.old_routes;
				send.rates= _this.rates;
				send.needed_routes = _this.categories_id;
				send.needed_ranges = _this.ranges;
				$.ajax({
					  async:true,
					  dataType:"json",
					  data:{"mapquestError":JSON.stringify(send)},
					  url:"https://staging.fooddudesdelivery.com/location_landing.php",
					  type:"POST",
					  success: _this.addressMatrixCallback,
					  error: function(data){
						 console.log(data);
						 _this.addError('Sorry there has been an error please try again 2');
						 return false;
					  }
				  });
				
			};
			
			_this.mapquestCallback=function(data){
				console.log("MAPQUEST SUCCESS");
				console.log(data);
				
				if(_this.mapquest_error){
					console.log('timeout');
					return;	
				}
				//clearTimeout(_this.mapquest_timeout);
				if(!data.distance || !data.time){
					_this.mapquestError();
					return;
				}
				_this.categories_id.unshift(0);
				var length = _this.categories_id.length;
				var new_one =[];
				for(var i=0;i<length;i++){
					var row={};
					row.categories_id=parseInt(_this.categories_id[i]);
					row.distance=data.distance[i];
					row.duration=data.time[i];
					new_one.push(row);
				}
				
				new_one.shift();
				
				_this.sendUpdatedRoutes(new_one);

				/*if(bigResultArray.length>0){
					alert("Add bigResultArray");
					bigResultArray = bigResultArray.concat(new_one);
				}else{
					alert("Set bigResultArray");
					bigResultArray = new_one;
				}

				mapquest_call_cnt++;
				alert(mapquest_call_cnt +"="+arrayOfArrays.length);
				if(mapquest_call_cnt == arrayOfArrays.length){
					alert("Call sendUpdatedRoutes")
					_this.sendUpdatedRoutes(bigResultArray);
				}else{
					return;
				}*/
			};
			
			_this.sendUpdatedRoutes=function(routes){
				console.log(routes);
				alert("Here");
				var send={};
				send.address=_this.address_separated;
				send.routes=routes;
				send.old_routes=_this.old_routes;
				send.rates= _this.rates;
				$.ajax({
					  async:true,
					  dataType:"json",
					  data:{"update_routes":JSON.stringify(send)},
					  url:"https://staging.fooddudesdelivery.com/location_landing.php",
					  type:"POST",
					  success: _this.addressMatrixCallback,
					  error: function(data){
						 console.log(data);
						 _this.addError('Sorry there has been an error please try again 3');
						  return false;
					  }
				  });
				
			};
			
			_this.validateCustomerPlace=function(){
				var places_length = _this.customer_place.address_components.length;
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
				var street = false;
				for(var i=0;i<places_length;i++){
					if(_this.customer_place.address_components[i].types[0]==='postal_code'){
						var tmpzip = parseInt(_this.customer_place.address_components[i].long_name);
						if(tmpzip>501){
							_this.customer_place.address_components[i].long_name=tmpzip;
							_this.customer_place.address_components[i].short_name=tmpzip;
							zip=true;
						}
					}
					if(_this.customer_place.address_components[i].types[0]==='route'){
						street=true;
					}
				}
				if(!zip || !street){
					return false;
				}
				$('#pac-input').val(_this.customer_place.formatted_address);
				return true;
			};
			
			
			
			
			_this.geolocate=function () {
				if($(window).width()<900){
				  if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
					  var geolocation = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					  };
					  //console.log('GOT LOCATION '+JSON.stringify(geolocation));
					  var circle = new google.maps.Circle({
						center: geolocation,
						radius: position.coords.accuracy
					  });
					  _this.autocomplete.setBounds(circle.getBounds());
					},
					function(){
					  var geolocation = {
						lat: 45.557654,
						lng: -94.221497
					  };
					  var circle = new google.maps.Circle({
						center: geolocation,
						radius: 200
					  });
					  _this.autocomplete.setBounds(circle.getBounds());
					});
				  }else{
					  var geolocation = {
						lat: 45.557654,
						lng: -94.221497
					  };
					  var circle = new google.maps.Circle({
						center: geolocation,
						radius: 200
					  });
					  _this.autocomplete.setBounds(circle.getBounds());
				  }
				}else{
					var geolocation = {
						lat: 45.557654,
						lng: -94.221497
					  };
					  var circle = new google.maps.Circle({
						center: geolocation,
						radius: 200
					  });
					  _this.autocomplete.setBounds(circle.getBounds());
				}
			  return true;
			};
			
			
			_this.jsonToAssoc=function(json){return $.map(json, function(el) { return el; });};

			_this.getPage=function(){var params = window.get_params;var page; if((params.hasOwnProperty('cPath')) && _this.jsonToAssoc(params).indexOf('index') !==-1){page='cpath';}else{page=params['main_page'];}return page;};
			
			
			_this.proceedRedirect=function(){
				var page = _this.getPage();
				var pathname= window.location.origin;
				//setCookie(window.add,'',-1);
				if (!window.location.origin) {
					 pathname= window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
				}
				console.log(window.location.origin);
				//location.reload();
				//return;
				if(page=='no_account'){
					$('.no_acct_submit_btn').click();	
					return;
				}
				
				if(page=='login'){
					$('.create_acct_form').submit();	
					return;
				}
				
				if(page=='index'){
					pathname = pathname.replace('?main_page=index&cPath=1_1914_1915', '');
					window.location.href = pathname+'?main_page=index&cPath=1_1914_1915';	
					return;
				}
				
				if(page=='checkout'){
					$('.mfp-close').click();
					_this.addError('Address Updated');
					return;
				}
				
				if(page=='cpath'){
					_this.fancyRedirect();
					return;
				}
		};
		
		_this.fancyRedirect=function(){
				$.ajax({
					type: 'POST',
					cache: false,
					url: "zm_ajax.php",
					data: {zm_check_current_res_redirect:1},
					dataType: 'text',
					async:true,
					error: function(){
						console.log('error at zm_check_current_res_redirect()');
						_this.addError('Error please try again');
					},
					success: function(data){
						if(data==1){
							location.reload();
						}else{
							var pathname= window.location.origin+window.location.pathname;
							pathname = pathname.replace('?main_page=index&cPath=1_1914_1915', '');
							window.location.href = pathname+'?main_page=index&cPath=1_1914_1915';
						}
					}
				});
	
		}	
			
	  //end of google
	  };