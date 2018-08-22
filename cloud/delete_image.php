<?
require "../lib/app_top_admin.php";
if($_REQUEST['type'] == "news")	
	dbQuery("UPDATE news SET image='' WHERE id='".$_REQUEST['id']."'");

?>
<font style="color:#FF0000">Image Deleted</font>