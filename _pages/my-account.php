<?
if(!$_SESSION[AUTH_PREFIX.'AUTH'])
	header('Location:'.APP_URL);

//update user account details
if($_REQUEST['signup'] == 'submit_profile')	{

	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	if(customerEmailExist($email, $_SESSION['USER_PROFILE']['id']) == 0)	{

		$password	= $_REQUEST['password'];

		//adding to customer table
		$dbFields = array();
		$dbFields['title'] 			= $title;
		$dbFields['firstname'] 		= $firstname;
		$dbFields['lastname'] 		= $lastname;
		$dbFields['email'] 			= $email;
		if($password != '')
			$dbFields['password'] 		= md5($password);

		$dbFields['address1'] 		= $address1;
		$dbFields['address2'] 		= $address2;

		$dbFields['town'] 			= $city;
		$dbFields['county'] 		= $county;
		$dbFields['country'] 			= $country;
		$dbFields['phone'] 			= $phone;
		$dbFields['postcode'] 		= $postcode;

		$dbFields['liquid_capital']		= $liquid_capital;
		$dbFields['timeframe'] 			= $timeframe;
		$dbFields['method_contact'] 	= $method_contact;
		$dbFields['preferred_location'] = $preferred_location;


		$specialFields = array();
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');

		$cond	= "id='{$_SESSION['USER_PROFILE']['id']}'";

		if(dbPerform("customers", $dbFields, $specialFields,$cond))	{
			$msg	= "Your details have been successfully updated.";
		}


	}
	else
		$msg	= "Email already exists.";
}

$profile	= getCustomerDetails($_SESSION['USER_PROFILE']['id']);
list($year, $month, $day)	= explode('-',$profile['dob']);

if($_REQUEST['signup'] == 'new')
	$msg	= '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></button>Your account has been created, you will receive an email confirmation shortly.</div>';

