<?
$_REQUEST['id']	= dbQuery("SELECT id FROM franchises WHERE vendor_code='{$_SESSION['code']}' AND status='active'", 'singlecolumn');
$vendor		= getVendorDetails($_REQUEST['id']);

$franchise_testimonials	= dbQuery("SELECT * FROM testimonials WHERE franchise_id='{$_REQUEST['id']}' AND status='active'");
$franchise_news			= dbQuery("SELECT * FROM news WHERE franchise_id='{$_REQUEST['id']}' AND status='active'");


if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
	$_SESSION['tmp_profile_id'] = empty($_SESSION['tmp_profile_id'])  ? rand(1000, 99999) :  $_SESSION['tmp_profile_id'];
}
else
	$profile	= getCustomerDetails($_SESSION['USER_PROFILE']['id']);

//update the hit for the voucher
dbQuery("UPDATE franchises SET profile_views=profile_views+1 WHERE id='{$_REQUEST['id']}'");
//ends

//adding to vouchers views & clicks
$dbFields = array();
$dbFields['type'] 			= 'profile_view';
$dbFields['franchise_id'] 	= $_REQUEST['id'];
if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
	$dbFields['customer_id'] 	= $_SESSION['tmp_profile_id'];
}
else
	$dbFields['customer_id'] 	= $_SESSION['USER_PROFILE']['id'];

$specialFields = array();
$dbFields['inserted_on'] 		= 'now()';

$specialFields = array('inserted_on');
dbPerform("franchise_views", $dbFields, $specialFields);
//ends

?>

