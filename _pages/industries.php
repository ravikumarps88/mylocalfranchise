<?
$vendors	= getVendorsListFiltered('',1,'','','','','featured3');
?>
<div class="search-hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col results-info">
                <h1 style="font-size: 2rem;">Franchise Opportunities by Industry</h1>
             <p>Browse our full list of franchise opportunities by their industry sectors and find a business perfect for you.</p>
            </div><!-- .col -->
            <div class="col promoted-franchise hidden-xs-down">
            	<?
				foreach($vendors as $val)	{
					if($val['logo'] == '')	{
						$thumb_image	= "No-Logo-Image.jpg";
					}
					else	{
						$thumb_image	= $val['logo'];
					}
                ?>
                    <div class="promoted-franchise__inner">
                        <div class="franchise-logo">
                            <a href="<?=$val['vendor_code']?>"><img src="upload/vendors/original/<?=$thumb_image?>" alt="<?=$val['vendor']?>" style=" max-height:65px;max-width:65px;"></a>
                        </div><!-- .franchise-logo -->
                        <div class="franchise-name">
                            <h5>
                                <a href="<?=$val['vendor_code']?>"><?=no_magic_quotes($val['vendor'])?></a>
                                <a href="<?=$val['vendor_code']?>" class="industry"><?=getFieldValue($val['category_id'], 'category', 'franchise_categories')?> Franchise </a>
                                <a href="<?=$val['vendor_code']?>" class="more-info">More info <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </h5>
                        </div><!-- .franchise-name -->
                        <span class="promoted-badge">promoted</span>
                    </div><!-- .promoted-franchise -->
				<?
				}
                ?>                    
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</div>
<section class="industries-page-section">
    <div class="container">
		<?
		foreach(getFranchiseCategoriesAll() as $val)	{
			$franchises			= getSearch('',$val['id'],'','','','','random',0,5);
			$franchises_count	= getSearch('',$val['id'],'','','','','random');
			if(count($franchises) > 0)	{
		?>	
        <div class="industries-category">
            <h3><a href="industries/<?=$val['url_title']?>"><?=no_magic_quotes($val['category'])?> <span><?=count($franchises_count)?></span></a></h3>
            <ul>
            	<?	
				foreach($franchises as $f_val)	{
				?>
                    <li><a href="<?=$f_val['vendor_code']?>"><img src="img/icons/category-list.png" alt="alt"><?=no_magic_quotes($f_val['vendor'])?> </a></li>
               	<?
				}
				?>     
            </ul>
            <a href="industries/<?=$val['url_title']?>">View All <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
        </div>
        <?
			}
		}
		?> 
        
    </div><!-- .container -->
</section><!-- .industries-page-section -->