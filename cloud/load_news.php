<?php
require "../lib/app_top_admin.php";

$query = "SELECT * FROM news WHERE id='{$_REQUEST['news_id']}'";
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

<input type="hidden" id="action" name="news" value="save" />
<input type="hidden" name="news_id" value="<?=$_REQUEST['news_id']?>" />

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
   
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Category:<br />
			<select name="news_category_id" class="form-control">
            	<option>Select</option>
				<?=htmlOptions($newsCategArr, $recordsList[0]['category_id']);?>
			</select>
		</td>
	  </tr>
      
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Title:<br />
        	<input type="text" name="news_title" value="<?=no_magic_quotes($recordsList[0]['title'])?>" id="form_name" class="form-control"  /></td>
	  </tr>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Content:<br />
        	<textarea name="news" id="content" class="form-control autogrow" style="height:500px;" ><?=no_magic_quotes($recordsList[0]['news'])?></textarea>
        </td>
      </tr>
      
      <tr>  
		<td colspan="3">
        	Upload your image:<br />
            <?
			if($recordsList[0]['image'] != '')	{
			?>	
            	<div id="jkimg"><img src="../images/news/<?=$recordsList[0]['image']?>" width="50" height="50px;"  /></div>
			<?
			}	
            ?>
		               
           <input type="file" id="news_image" name="news_image" class="form-control" data-label="<i class='glyphicon glyphicon-file'></i> Browse"  />           
          
		</td>

	  </tr>
      
        
        
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
            <button type="submit" name="case_study" class="btn btn-primary pull-right">Save</button>
		</td>
	  </tr>
      <br /><br />
      
</table>
</form>
