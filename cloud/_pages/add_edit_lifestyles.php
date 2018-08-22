<?
if ($action=="save") {
	//echo "<pre>";
	//print_r($_REQUEST);
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
		
	$dbFields = array();	
	
	//adding
	$dbFields['lifestyle'] 		= $lifestyle;
	
	$dbFields['title_tag'] 			= addslashes($title_tag);
	$dbFields['meta_description'] 	= addslashes($meta_description);
	$dbFields['meta_keywords'] 		= addslashes($meta_keywords);
		
	
	$dbFields['status'] 		= $status;
	
	$specialFields = array();
	if($_REQUEST['id'] != '')	{		
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_REQUEST['id'];
		$INFO_MSG = "Lifestyle has been edited.";
	}	
	else	{
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');	
		$INFO_MSG = "Lifestyle has been added.";
	}
	
	$new_id = dbPerform("lifestyles", $dbFields, $specialFields, $cond);
	$action = "edit";
	
	$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
	
}

if($action == 'edit')	{
	$query = "select * from lifestyles WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}



$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusArr[]	= array("optionId"=>"all","optionText"=>"All");

?>



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
        <a href="index.php?_page=manage-lifestyles">Lifestyles</a>
    </li>
    <li class="active">
        <strong>Add/Edit Lifestyles</strong>
    </li>
</ol>


<form id="form_category" action="" method="post" enctype="multipart/form-data" class="validate">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="4" >
        	<p class="bs-example">
                <a href="index.php?_page=manage-lifestyles" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
                    
                <button type="submit" class="btn btn-primary pull-right">Save</button>
			</p>
            
        </td>
	  </tr> 	
  
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
        <td width="18%">Lifestyle: <a href="#" data-original-title="This is category title/name"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><input type="text" name="lifestyle" value="<?=no_magic_quotes($recordsList[0]['lifestyle'])?>" id="lifestyle" class="form-control" data-validate="required" data-message-required="required field." placeholder="Lifestyle"  /></td>
    
        <td width="18%">Browser Title: <a href="#" data-original-title="This is how the page name will appear in the browser title/tab bar"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><input type="text" name="title_tag" value="<?=no_magic_quotes($recordsList[0]['title_tag'])?>"  id="field-1" class="form-control"  /></td>
    
      </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
      	<td>Meta Keywords: <a href="#" data-original-title="Keywords used by search engines to identify important content"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><textarea id="minWord" name="meta_keywords" style="height:100px;" class="form-control autogrow"><?=no_magic_quotes($recordsList[0]['meta_keywords'])?></textarea></td>
        
        <td>Meta Description: <a href="#" data-original-title="A 200 character description or summary of your business & website"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><textarea id="minChar" name="meta_description" style="height:100px;" class="form-control autogrow"><?=no_magic_quotes($recordsList[0]['meta_description'])?></textarea></td>
      
      </tr>
      <tr>
      	<td style="vertical-align:top;">Status: <a href="#" data-original-title="Enter the current status of the category"  data-toggle="tooltip" data-placement="top"  class="tooltip-primary" border="0"><i class="entypo-info-circled"></i></a></td>
        <td><select name="status" class="selectboxit">
				<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
			</select></td>
      </tr>
      
</table>