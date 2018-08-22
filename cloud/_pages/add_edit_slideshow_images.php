<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$title 		= addslashes($_REQUEST['title']);
		$url 		= addslashes($_REQUEST['url']);
		$description= addslashes($_REQUEST['description']);;
		$status		= addslashes($_REQUEST['status']);
	
		if($_FILES['slideshow_image']['size'] > 0)	{
			$filename	= '../images/slideshow/slideshow/'.$_FILES['slideshow_image']['name'];
			$slide_name	= $_FILES['slideshow_image']['name'];
			copy($_FILES['slideshow_image']['tmp_name'],$filename);
		}
		
		$dim	= dbQuery("SELECT slide_width,slide_height FROM slideshows WHERE id='{$_REQUEST['sid']}'",'single');
		if($_FILES['slideshow_image']['size'] > 0)	{
			$filename	= '../images/slideshow/thumb/'.$_FILES['slideshow_image']['name'];
			$thumb_name	= $_FILES['slideshow_image']['name'];
			ResizeImage($_FILES['slideshow_image']['tmp_name'], $dim['slide_width'], $dim['slide_height'], $filename);
		}
		
		
		$dbFields = array();
		$dbFields['title'] 			= $title;
		$dbFields['url'] 			= $url;
		$dbFields['description'] 	= $description;	
		if($thumb_name != '')
			$dbFields['thumb_img'] 		= $thumb_name;
		if($slide_name != '')	
			$dbFields['slideshow_img'] 	= $slide_name;
		$dbFields['status'] 		= $status;
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id']." AND slideshow_id=".$_REQUEST['sid'];
			$INFO_MSG = "slideshow has been edited.";
		}	
		else	{
			$dbFields['slideshow_id'] 		= $_REQUEST['sid'];
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "slideshow has been added.";
		}
		
		dbPerform("slideshow_img", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
			dbQuery("UPDATE slideshow_img SET sort_order='$new_id' WHERE id='$new_id'");
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from slideshow_img WHERE id='{$_REQUEST['id']}'";
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
				$('#form_slideshow').submit();
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
<form id="form_slideshow" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" >
        	<a href="index.php?_page=add_edit_slideshows&action=edit&id=<?=$_REQUEST['sid']?>" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button>

		</td>
	  </tr> 	
	  
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Title:<br />
        	<input type="text" name="title" value="<?=$recordsList[0]['title']?>" id="form_name" class="pref"  /></td>
	  </tr>
	  
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Url:<br />
        	<input type="text" name="url" value="<?=$recordsList[0]['url']?>" id="form_name" class="pref"  /></td>
      </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Description:<br />
        	<textarea name="description" rows="10" style="width: 95%"><?=no_magic_quotes($recordsList[0]['description'])?></textarea></td>
      </tr>
  
      <tr>  
		<td>Slideshow Image:&nbsp;<br />
		  <?=$recordsList[0]['slideshow_img'] != '' ? '<img src="../images/slideshow/thumb/'.$recordsList[0]['slideshow_img'].'" width="247" height="149px;"  />' : ''?>
          	    <input type="file" name="slideshow_image"  />	
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