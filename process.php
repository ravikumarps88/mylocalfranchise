<?
require "lib/app_top.php";

//============================================================================================
//============================================================================================

if($_REQUEST['action'] == 'reset_password')	{
	$email 		= $_REQUEST['email'];

	$email_exist	= dbQuery("SELECT count(*) FROM customers WHERE email='$email' AND status='active'",'count');
	if($email_exist ==0)
		echo json_encode(array("email"=>false));
	else	{
		$name	= dbQuery("SELECT firstname FROM customers WHERE email='$email' AND status='active'",'singlecolumn');

		$newPassword	= randomString(8);
		$dbFields = array();
		$dbFields['password'] = md5($newPassword);
		$specialFields = array();

		dbPerform("customers", $dbFields, $specialFields, "email='$email' AND status='active'");
		$passwordChanged = true;

		//email user
		$email_subject = 'Password reset';
		$email_tmp = "<p>Your password has been reset:</p>
						<p><u><strong>Login details</strong></u><br>
						Email: ".$_REQUEST['email']."<br>

						Username: ".$email."<br>
						New password: ".$newPassword."<br>

						<p>&nbsp;</p>
						<p>Thanks</p>
						<strong>".SITE_NAME."</strong>";

		if(sendMandrillMail($email,$name,EMAIL,SITE_NAME,$email_subject,$email_tmp))
			echo json_encode(array("email"=>true));
		else
			echo json_encode(array("email"=>false));

	}
}

//============================================================================================
//============================================================================================

if($_REQUEST['action'] == 'login')	{
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	if(authenticateUser($email, $password, 'customer'))	{
		echo json_encode(array("login"=>true));
	}
	else
		echo json_encode(array("login"=>false));


}

//============================================================================================
//============================================================================================
if($_REQUEST['action'] == 'subscribe')	{

	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);

	if($email=='' || $email=='undefined' || !filter_var($email, FILTER_VALIDATE_EMAIL))	{
		echo json_encode(array("subscribe"=>'invalid'));
		exit;
	}

	if(customerEmailExist($email) == 0)	{

		//adding to customer table
		$dbFields = array();

		$dbFields['email'] 			= $email;
		$dbFields['newsletter_subs']= 'yes';

		$password	= randomString(7);
		$dbFields['password'] 		= md5($password);

		$specialFields = array();
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on');


		if(dbPerform("customers", $dbFields, $specialFields))	{

			//email user
			$email_subject = 'Newletter Subscription';
			$email_signup	= '<tr>
							  <td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td>
							  <td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$email.'</td>
							</tr>
							<tr>
							  <td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Password:</td>
							  <td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$password.'</td>
							</tr>';

			$email_tmp	= createSignupEmailTemplate($firstname,$email_signup);

			sendMandrillMail($email,$firstname.' '.$lastname,EMAIL,SITE_NAME,$email_subject,$email_tmp);

			// email to admin
			/*$email_subject = 'Registration Form received';
			$email_signup	= '<tr><td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Name:</td><td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$firstname.' '.$lastname.' </td></tr><tr><td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Email:</td><td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$email.'</td></tr><tr><td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Address 1:</td><td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$address1.'</td></tr><tr><td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Address 2:</td><td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$address2.'</td></tr><tr><td width="18%" align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">City:</td><td width="82%" align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd; word-wrap:break-word; word-break:break-all; ">'.$city.'</td></tr><tr><td align="left" valign="top" bgcolor="#eee" style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;">Postcode:</td><td align="left" valign="top"  style="padding:5px; border-bottom:solid 1px #ddd; border-right:solid 1px #ddd;  word-wrap:break-word; word-break:break-all;">'.$postcode.'</td></tr>';

			$email_tmp	= createAdminSignupEmailTemplate($firstname,$email_signup);
			sendMandrillMail(CONTACT_EMAIL,SITE_NAME,EMAIL,SITE_NAME,$email_subject,$email_tmp);*/
			authenticateUser($email, $password, 'customer');
			echo json_encode(array("subscribe"=>true));
		}

	}
	else
		echo json_encode(array("subscribe"=>false));
}

