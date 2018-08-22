<?
if(!$_SESSION[AUTH_PREFIX.'AUTH'])
	$user_id = $_SESSION['tmp_profile_id'];
else
	$user_id = $_SESSION['USER_PROFILE']['id'];
	
	$pass_array	= array();
	foreach($_REQUEST as $key=>$val)	{
		$pass_array[$key] = urlencode($val);
	}
	
//$vendors	= getVendorsListFiltered('',4,'featured');	
//$profile_views	= dbQuery("SELECT DISTINCT franchise_id FROM franchise_views WHERE customer_id ='$user_id' AND type='profile_view' ORDER BY inserted_on DESC LIMIT 4");	
$profile_views_count	= dbQuery("SELECT COUNT(*) FROM franchise_views WHERE customer_id ='$user_id' AND type='profile_view'", 'count');	

?>


<?
if($profile_views_count > 0)	{
?>
<section class="another-look-section">
    <div class="container">
        <h4>Take Another Look</h4>
        <div class="row" id="load_another_look">
        	<div class="col-sm-6 col-lg-4 col-xl-3 ">
                <div class="timeline-wrapper">
                    <div class="timeline-item">
                        <div class="animated-background">
                            <div class="background-masker content-top"></div>
                        </div>
                  </div>
                </div>
            </div><!-- .col-sm-6 col-lg-4 col-xl-3  -->
            <div class="col-sm-6 col-lg-4 col-xl-3 ">
                <div class="timeline-wrapper">
                    <div class="timeline-item">
                        <div class="animated-background">
                            <div class="background-masker content-top"></div>
                        </div>
                  </div>
                </div>
            </div><!-- .col-sm-6 col-lg-4 col-xl-3  -->
            <div class="col-sm-6 col-lg-4 col-xl-3 ">
                <div class="timeline-wrapper">
                    <div class="timeline-item">
                        <div class="animated-background">
                            <div class="background-masker content-top"></div>
                        </div>
                  </div>
                </div>
            </div><!-- .col-sm-6 col-lg-4 col-xl-3  -->
            <div class="col-sm-6 col-lg-4 col-xl-3 ">
                <div class="timeline-wrapper">
                    <div class="timeline-item">
                        <div class="animated-background">
                            <div class="background-masker content-top"></div>
                        </div>
                  </div>
                </div>
            </div><!-- .col-sm-6 col-lg-4 col-xl-3  -->
            
        	<?
			$i=0;
			foreach($profile_views as $val)	{
				$i++;
				$vendor		= getVendorDetails($val['franchise_id']);
				
				if($i == 3)
					$inv_class_mobile	= ' hidden-md-down';
				if($i == 4)
					$inv_class_mobile	= ' hidden-lg-down';	

            ?>
                <div class="col-sm-6 col-lg-4 col-xl-3 <?=$inv_class_mobile?>">
                    <a href="<?=$vendor['vendor_code']?>" class="franchise-box">
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
                        <div class="franchise-name">
                            <?=no_magic_quotes($vendor['vendor'])?> <span>View</span>
                        </div><!-- .franchise-name -->
                    </a><!-- .franchise-name -->
                </div><!-- .col-sm-6 col-lg-4 col-xl-3  -->
            <?
			}
            ?>
        </div><!-- .row -->
    </div><!-- .container -->
</section><!-- .another-look-section -->
<?
}

if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
?>
<section class="subscribe-large-section">
    <div class="container">
        <h5>Subscribe to our Free Newsletter</h5>
        <p>Sign up for a free newsletter and receive the latest opportunities and news straight in your inbox.</p>
        <div class="row align-items-center">
            <div class="col" id="subscribe-form__email">
                <form class="subscribe-form" method="post" action="">
                    <div class="subscribe-form__inner">
                        <div class="subscribe-form__email">
                            <input type="email" id="newsletter_email" placeholder="Enter your email address...">
                            <button type="submit" class="btn btn-subscribe btn-yellow" name="subscribe" id="newsletter_subs">subscribe</button>
                        </div><!-- .subscribe-form__email -->
                    </div><!-- .subscribe-form__inner -->
                    <br /><h6 id="err_subscribe"></h6>
                </form><!-- .subscribe-form -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</section><!-- .subscribe-large-section -->
<?
}
?>

<footer class="site-footer">
    <div class="container">
        <div class="copyrights">Copyright &copy; <script>document.write(new Date().getFullYear())</script> Franchise Local Ltd All Rights Reserved. <a href="/terms-and-conditions.html">Terms &amp; Conditions</a> - <a href="/our-privacy-policy.html">Privacy Policy</a> - <a href="/advertise.html">Advertise with us</a> - <a href="/news/">News</a>				</div>
        <a href="#theTop" class="scrolltop">Back to top <i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>
    </div><!-- .container -->
</footer><!-- .site-footer -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="js/my-scripts.js" type="text/javascript"></script>



<?
if($page == 'franchise_details')	{
?>
<link href="css/print.css" rel="stylesheet" media="print">
<?
}
?>
        
<script type="text/javascript">
	$(document).ready(function() {
		<?
		if($page == 'franchise_details')	{
		?>
			$(window).scroll(function() {
				if($(window).scrollTop() > $('.contact-form').offset().top - $( window ).height()) {
					$('.fp-sticky-footer').addClass('hide');
				} else {
					$('.fp-sticky-footer').removeClass('hide');
				};
			});
		<?
		}
		?>
		
		setTimeout(
		  function() 
		  {
		  	$('#load_franchise_categs').load('process.php?action=load_franchise_categs');
			
			$('#load_search_hero').load('process.php?action=load_search_hero');
			
			$("#load_search_sidebar").load('process.php?action=load_search_sidebar&variables=<?=json_encode($pass_array)?>');
		
			<?
			if($page == 'enquiry_sent')	{
			?>
				$("#load_search_sidebar_nofilter").load('process.php?action=load_search_sidebar_nofilter&variables=<?=json_encode($pass_array)?>');
			<?
			}
			?>
			
			$('#load_feat_franchise').load('process.php?action=load_feat_franchise');
			
			<?
			if($profile_views_count > 0)	{
			?>
				$('#load_another_look').load('process.php?action=load_another_look');
			<?
			}
			?>
			
		  }, 100);
		  
		  $('.scrolltop').click(function(event)	{
		  	event.preventDefault();
			var target = $(this.hash);
			$('html, body').animate({
				scrollTop: target.offset().top
			}, 1000, function() {
				var $target = $(target);
				$target.focus();
				if ($target.is(":focus")) {
					return false;
				} else {
					$target.attr('tabindex','-1');
					$target.focus();
				};
			});
		  });
		
	});
</script>

<script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56d58549a896c0a3"></script>
