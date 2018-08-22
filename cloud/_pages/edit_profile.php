<?
if($_REQUEST['action'] == 'save')	{
	//echo "<pre>";
	//print_r($_REQUEST);
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	if(!userEmailExist($email, $_SESSION['ADMIN_USER_PROFILE']['id']))	{
		//adding to users	
		$dbFields = array();
		$dbFields['prefix'] 		= $prefix;
		$dbFields['firstname'] 		= $firstname;
		$dbFields['middlename'] 	= $middlename;
		$dbFields['lastname'] 		= $lastname;
		$dbFields['email'] 			= $email;
		
		$dbFields['address1'] 		= $address1;
		$dbFields['address2'] 		= $address2;
		$dbFields['phone'] 			= $phone;
		$dbFields['postcode'] 		= $postcode;
		
		$specialFields = array();
		
		
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_SESSION['ADMIN_USER_PROFILE']['id'];
		
		$INFO_MSG = "Profile has been edited.";
		dbPerform("users", $dbFields, $specialFields, $cond);
		
	}//duplicate email check
	else
		$WARNING_MSG	=  "Email already exist, Try again!!";	
}

$profile			= dbQuery("SELECT * FROM users WHERE id='{$_SESSION['ADMIN_USER_PROFILE']['id']}'", 'single');

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
		$("#regform").validate({ 
			rules: { 
				firstname: "required",
//				middlename: "required",
				lastname: "required",
				email: {
					required: true, 
					email: true 
				},
				password_again: {
					minlength: 5,
					equalTo: "#password"
				}
			}, 
			messages: { 
				firstname: "",
				middlename: "",
				lastname: "",
				email: "", 
				password_again:""
			} 
		});
		$('#password_again').val('');
		$('#password').val('');
		
		
		
	}); 
</script>



<form id="regform" action="" method="post" enctype="multipart/form-data" class="content-wrap">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />

<p>Update your details below for your invoice & contact purposes.</p><br/>
<div class="row">			
            
           
            <div class="col-md-4">
                <div class="form-group">
                   Prefix:&nbsp;<br />
			<select class="form-control" id="prefix" name="prefix" help="Prefix for Eg: Mr, Mrs, Ms" >
				<?=htmlOptions($prefixArr, $profile['prefix']);?>
            </select>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                   First Name:&nbsp;<br />
			<input  type="text" class="form-control" value="<?=no_magic_quotes($profile['firstname'])?>" id="firstname" name="firstname" size="25" placeholder="Firstname"  />
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    Surname:&nbsp;<br />
			<input  type="text" value="<?=no_magic_quotes($profile['lastname'])?>" class="form-control" id="lastname" name="lastname" size="25" placeholder="Lastname/Surname"   />
                </div>
            </div>
            
          
            
            
           
            
       <div class="col-md-4">
                <div class="form-group">
                   Address1:&nbsp;<br />
			<input  type="text" value="<?=no_magic_quotes($profile['address1'])?>" class="form-control" id="address1" name="address1" size="25" placeholder="enter line 1 of your address"   />
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                  Address2:&nbsp;<br />
			<input   type="text" value="<?=$profile['address2']?>" class="form-control" id="address2" name="address2" size="35" placeholder="enter line 2 of your address" />
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    Postcode:&nbsp;<br />
			<input  type="text" value="<?=no_magic_quotes($profile['postcode'])?>" class="form-control" id="postcode" name="postcode" size="25" placeholder="enter your postcode"   />
                </div>
            </div>
     
       
      
       
        <div class="col-md-4">
                <div class="form-group">
                   Phone:&nbsp;<br />
			<input   type="text" value="<?=$profile['phone']?>" class="form-control" id="phone" name="phone" size="35" placeholder="Phone number" />
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                   E-mail:&nbsp;<br />
			<input   type="text" value="<?=$profile['email']?>" class="form-control" id="email" name="email" size="35" placeholder="Email" />
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <p class="bs-example">
                <a href="index.php?_page=users" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
                    
                <button type="submit" class="btn btn-primary pull-right">Save</button>
			</p>
                </div>
            </div>
</div>
</form>