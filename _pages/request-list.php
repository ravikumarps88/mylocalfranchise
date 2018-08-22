<?
if(!$_SESSION[AUTH_PREFIX.'AUTH'])
	$customer_id	= $_SESSION['tmp_profile_id'];
else
	$customer_id	= $_SESSION['USER_PROFILE']['id'];
$request_list	= dbQuery("SELECT * FROM customers_request WHERE customers_id='$customer_id'");

$profile	= getCustomerDetails($_SESSION['USER_PROFILE']['id']);

$vendors	= getVendorsListFiltered('',1,'','','','','featured3');
foreach($vendors as $val)	{
	if($val['logo'] == '')	{
		$thumb_image	= "No-Logo-Image.jpg";
	}
	else	{
		$thumb_image	= $val['logo'];
	}
?>

<div class="search-hero-section hidden-xs-down">
    <div class="container">
        <div class="row align-items-center">
            <div class="col results-info">
                <h2>Your franchise request list</h2>
                <p>Complete the form below to contact all these franchises at once.</p>
            </div><!-- .col -->
            <div class="col promoted-franchise">
                <div class="promoted-franchise__inner">
                    <div class="franchise-logo">
                        <a href="<?=$val['vendor_code']?>"><img src="upload/vendors/original/<?=$thumb_image?>" alt="<?=$val['vendor']?>" style=" max-height:65px;max-width:65px;"></a>
                    </div><!-- .franchise-logo -->
                    <div class="franchise-name">
                        <h5>
                            <a href="<?=$val['vendor_code']?>"><?=no_magic_quotes($val['vendor'])?></a>
                            <a href="<?=$val['vendor_code']?>" class="industry"><?=getFieldValue($val['category_id'], 'category', 'franchise_categories')?> Franchise </a>
                            <a href="<?=$val['vendor_code']?>" class="more-info">More info <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </h5>
                    </div><!-- .franchise-name -->
                    <span class="promoted-badge">promoted</span>
                </div><!-- .promoted-franchise -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .search-hero-section -->
<?
}
?>

<div class="container">
    <section class="franchise-list-section">
        <div class="row">
        	<?
			foreach($request_list as $val)	{
				$vendor		= getVendorDetails($val['franchise_id']);
			?>
            <div class="col-12 col-lg-6 col-xl-3">

                <div class="franchise-box">
                    <figure>
                        <?
						if($vendor['logo'] == '')	{
						?>
							<img src="upload/vendors/thumbnail/No-Logo-Image.jpg" alt="<?=no_magic_quotes($vendor['vendor'])?>" title="<?=no_magic_quotes($vendor['vendor'])?>">
						<?
						}
						else	{
						?>
							<img src="upload/vendors/thumbnail/<?=$vendor['logo']?>" alt="<?=no_magic_quotes($vendor['vendor'])?>" title="<?=no_magic_quotes($vendor['vendor'])?>">
						<?
						}
						?>
                    </figure>
   <!--                 <div class="franchise-info">
                        <div class="name"><?=no_magic_quotes($vendor['vendor'])?></div>
                        <div class="description"><?=substr(no_magic_quotes($vendor['description']),0,100)?> ...</div>
                        <div class="investment"><strong>Min. Investment:</strong> &pound;<?=number_format($vendor['min_investment'])?></div>
                    </div>

                    <footer>
                        <div class="controls">
                            <a href="<?=$vendor['vendor_code']?>#contactForm" rel="nofollow"><i class="fa fa-envelope" aria-hidden="true"></i></a>

                        </div>
                        <a href="<?=$vendor['vendor_code']?>" class="more-link">find out more</a>
                    </footer>
-->
                </div><!-- .franchise-box -->
            </div><!-- .col -->
            <?
			}
			?>
        </div>
    </section>
