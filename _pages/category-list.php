<?
$voucher_categ_list	= getVoucherCategoriesList();

if($_SESSION['city_post'] != '')
	 	$within_postcodes	= getPostcodesWithinDistance($_SESSION['miles'], $_SESSION['city_post'], $_SESSION['county']);
$whrCitypost	= ($_SESSION['city_post'] != '' ? " AND (vnd.city = '{$_SESSION['city_post']}' OR vnd.online='yes'  $within_postcodes)" : '');
?>
<link rel="stylesheet" type="text/css" href="css/category-list.css">
<div class="category-list">
    <h1>All Categories A-Z</h1>
    <?
	foreach($voucher_categ_list as $val)	{
		
		//Get sub categories
		$sub_categs	= dbQuery("SELECT id FROM voucher_categories WHERE parent_id = '{$val['id']}' AND status='active'");
		$sub_categs_list = '';
		foreach($sub_categs as $scategs)
			$sub_categs_list	.= $scategs['id'].',';
		$sub_categs_list	= substr($sub_categs_list,0,strlen($return)-1);
		
		$count	= dbQuery("SELECT count(*) FROM vouchers v 
							LEFT JOIN vendors vnd
								ON vnd.id = v.vendor_id	
							WHERE v.category_id IN ($sub_categs_list) $whrCitypost AND v.status='active' AND (DATE(valid_to) >= now() OR expiry='yes' ) AND DATE(valid_from) <= now()", 'count');
		if($count > 0)	{
			$voucher_categ_list	= getVoucherSubCategoriesList($val['id']);
	?>
            <div class="main-category-button">
                <div class="icon"><img src="upload/categories/white/<?=$val['image_white']?>" alt="<?=no_magic_quotes($val['category'])?>"></div>
                
                <div class="category-name"><h4><a href="vouchers-list-view.html?category_id=<?=$val['id']?>"><?=no_magic_quotes($val['category'])?></a><br><small><?=$count>0?'('.$count.' Offers)':''?></small></h4></div>
            </div> <!-- .main-category-button -->
            <div class="category-list-content">
                <ul>
                    <?
                    foreach($voucher_categ_list as $sub_val)	{
						$sub_catge_ids	.=  ','.$sub_val['id'];
						
						$count	= dbQuery("SELECT count(*) FROM vouchers v 
							LEFT JOIN vendors vnd
								ON vnd.id = v.vendor_id	
							WHERE v.category_id = '{$sub_val['id']}' $whrCitypost AND v.status='active' AND (DATE(valid_to) >= now() OR expiry='yes' ) AND DATE(valid_from) <= now()", 'count');
						if($count > 0)	{	
                    ?>
                        	<li><a href="vouchers-list-view.html?category_id=<?=$sub_val['id']?>"><?=no_magic_quotes($sub_val['category'])?></a></li>
                    <?
						}
                    }
                    ?>
	                    <li><a href="vouchers-list-view.html?category_id=<?=$val['id'].$sub_catge_ids?>">All</a></li>
                </ul>
            </div> <!-- .category-list-content -->	
    <?	
		}
	}
    ?>
    
</div>