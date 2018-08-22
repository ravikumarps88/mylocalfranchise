<?
if($_SERVER['HTTP_REFERER'] != APP_URL.'/sign-in.html')
	$_SESSION['last_page']	= ($_SERVER['HTTP_REFERER']!=''?$_SERVER['HTTP_REFERER']:APP_URL);

if($_SESSION[AUTH_PREFIX.'AUTH'])	{
	//$my_page	= ($_SESSION['account_type'] == 'customer' ? 'my-account.html' : 'my-account-vendor.html');
	header("Location:".$_SESSION['last_page']);
}	

if($_REQUEST['action'] == 'sign in')	{
	foreach($_REQUEST as $key=>$val)
		 $$key	= addslashes($val);
	if(authenticateUser($email, $password, 'customer'))	{
		setcookie( "franchiselocal_remember", 'on', strtotime( '+30 days' ) );
		setcookie( "franchiselocal_email", $email, strtotime( '+30 days' ) );
		setcookie( "franchiselocal_pwd", $password, strtotime( '+30 days' ) );
			
		header("Location:".$_SESSION['last_page']);
	}	
	else
		$msg	= "Wrong Username/Password. Try again.";	
	
	
}

?>
<div class="col align-self-center hidden-md-down">
    <div class="display-1 text-white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
    <div class="display-3 text-white">Sign in</div>
    <p class="lead text-white">Sign in to your account to personalise your expericence.</p>
</div><!-- .col .col-md-5 -->
<div class="col col-lg-auto align-self-center">
    <div class="form-box">
        <h1><i class="fa fa-unlock-alt" aria-hidden="true"></i> Sign in</h1>
        <form id="loginform"  method="post" action="">
            <input type="email" placeholder="Email address" name="email"  value="<?=$_REQUEST["email"]?>" required="" autofocus="">
            <input type="password" placeholder="Password" name="password"  value="<?=$_REQUEST["password"]?>">
            <p class="forgot-password-link"><a href="forgot_password.html">Forgot your password?</a></p>
            <div class="form-buttons">
                <button class="btn btn-primary" value="sign in" name="action">Sign in</button>
                <a class="btn btn-facebook" href="fbconfig.php" ><i class="fa fa-facebook-official" aria-hidden="true"></i> Continue with Facebook</a>
            </div><!-- .row .form-buttons -->
            <h5><?=$msg?></h5>
            <p class="register-link">Don't have an account? <a href="register.html">Sign Up</a></p>
        </form>
    </div><!-- .form-box -->
</div><!-- .col-md-5 -->