</div>
<section class="centered-form-section">
    <div class="container">
        <div class="row justify-content-center" style="padding-top: 0;">
            <div class="col-12">
                <div class="form-box">
                    <h1>Contact these Franchises</h1>
                    <p>Complete the form below and your details will be sent to all of the franchise opportunities listed above.</p>
                    <form method="post" action="submit.php" name="sentMessage" id="contactForm2" novalidate >
            			<input type="hidden" name="franchise_id" id="franchise_id" value="<?=$_REQUEST['id']?>"  />
                        <div class="row">
                          <div class="co-12 col-xl-4">
                                <div class="form-group">
                                    <label>Title</label>
                                    <select class="required" name="title" id="title">
										<?=htmlOptions($titleArr,$profile['title'])?>
                                    </select>
                                </div><!-- .form-group -->
                            </div><!-- .co-12 .col-xl-4 -->
                            <div class="co-12 col-xl-4">
                                <div class="form-group">
                                    <label>First Name*</label>
                                    <input type="text" class="required" id="firstname" name="firstname" value="<?=$profile['firstname']?>" data-validation-required-message="Please enter your First Name." />
                                    <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                            </div><!-- .co-12 .col-xl-4 -->
                            <div class="co-12 col-xl-4">
                                <div class="form-group">
                                    <label>Last Name*</label>
                                    <input type="text" class="required" name="lastname" id="lastname" value="<?=$profile['lastname']?>" data-validation-required-message="Please enter your Last Name." />
                                    <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                            </div><!-- .co-12 .col-xl-4 -->
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-12 col-xl-6">
                                <div class="form-group">
                                    <label>Your Email Address*</label>
                                    <input type="email" class="required" id="email" name="email" value="<?=$profile['email']?>" data-validation-required-message="Please enter your Email." />
                                    <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                            </div><!-- .col-12 .col-xl-6 -->
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-12 col-xl-6">
                                <div class="form-group">
                                    <label>Contact Number*</label>
                                    <input type="tel" class="required" name="phone" id="phone" value="<?=$profile['phone']?>" data-validation-required-message="Please enter contact number.">
                                    <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                            </div><!-- .col-12 .col-xl-6 -->
                            <div class="co-12 col-xl-4">
                                  <div class="form-group">
                                      <label>Best Time to call</label>
                                      <select name="best_time" id="best_time">
                                          <option value="No Preference" <?=$profile['best_time'] == 'No Preference' ? 'selected="selected"' : ''?> > No Preference</option>
                                          <option value="Morning" <?=$profile['best_time'] == 'Morning' ? 'selected="selected"' : ''?>>Morning</option>
                                          <option value="Afternoon" <?=$profile['best_time'] == 'Afternoon' ? 'selected="selected"' : ''?>>Afternoon</option>
                                          <option value="Evening" <?=$profile['best_time'] == 'Evening' ? 'selected="selected"' : ''?>>Evening</option>
                                      </select>
                                  </div><!-- .form-group -->
                              </div><!-- .co-12 .col-xl-4 -->
                        </div><!-- .row -->
                        <hr>
                        <div class="row">
                            <div class="col-12 col-xl-6">
                                <div class="form-group">
                                    <label>Address line 1</label>
                                    <input type="text" name="address1" id="address1" value="<?=$profile['address1']?>" />
                                    <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                            </div><!-- .col-12 .col-xl-6 -->
                            <div class="col-12 col-xl-6">
                                <div class="form-group">
                                    <label>Address line 2</label>
                                    <input type="text" name="address2" id="address2" value="<?=$profile['address2']?>" />
                                </div><!-- .form-group -->
                            </div><!-- .col-12 .col-xl-6 -->
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-12 col-xl-5">
                                <div class="form-group">
                                    <label>Town</label>
                                    <input type="text" name="city" id="city" value="<?=$profile['town']?>"/>
                                    <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                            </div><!-- .col-12 .col-xl-6 -->
                            <div class="col-12 col-xl-4">
                                <div class="form-group">
                                    <label>County</label>
                                    <input type="text" name="county" id="county" value="<?=$profile['county']?>">
                                    <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                            </div><!-- .col-12 .col-xl-6 -->
                            <div class="col-12 col-xl-3">
                                <div class="form-group">
                                    <label>Postcode*</label>
                                    <input type="text" class="required" name="postcode" id="postcode" value="<?=$profile['postcode']?>" data-validation-required-message="Please enter your postcode." />
                                    <p class="help-block text-danger"></p>
                                </div><!-- .form-group -->
                            </div><!-- .col-12 .col-xl-6 -->
                        </div><!-- .row -->
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="additional-info-link" data-toggle="collapse" data-target="#additionalInfo">Additional Information <i class="fa fa-plus" aria-hidden="true"></i></h5>
                            </div><!-- .col-12 -->
                        </div><!-- .row -->

                        <div class="collapse" id="additionalInfo">
                          <p>&nbsp;</p>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Available Liquid Capital</label>
                                        <select name="liquid_capital" id="liquid_capital">
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
                                    </div><!-- .form-group -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Timeframe to Buy</label>
                                        <select name="timeframe" id="timeframe">
                                            <option value="No preference" <?=$profile['timeframe'] == 'No preference' ? 'selected="selected"' : ''?>>No preference</option>
                                            <option value="Within 3 Months" <?=$profile['timeframe'] == 'Within 3 Months' ? 'selected="selected"' : ''?>>Within 3 Months</option>
                                            <option value="Within 6 Months" <?=$profile['timeframe'] == 'Within 6 Months' ? 'selected="selected"' : ''?>>Within 6 Months</option>
                                            <option value="Within 12 Months" <?=$profile['timeframe'] == 'Within 12 Months' ? 'selected="selected"' : ''?>>Within 12 Months</option>
                                            <option value="Just Making an enquiry" <?=$profile['timeframe'] == 'Just Making an enquiry' ? 'selected="selected"' : ''?>>Just Making an enquiry</option>
                                        </select>
                                    </div><!-- .form-group -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Preferred Method of Contact</label>
                                        <select name="method_contact" id="method_contact">
                                            <option value="No preference" <?=$profile['best_time'] == 'No preference' ? 'selected="selected"' : ''?>>No preference</option>
                                            <option value="Phone" <?=$profile['method_contact'] == 'Phone' ? 'selected="selected"' : ''?>>Phone</option>
                                            <option value="Email" <?=$profile['method_contact'] == 'Email' ? 'selected="selected"' : ''?>>Email</option>
                                        </select>
                                    </div><!-- .form-group -->
                                </div><!-- .col-12 -->
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Preferred Location</label>
                                        <input type="text" name="preferred_location" id="preferred_location" value="<?=$profile['preferred_location']?>">
                                        <p class="help-block text-danger"></p>
                                    </div><!-- .form-group -->
                                </div><!-- .col-12 -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <h3>Message</h3>
                                </div><!-- .col-12 -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea cols="30" rows="7" placeholder="Message" name="contact-message" id="contact-message" ></textarea> <!-- required data-validation-required-message="Please enter your message." -->
                                        <p class="help-block text-danger"></p>
                                    </div><!-- .form-group -->
                                </div><!-- .col-12 -->
                            </div><!-- .row -->
                        </div><!-- .collapse -->
                        <hr>
                        <div class="row">
                            <div class="col-12">
                            	<?
								if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
								?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked id="create_account" name="create_account">
                                        <strong>Yes</strong> create an account to remember my details the next time I want to contact a franchisor.
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked id="newsletter" name="newsletter">
                                        <strong>Yes</strong> I wish to receive the franchise newsletters and other emails directly from Franchise Local.
                                    </label>
                                </div>
                                <?
								}
								?>
                                <p><small>By sending this message, you confirm that you agree to our <a href="terms-and-conditions.html" target="_blank">Terms & Conditions</a> and <a href="our-privacy-policy.html" target="_blank">Privacy Policy</a>.</small></p>
                                <button class="btn btn-primary" id="lead_submit" type="submit"><strong>Submit Information</strong></button>
                                <div id="success"></div>
                            </div><!-- .col-12 -->
                        </div><!-- .row -->
                    </form>
                </div><!-- .form-box -->
            </div><!-- .col-md-5 -->
        </div><!-- .row -->
    </div><!-- .container -->
</section><!-- .centered-form-section -->
