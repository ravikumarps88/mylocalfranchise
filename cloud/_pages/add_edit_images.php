<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$title 		= addslashes($_REQUEST['title']);
		$status		= addslashes($_REQUEST['status']);

		if($_FILES['images_img']['size'] > 0)	{
			$filename	= '../upload/'.$_FILES['images_img']['name'];
			copy($_FILES['images_img']['tmp_name'],$filename);
			list($width, $height) = getimagesize('../upload/'.$_FILES['images_img']['name']);
			
			$filename	= '../upload/thumbnail/'.$_FILES['images_img']['name'];
			ResizeImage($_FILES['images_img']['tmp_name'], THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, $filename);
			$images_img	= $_FILES['images_img']['name'];
		}
	
		$dbFields = array();
		$dbFields['title'] 			= $title;
		if($images_img != '')
			$dbFields['images_img'] 	= $images_img;
		$dbFields['width'] 			= $width;	
		$dbFields['height'] 		= $height;
		$dbFields['status'] 		= $status;
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "images has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "images has been added.";
		}
		
		$new_id	= dbPerform("images", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			dbQuery("UPDATE images SET sort_order='$new_id' WHERE id='$new_id'");
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from images WHERE id='{$_REQUEST['id']}'";
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
        <a href="index.php?_page=manage-images">Manage Images</a>
    </li>
    <li class="active">
        <strong>Add/Edit Images</strong>
    </li>
</ol>


<form id="form_images" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" >
        	<p class="bs-example">
                <a href="index.php?_page=manage-images" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
                    
                <button type="submit" class="btn btn-primary pull-right">Save</button>
			</p> 
            
        </td>
	  </tr> 	
	  <?if($action == 'edit')	{?>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3"><strong>Image path</strong>: 
			<a href="<?=APP_URL.'/upload/'.$recordsList[0]['images_img']?>" target="_blank"><?=APP_URL.'/upload/'.$recordsList[0]['images_img']?></a></td>
	  </tr>
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3"><strong>Dimensions</strong>: 
			<?=$recordsList[0]['width']?> x <?=$recordsList[0]['height']?>&nbsp;px</td>
	  </tr>
      <?}?>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">Title<br />
			<input type="text" name="title" value="<?=$recordsList[0]['title']?>"  id="field-1" class="form-control"  /></td>
	  </tr>
	  
      <tr>  

		<td width="41%">
	        Image:&nbsp;<br />
			<?=$recordsList[0]['images_img'] != '' ? $recordsList[0]['images_img'].'<br/><img src="../upload/thumbnail/'.$recordsList[0]['images_img'].'"  />' : ''?>	
		    <input type="file" name="images_img"  class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" /></td>
	  </tr>
  
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Status<br />
			<select name="status" class="selectboxit">
				<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
			</select>
		</td>
	  </tr>
      
</table>