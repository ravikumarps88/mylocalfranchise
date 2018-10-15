<?

function getTemplate($page) {
	$sql	= "SELECT tmp_content FROM templates t LEFT JOIN pages p ON t.id=p.template_id WHERE page_alias='$page' AND p.status='active'";
	return dbQuery($sql, 'singlecolumn');
	
}

function defaultTemplate()	{
	$sql	= "SELECT tmp_content FROM templates WHERE isdefault='yes' AND status='active'";
	return dbQuery($sql, 'singlecolumn');
}

function getContentType($page)	{
	$sql	= "SELECT content_type FROM pages WHERE page_alias='$page' AND status='active'";
	return dbQuery($sql, 'singlecolumn');
}

function getPageContents($page)	{
	$sql	= "SELECT content FROM pages WHERE page_alias='$page' AND status='active'";
	return dbQuery($sql, 'singlecolumn');
}


function getSEOTags($page, $template)	{
        if($_SESSION['industries'] != '')	{
		$_REQUEST['category_id']	= dbQuery("SELECT id FROM franchise_categories WHERE url_title LIKE '%{$_SESSION['industries']}%' AND status='active'", 'singlecolumn');
		$category_tags = dbQuery("select title_tag,meta_description,meta_keywords,image from franchise_categories WHERE id='{$_REQUEST['category_id']}'",'single');
		
		if($category_tags['title_tag'] != '')
			$tags['title_tag']			= $category_tags['title_tag'];
		else	
			$tags['title_tag']			= 'Best '.$_SESSION['industries'].' Franchise Opportunities | FranchiseLocal.co.uk';
		
		if($category_tags['meta_description'] != '')
			$tags['meta_description']	= $category_tags['meta_description'];
		else	
			$tags['meta_description']	= 'Browse the best '. $_SESSION['industries'] .' Franchise Opportunities and business opportunities for sale with Franchise Local - Visit us today';
		
		$tags['meta_keywords'] 		= $category_tags['meta_keywords'];
		
		$op_image_ind	= APP_URL."/upload/vendors/category/original/".$category_tags['image'];
		$template		= str_replace('{op_image_ind}', $op_image_ind, $template);
	}
	
	elseif($_SESSION['code'] != '')	{
		$_REQUEST['franchise_id']	= dbQuery("SELECT id FROM franchises WHERE vendor_code='{$_SESSION['code']}' AND status='active'", 'singlecolumn');			
		$franchise	= getVendorDetails($_REQUEST['franchise_id']);
		
		
		$tags['title_tag']			= $franchise['franchise_desc'].' - Franchiselocal.co.uk';
		$tags['meta_description']	= $franchise['vendor'].' franchise - a leading '. getFieldValue($franchise['category_id'],'category','franchise_categories') .' franchise opportunity providing lucrative '. getFieldValue($franchise['category_id'],'category','franchise_categories') .' franchise business options across the UK - Franchiselocal.co.uk';
		
		$op_image	= APP_URL."/upload/vendors/original/".$franchise['logo'];
		$template	= str_replace('{op_image}', $op_image, $template);
	}
	
	elseif($_SESSION['lifestyle'] != '')	{
                $lifestyle_tags = dbQuery("select lifestyle_title,lifestyle,title_tag,meta_description,meta_keywords,image from franchise_lifestyle WHERE url_title LIKE '%{$_SESSION['lifestyle']}%' AND status='active'",'single');
        
		if($lifestyle_tags['title_tag'] != '')
			$tags['title_tag']			= $lifestyle_tags['title_tag'];
		else	
			$tags['title_tag']			= 'Best '.$lifestyle_tags['lifestyle_title'].' Franchise Opportunities | FranchiseLocal.co.uk';
		
		if($lifestyle_tags['meta_description'] != '')
			$tags['meta_description']	= $lifestyle_tags['meta_description'];
		else	
			$tags['meta_description']	= 'Browse the best '. $lifestyle_tags['lifestyle_title'] .' Franchise Opportunities and business opportunities for sale with Franchise Local - Visit us today';
		
		$tags['meta_keywords'] 		= $lifestyle_tags['meta_keywords'];
                
                $op_image_ind	= APP_URL."/upload/vendors/lifestyle/original/".$lifestyle_tags['image'];
		$template		= str_replace('{op_image_ind}', $op_image_ind, $template);
	} 
        
        elseif($_SESSION['pricerange'] != '')	{
		$pricerangeId	= dbQuery("SELECT id FROM franchise_pricerange WHERE url_title LIKE '%{$_SESSION['pricerange']}%' AND status='active'", 'singlecolumn');
		$pricerange_tags = dbQuery("select pricerange,title_tag,meta_description,meta_keywords,image from franchise_pricerange WHERE id='{$pricerangeId}'",'single');
		
		if($pricerange_tags['title_tag'] != '')
			$tags['title_tag']			= $pricerange_tags['title_tag'];
		else	
			$tags['title_tag']			= 'Best '.$pricerange_tags['pricerange'].' Franchise Opportunities | FranchiseLocal.co.uk';
		
		if($pricerange_tags['meta_description'] != '')
			$tags['meta_description']	= $pricerange_tags['meta_description'];
		else	
			$tags['meta_description']	= 'Browse the best '. $pricerange_tags['pricerange'] .' Franchise Opportunities and business opportunities for sale with Franchise Local - Visit us today';
		
		$tags['meta_keywords'] 		= $pricerange_tags['meta_keywords'];
		
		$op_image_ind	= APP_URL."/upload/vendors/pricerange/original/".$pricerange_tags['image'];
		$template		= str_replace('{op_image_ind}', $op_image_ind, $template);
                
	} elseif($_SESSION['letter'] != '')	{
		$alphabetId	= dbQuery("SELECT id FROM alphabet_search WHERE url_title LIKE 'uk-franchise-directory' AND status='active'", 'singlecolumn');
		$alphabet_tags = dbQuery("select alphabet,title_tag,meta_description,meta_keywords,image FROM alphabet_search WHERE id='{$alphabetId}'",'single');
		
		if($alphabet_tags['title_tag'] != '')
			$tags['title_tag']			= $alphabet_tags['title_tag'];
		else	
			$tags['title_tag']			= 'Best '.$alphabet_tags['alphabet'].' Franchise Opportunities | FranchiseLocal.co.uk';
		
		if($alphabet_tags['meta_description'] != '')
			$tags['meta_description']	= $alphabet_tags['meta_description'];
		else	
			$tags['meta_description']	= 'Browse the best '. $alphabet_tags['alphabet'] .' Franchise Opportunities and business opportunities for sale with Franchise Local - Visit us today';
		
		$tags['meta_keywords'] 		= $alphabet_tags['meta_keywords'];
		
		$op_image_ind	= APP_URL."/upload/vendors/alphabet/original/".$alphabet_tags['image'];
		$template		= str_replace('{op_image_ind}', $op_image_ind, $template);
	}

	else	{
		$sql	= "SELECT title_tag,meta_description,meta_keywords,page_name FROM pages WHERE page_alias='$page'";
		$tags	= dbQuery($sql, 'single');
	}
	
	$template	= str_replace('{title}', '<title>'.$tags['title_tag'].'</title>', $template);
	$template	= str_replace('{page_title}', $tags['page_name'], $template);
	$template	= str_replace('{web_title}', $tags['title_tag'], $template);
	
	if($tags['meta_description'] != "")	{
		$template	= str_replace('{meta_description}', '<meta name="description" content="'.$tags['meta_description'].'" />', $template);
		$template	= str_replace('{description}', $tags['meta_description'], $template);
	}	
	else	{
		$template	= str_replace('{meta_description}', '<meta name="description" content="'.META_DESCRIPTION.'" />', $template);
		$template	= str_replace('{description}', META_DESCRIPTION, $template);
	}	
		
	if($tags['meta_keywords'] != "")
		$template	= str_replace('{meta_keywords}', '<meta name="keywords" content="'.$tags['meta_keywords'].'" />', $template);
	else
		$template	= str_replace('{meta_keywords}', '<meta name="keywords" content="'.META_KEYWORDS.'" />', $template);		
	return $template;
}

