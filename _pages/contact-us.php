<?php echo "sasas";exit;
if($_REQUEST['submit'])	{
	
	//Check to make sure that the name field is not empty
	if(trim($_POST['contactname']) == '') {
		$hasError = true;
	} else {
		$name = trim($_POST['contactname']);
	}


	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}



	//If there is no error, send the email
	if(!isset($hasError)) {
	
		
		$data[0] = CONTACT_EMAIL;
		$data[1] = SITE_NAME;
		$data[2] = EMAIL;
		$data[3] = 'Enquiry Form';
		$data[4] = "<p>Hi,</p>
					<p>An enquiry form has been submitted:</p>
					<p><u><strong>Enquiry form details</strong></u><br>
					Name: ".$_REQUEST['contactname']."<br>
					Email: ".$_REQUEST['email']."<br>
					
					Enquiry/Message: ".$_REQUEST['message']."<br>
					</p>";
		mailbox('',$data);
	
		
		$data[0] = $_REQUEST['email'];
		$data[1] = SITE_NAME;
		$data[2] = EMAIL;
		$data[3] = 'Contact Form received';
		$data[4] = "<p>Hi,</p>
					<p>Your enquiry form has been received:</p>
					<p><u><strong>Enquiry form details</strong></u><br>
					Name: ".$_REQUEST['contactname']."<br>
					Email: ".$_REQUEST['email']."<br>
					
					Enquiry/Message: ".$_REQUEST['message']."<br></p>
					<p>&nbsp;</p>
					<p>Thanks</p>
					<strong>".SITE_NAME."</strong>";			
		mailbox('',$data);
		$emailSent = true;
		//$msg	= "Form submitted successfully.";
	}	
}
?>


    

			
<div id="contact-wrapper">

<?php if(isset($hasError)) { //If errors are found ?>
    <p class="error">Please check if you've filled all the fields with valid information. Thank you.</p>
<?php } ?>

<?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
    <p class="success"><strong>Email Successfully Sent!</strong></p>
    <p>Thank you <strong><?php echo $name;?></strong> for using our contact form! Your email was successfully sent and we will be in touch with you soon.</p>
<?php } ?>

<form method="post" action="contact-us.html" id="contactform">
    <div>
        <label>Name:</label>
        <input type="text" size="45" name="contactname" id="contactname" value="" class="required" />
    </div><br />

    <div>
        <label>Email:</label>
        <input type="text" size="45" name="email" id="email" value="" class="required email" />
    </div>
    <br />
    

    <div>
        <label for="message">Message:</label>
        <textarea rows="8" cols="40" name="message" id="message" class="required"></textarea>
    </div>
    <input type="submit" class="submit-form" value="Send E-mail &rsaquo;" name="submit" />
</form>
<br/><br/>
</div><!-- close #contact-wrapper -->