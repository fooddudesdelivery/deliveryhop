<?php if($_SERVER["HTTPS"] != "on"){header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);die;}?>

<!DOCTYPE html>

<html>

<head>

    <meta content="telephone=no" name="format-detection">

    <meta content="no" name="msapplication-tap-highlight">

    <meta content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" name="viewport">

    <title></title>
	<link href="https://deliverhop.app/cordova/www/css/login.css" rel="stylesheet" type="text/css">
    <link href="https://deliverhop.app/cordova/www/css/jquerymobile.css" rel="stylesheet" type="text/css">

    <link href="https://deliverhop.app/cordova/www/css/bootstrap.css" rel="stylesheet" type="text/css">

    <link href="https://deliverhop.app/cordova/www/css/datepicker.css" rel="stylesheet" type="text/css">

    <link href="https://deliverhop.app/cordova/www/mycss/master.css" rel="stylesheet" type="text/css">
	
    <script src="https://deliverhop.app/cordova/www/js/jquery.js" type="text/javascript"></script>
    <script src="https://deliverhop.app/cordova/www/myjs/login.js" type= "text/javascript"></script>
	<script src="https://deliverhop.app/cordova/www/myjs/receive.js" type="text/javascript"></script>
    <script>

        $(document).on("mobileinit",function() {

            $.mobile.autoInitializePage = false;

        });

    </script>


</head>

<body style="overflow-y: scroll;">

    <div data-role="panel" hidden="" id="mainPanel">

        <a class="ui-btn h-btn" data-transition="slide" href="#current">Current Orders</a>

        <a class="ui-btn h-btn" data-transition="slide" href="#future">Future Orders</a>

        <a class="ui-btn h-btn" data-transition="slide" href="#past">Past Orders</a>

        <a class="ui-btn h-btn" data-transition="slide" href="#report">Reports</a>

        <a class="ui-btn h-btn" data-transition="slide" href="#fast_order">Fast Order</a>
        
        <a class="ui-btn h-btn" data-transition="slide" id="logoutbtn">Log Out</a>  

        <!--<a class="ui-btn h-btn" data-transition="slide" href="#config">Config</a>-->

    </div>

    <div data-position="fixed" data-role="header" data-theme="a" style="display:none" id="header">

        <a class="ui-btn ui-btn-left ui-alt-icon ui-nodisc-icon ui-corner-all ui-btn-icon-notext ui-icon-carat-l"

        data-rel="back" href="#mainPanel">Back</a>

        <h1>Current Orders</h1>

    </div>

    <div data-role="page" id="current">

        <div class="ui-content" role="main">

            <div id="mod_order"></div>

            <div id="current_order_box"></div>

        </div>

    </div>

    <div data-role="page" id="future">

        <div class="ui-content" role="main">

            <div id="future_order_box"></div>

        </div>

    </div>

    <div data-role="page" id="past">

        <div class="ui-content" role="main">

            <div id="past_order_box"></div>

        </div>

    </div>

    <div data-role="page" data-theme="a" id="report">

        <div class="ui-content" role="main">

            <div id="report_box"></div>

        </div>

    </div>

    <div data-role="page" data-theme="a" id="fast_order">

        <div class="ui-content" role="main">

            <div id="fast_order_box"></div>

        </div>

    </div>

    <div data-role="page" data-theme="a" id="config">

        <div class="ui-content" role="main">

            <div id="config_box"></div>

        </div>

    </div>

    <div data-role="page" id="new_order">

        <div id="new_order_data"></div>

    </div>

<div data-role="page" id="login" >
   <div  class="ui-content" data-role="content" >
      <div class="container" id="logincontent" style="display:none">
         <div id="loginerror" class="alert alert-danger" role="alert" style="display:none"><b>Error! </b>Failed to login please try again</div>
         <div class="container login-cont" >
            <div class="fd-logo"></div>
            <div class="clearFix"></div>
            <form>
            <div class="form-group">
                <input type="text" id="username" class="form-control" placeholder="Username">
            </div>
            
            <div class="form-group">
                <input type="password" id="password" class="form-control" placeholder="Password">
            </div>
            <button type="button" id="login_btn" class="form-control">Log In</button>
            </form>
         </div>
      </div>
   </div>
</div>


	<script src="https://deliverhop.app/cordova/www/js/bootstrap.js" type="text/javascript"></script>
    
    <script src="https://deliverhop.app/cordova/www/js/jquerymobile.js" type="text/javascript"> </script>

    <script src="https://deliverhop.app/cordova/www/js/chart.js" type="text/javascript"> </script>

    <script src="https://deliverhop.app/cordova/www/js/touch.js" type="text/javascript"></script>

    <script src="https://deliverhop.app/cordova/www/js/moment.js" type="text/javascript"> </script> 

	<script src="https://deliverhop.app/cordova/www/js/datepicker.js" type="text/javascript"> </script>

    <script src="https://deliverhop.app/cordova/www/js/react.js" type="text/javascript"></script>

    <script src="https://deliverhop.app/cordova/www/js/reactdom.js" type="text/javascript"></script>

	

    <script src="https://deliverhop.app/cordova/www/myjs/compro.js" type="text/javascript"></script>
    
    

    <script src="https://deliverhop.app/order_online/js/wokjs.js"></script>

    <script>
    DEFINE={},DEFINE.BRAINTREE_JS_KEY=""
    </script>

</body>

</html>