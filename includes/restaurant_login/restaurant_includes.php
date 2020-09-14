<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">




<link rel="stylesheet" type="text/css" href="includes/restaurant_login/bootstrap.css">
<link rel="stylesheet" type="text/css" href="includes/restaurant_login/daterangepicker-bs3.css" />
<script type="text/javascript" src="includes/restaurant_login/jquery.js"></script>
<script type="text/javascript" src="includes/restaurant_login/bootstrap.js"></script>
<script type="text/javascript" src="includes/restaurant_login/moment.js"></script>
<script type="text/javascript" src="includes/restaurant_login/daterangepicker.js"></script>
<script type="text/javascript" src="includes/restaurant_login/jssync.js"></script>
<audio id="rocknroll" src="includes/restaurant_login/alarm_beep.mp3" > </audio>

<style>
.info-panel-inside{
	font-size:24px !important;
	line-height:26px;
	white-space: nowrap;
}


.fieldset_order{
	/*white-space: nowrap;*/
}
.orders_price{
	text-align:right;	
}
.cog-modal{
	line-height:20px;	
}
.panel-body{
	padding-top:0px;	
}
.money_f{
	float:right;
}
@media screen and (max-width: 500px) {
.info-panel-inside{
	font-size:14px !important;
	line-height:16px;
	}

}
@media screen and (max-width: 600px) {
.info-panel-inside{
	font-size:18px !important;
	line-height:20px;
	}

}
<? if($_SESSION['categories_id']==11833){ ?>
#adjustment-input{
		width:89px;
		margin:0px;
		padding:0px;
		margin-right:-5px;
		height:75px;
}
<?php } ?>
.info-panel,.restaurant-heading,.modal-section{
	padding-left:0px;
	padding-right:0px;
}
.main-panel{
	padding:0px;
}
.glyphicon,.input-group-addon,a,.panel-heading{
	cursor:pointer;
}
.modal-section{
	margin-bottom:20px;	
}
#price-change-comment{
	resize: none;
}
body{
	min-height:800px;
	font-size:18px;
}
#time-select{
	display:none;
}
.drop-panel{
}
.confirm-btn{
	width:100%;
	margin-top:15px;
	border:1px solid #ef6f00;
}
.other-btn{
	
	margin-top:15px;
	border:1px solid #ef6f00;
}

</style>
<script>


$(document).ready(function(e) {
	$(document).on('click','.complete_order_btn',function(){
		var complete_id = $(this).attr('data-id');
		$.ajax({
			  url:'',
			  dataType:"text",
			  data:{complete_order:complete_id},
			  type:'POST',
			  success: function(data){
				  $('#'+complete_id+'-main-panel').hide();
			  },
			  error: function(data){
				  alert('There has been an error');
			  }
			});
		//complete_order
	});
	$(document).on('click','.confirm-btn',function(){
		z_.android_input('stop_sound');
		
		if(window.Android){
			window.Android.android_stop_sound();
		}
		
		if(window.timer){
			clearTimeout(window.timer);
		}
		z_.set_orders_id($(this).attr('data-id'));
		z_.set_orders_status(4);
		z_.change_orders_status();
		z_.android_input('display','Order Accepted');
	});
	$(document).on('click','#reprint',function(){
		console.log('asdasd');
		z_.reprint();
	});
	
	$(document).on('click','#refresh-btn',function(){
		if(window.Android){
			window.Android.android_refresh();
		}
		z_.android_input('display','Refresh');
		z_.screen_refresh('reload');
		 
		//z_.play_sound();
	});
	$(document).on('click','#main_brand',function(){
		if(window.Android){
			window.Android.android_refresh();
		}
		z_.android_input('display','Refresh');
		z_.screen_refresh('reload');
		 
		//z_.play_sound();
	});
	$(document).on('click','.z_order,.z_function,.z_nav_select',function(){
		//dumb idea, unwork this whole thing
		z_.click_handle(this);
	})
	$(document).on('click','.drop-panel',function(){
		$($(this).attr('data-drop')).slideToggle(100);
	});
	$(document).on('click','.cog-modal',function(e){
		e.stopPropagation();
		z_.set_orders_id($(this).attr('data-id'));
		z_.toggle_price_modal();
	});
	$(document).on('click','.total-change',function(e){
		z_.modify_adjustment(this.id);
	});
	$(document).on('click','#save-btn',function(e){
		z_.set_orders_comment($('#price-change-comment').val());
		z_.price_change(this.id);
	});
	$(document).on('click','#logout',function(e){
		z_.logout();
	});
	//$(document).on('click','#play_sound',function(e){
//		z_.android_input('stop_sound');
//	});
	z_.set_categories_id(<?php echo $_SESSION['categories_id'] ?>);
	z_.set_send_method_code('<?php echo $_SESSION['dispatch']['send_method_code'] ?>');
	z_.set_cloud_print_id('<?php echo $_SESSION['dispatch']['cloud_print_id'] ?>');
	z_.set_orders('<?php echo $_SESSION['sync']->get_orders_object() ?>');
	z_.set_orders_status_name('<?php  echo json_encode($_SESSION['sync']->get_orders_status_name());  ?>');
	z_.set_sync_rate(10000);
	z_.send();



$(function() {
    $('#reportrange span').html(moment().format('MMMM D, YY') + ' - ' + moment().format('MMMM D, YY'));
 
    $('#reportrange').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment(),
        endDate: moment(),
        minDate: '01/01/2007',
        maxDate: '12/31/2019',
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-default',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Search',
            cancelLabel: 'Cancel',
            fromLabel: 'Start',
            toLabel: 'End',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
		z_.change_date(start.toISOString(), end.toISOString());
        $('#reportrange span').html(start.format('MMMM D, YY') + ' - ' + end.format('MMMM D, YY'));
    });
 
});


	
});//eof document ready
</script>