function getGoogleAnalytics($template)	{
	$template	= str_replace('{google_analytics}', "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', '".GOOGLE_ANALYTICS."', 'auto');ga('require', 'displayfeatures');ga('send', 'pageview');</script>", $template);
	
	$template	= str_replace('{facebook_code}', "<script>(function() {var _fbq = window._fbq || (window._fbq = []);if (!_fbq.loaded) {var fbds = document.createElement('script');
    fbds.async = true;fbds.src = '//connect.facebook.net/en_US/fbds.js';var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(fbds, s);_fbq.loaded = true;}_fbq.push(['addPixelId', '370805273067942']);})();window._fbq = window._fbq || [];window._fbq.push(['track', 'PixelInitialized', {}]);</script><noscript><img height='1' width='1' alt='' style='display:none' src='https://www.facebook.com/tr?id=370805273067942&amp;ev=PixelInitialized' /></noscript>", $template);
	
	return $template;
}

function getStyleSheets($template, $page)	{
	$template	= str_replace('{stylesheets}', '<link rel="stylesheet" type="text/css" media="all" href="stylesheet.php?id='.$page.'" />', $template);
	return $template;
}

function getSlideshowScript($template, $page)	{
	$slideshow_script	= "<script type='text/javascript' src='js/jquery-1.5.2.min.js'></script><script type='text/javascript' src='js/jquery.cycle.all.min.js'></script><script type='text/javascript'>var \$s = jQuery.noConflict();\$s(function() {";
	$slideshows	= getSlideshows();
	foreach($slideshows as $val)		{
		$slideshow_script	.=	"\$s('#slideshow_".$val['id']."').cycle({fx: '".$val['transition']."',speed: ".$val['speed'].",timeout:".$val['timeout'].",pause:".($val['pauseonhover']=='yes'?1:0)."});";
	}
	$slideshow_script	.=	" });</script>";
	$template	= str_replace('{slideshow_script}', $slideshow_script, $template);
	return $template;
}

