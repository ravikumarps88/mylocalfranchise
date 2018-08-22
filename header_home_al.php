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
                            <li><a href="search.html?filter=newest">New Franchises</a></li>
                            <li><a href="search.html?lifestyle=15">Low-Cost Franchises</a></li>
                            <li><a href="search.html?lifestyle=14">Top Franchises</a></li>
                            <li><a href="search.html?lifestyle=7">Part-time Franchises</a></li>
                            <!--<li><a href="search.html?lifestyle=16">Van Based Franchises</a></li>-->
                            <li><a href="search.html?lifestyle=1">Home-Based Franchises</a></li>
                            <li><a href="search/a">Franchise Directory A-Z</a></li>
                        </ul>
                    </li>
                    <li><a href="industries.html">Industries</a></li>
                    <li class="dropdown"><a href="javascript:void(0);">Investment <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                        <ul>
                            <li><a href="search.html?price_range[]=0-10k&lifestyle=9">Less than &pound;10,000</a></li>
                            <li><a href="search.html?price_range[]=10-30k&lifestyle=10">&pound;10,000 to &pound;30,000</a></li>
                            <li><a href="search.html?price_range[]=30-50k&lifestyle=11">&pound;30,000 to &pound;50,000</a></li>
                            <li><a href="search.html?price_range[]=50-75k&lifestyle=12">&pound;50,000 to &pound;75,000</a></li>
                            <li><a href="search.html?price_range[]=75k+&lifestyle=13">More than &pound;75,000</a></li>
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

<button class="secondary-menu-btn">
    I'm looking for <i class="fa fa-chevron-down" aria-hidden="true"></i>
</button><!-- .secondary-menu-btn -->
<div class="secondary-menu">
    <div class="container">
        <ul id="load_franchise_categs">
            <li><a href="/industries.html" class="active">Search by Industry</a></li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>
            <li>
            	<div class="loading-link-item"><div class="animated-background"></div>
                </div>
            </li>

            <li class="more"><a href="industries.html">&hellip;</a></li> <!-- Maybe make this a button and not a link and make it expand the container and show all the links above on multiple lines in the menu.  -->
        </ul>
    </div><!-- .container -->
</div><!-- .secondary-menu -->
