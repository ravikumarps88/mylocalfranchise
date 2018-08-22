<?php
require "../lib/app_top_admin.php";

$query = "SELECT * FROM testimonials WHERE id='{$_REQUEST['testimonial_id']}'";
$recordsList = dbQuery($query);
?>

<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/jquery.counter-1.0.min.js"></script>

<!-- TinyMCE -->
<script type="text/javascript">
	
tinyMCE.init({	
// General options
	mode : "exact",
	elements : "content",
	theme : "advanced",
	plugins : "table,advimage,media",
	//content_css : "<?=APP_URL?>/stylesheet.php?id=<?=$pagename?>", 
	
	// Theme options
	theme_advanced_buttons1 : "save,cut,paste,pastetext,pasteword,copy,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,formatselect,sub,sup,image,media",
  theme_advanced_buttons2 : "bold,italic,underline,strikethrough,advhr,separator,bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,customdropdown,cmslinker,link,unlink,anchor,charmap,cleanup,separator,forecolor,backcolor,separator,code,help|advhr,removeformat,tablecontrols",
  theme_advanced_buttons3 : "",
  theme_advanced_buttons4 : "",
  extended_valid_elements : "object[width|height|classid|codebase],param[name|value],embed[src|type|width|height|flashvars|wmode],iframe[width|height|frameborder|scrolling|marginheight|marginwidth|src]",
  
	table_inline_editing : true,
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	file_browser_callback : "PUBNETFilePicker",
	relative_urls : false

});

function toggleEditor(id) {
	if (!tinyMCE.getInstanceById(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}

function PUBNETFilePicker (field_name, url, type, win) {
     
  var cmsURL = "<?=APP_URL?>/filepicker.php";
  
  tinyMCE.activeEditor.windowManager.open({
  
    file : cmsURL,
    title : 'File Selection',
    width : '700',
    height : '500',
    resizable : "yes",
    scrollbars : "yes",
    inline : "yes",
    close_previous : "no"
  
  }, {
    window : win,
    input : field_name
  });
  return false;
}
</script>

<form id="rootwizard-2" action="" method="post" enctype="multipart/form-data">

<input type="hidden" id="action" name="testimonial" value="save" />
<input type="hidden" name="testimonials_id" value="<?=$_REQUEST['testimonial_id']?>" />

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
   
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Name:<br />
        	<input type="text" name="name" value="<?=no_magic_quotes($recordsList[0]['name'])?>" id="form_name" class="form-control"  /></td>
	  </tr>
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Company:<br />
        	<input type="text" name="company" value="<?=no_magic_quotes($recordsList[0]['company'])?>" id="form_name" class="form-control"  /></td>
	  </tr>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Testimonial:<br />
        	<textarea name="testimonials" id="content" class="form-control autogrow" style="height:500px;" ><?=no_magic_quotes($recordsList[0]['testimonial'])?></textarea>
        </td>
      </tr>
        
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
            <button type="submit" name="testimonial" class="btn btn-primary pull-right">Save</button>
		</td>
	  </tr>
      <br /><br />
      
</table>
</form>