function insertSlideshow($template, $page)	{
	
	$slideshows	= getSlideshows();
	foreach($slideshows as $val)		{
		$slideshow_script	 = '<div id="slideshow_'.$val['id'].'" style="overflow:hidden;height:'.$val['slide_height'].'px; width:'.$val['slide_width'].'px;">';	
		foreach(getSlideshowImages($val['id'], "status='active'") as $imgval)	{
			$slideshow_script	.= '<img src="images/slideshow/slideshow/'.$imgval['slideshow_img'].'" width="'.$val['slide_width'].'" height="'.$val['slide_height'].'" alt="'.$val['slideshow'].'" /> ';	
		}
		$slideshow_script	.= '</div>';
		
		$template	= str_replace($val['embed_code'], $slideshow_script, $template);
	}
	return $template;
}

function insertFeaturedSlideshow($template, $page)	{
	$template	= str_replace('{featured_slideshow}', getFeaturedSlideshow(), $template);
	return $template;
}

function insertBlogElements($template, $page)	{
	$template	= str_replace('{blog_per_page}', BLOG_PER_PAGE, $template);
	return $template;
}


function insertPageDetails($template, $page)	{
	$page_details	= dbQuery("SELECT menu_text FROM pages WHERE page_alias='$page'", 'single');
	$template	= str_replace('{page_name}', $page_details['menu_text'], $template);
	return $template;
}
function insertBreadCrumb($template, $page)	{
	$page_details	= dbQuery("SELECT parent_id,menu_text FROM pages WHERE page_alias='$page'", 'single');
	if($page_details['parent_id'] == -1)
		$template	= str_replace('{page_bread_crumb}', '<li><a href="index.html">Home</a></li><li><span>'.$page_details['menu_text'], $template).'</span></li>';
	else	{
		$subpage_details	= dbQuery("SELECT menu_text,page_alias FROM pages WHERE id='{$page_details['parent_id']}'", 'single');
		$template			= str_replace('{page_bread_crumb}', '<li><a href="index.html">Home</a></li><li><a href="'.$subpage_details['page_alias'].'.html">'.$subpage_details['menu_text'].'</a></li><li><span>'.$page_details['menu_text'].'</span></li>', $template);
	}	
	return $template;	
}

