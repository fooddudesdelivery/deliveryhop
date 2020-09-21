<?php
include(__DIR__.'/Base.php');

class Time extends Base{
	private $padBreak=array();
	private $searchTime = 0;
	private $pord = 'delivery';
	
	protected function runTime(){
		$this->checkCategoriesId();
		if($this->Link['delivery']===1){
			$this->pord='delivery';
		}else{
			$this->pord='pickup';
		}
		$this->getTimezone();
		
		if
		(
			$this->inTime() 
		)
		{
			
			return true; 
		}else{
			$this->Link['open_menus']=array();
			//$this->addError(ERROR_TOP_LEVEL_TIME);
			
			return true;	
		}
	}
	
	protected function inTime(){
			$searchTime = $this->searchTime;
			$pord = $this->pord;
			//this is the return var
			$open_menus = array();
			
			
			$this_restaurant = $this->db->query("select categories_status from categories where categories_id = $this->CategoriesId")->fetch(PDO::FETCH_ASSOC);
			
			$this_city = $this->db->query("select categories_status from categories where categories_id = (select parent_id 
			from categories where categories_id = $this->CategoriesId)")->fetch(PDO::FETCH_ASSOC);
			
			$this_state = $this->db->query("select categories_status from categories where categories_id = (select parent_id 
			from categories where categories_id = (select parent_id 
			from categories where categories_id = $this->CategoriesId))")->fetch(PDO::FETCH_ASSOC);
			
			$this_deliverhops = $this->db->query("select categories_status from categories where categories_id = (select parent_id 
			from categories where categories_id = (select parent_id 
			from categories where categories_id = (select parent_id 
			from categories where categories_id = $this->CategoriesId)))")->fetch(PDO::FETCH_ASSOC);
			
			if($this_restaurant['categories_status'] == 0 ||
			$this_city['categories_status'] == 0 ||
			$this_state['categories_status'] == 0 ||
			$this_deliverhops['categories_status'] == 0 ){
				return array();
			}
			//0 means asap and will get the current time
			//this block gets most revelvant vars searchTime,searchDay,searchDate
			if($searchTime===0){
				$searchTime = strtotime('now');
				$searchDay = strtolower(date('l',strtotime('now')));
				$searchDate = strtolower(date('Y-m-d',$searchTime));
			}else{
				//IMPORTANT remember to include a time with custom date or else itll be 0
				//you can input both a epoch time and a string time this converts the string time
				if(!is_numeric($searchTime)){
					$searchTime=strtotime($searchTime);
				}
				$searchDay = strtolower(date('l',$searchTime));	
				$searchDate = strtolower(date('Y-m-d',$searchTime));	
			}
			
			//if you enter garbage in searchTime itll be false and you suck
			if($searchTime===FALSE){
				//echo 'BAD DATE';
				return array();
			}
			
			//date in past makes no sense
			if($searchTime<strtotime('now')){
				//echo 'PAST DATE';
				return array();
			}
			
			//could casue db problems if pord isnt right
			if($pord!=='delivery' && $pord!=='pickup'){
				//echo 'BAD TYPE';
				return array();
			}

	
			
			
			//get off days breaks and if breaks are active
			$breaks_alpha = $this->db->query("select * from pickup_breaks_offdays where categories_id = $this->CategoriesId")->fetch(PDO::FETCH_ASSOC);
			
			//get the stupid ass timepads
			$pads_alpha = $this->db->query("select time_pad_close, time_pad_open from categories_description where categories_id = $this->CategoriesId")->fetch(PDO::FETCH_ASSOC);
			$pad_start = intval($pads_alpha['time_pad_open'])*900;
			$pad_end = intval($pads_alpha['time_pad_close'])*900;
			
			if($breaks_alpha!==false){
		
			  $breaks = json_decode($breaks_alpha['json_array'],true);
			  $offdays = json_decode($breaks_alpha['offdays'],true);
	  
			  //see if the entered date is in the list of offdays
			  if(in_array($searchDate,$offdays)){
				  //echo'OFFDAY';
				  return array();
			  }		
			  
			  //check if breaks are even active for the restaurant
			  if(intval($breaks_alpha['break_active']) !== 0){
				  
				  //convert breaks to actual dates and check
				  $break_start=strtotime($searchDate.' '.$breaks[$searchDay]['open']);
				  $break_end=strtotime($searchDate.' '.$breaks[$searchDay]['close']);
				  if($searchTime >= ($break_start-$pad_start) && $searchTime <= ($break_end-$pad_end)){
					  //echo'IN BREAK';
					  return array();
				  }
			  }
			}
			
			//select delivery and pickup hours from table but only if that spot equals 1 in delivery/pickup_on
			$menus_alpha = $this->db->query("select menu_categories_id,".$pord."_hours from pickup_hours where ".$pord."_on = 1 and categories_id = $this->CategoriesId")->fetchAll(PDO::FETCH_ASSOC);
			if($menus_alpha===false){
				//echo 'BAD CONFIG';
				return array();
			}
			$menus = array();
			
			//select $pord which is pickup or delivery 
			foreach($menus_alpha as $m){
				$menus[$m['menu_categories_id']]=json_decode($m[$pord.'_hours'],true);
			}
			foreach($menus as $menu_id => $day){
				//just to make it cleaner set day to day[searchDay]
				$day = $day[$searchDay];
				
				//convert open times into actual dates
				$open = strtotime($searchDate.' '.$day['open']);
				$close = strtotime($searchDate.' '.$day['close']);
				
				// is the seached time inside the range
				if($searchTime >= ($open-$pad_start) && $searchTime <= ($close-$pad_end)){
					$open_menus[]=$menu_id;
				}
			}
			//print_r($open_menus);die;
			$this->Link['open_menus']=$open_menus;
			return true;
	}
	
	
	public function checkTime($searchTime=0,$pord='delivery'){
		
			//this is the return var
			$open_menus = array();
			
			//0 means asap and will get the current time
			//this block gets most revelvant vars searchTime,searchDay,searchDate
			if($searchTime===0){
				$searchTime = strtotime('now');
				$searchDay = strtolower(date('l',strtotime('now')));
				$searchDate = strtolower(date('Y-m-d',$searchTime));
			}else{
				//IMPORTANT remember to include a time with custom date or else itll be 0
				//you can input both a epoch time and a string time this converts the string time
				if(!is_numeric($searchTime)){
					$searchTime=strtotime($searchTime);
				}
				$searchDay = strtolower(date('l',$searchTime));	
				$searchDate = strtolower(date('Y-m-d',$searchTime));	
			}
			
			//if you enter garbage in searchTime itll be false and you suck
			if($searchTime===FALSE){
				//echo 'BAD DATE';
				return array();
			}
			
			//date in past makes no sense
			if($searchTime<strtotime('now')){
				//echo 'PAST DATE';
				return array();
			}
			
			//could casue db problems if pord isnt right
			if($pord!=='delivery' && $pord!=='pickup'){
				//echo 'BAD TYPE';
				return array();
			}
			
			//get off days breaks and if breaks are active
			$breaks_alpha = $this->db->query("select * from pickup_breaks_offdays where categories_id = $this->CategoriesId")->fetch(PDO::FETCH_ASSOC);
			
			//get the stupid ass timepads
			$pads_alpha = $this->db->query("select time_pad_close, time_pad_open from categories_description where categories_id = $this->CategoriesId")->fetch(PDO::FETCH_ASSOC);
			$pad_start = intval($pads_alpha['time_pad_open'])*900;
			$pad_end = intval($pads_alpha['time_pad_close'])*900;
			
			if($breaks_alpha!==false){
		
			  $breaks = json_decode($breaks_alpha['json_array'],true);
			  $offdays = json_decode($breaks_alpha['offdays'],true);
	  
			  //see if the entered date is in the list of offdays
			  if(in_array($searchDate,$offdays)){
				  //echo'OFFDAY';
				  return array();
			  }		
			  
			  //check if breaks are even active for the restaurant
			  if(intval($breaks_alpha['break_active']) !== 0){
				  
				  //convert breaks to actual dates and check
				  $break_start=strtotime($searchDate.' '.$breaks[$searchDay]['open']);
				  $break_end=strtotime($searchDate.' '.$breaks[$searchDay]['close']);
				  if($searchTime >= ($break_start-$pad_start) && $searchTime <= ($break_end-$pad_end)){
					  //echo'IN BREAK';
					  return array();
				  }
			  }
			}
			
			//select delivery and pickup hours from table but only if that spot equals 1 in delivery/pickup_on
			$menus_alpha = $this->db->query("select menu_categories_id,".$pord."_hours from pickup_hours where ".$pord."_on = 1 and categories_id = $this->CategoriesId")->fetchAll(PDO::FETCH_ASSOC);
			if($menus_alpha===false){
				//echo 'BAD CONFIG';
				return array();
			}
			$menus = array();
			
			//select $pord which is pickup or delivery 
			foreach($menus_alpha as $m){
				$menus[$m['menu_categories_id']]=json_decode($m[$pord.'_hours'],true);
			}
			foreach($menus as $menu_id => $day){
				//just to make it cleaner set day to day[searchDay]
				$day = $day[$searchDay];
				
				//convert open times into actual dates
				$open = strtotime($searchDate.' '.$day['open']);
				$close = strtotime($searchDate.' '.$day['close']);
				
				// is the seached time inside the range
				if($searchTime >= ($open-$pad_start) && $searchTime <= ($close-$pad_end)){
					$open_menus[]=$menu_id;
				}
			}
			
			return $open_menus;
	}
	
