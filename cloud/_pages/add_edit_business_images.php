<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {

		$title 		= addslashes($_REQUEST['title']);
		$status		= addslashes($_REQUEST['status']);
	
		if($_FILES['image']['size'] > 0)	{
			$max_id		= dbQuery("SELECT MAX(id) FROM business_images", 'singlecolumn') + 1;
			$filename	= '../upload/vendors/original/'.$max_id.'_'.$_FILES['image']['name'];
			$image_name	= $max_id.'_'.$_FILES['image']['name'];
			copy($_FILES['image']['tmp_name'],$filename);
			
			$filename	= '../upload/vendors/thumbnail/'.$max_id.'_'.$_FILES['image']['name'];
			ResizeImage($_FILES['image']['tmp_name'], THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, $filename);
		}
		
	
		$dbFields = array();
		$dbFields['title'] 			= $title;
		$dbFields['description']	= addslashes($_REQUEST['description']);

		if($image_name != '')
			$dbFields['image'] 		= $image_name;

		$dbFields['status'] 		= $status;
		
		
		$specialFields = array();
		if($_REQUEST['image_id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['image_id'];
			$INFO_MSG = "Image has been edited.";
		}	
		else	{
			$dbFields['vendor_id'] 		= $_REQUEST['id'];
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Image has been added.";
		}
		
		dbPerform("business_images", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['image_id'] == '')	{
			$new_id		=  mysql_insert_id();
			dbQuery("UPDATE business_images SET sort_order='$new_id' WHERE id='$new_id'");
		}	
		
		$_REQUEST['image_id']	= ($_REQUEST['image_id'] == '' ? $new_id: $_REQUEST['image_id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from business_images WHERE id='{$_REQUEST['image_id']}'";
	$recordsList = dbQuery($query);
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

?>

<? ############################################################################################## ?>

	<script>
		$(document).ready(function(){
		
			$('#submit').click(function()	{
				$('#form_images').submit();
			});
			
			$("#form_images").validate();
		});
	</script>
	
<? ############################################################################################## ?>

<? displayMessages(); ?>
<form id="form_images" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" ><a href="index.php?_page=add_edit_vendors&action=edit&id=<?=$_REQUEST['id']?>" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<a id="submit" style="cursor:pointer;float:right;" class="button" >Save</a></span></td>
	  </tr> 	
	  
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="28%">Title :</td>
		<td colspan="3"><input type="text" name="title" value="<?=$recordsList[0]['title']?>" id="title" class="pref"  /></td>
	  </tr>
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
	      <td width="10%" style="vertical-align:top;">Description: <a href="#" title="Enter the text you want to use as short description here" class="tool_tip_help" border="0"><img src="images/icons/info.png" style="vertical-align: top;" height="20" /></a></td>
		<td><textarea name="description" id="description" rows="20" cols="80" style="width:450px; height:50px;"><?=htmlspecialchars(no_magic_quotes($recordsList[0]['description']))?></textarea></td>
      </tr>
      
      <tr>  
		<td width="9%">Image:&nbsp;<br />
		  <?=$recordsList[0]['image'] != '' ? '<img src="../upload/vendors/thumbnail/'.$recordsList[0]['image'].'" width="100""  />' : ''?>
		</td>
		<td width="41%">
	    <input type="file" name="image" id="photo" class="required" /></td>
	  </tr>
  
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>Status:</td>
		<td>
			<select name="status" style="width:200px;">
				<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
			</select>
		</td>
	  </tr>
      
</table>