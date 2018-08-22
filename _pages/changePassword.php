<?
require "lib/app_top.php";
if(!$_SESSION[AUTH_PREFIX.'AUTH']) exit;

if ($_REQUEST['Submit']) {
	$oldPassword = $_REQUEST['oldPassword'];
	$newPassword = $_REQUEST['newPassword'];
	
	if (md5($oldPassword)!=$_SESSION['USER_PROFILE']['password'])
			$ERR_MSG = "Invalid old-password!";	
	
	if($ERR_MSG == '')	{
		$dbFields = array();
		$dbFields['password'] = md5($newPassword);
		$specialFields = array();
		$cfgKey	= "id='{$_SESSION['USER_PROFILE']['id']}'";
		dbPerform("resources", $dbFields, $specialFields, $cfgKey);
		$ERR_MSG = "Password changed";
	}
}

?>


<? if ($ERR_MSG!="") { ?><div class="errorMsg"><?=$ERR_MSG?></div><? } ?>
<link type="text/css" href="css/admin_user.css" rel="stylesheet"   />
<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jscolor.js"></script>
<script type="text/javascript"> 
    $(document).ready(function() { 
        $("#regform").validate({ 
            rules: { 
                oldPassword: "required",
                newPassword: "required",
                newPassword2: "required"

            }, 
            messages: { 
                oldPassword: "required",
                newPassword: "required",
                newPassword2: "required"
            } 
        });

    }); 
</script>

<fieldset><legend>Change Password</legend>
<form name="regform" id="regform"  action="" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="entryTable">
  <tr>
    <th width="26%">Old Password</th>
    <td width="5%" align="center" style="vertical-align:middle;"><strong>:</strong></td>
    <td width="69%"><input name="oldPassword" type="password" id="oldPassword" value="" size="40" /></td>
  </tr>
  <tr>
    <th>New Password</th>
    <td align="center" style="vertical-align:middle;"><strong>:</strong></td>
    <td><input name="newPassword" type="password" id="newPassword" value="" size="40" /></td>
  </tr>
  <tr>
    <th>New Password [Confirm]</th>
    <td align="center" style="vertical-align:middle;"><strong>:</strong></td>
    <td><input name="newPassword2" type="password" id="newPassword2" value="" size="40" /></td>
  </tr>
  
  <tr>
    <td colspan="3" style="padding-top:20px; border:none;"><input type="submit" name="Submit" value="Change Password" /></td>
  </tr>
</table>
</form>
</fieldset>
