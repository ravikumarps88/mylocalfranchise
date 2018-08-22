<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$name 		= addslashes($_REQUEST['name']);
		$position 	= addslashes($_REQUEST['position']);
		$company 	= addslashes($_REQUEST['company']);
		$testimonial= addslashes($_REQUEST['testimonial']);
		$status		= addslashes($_REQUEST['status']);
		
		if($_FILES['photo']['size'] > 0)	{
			$filename	= '../images/testimonial/'.$_FILES['photo']['name'];
			$photo		= $_FILES['photo']['name'];
			copy($_FILES['photo']['tmp_name'],$filename);
			
			$filename	= '../images/testimonial/thumb/'.$_FILES['photo']['name'];
			ResizeImage($_FILES['photo']['tmp_name'], '200', '140', $filename);
		}
		
		$dbFields = array();
		$dbFields['name'] 			= $name;
		$dbFields['position'] 		= $position;
		$dbFields['company'] 		= $company;
		if($photo != '')
			$dbFields['photo'] 		= $photo;

		$dbFields['testimonial'] 	= $testimonial;	
		$dbFields['status'] 		= $status;
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Testimonial has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Testimonial has been added.";
		}
		
		dbPerform("testimonials", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
			dbQuery("UPDATE testimonials SET sort_order='$new_id' WHERE id='$new_id'");
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from testimonials WHERE id='{$_REQUEST['id']}'";
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
	<script src="../js/jquery-1.5.2.min.js"></script>
	<script>
		$(document).ready(function(){
		
			$('#submit').click(function()	{
				$('#form_testimonials').submit();
			})
			
		});
	</script>

<? ############################################################################################## ?>

<? displayMessages(); ?>
<form id="form_testimonials" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">

      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" >
        	<a href="index.php?_page=manage-testimonial" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button>
        </td>
	  </tr>  	
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="28%">Name :</td>
		<td colspan="3"><input type="text" name="name" value="<?=$recordsList[0]['name']?>" id="name" class="pref"  /></td>
	  </tr>

	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>Position:</td>
		<td colspan="3"><input type="text" name="position" value="<?=$recordsList[0]['position']?>" id="position" class="pref"  /></td>
      </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>Company:</td>
		<td colspan="3"><input type="text" name="company" value="<?=$recordsList[0]['company']?>" id="company" class="pref"  /></td>
      </tr>
      <tr>  
		<td width="9%">Photo:&nbsp;<br />
		  <?=$recordsList[0]['photo'] != '' ? '<img src="../images/testimonial/'.$recordsList[0]['photo'].'" width="75" height="75;"  />' : ''?>
		</td>
		<td width="41%">
	    <input type="file" name="photo"  /></td>
	  </tr>

      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
      	<td>Testimonial :</td>
		<td><textarea name="testimonial" rows="10" style="width: 95%"><?=no_magic_quotes($recordsList[0]['testimonial'])?></textarea></td>
      </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>Status:</td>
		<td>
			<select name="status">
				<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
			</select>
		</td>
	  </tr>
      
</table>