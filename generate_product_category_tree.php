<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include dirname(__FILE__) ."/db_config.php";

date_default_timezone_set('America/Chicago');

global $db_custom;

$db_custom = new PDO("mysql:host="._DB_SERVER.";dbname="._DB_DATABASE, _DB_SERVER_USERNAME, _DB_SERVER_PASSWORD);

//$db_custom = new PDO("mysql:host=".'192.168.1.11'.";dbname=".'dbfooddu_dev', 'dbfooddu_dev', 'jqMOEj#IdPKt');

if(isset($_GET['term']) && !empty($_GET['term'])){
	global $db_custom;
	//$10 Lunch : in Lunch - ID#13056
	/*$qry   = " SELECT categories_id id, CONCAT (categories_name,' : in ', parent, ' - ID#', categories_id) label, CONCAT (categories_name,' : in ', parent, ' - ID#', categories_id) value";
	$qry   .= " FROM (";
	$qry  .= " SELECT distinct c.categories_id, cd.categories_name, ";
	$qry  .= " (SELECT cd_.categories_name FROM categories c_ INNER JOIN categories_description cd_ ON (c_.parent_id=cd_.categories_id) WHERE c_.categories_id=c.categories_id) as parent";
	$qry  .= " FROM categories c ";
	$qry  .= " INNER JOIN categories_description cd   ON (   c.categories_id = cd.categories_id)";
	$qry  .= " INNER JOIN products_to_categories ptoc ON (ptoc.categories_id = c.categories_id )";
	$qry  .= " WHERE cd.language_id = '1' ";
	$qry  .= " AND cd.categories_name like '".urldecode($_GET['term'])."%' ";
	$qry  .= " ORDER BY cd.categories_name ";
	$qry  .= " ) as t";*/

	$qry = "SELECT t.*
	FROM (
		SELECT
		tbl_level_3.categories_id as id,
		tbl_level_3.category_nm label,
		tbl_level_3.category_nm value
		FROM categories_tree as tbl_level_3
		WHERE tbl_level_3.level = '3' AND tbl_level_3.category_nm !='' AND tbl_level_3.category_nm like '".$_GET['term']."%'
		UNION ALL
		SELECT
		tbl_level_2.categories_id as id,
		tbl_level_2.category_nm label,
		tbl_level_2.category_nm value
		FROM categories_tree as tbl_level_2
		WHERE tbl_level_2.level = '2' AND tbl_level_2.category_nm !='' AND tbl_level_2.category_nm like '".$_GET['term']."%'
		UNION ALL
		SELECT
		tbl_level_6.categories_id as id,
		CONCAT (
			tbl_level_3.category_nm, ' -> ', tbl_level_4.category_nm, ' -> ', tbl_level_5.category_nm, ' -> ',
			tbl_level_6.category_nm
		) as label,
		CONCAT (
			tbl_level_3.category_nm, ' -> ',
			tbl_level_4.category_nm, ' -> ', tbl_level_5.category_nm, ' -> ',
			tbl_level_6.category_nm
		) as value
		FROM categories_tree as tbl_level_2
		LEFT JOIN categories_tree as tbl_level_3 
		ON (tbl_level_2.categories_id=tbl_level_3.sort_order AND tbl_level_3.level = '3')
		LEFT JOIN categories_tree as tbl_level_4 
		ON (tbl_level_3.categories_id=tbl_level_4.sort_order AND tbl_level_4.level = '4')
		LEFT JOIN categories_tree as tbl_level_5 
		ON (tbl_level_4.categories_id=tbl_level_5.sort_order AND tbl_level_5.level = '5')
		LEFT JOIN categories_tree as tbl_level_6 
		ON (tbl_level_5.categories_id=tbl_level_6.sort_order AND tbl_level_6.level = '6')
		LEFT JOIN categories_tree as tbl_level_7 
		ON (tbl_level_6.categories_id=tbl_level_7.sort_order AND tbl_level_7.level = '7')
		WHERE tbl_level_2.level = '2'
		";
		if(!empty($_GET['term'])){
			$qry .= "AND (tbl_level_2.category_nm like '".$_GET['term']."%' OR tbl_level_3.category_nm like '".$_GET['term']."%' OR tbl_level_4.category_nm like '".$_GET['term']."%' OR tbl_level_5.category_nm like '".$_GET['term']."%' OR tbl_level_6.category_nm like '".$_GET['term']."%' OR tbl_level_7.category_nm like '".$_GET['term']."%')";
		}

	$qry .= ") as t WHERE t.id IS NOT NULL LIMIT 0, 100";

	$data = $db_custom->query($qry)->fetchAll(PDO::FETCH_ASSOC);

	if(!empty($data)){
		foreach($data as $key => $d){
			$data[$key]['label'] = htmlspecialchars_decode(htmlspecialchars($data[$key]['label']));
			$data[$key]['value'] = htmlspecialchars_decode(htmlspecialchars($data[$key]['value']));
		}
		echo json_encode($data);
	}else{
		echo json_encode(array("value"=>"No Record Found"));
	}
	exit();
}
?>