function getMainMenu($template, $page='')	{
	$sql 	= "SELECT id,menu_text,page_alias,content_type,external_url FROM pages WHERE status='active' AND show_in_menu='yes' AND (menutype='main' || menutype='both') AND parent_id='-1' ORDER BY sort_order";
	$menu	= dbQuery($sql);
	foreach($menu as $val)	{
		$current	= ($val['page_alias'] == $page ? 'current-menu-item' : '');
		$href		= ($val['content_type'] == 'external' ? $val['external_url'] :  ($val['page_alias'] == '' ? '#' : $val['page_alias'].'.html'));
		$target		= ($val['content_type'] == 'external' ? 'target="_blank"' :  '');
		$menu_code	.= '<li><a href="'.$href.'" '.$target.'>'.$val['menu_text'].'</a>';
		$sql 	= "SELECT menu_text,page_alias,content_type,external_url FROM pages WHERE status='active' AND show_in_menu='yes' AND (menutype='sub' || menutype='both') AND parent_id='{$val['id']}' ORDER BY sort_order";
		$submenu	= dbQuery($sql);
		$menu_code	.= (count($submenu) == 0 ? '' : '<ul>');
		foreach($submenu as $sval)	{
			$href		= ($sval['content_type'] == 'external' ? $sval['external_url'] :  ($sval['page_alias'] == '' ? '#' : $sval['page_alias'].'.html'));
			$target		= ($sval['content_type'] == 'external' ? 'target="_blank"' :  '');		
			$menu_code	.= '<li class="'.$current.'"><a href="'.$href.'" '.$target.'>'.$sval['menu_text'].'</a></li>';
		}
		$menu_code	.= (count($submenu) == 0 ? '</li>' : '</ul></li>');
		
	}
	$menu_code	.= (!$_SESSION[AUTH_PREFIX.'AUTH'] ? '<li><a href="#" data-toggle="modal" data-target="#loginModal" id="signinmodal">Sign In</a></li>' : '<li><a href="#">My Account</a>');
	
	$menu_code	.= (!$_SESSION[AUTH_PREFIX.'AUTH'] ? '<li><a href="register.html" >Sign Up</a></li>' : '');
	
	$menu_code	.= (!$_SESSION[AUTH_PREFIX.'AUTH'] ? '' : '<ul><li><a href="my-account.html">Profile</a></li><li><a href="request-list.html">My List</a></li><li><a href="logout.html">Logout</a></li></ul></li>');
	
	$template	= str_replace('{main_menu}', $menu_code, $template);
	return $template;
}

function getFooterMenu($template, $page='')	{
	$sql 	= "SELECT id,menu_text,page_alias FROM pages WHERE status='active' AND show_in_menu='yes' AND (menutype='footer' || menutype='both') AND parent_id='-1' ORDER BY sort_order";
	$menu	= dbQuery($sql);
	foreach($menu as $val)	{
		$current	= ($val['page_alias'] == $page ? 'current-menu-item' : '');
		$href		= ($val['page_alias'] == '' ? '#' : $val['page_alias'].'.html');
		$menu_code	.= '<li><a href="'.$href.'">'.$val['menu_text'].'</a>';
		$sql 	= "SELECT menu_text,page_alias FROM pages WHERE status='active' AND show_in_menu='yes' AND (menutype='footer' || menutype='both') AND parent_id='{$val['id']}' ORDER BY sort_order";
		$submenu	= dbQuery($sql);
		$menu_code	.= (count($submenu) == 0 ? '' : '<ul>');
		foreach($submenu as $sval)	{		
			$menu_code	.= '<li class="'.$current.'"><a href="'.$sval['page_alias'].'.html">'.$sval['menu_text'].'</a></li>';
		}
		$menu_code	.= (count($submenu) == 0 ? '</li>' : '</ul></li>');
		
	}

	$template	= str_replace('{footer_menu}', $menu_code, $template);
	return $template;
}

