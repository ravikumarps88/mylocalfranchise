<?
if($page == 'register')	{
?>
<header id="rst-header">

    <!-- Header banner -->
    <div class="rst-header-banner rst-banner-normal">

        <!-- Menu bar -->
        <div class="rst-header-menu-bar">
            <div class="container">
                <div class="rst-header-logo">
                    <button class="rst-menu-trigger">
                        <span>Toggle navigation</span>
                    </button>
                    <a href="index.html"><img src="images/logo-sticky.png" alt=""></a>
                    <a class="rst-logo-sticky" href="index.html"><img src="images/logo-sticky.png" alt=""></a>
                </div>
                <nav class="rst-header-menu">
                    <ul>
                        <?=getMainMenu('{main_menu}')?>
                    </ul>
                    <form class="sign-in-dropdown" style="display:none" action="sign-in.html" method="post">
                        <a href="fbconfig.php" class="connect-facebook-btn"><i class="fa fa-facebook" aria-hidden="true"></i> Connect with Facebook</a>
                        <div class="or-seperator"><span>or</span></div>
                        <input type="email" name="email" id="login-email" class="text required email" placeholder="Email">
                        <input type="password" name="password" id="login-password" class="text required" placeholder="Password">
                        <input type="submit" name="action" value="sign in">
                        <input type="checkbox" name="remember"> Remember me
                        <p><a href="forgot_password.html">Forgot your password?</a><br>
                        Don't have an account? <a href="register.html">Sign Up</a></p>
                        <a class="rst-form-close" href="#"><i class="fa fa-times"></i></a>
                    </form>
                    <div class="my-account-dropdown" style="display:none">
                        <ul>
                            <li><a href="my-account.html">Profile</a></li>
                            <li><a href="request-list.html">My List</a></li>
                            <li><a href="logout.html">Logout</a></li>
                        </ul>
                    </div>
                </nav>
                <div class="clear"></div>
            </div>
        </div>
        <!-- Menu bar -->

        <!-- Banner content -->
        <div class="rst-banner-content">
            <div class="container">
                <div class="">
                    <h5>Make your Support</h5>
                	<h1>Register Free</h1>
                </div>
                <div class="rst-back-post">
                    <a href="home.html"><i class="fa fa-long-arrow-left"></i>back</a>
                </div>
            </div>
        </div>
        <!-- Banner content -->

    </div>
    <!-- Header banner -->

</header>

<?
}
else	{
?>

<header id="rst-header">

    <!-- Header banner -->
    <div class="rst-header-banner rst-banner-background rst-banner-2">

        <!-- Menu bar -->
        <div class="rst-header-menu-bar">
            <div class="container">
                <div class="rst-header-logo">
                    <button class="rst-menu-trigger">
                        <span>Toggle navigation</span>
                    </button>
                    <a href="index.html"><img src="images/logo-sticky.png" alt=""></a>
                    <a class="rst-logo-sticky" href="index.html"><img src="images/logo-sticky.png" alt=""></a>
                </div>
                <nav class="rst-header-menu">
                    <ul>
                        <?=getMainMenu('{main_menu}')?>
                    </ul>
                    <form class="sign-in-dropdown" style="display:none" action="sign-in.html" method="post">
                        <a href="#" class="connect-facebook-btn"><i class="fa fa-facebook" aria-hidden="true"></i> Connect with Facebook</a>
                        <div class="or-seperator"><span>or</span></div>
                        <input type="email" name="email" id="login-email" class="text required email" placeholder="Email">
                        <input type="password" name="password" id="login-password" class="text required" placeholder="Password">
                        <input type="submit" name="action" value="sign in">
                        <input type="checkbox" name="remember"> Remember me
                        <p><a href="forgot_password.html">Forgot your password?</a><br>
                        Don't have an account? <a href="register.html">Sign Up</a></p>
                        <a class="rst-form-close" href="#"><i class="fa fa-times"></i></a>
                    </form>
                    <div class="my-account-dropdown" style="display:none">
                        <ul>
                            <li><a href="my-account.html">Profile</a></li>
                            <li><a href="request-list.html">My List</a></li>
                            <li><a href="logout.html">Logout</a></li>
                        </ul>
                    </div>
                </nav>
                <div class="clear"></div>
            </div>
        </div>
        <!-- Menu bar -->

        <!-- Banner content -->
        <div class="rst-banner-content">
            <div class="container">
                <div class="row">

                    <?
					if($page == 'franchise_details')	{
						$_REQUEST['id']	= dbQuery("SELECT id FROM franchises WHERE vendor='{$_SESSION['code']}'", 'singlecolumn');
						$category_id	= getFieldValue($_REQUEST['id'],'category_id','franchises');
                    ?>
                    <div class="col-md-6 franchise-profile-header-left">
                        <h1><?=getFieldValue($_REQUEST['id'],'vendor','franchises')?></h1>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="search.html?category_id=<?=getParentId($category_id) == 0 ? $category_id : getParentId($category_id)?>"><?=getParentId($category_id) == 0 ? getFieldValue($category_id,'category','franchise_categories') : getFieldValue(getParentId($category_id),'category','franchise_categories')?></a></li>
                                <li><a href="search.html?category_id=<?=$category_id?>"><?=getParentId($category_id) == 0 ? '' : getFieldValue($category_id,'category','franchise_categories')?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 franchise-profile-header-right">
                        <div class="franchise-buttons">
                            <a href="#contactForm" class="btn btn-default scroll-to">Send Info</a>
                            <a href="javascript:void(0);" class="btn btn-default add_request_list" id="<?=$_REQUEST['id']?>"><i class="fa <?=customerRequestExist($_REQUEST['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'fa-heart-o' : 'fa-heart'?>"></i></a>
                        </div>
                    </div>

                    <?
					}
					else	{
                    ?>
                    	<div class="text-center">
                            <h1><?=getSEOTags($page, '{page_title}')?></h1>
                        </div>
                    <?
					}
                    ?>

                </div>
            </div>
        </div>
        <!-- Banner content -->

    </div>
    <!-- Header banner -->

</header>

<?
}
?>