?>
<h5><?=$msg?></h5>
<section class="centered-form-section">
    <div style="padding: 60px 0;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form-box">
                    <form class="user-profile" action="" method="post">
                        <div class="row align-items-center">
                            <div class="col-12 text-center">
                                <h1>User Profile</h1>
                                <p>Personal Details</p>
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Title :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable title"><?=$profile['title']?></span>
                                <select class="editable title" style="display:none !important" name="title">
                                    <option value="" disabled selected>Select...</option>
                                    <option value="Mr" <?=$profile['title'] == 'Mr' ? 'selected="selected"' : ''?>>Mr</option>
                                    <option value="Miss" <?=$profile['title'] == 'Miss' ? 'selected="selected"' : ''?>>Miss</option>
                                    <option value="Mrs" <?=$profile['title'] == 'Mrs' ? 'selected="selected"' : ''?>>Mrs</option>
                                    <option value="Ms" <?=$profile['title'] == 'Ms' ? 'selected="selected"' : ''?>>Ms</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>First Name :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable first-name" id="firstName"><?=$profile['firstname']?></span>
                                <input class="editable first-name" id="firstName" name="firstname" value="<?=$profile['firstname']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Last Name :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable last-name"><?=$profile['lastname']?></span>
                                <input class="editable last-name" name="lastname" value="<?=$profile['lastname']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Email :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable email"><?=$profile['email']?></span>
                                <input class="editable email" name="email" value="<?=$profile['email']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Contact Number :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable additional-number"><?=$profile['phone']?></span>
                                <input class="editable additional-number" name="phone" value="<?=$profile['phone']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Preferred Method of Contact :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable preferred-method-of-contact"><?=$profile['method_contact']?></span>
                                <select class="editable preferred-method-of-contact" style="display:none" name="method_contact">
                                    <option value="" disabled selected>Select...</option>
                                    <option value="Email" <?=$profile['method_contact'] == 'Email' ? 'selected="selected"' : ''?>>Email</option>
                                    <option value="Phone" <?=$profile['method_contact'] == 'Phone' ? 'selected="selected"' : ''?>>Phone</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-1st" class="editable" style="display:none">
                                <label class="email">Confirm Email Address :</label>
                            </div>
                            <div class="col-12 col-md-6" class="editable" style="display:none">
                                <input class="email" type="text" name="email_confirm" data-validate="equalTo[email]" />
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Password :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable password">**********</span>
                                <input class="editable password" name="password" type="password" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st" class="editable" style="display:none">
                                <label class="password">Confirm New Password :</label>
                            </div>
                            <div class="col-12 col-md-6 " class="editable" style="display:none">
                                <input class="password" type="password" name="confirm_password">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Address line 1 :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable address-line-1"><?=$profile['address1']?></span>
                                <input class="editable address-line-1" name="address1" value="<?=$profile['address1']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Address line 2 :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable address-line-2"><?=$profile['address2']?></span>
                                <input class="editable address-line-2" name="address2" value="<?=$profile['address2']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>City :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable city"><?=$profile['town']?></span>
                                <input class="editable city" name="city" value="<?=$profile['town']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Region :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable region"><?=$profile['county']?></span>
                                <input class="editable region" name="county" value="<?=$profile['county']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Country :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable country"><?=$profile['country']?></span>
                                <input class="editable country" name="country" value="<?=$profile['country']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Post Code :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable post-code"><?=$profile['postcode']?></span>
                                <input class="editable post-code" name="postcode" value="<?=$profile['postcode']?>" type="text" style="display:none">
                            </div>
                            <div class="col-12">
                                <h3 class="text-center">Additional Details</h3>
                            </div>

                            <div class="col-12 col-md-6 col-1st">
                                <label>Preferred Location :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable preferred-location"><?=$profile['preferred_location']?></span>
                                <input class="editable preferred-location" name="preferred_location" value="<?=$profile['preferred_location']?>" type="text" style="display:none">
                            </div>

                            <div class="col-12 col-md-6 col-1st">
                                <label>Avalible Liquid Capital :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable avalible-liquid-capital"><?=$liquid_capitalArr[$profile['liquid_capital']]?></span>
                                <select class="editable avalible-liquid-capital" style="display:none" name="liquid_capital">
                                    <option value="0" <?=$profile['liquid_capital'] == '0' ? 'selected="selected"' : ''?>>Not specified</option>
                                    <option value="15" <?=$profile['liquid_capital'] == '15' ? 'selected="selected"' : ''?>>Less than &pound;15,000</option>
                                    <option value="15-30" <?=$profile['liquid_capital'] == '15-30' ? 'selected="selected"' : ''?>>&pound;15,000 to &pound;30,000</option>
                                    <option value="30-40" <?=$profile['liquid_capital'] == '30-40' ? 'selected="selected"' : ''?>>&pound;30,000 to &pound;40,000</option>
                                    <option value="40-50" <?=$profile['liquid_capital'] == '40-50' ? 'selected="selected"' : ''?> <?=$profile['liquid_capital'] == '0' ? 'selected="selected"' : ''?>>&pound;40,000 to &pound;50,000</option>
                                    <option value="50-100" <?=$profile['liquid_capital'] == '50-100' ? 'selected="selected"' : ''?>>&pound;500,000 to &pound;100,000</option>
                                    <option value="100-150" <?=$profile['liquid_capital'] == '100-150' ? 'selected="selected"' : ''?>>&pound;100,000 to &pound;150,000</option>
                                    <option value="150-250" <?=$profile['liquid_capital'] == '150-250' ? 'selected="selected"' : ''?>>&pound;150,000 to &pound;250,000</option>
                                    <option value="250-500" <?=$profile['liquid_capital'] == '250-500' ? 'selected="selected"' : ''?>>&pound;250,000 to &pound;500,000</option>
                                    <option value="500-1000" <?=$profile['liquid_capital'] == '500-1000' ? 'selected="selected"' : ''?>>&pound;500,000 to &pound;1,000,000</option>
                                    <option value="1000" <?=$profile['liquid_capital'] == '1000' ? 'selected="selected"' : ''?>>More than &pound;1,000,000</option>
                                </select>

                            </div>
                            <div class="col-12 col-md-6 col-1st">
                                <label>Timeframe To Buy :</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="editable timeframe-to-buy"><?=$profile['timeframe']?></span>
                                <select class="editable timeframe-to-buy" name="timeframe" id="timeframe" style="display:none">
                                    <option value="No preference" <?=$profile['timeframe'] == 'No preference' ? 'selected="selected"' : ''?>>No preference</option>
                                    <option value="Within 3 Months" <?=$profile['timeframe'] == 'Within 3 Months' ? 'selected="selected"' : ''?>>Within 3 Months</option>
                                    <option value="Within 6 Months" <?=$profile['timeframe'] == 'Within 6 Months' ? 'selected="selected"' : ''?>>Within 6 Months</option>
                                    <option value="Within 12 Months" <?=$profile['timeframe'] == 'Within 12 Months' ? 'selected="selected"' : ''?>>Within 12 Months</option>
                                    <option value="Just Making an enquiry" <?=$profile['timeframe'] == 'Just Making an enquiry' ? 'selected="selected"' : ''?>>Just Making an enquiry</option>
                                </select>

                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-primary profile-btn" type="submit" name="signup" value="submit_profile">Edit</button>
                            </div><!-- .col-12-->
                        </div><!-- .row -->
                    </form>
                </div><!-- .form-box -->
            </div><!-- .col-md-5 -->
        </div><!-- .row -->
    </div><!-- .container -->
</section><!-- .centered-form-section -->
