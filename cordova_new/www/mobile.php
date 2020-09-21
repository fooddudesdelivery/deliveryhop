<?php if($_SERVER["HTTPS"] != "on"){header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);die;}?>

<!DOCTYPE html>

<html>

<head>

    <meta content="telephone=no" name="format-detection">

    <meta content="no" name="msapplication-tap-highlight">

    <meta content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" name="viewport">

    <title>Restaurant</title>
	<link href="https://deliverhop.app/cordova_new/www/css/login.css" rel="stylesheet" type="text/css">
    <link href="https://deliverhop.app/cordova_new/www/css/jquerymobile.css" rel="stylesheet" type="text/css">

    <link href="https://deliverhop.app/cordova_new/www/css/bootstrap.css" rel="stylesheet" type="text/css">

    <link href="https://deliverhop.app/cordova_new/www/css/datepicker.css" rel="stylesheet" type="text/css">

    <link href="https://deliverhop.app/cordova_new/www/mycss/master.css" rel="stylesheet" type="text/css">
	
    <script src="https://deliverhop.app/cordova_new/www/js/jquery.js" type="text/javascript"></script>
    <script src="https://deliverhop.app/cordova_new/www/myjs/login.js" type= "text/javascript"></script>
	<script src="https://deliverhop.app/cordova_new/www/myjs/receive.js" type="text/javascript"></script>
      <link href="https://deliverhop.app/cordova_new/www/mycss/availability.css" rel="stylesheet" type="text/css" />


  <script>

        $(document).on("mobileinit",function() {
            $.mobile.autoInitializePage = false;
        });

    </script>

    <script src="https://sdk.pushy.me/web/1.0.5/pushy-sdk.js"></script>
    <script type="text/javascript">
        // Matellio: 5dc2765dc5e2e11635961406
        // Fooddues: 56c802bb511fddbc5fe16a80
        // Register device for push notifications
        Pushy.register({ appId: '56c802bb511fddbc5fe16a80' }).then(function (deviceToken) {
            window.device_id = deviceToken;
            window.localStorage.setItem("device_id", deviceToken);
            document.getElementById('restaurant-device-id').value = deviceToken;
            // setCookie('device_id',deviceToken,99);

            var d = new Date();
            d.setTime(d.getTime() + (99*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = "device_id=" + deviceToken + "; " + expires;

            // Print device token to console
            console.log('Pushy device token: ' + deviceToken);
            // alert('Pushy device token: ' + deviceToken);
            // Send the token to your backend server via an HTTP GET request
            //fetch('https://your.api.hostname/register/device?token=' + deviceToken);

            // Succeeded, optionally do something to alert the user
        }).catch(function (err) {
            // Handle registration errors
            console.error(err);
        });
    </script>
</head>

<body style="overflow-y: scroll;">

    <div data-role="panel" hidden="" id="mainPanel">
        <input id="restaurant-device-id" type="hidden" value="">
        <a class="ui-btn h-btn" data-transition="slide" href="javascript:void(0)">
            Status
            <label class="switch switch-restaurant switch-flat">
                <input id="restaurant-availability" type="checkbox" class="switch-input">
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
        </a>

        <a class="ui-btn h-btn" data-transition="slide" href="javascript:void(Tawk_API.toggle())">Live Chat</a>

        <a class="ui-btn h-btn" data-transition="slide" href="#current">Current Orders</a>

        <a class="ui-btn h-btn" data-transition="slide" href="#future">Future Orders</a>

        <a class="ui-btn h-btn" data-transition="slide" href="#past">Past Orders</a>

        <a class="ui-btn h-btn" data-transition="slide" href="#report">Reports</a>
        <a class="ui-btn h-btn" data-transition="slide" href="#menu_on_off">Menu</a>
        <a class="ui-btn h-btn" data-transition="slide" href="#fast_order" id="fastorder">Fast Order</a>
        <a class="ui-btn h-btn" data-transition="slide" href="#myprofile" id="my_profile">Profile</a>
        <a class="ui-btn h-btn" data-transition="slide" href="#mysettings" id="my_settings">Settings</a>
        <a class="ui-btn h-btn" data-transition="slide"  href="#logout" id="logoutbtn">Log Out</a>  

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

    <div data-role="page" data-theme="a" id="menu_on_off">
      <div class="ui-content" role="main">
        <div id="mod_menu"></div>
        <div id="menu_on_off_box"></div>
      </div>
    </div>

    <div data-role="page" data-theme="a" id="myprofile">
      <div class="ui-content" role="main">
        <div id="myprofile_box"></div>
      </div>
    </div>    

    <div data-role="page" data-theme="a" id="mysettings">
        <div class="ui-content" role="main">
        <div id="mysettings_box"></div>
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
            <div class="clearFix loginSection"></div>
            <form class="loginSection">
            <div class="form-group">
                <input type="text" id="username" class="form-control" placeholder="Username">
            </div>
            
            <div class="form-group">
                <input type="password" id="password" class="form-control" placeholder="Password">
            </div>
            <button type="button" id="login_btn" class="form-control">Log In</button>
            <a id="forgot_password_link" href="javascript:void(0);" class="forgot_password">Forgot Password</a>
            </form>
            <div class="clearFix clearfixBoth passwordSection"></div>
            <form class="passwordSection">
              <div class="form-group">
                <input type="text" id="forgot_password_email"
                  class="form-control" placeholder="Enter Email Address" />
              </div>

              <button type="button" id="forgot_password_request_reset"
                class="form-control">
                Request Reset
              </button>
              <button type="button" id="forgot_password_cancel"
                class="form-control">
                Cancel
              </button>
            </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="availability-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Restaurant Availability</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <p id="status-message"></p>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button id="confirm-no" class="btn btn-default">Cancel</button>
        <button  id="confirm-yes" class="btn btn-default">Confirm</button>
      </div>
    </div>
  </div>
</div>

	<script src="https://deliverhop.app/cordova_new/www/js/bootstrap.js" type="text/javascript"></script>
    
    <script src="https://deliverhop.app/cordova_new/www/js/jquerymobile.js" type="text/javascript"> </script>

    <script src="https://deliverhop.app/cordova_new/www/js/chart.js" type="text/javascript"> </script>

    <script src="https://deliverhop.app/cordova_new/www/js/touch.js" type="text/javascript"></script>

    <script src="https://deliverhop.app/cordova_new/www/js/moment.js" type="text/javascript"> </script> 

	<script src="https://deliverhop.app/cordova_new/www/js/datepicker.js" type="text/javascript"> </script>

    <script src="https://deliverhop.app/cordova_new/www/js/react.js" type="text/javascript"></script>

    <script src="https://deliverhop.app/cordova_new/www/js/reactdom.js" type="text/javascript"></script>

	

    <script src="https://deliverhop.app/cordova_new/www/myjs/compro.js" type="text/javascript"></script>
    
    

    <script src="https://deliverhop.app/order_online/js/wokjs.js"></script>

    <script>
    DEFINE={},DEFINE.BRAINTREE_JS_KEY=""
    </script>
    
<!--Start of Tawk.to Script-->
  <script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/5cc7e7eed07d7e0c639138b0/default';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
<!--End of Tawk.to Script-->

</body>

<style type="text/css">
  .modal-header .close {
    margin-top: -20px;
  }
  button#login_btn {
    text-align: center;
  }
  .switch {
    position: relative;
    display: inline-block !important;
    width: 80px;
    height: 34px;
    float: right;
    margin: -8px 0 0 0 !important;
  }

  .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input.on + .slider {
    background-color: #ef6f00;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #ef6f00;
  }

  input.on + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>
</html>