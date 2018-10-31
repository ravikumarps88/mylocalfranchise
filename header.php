<div class="site-header" id="theTop">
    <div class="container">
        <div class="row align-items-center">
            <button class="menu-btn"><i class="fa fa-bars"></i></button>
            <div class="col site-logo">
                <a href="/"><img src="img/logo.svg" alt="logo"></a>
            </div><!-- .col . site-logo-->
            <div class="col site-search">
                <form action="search.html">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input type="text" name="keyword" value="<?=$_REQUEST['keyword']?>" placeholder="Search e.g. work from home">
                    <button type="submit" class="sb"><i class="fa fa-long-arrow-right"></i></button>
                </form>
            </div><!-- .col .site-search -->
            <div class="col top-menu">
                <ul>
                    <li class="dropdown"><a href="javascript:void(0);">Popular Searches <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                        <ul>
                            <li><a href="/search.html?filter=newest">New Franchises</a></li>
                            <li><a href="/low-cost-franchise/">Low-Cost Franchises</a></li>
                            <li><a href="/best-franchises-uk/">Top Franchises</a></li>
                            <li><a href="/part-time-franchise/">Part-time Franchises</a></li>
                            <li><a href="/van-based-franchise/">Van Based Franchises</a></li>
                            <li><a href="/home-based-franchise/">Home-Based Franchises</a></li>
                            <li><a href="/uk-franchise-directory/">Full Franchise Directory</a></li>
                        </ul>
                    </li>
                    <li><a href="industries.html">Industries</a></li>
                    <li class="dropdown"><a href="javascript:void(0);">Investment <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                        <ul>
                            <li><a href="/franchise-under-10k/">Less than &pound;10,000</a></li>
                            <li><a href="/franchise-under-20k/">Less than &pound;20,000</a></li>
                            <li><a href="/franchise-under-30k/">Less than &pound;30,000</a></li>
                            <li><a href="/franchise-under-40k/">Less than &pound;40,000</a></li>
                         <li><a href="/franchise-under-50k/">Less than &pound;50,000</a></li>
                            <li><a href="/franchise-under-100k/">Between 50K & 100K</a></li>
                         <li><a href="/franchise-over-100k/">Over 100K</a></li>
                        </ul>
                    </li>
                    <li><a href="/news/">News & Advice</a></li>
                    <!-- IF user not logged in -->
                    <?
					if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
                    ?>
	                    <li><a href="register.html" class="signup-btn">CREATE A FREE ACCOUNT</a></li>
    	                <li style="display:inherit;"><a href="sign-in.html">Sign In</a></li>
					<?
					}
                    ?>
                    <!-- ENDIF -->
                    <!-- IF user not logged in --> <!-- Currently using CSS to hide this -->
                    <?
					if($_SESSION[AUTH_PREFIX.'AUTH'])	{
                    ?>
                        <li class="dropdown" style="display:inherit;"><a href="javascript:void(0);">My Account <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <ul>
                                <li><a href="my-account.html">Profile</a></li>
                                <li><a href="request-list.html">My List</a></li>
                                <li><a href="logout.html">Logout</a></li>
                            </ul>
                        </li>
                    <?
					}
                    ?>
                    <!-- ENDIF -->
                </ul>
            </div><!-- .col .top-menu -->
            <button class="search-btn"><i class="fa fa-search"></i></button>
        </div><!-- .row .align-items-center -->
        <div class="mobile-site-search"></div><!-- .mobile-site-search -->
    </div><!-- .container -->
    <nav class="mobile-top-menu"></nav><!-- .mobile-top-menu -->
</div><!-- .site-header -->
