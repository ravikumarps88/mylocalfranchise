<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$title 		= addslashes($_REQUEST['title']);
		$artist 	= addslashes($_REQUEST['artist']);
		$status		= addslashes($_REQUEST['status']);
		
		if($_FILES['song']['size'] > 0)	{
			$filename	= '../assets/audio/'.$_FILES['song']['name'];
			copy($_FILES['song']['tmp_name'],$filename);
			$song		= $_FILES['song']['name'];
		}
		
		$dbFields = array();
		$dbFields['title'] 		= $title;
		if($song!='')
			$dbFields['song'] 		= $song;
		$dbFields['artist'] 	= $artist;
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
		
		dbPerform("mp3songs", $dbFields, $specialFields, $cond);
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
			dbQuery("UPDATE mp3songs SET sort_order='$new_id' WHERE id='$new_id'");
		}
		$action = "edit";
	
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from mp3songs WHERE id='{$_REQUEST['id']}'";
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
        	<a href="index.php?_page=manage-mp3songs" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button>
		</td>
	  </tr>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="28%">Title :</td>
		<td colspan="3"><input type="text" name="title" value="<?=$recordsList[0]['title']?>" id="title" class="pref"  /></td>
	  </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="28%">Artist :</td>
		<td colspan="3"><input type="text" name="artist" value="<?=$recordsList[0]['artist']?>" id="artist" class="pref"  /></td>
	  </tr>
      
      <tr>  
		<td width="41%">
	        Song:&nbsp;<br />
			<?=$recordsList[0]['song'] != '' ? $recordsList[0]['song'] : ''?>	
		    
		</td>
        <td><input type="file" name="song"  /></td>
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