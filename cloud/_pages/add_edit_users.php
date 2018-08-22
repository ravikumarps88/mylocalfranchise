<?
if($_REQUEST['action'] == 'save')	{
	//echo "<pre>";
	//print_r($_REQUEST);
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	if(!userEmailExist($email, $_REQUEST['id']))	{
	//adding to users	
	$dbFields = array();
	$dbFields['type'] 			= $type;
	$dbFields['prefix'] 		= $prefix;
	$dbFields['firstname'] 		= $firstname;
	$dbFields['middlename'] 	= $middlename;
	$dbFields['lastname'] 		= $lastname;
	$dbFields['email'] 			= $email;
	if($password != '')
		$dbFields['password'] 	= md5($password);
	
	$dbFields['status'] 		= $status;
	$specialFields = array();
	
	if($_REQUEST['id'])	{
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_REQUEST['id'];
		
		$INFO_MSG = "User has been edited.";
		dbPerform("users", $dbFields, $specialFields, $cond);
	}
	else	{
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');
		$INFO_MSG = "User has been added.";
		dbPerform("users", $dbFields, $specialFields);
	}
	$_REQUEST['id']	= ($_REQUEST['id'] == '' ? mysql_insert_id() : $_REQUEST['id']);
	
	}//duplicate email check
	else
		$WARNING_MSG	=  "Email already exist, Try again!!";	
}

$profile			= dbQuery("SELECT * FROM users WHERE id='{$_REQUEST['id']}'", 'single');

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


$accArr	= array();
$accArr[]	= array("optionId"=>"yes","optionText"=>"Yes");
$accArr[]	= array("optionId"=>"no","optionText"=>"No");
$accArr[]	= array("optionId"=>"other","optionText"=>"Other");

$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"pending","optionText"=>"Pending");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusArr[]	= array("optionId"=>"all","optionText"=>"All");

?>

<script type="text/javascript"> 
	$(document).ready(function() { 
		$('.user_radio').click(function()	{
			if($(this).val() == 'admin')	{
				$('#admin_tr').show();
				$('#telesales_tr').hide();
			}
			
			else if($(this).val() == 'telesales')	{
				$('#admin_tr').hide();
				$('#telesales_tr').show();
			}
			
			else	{
				$('#admin_tr').hide();
				$('#telesales_tr').hide();
			}	
		});	
	}); 
</script>

<form id="regform" action="" method="post" enctype="multipart/form-data" class="form-horizontal form-groups-bordered validate">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3" >
        	<p class="bs-example">
                <a href="index.php?_page=users" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
                    
                <button type="submit" class="btn btn-primary pull-right">Save</button>
			</p> 
        </td>
	  </tr> 	
	  
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">User Level<br />
        
            <div class="radio radio-replace">    
                <input type="radio" class="user_radio" name="type" value="admin" <?=$profile['type'] == 'admin' ? 'checked="checked"' : ''?>   style="width:20px; display:inline;" />
                <label>Admin</label>
            </div>    
            
            <div class="radio radio-replace">    
            	<?
                if($_SESSION[AUTH_PREFIX.'SUPERADMIN_AUTH'])
				{
				?>
                <input type="radio" class="user_radio" name="type" value="superadmin" <?=$profile['type'] == 'superadmin' ? 'checked="checked"' : ''?>  style="width:20px; display:inline;"  />
                <label>Superadmin</label>
                
                <?
				}
				?>	
            </div>
                        
			
            
            
        </td>
	  </tr>
      
      <tr style="display:<?=$profile['type'] == 'admin'?'':'none'?>;" id="admin_tr">  
		<td width="41%">
	        Franchise:&nbsp;<br />
			<input  type="text" value="<?=no_magic_quotes($profile['franchise'])?>" name="franchise"  id="field-1" class="form-control" placeholder="Franchise name, can contain alphanumeric characters"  />
		</td>
	  </tr>
      
      <tr style="display:<?=$profile['type'] == 'telesales'?'':'none'?>;" id="telesales_tr">  
		<td width="41%">
	        Company:&nbsp;<br />
			<input  type="text" value="<?=no_magic_quotes($profile['company'])?>" name="company"  id="field-1" class="form-control" placeholder="Company name, can contain alphanumeric characters"  />
		</td>
	  </tr>
	      
	  <tr>  
		<td width="41%">
	        Prefix:&nbsp;<br />
			<select class="selectboxit" name="prefix" >
				<?=htmlOptions($prefixArr, $profile['prefix']);?>
            </select>
		</td>
	  </tr>
      
      <tr>  
		<td width="41%">
	        First Name:&nbsp;<br />
			<input  type="text" value="<?=no_magic_quotes($profile['firstname'])?>" name="firstname"  id="field-1" class="form-control" data-validate="required" data-message-required="required field." placeholder="Firstname of yours, can contain alphanumeric characters"  />
		</td>
	  </tr>
      <tr>  
		<td width="41%">
	        Surname:&nbsp;<br />
			<input  type="text" value="<?=no_magic_quotes($profile['lastname'])?>"  id="field-1" class="form-control" name="lastname" size="25" placeholder="Lastname/Surname of yours, can contain alphanumeric characters"   />
		</td>
	  </tr>
      <tr>  
		<td width="41%">
	        E-mail:&nbsp;<br />
			<input   type="text" value="<?=$profile['email']?>"  id="field-1" class="form-control" data-validate="required,email" data-message-required="required field." placeholder="E-mail address" name="email"  />
		</td>
	  </tr>
      <tr>  
		<td width="41%">
	        Create a Password:&nbsp;<br />
			<input type="password" name="password" value="" id="password" class="form-control" data-message-required="required field." placeholder="Please choose your own password" autocomplete="off" />
		</td>
	  </tr>
      <tr>  
		<td width="41%">
	        Confirm Password:&nbsp;<br />
			<input type="password" name="password_again" value="" class="form-control" data-validate="validate-equalTo[#password]" data-message-required="required field." placeholder="Please confirm your password" autocomplete="off" />
		</td>
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

