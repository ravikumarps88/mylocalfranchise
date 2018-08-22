<?
if($_SERVER['HTTP_REFERER'] != APP_URL.'/register.html')
	$_SESSION['last_page']	= $_SERVER['HTTP_REFERER'];

if($_SESSION[AUTH_PREFIX.'AUTH'])	{
	header("Location:".$_SESSION['last_page']);
}	

if($_REQUEST['signup'])	{

	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	if(customerEmailExist($email) == 0)	{	
	
		//$password	= randomString(7);
		$password	= $_REQUEST['password'];
		//adding to customer table	
		$dbFields = array();
		$dbFields['title'] 			= $title;
		$dbFields['firstname'] 		= $firstname;
		$dbFields['lastname'] 		= $lastname;
		$dbFields['email'] 			= $email;
		$dbFields['password'] 		= md5($password);
		
		$specialFields = array();
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');	
			
		$new_id	= dbPerform("customers", $dbFields, $specialFields);	
		if($new_id > 0)	{
			
			//email user
			$email_subject = "$firstname".SUBJECT_SIGNUP;
			$email_signup	= '<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Name:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$firstname.' '.$lastname.' </td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$email.'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Password:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$password.'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Address 1:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$address1.'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Address 2:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$address2.'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">City:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$city.'</td>
							</tr>
							<tr>
							  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Postcode:</td>
							  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;  word-wrap:break-word; word-break:break-all;">'.$postcode.'</td>
							</tr>
							<tr>
							  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Phone:</td>
							  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;  word-wrap:break-word; word-break:break-all;">'.$phone.'</td>
							</tr>
							';
						
			$email_tmp	= createSignupEmailTemplate($firstname,$email_signup);
			
			sendMandrillMail($email,$firstname.' '.$lastname,EMAIL,SITE_NAME,$email_subject,$email_tmp);
			
			// email to admin
			/*$email_subject = 'Registration Form received';
			$email_signup	= '<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Name:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$firstname.' '.$lastname.' </td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$email.'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Address 1:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$address1.'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Address 2:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$address2.'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">City:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$city.'</td>
							</tr>
							<tr>
							  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Postcode:</td>
							  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;  word-wrap:break-word; word-break:break-all;">'.$postcode.'</td>
							</tr>';
						
			$email_tmp	= createAdminSignupEmailTemplate($firstname,$email_signup);
			sendMandrillMail(CONTACT_EMAIL,SITE_NAME,EMAIL,SITE_NAME,$email_subject,$email_tmp);*/
			
			if(authenticateUser($email, $password, 'customer'))	{
				header("Location:".APP_URL."/sign-up-step-2.html?new_id=".$new_id);
			}
			
			$msg	= "Successfully signed up.";
				
		}	
		else
			$msg	= "Error Occured. Try again later.";	
		
		
	}
	else
		$msg	= '<div class="alert alert-warning alert-dismissible" role="alert">An account with this email address already exists. Please  <a href="sign-in.html">Sign In</a>';
		
}

?>

<script>
	$(document).ready(function(){
		  
		   $("#regform").validate({
			 rules: {
				upassword: {
					 required: true,
					 minlength : 5
				 },
				
				uemail: {
					 required: true,
					 email : true
				 },
				messages: {
					   upassword: {
						  required: "Please enter the password.",
						  minlength: "Your password must be at least 5 characters long"
						}
                }   
			 }	    	 
			});
	});
</script>

<div class="col align-self-center hidden-md-down">
    <div class="display-1 text-white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
    <div class="display-3 text-white">Sign Up</div>
    <p class="lead text-white">Sign in to your account to personalise your expericence.</p>
</div><!-- .col .col-md-5 -->
<div class="col col-lg-auto align-self-center">
    <div class="form-box">
        <h1><i class="fa fa-unlock-alt" aria-hidden="true"></i> Sign Up</h1>
        <p>Enter your details below to sign up for an account.</p>
        <form action="" method="post" id="regform">
                <div class="row">
                        <div class="co-12 col-xl-6">
                                <div class="form-group">
                                        <input type="text" placeholder="First Name" id="firstName" name="firstname" value="<?=$_REQUEST['firstname']?>" required>
                                        <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                        </div><!-- .co-12 .col-xl-4 -->
                        <div class="co-12 col-xl-6">
                                <div class="form-group">
                                        <input type="text" placeholder="Last Name" name="lastname" value="<?=$_REQUEST['lastname']?>">
                                        <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                        </div><!-- .co-12 .col-xl-4 -->
                </div><!-- .row -->
                <div class="row">
                    <div class="co-12 col-xl-12">
                        <div class="form-group">
                <input type="email" placeholder="Email" id="uemail" name="email" value="<?=$_REQUEST['email']?>" required>
                <p class="help-block text-danger"></p>
                        </div><!-- .form-group -->
                    </div><!-- .co-12 .col-xl-4 -->
                </div><!-- .row -->
                    <div class="row">
                        <div class="co-12 col-xl-12">
                            <div class="form-group">
                <input type="password" placeholder="Password" id="upassword" name="password" required>
                <p class="help-block text-danger"></p>
                        </div><!-- .form-group -->
                    </div><!-- .co-12 .col-xl-4 -->
                    </div><!-- .row -->
            <div class="form-buttons">
                <button class="btn btn-primary" type="submit" value="signup" name="signup">Sign Up</button>
                <a class="btn btn-facebook" href="fbconfig.php" ><i class="fa fa-facebook-official" aria-hidden="true"></i> Continue with Facebook</a>
  
            </div><!-- .row .form-buttons -->
            <h5><?=$msg?></h5>
            <p class="login-link">Already have an account? <a href="sign-in.html">Sign in</a></p>
        </form>
    </div><!-- .form-box -->
</div><!-- .col-md-5 -->