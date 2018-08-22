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
        <form action="search.html" method="get">
            <div class="rst-banner-content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-left">
                                <h5>Your Search Results for</h5>
                                <h1>“<?=$_REQUEST['keyword'] == '' ? getFieldValue($_REQUEST['category_id'], 'category','franchise_categories') : $_REQUEST['keyword']?>”</h1>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="rst-search-form rst-search">
                                <input type="text" placeholder="Search ..."  name="keyword">
                                <button type="submit"  class="sb"><i class="fa fa-long-arrow-right"></i></button>
                            </div>
                            <div class="rst-search-options-link"> More search options <i class="fa fa-angle-down"></i> </div>
                        </div>
                    </div>
                </div>
                <div class="rst-search-options-drop-down">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <p><strong>Price range</strong></p>
                                <div class="price-range">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="price_range[]" value="0-10k" <?=in_array('0-10k',$_REQUEST['price_range']) ? 'checked' : ''?>> 0-10k 
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="price_range[]" value="10-20k"  <?=in_array('10-20k',$_REQUEST['price_range']) ? 'checked' : ''?>> 10-20k
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="price_range[]" value="20-30k"  <?=in_array('20-30k',$_REQUEST['price_range']) ? 'checked' : ''?>> 20-30k
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="price_range[]" value="30-40k"  <?=in_array('30-40k',$_REQUEST['price_range']) ? 'checked' : ''?>> 30-40k
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="price_range[]" value="40-50k"  <?=in_array('40-50k',$_REQUEST['price_range']) ? 'checked' : ''?>> 40-50k
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="price_range[]" value="50-100k"  <?=in_array('50-100k',$_REQUEST['price_range']) ? 'checked' : ''?>> 50-100k
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="price_range[]" value="100k+"  <?=in_array('100k+',$_REQUEST['price_range']) ? 'checked' : ''?>> 100k+
                                    </label>
                                </div>
                                <p><strong>Recently added</strong></p>
                                <div class="recently-added">
                                    <label class="radio-inline">
                                    <input type="radio" name="filter" value="all">
                                    Show All </label>
                                    <label class="radio-inline">
                                    <input type="radio" name="filter" value="newest">
                                    Newest </label>
                                    <label class="radio-inline">
                                    <input type="radio" name="filter" value="oldest">
                                    Oldest </label>
                                </div>
                                <!--<p><strong>Add keywords</strong></p>
                                <div class="add-keywords">
                                    <div class="add-keywords-wrap">
                                        <input type="text" placeholder="Enter a keyword">
                                        <button type="button">Add</button>
                                    </div>
                                </div>
                                <div class="keyword-tags">
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                        Keyword 1
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                        Keyword 2
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                        Keyword 3
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                </div>-->
                            </div>
                            <div class="col-sm-6">
                            	<p><strong>By brand</strong></p>
                                <div class="">
                                    <select name="brand">
                                        <option value="" disabled selected>Select a Brand</option>
                                        <?=htmlOptions($franchiseArr, $_REQUEST['brand']);?>
                                    </select>
                                </div>
                                <p><strong>By lifestyle</strong></p>
                                <div class="">
                                    <select name="lifestyle">
                                        <option value="" disabled selected>Select a Lifestyle</option>
                                        <?=htmlOptions($lifeStyleArr, $_REQUEST['lifestyle']);?>
                                    </select>
                                </div>
                                <p><strong>By category</strong></p>
                                <div class="">
                                    <select name="category_id">
                                        <option value="" disabled selected>Select a Category</option>
                                        <?=htmlOptions($franchiseCategArr, $_REQUEST['category_id']);?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Banner content -->

    </div>
    <!-- Header banner -->

</header>