<section class="franchise-profile-section">
    <div class="franchise-profile-section__inner">
        <div class="franchise-profile-top">
            <div class="franchise-intro">
                <h1><?=no_magic_quotes($vendor['vendor'])?>&nbspFranchise</h1>
                <h2><?=no_magic_quotes(getFieldValue($vendor['category_id'], 'category', 'franchise_categories'))?> Franchise</h2>
                <p><?=no_magic_quotes($vendor['description'])?></p>
                <div class="row">
                	<?
					if($vendor['break_even_show'] == 'yes')	{
					?>
                        <div class="col-12 col-xl-6">
                            <p><i class="fa fa-check"></i> <strong>Break even in:</strong> <?=no_magic_quotes($vendor['break_even_time'])?></p>
                        </div>
                    <?
					}
					if($vendor['established_show'] == 'yes')	{
					?>
                        <div class="col-12 col-xl-6">
                            <p><i class="fa fa-check"></i> <strong>Established:</strong> <?=no_magic_quotes($vendor['established'])?></p>
                        </div>
                    <?
					}
					if($vendor['min_invest_show'] == 'yes')	{
					?>
                        <div class="col-12 col-xl-6">
                            <p><i class="fa fa-check"></i> <strong>Min Investment:</strong> &pound;<?=number_format($vendor['min_investment'])?></p>
                        </div>
                    <?
					}
					if($vendor['franchise_no_show'] == 'yes')	{
					?>
                        <div class="col-12 col-xl-6">
                            <p><i class="fa fa-check"></i> <strong>No. Of Franchisees:</strong> <?=no_magic_quotes($vendor['franchise_no'])?></p>
                        </div>
                    <?
					}
					?>
                </div><!-- .row -->
            </div><!-- .franchise-intro -->
            <div class="franchise-logo">
            	<?php if($vendor['logo'] == '') { ?>
                <a href="<?=$vendor['vendor_code']?>"><img src="upload/vendors/thumbnail/No-Logo-Image.jpg" alt="<?=no_magic_quotes($vendor['vendor'])?>" title="<?=no_magic_quotes($vendor['vendor'])?>" style="max-height:200px; max-width:200px;" /></a>
                <?php } else { ?>
                <a href="<?=$vendor['vendor_code']?>"><img src="upload/vendors/thumbnail/<?=$vendor['logo']?>" alt="<?=no_magic_quotes($vendor['vendor'])?>" title="<?=no_magic_quotes($vendor['vendor'])?>" style="max-height:200px; max-width:200px;" /></a>
                <?php } ?>

                <a class="print-profile" href="javascript:window.print();"><i class="fa fa-print"></i> Print</a>
            </div><!-- .franchise-logo -->
        </div><!-- .franchise-profile-top -->
        <div class="row buttons-wrap">
            <div class="col-12 col-xl-4">
                <a href="javascript:void(0);" class="btn btn-block btn-primary contact_focus">Request Free Information</a>
            </div>
            <div class="col-12 col-xl-4">
                <a href="javascript:void(0);" class="btn btn-block btn-secondary <?=customerRequestExist($_REQUEST['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'add_request_list_button' : 'remove_request_list_button' ?>" id="add_remove_button" val="<?=$_REQUEST['id']?>"><?=customerRequestExist($_REQUEST['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'Add to Request List' : 'Remove' ?></a>
            </div>

            <?
			if($vendor['video'] != '')	{
            ?>
                <div class="col-12 col-xl-4">
                    <button class="btn btn-block btn-secondary" data-toggle="modal" data-target="#videoModal"><i class="fa fa-play"></i> Watch Video</button>
                </div>
			<?
			}
			?>

        </div><!-- .row .buttons-wrap -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Profile" role="tab">Profile</a></li>

            <?
			if($vendor['is_testimonial'] == 'yes')	{
			?>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Testimonials" role="tab">Testimonials</a></li>
            <?
			}
			if($vendor['is_news'] == 'yes')	{
			?>
            	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#News" role="tab">News</a></li>
            <?
			}
			?>

            <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#CaseStudies" role="tab">Case Studies</a></li>-->

        </ul><!-- .nav .nav-tabs -->
        <div class="tab-content">
            <div class="tab-pane active" id="Profile" role="tabpanel">
                <p><?=no_magic_quotes($vendor['profile'])?></p>
            </div>

            <?
			if($vendor['is_testimonial'] == 'yes')	{
			?>
                <div class="tab-pane" id="Testimonials" role="tabpanel">
                    <?
                        foreach($franchise_testimonials as $val)	{
                    ?>
                        <blockquote>
    <p><?=$val['testimonial']?></p>
    <footer><?=no_magic_quotes($val['name'])?></footer>
    </blockquote>

                    <?
                    }
                    ?>
                </div>
            <?
			}
			?>


            <?
			if($vendor['is_news'] == 'yes')	{
			?>
                <div class="tab-pane" id="News" role="tabpanel">
                    <?
						foreach($franchise_news as $val)	{
					?>
						<p><?=no_magic_quotes($val['title'])?> - <?=$val['news']?></p>
					<?
					}
					?>
                </div>
            <?
			}
            ?>
            <!--<div class="tab-pane" id="CaseStudies" role="tabpanel">
                Case Studies
            </div>-->

        </div><!-- .tab-content -->
        <div class="contact-form" id="contactForm">
            <form method="post" action="submit.php" name="sentMessage" id="contactForm2" novalidate >
                <input type="hidden" name="franchise_id" id="franchise_id" value="<?=$_REQUEST['id']?>"  />
                <div class="row">
                    <div class="col-12">
                        <h4><strong>Would you like to start a <?=no_magic_quotes($vendor['vendor'])?> franchise?</strong></h4>
                        <p>To get in contact with <?=no_magic_quotes($vendor['vendor'])?> regarding their franchise opportunity, please complete the form below.</p>
                    </div><!-- .col-12 -->
                </div><!-- .row -->
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
                            <input type="text" name="city" id="city" value="<?=$profile['town']?>" />
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
                            <label style="display: none;">
                                <input type="checkbox" checked id="create_account" name="create_account">
                                <strong>Yes</strong> create an account to remember my details the next time I want to contact a franchisor.
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked id="newsletter" name="newsletter">
                                I wish to receive updates and promotions from Franchise Local via email.
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
        </div><!-- .contact-form -->
    </div><!-- .franchise-profile-section__inner -->
</section><!-- .franchise-profile-section -->

<div class="modal fade" id="videoModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?=no_magic_quotes($vendor['vendor'])?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div><!-- .modal-header -->
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <?=no_magic_quotes($vendor['video'])?>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
              <div class="row">
                  <div class="col-12 col-xl-6">
                      <button type="button" class="btn btn-block btn-primary contact_focus" data-dismiss="modal">Send Me Information</button>
                  </div>
                  <div class="col-12 col-xl-6">
                  	<a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary <?=customerRequestExist($_REQUEST['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'add_request_list_button' : 'remove_request_list_button' ?>" id="add_remove_button2" val="<?=$_REQUEST['id']?>"> <?=customerRequestExist($_REQUEST['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'Add to Request List' : 'Remove' ?></a>

                  </div>
              </div><!-- .row -->
            </div><!-- .modal-footer -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal .fade -->

<div class="fp-sticky-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-4 hidden-xs-down">
                <p class="franchise-name"><?=no_magic_quotes($vendor['vendor'])?> - <?=no_magic_quotes(getFieldValue($vendor['category_id'], 'category', 'franchise_categories'))?> Franchise</p>
            </div>
            <div class="col-sm-5 text-center">

            </div>
            <div class="col-sm-3 text-right">
                <a href="javascript:void(0);" class="btn btn-sm btn-primary contact_focus d-block">Request Free Information</a>
            </div>
        </div>
    </div>
</div>
