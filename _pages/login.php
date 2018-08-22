<?
if($_SERVER['HTTP_REFERER'] != APP_URL.'/login.html')
	$_SESSION['last_page']	= $_SERVER['HTTP_REFERER'];
if($_SESSION[AUTH_PREFIX.'AUTH'])	{
	//$my_page	= ($_SESSION['account_type'] == 'customer' ? 'my-account.html' : 'my-account-vendor.html');
	header("Location:".$_SESSION['last_page']);
}	
	
if($_REQUEST['action'])	{
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	if(authenticateUser($email, $password, 'customer'))	{
		//$my_page	= ($_SESSION['account_type'] == 'customer' ? 'my-account.html' : 'my-account-vendor.html');
		header("Location:".$_SESSION['last_page']);
	}	
	else
		$msg	= 'Incorrect login details, try again!!!';
	
	
}

?>
<script type="text/javascript"> 
$(document).ready(function() {
		
	$("#loginform").validate({ 
		rules: { 
			email: {
				required: true, 
				email: true 
			},
			password: {
				required: true,
				minlength: 6
			}
		}, 
		messages: { 
			email: "", 
			password: ""
			
		} 
	});
	

	
});

</script>

<?php /*?>#################################################################################################################################################################################################################################<?php */?>



<?php /*?>#################################################################################################################################################################################################################################<?php */?>

  

<form class="form-inline clearfix" name="form2" id="loginform"  method="post" action="">
 <table align=center bordercolor="#00FF66" border=0  width=100% cellpadding="3" cellspacing="3">
 <tr valign=top>
  <td colspan=2><h4>Login</h4></td>
 </tr>
 <tr valign=top>
  <td colspan=2>
   <table>
   	<!--<tr>
     <td colspan="2" align="left">
     	<input type="radio" name="account_type" value="customer" checked="checked" /> Customer   &nbsp;&nbsp;&nbsp;&nbsp; 
     	<input type="radio" name="account_type" value="vendor" /> Business<br><br></td>	
    </tr>-->
    
    <tr>
     <td>Email:&nbsp;&nbsp; <input type="text" name="email"  id="email" value="<?=$_REQUEST["email"]?>"/></td>
     <td>Password:&nbsp;&nbsp; <input type="password" name="password"  id="password" value="<?=$_REQUEST["password"]?>"  /></td>
    </tr>
   </table>
   <?=$msg?>
  </td>
 </tr>
 <tr valign=top>
  <td colspan=2 align="right"><button name="action" value="Login" class="btn btn-blue btn-large">Login</button></td>
 </tr>
</table>
</form>

<div class="clearfix" id="sign-in">
    <p class="pull-left"><a href="">Sign up</a> for vouchers and discount!</p>
</div>