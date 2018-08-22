<?
	$pagename	= getPageAlias($_REQUEST['id']);
?>


<script type="text/javascript" src="js/tiny_mce.js"></script>
<script type="text/javascript" src="js/jquery.counter-1.0.min.js"></script>

<!-- TinyMCE -->
<script type="text/javascript">
	
tinyMCE.init({	
// General options
	mode : "exact",
	elements : "content",
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
<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$page_name		= addslashes($_REQUEST['page_name']);
		if($_REQUEST['content_type']!='')
			$content_type	= $_REQUEST['content_type'];
		$external_url	= $_REQUEST['external_url'];
		$template_id	= $_REQUEST['template_id'];
		$parent_id		= $_REQUEST['parent_id'];
		$status			= addslashes($_REQUEST['status']);
		$content		= addslashes($_REQUEST['content']);
		
		$menu_text		= ($_REQUEST['menu_text'] !='' ? addslashes($_REQUEST['menu_text']) : addslashes($_REQUEST['page_name']) );
		
		if($content_type != 'external')
			$page_alias		= ($_REQUEST['page_alias'] !='' ? post_slug($_REQUEST['page_alias']) : post_slug($_REQUEST['menu_text']) );
			
		$show_in_menu	= ($_REQUEST['show_in_menu'] == 'on' ? 'yes' : 'no');
		$menutype		= $_REQUEST['menutype'];
		$title_tag		= addslashes($_REQUEST['title_tag']);
		$meta_description	= strip_tags(addslashes($_REQUEST['meta_description']));
		$meta_keywords		= strip_tags(addslashes($_REQUEST['meta_keywords']));
	
		$dbFields = array();
		$dbFields['page_name'] 		= $page_name;
		if($_REQUEST['content_type']!='')
			$dbFields['content_type'] 	= $content_type;
		$dbFields['external_url'] 	= $external_url;
		$dbFields['content'] 		= $content;
		$dbFields['status'] 		= $status;
		$dbFields['template_id'] 	= $template_id;
		$dbFields['parent_id'] 		= $parent_id;
		$dbFields['menu_text'] 		= $menu_text;
		$dbFields['page_alias'] 	= $page_alias;
		$dbFields['show_in_menu'] 	= $show_in_menu;
		$dbFields['menutype'] 		= $menutype;
		$dbFields['title_tag'] 		= $title_tag;
		$dbFields['meta_description'] 	= $meta_description;
		$dbFields['meta_keywords'] 		= $meta_keywords;
		
		
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{
			if($status == 'inactive' || $status=='deleted')	
				$dbFields['parent_id'] 		= '-1';	
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Page has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Page has been added.";
		}
		
		$new_id	= dbPerform("pages", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			dbQuery("UPDATE pages SET sort_order='$new_id' WHERE id='$new_id'");
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from pages WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

$sql 			=  "SELECT id AS optionId, tmp_name AS optionText FROM templates WHERE status='active'";
$templateArr	= dbQuery($sql);

$sql 			=  "SELECT id AS optionId, page_name AS optionText FROM pages WHERE status='active' AND parent_id='-1'";
$parentmenuArr	= dbQuery($sql);
?>

<? ############################################################################################## ?>
<!-- DATE PICKER -->
<script>
	$(document).ready(function(){
		
		$("#minWord").counter({
			type: 'word',
			goal: 30
		});
		
		$("#minChar").counter({
			count: 'up',
			goal: 200
		});
		
		
		$("input[name='content_type']").click(function()	{
			if($(this).val() == 'external')
				$('#externallink').show();
			else
				$('#externallink').hide();	
		})
		
	});
</script>
	

<? ############################################################################################## ?>
<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li>
        <a href="index.php?_page=manage-pages">Manage Pages</a>
    </li>
    <li class="active">
        <strong>Add/Edit Pages</strong>
    </li>
</ol>

<form id="form_pages" action="" method="post" enctype="multipart/form-data" class="form-horizontal form-groups-bordered validate">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<p class="bs-example">
    <a href="index.php?_page=manage-pages" class="bs-example">
        <button type="button" class="btn btn-primary pull-right">Back</button>
    </a>
        
    <button type="submit" class="btn btn-primary pull-right">Save</button>
</p>

                            
<h3><?=no_magic_quotes($recordsList[0]['menu_text'])?></h3>                            
<ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
    <li class="active">
        <a href="#main" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-home"></i></span>
            <span class="hidden-xs">Details</span>
        </a>
    </li>
    <li>
        <a href="#content-box" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-user"></i></span>
            <span class="hidden-xs">Content</span>
        </a>
    </li>
    <li>
        <a href="#options" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-mail"></i></span>
            <span class="hidden-xs">Options</span>
        </a>
    </li>
    <li>
        <a href="#preview" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-cog"></i></span>
            <span class="hidden-xs">Preview</span>
        </a>
    </li>
</ul>                            


<div class="tab-content">
	<div class="tab-pane active" id="main">
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td width="18%">Navigation Title: <a href="#" data-original-title="This is how the page name will appear in the navigation bar" data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                <td colspan="3"><input type="text" name="menu_text" value="<?=no_magic_quotes($recordsList[0]['menu_text'])?>"  id="field-1" class="form-control" data-validate="required" data-message-required="required field." placeholder="Navigation Title"  /></td>
              </tr>	  
        
              <?if ($_SESSION[AUTH_PREFIX.'SUPERADMIN_AUTH']) {?>
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                    <td>Content Type: <a href="#" data-original-title="If this is a dynamic page with custom coding involved mark it as Dynamic or if its just CMS mark as Content"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                    <td>
                        <div class="radio radio-replace">
                            <input type="radio" name="content_type" value="content" <?=$recordsList[0]['content_type'] == 'content' || $recordsList[0]['content_type'] == '' ? 'checked="checked"' : ''?> style="width:20px; display:inline;"   />
                            <label>Content</label>
                        </div>
                       
                        <div class="radio radio-replace">    
                            <input type="radio" name="content_type" value="dynamic" <?=$recordsList[0]['content_type'] == 'dynamic' ? 'checked="checked"' : ''?>   style="width:20px; display:inline;" />
                            <label>Dynamic</label>
                        </div>    
                        
                        <div class="radio radio-replace">    
                            <input type="radio" name="content_type" value="external" <?=$recordsList[0]['content_type'] == 'external' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;"  />
                            <label>External</label>
                        </div>
                    </td>
                </tr>
              <?}elseif($recordsList[0]['content_type'] != 'dynamic')	{?>
                <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                    <td>Content Type: <a href="#" data-original-title="If this is a dynamic page with custom coding involved mark it as Dynamic or if its just CMS mark as Content"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                    <td>
                        <div class="radio radio-replace">
                            <input type="radio" name="content_type" value="content" <?=$recordsList[0]['content_type'] == 'content' || $recordsList[0]['content_type'] == '' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;"  />
                            <label>Content</label>
                        </div>    
                    
                        <div class="radio radio-replace">
                            <input type="radio" name="content_type" value="external" <?=$recordsList[0]['content_type'] == 'external' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;"  />
                            <label>External</label>
                        </div>   
                         
                    </td>
                </tr>
              <?}?>
              
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';" style="<?=$recordsList[0]['content_type'] == 'external' ? '' : 'display:none;'?>" id="externallink">
                <td width="18%">External URL: <a href="#" data-original-title="External URL"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                <td colspan="3"><input type="text" name="external_url" value="<?=no_magic_quotes($recordsList[0]['external_url'])?>"   id="field-1" class="form-control" /></td>
              </tr>  
             
                   
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td>Page Template: <a href="#" data-original-title="Select which page template you want to use" border="0"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary"><i class="entypo-info-circled"></i></a></td>
                <td>
                    <select name="template_id" class="selectboxit">
                        <?=htmlOptions($templateArr, $recordsList[0]['template_id']);?>
                    </select>
                </td>
              </tr>
               
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td>Parent Menu: <a href="#" data-original-title="Select which parent menu this page link should appear" border="0"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary"><i class="entypo-info-circled"></i></a></td>
                <td>
                    <select name="parent_id" class="selectboxit">
                        <option value="-1">None</option>
                        <?=htmlOptions($parentmenuArr, $recordsList[0]['parent_id']);?>
                    </select>
                </td>
              </tr>
                    
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                    <td>Show in Menu: <a href="#" data-original-title="Do you want this page to be visible in the main navigation bar?"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                    <td>
                    	<div class="checkbox checkbox-replace">
                            <input type="checkbox" name="show_in_menu" <?=$recordsList[0]['show_in_menu'] == 'yes' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;" />
                            <label>Show in Menu</label>
                        </div>
                        
                        
                        
                        <div class="radio radio-replace">
                            <input type="radio" name="menutype" value="main" <?=$recordsList[0]['menutype'] == 'main' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;"  />
                            <label>Main menu</label>
                        </div>    
                    
                        <div class="radio radio-replace">
                            <input type="radio" name="menutype" value="sub" <?=$recordsList[0]['menutype'] == 'sub' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;"  />
                            <label>Sub menu</label>
                        </div>  
                        
                        <div class="radio radio-replace">
                            <input type="radio" name="menutype" value="footer" <?=$recordsList[0]['menutype'] == 'footer' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;"  />
                            <label>Footer menu</label>
                        </div>  
                        
                        <div class="radio radio-replace">
                            <input type="radio" name="menutype" value="both" <?=$recordsList[0]['menutype'] == 'both' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;"  />
                            <label>Both</label>
                        </div>   
                        
                        
                    </td>
                </tr>
                
        
        
            <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td>Status: <a href="#" data-original-title="Select whether you want the page to be visible on the front end or just available in the admin area whilst you work on it"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                <td>
                    <select name="status" class="selectboxit">
                        <?=htmlOptions($statusArr, $recordsList[0]['status']);?>
                    </select>
                </td>
            </tr>
              
              
              
        </table>
	</div>

    <div id="content-box" class="tab-pane">
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
                   
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td width="18%" style="vertical-align: middle;">Page Title: <a href="#" data-original-title="This is how you idenfity the page in this admin area, and this would be the title (H2 tag) in the pages" border="0"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary"><i class="entypo-info-circled"></i></a> </td>
                <td colspan="3"><input type="text" name="page_name" value="<?=no_magic_quotes($recordsList[0]['page_name'])?>"  id="field-1" class="form-control"  /></td>
              </tr>
              
              
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td style="vertical-align:top;">Page Content: <a href="#" data-original-title="Enter the text or images you want to use on your web page here"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                <td><textarea name="content" id="content" class="form-control autogrow"><?=htmlspecialchars(no_magic_quotes($recordsList[0]['content']))?></textarea></td>
              </tr>  
              
              
        </table>
    
    </div>

    <div id="options" class="tab-pane">
               
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
        
        <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
            <td width="18%">Browser Title: <a href="#" data-original-title="This is how the page name will appear in the browser title/tab bar"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
            <td colspan="3"><input type="text" name="title_tag" value="<?=no_magic_quotes($recordsList[0]['title_tag'])?>"  id="field-1" class="form-control"  /></td>
        </tr>
        
        
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td width="18%">Page URL: <a href="#" data-original-title="This is how the page will appear in the browser address field; ie: http://www.yourpub.co.uk/page_url.html"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                <td colspan="3"><input type="text" name="page_alias" value="<?=no_magic_quotes($recordsList[0]['page_alias'])?>"  id="field-1" class="form-control" <?=$recordsList[0]['content_type'] == 'dynamic' ? 'readonly="readonly"' : ''?>  /></td>
              </tr>
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td>Meta Keywords: <a href="#" data-original-title="Keywords used by search engines to identify important content"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                <td><textarea id="minWord" name="meta_keywords" style="width:520px; height:100px;" class="form-control autogrow"><?=no_magic_quotes($recordsList[0]['meta_keywords'])?></textarea></td>
              </tr>
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td>Meta Description: <a href="#" data-original-title="A 200 character description or summary of your business & website"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
                <td><textarea id="minChar" name="meta_description" style="width:520px; height:100px;" class="form-control autogrow"><?=no_magic_quotes($recordsList[0]['meta_description'])?></textarea></td>
              </tr>
              
        </table>
    </div>


    <div id="preview" class="tab-pane">
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td colspan="3" style="background-color: red; color: black; text-align: center; font-weight: bold; font-size: 14px; " >Warning: This preview panel behaves much like a browser window allowing you to navigate away from the initially previewed page</td>
              </tr>
              <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
                <td><iframe src="<?=APP_URL.'/'.$recordsList[0]['page_alias'].'.html'?>" width="100%" height="600" frameborder="0"></iframe></td>
              </tr>
        
        </table>
    </div>
</div> <!-- End of .content -->
</form>                    