<!DOCTYPE html>
<html>
	<head>
	    <meta content="telephone=no" name="format-detection" />
	    <meta content="no" name="msapplication-tap-highlight" />
	    <meta http-equiv="Content-Security-Policy" />
	    <meta content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" name="viewport" />

	    <link rel="icon" type="image/x-icon" href="https://deliverhop.app/images/pepper/faviconfd (1).ico" />
    
    	<title>Update Restaurant</title>
    	
    	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="css/master.css?tm=<?php echo time()?>" rel="stylesheet" type="text/css" />
	</head>

	<body>
		<?php include_once("../includes/configure.php");
		global $db;

		$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE."", DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
		$admin_id = $_GET["tm"];
		$category_id = $_GET["cat_id"];

		$flag = false;
		
		if(!empty($admin_id) && !empty($category_id)){
			$results = $db->query("SELECT admin_name FROM admin WHERE admin_id = '$admin_id' AND categories_id = '$category_id' ")->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($results)){
				$results = $results[0];
				$flag = true;
			}
		}

		if($flag){?>
			<div data-position="fixed" data-role="header" data-theme="a" id="header">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<h1 id="header_title" class="text-center header_title">Update Available</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="loader"></div>
				<div data-role="page" id="current">
					<div class="ui-content" role="main">
						<div id="download_box">
							<p>How to Install New Restaurant App</p>
							<p>Step 1 - Click the link to download the app. Link: <strong><a href="../20.apk">Click Here To Download</a></strong> </p>
							<p>Step 2 - This will download the new Android app on your tablet.</p>
							<p>Step 3 - Click and install the new downloaded build.</p>
							<p>Step 4 - Please enter your Username <strong>"<?php echo $results['admin_name']?>"</strong> and default password <strong>"1234asdf"</strong>.</p>
						</div>
					</div>
				</div>
			</div>
		<?php }else{?>
			<div data-position="fixed" data-role="header" data-theme="a" id="header">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<h1 id="header_title" class="text-center header_title">Access Denied</h1>
						</div>
					</div>
				</div>
			</div>
			<div data-role="page" id="current">
				<div class="ui-content" role="main">
					<div id="download_box">
						<p>You are not authorized to access this page</p>
					</div>
				</div>
			</div>
		<?php } ?>
  	</body>
</html>