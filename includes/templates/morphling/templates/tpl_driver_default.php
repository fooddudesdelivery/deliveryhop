<?php

/**

* @package page template

* @copyright Copyright 2003-2006 Zen Cart Development Team

* @copyright Portions Copyright 2003 osCommerce

* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

* @version $Id: Define Generator v0.1 $

*/



// THIS FILE IS SAFE TO EDIT! This is the template page for your new page 


include_once dirname(__FILE__) . '/../../../../db_config.php';
?>



<style>

	#driver{

	background-image: url(includes/templates/morphling/images/road.png);

    background-repeat: repeat-x;

    background-position: top;

 		 	}

			

	@media (max-width: 600px) {

	#driver{

    background-image: none !important;

  }

}



	.driver_label{

		width:400px;

		font-weight:300;

	}



</style>



<!-- bof tpl_driver_default.php -->

	<div class='centerColumn' id='driver'>

    

    <?php

  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {

?>



<script>

$(document).ready(function(e) {

    setTimeout(function(){

		window.location.replace(SITE_URL);

	},5000);

});



</script>



<div style="font-size:18px"><?php echo TEXT_SUCCESS; ?></div>



<?php

  } else {

	  

?>



		<h3 id='driver-heading'><?php echo HEADING_TITLE; ?></h3>

		<div id='driver-content' class='content'>

		<?php

		/**

		* require the html_define for the driver page

		*/

		require($define_page);

?>

		</div>

	</div>

    <br />

    <div class='container'>

    <legend>Driver Sign Up</legend>

        <form action="index.php?main_page=driver" method="post" >

        	<input type='hidden' name='submit' value='driver_submit'>

        	<label class='driver_label'>

           		First Name:

            	<input type='text' name='firstname_driver' class='form-control'>

            </label>

            <br>

            <label class='driver_label'>

           		Last Name:

            	<input type='text' name='lastname_driver' class='form-control'>

            </label>

            <br>

            <label class='driver_label'>

           		Phone Number:

            	<input type='text' name='phone_driver' class='form-control'>

            </label>

            <br>

          	<label class='driver_label'>

           		Email Address:

            	<input type='text' name='email_driver' class='form-control'>

            </label>

            <br>

 <!--           <label class='driver_label'>

           		Vehicle Make/Model:

            	<input type='text' name='car_driver' class='form-control'>

            </label>

            <br>-->

            <label class='driver_label'>

           		Age 21 or Older?:

            	<select class='form-control' name='above21_driver'>

                <option value='1'>Yes</option>

                <option value='0'>No</option>

                </select>

            </label>

            <br>

            <label class='driver_label'>

           		City:

            	<select class='form-control' name='city_driver'>

                <?php echo $select_options ?>

                </select>

            </label>

            <br>

        	<!--<label class='driver_label'>

           		Comments:

            	<textarea class='form-control' name='comments_driver'>

                

                </textarea>

                            </label>



<label class='driver_label'>Comments:

<?php // echo zen_draw_textarea_field('comments', 30, 4, zen_output_string_protected($comments), 'class="form-control" name="comments_driver"'); ?>

</label>-->



<label class="driver_label" for="comments">Comments:

<?php echo zen_draw_textarea_field('comments', 30, 4, zen_output_string_protected($comments), 'id="comments" class="form-control"'); ?>

</label>



<br class="clearBoth" />

<div class="buttonRow back"><?php echo recaptcha_get_html(); ?></div>



            <div class="buttonRow back"><?php echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_SEND_ALT); ?></div>



           <!-- <input type='submit' value='Send Now' class='btn btn-default'> -->

        </form>

    <?php

  }

?>

    </div>

<!-- eof tpl_driver_default.php -->