if($_REQUEST['action'] == 'load_search_sidebar')	{
	$form_vals = json_decode($_REQUEST['variables']);
	echo '<aside class="widget widget_request_list">
                    <h3>Request List</h3>
                    <h3 class="collapse-title"><a href="#widget_request_list" data-toggle="collapse">My Request List <i class="fa fa-angle-down float-right"></i></a></h3>
                    <div class="collapse" id="widget_request_list">
                        <div class="collapse__inner" id="request-list-collapse">
                            <p>add franchises to your request list and then message them all at once.</p>
                            '.getRequestList('{request_list}').'
                            <a class="text-right" href="request-list.html">SEND MESSAGE <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div><!-- .collapse__inner -->
                    </div><!-- .collapse -->
                </aside><!-- .widget .widget_request_list -->
                <aside class="widget widget_featured_franchises">
                    <h3>Top Franchises</h3>
                    <h3 class="collapse-title"><a href="#widget_featured_franchises" data-toggle="collapse">Top Franchises <i class="fa fa-angle-down float-right"></i></a></h3>
                    <div class="collapse" id="widget_featured_franchises">
                        <div class="collapse__inner">
                            <ul>
                                '.getFeaturedBusiness().'
                            </ul>
                        </div><!-- .collapse__inner -->
                    </div><!-- .collapse -->
                </aside><!-- .widget .widget_featured_franchises -->';
}

if($_REQUEST['action'] == 'load_search_hero')	{
	echo getSearchHero();
}

if($_REQUEST['action'] == 'load_another_look')	{
	if(!$_SESSION[AUTH_PREFIX.'AUTH'])
		$user_id = $_SESSION['tmp_profile_id'];
	else
		$user_id = $_SESSION['USER_PROFILE']['id'];
	$profile_views	= dbQuery("SELECT DISTINCT franchise_id FROM franchise_views WHERE customer_id ='$user_id' AND type='profile_view' ORDER BY inserted_on DESC LIMIT 4");

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

}

if($_REQUEST['action'] == 'load_feat_franchise')	{
	$vendors	= getVendorsListFiltered('',4,'featured');

	$i=0;
	foreach($vendors as $val)	{
		$i++;

		if($i == 3)
			$inv_class_mobile	= ' hidden-md-down';
		if($i == 4)
			$inv_class_mobile	= ' hidden-lg-down';
	?>
		<div class="col-sm-6 col-lg-4 col-xl-3 <?=$inv_class_mobile?>">
			<a href="<?=$val['vendor_code']?>" class="franchise-box">
				<figure>
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

				</figure>
				<div class="franchise-name">
					<?=no_magic_quotes(substr($val['vendor'],0,22))?> <span>View</span>
				</div><!-- .franchise-name -->
			</a><!-- .franchise-name -->
		</div><!-- .col-sm-6 col-lg-4 col-xl-3  -->
	<?
	}
}

if($_REQUEST['action'] == 'load_franchise_categs')	{
	echo '<li><a href="/industries.html" class="active">Search by Industry</a></li>';
	foreach(getFranchiseCategories(11,'random') as $val)	{
	?>
		<li><a href="industries/<?=$val['url_title']?>"><?=no_magic_quotes($val['category'])?></a></li>
	<?
	}
	echo '<li class="more"><a href="industries.html">&hellip;</a></li>';
}


if($_REQUEST['action'] == 'load_search_sidebar_nofilter')	{
	$form_vals = json_decode($_REQUEST['variables']);
	echo '<aside class="widget widget_request_list">
                    <h3>My Request List</h3>
                    <h3 class="collapse-title"><a href="#widget_request_list" data-toggle="collapse">My Request List <i class="fa fa-angle-down float-right"></i></a></h3>
                    <div class="collapse" id="widget_request_list">
                        <div class="collapse__inner" id="request-list-collapse">
                            <p>add to your request list by selecting franchises.</p>
                            '.getRequestList('{request_list}').'
                            <a class="text-right" href="request-list.html">VIEW ALL <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div><!-- .collapse__inner -->
                    </div><!-- .collapse -->
                </aside><!-- .widget .widget_request_list -->
                <aside class="widget widget_featured_franchises">
                    <h3>Top Franchises</h3>
                    <h3 class="collapse-title"><a href="#widget_featured_franchises" data-toggle="collapse">Top Franchises <i class="fa fa-angle-down float-right"></i></a></h3>
                    <div class="collapse" id="widget_featured_franchises">
                        <div class="collapse__inner">
                            <ul>
                                '.getFeaturedBusiness().'
                            </ul>
                        </div><!-- .collapse__inner -->
                    </div><!-- .collapse -->
                </aside><!-- .widget .widget_featured_franchises -->';
}
?>
