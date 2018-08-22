<?php
session_start();
require "lib/app_top.php";
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

// init app with app id and secret
FacebookSession::setDefaultApplication( '940472076072346','fcf8523d4c41497a31d64a2599463708' );

// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('https://www.franchiselocal.co.uk/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {

	// graph api request for user data
	$request = new FacebookRequest( $session, 'GET', '/me?locale=en_UK&fields=name,email,first_name,last_name' );
	$response = $request->execute();

	// get response
	$graphObject = $response->getGraphObject()->asArray();

	$fbid 			= $graphObject['id'];              // To Get Facebook ID

	$fbfirstname 	= $graphObject['first_name']; 		// To Get Facebook first name
	$fblastname 	= $graphObject['last_name']; 		// To Get Facebook last name
	$fblgender	 	= $graphObject['gender']; 			// To Get Facebook gender

	$femail 		= $graphObject['email'];    		// To Get Facebook email ID

	list($town,$county,$country)	= explode(',',$graphObject['location']->name);

	//list($month,$date,$year)		= explode('/',$graphObject['birthday']);

	/* ---- Session Variables -----*/
	$_SESSION['FBID'] 			= $fbid;

	$_SESSION['FBFIRSTNAME'] 	= $fbfirstname;
	$_SESSION['FBLASTNAME'] 	= $fblastname;
	$_SESSION['FBGENDER'] 		= $fblgender;

	$_SESSION['FBEMAIL'] 		= $femail;

	$_SESSION['FBTOWN'] 		= $town;
	$_SESSION['FBCOUNTY'] 		= $county;

	//$_SESSION['FBDOB']	 		= $year.'-'.$month.'-'.$date;

	/* ---- header location after session ----*/

	if(customerEmailExist($_SESSION['FBEMAIL']) == 0)	{

		//adding to customer table
		$dbFields = array();
		$dbFields['email'] 			= $_SESSION['FBEMAIL'];

		$dbFields['firstname'] 		= $_SESSION['FBFIRSTNAME'];
		$dbFields['lastname'] 		= $_SESSION['FBLASTNAME'];
		$dbFields['gender'] 		= $_SESSION['FBGENDER'];

		$dbFields['town'] 			= $_SESSION['FBTOWN'];
		$dbFields['county'] 		= $_SESSION['FBCOUNTY'];

		//$dbFields['dob'] 			= $_SESSION['FBDOB'];

		$newPassword	= randomString(8);
		$dbFields['password'] 		= md5($newPassword);

		$dbFields['facebook_id'] 		= $_SESSION['FBID'];

		$specialFields = array();
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');

		if(dbPerform("customers", $dbFields, $specialFields))	{
			$email_subject = $_SESSION['FBFIRSTNAME'].SUBJECT_SIGNUP;
			$email_signup	= '<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Name:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$_SESSION['FBFIRSTNAME'].' '.$_SESSION['FBLASTNAME'].' </td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$_SESSION['FBEMAIL'].'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Password:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$newPassword.'</td>
							</tr>

							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">City:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$_SESSION['FBTOWN'].'</td>
							</tr>';

			$email_tmp	= createSignupEmailTemplate($_SESSION['FBFIRSTNAME'],$email_signup);

			sendMandrillMail($_SESSION['FBEMAIL'],$_SESSION['FBFIRSTNAME'].' '.$_SESSION['FBLASTNAME'],EMAIL,SITE_NAME,$email_subject,$email_tmp);

			// email to admin
			/*$email_subject = 'Registration Form received';
			$email_signup	= '<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Name:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$_SESSION['FBFIRSTNAME'].' '.$_SESSION['FBLASTNAME'].' </td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$_SESSION['FBEMAIL'].'</td>
							</tr>
							<tr>
							  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">City:</td>
							  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$_SESSION['FBTOWN'].'</td>
							</tr>';

			$email_tmp	= createAdminSignupEmailTemplate($_SESSION['FBFIRSTNAME'],$email_signup);
			sendMandrillMail(CONTACT_EMAIL,SITE_NAME,EMAIL,SITE_NAME,$email_subject,$email_tmp);*/

			if(authenticateUser($_SESSION['FBEMAIL'], $newPassword, 'customer'))	{
				header("Location:".APP_URL."/my-account.html");
			}

		}

	}

	else	{
		//If user email already exist/registered
		//update the user details
		//adding to customer table
		$dbFields = array();

		$dbFields['firstname'] 		= $_SESSION['FBFIRSTNAME'];
		$dbFields['lastname'] 		= $_SESSION['FBLASTNAME'];
		$dbFields['gender'] 		= $_SESSION['FBGENDER'];
		$dbFields['facebook_id'] 	= $_SESSION['FBID'];

		$dbFields['town'] 			= $_SESSION['FBTOWN'];
		$dbFields['county'] 		= $_SESSION['FBCOUNTY'];

		//$dbFields['dob'] 			= $_SESSION['FBDOB'];

		$specialFields = array();
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');

		$cond	= "email='{$_SESSION['FBEMAIL']}' AND status='active'";
		dbPerform("customers", $dbFields, $specialFields,$cond);

		//automatically login
		if(authenticateFBUser($_SESSION['FBEMAIL'], $_SESSION['FBID']))	{
			header("Location:".APP_URL."/my-account.html");
		}

	}

	header("Location:".APP_URL);

} else {
	$loginUrl = $helper->getLoginUrl( array('scope' => 'email'));
 	header("Location: ".$loginUrl);
}
?>
