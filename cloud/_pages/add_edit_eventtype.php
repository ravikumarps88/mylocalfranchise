<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$event_type 	= addslashes($_REQUEST['event_type']);
		$description	= addslashes($_REQUEST['description']);
		$status			= addslashes($_REQUEST['status']);

		$dbFields = array();
		$dbFields['event_type'] 	= $event_type;
		$dbFields['description'] 	= $description;	
		$dbFields['status'] 		= $status;
	
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Event Type has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Event Type has been added.";
		}
		
		dbPerform("event_type", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	
			$new_id		=  mysql_insert_id();
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from event_type WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
?>

<? ############################################################################################## ?>
<!-- DATE PICKER -->
	<script>
		$(document).ready(function(){
		
			$('#submit').click(function()	{
				$('#form_event_type').submit();
			})
			
		});
	</script>
	<script language="javascript">
		var valRules=new Array();
		valRules[0]='title:Title|required';
		valRules[1]='phone:Telephone|required';
	</script>
<? ############################################################################################## ?>

<? displayMessages(); ?>
<form id="form_event_type" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" ><a href="index.php?_page=event_type" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button></td>
	  </tr> 	
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Event Type:<br />
        	<input type="text" name="event_type" value="<?=no_magic_quotes($recordsList[0]['event_type'])?>" id="form_name" class="pref" size="70"  />
        </td>
	  </tr>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Description:<br />
        	<textarea name="description" style="width:520px; height:150px;"><?=no_magic_quotes($recordsList[0]['description'])?></textarea>
        </td>
	  </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Status:<br />
			<select name="status">
				<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
			</select>
		</td>
	  </tr>
</table>
</form>