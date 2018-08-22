<?
require "../lib/app_top_admin.php";

$authFlag = authenticateAdmin();

$page = ($_GET['_page']!="" ? $_GET['_page'] : "home");
$page = ($authFlag==false ? "login" : ($_GET['_page']=="" && $_SESSION[AUTH_PREFIX.'SUPERADMIN_AUTH'] ? "home" : $page) );
$contentPage = "_pages/{$page}.php";
if ( ! file_exists($contentPage) ) {
	$contentPage = "_pages/404.php";
}

$displayMenu = ($authFlag ? true : false);

switch($page) {
	case "login": $pageHeading = "Login"; break;
	case "manage-pages": $pageHeading = "Manage Pages";	break;
	case "add_edit_pages": $pageHeading = "Add/Edit Pages"; break;
	case "manage-events": $pageHeading = "Manage Events"; break;
	case "add_edit_events": $pageHeading = "Add/Edit Events"; break;
	
	case "manage-images": $pageHeading = "Manage Images"; break;
	case "add_edit_images": $pageHeading = "Add/Edit Images"; break;
	
	case "settings": $pageHeading = "Manage Settings"; break;
	
	case "manage-templates": $pageHeading = "Manage Templates"; break;
	case "add_edit_templates": $pageHeading = "Add/Edit Templates"; break;
	case "manage-css": $pageHeading = "Manage CSS"; break;
	case "add_edit_css": $pageHeading = "Add/Edit CSS"; break;
	case "add_css": $pageHeading = "Add/Edit CSS Association to Templates"; break;
	
	case "users": $pageHeading = "Manage Users";	break;
	case "add_edit_users": $pageHeading = "Add/Edit Users";	break;
	
	case "customers": $pageHeading = "Manage Customers";	break;
	case "add_edit_customers": $pageHeading = "Add/Edit Customers";	break;

	case "manage-slideshow": $pageHeading = "Manage Slideshow";	break;
	case "add_edit_slideshow": $pageHeading = "Add/Edit Slideshow";	break;

	case "manage-gallery": $pageHeading = "Manage Gallery : ".ucfirst($_REQUEST['category']); break;
	case "add_edit_gallery": $pageHeading = "Add/Edit Gallery"; break;	
	
	case "manage-portfolio": $pageHeading = "Manage Portfolio"; break;
	case "add_edit_portfolio": $pageHeading = "Add/Edit Portfolio"; break;	
	
	case "changePassword": $pageHeading = "Change Password"; break;
	default: $pageHeading = ucwords(preg_replace(array('/-/', '/_/'),' ',$page)); break;
}
$pageHeading = "$pageHeading";

$action 	= ($_REQUEST['action']!="" ? $_REQUEST['action'] : "list");
$process 	= ($_REQUEST['process']!="" ? $_REQUEST['process'] : "no");

$statusShowArr	= array();
$statusShowArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusShowArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusShowArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusShowArr[]	= array("optionId"=>"all","optionText"=>"All");