function getSubpageMenu($template, $page)	{
	$pageid	= getPageId($page);
	//$sql 	= "SELECT menu_text,page_alias FROM pages WHERE status='active' AND show_in_menu='yes' AND (menutype='sub' || menutype='both') AND parent_id='$pageid' ORDER BY sort_order";
	$sql 	= "SELECT menu_text,page_alias,content_type,external_url FROM pages WHERE status='active' AND show_in_menu='yes' AND (menutype='sub' || menutype='both') ORDER BY sort_order";
	$menu	= dbQuery($sql);
	foreach($menu as $val)	{
		$current	= ($val['page_alias'] == $page ? 'current-sub-menu-item' : '');
		$href		= ($val['content_type'] == 'external' ? $val['external_url'] :  ($val['page_alias'] == '' ? '#' : $val['page_alias'].'.html'));
		$target		= ($val['content_type'] == 'external' ? 'target="_blank"' :  '');		
		$menu_code	.= '<li class="'.$current.'"><a href="'.$href.'" '.$target.'>'.$val['menu_text'].'</a></li>';
	}
	$template	= str_replace('{sub_menu}', $menu_code, $template);
	return $template;
}

function getHeadMenu($template, $page)	{
	if($page!='home')
		$menu_code	.= '<ul class="list-inline pull-left">
							<li><a href="saverplaces.html"><span class="fa fa-home"></span> Home</a></li>
						</ul>';
	if($_SESSION['email'] != '' && $_SESSION['city_post'] != '' && $_SESSION['splash_screen'] != '')
		$complete_str	= '<li><a href="my-account.html" class="" style="color:#ffc600;"><span class="fa fa-user"></span> Please complete your registration</a></li>';
	
	if($_SESSION['email'] != '' && $_SESSION['city_post'] != '' && !$_SESSION[AUTH_PREFIX.'AUTH'])	{

		$menu_code		.= '<ul class="list-inline pull-right">
								<li><a href="sign-up-step-2.html" class="" style="color:#ffc600; cursor:default;"><span class="fa fa-user"></span> Please complete your registration</a></li>
								<li class="tb-signup">	
									<a href="sign-up-step-2.html" class=""><span class="fa fa-lock"></span> My Account</a>
								</li>	
							</ul>';
	}
					
	elseif(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
		$menu_code	.= '<ul class="list-inline pull-right">
							<li class="tb-signup">
								<a href="#" class="highlight" data-toggle="signup-dropdown"><span class="fa fa-lock"></span> Sign up</a>
								<div class="signup-dropdown">
									<h4>Sign Up</h4>
									<form action="sign-up-step-2.html" method="post" id="signupform">
										<input type="text" name="email" class="form-control required" placeholder="Email Address">
										<button class="btn btn-blue btn-block" type="submit">Sign up</button>
									</form>
									<p><small>By signing up, you accept our <a href="our-privacy-policy.html">Privacy Policy</a></small></p>
								</div>
							</li>
							<li><a href="#loginModal" data-toggle="modal" data-dismiss="modal" class="signIn"><span class="fa fa-lock"></span> Sign in</a></li>
						</ul>';
	}	
	else	{
		$my_page	= ($_SESSION['account_type'] == 'customer' ? 'my-account.html' : 'my-account-vendor.html');
		$details		= ($_SESSION['USER_PROFILE']['firstname'] == '' ? $_SESSION['USER_PROFILE']['email'] : $_SESSION['USER_PROFILE']['firstname'].' '.$_SESSION['USER_PROFILE']['lastname']);
		$menu_code	.= '<ul class="list-inline pull-right">
							'.$complete_str.'
							<li class="tb-signup">
								<a href="javascript:void(0);" class="" data-toggle="signup-dropdown"><span class="fa fa-lock"></span> '.$details.'</a>
								<div class="signup-dropdown">
									<a href="'.$my_page.'">My Account</a>
									<a href="logout.html" class="last">Sign Out</a>
								</div>
							</li>
							
						</ul>';
						

	}
	
	$template	= str_replace('{head_menu}', $menu_code, $template);
	return $template;
}



