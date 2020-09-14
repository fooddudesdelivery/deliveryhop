<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include dirname(__FILE__) ."/db_config.php";

date_default_timezone_set('America/Chicago');

global $db_custom;

$db_custom = new PDO("mysql:host="._DB_SERVER.";dbname="._DB_DATABASE, _DB_SERVER_USERNAME, _DB_SERVER_PASSWORD);

//$db = new PDO("mysql:host=".'192.168.1.11'.";dbname=".'dbfooddu_dev', 'dbfooddu_dev', 'jqMOEj#IdPKt',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

function zen_products_in_category_count($categories_id, $include_deactivated = false, $include_child = true, $limit = false) {

	global $db_custom;
	$products_count = 0;

	if ($limit) {
		$limit_count = ' limit 1';
	} else {
		$limit_count = '';
	}

	if ($include_deactivated) {
		$products = $db_custom->query("select count(*) as total
                            from products p, products_to_categories p2c
                            where p.products_id = p2c.products_id
                            and p2c.categories_id = '" . (int)$categories_id . "'" . $limit_count)->fetchAll(PDO::FETCH_ASSOC);
	} else {
		$products = $db_custom->query("select count(*) as total
                            from products p, products_to_categories p2c
                            where p.products_id = p2c.products_id
                            and p.products_status = 1
                            and p2c.categories_id = '" . (int)$categories_id . "'" . $limit_count)->fetchAll(PDO::FETCH_ASSOC);
	}

	$products_count += $products['total'];

	if ($include_child) {
		$childs = $db_custom->query("select categories_id from categories where parent_id = '" . (int)$categories_id . "'")->fetchAll(PDO::FETCH_ASSOC);
		foreach ($childs as $key => $ch) {
			$products_count += zen_products_in_category_count($ch['categories_id'], $include_deactivated);
		}
	}
	return $products_count;
}

function zen_get_category_tree($parent_id = '0', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = true, $category_has_products = false, $limit = false, $level_no = '0') {
    global $db_custom;

    if ($limit) {
      $limit_count = " limit 1";
    } else {
      $limit_count = '';
    }

    if (!is_array($category_tree_array)) $category_tree_array = array();
    if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => 'Top', 'level_no' => $level_no, 'parent' => '0');

    $level_no ++;
    
    if ($include_itself) {
      $category = $db_custom->query("SELECT c.categories_id, cd.categories_name, c.parent_id
                                FROM categories_description cd
                                INNER JOIN categories c on (c.categories_id=cd.categories_id)
                                WHERE cd.language_id = '1'
                                AND cd.categories_id = '" . (int)$parent_id . "'")->fetchAll(PDO::FETCH_ASSOC);
      if(!empty($category)){
      	$category_tree_array[] = array('id' => $category[0]['categories_id'], 'text' => $category[0]['categories_name'], 'parent'=>$category[0]['parent_id'], 'level_no' => $level_no);
      }
    }

    $categories = $db_custom->query("SELECT c.categories_id, cd.categories_name, c.parent_id, '".$level_no."' as level_no
	    FROM categories c, categories_description cd
	    WHERE c.categories_id = cd.categories_id
	    AND cd.language_id = '1'
	    AND c.parent_id = '" . (int)$parent_id . "'
	    ORDER BY c.sort_order, cd.categories_name")->fetchAll(PDO::FETCH_ASSOC);

    foreach($categories as $key => $cat){
      if ($category_has_products == true and zen_products_in_category_count($cat['categories_id'], '', false, true) >= 1) {
        $mark = '*';
      } else {
        $mark = '';
      }
      if ($exclude != $cat['categories_id']) $category_tree_array[] = array('id' => $cat['categories_id'], 'text' => $cat['categories_name'] . $mark, 'level_no'=>$cat['level_no'], 'parent' => $cat['parent_id']);
      $category_tree_array = zen_get_category_tree($cat['categories_id'], '', $exclude, $category_tree_array, '', false, false, $level_no);
    }

    return $category_tree_array;
}

if(isset($_GET['type']) && $_GET['type'] == "gen"){
	echo "Start";
	$cat_array = zen_get_category_tree();

	$db_custom->query("TRUNCATE categories_tree")->fetchAll(PDO::FETCH_ASSOC);

	foreach ($cat_array as $key => $cat){
		$qry = "INSERT INTO categories_tree (categories_id, category_nm, sort_order, level) VALUES ('".$cat['id']."','".addslashes(trim($cat['text']))."','".$cat['parent']."','".$cat['level_no']."');";
		$db_custom->query($qry)->fetchAll(PDO::FETCH_ASSOC);
	}
	echo "<br />Done";
	exit();
}else{
	global $db_custom;
	$qry = "SELECT t.*
	FROM (
		SELECT
		tbl_level_4.categories_id as id,
		CONCAT (tbl_level_3.category_nm, ' -> ', tbl_level_4.category_nm) label,
		CONCAT (tbl_level_3.category_nm, ' -> ', tbl_level_4.category_nm) value
		FROM categories_tree as tbl_level_4
		INNER JOIN categories_tree as tbl_level_3 ON( tbl_level_4.sort_order=tbl_level_3.categories_id AND tbl_level_3.level = '3')
		WHERE tbl_level_4.level = '4' AND tbl_level_4.category_nm !='' AND tbl_level_4.category_nm like '".$_GET['term']."%'
		UNION ALL
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
			tbl_level_2.category_nm, ' -> ', tbl_level_3.category_nm, ' -> ',
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

	$default = array(array("id"=>"0","label"=>"Top","value"=>"Top"));

	$data = $db_custom->query($qry)->fetchAll(PDO::FETCH_ASSOC);
	if(!empty($data)){
		foreach($data as $key => $d){
			$data[$key]['label'] = htmlspecialchars_decode(htmlspecialchars($data[$key]['label']));
			$data[$key]['value'] = htmlspecialchars_decode(htmlspecialchars($data[$key]['value']));
		}
		if(isset($_GET['profile']) && $_GET['profile'] == "1"){
			echo json_encode(array_merge($default, $data));
		}else{
			echo json_encode($data);
		}
	}else{
		if(isset($_GET['profile']) && $_GET['profile'] == "1"){
			echo json_encode($default);
		}else{
			echo json_encode(array("value"=>"No Record Found"));
		}
	}
	exit();
}
?>