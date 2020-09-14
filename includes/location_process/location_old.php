<?php
 
class Location{
    private $pointOnVertex = true; // Check if the point sits exactly on one of the vertices? idk
	private $rates='';
	private $closestCity;
	private $lat;
	private $lng;
	private $restaurants;
	private $routes;
	private $address;
	private $closeRoutes=array();
	private $citiesInOrder;
	private $tryagain=false;
	
	public function checkForCloseLatLng($lat,$lng,$exclude){
		global $db;
		$lat = floatval($lat);
		$lng = floatval($lng);
		$search_radius = .005;
		
		//.003 is about 220m is about 721.78 ft
		// so i am searching in a SQUARE about 721 feets across
		$srcstr='';
		if(is_array($exclude)){
		  if(count($exclude)>1){
			  $srcstr=' and categories_id not in ('.implode(',',$exclude).') ';
		  }else if(count($exclude)==1){
			  $srcstr=" and categories_id != $exclude ";
		  }
		}
		$lat1= $lat-$search_radius;
		$lat2= $lat+$search_radius;
		$lng1= $lng-$search_radius;
		$lng2= $lng+$search_radius;
		
		$search_query = "
		SELECT address_mapping_id,categories_id,distance,duration 
		FROM address_mapping
		WHERE customer_lat
		BETWEEN $lat1
		AND $lat2
		AND customer_lng
		BETWEEN $lng1
		AND $lng2
		$srcstr
		GROUP BY categories_id
		LIMIT 0 , 9999";
		
		$this->closeRoutes = $db->query($search_query)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getLatLngRoutes($info){
		$exclude_id=array();
		foreach($info['old_routes'] as $or){
			$exclude_id[]=intval($or['categories_id']);
		}
		$this->checkForCloseLatLng($info['needed_ranges'][0]['latLng']['lat'],$info['needed_ranges'][0]['latLng']['lng'],$exclude_id);
		
		$found_ids=array();
		foreach($this->closeRoutes as $close){
			$found_ids[]=$close['categories_id'];
		}

		$info['old_routes'] = array_merge($this->closeRoutes,$info['old_routes']);
		$percent_offset = 1.1;
		$flat_offset = 60;
		
		$leng=count($info['needed_ranges']);
		//find average time
		$dist=0;
		$time=0;
		$cc=0;
		$avg =0;
		foreach( $info['old_routes'] as $old){
			$cc++;
			$dist+=floatval($old['duration'])/floatval($old['distance']);

		}
		if($cc!=0){
			$avg = (($dist)/$cc) * $percent_offset;
		}
		
		if($avg==0 || $cc<9){
			$avg=105;
		}
		for($ii=0;$ii<$leng;$ii++){
			if($ii!=0){
				if(!in_array($info['needed_routes'][$ii-1],$found_ids)){
					$calc_dist =$this->calcDistance
					(
						$info['needed_ranges'][0]['latLng']['lat'],
						$info['needed_ranges'][0]['latLng']['lng'],
						$info['needed_ranges'][$ii]['latLng']['lat'],
						$info['needed_ranges'][$ii]['latLng']['lng']
					);
					
					$info['old_routes'][]=array(
						'categories_id'=>$info['needed_routes'][$ii-1],
						'distance' => round( ( ($calc_dist + 1 ) * $percent_offset ) , 3 ) ,
						'duration' => round( ( ( $calc_dist * $avg ) + $flat_offset ) * $percent_offset , 0 )
					);
				}
			}
		}
		$this->routes = $info['old_routes'];
		$this->rates = $info['rates'];
		
		$this->analyzeRates();
		
	}
	public function updateRoutes($routes){
	  //print_r($routes);
		global $db;
		// $newroutes=json_decode($routes,true);
		 //print_r($newroutes);
	  $address = $routes['address'];
		// print_r($address.'asdasd ');
	  function c($a){return	strtoupper(preg_replace('/\s+/','',$a));}

	  $hold= $address['google_place_id'];
	  $this->address=array_map('c',$address); 	
	  $this->address['google_place_id']=$hold;
		 foreach($routes['routes'] as $rr){
	
		 	$db->query('
			insert into address_mapping (street_number ,street, city ,state, zip ,customer_lat ,customer_lng, google_place_id ,categories_id, distance ,duration) values 
			("'.$this->address['street_number'].'", 
			"'.$this->address['street'].'", 
			"'.$this->address['city'].'", 
			"'.$this->address['state'].'", 
			"'.$this->address['zipcode'].'", 
			"'.$this->address['lat'].'", 
			"'.$this->address['lng'].'", 
			"'.$this->address['google_place_id'].'",
			"'.$rr['categories_id'].'",
			"'.$rr['distance'].'",
			"'.$rr['duration'].'")
			');
			
		 }
	
		 $new_one=array();
		 if(count($routes['old_routes'])>0){
			 //echo 'has old routes';
		 foreach($routes['old_routes'] as $rr){
			 $new_one[]=array('categories_id'=>$rr['categories_id'],'distance'=>$rr['distance'],'duration'=>$rr['duration']);
		 }
		 $this->routes=array_merge($new_one,$routes['routes']);
		 }else{
			 //echo 'no old routes';
			 $this->routes =$routes['routes'];
		 }
		 //echo 'inserted new routes';
		 //print_r($this->routes);
		 $this->rates=$routes['rates'];
		 
		// print_r(json_encode($routes['rates']));
		 $this->analyzeRates();
	}
	
	
	public function runLocation(){
		
		$decode = json_decode($_POST['address_info'],true);
		$this->lat=floatval($decode['lat']);
		$this->lng=floatval($decode['lng']);

		$this->findClosestCity();
		$this->getLocationConfig();
		$v=$this->coordsInRange();
		if(!$v){
			//echo 'not in range';
			return;
		}
		$this->getAllRestaurants();
		$this->getSavedRoutes();
		$address_has_all_routes=$this->decideRoute();
		
		if($address_has_all_routes){
			
			$this->updateAddressMappingAllRoutes();
			$this->analyzeRates();
			//echo 'already mapped';
		}else{
			echo 'error';
			
		}
	}
	
	public function runLocationAgain(){
		$this->tryagain=true;
		$this->closestCity=$this->citiesInOrder[1]['categories_id'];
		$this->expanded_city_list = array($this->closestCity);
		$this->getLocationConfig();
		$this->coordsInRange();
		$this->getAllRestaurants();
		$this->getSavedRoutes();
		$address_has_all_routes=$this->decideRoute();
		if($address_has_all_routes){
			$this->updateAddressMappingAllRoutes();
			$this->analyzeRates();
			//echo 'already mapped';
		}
	}
	
	private function findClosestCity(){
		global $db;
		$city_sql = 'SELECT max_travel_distance,cd.comments,c.categories_id,cd.lat,cd.lng,c.categories_status,cd.categories_name FROM categories_description AS cd INNER JOIN categories as c on c.categories_id = cd.categories_id WHERE parent_id IN (select categories_id FROM categories where parent_id=1) OR c.categories_id=1';
		$city_array = $db->query($city_sql)->fetchAll(PDO::FETCH_ASSOC);
		
		$distance=array();
		$main=array();
		$location_open=true;
		$expanded_city_list=array();
		foreach($city_array as $ca){
			if($ca['categories_id']!=1){
				$dist=$this->calcDistance($this->lat,$this->lng,floatval($ca['lat']),floatval($ca['lng']));
				$distance[]=$dist;
				if((floatval($dist)*1.2)<$ca['max_travel_distance']){
					$expanded_city_list[]=$ca['categories_id'];
				}
				$main[]=array('categories_id'=>$ca['categories_id'],'comments'=>$ca['comments'],'distance'=>$dist,'categories_status'=>$ca['categories_status'],'categories_name'=>$ca['categories_name']);
			}else{
				if($ca['categories_status']==0){
					$location_open=false;
				}
			}
		}
		
		array_multisort($distance, SORT_ASC , $main);

		if(is_array($main)){
			if($main[0]['categories_status']==0){
				
				if(strlen($main[0]['comments'])>2){
					print_r(json_encode(array('code'=>'closest_city_closed_note','note'=>$main[0]['comments'])));	
				}else{
					print_r(json_encode(array('code'=>'closest_city_closed','categories_name'=>$main[0]['categories_name'])));
				}
				
				die;
			}else if(!$location_open){
				print_r(json_encode(array('code'=>'closest_city_closed','categories_name'=>'Food Dudes Delivery')));
				die;
			}else{
				//clear cart here
				$this->citiesInOrder=$main;
				$this->closestCity=$main[0]['categories_id'];
				$this->expanded_city_list = $expanded_city_list;
			}
		}else{
			print_r(json_encode(array('code'=>'error','message'=>'Sorry we are currently closed')));
			die;	
		}
		
	}
	
	private function updateAddressMappingAllRoutes(){
		global $db;
		foreach($this->routes as $route){
			$db->query('
			update address_mapping set 
			street_number ="'.$this->address['street_number'].'", 
			street="'.$this->address['street'].'", 
			city="'.$this->address['city'].'", 
			state="'.$this->address['state'].'", 
			zip="'.$this->address['zipcode'].'", 
			customer_lat="'.$this->address['lat'].'", 
			customer_lng="'.$this->address['lng'].'", 
			google_place_id="'.$this->address['google_place_id'].'"
			where address_mapping_id="'.$route['address_mapping_id'].'"');
		}
		return true;
	}
	private function decideRoute(){
		global $db;
		$saved_restaurants=array();
		foreach($this->routes as $save){
			$saved_restaurants[]=$save['categories_id'];
		}
		
		$this->restaurants=array_unique($this->restaurants);
		$saved_restaurants=array_unique($saved_restaurants);
		
		$difference=array();
		$difference= array_values(array_diff($this->restaurants,$saved_restaurants));

		if(count($difference)==0){
			return true;
		}else{
			$return_lat_lng=array();
			$return_lat_lng[]=array('latLng'=>array('lat'=>$this->address['lat'],'lng'=>$this->address['lng']));
			$cats=array();
			$new_coord=$db->query('select categories_id,lat,lng from categories_description where categories_id in('.implode(',',$difference).') and lat !="na" and lng !="na"');
			foreach($new_coord as $r){
				if(floatval($r['lat'])!=0 && floatval($r['lng'])!=0){
					$cats[]=$r['categories_id'];
					$return_lat_lng[]=array('latLng'=>array('lat'=>$r['lat'],'lng'=>$r['lng']));
				}
			}
			
			if(count($cats)<1 || count($return_lat_lng)<=1){
				$cats=array();
				$return_lat_lng=array();
				return true;
				//idk about this
			}
			print_r(json_encode(array('ranges'=>$return_lat_lng,'code'=>'mapquest','categories_id'=>$cats,'old_routes'=>$this->routes,'rates'=>$this->rates)));	
			die;
			return false;
		}
	}
	private function getAllRestaurants(){
		global $db;
		
		//$listcity = implode(',',$this->expanded_city_list);
		$listcity = $this->closestCity;
		
		$restaurant_query="select categories_id from categories where parent_id in($listcity)";
		$restaurants = $db->query($restaurant_query)->fetchAll(PDO::FETCH_ASSOC);
		$category_id_array=array();
		$counts = 0;
		foreach($restaurants as $res){
			if($counts<100){
				$category_id_array[]=$res['categories_id'];
				$counts++;
			}
		}
		$this->restaurants = $category_id_array;
	}
	
	private function getSavedRoutes(){
	  global $db;
	  function c($a){return	strtoupper(preg_replace('/\s+/','',$a));}
	  $address= json_decode($_POST['address_info'],true);
	  $hold= $address['google_place_id'];
	  $this->address=array_map('c',$address); 	
	  $this->address['google_place_id']=$hold;
	  $search_query = '
	  SELECT address_mapping_id,categories_id,distance,duration from address_mapping 
	  WHERE  
	  street_number = "'.$this->address['street_number'].'" and 
	  street = "'.$this->address['street'].'" and 
	  city = "'.$this->address['city'].'" and 
	  state = "'.$this->address['state'].'" and 
	  zip = "'.$this->address['zipcode'].'" and
	  categories_id in ('.implode(',',$this->restaurants).')
	  OR google_place_id="'.$this->address['google_place_id'].'"
	  GROUP BY categories_id';
	  $this->routes = $db->query($search_query)->fetchAll(PDO::FETCH_ASSOC);
		//print_r($this->routes);
		//
	}
	private function getLocationConfig(){
		global $db;
		//more error checking !!!!!! R@J#RJ@#RJ@#JR#@2323
		//print_r($this->closestCity);
		$rates_ranges_query="
		SELECT categories_id, json_range,  max_travel_distance,max_travel_time ,
		tier_1_distance ,  
		tier_2_distance ,  
		tier_3_distance ,  
		tier_4_distance ,  
		tier_5_distance , 
		tier_1_time ,  
		tier_2_time ,  
		tier_3_time ,  
		tier_4_time ,  
		tier_5_time ,
		tier_1_price ,  
		tier_2_price ,  
		tier_3_price ,  
		tier_4_price ,  
		tier_5_price 
		FROM  categories_description 
		WHERE categories_id = $this->closestCity
		AND tier_1_distance NOT 
		IN (
		 '',  'na',  ' '
		)
		LIMIT 0 , 1";
		$rnr = $db->query($rates_ranges_query)->fetch();
		$rates = array();
		$rates = array('max_travel_distance' => $rnr['max_travel_distance'],
					   'max_travel_duration' => $rnr['max_travel_time'],
					   'tiers' => array (
							array('duration'=>$rnr['tier_1_time'],'distance'=>$rnr['tier_1_distance'],'price'=>$rnr['tier_1_price']),
							array('duration'=>$rnr['tier_2_time'],'distance'=>$rnr['tier_2_distance'],'price'=>$rnr['tier_2_price']),
							array('duration'=>$rnr['tier_3_time'],'distance'=>$rnr['tier_3_distance'],'price'=>$rnr['tier_3_price']),
							array('duration'=>$rnr['tier_4_time'],'distance'=>$rnr['tier_4_distance'],'price'=>$rnr['tier_4_price']),
							array('duration'=>$rnr['tier_5_time'],'distance'=>$rnr['tier_5_distance'],'price'=>$rnr['tier_5_price'])
						),
						'json_range' =>json_decode(base64_decode($rnr['json_range']),true)
				  );
				  
				  //print_r( $rates);
		$this->rates = $rates;
	}
	
	
	private function analyzeRates(){
		//echo 'max distance '.$this->rates['max_travel_distance'];
		//echo '---max duration '.$this->rates['max_travel_duration'];
		//print_r($this->rates['tiers']);
		foreach($this->routes as $key=>&$dist){
			if($dist['distance']>$this->rates['max_travel_distance']){
				unset($this->routes[$key]);
				continue;
			}
			if($dist['duration']>$this->rates['max_travel_duration']){
				unset($this->routes[$key]);
				continue;
			}
			$delivery_fee=0;
			foreach($this->rates['tiers'] as $tier){
				if($dist['distance']>$tier['distance']){
					$delivery_fee=floatval($tier['price']);
				}
				if($dist['duration']>$tier['duration']){
					$delivery_fee=floatval($tier['price']);
				}
			}
			if($delivery_fee==0){
				$delivery_fee=4.99;
			}

			
			$dist['delivery_fee']=$delivery_fee;
		}
		
		foreach($this->routes as &$rr){
			if(isset($rr['address_mapping_id'])){
				unset($rr['address_mapping_id']);
			}
			$rr['categories_id']=intval($rr['categories_id']);
			$rr['delivery_fee']=floatval($rr['delivery_fee']);
			$rr['distance']=floatval($rr['distance']);
			$rr['duration']=floatval($rr['duration']);
		}
		
		$this->finishHim();
	}
	
	private function finishHim(){
		//include('../application_top.php');
//		$_SESSION['address_separated'] = array();
//		$_SESSION['address_separated'] = json_decode($address,true);
//		$_SESSION['address_separated'][0]['street_number']=$this->address['street_number'];
//		$_SESSION['address_separated'][0]['street']=$this->address['street'];
//		$_SESSION['address_separated'][0]['postcode']=$this->address['zipcode'];
//		$_SESSION['address_separated'][0]['city']=$this->address['city'];
//		$_SESSION['address_separated'][0]['state']=$this->address['state'];
//		
//		
//		
//		foreach($this->routes as $info){
//			$_SESSION['restaurant_info'][$info['categories_id']]=array( 'distance' => $info['distance'], 'duration' => $info['duration'], 'delivery_fee' => $info['delivery_fee'] );
//		}
//		if(isset($_SESSION['customer_id'])){
//			zm_add_address_to_book();
//		}
		print_r(json_encode(array('routes'=>$this->routes,'code'=>'all_routes_available')));
		die;
	}
	
    private function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }
 
    private function pointStringToCoordinates($pointString) {
        $coords = explode(",", $pointString);
        return array("x" => $coords[0], "y" => $coords[1]);
    }
	
	private function calcDistance($lat1,$lon1,$lat2,$lon2){
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		return $dist * 60 * 1.1515;
	}

//	private function setDistanceToRestaurant() {
//		$this->Link['math_distance']=
//		round(
//			$this->calcDistance
//			(
//				$this->Link['customer_coordinates']['lat'],
//				$this->Link['customer_coordinates']['lng'],
//				$this->Config['restaurant_coordinates']['lat'],
//				$this->Config['restaurant_coordinates']['lng']
//			)
//		,5);
//		return true;
//	}
	
	
	private function coordsInRange(){
		$polygon = array();
		$polygon = $this->rates['json_range'];
		
		if(count($polygon)<3){
			print_r(json_encode(array('code'=>'error','message'=>'Sorry we are currently closed.')));
			die;	
		}
		
		$polygon[count($polygon)]=$polygon[0];
		//$this->setLongestDistance($polygon);
		//$this->setDistanceToRestaurant();
		return $this->pointInPolygon($polygon);
	}
	
	
	private function pointInPolygon($polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
 
        // Transform string coordinates into arrays with x and y values
        $point = array("x" => $this->lat, "y" => $this->lng);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }
 
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return true;
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
 
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return true;
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return true;
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return true;
        } else {
			if(!$this->tryagain){
				$this->runLocationAgain();
				return false;
			}
			print_r(json_encode(array('code'=>'error','message'=>'Sorry your address is out of delivery range')));
			die;
        }
    }
	
		
//	private function setLongestDistance($polygon) {
//		$distance=array();
//		$y = explode(',',$this->restaurantCoordinates);
//		foreach($polygon as $points){
//			$x = explode(',',$points);
//			$distance[]=$this->calcDistance($x[0],$x[1],$y[0],$y[1]);
//		}
//		$this->Link['restaurant_max_delivery']=round(max($distance),5);
//	}
 
}
?>