function getMobileHeadMenu($template, $page='')	{
	
	$sql 	= "SELECT id,menu_text,page_alias,content_type,external_url FROM pages WHERE status='active' AND show_in_menu='yes' AND (menutype='main' || menutype='both') AND parent_id='-1' ORDER BY sort_order";
	$menu	= dbQuery($sql);
	foreach($menu as $val)	{
		$current	= ($val['page_alias'] == $page ? 'current-menu-item' : '');
		$href		= ($val['content_type'] == 'external' ? $val['external_url'] :  ($val['page_alias'] == '' ? '#' : $val['page_alias'].'.html'));
		$target		= ($val['content_type'] == 'external' ? 'target="_blank"' :  '');
		$menu_code	.= '<li><a href="'.$href.'" '.$target.'>'.$val['menu_text'].'</a>';
		$sql 	= "SELECT menu_text,page_alias,content_type,external_url FROM pages WHERE status='active' AND show_in_menu='yes' AND (menutype='sub' || menutype='both') AND parent_id='{$val['id']}' ORDER BY sort_order";
		$submenu	= dbQuery($sql);
		$menu_code	.= (count($submenu) == 0 ? '' : '<ul>');
		foreach($submenu as $sval)	{
			$href		= ($sval['content_type'] == 'external' ? $sval['external_url'] :  ($sval['page_alias'] == '' ? '#' : $sval['page_alias'].'.html'));
			$target		= ($sval['content_type'] == 'external' ? 'target="_blank"' :  '');		
			$menu_code	.= '<li class="'.$current.'"><a href="'.$href.'" '.$target.'>'.$sval['menu_text'].'</a></li>';
		}
		$menu_code	.= (count($submenu) == 0 ? '</li>' : '</ul></li>');
		
	}
	$menu_code	.= (!$_SESSION[AUTH_PREFIX.'AUTH'] ? '<li><a href="#" data-toggle="modal" data-target="#loginModal">Sign In</a></li>' : '<li><a data-toggle="my-account-mobile" href="#">My Account</a>');
	
	$menu_code	.= (!$_SESSION[AUTH_PREFIX.'AUTH'] ? '' : '<ul class="my-account-mobile-menu"><li><a href="my-account.html">Profile</a></li><li><a href="request-list.html">My List</a></li><li><a href="logout.html">Logout</a></li></ul></li>');
	
	$template	= str_replace('{main_menu}', $menu_code, $template);
	return $template;
}

function getPageId($page)	{
	return dbQuery("SELECT id FROM pages WHERE page_alias='$page'",'singlecolumn');
}

function getFooter($template)	{
	$template	= str_replace('{footer}', FOOTER, $template);
	return $template;
}

function subPageContent($template)	{
	for($i=0; $i < 10; $i++):
		//title
		preg_match("/{page_title_?(.*)}/i",$template, $matches);
		@list($page,$strlen) = explode('_',$matches[1]);
		$needle	= '{page_title_'.$matches[1].'}';
		$sql	= "SELECT title_tag FROM pages WHERE page_alias='$page'";
		$cnt	= dbQuery($sql, 'singlecolumn');
		$template	= str_replace($needle, $cnt, $template);
		
		//contents
		preg_match("/{subContent_?(.*)}/i",$template, $matches);
		@list($page,$strlen) = explode('_',$matches[1]);
		$cnt	= getPageContents($page);
		$needle	= '{subContent_'.$matches[1].'}';
		$template	= str_replace($needle, $cnt, $template);
	endfor;
	return $template;
}

function subPageDynamicContent($template)	{
	for($i=0; $i < 10; $i++):
		//dynamic contents
		preg_match("/{dynamicContent_?(.*)}/i",$template, $matches);
		list($page,$strlen) = explode('_',$matches[1]);
		$needle	= '{dynamicContent_'.$matches[1].'}';
		$dPage = "_pages/".$page.".php";
		$template	= str_replace($needle, '<?php include "'.$dPage.'"; ?>', $template);

	endfor;
	return $template;
}

