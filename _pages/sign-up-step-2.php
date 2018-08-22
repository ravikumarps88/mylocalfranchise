<?
if($_REQUEST['signup2'])	{
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	
	//adding to customer table	
	$dbFields = array();
	
	$dbFields['address1'] 		= $address1;
	$dbFields['address2'] 		= $address2;

	$dbFields['town'] 			= $city;
	
	$dbFields['phone'] 			= $phone;
	$dbFields['postcode'] 		= $postcode;
	
	$dbFields['liquid_capital']		= $liquid_capital;
	$dbFields['timeframe'] 			= $timeframe;
	$dbFields['preferred_location'] = $preferred_location;
	
	$specialFields = array();
	$dbFields['updated_on'] 		= 'now()';
	$specialFields = array('updated_on');	
	$cond	= " id='{$_REQUEST['new_id']}'";		
		
	dbPerform("customers", $dbFields, $specialFields,$cond);
	header("Location:".APP_URL."/search.html");	
}
elseif(empty($_REQUEST['new_id']))
	header("Location:".APP_URL);
//========================================================================================================================
//========================================================================================================================
?>

<div class="col align-self-center hidden-md-down">
    <div class="display-1 text-white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
    <div class="display-3 text-white">Sign Up</div>
    <p class="lead text-white">Sign in to your account to personalise your expericence.</p>
</div><!-- .col .col-md-5 -->
<div class="col col-lg-auto align-self-center">
    <div class="form-box">
        <h1><i class="fa fa-unlock-alt" aria-hidden="true"></i> Additional Details</h1>
        <p>Complete these details to save time when sending enquiries or <a href="search.html?signup=new">Skip this step</a>.</p>
        <form action="" method="post">
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="form-group">
                        <label>Address line 1:</label>
                        <input type="text" name="address1" value="<?=$_REQUEST['address1']?>" required>
                        <p class="help-block text-danger"></p>
                    </div><!-- .form-group -->
                </div><!-- .col-12 .col-xl-6 -->
                </div><!-- .row -->
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="form-group">
                            <label>Address line 2:</label>
                            <input type="text" name="address2" value="<?=$_REQUEST['address2']?>">
                    </div><!-- .form-group -->
                </div><!-- .col-12 .col-xl-6 -->
            </div><!-- .row -->
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="form-group">
                        <label>City:</label>
                        <input type="text" name="city" value="<?=$_REQUEST['city']?>" required>
                        <p class="help-block text-danger"></p>
                    </div><!-- .form-group -->
                </div><!-- .col-12 .col-xl-6 -->
                <div class="col-12 col-xl-6">
                    <div class="form-group">
                        <label>Postcode:</label>
                        <input type="text" name="postcode" value="<?=$_REQUEST['postcode']?>" required>
                        <p class="help-block text-danger"></p>
                    </div><!-- .form-group -->
                </div><!-- .col-12 .col-xl-6 -->
            </div><!-- .row -->
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="form-group">
                        <label>Phone Number:</label>
                        <input type="tel" name="phone" value="<?=$_REQUEST['phone']?>" required>
                        <p class="help-block text-danger"></p>
                    </div><!-- .form-group -->
                </div><!-- .col-12 .col-xl-6 -->
            </div><!-- .row -->
            <hr>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="form-group">
                        <label>Available Liquid Capital:</label>
                        <input type="text" name="liquid_capital" value="<?=$_REQUEST['liquid_capital']?>">
                    </div><!-- .form-group -->
                </div><!-- .col-12 .col-xl-6 -->
            </div><!-- .row -->
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="form-group">
                        <label>Timeframe to Buy:</label>
                        <input type="text" name="timeframe" value="<?=$_REQUEST['timeframe']?>">
                    </div><!-- .form-group -->
                </div><!-- .col-12 .col-xl-6 -->
            </div><!-- .row -->
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="form-group">
                        <label>Preferred Location:</label>
                        <input type="text" name="preferred_location" value="<?=$_REQUEST['preferred_location']?>">
                        <p class="help-block text-danger"></p>
                    </div><!-- .form-group -->
                </div><!-- .col-12 .col-xl-6 -->
            </div><!-- .row -->
            <div class="form-buttons">
                <button class="btn btn-primary" name="signup2" value="signup2" type="submit">Submit</button>
            </div><!-- .row .form-buttons -->
        </form>
        <p class="skip-link"><a href="search.html?signup=new">Skip this step</a></p>
    </div><!-- .form-box -->
</div><!-- .col-md-5 -->