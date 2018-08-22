<?

function authenticateAdmin($username="", $password="") {
	if ($username=="") {
		if (isset($_SESSION[AUTH_PREFIX.'ADMIN_AUTH'])) {
			return true;
		} else {
			return false;
		}
	}
	
	$sql		= "SELECT * FROM users WHERE email='$username' AND status='active' AND (type='telesales' || type='admin' || type='superadmin' || type='user')";
	$userProfile= dbQuery($sql, 'single');	
	if (md5($password) == $userProfile['password']) {
		$_SESSION[AUTH_PREFIX.'ADMIN_AUTH'] = true;
		$_SESSION['ADMIN_USER_PROFILE']		= $userProfile;
		if($userProfile['type'] == 'superadmin')
			$_SESSION[AUTH_PREFIX.'SUPERADMIN_AUTH'] = true;
		return true;
	} else {
		return false;
	}
	
	
}

function logoutAdmin() {
	unset($_SESSION[AUTH_PREFIX.'ADMIN_AUTH']);
	unset($_SESSION[AUTH_PREFIX.'SUPERADMIN_AUTH']);
}

function authenticateUser($username ='', $password ='', $account_type ='') {
	if ($username=="") {
		if (isset($_SESSION[AUTH_PREFIX.'AUTH'])) {
			return true;
		} else {
			return false;
		}
	}
	$tbl	= ($account_type == 'customer' ? 'customers' : 'vendors' );
	$sql		= "SELECT * FROM $tbl WHERE email='$username' AND status='active'";
	$userProfile= dbQuery($sql, 'single');	
	if (md5($password) == $userProfile['password']) {
		$_SESSION[AUTH_PREFIX.'AUTH'] = true;
		$_SESSION['account_type']	= $account_type;
		$_SESSION['USER_PROFILE']	= $userProfile;
		return true;
	} else {
		return false;
	}

}

//Authenticate FB user
function authenticateFBUser($email,$fb_id) {
	
	$sql		= "SELECT * FROM customers WHERE email='$email' AND status='active'";
	$userProfile= dbQuery($sql, 'single');	
	
	$_SESSION[AUTH_PREFIX.'AUTH'] = true;
	$_SESSION['account_type']	= 'customer';
	$_SESSION['USER_PROFILE']	= $userProfile;

	return true;

}

//end

function logoutUser() {
	unset($_SESSION[AUTH_PREFIX.'AUTH']);
	unset($_SESSION['USER_PROFILE']);
	
	$_SESSION['logout'] = 'yes';
}

?>