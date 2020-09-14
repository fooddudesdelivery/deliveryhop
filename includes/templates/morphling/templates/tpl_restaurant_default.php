<?php

//

// +----------------------------------------------------------------------+

// |zen-cart Open Source E-commerce                                       |

// +----------------------------------------------------------------------+

// | Copyright (c) 2003 The zen-cart developers                           |

// |                                                                      |

// | http://www.zen-cart.com/index.php                                    |

// |                                                                      |

// | Portions Copyright (c) 2003 osCommerce                               |

// +----------------------------------------------------------------------+

// | This source file is subject to version 2.0 of the GPL license,       |

// | that is bundled with this package in the file LICENSE, and is        |

// | available through the world-wide-web at the following url:           |

// | http://www.zen-cart.com/license/2_0.txt.                             |

// | If you did not receive a copy of the zen-cart license and are unable |

// | to obtain it through the world-wide-web, please send a note to       |

// | license@zen-cart.com so we can mail you a copy immediately.          |

// +----------------------------------------------------------------------+

// $Id: tpl_band_restaurant_default.php,v 1.3 2007/06/07 00:00:00 DrByteZen Exp $

//
include_once dirname(__FILE__) . '/../../../../db_config.php';
?>

<style>

	.driver_label{

		width:400px;

		font-weight:300;

	}

</style>



<div class="centerColumn" id="menuDefault">



<?php if ($messageStack->size('restaurant') > 0) echo $messageStack->output('restaurant'); ?>





<?php

  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {

?>



<script>

$(document).ready(function(e) {

	

    setTimeout(function(){

		window.location.replace("<?php echo HTTP_SERVER  ?>");

	},5000);

});



</script>



<div style="font-size:18px"><?php echo TEXT_SUCCESS; ?></div>



<?php

  } else {

	  

?>

<h1><?php //echo HEADING_TITLE; ?></h1>

<?php

/**

* require the html_define for the menu page

*/

require($define_page);

?>



<?php echo zen_draw_form('restaurant', zen_href_link(FILENAME_RESTAURANT, 'action=send')); ?>





 <div class='container'>

    <legend>Restaurant Sign Up</legend>

        <form action="<?php echo _SITE_FRONT_URL ?>/restaurantowners" method="post" >

        	<input type='hidden' name='submit' value='restaurant_submit'>

        	<label class='driver_label'>

           		Restaurant Name:

            	<input type='text' name='restaurant_name' class='form-control'>

            </label>

            <br>

            <label class='driver_label'>

           		Restaurant Address:

            	<input type='text' name='restaurant_address' class='form-control'>

            </label>

            <br>

            <label class='driver_label'>

           		Contact Name:

            	<input type='text' name='contact_name' class='form-control'>

            </label>

            <br>

          	<label class='driver_label'>

           		Phone Number:

            	<input type='text' name='phone_number' class='form-control'>

            </label>

            <br>

           <label class='driver_label'>

           		Email Address:

            	<input type='text' name='email_address' class='form-control'>

            </label>

            <br>



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

</div>