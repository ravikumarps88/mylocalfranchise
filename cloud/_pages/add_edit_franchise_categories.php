<?
if ($action=="save") {
	//echo "<pre>";
	//print_r($_REQUEST);
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
		
	$dbFields = array();	
	if($_FILES['logo']['size'] > 0)	{
		$filename	= '../upload/vendors/category/original/'.$_FILES['logo']['name'];
		copy($_FILES['logo']['tmp_name'],$filename);
	
		$filename	= '../upload/vendors/category/thumbnail/'.$_FILES['logo']['name'];
		ResizeImage($_FILES['logo']['tmp_name'], '545', '312', $filename);
		
		$logo		= $_FILES['logo']['name'];
		
		$dbFields['image'] 	= $logo;
	}	
	
	//adding
	$dbFields['category'] 		= $category;
	$dbFields['parent_id'] 		= $parent_id;
	
	$dbFields['description'] 	= addslashes($_REQUEST['description']);
	
	$dbFields['url_title'] 		= $url_title;
	$dbFields['title_tag'] 		= $title_tag;
	$dbFields['meta_description'] 	= $meta_description;
	$dbFields['meta_keywords'] 		= $meta_keywords;
		
	
	$dbFields['status'] 		= $status;
	
	$specialFields = array();
	if($_REQUEST['id'] != '')	{		
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_REQUEST['id'];
		$INFO_MSG = "category has been edited.";
	}	
	else	{
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');	
		$INFO_MSG = "category has been added.";
	}
	
	$new_id = dbPerform("franchise_categories", $dbFields, $specialFields, $cond);
	$action = "edit";
	
	$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
	
}

if($action == 'edit')	{
	$query = "select * from franchise_categories WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}



$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusArr[]	= array("optionId"=>"all","optionText"=>"All");

?>

<script type="text/javascript" src="js/tiny_mce.js"></script>
<script type="text/javascript" src="js/jquery.counter-1.0.min.js"></script>

<!-- TinyMCE -->
<script type="text/javascript">
	
tinyMCE.init({	
// General options
	mode : "exact",
	elements : "description",
	theme : "advanced",
	plugins : "fullscreen,table",
	//content_css : "<?=APP_URL?>/stylesheet.php?id=<?=$pagename?>", 
	content_css: "../style.css",
	
	// Theme options
	theme_advanced_buttons1 : "save,cut,paste,pastetext,pasteword,copy,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,formatselect,sub,sup,fullscreen",
  theme_advanced_buttons2 : "bold,italic,underline,strikethrough,advhr,separator,bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,customdropdown,cmslinker,link,unlink,anchor,image,charmap,cleanup,separator,forecolor,backcolor,separator,code,help|advhr,,removeformat,tablecontrols",
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

<!-- /TinyMCE -->

<? ############################################################################################## ?>
<!-- DATE PICKER -->
	<script>
		$(document).ready(function(){
		
		});
	</script>

<? ############################################################################################## ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li>
        <a href="index.php?_page=franchise_categories">Franchise Categories</a>
    </li>
    <li class="active">
        <strong>Add/Edit Franchise Categories</strong>
    </li>
</ol>


<form id="form_category" action="" method="post" enctype="multipart/form-data" class="validate">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="4" >
        	<p class="bs-example">
                <a href="index.php?_page=franchise_categories" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
                    
                <button type="submit" class="btn btn-primary pull-right">Save</button>
			</p>
            
        </td>
	  </tr> 	
  
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
        <td width="18%">Category: <a href="#" data-original-title="This is category title/name"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><input type="text" name="category" value="<?=no_magic_quotes($recordsList[0]['category'])?>" id="category" class="form-control" data-validate="required" data-message-required="required field." placeholder="Category"  /></td>
    
        <td style="vertical-align:top;">Parent Category: <a href="#" data-original-title="Enter the parent category"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><select name="parent_id" id="parent_id" class="selectboxit">
            	<option value="">Select</option>
                <option value="0" <?=$recordsList[0]['parent_id']==0? 'selected' : ''?> >None</option>
				<?=htmlOptions($parentCategorieseArr, $recordsList[0]['parent_id']);?>
			</select></td>
      </tr> 
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
        <td style="vertical-align:top;">Image: </td>
        <td>
        	<input type="file" id="logo" name="logo" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse"  /> Upload your logo 
            <img src="../upload/vendors/category/thumbnail/<?=$recordsList[0]['image']?>" class="img-responsive img-rounded" style="margin-top:5px;" />
        </td>
        <td width="18%">URL Title: <a href="#" data-original-title="This is how the url name will appear in the browser address bar"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><input type="text" name="url_title" value="<?=no_magic_quotes($recordsList[0]['url_title'])?>"  id="field-1" class="form-control"  /></td>
      </tr> 
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
        <td style="vertical-align:top;">Page Content: <a href="#" data-original-title="Enter the text or images you want to use on your web page here"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td colspan="3"><textarea name="description" id="description" class="form-control autogrow"><?=htmlspecialchars(no_magic_quotes($recordsList[0]['description']))?></textarea></td>
      </tr> 
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
        <td width="18%">Browser Title: <a href="#" data-original-title="This is how the page name will appear in the browser title/tab bar"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><input type="text" name="title_tag" value="<?=no_magic_quotes($recordsList[0]['title_tag'])?>"  id="field-1" class="form-control"  /></td>
    
        <td>Meta Keywords: <a href="#" data-original-title="Keywords used by search engines to identify important content"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><textarea id="minWord" name="meta_keywords" style="height:100px;" class="form-control autogrow"><?=no_magic_quotes($recordsList[0]['meta_keywords'])?></textarea></td>
      </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
        <td>Meta Description: <a href="#" data-original-title="A 200 character description or summary of your business & website"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><textarea id="minChar" name="meta_description" style="height:100px;" class="form-control autogrow"><?=no_magic_quotes($recordsList[0]['meta_description'])?></textarea></td>
      
        <td style="vertical-align:top;">Status: <a href="#" data-original-title="Enter the current status of the category"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><select name="status" class="selectboxit">
				<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
			</select></td>
      </tr>
      
</table>