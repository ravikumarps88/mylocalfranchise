<?php
require "lib/app_top.php";

if(preg_match("/.html/",$_REQUEST['_page']) || $_REQUEST['_page']=='')	{
	$_REQUEST['_page']	= str_replace('.html','',$_REQUEST['_page']);	
	if($_REQUEST['_page'] == 'home') header('Location:'.APP_URL);
	if($_REQUEST['_page'] == 'index') header('Location:'.APP_URL);
	$_SESSION['code']	= $_SESSION['industries'] = $_SESSION['letter'] = '';
	if($_REQUEST['lifestyle'] !='')
		$_SESSION['lifestyle'] = $_REQUEST['lifestyle'];
}
elseif($_REQUEST['_page'] == 'advertise')	{
	$_REQUEST['_page']	= 'advertise';		
}
elseif($_REQUEST['_page'] == 'enquiry_sent')	{
	$_REQUEST['_page']	= 'enquiry_sent';		
}
elseif($_REQUEST['_page'] == 'industries' || $_REQUEST['_page'] == 'industries/')	{
	$_REQUEST['_page']	= 'industries';		
}	
else	{	
	$_SESSION['code']	= $_REQUEST['_page'];
	//Page redirects
	if($_SESSION['code'] == 'SlidingSashSolutions')  header('Location:'.APP_URL.'/Sliding-Sash-Solutions', true, 301);
	if($_SESSION['code'] == 'TimeForYou')  header('Location:'.APP_URL.'/time-for-you', true, 301);
	if($_SESSION['code'] == 'ClarriotsCare')  header('Location:'.APP_URL.'/clarriots-care', true, 301);
	if($_SESSION['code'] == 'LanguageForFun')  header('Location:'.APP_URL.'/language-for-fun', true, 301);
	if($_SESSION['code'] == 'GreenCleen')  header('Location:'.APP_URL.'/green-cleen', true, 301);
	if($_SESSION['code'] == 'AddALittleSparkle')  header('Location:'.APP_URL.'/add-a-little-sparkle', true, 301);
	if($_SESSION['code'] == 'Dor2Dor')  header('Location:'.APP_URL.'/dor2dor', true, 301);
	if($_SESSION['code'] == 'MrElectric')  header('Location:'.APP_URL.'/mr-electric', true, 301);
	if($_SESSION['code'] == 'MerryMaids')  header('Location:'.APP_URL.'/merry-maids', true, 301);
	if($_SESSION['code'] == 'ThomasCleaning')  header('Location:'.APP_URL.'/thomas-cleaning', true, 301);
	if($_SESSION['code'] == 'SpeedyFreight')  header('Location:'.APP_URL.'/speedy-freight', true, 301);
	if($_SESSION['code'] == 'RosemaryBookkeeping')  header('Location:'.APP_URL.'/rosemary-bookkeeping', true, 301);
	if($_SESSION['code'] == 'OvenWizards')  header('Location:'.APP_URL.'/oven-wizards', true, 301);
	if($_SESSION['code'] == 'AdditionalResources')  header('Location:'.APP_URL.'/additional-resources', true, 301);
	if($_SESSION['code'] == 'HomeInsteadSeniorCare')  header('Location:'.APP_URL.'/home-instead-senior-care', true, 301);
	if($_SESSION['code'] == 'eds-garden')  header('Location:'.APP_URL.'/eds-garden-maintenance', true, 301);
	if($_SESSION['code'] == 'HeritageHealthcare')  header('Location:'.APP_URL.'/heritage-healthcare', true, 301);
	if($_SESSION['code'] == 'BrightBeautiful')  header('Location:'.APP_URL.'/bright-beautiful', true, 301);
	if($_SESSION['code'] == 'AmbienceVenueStyling')  header('Location:'.APP_URL.'/ambience-venue-styling', true, 301);
	
	
	
	
	if(dbQuery("SELECT COUNT(*) FROM franchises WHERE vendor_code='{$_SESSION['code']}' AND status='active'", 'count') == 0)	{
		if(preg_match("/search/",$_REQUEST['_page']))	{
			$_SESSION['letter']	= str_replace('search/','',$_REQUEST['_page']);
			$_REQUEST['_page']		= 'search';
			$_SESSION['code']		= '';	
			$_SESSION['industries']		= '';
		}
		elseif(preg_match("/industries/",$_REQUEST['_page']))	{
                    
			$_SESSION['industries']	= str_replace('industries/','',$_REQUEST['_page']);
			//var_dump($_SESSION['industries']);
			//Industry redirects			
			if($_SESSION['industries'] == 'Home-Improvment')  header('Location:'.APP_URL.'/industries/home-improvement-franchises', true, 301);
			if($_SESSION['industries'] == 'Business')  header('Location:'.APP_URL.'/industries/business-franchises', true, 301);
			if($_SESSION['industries'] == 'business')  header('Location:'.APP_URL.'/industries/business-franchises', true, 301);
			if($_SESSION['industries'] == 'Building-Maintenance')  header('Location:'.APP_URL.'/industries/building-maintenance-franchises', true, 301);
			if($_SESSION['industries'] == 'Events')  header('Location:'.APP_URL.'/industries/event-franchises', true, 301);
			if($_SESSION['industries'] == 'Computer')  header('Location:'.APP_URL.'/industries/computer-franchises', true, 301);
			if($_SESSION['industries'] == 'Pet')  header('Location:'.APP_URL.'/industries/pet-franchises', true, 301);
			if($_SESSION['industries'] == 'Automotive')  header('Location:'.APP_URL.'/industries/automotive-franchises', true, 301);
			if($_SESSION['industries'] == 'Cleaning')  header('Location:'.APP_URL.'/industries/cleaning-franchises', true, 301);
			if($_SESSION['industries'] == 'Care')  header('Location:'.APP_URL.'/industries/care-franchises', true, 301);
			if($_SESSION['industries'] == 'Children')  header('Location:'.APP_URL.'/industries/childrens-franchises', true, 301);
			if($_SESSION['industries'] == 'Education')  header('Location:'.APP_URL.'/industries/education-franchises', true, 301);
			if($_SESSION['industries'] == 'Food')  header('Location:'.APP_URL.'/industries/food-franchises', true, 301);
			if($_SESSION['industries'] == 'Photography')  header('Location:'.APP_URL.'/industries/photography-franchises', true, 301);
			if($_SESSION['industries'] == 'Retail')  header('Location:'.APP_URL.'/industries/retail-franchises', true, 301);
			if($_SESSION['industries'] == 'Beauty')  header('Location:'.APP_URL.'/industries/beauty-franchises', true, 301);
			if($_SESSION['industries'] == 'Health')  header('Location:'.APP_URL.'/industries/health-fitness-franchises', true, 301);
			if($_SESSION['industries'] == 'Leisure')  header('Location:'.APP_URL.'/industries/leisure-franchises', true, 301);
			if($_SESSION['industries'] == 'Property')  header('Location:'.APP_URL.'/industries/property-estate-agent-franchises', true, 301);
			if($_SESSION['industries'] == 'Signs-')  header('Location:'.APP_URL.'/industries/signs-printing-franchises', true, 301);
			if($_SESSION['industries'] == 'Sports-')  header('Location:'.APP_URL.'/industries/sports-fitness-franchises', true, 301);			
			if($_SESSION['industries'] == 'Legal-')  header('Location:'.APP_URL.'/industries/legal-finance-franchises', true, 301);
			if($_SESSION['industries'] == 'Mail-')  header('Location:'.APP_URL.'/industries/mail-courier-franchise', true, 301);	
		
			
			if(preg_match("/Flowers/",$_SESSION['industries']) && $_SESSION['industries']!='flowers-gifts-cards-franchise')  header('Location:'.APP_URL.'/industries/flowers-gifts-cards-franchise', true, 301);
			if(preg_match("/Caf/",$_SESSION['industries']) && $_SESSION['industries']!='cafe-coffee-franchises')  header('Location:'.APP_URL.'/industries/cafe-coffee-franchises', true, 301);
			if(preg_match("/Legal/",$_SESSION['industries']) && $_SESSION['industries']!='legal-finance-franchises')  header('Location:'.APP_URL.'/industries/legal-finance-franchises', true, 301);
			if(preg_match("/Building/",$_SESSION['industries']) && $_SESSION['industries']!='building-maintenance-franchises')  header('Location:'.APP_URL.'/industries/building-maintenance-franchises', true, 301);
			if(preg_match("/Personal/",$_SESSION['industries']) && $_SESSION['industries']!='personal-services-franchises')  header('Location:'.APP_URL.'/industries/personal-services-franchises', true, 301);
			if(preg_match("/Home/",$_SESSION['industries']) && $_SESSION['industries']!='home-improvement-franchises')  header('Location:'.APP_URL.'/industries/home-improvement-franchises', true, 301);
					
			//end
			
			$_REQUEST['_page']		= 'search';
			$_SESSION['code']		= '';	
			$_SESSION['letter']		= '';
		}
                elseif(in_array($_REQUEST['_page'], $customPriceRageUrls))	{
                    $_SESSION['code']	= $_SESSION['industries'] = $_SESSION['letter'] = '';
                    $_SESSION['pricerange']	= $_REQUEST['_page'];
                    
                    $_REQUEST['_page']		= 'search';
                    $_SESSION['code']		= '';	
                    $_SESSION['letter']		= '';
                }
		else	{
			$_REQUEST['_page']	= 'franchise_redirect';		
			$_SESSION['code']	= $_SESSION['industries'] = $_SESSION['letter'] = '';
		}	
	}	
	else	{	
		$_SESSION['industries']		= '';
		$_REQUEST['_page']	= 'franchise_details';	
	}	
}	

