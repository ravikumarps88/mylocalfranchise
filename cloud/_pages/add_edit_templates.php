<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$tmp_name 		= addslashes($_REQUEST['tmp_name']);
		$tmp_content 	= addslashes($_REQUEST['tmp_content']);
		$status			= addslashes($_REQUEST['status']);

		$dbFields = array();
		$dbFields['tmp_name'] 		= $tmp_name;
		$dbFields['tmp_content'] 	= $tmp_content;	
		$dbFields['status'] 		= $status;
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Template has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Template has been added.";
		}
		
		$new_id	= dbPerform("templates", $dbFields, $specialFields, $cond);
		$action = "edit";
			
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from templates WHERE id='{$_REQUEST['id']}'";
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
        <a href="index.php?_page=manage-templates">Manage Templates</a>
    </li>
    <li class="active">
        <strong>Add/Edit Templates</strong>
    </li>
</ol>
<form id="form_templates" class="form-horizontal form-groups-bordered" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table" id="">
	<tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="2" >
        	<p class="bs-example">
                <a href="index.php?_page=manage-templates" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
                    
                <button type="submit" class="btn btn-primary pull-right">Save</button>
			</p>            	    
        </td>
	</tr> 	
	   
	<tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="90%">
            <div class="form-group">
                <label class="col-sm-1 control-label">Template</label>
                
                <div class="col-sm-2">
                    <input type="text" name="tmp_name" value="<?=$recordsList[0]['tmp_name']?>" id="field-1" class="form-control"  />
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
	<tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        
        	<div class="form-group">
                <label class="col-sm-1 control-label">Content</label>
                
                <div class="col-sm-2">
                    <textarea name="tmp_content" class="form-control autogrow" style="width:85em; height:60em;"><?=htmlspecialchars(no_magic_quotes($recordsList[0]['tmp_content']))?></textarea>
                </div>
            </div>
		</td>
	</tr>
</table>