function getContactDetails($template, $page)	{
	$template	= str_replace('{phone}', PHONE_NUMBER, $template);
	$template	= str_replace('{fax}', FAX, $template);
	$template	= str_replace('{email}', EMAIL, $template);
	$template	= str_replace('{address}', nl2br(ADDRESS), $template);
	$template	= str_replace('{twitter}', TWITTER, $template);
	$template	= str_replace('{facebook}', FACEBOOK, $template);
	$template	= str_replace('{gplus}', GOOGLEPLUS, $template);
	$template	= str_replace('{linkedin}', LINKEDIN, $template);
	$template	= str_replace('{map}', MAP, $template);
	
	//business
	if(!empty($_REQUEST['code']))	{
		$business_id	= dbQuery("SELECT id FROM franchises WHERE vendor='{$_REQUEST['code']}'", 'singlecolumn');
		$template		= str_replace('{business_email}', getFieldValue($business_id, 'email', 'franchises'), $template);
		$template		= str_replace('{business_phone}', getFieldValue($business_id, 'phone', 'franchises'), $template);
		
		$template		= str_replace('{business_title}', '<title>'.getFieldValue($business_id, 'vendor', 'franchises').' Offers and Discount Codes - Saverplaces.co.uk</title>', $template);
		
		$template		= str_replace('{business_meta_description}', '<meta name="description" content="The latest '.getFieldValue($business_id, 'vendor', 'franchises').' discount codes, offers and vouchers. Download free '.getFieldValue($business_id, 'vendor', 'franchises').' discount codes or offers today to save money at '.getFieldValue($business_id, 'vendor', 'franchises').'" />', $template);
		
	}
		
	return $template;
}

function getRequestList($template)	{
	if($_SESSION[AUTH_PREFIX.'AUTH'])
		$request_list	= dbQuery("SELECT * FROM customers_request WHERE customers_id='{$_SESSION['USER_PROFILE']['id']}'");
	else
		$request_list	= dbQuery("SELECT * FROM customers_request WHERE customers_id='{$_SESSION['tmp_profile_id']}'");	
	foreach($request_list as $val)	{
		
		$ret	.= '<div class="alert alert-info alert-dismissible fade show" role="alert">
						<button id="'.$val['franchise_id'].'" type="button" class="close removereqlist" data-dismiss="alert"><span>&times;</span></button>
						'.getFieldValue($val['franchise_id'],'vendor','franchises').'
					</div>';					
	}
	
	/*if(count($request_list) == 0)
		$ret	= "add to your request list by selecting franchises";	*/
		
	$template		= str_replace('{request_list}', $ret, $template);
	return $template;
}

function insertHomePageContents($contents, $page='')	{
	
	//Business section
	if($page == 'home')	{
	
		$promoted_business_home	= getPromotedBusinessHome();
		$contents				= str_replace('{promoted_business_home}', $promoted_business_home, $contents);
		
		$featured_business_home	= getFeaturedBusinessHome();
		$contents				= str_replace('{featured_business_home}', $featured_business_home, $contents);
		
		$subscription_home	= getSubscriptionBoxHome();
		$contents				= str_replace('{subscription_home}', $subscription_home, $contents);
		
		$categories_home	= getCategoriesHome();
		$contents			= str_replace('{categories_home}', $categories_home, $contents);
		
		$categories_list_home	= getCategoriesListHome();
		$contents				= str_replace('{categories_list_home}', $categories_list_home, $contents);
	}
		
	$featured_business	= getFeaturedBusiness();
	$contents			= str_replace('{featured_business}', $featured_business, $contents);
	
	$search_hero		= getSearchHero();
	$contents			= str_replace('{search_hero}', $search_hero, $contents);
	
	
	return $contents;
}

function insertPageContents($contents)	{
	return $contents;
}

function getPricerangeUrls($priceRange) {
    $pricerangeUrl	= dbQuery("SELECT url_title FROM franchise_pricerange WHERE pricerange LIKE '%{$priceRange}%' AND status='active'", 'singlecolumn');
    
    return $pricerangeUrl;
}

function getLifestyleCatogoryUrls($lifestyleVal) {
    $lifestyleUrl	= dbQuery("SELECT url_title FROM franchise_lifestyle WHERE lifestyle ='{$lifestyleVal}' AND status='active'", 'singlecolumn');
    
    return $lifestyleUrl;
}

function getPricerangeUrlsWithPattern($pattern) {
    $pricerangeUrlWithPattern	= dbQuery("SELECT url_title FROM franchise_pricerange WHERE pricerange LIKE '%{$pattern}%' AND status='active'", 'singlecolumn');
    
    return $pricerangeUrlWithPattern;
}
?>