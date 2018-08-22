<?php 
require "../lib/app_top_admin.php";
$array	= $_REQUEST['arrayorder'];
$tbl	= $_REQUEST['table'];

if ($_POST['update'] == "update"){
	
	$count = 1;
	foreach ($array as $idval) {
		$query = "UPDATE $tbl SET sort_order = " . $count . " WHERE id = " . $idval;
		dbQuery($query);
		$count ++;	
	}
}
?>