<?php
require "../lib/app_top_admin.php";

# Response Data Array
$resp = array();


// Fields Submitted
$username = $_POST["username"];
$password = $_POST["password"];


// This array of data is returned for demo purpose, see assets/js/neon-forgotpassword.js
$resp['submitted_data'] = $_POST;


// Login success or invalid login data [success|invalid]
// Your code will decide if username and password are correct
$login_status = 'invalid';

$authFlag = authenticateAdmin($username, $password);
if ($authFlag) {
	$login_status = 'success';
}

$resp['login_status'] = $login_status;


// Login Success URL
if($login_status == 'success')
{
	
	// Set the redirect url after successful login
	$resp['redirect_url'] = 'index.php';
}


echo json_encode($resp);