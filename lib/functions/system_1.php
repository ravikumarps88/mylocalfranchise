<?
//------------------------------------------------------------------------------------------------------------------------

function getUser($id)	{
	$query = "select concat_ws(' ',firstname,lastname) FROM users WHERE id='$id'";
	return dbQuery($query,'singlecolumn');
}

function getAllUsers()	{
	$query = "select id,concat_ws(' ',firstname,lastname) as name FROM users WHERE status='active' AND type<>'superadmin'";
	return dbQuery($query);
}

function getNewsCategory($id)	{
	$query = "select category from news_categories WHERE id='$id'";
	return dbQuery($query,'singlecolumn');
}
// blog function ends

//------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------

function getTemplateName($tmp_id) {
	$sql	= "SELECT tmp_name FROM templates WHERE id='$tmp_id'";
	return dbQuery($sql, 'singlecolumn');
	
}

function getPageAlias($id) {
	$sql	= "SELECT page_alias FROM pages WHERE id='$id'";
	return dbQuery($sql, 'singlecolumn');
	
}

function getUploadedImages()	{
	$sql	= "SELECT * FROM images WHERE status='active'";
	return dbQuery($sql);
}

function getPages($auth='')	{
	$content_type	= ($auth ? '' : " AND content_type='content'");
	$sql	= "SELECT id,page_name FROM pages WHERE status='active' $content_type ORDER BY sort_order";
	return dbQuery($sql);
}

