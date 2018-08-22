<?
if($_REQUEST['action'] == 'save')	{
	//echo "<pre>";
	//print_r($_REQUEST);
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	if(!customerEmailExist($email, $_REQUEST['id']))	{
	//adding to customers	
		
	$dbFields = array();
		
	$dbFields['firstname'] 		= $firstname;
	$dbFields['lastname'] 		= $lastname;
	
	$dbFields['town'] 			= $town;
	$dbFields['county'] 		= $county;

	$dbFields['email'] 			= $email;
	if($password != '' && ($password==$password_again))
		$dbFields['password'] 		= md5($password);
	elseif($password != '')
		$pwd_msg	= ' Password mismatch';

	$dbFields['status'] 				= $status;
	$specialFields = array();
	
	if($_REQUEST['id'])	{
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_REQUEST['id'];
		
		$INFO_MSG = "Customer has been edited.";
		dbPerform("customers", $dbFields, $specialFields, $cond);
	}
	else	{
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');
		$INFO_MSG = "Customer has been added.";
		dbPerform("customers", $dbFields, $specialFields);
	}
	$_REQUEST['id']	= ($_REQUEST['id'] == '' ? mysql_insert_id() : $_REQUEST['id']);
	
	}//duplicate email check
	else
		$WARNING_MSG	=  "Email already exist, Try again!!<br />";	
}
$INFO_MSG	= $INFO_MSG.$pwd_msg;
$profile			= dbQuery("SELECT * FROM customers WHERE id='{$_REQUEST['id']}'", 'single');


$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"pending","optionText"=>"Pending");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

?>

<script type="text/javascript"> 
	$(document).ready(function() { 
		
	}); 
</script>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li>
        <a href="index.php?_page=customers">Manage Customers</a>
    </li>
    <li class="active">
        <strong>Add/Edit Customers</strong>
    </li>
</ol>

<form id="regform" action="" method="post" enctype="multipart/form-data" class="validate" autocomplete="off" >
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" >
        	<p class="bs-example">
                <a href="index.php?_page=customers" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
                    
                <button type="submit" class="btn btn-primary pull-right">Save</button>
			</p> 
            
        </td>
	  </tr> 	
	  <tr>  
		<td width="41%">
	        First Name:&nbsp;<br />
			<input  type="text" class="form-control" value="<?=no_magic_quotes($profile['firstname'])?>" id="firstname" name="firstname" data-validate="required" data-message-required="required field." placeholder="Firstname of yours, can contain alphanumeric characters"  />
		</td>

		<td width="41%">
	        Lastname:&nbsp;<br />
			<input  type="text" value="<?=no_magic_quotes($profile['lastname'])?>" class="form-control" id="lastname" name="lastname" placeholder="Lastname/Surname of yours, can contain alphanumeric characters"   />
		</td>
	  </tr>
      
      <tr>  
		<td width="41%">
	        Town:&nbsp;<br />
			<input  type="text" class="form-control" value="<?=no_magic_quotes($profile['town'])?>" id="town" name="town" size="25" placeholder="Town of yours, can contain alphanumeric characters"  />
		</td>

		<td width="41%">
	        County:&nbsp;<br />
			<input  type="text" class="form-control" value="<?=no_magic_quotes($profile['county'])?>" id="county" name="county" size="25" placeholder="County of yours, can contain alphanumeric characters"  />
		</td>
	  </tr>
      
      <tr>  
		<td width="41%">
	        Postcode:&nbsp;<br />
			<input  type="text" class="form-control" value="<?=no_magic_quotes($profile['postcode'])?>" id="postcode" name="postcode" size="25" placeholder="postcode of yours, can contain alphanumeric characters"  />
		</td>

		<td width="41%">
	        Email:&nbsp;<br />
			<input  type="text" class="form-control" value="<?=no_magic_quotes($profile['email'])?>" id="email" name="email" data-validate="required,email" data-message-required="required field." placeholder="email of customers, can contain alphanumeric characters"  />
		</td>
	  </tr>
      
      <tr>  
		<td width="41%">
	        Create a Password:&nbsp;<br />
			<input type="password" class="form-control" id="password" name="password" size="35" data-validate="required" data-message-required="required field." placeholder="Please choose your own password" />
		</td>
        <td width="41%">
	       Confirm Password:&nbsp;<br />
			<input type="password" class="form-control" id="password_again" name="password_again" value="" data-validate="required,validate-equalTo[#password]" data-message-required="required field." placeholder="Please confirm your password" />
		</td>
	  </tr>
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Status<br />
			<select name="status" class="selectboxit">
				<?=htmlOptions($statusArr, $profile['status']);?>
			</select>
		</td>
	  </tr>
      
</table>
</form>

