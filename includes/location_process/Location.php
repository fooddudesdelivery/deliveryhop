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
        
        $this->getLocationConfig();
        $v=$this->coordsInRange();
        if(count($v)==0){
           print_r(json_encode(array('code'=>'error','message'=>'Sorry, we currently do not service your location. Please try a different address.
')));
            return;
        }
      
		$this->findClosestCity($v);
        
		
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
	

	
	private function findClosestCity($city_array){
		global $db;
		//put in a thign for top level TODO
		
		$distance=array();
		$main=array();
		$location_open=true;
		$expanded_city_list=array();
		foreach($city_array as $ca){
           
			if($ca['categories_id']!=1){
                
				$dist=$this->calcDistance($this->lat,$this->lng,floatval($ca['lat']),floatval($ca['lng']));
				$distance[]=$dist;
				if(floatval($dist)<floatval($ca['max_travel_distance'])*1.3){
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
                foreach($this->rates as $r){
                    if($r['categories_id']==$main[0]['categories_id']){
                        $this->rates =$r;
                    }
                }
				$this->citiesInOrder=$main;
				$this->closestCity=$main[0]['categories_id'];
				$this->expanded_city_list = $expanded_city_list;
				
				if(count($this->expanded_city_list)==0){
					print_r(json_encode(array('code'=>'error','message'=>'Sorry, we currently do not service your location. Please try a different address.
')));
					die;
				}
				
				
                
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
	
	private function getExtraRes(){
		global $db;
		$ex = $db->query("select categories_id,json_range from categories_description where added_to_borders=1")->fetchAll(PDO::FETCH_ASSOC);
		$out = array();
		foreach($ex as $e){
			$out[]=$this->pointInPolygon(json_decode(base64_decode($e['json_range']),true)); 
		
		}
		var_dump($out);
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
			
		}
	}
	private function getAllRestaurants(){
		global $db;
		
		$listcity = implode(',',$this->expanded_city_list);
		
		
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
        if(!isset($this->address['street_number'])){
            $this->address['street_number'] ='';
        }
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
		SELECT c.categories_id, json_range,  max_travel_distance,max_travel_time ,comments,lat,lng,categories_name,c.categories_status,
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
		FROM  categories_description as cd
        INNER JOIN categories as c on c.categories_id = cd.categories_id
		WHERE c.categories_id in(select categories_id from categories where parent_id in(select categories_id from categories where parent_id =1)) 
		AND tier_1_distance NOT 
		IN (
		 '',  'na',  ' '
		)
		";
		$rates = $db->query($rates_ranges_query)->fetchAll();
      
		$rates_out = array();
        foreach($rates as $rnr){
          		$rates_out[]= 
                array( 
                    'categories_id' => $rnr['categories_id'],
                    'max_travel_distance' => $rnr['max_travel_distance'],
                    'comments'=>$rnr['comments'],
                    'lat'=>$rnr['lat'],
                    'lng'=>$rnr['lng'],
                    'categories_name'=>$rnr['categories_name'],
                    'categories_status'=>$rnr['categories_status'],
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
        }

				  
		$this->rates = $rates_out;
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


	
	
	private function coordsInRange(){
        $inRangeList=array();
        foreach($this->rates as $rate){
            $polygon = array();
            $polygon = $rate['json_range'];


            $polygon[count($polygon)]=$polygon[0];

            $in_range = $this->pointInPolygon($polygon);    
            if($in_range){
                $inRangeList[]= $rate;
            }
            
        }
        return $inRangeList;
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
			
			return false;
        }
    }
	

 
}
?>