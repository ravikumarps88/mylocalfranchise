<!DOCTYPE html>
<html lang=\"en\">
<head>
   <base href=\"<?=APP_URL?>\">
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    {title}
    {meta_description}
    {meta_keywords}

<link href=\"css/style.css\" rel=\"stylesheet\">

<link rel=\"canonical\" href=\"<?=APP_URL.$_SERVER[\'REQUEST_URI\']?>\" />

<link rel=\"publisher\" href=\"https://plus.google.com/u/0/+FranchiselocalUk\"/>
<meta property=\"fb:app_id\" content=\"940472076072346\"/>
<meta property=\"og:locale\" content=\"en_GB\" />
<meta property=\"og:type\" content=\"website\" />
<meta property=\"og:title\" content=\"{web_title}\" />
<meta property=\"og:description\" content=\"{description}\" />
<meta property=\"og:url\" content=\"<?=APP_URL.$_SERVER[\'REQUEST_URI\']?>\" />
<meta property=\"og:site_name\" content=\"Franchise Local\" />

<?
if($_SESSION[\'industries\'] != \'\')	{
?>
<meta property=\"og:image\" content=\"{op_image_ind}\" />
<?
}
else {
?>
<meta property=\"og:image\" content=\"https://www.franchiselocal.co.uk/img/Sharing-Image.jpg\" />
<?
}
?>

<meta name=\"twitter:card\" content=\"summary_large_image\" >
<meta name=\"twitter:description\" content=\"{description}\" >
<meta name=\"twitter:title\" content=\"{web_title}\" >
<meta name=\"twitter:site\" content=\"@franchiselocal\" >
<?
if($_SESSION[\'industries\'] != \'\')	{
?>
<meta property=\"og:image\" content=\"{op_image_ind}\" >
<?
}
else {
?>
<meta property=\"og:image\" content=\"https://www.franchiselocal.co.uk/img/Sharing-Image.jpg\" >
<?
}
?>
<meta name=\"twitter:creator\" content=\"@franchiselocal\" >

    {google_analytics}

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\'2.0\';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,\'script\',
\'https://connect.facebook.net/en_US/fbevents.js\');
 fbq(\'init\', \'139027419962653\'); 
fbq(\'track\', \'PageView\');
</script>
<noscript>
 <img height=\"1\" width=\"1\" 
src=\"https://www.facebook.com/tr?id=139027419962653&ev=PageView
&noscript=1\"/>
</noscript>
<!-- End Facebook Pixel Code -->

<link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"../images/Favicon/apple-icon-57x57.png\">
<link rel=\"apple-touch-icon\" sizes=\"60x60\" href=\"../images/Favicon/apple-icon-60x60.png\">
<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"../images/Favicon/apple-icon-72x72.png\">
<link rel=\"apple-touch-icon\" sizes=\"76x76\" href=\"../images/Favicon/apple-icon-76x76.png\">
<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"../images/Favicon/apple-icon-114x114.png\">
<link rel=\"apple-touch-icon\" sizes=\"120x120\" href=\"../images/Favicon/apple-icon-120x120.png\">
<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"../images/Favicon/apple-icon-144x144.png\">
<link rel=\"apple-touch-icon\" sizes=\"152x152\" href=\"../images/Favicon/apple-icon-152x152.png\">
<link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"../images/Favicon/apple-icon-180x180.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"192x192\"  href=\"../images/Favicon/android-icon-192x192.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"../images/Favicon/favicon-32x32.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"96x96\" href=\"../images/Favicon/favicon-96x96.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"../images/Favicon/favicon-16x16.png\">
<link rel=\"manifest\" href=\"/manifest.json\">
<meta name=\"msapplication-TileColor\" content=\"#101010\">
<meta name=\"msapplication-TileImage\" content=\"/ms-icon-144x144.png\">
<meta name=\"theme-color\" content=\"#101010\">

<!-- One Signal Code -->
<link rel=\"manifest\" href=\"/manifest.json\" />
<script src=\"https://cdn.onesignal.com/sdks/OneSignalSDK.js\" async=\"\"></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: \"1cca17fd-6b89-459b-9d40-f682f4bad81a\",
      autoRegister: true,
      notifyButton: {
        enable: false,
      },
    });
  });
