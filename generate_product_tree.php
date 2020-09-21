<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include dirname(__FILE__) ."/includes/configure.php";
date_default_timezone_set(SITE_TIMEZONE);
global $db_custom;
$db_custom = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

if(isset($_GET['term']) && !empty($_GET['term'])){
	global $db_custom;
	$qry  = "SELECT t.* ";
	$qry  .= " FROM (";
	$qry  .= "SELECT p.products_id id, ";
	$qry .= " pd.products_name, FORMAT(p.products_price, 2) as products_price, products_model, p.products_id, ";
	$qry .= " level_6.category_nm as menu_cat, level_5.category_nm as menu, level_4.category_nm as restaurant, level_3.category_nm as city ";
	$qry .= " FROM products p INNER JOIN products_description pd ON (p.products_id = pd.products_id) ";
	$qry .= " INNER JOIN products_to_categories ptc ON (ptc.products_id = p.products_id) ";
	$qry .= " INNER JOIN categories_tree level_6 ON (level_6.categories_id = ptc.categories_id AND level_6.level='6') ";
	$qry .= " INNER JOIN categories_tree level_5 ON (level_6.sort_order = level_5.categories_id AND level_5.level='5') ";
	$qry .= " INNER JOIN categories_tree level_4 ON (level_5.sort_order = level_4.categories_id AND level_4.level='4') ";
	$qry .= " INNER JOIN categories_tree level_3 ON (level_4.sort_order = level_3.categories_id AND level_3.level='3') ";
	$qry .= " WHERE pd.language_id = '1' ";
	$qry .= " AND pd.products_name like '%".urldecode($_GET['term'])."%' ";
	$qry .= " ORDER BY pd.products_name ";
	$qry .= " LIMIT 0, 100 ";
	$qry .= " ) as t ";
	$data = $db_custom->query($qry)->fetchAll(PDO::FETCH_ASSOC);
	if(!empty($data)){
		foreach($data as $key => $d){
			$lbl_city = htmlspecialchars_decode(htmlspecialchars($data[$key]['city']));
			$lbl_restaurant = htmlspecialchars_decode(htmlspecialchars($data[$key]['restaurant']));
			$lbl_menu = htmlspecialchars_decode(htmlspecialchars($data[$key]['menu']));
			$lbl_menu_cat = htmlspecialchars_decode(htmlspecialchars($data[$key]['menu_cat']));
			$lbl_products_name = htmlspecialchars_decode(htmlspecialchars($data[$key]['products_name']));

			$data[$key]['label'] = "$lbl_city -> $lbl_restaurant -> $lbl_menu -> $lbl_menu_cat -> $lbl_products_name";
			$data[$key]['value'] = "$lbl_city -> $lbl_restaurant -> $lbl_menu -> $lbl_menu_cat -> $lbl_products_name";

			unset($data[$key]['city']);
			unset($data[$key]['restaurant']);
			unset($data[$key]['menu']);
			unset($data[$key]['menu_cat']);
			unset($data[$key]['products_name']);
			unset($data[$key]['products_model']);
			unset($data[$key]['products_id']);
			unset($data[$key]['products_price']);
		}
		echo json_encode($data);
	}else{
		echo json_encode(array("value"=>"No Record Found"));
	}
	exit();
}
?>