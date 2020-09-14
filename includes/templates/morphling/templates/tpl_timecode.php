<?php


$c_level = zm_get_c_level($_GET['cPath']);

if($c_level==4){

	//$timecode_times = zm_get_asap_times_for_today();
	//$option_list = zm_format_option_list_for_today($timecode_times);

}


?>


<div id="timecode-popup" class="pt-popup pt-paddingless mfp-hide">
	<div class="timecode-popup-head">
		<div class="popup-title"><?php echo DEPLOY_TIMECODE; ?></div>
	</div>
	<div class="timecode-popup-content">
    	<div class="timecode-timepicker-container">
        	<select class="timecode-timepicker" >
            <option value="2">Select Date</option>
            </select>
        </div>
    	<div class='timecode-calendar'>
        	<div></div>
        </div>
        
        <div class='save_btn_cont' style="display:flex;justify-content:center;align-items:center;">
  <div><input id="time-save" class="btn btn-default" type="button" value="Save"></div>
</div>

       
       
		
	</div>
</div>