<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$title 		= addslashes($_REQUEST['title']);
		$url	 	= addslashes($_REQUEST['url']);
		$status		= addslashes($_REQUEST['status']);
		
		if($url	!= '')	{
			$url_parts = parse_url($url);
			parse_str($url_parts['query'], $path_parts);
			$image	= 'http://i1.ytimg.com/vi/'.$path_parts['v'].'/default.jpg';;
		}
		
		if($_FILES['image']['size'] > 0)	{
			$filename	= '../images/videos/'.$_FILES['image']['name'];
			copy($_FILES['song']['tmp_name'],$filename);
			$image		= $_FILES['image']['name'];
			
			$filename	= '../images/videos/thumb/'.$_FILES['image']['name'];
			ResizeImage($_FILES['image']['tmp_name'], THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, $filename);
		}
		
		$dbFields = array();
		$dbFields['title'] 		= $title;
		$dbFields['url'] 		= $url;
		if($image != '')
			$dbFields['image'] 	= $image;
		$dbFields['status'] 	= $status;
	
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Song has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Song has been added.";
		}
		
		dbPerform("videos", $dbFields, $specialFields, $cond);
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
		}
		$action = "edit";
	
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from videos WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
	
	$url_parts = parse_url($recordsList[0]['url']);
	parse_str($url_parts['query'], $path_parts);
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
				$('#form_songlist').submit();
			})
			
		});
	</script>

<? ############################################################################################## ?>

<? displayMessages(); ?>
<form id="form_songlist" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="4" >
        	<a href="index.php?_page=manage-videos" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button>
		</td>
	  </tr>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="28%">Title :</td>
		<td colspan="3"><input type="text" name="title" value="<?=$recordsList[0]['title']?>" id="title" class="pref"  /></td>
	  </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="28%">Url :</td>
		<td colspan="3"><input type="text" name="url" value="<?=$recordsList[0]['url']?>" id="url" class="pref"  /></td>
	  </tr>
      
      <tr>  
		<td width="41%">
	        Image:&nbsp;<br />
			<?=$recordsList[0]['image'] != '' ? ($path_parts['v']=='' ? '<img src="../images/videos/thumb/'.$recordsList[0]['image'].'" width="130"  />' : '<img src="'.$recordsList[0]['image'].'" />')  : ''?>
		    
		</td>
        <td><input type="file" name="image"  /></td>
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