if(isset($_REQUEST['price_range']))
{
    $url = getPricerangeUrls($_REQUEST['price_range']);
    header('Location:'.APP_URL.'/'.$url, true, 301);
}
$page = ($_REQUEST['_page']!="" ? ($_REQUEST['_page']!="index" ? $_REQUEST['_page'] : "home") : "home");
    
$template	= getTemplate($page);

if ( empty($template) ) {
	define('CURRENT_PAGE', '404');
	$template	= getTemplate(CURRENT_PAGE);
}
else	{
	define('CURRENT_PAGE', $page);
	$template	= getTemplate(CURRENT_PAGE);
}

switch(getContentType(CURRENT_PAGE))	{
	case 'dynamic':
		$dynamicPage = "_pages/".CURRENT_PAGE.".php";
		$contentPage = "_pages/main.php";
		break;
		
	case 'content':
		$contentPage = "_pages/main.php";
		break;	
}

if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{ 
	$_SESSION['tmp_profile_id'] = empty($_SESSION['tmp_profile_id'])  ? rand(1000, 99999) :  $_SESSION['tmp_profile_id'];
}

//clear session logout if not logout page and logout variable empty
if(empty($_REQUEST['logout']) && $page != 'logout' && $page != 'home')
	unset($_SESSION['logout']);
	
