<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$css_name 	= addslashes($_REQUEST['css_name']);
		$css_text 	= addslashes($_REQUEST['css_text']);
		$media_type	= addslashes($_REQUEST['media_type']);
		$status		= addslashes($_REQUEST['status']);

		$dbFields = array();
		$dbFields['css_name'] 		= $css_name;
		$dbFields['css_text'] 		= $css_text;	
		$dbFields['media_type'] 	= $media_type;	
		$dbFields['status'] 		= $status;
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "CSS has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "CSS has been added.";
		}
		
		dbPerform("css", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from css WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li>
        <a href="index.php?_page=manage-css">Manage CSS</a>
    </li>
    <li class="active">
        <strong>Add/Edit CSS</strong>
    </li>
</ol>

<form id="form_css" action="" method="post" enctype="multipart/form-data" class="validate">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	<tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="2" >
        	<p class="bs-example">
                <a href="<?=$_SERVER['HTTP_REFERER']?>" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
                    
                <button type="submit" class="btn btn-primary pull-right">Save</button>
			</p>  
            
        	
        </td>
	</tr> 

	  
	<tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="91%" colspan="3">
        	<div class="form-group">
                <label class="col-sm-1 control-label">CSS</label>
                
                <div class="col-sm-2">
                    <input type="text" name="css_name" value="<?=$recordsList[0]['css_name']?>" id="field-1" class="form-control" data-validate="required" data-message-required="required field." placeholder="CSS Name"  />
                </div>
            </div>
            
        </td>
  	</tr>
	
    <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	<div class="form-group">
                <label class="col-sm-1 control-label">Media Type</label>
                
                <div class="col-sm-2">
                    <input type="text" name="media_type" value="<?=$recordsList[0]['media_type']?>" id="field-1" class="form-control"  />
                </div>
            </div>
		</td>
	</tr>
	
    <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	<div class="form-group">
                <label class="col-sm-1 control-label">Content</label>
                
                <div class="col-sm-2">
                    <textarea name="css_text" class="form-control autogrow" style="width:55em; height:40em;" data-validate="required,minlength[10]" placeholder="CSS Stylesheet content"><?=no_magic_quotes($recordsList[0]['css_text'])?></textarea>
                </div>
            </div>
            
         </td>
        
	</tr>
  
    <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	<div class="form-group">
                <label class="col-sm-1 control-label">Status</label>
                
                <div class="col-sm-2">
                    <select name="status" class="selectboxit">
						<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
                    </select>
                </div>
            </div>
            
		</td>
	</tr>
      
</table>
</form>