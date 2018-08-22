<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
<!-- TinyMCE -->
<script type="text/javascript">
tinyMCE.init({	
// General options
	mode : "textareas",
	theme : "advanced",
	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
	theme_advanced_buttons3 : "forecolor,backcolor,hr,removeformat,visualaid,|,sub,sup,|,charmap",
	theme_advanced_toolbar_location : "bottom",
	theme_advanced_toolbar_align : "center"
});

function toggleEditor(id) {
	if (!tinyMCE.getInstanceById(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}
</script>

<!-- /TinyMCE -->
<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$title 		= addslashes($_REQUEST['title']);
		$news 		= addslashes($_REQUEST['news']);
		$user 		= addslashes($_REQUEST['user']);
		$category 	= addslashes($_REQUEST['category']);
		$ndate 		= ($_REQUEST['date'] == '' ? 'now()' : "'".convertToMysqlDate($_REQUEST['date'], '/').' '.date("H:i:s")."'");
		$status		= addslashes($_REQUEST['status']);
	
		if($_FILES['image']['size'] > 0)	{
			$filename	= '../images/news/'.$_FILES['image']['name'];
			$image_name	= $_FILES['image']['name'];
			copy($_FILES['image']['tmp_name'],$filename);
			$filename	= '../images/news/thumbnail/'.$_FILES['image']['name'];
			ResizeImage($_FILES['image']['tmp_name'], '200', '140', $filename);
			
			$filename	= '../images/news/resize/'.$_FILES['image']['name'];
			ResizeImage($_FILES['image']['tmp_name'], '602', '224', $filename);
		}
		
		$dbFields = array();
		$dbFields['title'] 			= $title;
		$dbFields['news'] 			= $news;
		$dbFields['user_id'] 		= $user;
		$dbFields['category'] 		= $category;
		
		if($image_name != '')
			$dbFields['image'] 		= $image_name;

		$dbFields['status'] 		= $status;
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= $ndate;
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Blog entry has been edited.";
		}	
		else	{
			$dbFields['updated_on'] 		= $ndate;
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on','updated_on');
			$INFO_MSG = "Blog entry has been posted.";
		}
		
		dbPerform("news", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
			dbQuery("UPDATE news SET sort_order='$new_id' WHERE id='$new_id'");
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
		
		
		
		
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from news WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

$sql		= "SELECT id AS optionId, concat_ws(' ',firstname,lastname) AS optionText FROM users WHERE status='active' AND (type='editor' || type='admin')";
$userArr	= dbQuery($sql);

$sql		= "SELECT id AS optionId, category AS optionText FROM news_categories WHERE status='active'";
$categoryArr= dbQuery($sql);
?>

<? ############################################################################################## ?>
<!-- DATE PICKER -->
	<script>
		$(document).ready(function(){
			//$('#date').datepicker({ dateFormat:'dd/mm/yy'});
		
			$('#submit').click(function()	{
				$('#form_news').submit();
			})
			
			$('a[rel=img]').click(function()	{
				$('#jkimg').load("delete_image.php?id="+$(this).attr('id')+"&type=news");	
			});
		});
	</script>
	<script language="javascript">
		var valRules=new Array();
		valRules[0]='title:Title|required';
		valRules[1]='phone:Telephone|required';
	</script>
<? ############################################################################################## ?>

<? displayMessages(); ?>

<form id="form_news" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" >
        	<a href="index.php?_page=manage-blog" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button>
		</td>
	  </tr>
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Author:<br />
			<select name="user">
            	<option>Select</option>
				<?=htmlOptions($userArr, $recordsList[0]['user_id']);?>
			</select>
		</td>
	  </tr>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
         <td>
         	Date:(FORMAT: dd/mm/yyyy)<br />
         	<input type="text" name="date" value="<?=$recordsList[0]['updated_on'] != '' ? convertMysqlToDate(date('Y-m-d',strtotime($recordsList[0]['updated_on'])), '-') : date('d/m/Y'); ?>" id="date"  />
		</td>
      </tr>      
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Category:<br />
			<select name="category">
            	<option>Select</option>
				<?=htmlOptions($categoryArr, $recordsList[0]['category']);?>
			</select>
		</td>
	  </tr>
      
      
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Title:<br />
        	<input type="text" name="title" value="<?=no_magic_quotes($recordsList[0]['title'])?>" id="form_name" class="pref"  /></td>
	  </tr>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	News:<br />
        	<textarea name="news" id="content" class="pref tareahs bodycopy" ><?=no_magic_quotes($recordsList[0]['news'])?></textarea>
        </td>
      </tr>
      <tr>  
		<td colspan="3">
        	Image:<br />
		  <?=$recordsList[0]['image'] != '' ? '<div id="jkimg"><img src="../images/news/'.$recordsList[0]['image'].'" width="50" height="50px;"  />&nbsp;&nbsp;<a href="javascript:void(0)" id="'.$_REQUEST['id'].'" rel="img"><img src="../images/icons/delete.png"  title="Delete image" alt="Delete image" /></a></div>' : ''?>
          		    <input type="file" name="image"  />
          
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