//check cookie and enable auto login
if($_COOKIE['franchiselocal_remember'] == 'on' && empty($_SESSION[AUTH_PREFIX.'AUTH']) && empty($_SESSION['logout']) && $page != 'sign-up-step-2' && $page != 'sign-in') {
	authenticateUser($_COOKIE['franchiselocal_email'], $_COOKIE['franchiselocal_pwd'], 'customer');
}
///ends 

$price_range_arr_str = '';
if(in_array($_SESSION['pricerange'], $customPriceRageUrls)) {
    $price_val = dbQuery("SELECT pricerange FROM franchise_pricerange WHERE url_title LIKE '%{$_SESSION['pricerange']}%' AND status='active'", 'singlecolumn');
    $price_range_arr_str .= "&price_range=$price_val";
}

//replace content tags
$template	= str_replace('{content}','<?php include $contentPage; ?>', $template);
$template	= str_replace('{dynamic_content}','<?php include $dynamicPage; ?>', $template);
//echo CURRENT_PAGE;exit;
// replacing the tags
//echo $template;exit;
$template	= getSEOTags(CURRENT_PAGE, $template);
//echo $template;exit;
$template	= getGoogleAnalytics($template);
//$template	= getStyleSheets($template, CURRENT_PAGE);
$template	= getContactDetails($template, CURRENT_PAGE);

//insert page elements
//$template	= insertBreadCrumb($template, CURRENT_PAGE);
$template	= insertPageDetails($template, CURRENT_PAGE);
$template	= insertHomePageContents($template, CURRENT_PAGE);

//pagination elements
$template	= insertBlogElements($template, CURRENT_PAGE);

//menu management
//$template	= getMainMenu($template, CURRENT_PAGE);
//$template	= getFooterMenu($template, CURRENT_PAGE);
//$template	= getSubpageMenu($template, CURRENT_PAGE);
//$template	= getHeadMenu($template, CURRENT_PAGE);

$template	= getRequestList($template);

//set footer
//$template	= getFooter($template);
//$template	= subPageContent($template);

$template	= no_magic_quotes($template);

//displaying the template
echo @eval('?>' . $template . '<?');
?>