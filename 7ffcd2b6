<?php
require "lib/app_top.php";

if($_REQUEST['action'] == 'contact_franchise')	{
	// Check for empty fields
	if(empty($_POST['firstname'])  		||
	   empty($_POST['email']) 	    ||
	   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
	   {
		//echo "No arguments Provided!";
		return false;
	   }
	   
	$firstname	= $_POST['firstname'];
	$lastname 	= $_POST['lastname'];
	$email 		= $_POST['email'];
	$phone 		= $_POST['phone'];
	$address1 	= $_POST['address1'];
	$address2 	= $_POST['address2'];
	$city 		= $_POST['city'];
	$county 	= $_POST['county'];
	$postcode 	= $_POST['postcode'];
	
	$liquid_capital 	= $_POST['liquid_capital'];
	$timeframe 			= $_POST['timeframe'];
	$preferred_location = $_POST['preferred_location'];
	
	$method_contact 	= $_POST['method_contact'];
	$best_time 			= $_POST['best_time'];
	
	$message 			= $_POST['message'];
	
	$create_account 	= $_POST['create_account'];
	$newsletter			= $_POST['newsletter'];
	
	//$to 	= 'aadukp@gmail.com';
	//$name 	= 'Adarsh K Peethambaran';
	
	
	$email_body	= '<tr>
					  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Name:</td>
					  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$firstname.' '.$lastname.' </td>
					</tr>
					<tr>
					  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
					  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$email.'</td>
					</tr>
					<tr>
					  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Phone:</td>
					  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$phone.'</td>
					</tr>
					<tr>
					  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Best Time to call:</td>
					  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$best_time.'</td>
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
					  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">County:</td>
					  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$county.'</td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Postcode:</td>
					  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;  word-wrap:break-word; word-break:break-all;">'.$postcode.'</td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Available Liquid Capital:</td>
					  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$liquid_capitalArr[$liquid_capital].'</td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Preferred Method of Contact:</td>
					  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$method_contact.'</td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Timeframe to Buy:</td>
					  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$timeframe.'</td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Preferred Location:</td>
					  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$preferred_location.'</td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Message:</td>
					  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.nl2br($message).'</td>
					</tr>';
	
	// Create the email and send the message
	if($_REQUEST['franchise_id'] > 0)	{
		$to 	= getFieldValue($_REQUEST['franchise_id'],'email','franchises');
		$name 	= getFieldValue($_REQUEST['franchise_id'],'vendor','franchises');
		$fname 	= getFieldValue($_REQUEST['franchise_id'],'firstname','franchises');
		$cc 	= getFieldValue($_REQUEST['franchise_id'],'email_cc','franchises');
		
		$email_subject = "$fname".SUBJECT_LEAD;
		
		$email_tmp	= createLeadEmailTemplate($fname,$name,$email_body);
		
		sendMandrillMail($to,$name,EMAIL,SITE_NAME,$email_subject,$email_tmp,$bcc='',$cc);
		
		//sign up user if not logged in 
		if(!$_SESSION[AUTH_PREFIX.'AUTH'] && $create_account == 'yes')	{
			if(customerEmailExist($email) == 0)	{	
	
				$password	= randomString(7);
				
				//adding to customer table	
				$dbFields = array();
				$dbFields['title'] 			= $title;
				$dbFields['firstname'] 		= $firstname;
				$dbFields['lastname'] 		= $lastname;
				$dbFields['email'] 			= $email;
				$dbFields['password'] 		= md5($password);
				
				$dbFields['phone'] 			= $phone;
				$dbFields['address1'] 		= $address1;
				$dbFields['address2'] 		= $address2;
			
				$dbFields['town'] 			= $city;
				$dbFields['county'] 			= $county;
				
				$dbFields['postcode'] 		= $postcode;
				
				$dbFields['liquid_capital']	= $liquid_capital;
				$dbFields['timeframe'] 		= $timeframe;
				
				$dbFields['method_contact']		= $method_contact;
				$dbFields['preferred_location'] = $preferred_location;
				
				$dbFields['newsletter_subs']= $newsletter;
				
				$specialFields = array();
				$dbFields['inserted_on'] 		= 'now()';
				$specialFields = array('inserted_on');	
					
					
				if($customers_id = dbPerform("customers", $dbFields, $specialFields))	{
					
					//$customers_id	= mysql_insert_id();
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
									  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">County:</td>
									  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$county.'</td>
									</tr>
									<tr>
									  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Postcode:</td>
									  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;  word-wrap:break-word; word-break:break-all;">'.$postcode.'</td>
									</tr>';
								
					$email_tmp	= createSignupEmailTemplate($firstname,$email_signup);			
					sendMandrillMail($email,$firstname.' '.$lastname,EMAIL,SITE_NAME,$email_subject,$email_tmp);
					
					// email to admin
					/*$data[0] = CONTACT_EMAIL;
					$data[1] = SITE_NAME;
					$data[2] = EMAIL;
					$email_subject 	= SUBJECT_SIGNUP;
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
					
					//Auto Login user
					authenticateUser($email, $password, 'customer');
						
				}//dbentry	
				
			}//email exist
			
		}//create account
		
		//customer id
		if($_SESSION[AUTH_PREFIX.'AUTH'])
			$customers_id	= $_SESSION['USER_PROFILE']['id'];
			
		//store request details
		$dbFields = array();
		$dbFields['franchise_id'] 	= $_REQUEST['franchise_id'];
		$dbFields['customers_id'] 	= $customers_id;
		
		$dbFields['title'] 			= $title;
		$dbFields['firstname'] 		= $firstname;
		$dbFields['lastname'] 		= $lastname;
		$dbFields['email'] 			= $email;
		
		$dbFields['phone'] 			= $phone;
		$dbFields['address1'] 		= $address1;
		$dbFields['address2'] 		= $address2;
	
		$dbFields['city'] 			= $city;
		$dbFields['county']			= $county;
		$dbFields['postcode'] 		= $postcode;
		
		$dbFields['liquid_capital']	= $liquid_capital;
		$dbFields['timeframe'] 		= $timeframe;
		
		$dbFields['method_contact']		= $method_contact;
		$dbFields['preferred_location']	= $preferred_location;
		$dbFields['best_time']			= $best_time;
		
		$dbFields['message']			= $message;
		
		$specialFields = array();
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');	
			
		dbPerform("request_details", $dbFields, $specialFields);
		//store end
	}
	
	
	
	else	{
		if(!$_SESSION[AUTH_PREFIX.'AUTH'])
			$customer_id	= $_SESSION['tmp_profile_id'];
		else
			$customer_id	= $_SESSION['USER_PROFILE']['id'];
		
		//customer id
		if($_SESSION[AUTH_PREFIX.'AUTH'])
			$customers_id	= $_SESSION['USER_PROFILE']['id'];
				
		//sign up user if not logged in 
		if(!$_SESSION[AUTH_PREFIX.'AUTH'] && $create_account == 'yes')	{
			if(customerEmailExist($email) == 0)	{	
	
				$password	= randomString(7);
				
				//adding to customer table	
				$dbFields = array();
				$dbFields['title'] 			= $title;
				$dbFields['firstname'] 		= $firstname;
				$dbFields['lastname'] 		= $lastname;
				$dbFields['email'] 			= $email;
				$dbFields['password'] 		= md5($password);
				
				$dbFields['phone'] 			= $phone;
				$dbFields['address1'] 		= $address1;
				$dbFields['address2'] 		= $address2;
			
				$dbFields['town'] 			= $city;
				$dbFields['county'] 		= $county;
				
				$dbFields['postcode'] 		= $postcode;
				
				$dbFields['liquid_capital']	= $liquid_capital;
				$dbFields['timeframe'] 		= $timeframe;
				
				$dbFields['method_contact']		= $method_contact;
				$dbFields['preferred_location']	= $preferred_location;
				
				$dbFields['newsletter_subs']= $newsletter;
				
				$specialFields = array();
				$dbFields['inserted_on'] 		= 'now()';
				$specialFields = array('inserted_on');	
					
					
				if($customers_id = dbPerform("customers", $dbFields, $specialFields))	{

					//$customers_id	= mysql_insert_id();
					//email user
					$email_subject 	= "$firstname".SUBJECT_SIGNUP;
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
									</tr>';
								
					$email_tmp	= createSignupEmailTemplate($firstname,$email_signup);
					sendMandrillMail($email,$firstname.' '.$lastname,EMAIL,SITE_NAME,$email_subject,$email_tmp);
					
					// email to admin
					/*$data[0] = CONTACT_EMAIL;
					$data[1] = SITE_NAME;
					$data[2] = EMAIL;
					$email_subject 	= SUBJECT_SIGNUP;
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
					
					authenticateUser($email, $password, 'customer');
						
				}//dbentry	
				
			}//email exist
			
		}//create account	
		
		
		$email_body	= '<tr>
						  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Name:</td>
						  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$firstname.' '.$lastname.' </td>
						</tr>
						<tr>
						  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
						  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$email.'</td>
						</tr>
						<tr>
						  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Phone:</td>
						  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$phone.'</td>
						</tr>
						<tr>
						  <td width="30%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Best Time to call:</td>
						  <td width="70%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$best_time.'</td>
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
						  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Available Liquid Capital:</td>
						  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$liquid_capitalArr[$liquid_capital].'</td>
						</tr>
						<tr>
						  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Preferred Method of Contact:</td>
						  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$method_contact.'</td>
						</tr>
						<tr>
						  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Timeframe to Buy:</td>
						  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$timeframe.'</td>
						</tr>
						<tr>
						  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Preferred Location:</td>
						  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$preferred_location.'</td>
						</tr>
						<tr>
						  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Message:</td>
						  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.nl2br($message).'</td>
						</tr>';
		
		$request_list	= dbQuery("SELECT * FROM customers_request WHERE customers_id='$customer_id'");
		foreach($request_list as $val)	{
			$to 	= getFieldValue($val['franchise_id'],'email','franchises');
			$name 	= getFieldValue($val['franchise_id'],'vendor','franchises');
			$fname 	= getFieldValue($val['franchise_id'],'firstname','franchises');
			$cc 	= getFieldValue($val['franchise_id'],'email_cc','franchises');
			
			$email_subject = "$fname".SUBJECT_LEAD;
			
			$email_tmp	= createLeadEmailTemplate($fname,$name,$email_body);
			sendMandrillMail($to,$name,EMAIL,SITE_NAME,$email_subject,$email_tmp,$bcc='',$cc);
			
			//store request details
			$dbFields = array();
			$dbFields['franchise_id'] 	= $val['franchise_id'];
			$dbFields['customers_id'] 	= $customers_id;
			
			$dbFields['title'] 			= $title;
			$dbFields['firstname'] 		= $firstname;
			$dbFields['lastname'] 		= $lastname;
			$dbFields['email'] 			= $email;
			
			$dbFields['phone'] 			= $phone;
			$dbFields['address1'] 		= $address1;
			$dbFields['address2'] 		= $address2;
		
			$dbFields['city'] 			= $city;
			$dbFields['county']			= $county;
			$dbFields['postcode'] 		= $postcode;
			
			$dbFields['liquid_capital']	= $liquid_capital;
			$dbFields['timeframe'] 		= $timeframe;
			
			$dbFields['preferred_location']	= $preferred_location;
			$dbFields['best_time']			= $best_time;
			$dbFields['method_contact']		= $method_contact;
			
			$dbFields['message']			= $message;
			
			$specialFields = array();
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
				
			dbPerform("request_details", $dbFields, $specialFields);
			//store end
		}
		
			
	}
	
	
	
	return true;			
}

//=====================================================================================
//=====================================================================================
if($_REQUEST['action'] == 'add_to_request_list')		{
	if($_SESSION[AUTH_PREFIX.'AUTH'])	{
		if(customerRequestExist($_REQUEST['franchise_id'], $_SESSION['USER_PROFILE']['id']) == 0)	{
			$dbFields = array();
			$dbFields['franchise_id'] 	= $_REQUEST['franchise_id'];
			$dbFields['customers_id'] 	= $_SESSION['USER_PROFILE']['id'];
		
			$specialFields = array();
			$dbFields['inserted_on'] 	= 'now()';
			$specialFields = array('inserted_on');	
				
			dbPerform("customers_request", $dbFields, $specialFields);
			
			echo json_encode(array("login"=>true));
		}	
	}
	else	{
		if(customerRequestExist($_REQUEST['franchise_id'], $_SESSION['tmp_profile_id']) == 0)	{
			$dbFields = array();
			$dbFields['franchise_id'] 	= $_REQUEST['franchise_id'];
			$dbFields['customers_id'] 	= $_SESSION['tmp_profile_id'];
		
			$specialFields = array();
			$dbFields['inserted_on'] 	= 'now()';
			$specialFields = array('inserted_on');	
				
			dbPerform("customers_request", $dbFields, $specialFields);
			
			echo json_encode(array("login"=>true));
		}
	}	
}
//=====================================================================================
//=====================================================================================
if($_REQUEST['action'] == 'remove_from_request_list')		{
	if($_SESSION[AUTH_PREFIX.'AUTH'])	{
		dbQuery("DELETE FROM customers_request WHERE franchise_id='{$_REQUEST['franchise_id']}' AND customers_id='{$_SESSION['USER_PROFILE']['id']}'");
		echo json_encode(array("login"=>true));
	}
	else	{
		dbQuery("DELETE FROM customers_request WHERE franchise_id='{$_REQUEST['franchise_id']}' AND customers_id='{$_SESSION['tmp_profile_id']}'");
		echo json_encode(array("login"=>true));		
	}	
}

//refresh request list
if($_REQUEST['action'] == 'refresh_request_list')		{
	echo getRequestList('{request_list}');
	echo '<p class="text-right" style="margin-bottom:0;"><a href="request-list.html">View all</a></p>';
}
?>