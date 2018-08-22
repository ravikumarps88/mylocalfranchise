<?
//---------------------------------------------------------------------------------------------------
$query 				= "select * from portfolio_categ WHERE status='active' ORDER BY category";
$portfolio_slides	= dbQuery($query);

if ($action=="save") {
		$title 		= addslashes($_REQUEST['title']);
		$url 		= addslashes($_REQUEST['url']);
		$description= addslashes($_REQUEST['description']);
		$status		= addslashes($_REQUEST['status']);
		
		foreach($portfolio_slides as $val)	{
			if($_REQUEST['categ'][$val['id']]	== 'on')
				$category	.= $val['id'].',';
		}
	
		if($_FILES['slideshow_image']['size'] > 0)	{
			$filename	= '../images/portfolio/slideshow/'.$_FILES['slideshow_image']['name'];
			$slide_name	= $_FILES['slideshow_image']['name'];
			copy($_FILES['slideshow_image']['tmp_name'],$filename);
			
			$filename	= '../images/portfolio/thumb/'.$_FILES['slideshow_image']['name'];
			$thumb_name	= $_FILES['slideshow_image']['name'];
			ResizeImage($_FILES['slideshow_image']['tmp_name'], '220', '146', $filename);
		}
		
	
		$dbFields = array();
		$dbFields['title'] 			= $title;
		$dbFields['category'] 		= $category;
		$dbFields['url'] 			= $url;
		if($thumb_name != '')
			$dbFields['thumb_img'] 		= $thumb_name;
		if($slide_name != '')	
			$dbFields['slideshow_img'] 	= $slide_name;
			
		$dbFields['description'] 	= $description;	
		
		$dbFields['status'] 		= $status;
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Portfolio has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Portfolio has been added.";
		}
		
		dbPerform("portfolio", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
			dbQuery("UPDATE portfolio SET sort_order='$new_id' WHERE id='$new_id'");
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from portfolio WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

$categoryArr	= dbQuery("SELECT id AS optionId, category AS optionText FROM portfolio_categ WHERE status='active'");
?>

<? ############################################################################################## ?>
<!-- DATE PICKER -->
	<script src="../js/jquery-1.5.2.min.js"></script>
	<script>
		$(document).ready(function(){
		
			$('#submit').click(function()	{
				$('#form_portfolio').submit();
			})
			
			$("#category_all").click(function()	{
				$(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
			})
		});
	</script>
<? ############################################################################################## ?>

<? displayMessages(); ?>

<div class="nonmodal">
<form id="form_portfolio" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" >
        	<a href="index.php?_page=manage-portfolio&category=<?=$_REQUEST['category']?>" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button>
		</td>
	  </tr> 	
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Title:<br />
        	<input type="text" name="title" value="<?=$recordsList[0]['title']?>" id="form_name" class="pref"  /></td>
	  </tr>

      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Category:<br />
        	<fieldset>
        	<input type="checkbox" name="category_all" id="category_all"  style="width:20px; display:inline;" />&nbsp;Select All<br />
<? 
					$categ_arr	= explode(',',$recordsList[0]['category']);
					foreach($portfolio_slides as $val)	{
?>
						<input type="checkbox" name="categ[<?=$val['id']?>]" <?=in_array($val['id'],$categ_arr) ? "checked='checked'" : ''?>  style="width:13px; display:inline;" />&nbsp;<?=no_magic_quotes($val['category'])?>&nbsp;&nbsp;
<?				
					}
?>
			</fieldset>
        </td>
      </tr>      
	  
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
	        Url:<br />
			<input type="text" name="url" value="<?=$recordsList[0]['url']?>" id="form_name" class="pref"  /></td>
      </tr>
      <tr>  
		<td>Image:&nbsp;<br />
		  <?=$recordsList[0]['slideshow_img'] != '' ? '<img src="../images/portfolio/slideshow/'.$recordsList[0]['slideshow_img'].'" width="247" height="149px;"  />' : ''?>
			<input type="file" name="slideshow_image"  />
		</td>

	  </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Description:<br />
        	<textarea name="description" rows="10" style="width: 95%"><?=no_magic_quotes($recordsList[0]['description'])?></textarea></td>
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
</div>