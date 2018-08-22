<?
if($_REQUEST['subscribe'])	{
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	if(customerEmailExist($email) == 0)	{	
	
		//adding to customer table	
		$dbFields = array();
		
		$dbFields['email'] 			= $email;
		$dbFields['newsletter_subs']= 'yes';
		
		$specialFields = array();
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');	
			
			
		if(dbPerform("customers", $dbFields, $specialFields))	{
			
			//email user
			/*$email_subject = 'Newletter Subscription';
			$email_signup	= '<tr>
							  <td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
							  <td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$email.'</td>
							</tr>';
						
			$email_tmp	= createSignupEmailTemplate($firstname,$email_signup);
			
			sendMandrillMail($email,$firstname.' '.$lastname,EMAIL,SITE_NAME,$email_subject,$email_tmp);
			
			// email to admin
			$email_subject = 'Registration Form received';
			$email_signup	= '<tr>
							  <td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Name:</td>
							  <td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$firstname.' '.$lastname.' </td>
							</tr>
							<tr>
							  <td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
							  <td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$email.'</td>
							</tr>
							<tr>
							  <td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Address 1:</td>
							  <td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$address1.'</td>
							</tr>
							<tr>
							  <td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Address 2:</td>
							  <td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$address2.'</td>
							</tr>
							<tr>
							  <td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">City:</td>
							  <td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$city.'</td>
							</tr>
							<tr>
							  <td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Postcode:</td>
							  <td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;  word-wrap:break-word; word-break:break-all;">'.$postcode.'</td>
							</tr>';
						
			$email_tmp	= createAdminSignupEmailTemplate($firstname,$email_signup);
			sendMandrillMail(CONTACT_EMAIL,SITE_NAME,EMAIL,SITE_NAME,$email_subject,$email_tmp);*/
				
		}	
		
	}
	
}
?>