function getTemplates()	{
	$sql	= "SELECT id,tmp_name FROM templates WHERE status='active' ORDER BY tmp_name";
	return dbQuery($sql);
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//convert the input array into a comma separated string (takes the field mentioned from the array)
function convertIntoCommaSepFieldArray($array, $fieldname)	{
	$column	 = array();
	foreach($array as $val)	{
		$column[]	= $val[$fieldname];
	}
	return implode(',',$column);
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//user functions

//user email exist
function userEmailExist($email, $id='')	{
	$cond	= ($id != '' ? " AND id<>'".$id."'" : '');
	return dbQuery("SELECT count(*) FROM users WHERE status='active' AND email='$email' $cond",'count');
}

//get the user details
function getUserDetails($user_field, $field='')	{
	$field	= ($field == '' ? 'id' : $field);
	return dbQuery("SELECT * FROM users
					 	WHERE $field='$user_field'",'single');
}

//get the user details
function getUserField($id, $field)	{
	return dbQuery("SELECT $field FROM users
					 	WHERE id='$id'",'singlecolumn');
}



//user functions ends

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//vendor functions
//vendor email exist
function vendorEmailExist($email, $id='')	{
	$cond	= ($id != '' ? " AND id<>'".$id."'" : '');
	return dbQuery("SELECT count(*) FROM franchises WHERE email='$email' $cond",'count');
}

//vendor code exist
function vendorCodeExist($vendor_code, $id='')	{
	$cond	= ($id != '' ? " AND id<>'".$id."'" : '');
	return dbQuery("SELECT count(*) FROM franchises WHERE vendor_code='$vendor_code' $cond",'count');
}

//get the vendor details
function getVendorDetails($vendor_field, $field='')	{
	$field	= ($field == '' ? 'id' : $field);
	return dbQuery("SELECT * FROM franchises
					 	WHERE $field='$vendor_field'",'single');
}

function getVendorsList($letter='', $limit='', $featured='')	{
	$whrfeatured	= ($featured == '' ? '' : " AND featured='yes'");
	if($letter=='0')
		$whrletter	= ($letter == '' ? '' : " AND vendor REGEXP '[[:digit:]]+'");	
	else	
		$whrletter	= ($letter == '' ? '' : " AND vendor LIKE '$letter%'");
	$whrlimit	= ($limit == '' ? '' : " LIMIT 0,".$limit);
	
	$sql		= "SELECT vnd.* FROM franchises vnd
					 WHERE 
						vnd.status='active' $whrletter $whrfeatured GROUP BY vnd.id ORDER BY RAND() $whrlimit";
	$vendors	= dbQuery($sql);

	return $vendors;						
}

function getVendorsListFiltered($letter='', $limit='', $featured='', $premium='', $category_id='', $featured2='', $featured3='', $featured4='', $featured5='', $sponsored_categs='', $non_categs='', $lifestyle='')	{

	$whrfeatured	= ($featured == '' ? '' : " AND featured='yes'");
	
	$whrfeatured2	= ($featured2 == '' ? '' : " AND featured2='yes'");
	
	$whrfeatured3	= ($featured3 == '' ? '' : " AND featured3='yes'");
	
	$whrfeatured4	= ($featured4 == '' ? '' : " AND featured4='yes'");
	
	$whrfeatured5	= ($featured5 == '' ? '' : " AND featured5='yes'");
	
	$whrsponsored_categs	= ($sponsored_categs == '' ? '' : " AND spons_categs LIKE '%,".$sponsored_categs.",%'");
	
	$whrnon_categs			= ($non_categs == '' ? '' : " AND spons_non_categs LIKE '%,".$non_categs.",%'");
	
	$whrlifestyle	= ($lifestyle == '' ? '' : " AND lifestyles LIKE '%,".$lifestyle.",%'");
	
	$whrpremium		= ($premium == '' ? '' : " AND premium='yes'");
	
	//if category not selected check the categories and sub for the keyword	
	if($category_id != '')	{
		
		//$category	= dbQuery("SELECT id FROM franchise_categories WHERE id = '$category_id' AND status='active'", 'singlecolumn');
		
		if(getFieldValue($category_id, 'parent_id', 'voucher_categories') == 0)	{
			//Get sub categories
			$sub_categs	= array();	
			$sub_categories		= dbQuery("SELECT id FROM franchise_categories WHERE parent_id = '$category_id' AND status='active'");
			foreach($sub_categories as $sub_val)
				$sub_categs[]	= $sub_val['id'];		
			$sub_categs[]	= $category_id;	
			$sub_categs		= implode(',',$sub_categs);
			$whrincateg		= ' AND vnd.category_id IN ('.$sub_categs.')';
		
		}
		else						
			$whrincateg	= ($category_id != '' ? " AND vnd.category_id = ".$category_id : '');
	}	
	//end
	
	if($letter=='0')
		$whrletter	= ($letter == '' ? '' : " AND vendor REGEXP '[[:digit:]]+'");	
	else	
		$whrletter	= ($letter == '' ? '' : " AND vendor LIKE '$letter%'");
	$whrlimit	= ($limit == '' ? '' : " LIMIT 0,".$limit);
	
	$sql		= "SELECT DISTINCT(vnd.id), vnd.logo, vnd.vendor, vnd.description, vnd.category_id, vnd.vendor_code, vnd.min_investment FROM franchises vnd
					 	WHERE 
							vnd.status='active' $whrletter $whrfeatured $whrfeatured2 $whrfeatured3 $whrfeatured4 $whrfeatured5 $whrpremium $whrincateg $whrsponsored_categs $whrnon_categs $whrlifestyle ORDER BY RAND() $whrlimit";
	$vendors	= dbQuery($sql);

	return $vendors;						
}

function getRecentlyAddedBusiness()	{
	$recent_business	= getRecentBusiness(10);
	
	foreach($recent_business as $val)	{
		if($val['logo'] == '')	{
			$thumb_image	= "No-Logo-Image.jpg";
		}
		else	{
			$thumb_image	= $val['logo'];
		}
		
		$ret	.= '<li>
						<a href="'.$val['vendor_code'].'">
							<div class="offer-logo"><img src="upload/vendors/thumbnail/'.$thumb_image.'" alt="'.no_magic_quotes($val['vendor']).' Franchise For Sale"></div>
							<div class="offer-details">
								'.no_magic_quotes($val['vendor']).'
							</div>
						</a>
					</li>';
	
	}
	return $ret;
}

function getRecentlyAddedBusinessNewHome()	{
	$recent_business	= getRecentBusiness();
	
	foreach($recent_business as $val)	{
		if($val['logo'] == '')	{
			$thumb_image	= "No-Logo-Image.jpg";
		}
		else	{
			$thumb_image	= $val['logo'];
		}
		
		$ret	.= '<div class="item">
						<img src="upload/vendors/thumbnail/'.$thumb_image.'">
                        <h5><a href="'.$val['vendor_code'].'">'.no_magic_quotes($val['vendor']).'</a></h5>
                        <p><small>'.no_magic_quotes($val['vendor']).'</small></p>
                    </div>';
	}
	return $ret;
}

function getRecentBusiness($limit='')	{
	$whrlimit	= ($limit == '' ? '' : " LIMIT 0,".$limit);
	
	$sql		= "SELECT DISTINCT(vnd.id), vnd.* FROM franchises vnd
					 	WHERE 
							vnd.status='active' ORDER BY inserted_on DESC $whrlimit";
	$vendors	= dbQuery($sql);

	return $vendors;	
}

//vendor functions ends
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function getSignupFacebookMessageNewHome()	{
	
	if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
		
		$ret	.= '<div class="message">
						<h4>Get the Latest Offers Direct to your Inbox</h4>
						<small>Sign up for an account to benefit from lots of additional features</small>
					</div>
					<form action="saverplaces.html" method="get" id="search_city_post">
						<input type="hidden" name="search" value="yes">
						<input type="hidden" name="splash_screen" value="yes">
						<div class="input-wrap">
							<input type="text" placeholder="email address" name="email" required>
						</div>
						<div class="button-wrap">
							<button type="submit">JOIN<span> - it\'s free<span></button>
							or
							<a href="fbconfig.php" class="facebook-connect"><i class="fa fa-facebook"></i> Connect<span> with Facebook<span></a>
						</div>
					</form>';
	}
	return $ret;
}


//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//customer functions
//customer email exist
function customerEmailExist($email, $id='')	{
	$cond	= ($id != '' ? " AND id<>'".$id."'" : '');
	return dbQuery("SELECT count(*) FROM customers WHERE email='$email' AND status='active' $cond",'count');
}

//get the customer details
function getCustomerDetails($customer_field, $field='')	{
	$field	= ($field == '' ? 'id' : $field);
	return dbQuery("SELECT * FROM customers
					 	WHERE $field='$customer_field'",'single');
}

//customer functions ends
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function getFieldValue($id, $field, $table)	{
	return dbQuery("SELECT $field FROM $table
					 	WHERE id='$id'",'singlecolumn');
}


 function getSearch($keyword='', $category_id, $price_range='', $keywords='', $brand='', $lifestyle='', $filter='', $start='',$end='', $featured='', $letter='', $sponsored_categs='', $non_categs='')	{
 	$limit			= ($start=='' && $end=='' ? '' : " LIMIT $start,$end");
	
	$whrFeatured	= ($featured == '' ? '' : " AND f.featured = 'yes'");
	
	$whrsponsored_categs	= ($sponsored_categs == '' ? '' : " AND spons_categs LIKE '%,".$sponsored_categs.",%'");
	
	$whrnon_categs			= ($non_categs == '' ? '' : " AND spons_non_categs LIKE '%,".$non_categs.",%'");
	
	$whrlifestyle			= ($lifestyle == '' ? '' : " AND lifestyles LIKE '%,".$lifestyle.",%'");
	
	if($letter=='0')
		$whrletter	= ($letter == '' ? '' : " AND vendor REGEXP '[[:digit:]]+'");	
	else	
		$whrletter	= ($letter == '' ? '' : " AND vendor LIKE '$letter%'");
	
	//Price range
	if(count($price_range) > 0 && is_array($price_range))
		$whrFilter	= " AND (";
	foreach($price_range as $price_val)		{
		switch($price_val)	{	
			case '0-10k':
				$whrFilter	.= ' (min_investment > 0 AND  min_investment <= 10000) OR';	
			break;
			
			case '10-20k':
				$whrFilter	.= ' (min_investment > 10000 AND  min_investment <= 20000) OR';	
			break;
			
			case '10-30k':
				$whrFilter	.= ' (min_investment > 10000 AND  min_investment <= 30000) OR';	
			break;
			
			case '20-30k':
				$whrFilter	.= ' (min_investment > 20000 AND  min_investment <= 30000) OR';	
			break;	
	
			case '30-40k':
				$whrFilter	.= ' (min_investment > 30000 AND  min_investment <= 40000) OR';	
			break;	
			
			case '30-50k':
				$whrFilter	.= ' (min_investment > 30000 AND  min_investment <= 50000) OR';	
			break;
			
			case '40-50k':
				$whrFilter	.= ' (min_investment > 40000 AND  min_investment <= 50000) OR';	
			break;	
			
			case '50-75k':
				$whrFilter	.= ' (min_investment > 50000 AND  min_investment <= 75000) OR';	
			break;
			
			case '50-100k':
				$whrFilter	.= ' (min_investment > 50000 AND  min_investment <= 100000) OR';	
			break;	
			
			case '75k ':
				$whrFilter	.= ' min_investment > 75000 OR';	
			break;
			
			case '100k+':
				$whrFilter	.= ' min_investment > 100000 OR';	
			break;	
			
		}
		
	} 
	
	if(count($price_range) > 0 && is_array($price_range))	{
		$whrFilter	= substr($whrFilter,0,strlen($whrFilter)-2);
		$whrFilter	.= ") ";		
	}	
	
	
	//sort
	switch($filter)	{	
		case 'newest':
			$whrSort	= "inserted_on DESC,f.featured ASC";
		break;
		
		case 'oldest':
			$whrSort	= "f.featured ASC, inserted_on ASC";
		break;
		
		case 'random':
			$whrSort	= "f.featured ASC, RAND()";
		break;
		
		case 'all':
			$whrSort	= "f.featured ASC, vendor ASC";
		break;	

		default;
			$whrSort	= "f.featured ASC, vendor ASC";
		break;	
	}
	//end
	
	//if category not selected check the categories and sub for the keyword	
	if($category_id != '')	{
		
		//$category	= dbQuery("SELECT id FROM franchise_categories WHERE id = '$category_id' AND status='active'", 'singlecolumn');
		
		if(getFieldValue($category_id, 'parent_id', 'voucher_categories') == 0)	{
			//Get sub categories
			$sub_categs	= array();	
			$sub_categories		= dbQuery("SELECT id FROM franchise_categories WHERE parent_id = '$category_id' AND status='active'");
			foreach($sub_categories as $sub_val)
				$sub_categs[]	= $sub_val['id'];		
			$sub_categs[]	= $category_id;	
			$sub_categs		= implode(',',$sub_categs);
			$whrincateg		= ' AND f.category_id IN ('.$sub_categs.')';
		
		}
		else						
			$whrincateg	= ($category_id != '' ? " AND f.category_id = ".$category_id : '');
	}	
	//end
		
	
	$whrKeyword		= ($keyword != '' ? " (f.vendor LIKE '%$keyword%' 
											OR f.description LIKE '%$keyword%' 
											OR fcat.category LIKE '%$keyword%'
										  )" : 1);
	if($keyword != '')	{
		$whrJoin	= "LEFT JOIN franchise_categories fcat
							ON fcat.id = f.category_id	";
	}										  
	
	
	$sql	= "SELECT f.id, f.logo, f.vendor_code, f.vendor, f.description, f.min_investment,f.min_invest_show
						FROM franchises f 

						$whrJoin

						 WHERE 
						 	$whrKeyword 
							$whrincateg 
							$whrFilter
							$whrletter
							$whrlifestyle
							AND f.status='active'
							$whrFeatured $whrsponsored_categs $whrnon_categs
						ORDER BY ".$whrSort.$limit;
	$result	= dbQuery($sql);
	return $result;
}

function getSearchCount($keyword='', $category_id, $price_range='', $keywords='', $brand='', $lifestyle='', $filter='', $start='',$end='', $featured='', $letter='', $sponsored_categs='', $non_categs='')	{
 	$limit			= ($start=='' && $end=='' ? '' : " LIMIT $start,$end");
	
	$whrFeatured	= ($featured == '' ? '' : " AND f.featured = 'yes'");
	
	$whrsponsored_categs	= ($sponsored_categs == '' ? '' : " AND spons_categs LIKE '%,".$sponsored_categs.",%'");
	
	$whrnon_categs			= ($non_categs == '' ? '' : " AND spons_non_categs LIKE '%,".$non_categs.",%'");
	
	$whrlifestyle			= ($lifestyle == '' ? '' : " AND lifestyles LIKE '%,".$lifestyle.",%'");
	
	if($letter=='0')
		$whrletter	= ($letter == '' ? '' : " AND vendor REGEXP '[[:digit:]]+'");	
	else	
		$whrletter	= ($letter == '' ? '' : " AND vendor LIKE '$letter%'");
	
	//Price range
	if(count($price_range) > 0 && is_array($price_range))
		$whrFilter	= " AND (";
	foreach($price_range as $price_val)		{
		switch($price_val)	{	
			case '0-10k':
				$whrFilter	.= ' (min_investment > 0 AND  min_investment <= 10000) OR';	
			break;
			
			case '10-20k':
				$whrFilter	.= ' (min_investment > 10000 AND  min_investment <= 20000) OR';	
			break;
			
			case '10-30k':
				$whrFilter	.= ' (min_investment > 10000 AND  min_investment <= 30000) OR';	
			break;
			
			case '20-30k':
				$whrFilter	.= ' (min_investment > 20000 AND  min_investment <= 30000) OR';	
			break;	
	
			case '30-40k':
				$whrFilter	.= ' (min_investment > 30000 AND  min_investment <= 40000) OR';	
			break;	
			
			case '30-50k':
				$whrFilter	.= ' (min_investment > 30000 AND  min_investment <= 50000) OR';	
			break;
			
			case '40-50k':
				$whrFilter	.= ' (min_investment > 40000 AND  min_investment <= 50000) OR';	
			break;	
			
			case '50-75k':
				$whrFilter	.= ' (min_investment > 50000 AND  min_investment <= 75000) OR';	
			break;
			
			case '50-100k':
				$whrFilter	.= ' (min_investment > 50000 AND  min_investment <= 100000) OR';	
			break;	
			
			case '75k ':
				$whrFilter	.= ' min_investment > 75000 OR';	
			break;
			
			case '100k+':
				$whrFilter	.= ' min_investment > 100000 OR';	
			break;	
			
		}
		
	} 
	
	if(count($price_range) > 0 && is_array($price_range))	{
		$whrFilter	= substr($whrFilter,0,strlen($whrFilter)-2);
		$whrFilter	.= ") ";		
	}	
	
	
	//sort
	switch($filter)	{	
		case 'newest':
			$whrSort	= "f.featured ASC, inserted_on DESC";
		break;
		
		case 'oldest':
			$whrSort	= "f.featured ASC, inserted_on ASC";
		break;
		
		case 'random':
			$whrSort	= "f.featured ASC, RAND()";
		break;
		
		case 'all':
			$whrSort	= "f.featured ASC, vendor ASC";
		break;	

		default;
			$whrSort	= "f.featured ASC, vendor ASC";
		break;	
	}
	//end
	
	//if category not selected check the categories and sub for the keyword	
	if($category_id != '')	{
		
		//$category	= dbQuery("SELECT id FROM franchise_categories WHERE id = '$category_id' AND status='active'", 'singlecolumn');
		
		if(getFieldValue($category_id, 'parent_id', 'voucher_categories') == 0)	{
			//Get sub categories
			$sub_categs	= array();	
			$sub_categories		= dbQuery("SELECT id FROM franchise_categories WHERE parent_id = '$category_id' AND status='active'");
			foreach($sub_categories as $sub_val)
				$sub_categs[]	= $sub_val['id'];		
			$sub_categs[]	= $category_id;	
			$sub_categs		= implode(',',$sub_categs);
			$whrincateg		= ' AND f.category_id IN ('.$sub_categs.')';
		
		}
		else						
			$whrincateg	= ($category_id != '' ? " AND f.category_id = ".$category_id : '');
	}	
	//end
		
	
	$whrKeyword		= ($keyword != '' ? " (f.vendor LIKE '%$keyword%' 
											OR f.description LIKE '%$keyword%' 
											OR fcat.category LIKE '%$keyword%'
										  )" : 1);
	if($keyword != '')	{
		$whrJoin	= "LEFT JOIN franchise_categories fcat
							ON fcat.id = f.category_id	";
	}											  
	
	
	$sql	= "SELECT COUNT(*)
						FROM franchises f 

						$whrJoin

						 WHERE 
						 	$whrKeyword 
							$whrincateg 
							$whrFilter
							$whrletter
							$whrlifestyle
							AND f.status='active'
							$whrFeatured $whrsponsored_categs $whrnon_categs
						ORDER BY ".$whrSort.$limit;
	$result	= dbQuery($sql, 'count');
	return $result;
}
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
 
 function getA2ZBox()	{
	
	$ret	= '<li><a href="all-vouchers-list-a.html">A</a></li><li><a href="all-vouchers-list-b.html">B</a></li><li><a href="all-vouchers-list-c.html">C</a></li><li><a href="all-vouchers-list-d.html">D</a></li><li><a href="all-vouchers-list-e.html">E</a></li><li><a href="all-vouchers-list-f.html">F</a></li><li class="last"><a href="all-vouchers-list-g.html">G</a></li><li><a href="all-vouchers-list-h.html">H</a></li><li><a href="all-vouchers-list-i.html">I</a></li><li><a href="all-vouchers-list-j.html">J</a></li><li><a href="all-vouchers-list-k.html">K</a></li><li><a href="all-vouchers-list-l.html">L</a></li><li><a href="all-vouchers-list-m.html">M</a></li><li class="last"><a href="all-vouchers-list-n.html">N</a></li><li><a href="all-vouchers-list-o.html">O</a></li><li><a href="all-vouchers-list-p.html">P</a></li><li><a href="all-vouchers-list-q.html">Q</a></li><li><a href="all-vouchers-list-r.html">R</a></li><li><a href="all-vouchers-list-s.html">S</a></li><li><a href="all-vouchers-list-t.html">T</a></li><li class="last"><a href="all-vouchers-list-u.html">U</a></li><li><a href="all-vouchers-list-v.html">V</a></li><li><a href="all-vouchers-list-w.html">W</a></li><li><a href="all-vouchers-list-x.html">X</a></li><li><a href="all-vouchers-list-y.html">Y</a></li><li><a href="all-vouchers-list-z.html">Z</a></li><li class="last num"><a href="all-vouchers-list-0.html">0-9</a></li>';
	
	return $ret;
 }
 
 function getSubscriptionBoxHome()	{
 	if(!$_SESSION[AUTH_PREFIX.'AUTH'])	{
		return '<section class="subscribe-section">
			<div class="container">
				<div class="row align-items-center msg_subs_home">
					<div class="col-lg-5 col-xl-4 col-xxl-3 subscribe-message">
						<h5>Subscribe to our Newsletter</h5>
						<p>Receive the best opportunities in your inbox.</p>
					</div><!-- .col .subscribe-message -->
					<div class="col">
						<form class="subscribe-form">
							<label for="email">Subscribe to our Free Newsletter</label>
							<button type="button" class="btn btn-block btn-yellow collapse-btn" data-toggle="collapse" data-target="#subscribe1">Subscribe</button>
							<div class="collapse" id="subscribe1">
								<div class="subscribe-form__inner">
									<div class="subscribe-form__email">
										<input type="email" class="newsletter_email" id="email" placeholder="Enter your email address...">
										<button type="submit" id="" class="btn btn-subscribe btn-yellow newsletter_subs_home">subscribe</button>
									</div><!-- .subscribe-form__email -->
									<!--<span>or</span>
									<a href="fbconfig.php" class="btn btn-signup"><i class="fa fa-facebook-official" aria-hidden="true"></i> Connect with facebook</a>-->
								</div><!-- .subscribe-form__inner -->
								<h6 class="err_subscribe" style="display:none;"></h6>
							</div><!-- .collapse -->
						</form><!-- .subscribe-form -->
					</div><!-- .col -->
				</div><!-- .row -->
			</div><!-- .container -->
		</section><!-- .subscribe-section -->';
	}
	else
		return '';
 }
 
 		
 function getPromotedBusinessHome()	{
 	
	$i=0;	
 	$ret='';
 	$vendors	= getVendorsListFiltered('',3,'','','','featured2');
	foreach($vendors as $val)	{
		$i++;
		if($val['logo'] == '')	{
			$thumb_image	= "No-Logo-Image.jpg";
		}
		else	{
			$thumb_image	= $val['logo'];
		}
		
		$inv_class_mobile	= ($i > 1 ? ' class="hidden-md-down"' : '');
		
		$ret	.= '<li '.$inv_class_mobile.'>
						<div class="franchise-logo">
							<a href="'.$val['vendor_code'].'"><img src="upload/vendors/thumbnail/'.$thumb_image.'" alt="'.$val['vendor'].' Franchise For Sale" style=" max-height:80px;max-width:80px;"></a>
							<span class="promoted-badge">promoted</span>
						</div>
						<div class="franchise-name">
							<h5>
								<a href="'.$val['vendor_code'].'" target="_blank">'.no_magic_quotes($val['vendor']).'</a>
								<a href="'.$val['vendor_code'].'" target="_blank" class="industry">'.getFieldValue($val['category_id'], 'category', 'franchise_categories').' Franchise </a>
								<a href="'.$val['vendor_code'].'" target="_blank" class="more-info">More info <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
							</h5>
						</div>
					</li>';		
				
	}
	return $ret;				
 }	
							
 function getFeaturedBusinessHome()	{
 	
		
 	$ret='';
 	$vendors	= getVendorsListFiltered('',8,'featured');
	foreach($vendors as $val)	{
		if($val['logo'] == '')	{
			$thumb_image	= "No-Logo-Image.jpg";
		}
		else	{
			$thumb_image	= $val['logo'];
		}
		
		$ret	.= '<div class="col-12 col-lg-6 col-xl-3">
						<div class="franchise-box">
							<figure>
								<img src="upload/vendors/thumbnail/'.$thumb_image.'" alt="'.$val['vendor'].' Franchise">
							</figure>
							<div class="franchise-info">
								<div class="name">'.no_magic_quotes($val['vendor']).'</div>
								<div class="description">'.no_magic_quotes(substr($val['description'],0,80)).' ...</div>
								<div class="investment"><strong>Min. Investment:</strong> &pound;'.number_format($val['min_investment']).'</div>
							</div>
							<footer>
								<div class="controls">
									<a href="'.$val['vendor_code'].'#contactForm" rel="nofollow" data-toggle="tooltip" data-placement="top" title="Contact Franchise"><i class="fa fa-envelope" aria-hidden="true"></i></a>
								</div>
								<a href="'.$val['vendor_code'].'" class="more-link">find out more</a>
							</footer>
						</div><!-- .franchise-box -->
					</div><!-- .col -->';			
	}
	return $ret;				
 }
 
 
 function getFeaturedBusiness()	{
 	$vendors	= getVendorsListFiltered('',5,'featured');
	foreach($vendors as $val)	{
		if($val['logo'] == '')	{
			$thumb_image	= "No-Logo-Image.jpg";
		}
		else	{
			$thumb_image	= $val['logo'];
		}
		
		$ret	.= '<li>
						<div class="franchise-logo">
							<a href="'.$val['vendor_code'].'"><img src="upload/vendors/thumbnail/'.$thumb_image.'" alt="'.$val['vendor'].' Franchise" style=" max-height:80px;max-width:80px;"></a>
						</div>
						<div class="franchise-name">
							<h5>
								<a href="'.$val['vendor_code'].'" target="_blank">'.no_magic_quotes(substr($val['vendor'],0,22)).(strlen($val['vendor'])>25?'...':'').'</a>
								<a href="'.$val['vendor_code'].'" target="_blank" class="industry">'.no_magic_quotes(getFieldValue($val['category_id'], 'category', 'franchise_categories')).' Franchise </a>
								<a href="'.$val['vendor_code'].'" target="_blank" class="more-info">More info <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
							</h5>
						</div>
					</li>';	
					
	}
	return $ret;				
 }
 
 function getSearchHero()	{
 	$vendors	= getVendorsListFiltered('',1,'','','','','featured3');
	foreach($vendors as $val)	{
		if($val['logo'] == '')	{
			$thumb_image	= "No-Logo-Image.jpg";
		}
		else	{
			$thumb_image	= $val['logo'];
		}
	
		$ret	.= '<div class="promoted-franchise__inner">
						<div class="franchise-logo">
							<a href="'.$val['vendor_code'].'"><img src="upload/vendors/thumbnail/'.$thumb_image.'" alt="'.$val['vendor'].' Franchise" style=" max-height:65px;max-width:65px;"></a>
						</div><!-- .franchise-logo -->
						<div class="franchise-name">
							<h5>
								<a href="'.$val['vendor_code'].'" target="_blank">'.no_magic_quotes($val['vendor']).'</a>
								<a href="'.$val['vendor_code'].'" target="_blank" class="industry">'.getFieldValue($val['category_id'], 'category', 'franchise_categories').' Franchise </a>
								<a href="'.$val['vendor_code'].'" target="_blank" class="more-info">More info <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
							</h5>
						</div><!-- .franchise-name -->
						<span class="promoted-badge">promoted</span>
					</div><!-- .promoted-franchise -->';
	
	}
	return $ret;
 }
 
 function getCategoriesHome()	{
 	$categories	= getFranchiseCategories(8, 'random');
 	
	foreach($categories as $val)	{
		if($val['image'] == '')	{
			$thumb_image	= "http://placehold.it/545x312";
		}
		else	{
			$thumb_image	= 'upload/vendors/category/thumbnail/'.$val['image'];
		}
		
		if(getFieldValue($val['id'], 'parent_id', 'voucher_categories') == 0)	{
			//Get sub categories
			$sub_categs	= array();	
			$sub_categories		= dbQuery("SELECT id FROM franchise_categories WHERE parent_id = '{$val['id']}' AND status='active'");
			foreach($sub_categories as $sub_val)
				$sub_categs[]	= $sub_val['id'];		
			$sub_categs[]	= $val['id'];	
			$sub_categs		= implode(',',$sub_categs);
			$whrincateg		= ' category_id IN ('.$sub_categs.')';
		
		}
		else						
			$whrincateg	= ($val['id'] != '' ? " category_id = ".$val['id'] : '');
			
		$count	= dbQuery("SELECT COUNT(*) FROM franchises WHERE $whrincateg AND status='active'", 'count');
			
		$ret	.= '<div class="col-sm-6 col-lg-4 col-xl-3 ">
						<a href="industries/'.$val['url_title'].'" class="category-box">
							<figure>
								<img src="'.$thumb_image.'" alt="'.$val['category'].' Franchise Opportunities">								
								<div class="category-count"><strong>'.$count.'</strong> franchises</div>
							</figure>
							<div class="category-name">
								'.no_magic_quotes($val['category']).' <span>Show all</span>
							</div><!-- .category-name -->
						</a><!-- .category-box -->
					</div><!-- .col-sm-6 col-lg-4 col-xl-3  -->';		
					
	}
	return $ret;				
 }
 
 
 function getCategoriesListHome()	{
 	$categories	= getFranchiseCategories();
 	
	$ret = '<div class="collapse more-categories" id="moreCategories"><div class="card card-block"><ul>';
	
	foreach($categories as $val)	{
		
		$count	= dbQuery("SELECT COUNT(*) FROM franchises WHERE category_id='{$val['id']}'", 'count');
		
		if($count > 0)	{	
			$ret	.= '<li><a href="industries/'.$val['url_title'].'">'.no_magic_quotes($val['category']).'</a></li>';		
		}
							
	}
	
	$ret	.= '</ul></div> <!-- card-block --></div><!-- .collapse --><div class="view-more-categories" data-toggle="collapse" data-target="#moreCategories"><i class="fa fa-arrow-down" aria-hidden="true"></i> <span>VIEW MORE INDUSTRIES</span> <i class="fa fa-arrow-down" aria-hidden="true"></i></div>';
	
	return $ret;				
 }
             
 
 function formatBritishPostcode($postcode) {

    //--------------------------------------------------
    // Clean up the user input

        $postcode = strtoupper($postcode);
        $postcode = preg_replace('/[^A-Z0-9]/', '', $postcode);
        $postcode = preg_replace('/([A-Z0-9]{3})$/', ' \1', $postcode);
        $postcode = trim($postcode);

    //--------------------------------------------------
    // Check that the submitted value is a valid
    // British postcode: AN NAA | ANN NAA | AAN NAA |
    // AANN NAA | ANA NAA | AANA NAA

        if (preg_match('/^[a-z](\d[a-z\d]?|[a-z]\d[a-z\d]?) \d[a-z]{2}$/i', $postcode)) {
            return $postcode;
        } else {
            return NULL;
        }

}

function getTown()	{
	$towns	=  dbQuery("SELECT concat_ws(' - ',place_name,county) as place FROM uk_towns");
	foreach($towns as $val)	{
		$towns_list	.= $val['place'].',';
	}
	return $towns_list;
}

function getFranchiseNonCategories($limit='', $random='')	{
	$whrlimit	= ($limit == '' ? '' : " LIMIT 0,".$limit);
	$whrOrder	= ($random == '' ? 'ORDER BY category' : "ORDER BY RAND()");
	return dbQuery("SELECT id,category,url_title FROM franchise_categories WHERE status='active' AND parent_id=0 AND is_category='no' $whrOrder $whrlimit");
}

function getFranchiseCategoriesAll($limit='', $random='')	{
	$whrlimit	= ($limit == '' ? '' : " LIMIT 0,".$limit);
	$whrOrder	= ($random == '' ? 'ORDER BY category' : "ORDER BY RAND()");
	return dbQuery("SELECT id,category,url_title FROM franchise_categories WHERE status='active' AND parent_id=0 AND is_category='yes' $whrOrder $whrlimit");
}

function getFranchiseCategories($limit='', $random='')	{
	$whrlimit	= ($limit == '' ? '' : " LIMIT 0,".$limit);
	$whrOrder	= ($random == '' ? 'ORDER BY category' : "ORDER BY RAND()");
	
	return dbQuery("SELECT fc.id, fc.category, fc.image, fc.url_title FROM franchise_categories fc 
						LEFT JOIN franchises f 
							ON fc.id=f.category_id 
						WHERE fc.status='active' 
							AND f.status='active' 
							AND parent_id=0  AND is_category='yes'
						 	GROUP BY fc.id $whrOrder $whrlimit");
						
	//return dbQuery("SELECT * FROM franchise_categories WHERE status='active' AND parent_id=0 $whrOrder $whrlimit");
}

function getSubcategoryArray($category_id)	{
	return dbQuery("SELECT id AS optionId, category AS optionText FROM franchise_categories WHERE status='active' AND parent_id='$category_id' ORDER BY category");
}

function getParentId($category_id)	{
	return dbQuery("SELECT parent_id FROM franchise_categories WHERE id='$category_id'", 'singlecolumn');
}


function customerRequestExist($franchise_id, $customer_id)	{
	if(!$_SESSION[AUTH_PREFIX.'AUTH'])
		$customer_id	= $_SESSION['tmp_profile_id'];
		
	return dbQuery("SELECT count(*) FROM customers_request WHERE franchise_id='$franchise_id' AND customers_id='$customer_id'",'count');
}

function getLifestyles()	{
	return dbQuery("SELECT * FROM lifestyles WHERE status='active' ORDER BY lifestyle");
}

function getNonLifestyles()	{
	return dbQuery("SELECT * FROM lifestyles WHERE status='active' AND is_lifestyle='no' OR (id=1 || id=7) ORDER BY lifestyle");
}