	public function displayTime($pord='delivery'){
		
		
		$days =array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
		$menus_alpha = $this->db->query("select menu_categories_id,".$pord."_hours from pickup_hours where ".$pord."_on = 1 and categories_id = $this->CategoriesId")->fetchAll(PDO::FETCH_ASSOC);
		if($menus_alpha===false){
			return array();
		}
		$menus_beta=array();
		
		foreach($menus_alpha as $m){
				$menus_beta[]=json_decode($m[$pord.'_hours'],true);
		}
		
		$days_org=array();
		foreach($days as $day){
			foreach($menus_beta as $menu){
				$days_org[$day]['open'][]=$menu[$day]['open'];
				$days_org[$day]['close'][]=$menu[$day]['close'];
			}
		}
		
		$sched=array();
		foreach($days_org as $day=>$org){
			
			$cur_min = min($org['open']);
			$cur_max = max($org['close']);
			
			if($this->f($cur_min)!=='12:00am'){
				$sched[$day]['open']=$this->f($cur_min);
			}else{
				//may need to go deeper/make recursive for more menus.. well see if it comes up
				unset($org['open'][array_search($cur_min, $org['open'])]);
				
				$sched[$day]['open']=$this->f($cur_min);
			}
			
			if($this->f($cur_max)!=='12:00am'){
				$sched[$day]['close']=$this->f($cur_max);
			}else{
				//may need to go deeper/make recursive for more menus.. well see if it comes up
				unset($org['close'][array_search($cur_max, $org['close'])]);
				$sched[$day]['close']=$this->f($cur_max);
			}
		}
		
		$breaks_alpha = $this->db->query("select json_array from pickup_breaks_offdays where break_active=1 and categories_id = $this->CategoriesId")->fetch(PDO::FETCH_ASSOC);
		if($breaks_alpha!==false){
			$new_sched=array();
			foreach(json_decode($breaks_alpha['json_array'],true)  as $day=>$breaks){
				if($this->f($breaks['open'])!=='12:00am' && $this->f($breaks['close'])!=='12:00am'){
					$new_sched[$day]['open']=$this->f($sched[$day]['open']).'-'.$this->f($breaks['open']);
					$new_sched[$day]['close']=$this->f($breaks['close']).'-'.$this->f($sched[$day]['close']);
				}else{
					$new_sched[$day]['open']=$this->f($sched[$day]['open']);
					$new_sched[$day]['close']=$this->f($sched[$day]['close']);
				}
			}
			$sched = $new_sched;
		}
		return $sched;
		
		//use on display
		//$symb = strpos($times['open'],'-')!==false ? ', ' : '-';
	}
	
	
	private function f($time){return date('g:ia',strtotime('today '.$time));}
	
	
	//private function setPadBreak(){
//		$pad_break_query='
//		SELECT 
//		categories_id,
//		'.$this->day.'_break AS break_start,
//		'.$this->day.'_break_length AS break_end,
//		time_pad_open AS pad_start,
//		time_pad_close AS pad_end,
//		special_off_1 as closed_days
//		FROM categories_description
//		WHERE categories_id = '.$this->CategoriesId.'
//		LIMIT 0 , 1';
//		$this->padBreak = $this->db->query($pad_break_query)->fetch();
//		return true;
//	}
//	
//	
//	private function checkClosedToday(){
//		//closed for holiday
//		if($this->padBreak['closed_days']!='' && $this->padBreak['closed_days']!=' ' && $this->padBreak['closed_days']!='na'){
//			$closed_days_array=explode(',',$this->padBreak['closed_days']);
//			foreach($closed_days_array as $closed){
//				if(date('m/d/y')==date('m/d/y',strtotime($closed))){
//					//$this->addError(ERROR_RESTAURANT_IS_CLOSED_HOLIDAY);
//					return false;
//				}
//			}
//		}
//		return true;
//	}
//	
//	
//	private function checkBreaks(){
//		//day breaks
//		$this->padBreak['pad_start']=intval($this->padBreak['pad_start']*15*60);
//		$this->padBreak['pad_end']=intval($this->padBreak['pad_end']*15*60);
//		
//		if($this->padBreak['break_start']>0 && $this->padBreak['break_end']>0){
//			$this->padBreak['break_start']=intval(date('Hi',strtotime($this->padBreak['break_start'])-$this->padBreak['pad_start']));
//			$this->padBreak['break_end']=intval(date('Hi',strtotime($this->padBreak['break_end'])-$this->padBreak['pad_end']));
//			if($this->padBreak['break_start']<=$this->timenow && $this->padBreak['break_end']>=$this->timenow){
//				//$this->addError(ERROR_RESTAURANT_IS_ON_BREAK);
//				return false;
//			}
//		}	
//		return true;
//	}
//	
//	private function checkMenuTimes(){
//		//menu times most likely to restrict
//		$dates_query ='
//		SELECT 
//		categories_id,
//		'.$this->day.'_start_first AS menu_start,
//		'.$this->day.'_end_first AS menu_end
//		FROM categories_description
//		WHERE categories_id
//		IN (
//		  SELECT categories_id
//		  FROM categories
//		  WHERE parent_id ='.$this->CategoriesId.'
//		  AND categories_status =1
//		)
//		LIMIT 0 , 9999';
//		
//		$this->Link['open_menus']=array();
//		foreach($this->db->query($dates_query) as $d){
//			$start=intval(date('Hi',strtotime($d['menu_start'])-$this->padBreak['pad_start']));
//			$end=intval(date('Hi',strtotime($d['menu_end'])-$this->padBreak['pad_end']));
//			if($this->timenow>=$start && $this->timenow<=$end){
//				$this->Link['open_menus'][]=intval($d['categories_id']);
//			}
//		}
//		
//		$this->Link['open_menus']=array_unique($this->Link['open_menus']);
//		if(count($this->Link['open_menus'])<1){
//			//$this->addError(ERROR_RESTAURANT_IS_CLOSED_MENU);
//			return false;	
//		}else{
//			return true;
//		}
//	}
	
//	public function getDeliveryTimes(){
//		//fix this
//		$dates_query ='
//		SELECT 
//		categories_id,
//		monday_start_first,
//		monday_end_first,
//		tuesday_start_first,
//		tuesday_end_first,
//		wednesday_start_first,
//		wednesday_end_first,
//		thursday_start_first,
//		thursday_end_first,
//		friday_start_first,
//		friday_end_first,
//		saturday_start_first,
//		saturday_end_first,
//		sunday_start_first,
//		sunday_end_first
//		FROM categories_description
//		WHERE categories_id
//		IN (
//		  SELECT categories_id
//		  FROM categories
//		  WHERE parent_id ='.$this->CategoriesId.'
//		  AND categories_status =1
//		)
//		LIMIT 0 , 9999';
//		$date_array=array();
//		$weekdays=array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
//		
//		foreach($this->db->query($dates_query) as $days){
//			foreach($weekdays as $day){
//				$tmp_start=date('Hi',strtotime($days[$day.'_start_first']));
//				if($tmp_start!=0000){
//					$date_array[$day.'_start'][]=$tmp_start;
//				}
//				
//				$tmp_end=date('Hi',strtotime($days[$day.'_end_first']));
//				if($tmp_end!=0000){
//					$date_array[$day.'_end'][]=$tmp_end;
//				}
//			}
//		}
//		
//		$min_max=array();
//		foreach($weekdays as $day){
//			$min_max[$day.'_start']=min($date_array[$day.'_start']);
//			$min_max[$day.'_end']=max($date_array[$day.'_end']);
//		}
//		
//
//		$pad_break_query='
//		SELECT 
//		categories_id,
//		monday_break,
//		monday_break_length,
//		tuesday_break,
//		tuesday_break_length,
//		wednesday_break,
//		wednesday_break_length,
//		thursday_break,
//		thursday_break_length,
//		friday_break,
//		friday_break_length,
//		saturday_break,
//		saturday_break_length,
//		sunday_break,
//		sunday_break_length,
//		time_pad_open AS pad_start,
//		time_pad_close AS pad_end,
//		special_off_1 as closed_days
//		FROM categories_description
//		WHERE categories_id = '.$this->CategoriesId.'
//		LIMIT 0 , 1';
//		$pads_breaks = $this->db->query($pad_break_query)->fetch();
//		$final_array=array();
//		foreach($pads_breaks as $key=> &$p){
//			if($key!='pad_start' && $key!='pad_end' && $p!=0 && $p!='' && $p!=' '){
//				$p=date('Hi',strtotime($p));
//			}
//		}
//
//		$po=intval($pads_breaks['pad_start'])*15*60;
//		$pc=intval($pads_breaks['pad_end'])*15*60;
//		foreach($weekdays as $day){
//			$start=date('g:ia',strtotime($min_max[$day.'_start'])+$po);
//			$end=date('g:ia',strtotime($min_max[$day.'_end'])-$pc);
//			
//			if($pads_breaks[$day.'_break']!=0 && $pads_breaks[$day.'_break']!=''&& $pads_breaks[$day.'_break']!=' '){
//				$break_start=date('g:ia',strtotime($pads_breaks[$day.'_break'])-$po);
//				$break_end=date('g:ia',strtotime($pads_breaks[$day.'_break_length'])-$po);
//
//				if($start==$break_start){
//					$final_array[ucwords($day)]=$start.'-'.$end;
//				}else{
//					$final_array[ucwords($day)]=$start.'-'.$break_start.'<br>'.$break_end.'-'.$end;
//				}
//
//			}else{
//				$final_array[ucwords($day)]=$start.'-'.$end;	
//			}	
//		}
//		
//		return $final_array;
//	}
	
	
}

?>