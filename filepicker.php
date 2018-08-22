<?
require "lib/app_top.php";
$img	= getUploadedImages();
?>
<script language="javascript" type="text/javascript" src="fsadmin/js/tiny_mce_popup.js"></script>
<script type="application/javascript">
function SubmitElement(filename) {
  var URL = filename;
  var win = tinyMCEPopup.getWindowArg("window");

  // insert information now
  win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
  
   // close popup window
  tinyMCEPopup.close();
}
</script>

<?
foreach($img  as $val)	{
?>
	<a title="<?=$val['title']?>" href="#" onclick='SubmitElement("../upload/<?=$val['images_img']?>")'>
		<img src="<?=APP_URL?>/upload/thumbnail/<?=$val['images_img']?>" alt="<?=$val['title']?>" title="<?=$val['title']?>">
	</a>
<?	
}
?>