<?
if($_SESSION[AUTH_PREFIX.'AUTH'])	{
	header("Location:".APP_URL);
}	

if ($_REQUEST['Submit']) {
	$email 		= $_REQUEST['email'];
	
	$email_exist	= dbQuery("SELECT count(*) FROM customers WHERE email='$email' AND email<>'' AND status='active'",'count');
	if($email_exist ==0)
		$ERR_MSG	= "Email does not exist , please try again";
	else	{
		$newPassword	= randomString(8);
		$dbFields = array();
		$dbFields['password'] = md5($newPassword);
		$specialFields = array();
		
		dbPerform("customers", $dbFields, $specialFields, "email='$email'");
		$passwordChanged = true;
		
		//email user
		$data[0] = $email;
		//$data[0] = 'adarsh@freedomsites.co.uk';
		$data[1] = SITE_NAME;
		$data[2] = EMAIL;
		$data[3] = 'Password reset';
		$data[4] = "<p>Your password has been reset:</p>
					<p><u><strong>Login details</strong></u><br>
					Email: ".$_REQUEST['email']."<br>

					Username: ".$email."<br>
					Password: ".$newPassword."<br>
					
					<p>&nbsp;</p>
					<p>Thanks</p>
					<strong>".SITE_NAME."</strong>";
		mailbox('',$data);
		
	}	
}

?>
<? if($passwordChanged) { ?>
	<br><p class="lead text-white">Password has been reset and sent to your registered Email, Thank you. <a href="sign-in.html">Click here</a> to login</p>
<? } else { ?>
	<? if ($ERR_MSG!="") { ?><p class="bg-danger error-messages"><?=$ERR_MSG?></p><? } ?>
	        
        <div class="col align-self-center hidden-md-down">
            <div class="display-1 text-white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
            <div class="display-3 text-white">Forgot Password?</div>
            <p class="lead text-white">Sign in to your account to personalise your expericence.</p>
        </div><!-- .col .col-md-5 -->
        <div class="col col-lg-auto align-self-center">
            <div class="form-box">
                <h1><i class="fa fa-unlock-alt" aria-hidden="true"></i> Forgot Password?</h1>
                <form name="frmChangePass" action="" method="post">
                    <input type="email" placeholder="Email" name="email" required />
                    <div class="form-buttons">
                        <button type="submit" name="Submit" value="Reset Password" class="btn btn-primary">Reset Password</button>
                    </div><!-- .row .form-buttons -->
                    <p class="register-link">Don't have an account? <a href="register.html">Sign Up</a></p>
                </form>
            </div><!-- .form-box -->
        </div><!-- .col-md-5 --> 
<? } ?>