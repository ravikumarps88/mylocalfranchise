<?
if ($action=="save") {
	//echo "<pre>";
	//print_r($_REQUEST);
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	
	//adding to wine profile	
	$dbFields = array();
	$dbFields['category'] 				= $category;

	$dbFields['status'] 				= $status;
	
	$specialFields = array();
	if($_REQUEST['id'] != '')	{		
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_REQUEST['id'];
		$INFO_MSG = "category has been edited.";
	}	
	else	{
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');	
		$INFO_MSG = "category has been added.";
	}
	
	dbPerform("portfolio_categ", $dbFields, $specialFields, $cond);
	$action = "edit";
	
	if($_REQUEST['id'] == '')
		$new_id		=  mysql_insert_id();

	$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
	
}

if($action == 'edit')	{
	$query = "select * from portfolio_categ WHERE id='{$_REQUEST['id']}'";
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
	<script src="../js/jquery-1.2.3.min.js"></script>
	<script>
		$(document).ready(function(){
		
			$('#submit').click(function()	{
				$('#form_category').submit();
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
<form id="form_category" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" >
        	<a href="index.php?_page=pfolio_categories" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button>

		</td>
	  </tr> 	
  
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Category:<br />
        	<input type="text" name="category" value="<?=$recordsList[0]['category']?>" id="category" class="pref"  /></td>
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