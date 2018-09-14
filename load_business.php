<?
require "lib/app_top.php";
$search		= getSearch($_REQUEST['keyword'], $_REQUEST['category_id'], $_REQUEST['price_range'],'','',$_REQUEST['lifestyle'],$_REQUEST['filter'],$_REQUEST['start'],$_REQUEST['blog_per_page'],$_REQUEST['featured'],$_REQUEST['letter'],$_REQUEST['sponsored_categ_id'],$_REQUEST['sponsored_non_categ_id']);

//End shuffle section: Section to shuffle featured search results in each refresh

$search_start_copy = array();
$search_start_copy = $search;
$featuredArray = array();
foreach($search_start_copy as $skey => $sVal) {
    if($sVal['featured'] == 'yes') {
        $featuredArray[] = $sVal;
        unset($search_start_copy[$skey]);
    }
}
shuffle($featuredArray);
foreach($featuredArray as $fData) {
    array_unshift($search_start_copy, $fData);
}
$search = $search_start_copy;

//End shuffle section

if($_SESSION['industries'] != '')	{
?>
		<div class="col-12"><div class="no-results">  
	        <h2><?=no_magic_quotes( getFieldValue($_REQUEST['category_id'], 'category','franchise_categories'))?> Franchise</h2>   
            <p><?=getFieldValue($_REQUEST['category_id'], 'description','franchise_categories')?></p>
        </div></div>		
<?
	$vendors	= getVendorsListFiltered('',1,'featured','',$_REQUEST['category_id']);
	foreach($vendors as $val)	{
?>
        <div class="col-12">
            <div class="featured-franchise">
                <div class="franchise-logo">
                    <?
                    if($val['logo'] == '')	{
                    ?>
                        <img src="upload/vendors/thumbnail/No-Logo-Image.jpg" alt="<?=no_magic_quotes($val['vendor'])?>" title="<?=no_magic_quotes($val['vendor'])?>">
                    <?
                    }
                    else	{
                    ?>
                        <img src="upload/vendors/thumbnail/<?=$val['logo']?>" alt="<?=no_magic_quotes($val['vendor'])?>" title="<?=no_magic_quotes($val['vendor'])?>">
                    <?
                    }
                    ?>
                </div><!-- .franchise-logo -->
                <div class="franchise-details">
                    <h2><?=no_magic_quotes($val['vendor'])?></h2>
                    <h3><?=no_magic_quotes(getFieldValue($val['category_id'], 'category', 'franchise_categories'))?> Franchise</h3>
                    <p><?=substr(no_magic_quotes($val['description']),0,85)?> ...</p>
                    <p><strong>Min Investment:</strong> &pound;<?=number_format($val['min_investment'])?></p>
                    <div class="row button-wrap">
                        <div class="col-12 col-md-6">
                            <a href="<?=$val['vendor_code']?>" class="btn btn-block btn-primary">Find Out More</a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="javascript:void(0);" id="<?=$val['id']?>" class="btn btn-block btn-secondary add_request_list">Add to Request List</a>
                        </div>
                    </div><!-- .button-wrap -->
                </div><!-- .franchise-details -->
            </div><!-- .featured-franchise -->
        </div><!-- .col-12 -->
<?
	}
}

elseif($_REQUEST['lifestyle'] != '')	{ 

    $_REQUEST['lifestyle_id']	= dbQuery("SELECT id FROM franchise_lifestyle WHERE url_title LIKE '%{$_SESSION['lifestyle']}%' AND status='active'", 'singlecolumn');
    
?>

    <div class="col-12">
        <div class="no-results">  
            <h1 style="font-size: 33px;"><?= no_magic_quotes(getFieldValue($_REQUEST['lifestyle_id'], 'lifestyle_title', 'franchise_lifestyle')) ?></h1>   
            <p><?= getFieldValue($_REQUEST['lifestyle_id'], 'description', 'franchise_lifestyle') ?></p>
        </div>
    </div>

    <?
	$vendors	= getVendorsListFiltered('',1,'','','','','','','','',$_REQUEST['lifestyle']);
	foreach($vendors as $val)	{
    ?>
            <div class="col-12">
                <div class="featured-franchise">
                    <div class="franchise-logo">
                        <?
                        if($val['logo'] == '')	{
                        ?>
                        <img src="upload/vendors/thumbnail/No-Logo-Image.jpg" alt="<?= no_magic_quotes($val['vendor']) ?>" title="<?= no_magic_quotes($val['vendor']) ?>">
                        <?
                        }
                        else	{
                        ?>
                        <img src="upload/vendors/thumbnail/<?= $val['logo'] ?>" alt="<?= no_magic_quotes($val['vendor']) ?>" title="<?= no_magic_quotes($val['vendor']) ?>">
                        <?
                        }
                        ?>
                    </div><!-- .franchise-logo -->
                    <div class="franchise-details">
                        <h2><?= no_magic_quotes($val['vendor']) ?></h2>
                        <h3><?= no_magic_quotes(getFieldValue($val['category_id'], 'category', 'franchise_categories')) ?> Franchise</h3>
                        <p><?= substr(no_magic_quotes($val['description']), 0, 85) ?> ...</p>
                        <p><strong>Min Investment:</strong> &pound;<?= number_format($val['min_investment']) ?></p>
                        <div class="row button-wrap">
                            <div class="col-12 col-md-6">
                                <a href="<?= $val['vendor_code'] ?>" class="btn btn-block btn-primary">Find Out More</a>
                            </div>
                            <div class="col-12 col-md-6">
                                <a href="javascript:void(0);" id="<?= $val['id'] ?>" class="btn btn-block btn-secondary add_request_list">Add to Request List</a>
                            </div>
                        </div><!-- .button-wrap -->
                    </div><!-- .franchise-details -->
                </div><!-- .featured-franchise -->
            </div><!-- .col-12 -->
<?
	}
} else if($_SESSION['pricerange'] != '')	{ 
    $_REQUEST['price_range_id']	= dbQuery("SELECT id FROM franchise_pricerange WHERE pricerange LIKE '%{$_REQUEST['price_range']}%' AND status='active'", 'singlecolumn');
?>
<div class="col-12">
    <div class="no-results">  
        <h1 style="font-size: 33px;"><?= no_magic_quotes(getFieldValue($_REQUEST['price_range_id'], 'pricerange_title', 'franchise_pricerange')) ?></h1>   
        <p><?= getFieldValue($_REQUEST['price_range_id'], 'description', 'franchise_pricerange') ?></p>
    </div>
</div>
<?
}