</script>
</head>
<body>
<!-- Facebook Tracking Search -->
<script>
  fbq(\'track\', \'Search\');
</script>

    <!-- Header -->
    <?include(\'header_home_al.php\')?>
    <!-- Header -->

    <div class=\"search-hero-section\">
        <div class=\"container\">
            <div class=\"row align-items-center\">
                <div class=\"col results-info\">
                    <? 
                    $search_id = ($_REQUEST[\'category_id\'] > 0 ? $_REQUEST[\'category_id\'] : ($_REQUEST[\'sponsored_non_categ_id\'] > 0 ? $_REQUEST[\'sponsored_non_categ_id\'] : $_REQUEST[\'sponsored_categ_id\']) );
                    if($_REQUEST[\'keyword\'] != \'\' || $search_id>0)	{ ?>
		    Your results for <strong>\"<?=$_REQUEST[\'keyword\'] == \'\' ?  no_magic_quotes(getFieldValue($search_id, \'category\',\'franchise_categories\')) : $_REQUEST[\'keyword\']?>\"</strong>
		     <?
		     }
                     elseif($_SESSION[\'letter\'] != \'\') {
                     ?>
		    Your results for <strong>\"<?=$_SESSION[\'letter\']?>\"</strong>
                     <?
                     }
                     elseif($_REQUEST[\'filter\'] != \'\') {
                     ?>
		    Your results for <strong>\"<?=$_REQUEST[\'filter\']?>\"</strong>
                     <?
                     }
                     elseif($_REQUEST[\'lifestyle\'] != \'\') {
                     ?>
		    Your results for <strong>\"<?=no_magic_quotes( getFieldValue($_REQUEST[\'lifestyle\'], \'lifestyle\',\'lifestyles\'))?>\"</strong>
                     <?
                     }
                     elseif($_REQUEST[\'price_range\'] != \'\') {
                     ?>
		    Your results
                     <?
                     }
                     ?>
                </div><!-- .col -->
                <div class=\"col promoted-franchise  hidden-xs-down\" id=\"load_search_hero\">
                <div class=\"promoted-franchise__inner\">
                        <div class=\"timeline-wrapper\">
                            <div class=\"timeline-item\">
                                <div class=\"animated-background\">
                                    <div class=\"background-masker header-top\"></div>
                                    <div class=\"background-masker header-left\"></div>
                                    <div class=\"background-masker header-right\"></div>
                                    <div class=\"background-masker header-bottom\"></div>
                                    <div class=\"background-masker subheader-left\"></div>
                                    <div class=\"background-masker subheader-right\"></div>
                                    <div class=\"background-masker subheader-bottom\"></div>
                                    <div class=\"background-masker content-top\"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .promoted-franchise -->    
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .search-hero-section -->

 <?
if($_SESSION[\'letter\'] != \'\')	{
?>
	<section class=\"a-to-z-section\">
		<div class=\"container\">
			<h5>Filter by:</h5>
			<div class=\"row\">
				<div class=\"col-12\">
					<ul class=\"pagination\">
						<li><a href=\"search/0\">0-9</a></li>
                        <?
						foreach(range(\'a\', \'z\') as $start_letter) {
							if(dbQuery(\"SELECT COUNT(*) FROM franchises WHERE status=\'active\' AND vendor LIKE \'$start_letter%\'\", \'count\') > 0) {
                        ?>
	                        	<li class=\"<?=$start_letter == strtolower($_SESSION[\'letter\']) ? \'active\' : \'\' ?>\" ><a href=\"search/<?=$start_letter?>\"><?=strtoupper($start_letter)?></a></li>	
                        <?
					}		else	{
						?>
                        		<li class=\"<?=$start_letter == strtolower($_SESSION[\'letter\']) ? \'active\' : \'\' ?>\" ><span><?=strtoupper($start_letter)?></span></li>		
                        <?
                        	}	
						}
                        ?>
						
					</ul>

                                        <select onChange=\"window.location.replace(this.options[this.selectedIndex].value)\">
						<option disabled selected>Go to page...</option>

						<option value=\"search/0\" <?=strtolower($_SESSION[\'letter\']) == 0 ? \'selected=\"selected\"\' : \'\' ?> >0-9</option>
						<option value=\"search/a\" <?=strtolower($_SESSION[\'letter\']) == \'a\' ? \'selected=\"selected\"\' : \'\' ?>>A</option>
						<option value=\"search/b\" <?=strtolower($_SESSION[\'letter\']) == \'b\' ? \'selected=\"selected\"\' : \'\' ?>>B</option>
						<option value=\"search/c\" <?=strtolower($_SESSION[\'letter\']) == \'c\' ? \'selected=\"selected\"\' : \'\' ?>>C</option>
						<option value=\"search/d\" <?=strtolower($_SESSION[\'letter\']) == \'d\' ? \'selected=\"selected\"\' : \'\' ?>>D</option>
						<option value=\"search/e\" <?=strtolower($_SESSION[\'letter\']) == \'e\' ? \'selected=\"selected\"\' : \'\' ?>>E</option>
						<option value=\"search/f\" <?=strtolower($_SESSION[\'letter\']) == \'f\' ? \'selected=\"selected\"\' : \'\' ?>>F</option>
						<option value=\"search/g\" <?=strtolower($_SESSION[\'letter\']) == \'g\' ? \'selected=\"selected\"\' : \'\' ?>>G</option>
						<option value=\"search/h\" <?=strtolower($_SESSION[\'letter\']) == \'h\' ? \'selected=\"selected\"\' : \'\' ?>>H</option>
						<option value=\"search/i\" <?=strtolower($_SESSION[\'letter\']) == \'i\' ? \'selected=\"selected\"\' : \'\' ?>>I</option>
						<option value=\"search/j\" <?=strtolower($_SESSION[\'letter\']) == \'j\' ? \'selected=\"selected\"\' : \'\' ?>>J</option>
						<option value=\"search/k\" <?=strtolower($_SESSION[\'letter\']) == \'k\' ? \'selected=\"selected\"\' : \'\' ?>>K</option>
						<option value=\"search/l\" <?=strtolower($_SESSION[\'letter\']) == \'l\' ? \'selected=\"selected\"\' : \'\' ?>>L</option>
						<option value=\"search/m\" <?=strtolower($_SESSION[\'letter\']) == \'m\' ? \'selected=\"selected\"\' : \'\' ?>>M</option>
						<option value=\"search/n\" <?=strtolower($_SESSION[\'letter\']) == \'n\' ? \'selected=\"selected\"\' : \'\' ?>>N</option>
						<option value=\"search/o\" <?=strtolower($_SESSION[\'letter\']) == \'o\' ? \'selected=\"selected\"\' : \'\' ?>>O</option>
						<option value=\"search/p\" <?=strtolower($_SESSION[\'letter\']) == \'p\' ? \'selected=\"selected\"\' : \'\' ?>>P</option>
						<option value=\"search/q\" <?=strtolower($_SESSION[\'letter\']) == \'q\' ? \'selected=\"selected\"\' : \'\' ?>>Q</option>
						<option value=\"search/r\" <?=strtolower($_SESSION[\'letter\']) == \'r\' ? \'selected=\"selected\"\' : \'\' ?>>R</option>
						<option value=\"search/s\" <?=strtolower($_SESSION[\'letter\']) == \'s\' ? \'selected=\"selected\"\' : \'\' ?>>S</option>
						<option value=\"search/t\" <?=strtolower($_SESSION[\'letter\']) == \'t\' ? \'selected=\"selected\"\' : \'\' ?>>T</option>
						<option value=\"search/u\" <?=strtolower($_SESSION[\'letter\']) == \'u\' ? \'selected=\"selected\"\' : \'\' ?>>U</option>
						<option value=\"search/v\" <?=strtolower($_SESSION[\'letter\']) == \'v\' ? \'selected=\"selected\"\' : \'\' ?>>V</option>
						<option value=\"search/w\" <?=strtolower($_SESSION[\'letter\']) == \'w\' ? \'selected=\"selected\"\' : \'\' ?>>W</option>
						<option value=\"search/x\" <?=strtolower($_SESSION[\'letter\']) == \'x\' ? \'selected=\"selected\"\' : \'\' ?>>X</option>
						<option value=\"search/y\" <?=strtolower($_SESSION[\'letter\']) == \'y\' ? \'selected=\"selected\"\' : \'\' ?>>Y</option>
						<option value=\"search/z\" <?=strtolower($_SESSION[\'letter\']) == \'z\' ? \'selected=\"selected\"\' : \'\' ?>>Z</option>
					</select>
					
				</div>
			</div>
		</div>
	</section>	
<?    
}
?>

    <div class=\"container sidebar-left\">
        <div class=\"row\">
            <div class=\"site-sidebar\" id=\"load_search_sidebar\">
             <aside class=\"widget widget_filter\">
                    <h3>Update Results</h3>
                    <h3 class=\"collapse-title\"><a href=\"#widget_filter\" data-toggle=\"collapse\">Update Results <i class=\"fa fa-angle-down float-right\"></i></a></h3>
                    <div class=\"collapse\" id=\"widget_filter\">
                        <div class=\"collapse__inner\">
                            <form action=\"search.html\" method=\"\"get>
                                <p><strong>Price Range</strong></p>
				<select>
                                    <option value=\"\"  selected>Select a Price range</option>
                                    
                                </select>
                                <p><strong>By lifestyle</strong></p>
                                <select>
                                    <option value=\"\"  selected>Select a Lifestyle</option>
                                    
                                </select>
                                <p><strong>By category</strong></p>
                                <select>
                                    <option value=\"\"  selected>Select a Category</option>
                                </select>
                                <div class=\"text-right\">
                                    <button type=\"submit\" class=\"btn btn-warning\">Update</button>
                                </div><!-- .text-right -->
                            </form>
                        </div><!-- .collapse__inner -->
                    </div><!-- .collapse -->
                </aside><!-- .widget .widget_filter -->
                <aside class=\"widget widget_request_list\">
                    <h3>My Request List</h3>
                    <h3 class=\"collapse-title\"><a href=\"#widget_request_list\" data-toggle=\"collapse\">My Request List <i class=\"fa fa-angle-down float-right\"></i></a></h3>
                    <div class=\"collapse\" id=\"widget_request_list\">
                        <div class=\"collapse__inner\">
                            <p>add to your request list by selecting franchises.</p>
                            <div class=\"alert alert-info alert-dismissible fade show\" role=\"alert\">
                                 <div class=\"loading-link-item\"><div class=\"animated-background\"></div></div>
                            </div>
                            
                            <a class=\"text-right\" href=\"#\">VIEW ALL <i class=\"fa fa-long-arrow-right\" aria-hidden=\"true\"></i></a>
                        </div><!-- .collapse__inner -->
                    </div><!-- .collapse -->
                </aside><!-- .widget .widget_request_list -->
                <aside class=\"widget widget_featured_franchises\">
                    <h3>Featured Franchises</h3>
                    <h3 class=\"collapse-title\"><a href=\"#widget_featured_franchises\" data-toggle=\"collapse\">Featured Franchises <i class=\"fa fa-angle-down float-right\"></i></a></h3>
                    <div class=\"collapse\" id=\"widget_featured_franchises\">
                        <div class=\"collapse__inner\">
                            <ul>
                                <li>
                        <div class=\"timeline-wrapper\">
                            <div class=\"timeline-item\">
                                <div class=\"animated-background\">
                                    <div class=\"background-masker header-top\"></div>
                                    <div class=\"background-masker header-left\"></div>
                                    <div class=\"background-masker header-right\"></div>
                                    <div class=\"background-masker header-bottom\"></div>
                                    <div class=\"background-masker subheader-left\"></div>
                                    <div class=\"background-masker subheader-right\"></div>
                                    <div class=\"background-masker subheader-bottom\"></div>
                                    <div class=\"background-masker content-top\"></div>
                                </div>
                            </div>
                        </div>
                                </li>
                                
                            </ul>
                        </div><!-- .collapse__inner -->
                    </div><!-- .collapse -->
                </aside><!-- .widget .widget_featured_franchises -->   
            </div><!-- .site-sidebar -->

            <section class=\"franchise-list-section\">
                
                     {content}
                     {dynamic_content}
                

                <div  id=\"Pagination\" class=\"pagination justify-content-center\">
                    
                </div><!-- .pagination .justify-content-center -->
            </section><!-- .franchise-list-section -->

        </div><!-- .row -->
    </div><!-- .container .sidebar-left -->
       
    <!-- Footer -->
   <?include(\'footer.php\')?>
   <!-- Footer -->

        <script type=\"text/javascript\" src=\"js/jquery.pagination.js\"></script>
	<script> 
	    jQuery(document).ready(function(){ 
			jQuery(\"#Pagination\").pagination(<?=$search?>, {
				items_per_page:{blog_per_page},
				callback:handlePaginationClick,
				num_display_entries: 6,
				num_edge_entries: 2,
                                load_first_page : false,
                                next_show_always: false,
                                prev_show_always: false
			});

			//pagination
			function handlePaginationClick(new_page_index, pagination_container) {
				jQuery(\"#col_holder\").load(\"load_business.php?start=\"+(new_page_index*{blog_per_page})+\"&blog_per_page={blog_per_page}&keyword=<?=$_REQUEST[\'keyword\']?>&category_id=<?=$_REQUEST[\'category_id\']?>&letter=<?=$_REQUEST[\'letter\']?>&sponsored_categ_id=<?=$_REQUEST[\'sponsored_categ_id\']?>&sponsored_non_categ_id=<?=$_REQUEST[\'sponsored_non_categ_id\']?>&lifestyle=<?=$_REQUEST[\'lifestyle\']?>&filter=<?=$_REQUEST[\'filter\']?><?=$price_range_arr_str?>\");
				
        jQuery(\"html, body\").animate({
        	scrollTop: 0
    	}, 1000);
return false;
			}
	    });
	</script>

</body>
</html>