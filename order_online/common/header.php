<? //this is the panel 

$delivery_times = $this->displayTime('delivery');
$pickup_times = $this->displayTime('pickup');
$times_same = true;
$new_delivery=array();
$new_pickup=array();
$display_now_delivery='';
$display_now_pickup='';
$day_today=substr(date('l'),0,3);
$day_today_lower = strtolower(date('l'));
foreach($delivery_times as $day=> $del){
	$subdate = substr(ucfirst($day),0,3);
	if($times_same===true){
		if($del['open']!=$pickup_times[$day]['open'] || $del['close']!=$pickup_times[$day]['close']){
			$times_same = false;
		}
	}

	$symb = strpos($del['open'],'-')!==false ? ',<br />' : '-';
	if(strpos($del['open'],'12:00am')!==false && strpos($del['close'],'12:00am')!==false){
		$new_delivery[$subdate]='Closed';
	}else{
		$new_delivery[$subdate]=$del['open'].$symb.$del['close'];
	}

	$picku = strpos($pickup_times[$day]['open'],'-')!==false ? ',<br />' : '-';
	if(strpos($pickup_times[$day]['open'],'12:00am')!==false && strpos($pickup_times[$day]['close'],'12:00am')!==false){
		$new_pickup[$subdate]='Closed';
	}else{
		$new_pickup[$subdate]=$pickup_times[$day]['open'].$picku.$pickup_times[$day]['close'];
	}
	
	if($day_today_lower===$day){
		$display_now_delivery = $new_delivery[$day_today];
		$display_now_pickup = $new_pickup[$day_today];
	}

	$new_pickup[$subdate]='<tr><td>'.$subdate.':</td><td>'.$new_pickup[$subdate].'</td></tr>';
	$new_delivery[$subdate]='<tr><td>'.$subdate.':</td><td>'.$new_delivery[$subdate].'</td></tr>';
}

$check_delivery = $this->checkTime(0,'delivery');
$check_pickup = $this->checkTime(0,'pickup');
$default_time_select=true;

if(count($check_delivery)>0){
	$open_now_txt='<span class="opennowtxt">Open Now</span><br>'.$display_now_delivery;
}else{
	$open_now_txt='<span  class="closednowtxt">Closed Now</span><br>'.$display_now_delivery;
}

if(count($check_pickup)>0){
	$open_now_txt_p='<span class="opennowtxt">Open Now</span><br>'.$display_now_pickup;
	if(count($check_delivery)==0){
		$default_time_select=false;
	}
}else{
	$open_now_txt_p='<span  class="closednowtxt">Closed Now</span><br>'.$display_now_pickup;	
}



?>
<div data-role="panel" id="firstpanel<?php echo $this->headPanelCount ?>" data-position="left" data-display="overlay" class="mainPanel">
    <div  class="close_modal_mobile visible-sm visible-xs">
        <?php echo TEXT_EXIT_ORDERING ?>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <div class="google-map-container">
            <img class="header_img" alt="<?php echo $this->Config['restaurant_name'] ?>" src="<?php echo $this->Config['google_map_link'] ?>">
        </div>
      </div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-body">
         <a  class="text-center header_new_a col-xs-12" href="tel:<?php echo $this->Config['restaurant_phone'] ?>">
            <?php echo $this->phoneFormat($this->Config['restaurant_phone']) ?>
        </a> 
      </div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-body">
        <a class="text-center col-xs-12 header_new_a" href="https://www.google.com/maps/place/<?php echo urlencode($this->Config['restaurant_name'].' '.$this->Config['restaurant_address']) ?>" target="_blank">
            <?php echo $this->Config['restaurant_address'] ?>
        </a>
      </div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-body">

		 <? if($times_same===false){ ?>
            <table class="special_dumbass_table text-center header_new_a htb" >
              <tr>
                <td class="header_switch <? echo $default_time_select ? 'header_active':''?>" data-show=".delivery_times">Delivery</td>
                <td class="header_switch <? echo $default_time_select ? '':'header_active'?>" data-show=".pickup_times">Pickup</td>
              </tr>
            </table>
         <? } ?> 
         
                  
        <div class="delivery_times toggletime" <? echo $default_time_select ? '':'style="display:none"'?>>
          <table class="special_dumbass_table">
          <tr>
            <td>
              <div data-toggle="collapse" data-target="#slidemenu<?php echo $this->headPanelCount ?>">
				<?php echo $open_now_txt;  ?>
                <br>
                <div class="glyphicon glyphicon-chevron-down"></div>
              </div>
            </td>
          </tr>
          </table>
          <div id="slidemenu<?php echo $this->headPanelCount ?>" class="collapse marg20top">
            <table class="table header_new_a">
              <? echo implode($new_delivery); ?>
            </table>
          </div>
        </div>
        
   
         <div class="pickup_times toggletime" <? echo $default_time_select ? 'style="display:none"':''?> >
          <table class="special_dumbass_table">
          <tr>
            <td>
              <div data-toggle="collapse" data-target="#slidemenup<?php echo $this->headPanelCount ?>">
				<?php echo $open_now_txt_p;  ?>
                <br>
                <div class="glyphicon glyphicon-chevron-down"></div>
              </div>
            </td>
          </tr>
          </table>
          <div id="slidemenup<?php echo $this->headPanelCount ?>" class="collapse marg20top">
            <table class="table header_new_a">
              <? echo implode($new_pickup); ?>
            </table>
          </div>
        </div>
          
          
      </div>
    </div>
    
<? //end panel ?>
</div>




<? //this is the actual header ?>
<div data-role="header"  class="main_header_container" data-id="persistent" data-position="fixed" data-transition="none"  data-tap-toggle="false"  >
    <div class="container-fluid second_header_container">
        <a href="#" data-rel="back" data-transition="slide" class=" col-xs-2 text-left">
        <i class="glyphicon glyphicon-chevron-left stop1" style="color:<?php  echo $this->Config['primary_color'] ?> !important;"></i>
        </a>
        <div class="col-xs-8 text-center" style="white-space: nowrap;">
            <?php echo $this->Config['restaurant_name'] ?>
        </div>
        <a href="#firstpanel<?php echo $this->headPanelCount ?>" >
            <div class="col-xs-2 text-right" ><i class="stop2 glyphicon glyphicon-th" style="color:<?php  echo $this->Config['primary_color'] ?> !important;"></i></div>
        </a>
    </div>
    <div class="error_msg_style <?php echo  ID_ERROR_MESSAGE ?>"></div>
</div>
<div style="width:100%;height:15px;"></div>
	
    
    
    	
<?php $this->headPanelCount++ ?>