<?

if ($_REQUEST['process']=="yes") {
	$oldPassword = $_REQUEST['oldPassword'];
	$newPassword = $_REQUEST['newPassword'];
	
	$oPassword	= dbQuery("SELECT password FROM users WHERE id='{$_SESSION['ADMIN_USER_PROFILE']['id']}'",'singlecolumn');
	if (md5($oldPassword) != $oPassword)
		$ERR_MSG = "Invalid old-password!";	
	
	if($ERR_MSG == '')	{
		$dbFields = array();
		$dbFields['password'] = md5($newPassword);
		$specialFields = array();
		$cfgKey	= "id='{$_SESSION['ADMIN_USER_PROFILE']['id']}'";
		dbPerform("users", $dbFields, $specialFields, $cfgKey);
		$passwordChanged = true;
		$INFO_MSG	= "Admin password was changed.";
	}
}

?>

<script type="text/javascript"> 
	$(document).ready(function() { 
	
		
	}); 
</script>	

	<form name="frmChangePass" id="chpwd" action="index.php?_page=changePassword&process=yes" method="post" class="content-wrap validate">
    
  <p>If you would like to update your password please enter your current password and then your new password below.</p><br/>  
    
    
    <div class="row">			
            
           
            <div class="col-md-6">
                <div class="form-group">
                   Old Password:<br />
        	<input name="oldPassword" type="password" id="oldPassword" value="" size="40" class="form-control" placeholder="Please enter your old password" data-validate="required" /></td>
                </div>
            </div>
            
             <div class="col-md-6">
                <div class="form-group">
                   
                </div>
            </div>
    </div>
    
    <div class="row">	
            
            <div class="col-md-6">
                <div class="form-group">
                   New Password:<br /><input name="newPassword" type="password" id="password" value="" size="40" class="form-control" placeholder="Please choose your new password" data-validate="required" />
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    New Password [Confirm]<br /><input name="newPassword2" type="password" id="password_confirm" value="" size="40" class="form-control" placeholder="Please confirm your password" data-validate="required" equalTo="#password" />
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                     <button type="submit" class="btn btn-primary pull-right">Change Password</button>
                </div>
            </div>
   
  </div>  

    
    
	</form>
	