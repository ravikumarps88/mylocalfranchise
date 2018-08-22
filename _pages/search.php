<?
//print_r($_SESSION['industries']);exit;
if($_SESSION['industries'] != '')	{
	$_REQUEST['category_id']	= dbQuery("SELECT id FROM franchise_categories WHERE url_title LIKE '%{$_SESSION['industries']}%' AND status='active'", 'singlecolumn');
	//if($_REQUEST['category_id'] == '' || $_REQUEST['category_id'] == 0)
		//header("Location:".APP_URL."/home.html");
}

if($_SESSION['pricerange'] != '')	{
	$_REQUEST['price_range']	= dbQuery("SELECT pricerange FROM franchise_pricerange WHERE url_title LIKE '%{$_SESSION['pricerange']}%' AND status='active'", 'singlecolumn');
        $_REQUEST['price_range_id']	= dbQuery("SELECT id FROM franchise_pricerange WHERE url_title LIKE '%{$_SESSION['pricerange']}%' AND status='active'", 'singlecolumn');
        //echo $_REQUEST['price_range'];exit;
}

if($_SESSION['letter'] != '')	{
	$_REQUEST['letter']	= $_SESSION['letter'];
}		
	
$search_start	= getSearch($_REQUEST['keyword'], $_REQUEST['category_id'], $_REQUEST['price_range'],'','',$_REQUEST['lifestyle'],$_REQUEST['filter'],0,BLOG_PER_PAGE,$_REQUEST['featured'],$_REQUEST['letter'],$_REQUEST['sponsored_categ_id'],$_REQUEST['sponsored_non_categ_id']);
$search			= getSearchCount($_REQUEST['keyword'], $_REQUEST['category_id'], $_REQUEST['price_range'],'','',$_REQUEST['lifestyle'],$_REQUEST['filter'],'','',$_REQUEST['featured'],$_REQUEST['letter'],$_REQUEST['sponsored_categ_id'],$_REQUEST['sponsored_non_categ_id']);

if($search == 0)
	$vendors_others		= getVendorsListFiltered('',20,'featured');

$vendor_ids = array();
/*foreach($search as $val)
	$vendor_ids[]	= $val['id'];*/
?>

<?=$search == 0 ? '<div class="no-results">  
		<i class="fa fa-info-circle pull-left" style="font-size: 30px;color: hsl(0, 0%, 51%);margin-right: 15px;"></i>
        <h2>Sorry, no results found.</h2>        
         <p>Maybe you would like to <a href="/search/a">View Franchises Alphabetically</a> or <a href="/industries.html">Browse by Industry</a></p>
    </div>' : ''?>
    
<!-- Search Results -->
<div class="row" id="col_holder">
<?
if($_SESSION['industries'] != '')	{
?>
		<div class="col-12"><div class="no-results">  
	        <h1 style="font-size: 33px;"><?=no_magic_quotes( getFieldValue($_REQUEST['category_id'], 'category','franchise_categories'))?> Franchise Opportunities For Sale</h1>   
            <p><?=getFieldValue($_REQUEST['category_id'], 'description','franchise_categories')?></p>
        </div></div>		
<?
	$vendors	= getVendorsListFiltered('',1,'','',$_REQUEST['category_id'],'','','','',$_REQUEST['category_id']);

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
                            <a href="javascript:void(0);" class="btn btn-block btn-secondary <?=customerRequestExist($val['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'add_request_list_button' : 'remove_request_list_button' ?>" id="add_remove_button" val="<?=$val['id']?>"><?=customerRequestExist($val['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'Add to Request List' : 'Remove' ?></a>
                            
                        </div>
                    </div><!-- .button-wrap -->
                </div><!-- .franchise-details -->
            </div><!-- .featured-franchise -->
        </div><!-- .col-12 -->
<?
	}
}
elseif($_REQUEST['lifestyle'] != '')	{
	$vendors	= getVendorsListFiltered('',1,'','','','','','','','',$_REQUEST['lifestyle']);
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
} else if($_SESSION['pricerange'] != '')	{ 
?>
		<div class="col-12"><div class="no-results">  
	        <h1 style="font-size: 33px;"><?=no_magic_quotes( getFieldValue($_REQUEST['price_range_id'], 'pricerange_title','franchise_pricerange'))?> Franchise Opportunities For Sale</h1>   
            <p><?=getFieldValue($_REQUEST['price_range_id'], 'description','franchise_pricerange')?></p>
        </div></div>
<?
}
	$i	= $subcr_count = 0;
    foreach($search_start as $val)	{
		$i++;
		
        /*if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
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
        dbPerform("franchise_views", $dbFields, $specialFields);*/
        //ends
    ?>
    
    <div class="col-12 col-lg-6 col-xxl-4">
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
                    <a href="<?=$val['vendor_code']?>#contactForm" rel="nofollow"><i class="fa fa-envelope" aria-hidden="true"></i></a>
    
                </div>
                <a href="<?=$val['vendor_code']?>" class="more-link">find out more</a>
            </footer>
        </div><!-- .franchise-box -->
    </div><!-- .col -->
    
<?
		if((!$_SESSION[AUTH_PREFIX.'AUTH'] && $i==3) || (!$_SESSION[AUTH_PREFIX.'AUTH'] && ($search == $i)) && $subcr_count == 0)	{
			$subcr_count++;
?>
			<div class="col-12 col-lg-6 col-xxl-4">
                <div class="subscribe-section-wrap">
                    <section class="subscribe-section align-items-center">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-12 subscribe-message text-center">
                                    <h3>Subscribe to our Newsletter</h3>
                                    <p>Subscribe to our FREE newsletter to receive the the best opportunities in your inbox.</p>
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
                                               <!--  <span>or</span>
                                                <a href="fbconfig.php" class="btn btn-signup"><i class="fa fa-facebook-official" aria-hidden="true"></i> Connect with facebook</a>  -->                                                  </div><!-- .subscribe-form__inner -->
                                        </div><!-- .collapse -->
                                    </form><!-- .subscribe-form -->
                                    <br /><h5 style="color:#FFFFFF;display:none;" id="err_subscribe_search"></h5>
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

	
<?
if($search == 0)	{
	$cnt = 0 ;
	foreach($vendors_others as $val)	{
		if(!in_array($val['id'],$vendor_ids))	{
			$cnt++;
	if($cnt == 1)	{				
	?>
    <div class="col-12">
    <h4>Here are some other franchises opportunities you might like...</h4>
	</div>	
	<?
	}
	
	if($cnt == 4)
		break;
	?>
		<div class="col-12 col-lg-6 col-xxl-4">
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
					<div class="investment"><strong>Min. Investment:</strong> &pound;<?=number_format($val['min_investment'])?></div>
				</div>
				<footer>
					<div class="controls">
						<a href="<?=$val['vendor_code']?>"><i class="fa fa-envelope" aria-hidden="true"></i></a>
		
					</div>
					<a href="<?=$val['vendor_code']?>" class="more-link">find out more</a>
				</footer>
			</div><!-- .franchise-box -->
		</div><!-- .col -->
	<?
		}
	}
}	
?>
    
</div>
<!-- Search Results -->