$i	= 0;
foreach($search as $val)	{
	$i++;
		
	if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
		$_SESSION['tmp_profile_id'] = empty($_SESSION['tmp_profile_id'])  ? rand(1000, 99999) :  $_SESSION['tmp_profile_id'];
	}
	//update the hit for the voucher
	dbQuery("UPDATE franchises SET search_views=search_views+1 WHERE id='{$val['id']}'");
	//ends
	
	//adding to vouchers views & clicks	
	$dbFields = array();
	$dbFields['type'] 			= 'search_view';
	$dbFields['franchise_id'] 	= $val['id'];
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

<div class="col-12 col-lg-4 col-xxl-4">
    <div class="franchise-box">
        <div class="add-to-request-list">
            <a href="javascript:void(0);"><i class="fa <?=customerRequestExist($val['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'fa-square-o' : 'fa-check-square-o'?>" id="<?=$val['id']?>"></i> Add to Request List</a>
        </div>
        <figure>
        	<?
			if($val['logo'] == '')	{
			?>
				<a href="<?=$val['vendor_code']?>"><img src="upload/vendors/thumbnail/No-Logo-Image.jpg" alt="<?=no_magic_quotes($val['vendor'])?>" title="<?=no_magic_quotes($val['vendor'])?>"></a>
			<?
			}
			else	{
			?>
				<a href="<?=$val['vendor_code']?>"><img src="upload/vendors/thumbnail/<?=$val['logo']?>" alt="<?=no_magic_quotes($val['vendor'])?>" title="<?=no_magic_quotes($val['vendor'])?>"></a>
			<?
			}
			?>
            
        </figure>
        <div class="franchise-info">
            <div class="name"><?=no_magic_quotes($val['vendor'])?></div>
            <div class="description"><?=substr(no_magic_quotes($val['description']),0,85)?> ...</div>
            <div class="investment"><?if($val['min_invest_show'] == 'yes'){?><strong>Min. Investment:</strong> &pound;<?=number_format($val['min_investment'])?><?}?>&nbsp;</div>
        </div>
        <footer>
            <div class="controls">
                <a href="<?=$val['vendor_code']?>#contactForm" rel="nofollow" data-toggle="tooltip" data-placement="top" title="Contact Franchise" data-original-title="Contact Franchise"><i class="fa fa-envelope" aria-hidden="true"></i></a>

            </div>
            <a href="<?=$val['vendor_code']?>" class="more-link">find out more</a>
        </footer>
    </div><!-- .franchise-box -->
</div><!-- .col -->


<?
		if((!$_SESSION[AUTH_PREFIX.'AUTH'] && $i==3) || (!$_SESSION[AUTH_PREFIX.'AUTH'] && $search == $i))	{
?>

			<div class="col-12 col-lg-6 col-xxl-4">
                <div class="subscribe-section-wrap">
                    <section class="subscribe-section align-items-center">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-12 subscribe-message text-center">
                                    <h5>Subscribe to our Newsletter</h5>
                                    <p>Receive the best opportunities in your inbox.</p>
                                </div><!-- .subscribe-message -->
                                <div class="col">
                                    <form class="subscribe-form" action="" method="post">
                                        <label for="email">Subscribe to our Free Newsletter</label>
                                        <button type="button" class="btn btn-block btn-yellow collapse-btn" data-toggle="collapse" data-target="#subscribe1">Subscribe</button>
                                        <div class="collapse" id="subscribe1">
                                            <div class="subscribe-form__inner">
                                                <div class="subscribe-form__email">
                                                    <input type="email" placeholder="Enter your email address..." name="email" id="newsletter_email_search" />
                                                    <button type="submit" class="btn btn-subscribe btn-yellow" name="subscribe" id="newsletter_subs_search">subscribe</button>
                                                </div><!-- .subscribe-form__email -->
                                               <!-- <span>or</span>
                                                <a href="fbconfig.php" class="btn btn-signup"><i class="fa fa-facebook-official" aria-hidden="true"></i> Connect with facebook</a>    -->                                                
                                              </div><!-- .subscribe-form__inner -->
                                        </div><!-- .collapse -->
                                    </form><!-- .subscribe-form -->
                                    <h5 style="color:#FFFFFF;display:none;" id="err_subscribe_search"></h5>
                                </div><!-- .col -->
                            </div><!-- .row -->
                        </div><!-- .container -->
                    </section>
                  <!-- .subscribe-section -->
                </div> <!-- .subscribe-section-wrap -->
            </div><!-- .col -->
                
            
		
<?		
		}
    }
?>
