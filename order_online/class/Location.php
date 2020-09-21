<?php


require(__DIR__.'/Time.php'); 
class Location extends Time{
    private $pointOnVertex = true; // Check if the point sits exactly on one of the vertices? idk
	

	
	
	protected function runLocation(){
		if
		(
			$this->coordsInRange() && 
			$this->analyzeRates()
		)
		{
			return true;
		}else{
			$this->addError(ERROR_TOP_LEVEL_LOCATION);
			return false;
		}
	}
	
	
	protected function getLocationConfig(){
		//more error checking !!!!!! R@J#RJ@#RJ@#JR#@2323
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
		WHERE categories_id
		IN ( $this->CategoriesId , (
			  
			  SELECT parent_id
			  FROM categories
			  WHERE categories_id = $this->CategoriesId
			  ) ) 
		AND tier_1_distance NOT 
		IN (
		 '',  'na',  ' '
		)
		ORDER BY categories_id DESC 
		LIMIT 0 , 1";
		$rnr = $this->db->query($rates_ranges_query)->fetch();
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
				  
		return $rates;
	}
	
	
	private function analyzeRates(){
		if($this->Link['math_distance']>$this->Config['max_travel_distance']){
			$this->addError(ERROR_DISTANCE_TOO_FAR);
			return false;
		}
		
		$delivery_fee=0;
		foreach($this->Config['tiers'] as $tier){
			if($this->Link['math_distance']>$tier['distance']){
				$delivery_fee=floatval($tier['price']);
			}
		}
		if($delivery_fee==0){
			$delivery_fee=3.99;
		}
		
		$this->Link['totals']['delivery_fee'] = $delivery_fee;
		return true;
		
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

	private function setDistanceToRestaurant() {
		$this->Link['math_distance']=
		round(
			$this->calcDistance
			(
				$this->Link['customer_coordinates']['lat'],
				$this->Link['customer_coordinates']['lng'],
				$this->Config['restaurant_coordinates']['lat'],
				$this->Config['restaurant_coordinates']['lng']
			)
		,5);
		return true;
	}
	
	
	private function coordsInRange(){
		$polygon = array();
		$polygon = $this->Config['json_range'];
		
		if(count($polygon)<3){
			$this->addError(ERROR_NO_JSON_RANGE);
			return false;	
		}
		
		$polygon[count($polygon)]=$polygon[0];
		//$this->setLongestDistance($polygon);
		$this->setDistanceToRestaurant();
		return $this->pointInPolygon($polygon);
	}
	
	
	private function pointInPolygon($polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
 
        // Transform string coordinates into arrays with x and y values
        $point = array("x" => $this->Link['customer_coordinates']['lat'], "y" => $this->Link['customer_coordinates']['lng']);
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
			$this->addError(ERROR_COORDS_NOT_IN_POLYGON);
            return false;
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