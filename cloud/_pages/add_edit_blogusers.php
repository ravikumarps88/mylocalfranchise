<?
if ($action=="save") {
	//echo "<pre>";
	//print_r($_REQUEST);
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	
	//adding to wine profile	
	$dbFields = array();

	$dbFields['firstname'] 				= $firstname;
	$dbFields['lastname'] 				= $lastname;
	$dbFields['email'] 					= $email;
	//$dbFields['phone'] 					= $phone;
	
	$dbFields['position'] 				= $position;

	$dbFields['status'] 				= $status;
	
	$specialFields = array();
	if($_REQUEST['id'] != '')	{		
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_REQUEST['id'];
		$INFO_MSG = "User has been edited.";
	}	
	else	{
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');	
		$INFO_MSG = "User has been added.";
	}
	
	dbPerform("users", $dbFields, $specialFields, $cond);
	$action = "edit";
	
	if($_REQUEST['id'] == '')
		$new_id		=  mysql_insert_id();

	$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
	
}

if($action == 'edit')	{
	$query = "select * from users WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}


$prefixArr	= array();
$prefixArr[]	= array("optionId"=>"mr","optionText"=>"Mr");
$prefixArr[]	= array("optionId"=>"mrs","optionText"=>"Mrs");
$prefixArr[]	= array("optionId"=>"miss","optionText"=>"Miss");
$prefixArr[]	= array("optionId"=>"ms","optionText"=>"Ms");
$prefixArr[]	= array("optionId"=>"dr","optionText"=>"Dr");
$prefixArr[]	= array("optionId"=>"prof","optionText"=>"Prof");
$prefixArr[]	= array("optionId"=>"sir","optionText"=>"Sir");
$prefixArr[]	= array("optionId"=>"lord","optionText"=>"Lord");
$prefixArr[]	= array("optionId"=>"lady","optionText"=>"Lady");

$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"pending","optionText"=>"Pending");
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
				$('#form_user').submit();
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
<form id="form_user" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="contentTable">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" ><span class="right"><a href="index.php?_page=blogusers" id="back">Back</a>&nbsp;&nbsp;&nbsp;<a id="submit" style="cursor:pointer;">Save</a></span></td>
	  </tr> 	
	  
	  
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>First name:</td>
		<td colspan="3"><input type="text" name="firstname" value="<?=no_magic_quotes($recordsList[0]['firstname'])?>" id="firstname" class="pref"  /></td>
      </tr>
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>Surname:</td>
		<td colspan="3"><input type="text" name="lastname" value="<?=no_magic_quotes($recordsList[0]['lastname'])?>" id="lastname" class="pref"  /></td>
      </tr>
      
     <!-- <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>Email:</td>
		<td colspan="3"><input type="text" name="email" value="<?=$recordsList[0]['email']?>" id="email" class="pref"  /></td>
      </tr> -->
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>Position:</td>
		<td colspan="3"><input type="text" name="position" value="<?=no_magic_quotes($recordsList[0]['position'])?>" id="position" class="pref"  /></td>
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