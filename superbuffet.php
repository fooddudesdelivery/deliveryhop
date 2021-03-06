<?php
ini_set('display_errors',true);
require('includes/application_top.php');
ini_set('display_errors',true);
require('order_online/vendor/autoload.php');
require('order_online/class/zarocredit.php');
require('includes/configure.php');
$wok = new CreditCard;
if(isset($_GET['wokorder'])){
	if(isset($_GET['payment_method_nonce'])){
		$salestax=$_GET['tax'];
		$subtotal=$_GET['subtotal'];
		$delivery_fee=$_GET['delivery'];
		$total=$salestax+$subtotal+$delivery_fee;
		$token = $wok->authorizeTransaction($_GET['payment_method_nonce']);
		$wok->processTransaction($total+10,$total);
	}else{
		orderGenerateZaroty($_GET);
	}
	header('Location: '.SITE_FRONT_URL.'superbuffet.php?complete=1');
	die;
}
echo '<script>DEFINE={},DEFINE.BRAINTREE_JS_KEY="'.$wok->getClientId().'"</script>';
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo '/../order_online/js/wokjs.js' ?>"></script>
		<script>
			var wok = new CreditCard();
			wok.initilize();
			$(document).ready(function(e){
				$('.kill').click(function(){
					$(this).val('');
				});
				$(document).on('keyup','.am',function(){
					var tot = 0;
					$('.am').each(function(index, element){
						tot+=parseFloat(this.value);
					});
					$('#Total').val(tot.toFixed(2));
				});
				$(document).on('keyup','#Subtotal',function(){});
			});
			function validate(){
				haserr=false;
				$('.check').each(function(index, element){
					if(this.value==0 || this.value==''){
						haserr=true;
						$(this).css('border','1px solid red');
					}
				});
				if(haserr){
					alert('Please fill out required fields');
					return false;
				}else{
					return true;
				}
			}
			function changepay(val){
				console.log(val);
				if(val=='Credit'){
					$('#main_submit').hide();
					$('#ccfields').slideDown(200);
				}else{
					$('#main_submit').show();
					$('#ccfields').slideUp(200);
				}
			}
			function changecity(val){
				switch(val){
					case 'Sartell':$('#Zipcode').val(56377); break;
					case 'St Joesph':$('#Zipcode').val(56374); break;
					case 'Sauk Rapids':$('#Zipcode').val(56379); break;
					case 'Waite Park':$('#Zipcode').val(56387); break;
					default:$('#Zipcode').val('');break;
				}
			}
		</script>
	</head>
	<body>
		<div class="container">
			<?php if(isset($_GET['error'])){ ?>
				<div class="alert alert-danger"><?php echo $_GET['error'] ?></div>
			<?php } ?>
			<?php if(isset($_GET['complete'])){  ?>
				<div class="alert alert-success">Order Created</div>
			<?php } ?>
			<form method="get" action="" class="frm" id="main" onSubmit="return validate()">
				<input type="hidden" name="action" value="add">
				<div class="form-group" >
					<label for="Number">Super Buffet Order Number</label>
					<input name="wokorder" type="number" class="kill form-control check" id="Number" value="1">
				</div>
				<div class="form-group">
					<label for="Phone">Phone</label>
					<input name="phone" type="tel" class="form-control check" id="Phone">
				</div>
				<div class="form-group">
					<label for="Name">Name</label>
					<input name="name" type="text" class="form-control" id="Name">
				</div>
				<div class="form-group">
					<label for="Company">Company</label>
					<input name="company" type="text" class="form-control" id="Company">
				</div>
				<div class="form-group">
					<label for="Address">Address</label>
					<input name="address" type="text" class="form-control check" id="Address">
				</div>
				<div class="form-group">
					<label for="Apt">Apt/Suite</label>
					<input name="apt" type="text" class="form-control" id="Apt">
				</div>
				<div class="form-group">
					<label for="City">City</label>
					<input name="city" type="text" class="form-control" id="City" value="Fargo">
				</div>
				<div class="form-group">
					<label for="Zipcode">Zipcode</label>
					<input name="zip" type="text" class="form-control" id="Zipcode" value="">
				</div>
				<div class="form-group">
					<label for="Subtotal">Subtotal</label>
					<input name="subtotal" type="text" class="form-control kill am check" id="Subtotal" value="0">
				</div>
				<div class="form-group">
					<label for="Delivery">Delivery Fee</label>
					<input name="delivery" type="text" class="form-control kill am check" id="Delivery" value="4.99">
				</div>
				<div class="form-group">
					<label for="Tax">Tax</label>
					<input name="tax" type="text" class="form-control kill am check" id="Tax" value="0">
				</div>
				<div class="form-group">
					<label for="Total">Total</label>
					<input readonly type="text" class="form-control" id="Total" value="0">
				</div>
				<div class="form-group">
					<label for="Special">Special Instructions</label>
					<textarea name="special" class="form-control" id="Special" ></textarea>
				</div>
				<div class="form-group">
					<label for="type">Payment Type</label>
					<select name="type" class="form-control" id="type" onChange="changepay(this.value)">
						<option value="Cash" selected="selected">Cash</option>
						<option value="Credit">Credit</option>
					</select>
				</div>
				<button type="submit" id="main_submit" class="col-xs-12 btn btn-default subbtn">Submit</button>
			</form>
			<span id="ccfields" style="display:none">
				<form method="post" action="" class="frm" id="gwok" onSubmit="return validate()">
					<div class="form-group">
						<label for="bcredit">Card Number</label>
						<div id="bcredit" class="form-control"></div>
					</div>
					<div class="form-group col-xs-4" style="padding-left:0px">
						<label for="bmonth">Expiration Month</label>
						<div id="bmonth" class="form-control"></div>
					</div>
					<div class="form-group col-xs-4">
						<label for="byear">Expiration Year</label>
						<div id="byear" class="form-control"></div>
					</div>
					<div class="form-group col-xs-4" style="padding-right:0px">
						<label for="bcvv">Cvv code</label>
						<div id="bcvv" class="form-control"></div>
					</div>
					<button type="submit" class="col-xs-12 btn btn-default subbtn">Submit</button>
				</form>
			</span>
			<div style="height:100px;"></div>
		</div>
	</body>
</html>