$tmps	= getTemplates();
$pages	= getPages($_SESSION[AUTH_PREFIX.'SUPERADMIN_AUTH']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />
	
	<title><?=he(SITE_NAME)?> Administration</title>
	
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.0.min.js"></script>

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
</head>

<? if ($displayMenu) { ?>	

<body class="page-body" >

<div class="page-container horizontal-menu"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->	
	<header class="navbar">

		<div class="navbar-inner">
			
			
			<!-- logo -->
			<div class="navbar-brand">
				<a href="index.php">
					<img src="../images/Logo-Icon.png">
				</a>
			</div>
			
						<!-- logo collapse icon -->
						
			
		
				
		<ul class="navbar-nav">
			<!-- add class "multiple-expanded" to allow multiple submenus to open -->
			<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
			<!-- Search Bar -->
             <li <?=$page=='home' ? 'class="opened active"' : ''?>>
                    <a href="index.php?_page=home">
                    
                    	<span class="title"> Home</span>
                    </a>
                    
                </li>
            
			<? if ($_SESSION[AUTH_PREFIX.'SUPERADMIN_AUTH']) { ?>            	
               
                
                <li <?=$page=='manage-templates' || $page=='add_edit_templates' ? 'class="opened active"' : ''?>>
                    
                    <a href="index.php?_page=manage-templates">
                    	
                    	<span class="title">Templates</span>
                    </a>
                    <ul>
                        <li <?=$page=='manage-templates' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=manage-templates">Manage Templates</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_templates' && empty($_REQUEST['id']) ? 'class="active"' : ''?>>
                            <a href="index.php?_page=add_edit_templates">Add Template</a>									
                        </li>
                        
                        <?foreach($tmps as $val)	{?>
                            <li <?=$page=='add_edit_templates' && $val['id'] == $_REQUEST['id']  ? 'class="active"' : ''?>>
                                <a href="index.php?_page=add_edit_templates&action=edit&id=<?=$val['id']?>"><?=$val['tmp_name']?></a>
                            </li>
                        <?}?>
                    </ul>
                </li>
                
                <li <?=$page=='manage-css' || $page=='add_edit_css' ? 'class="opened active"' : ''?>>
                    
                    <a href="index.php?_page=manage-css">
                    	
                    	<span class="title">CSS</span>
                    </a>
                    <ul>
                        <li <?=$page=='manage-css' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=manage-css">Manage CSS</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_css' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=add_edit_css">Add CSS</a>									
                        </li>
                        
                    </ul>
                </li>
               
                <li <?=$page=='' || $page=='add_edit_pages' || $page=='manage-pages' ? 'class="opened active"' : ''?>>
                    
                    <a href="index.php">
                    
                    	<span class="title">Pages</span>
                    </a>
                    
                    <ul>
                        <li <?=$page=='manage-pages' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=manage-pages">Manage Pages</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_pages' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=add_edit_pages">Add New Page</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_pages' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=manage-pages&content_type=content">Non-dynamic Pages</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_pages' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=manage-pages&content_type=dynamic">Dynamic Pages</a>									
                        </li>
                        
                    </ul>
                </li>
                
                <li <?=$page=='manage-images' || $page=='add_edit_images' ? 'class="opened active"' : ''?>>
                    
                    <a href="index.php?_page=manage-images">
                    	
                    	<span class="title">Images</span>
                    </a>
                    
                    <ul>
                        <li <?=$page=='manage-images' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=manage-images">Manage Images</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_images' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=add_edit_images">Add Image</a>									
                        </li>
                    </ul>
                </li>

                
                <li <?=$page=='users' || $page=='add_edit_users' ? 'class="opened active"' : ''?>>
                    <a href="index.php?_page=users">
                    	
                    	<span class="title">Users</span>
                    </a>
                    
                    <ul>
                        <li <?=$page=='users' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=users">Manage Users</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_users' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=add_edit_users">Add user</a>									
                        </li>
                    </ul>
                </li>
                
                <li <?=$page=='customers' || $page=='add_edit_customers' ? 'class="opened active"' : ''?>>
                    
                    <a href="index.php?_page=customers">
                    	
                    	<span class="title">Customers</span>
                    </a>
                    
                    <ul>
                        <li <?=$page=='customers' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=customers">Manage Customers</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_customers' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=add_edit_customers">Add Customer</a>									
                        </li>
                    </ul>
                </li>
                
                <? } ?> 
                
                <li <?=$page=='franchises' || $page=='add_edit_franchise' ? 'class="opened active"' : ''?>>
                    
                    <a href="index.php?_page=franchises">	
                    
                    	<span class="title">Franchises</span>
                    </a>
                    
                    <ul>
                        <li <?=$page=='franchises' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=franchises">Manage Franchises</a>									
                        </li>
                        
                    
                        <li <?=$page=='add_edit_franchise' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=add_edit_franchise">Add Franchise</a>									
                        </li>
                        
                    </ul>
                </li>
                
                    
                
                

			<?                                        
			if ($_SESSION[AUTH_PREFIX.'SUPERADMIN_AUTH']) { 
			?>                                  
                <li <?=$page=='settings' || $page=='changePassword' || $page=='franchise_categories' || $page=='add_edit_franchise_categories' || $page=='edit_profile' ? 'class="opened active"' : ''?>>
                   
                    <a href="index.php?_page=settings&type=user">
                    
                    	<span class="title">Settings</span>
                    </a>
                    
                    <ul>
                        <li <?=$page=='franchise_categories' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=search_filter">Search Filter</a>									
                        </li>
                        <li <?=$page=='franchise_categories' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=franchise_categories">Franchise Categories</a>									
                        </li>
                        
                        <li <?=$page=='add_edit_franchise_categories' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=add_edit_franchise_categories">Add Franchise Categories</a>									
                        </li>
                        
                        <li <?=$page=='manage-lifestyles' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=manage-lifestyles">Lifestyles</a>									
                        </li>
                        
                        <li <?=$page=='settings' && $_REQUEST['type']=='user' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=settings&type=user">User Settings</a>									
                        </li>
                        
                        <li <?=$page=='settings' && $_REQUEST['type']=='system' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=settings&type=system">System Settings</a>									
                        </li>
    
                        <li <?=$page=='edit_profile' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=edit_profile">Edit Profile</a>									
                        </li>    

                        <li <?=$page=='changePassword' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=changePassword">Change Password</a>									
                        </li>
                        
                    </ul>
                </li>
			<? } elseif($_SESSION[AUTH_PREFIX.'ADMIN_AUTH'])	{?>                                    
                    <li <?=$page=='changePassword' || $page=='edit_profile' ? 'class="opened active"' : ''?>>
                    <a href="index.php?_page=changePassword">
                  
                    <span class="title">Settings</span></a>
                    <ul>
                        <li <?=$page=='edit_profile' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=edit_profile">Edit Profile</a>									
                        </li>
                        
                        <li <?=$page=='changePassword' ? 'class="active"' : ''?>>
                            <a href="index.php?_page=changePassword">Change Password</a>									
                        </li>
                    </ul>
                </li>
			<? }?>
		</ul>
				

	
		

	<ul class="nav navbar-right pull-right"> 
	
	<!-- Raw Links -->
	
			
			<li class="sep"></li>
			
			<li>

				<a href="index.php?_page=logout" onClick="return confirm ('Are you sure you want to logout?');" class="alinkcolor">
					Log Out <i class="entypo-logout right"></i>
				</a>
			</li>
	</ul>
    
    <!-- logo collapse icon -->
						
			
		
		
</div>
</header>

<div class="main-content">
  <div class="container">

	<div class="row">
		<div class="col-md-9 col-sm-7">
			<h2><?=$pageHeading?></h2>
		</div>
	</div>

<? include $contentPage; ?>
  </div>

	<!-- Footer -->
<footer class="main">
	
		
	<p class="text-center">Franchise local</a> &copy; <?=date('Y')?> All rights reserved. </p>
	
</footer>
  
</div>
</div>

  
	

	<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">
    <link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">
    <link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
    <link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="assets/js/jcrop/jquery.Jcrop.min.css">
    <link rel="stylesheet" href="assets/js/wysihtml5/bootstrap-wysihtml5.css">

	<!-- Bottom Scripts -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
    <script src="assets/js/jquery.bootstrap.wizard.min.js"></script>
    
    <script src="assets/js/wysihtml5/wysihtml5-0.4.0pre.min.js"></script>
	<script src="assets/js/wysihtml5/bootstrap-wysihtml5.js"></script>
	<script src="assets/js/ckeditor/ckeditor.js"></script>
	<script src="assets/js/ckeditor/adapters/jquery.js"></script>
    
    <script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/datatables/TableTools.min.js"></script>
	<script src="assets/js/dataTables.bootstrap.js"></script>
	<script src="assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
	<script src="assets/js/datatables/lodash.min.js"></script>
	<script src="assets/js/datatables/responsive/js/datatables.responsive.js"></script>
    <script src="assets/js/select2/select2.min.js"></script>
    
    <script src="assets/js/jquery.inputmask.bundle.min.js"></script>
	<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
	<script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/daterangepicker/moment.min.js"></script>
    <script src="assets/js/daterangepicker/daterangepicker.js"></script>
	<script src="assets/js/bootstrap-switch.min.js"></script>
	<script src="assets/js/jquery.multi-select.js"></script>
    <script src="assets/js/jcrop/jquery.Jcrop.min.js"></script>
    
	<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="assets/js/jquery.sparkline.min.js"></script>
	<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/morris.min.js"></script>
	<script src="assets/js/toastr.js"></script>
	<script src="assets/js/neon-chat.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>
    <script src="assets/js/jquery.bootstrap.wizard.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    
    
    <!-- image upload script -->
    <link rel="stylesheet" href="css/fileuploader.css">
    <script type="text/javascript" src="js/fileuploader.js"></script>
    
    <script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
    
    <script language="javascript">
	
	var responsiveHelper;
	var breakpointDefinition = {
		tablet: 1024,
		phone : 480
	};
	var tableContainer;

	jQuery(document).ready(function($)
		{
			show_loading_bar(100);
			
			function displayMessages(msg,err_msg,warning_msg) {
				if(msg!="") {
					toastr.success(msg);
				}
				
				if(err_msg!="") {
					toastr.error(err_msg);
				}
				
				if(warning_msg!="") {
					toastr.warning(warning_msg);
				}
			}
			displayMessages('<?=$INFO_MSG?>','<?=$ERR_MSG?>','<?=$WARNING_MSG?>');
			
			
			
			
			tableContainer = $("#table-1");
		
			tableContainer.dataTable({
				"sPaginationType": "bootstrap",
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true,
				
	
				// Responsive Settings
				bAutoWidth     : false,
				fnPreDrawCallback: function () {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper) {
						responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
					}
				},
				fnRowCallback  : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
					responsiveHelper.createExpandIcon(nRow);
				},
				fnDrawCallback : function (oSettings) {
					responsiveHelper.respond();
				}
			});
			
			$(".dataTables_wrapper select").select2({
				minimumResultsForSearch: -1
			});
			
			
			$("#table-2").dataTable({
				"sPaginationType": "bootstrap",
				"sDom": "t<'row'<'col-xs-6 col-left'i><'col-xs-6 col-right'p>>",
				"bStateSave": false,
				"iDisplayLength": 15,
				"ordering": false,
				"aoColumns": [
					{ "bSortable": false },
					{ "bSortable": false },
					null,
					null,
					null,
					null
				],
				"columnDefs": [
				{
					"targets": [ 0 ],
					"visible": false,
					"searchable": false
				}]
			});
			
		});		
	</script>


<!-- Modal 7 (Ajax Modal)-->
<div class="modal fade" id="modal-7">
	<div class="modal-dialog" style="width:850px;">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Close">&times;</button>
                <h4 class="modal-title">Add / Edit Vouchers</h4>
			</div>
			
			<div class="modal-body">
			
				Content is loading...
				
			</div>
			<div id="voucher_preview"></div>
		</div>
	</div>
    
</div> 


</body>
<? } else { ?>
	<? include $contentPage; ?>
<? } ?>	
</html>
