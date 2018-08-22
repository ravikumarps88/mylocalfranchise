<?
$vendors_others	= getVendorsListFiltered('',15,'featured');
?>

<div class="row">
<?

foreach($vendors_others as $val)	{
	$cnt++;
	if($cnt == 1)	{				
	?>
     <div class="col-12">
        <div class="no-results">  
		<i class="fa fa-info-circle pull-left" style="font-size: 30px;color: hsl(0, 0%, 51%);margin-right: 15px;"></i>
        <h2>Sorry, we can&lsquo;t find the franchise you&lsquo;re looking for.</h2>        
         <p>Maybe you would like to <a href="/search/a">View Franchises Alphabetically</a> or <a href="/industries.html">Browse by Industry</a></p>
   	 </div>
    </div>
    <div class="col-12">
        <h3>Here are some other franchises opportunities you might like...</h3>
    </div>
	<?
	}

	?>
		<div class="col-12 col-lg-6 col-xxl-4">
			<div class="franchise-box">
				<div class="add-to-request-list">
					<a href="javascript:void(0);"><i class="fa <?=customerRequestExist($val['id'], $_SESSION['USER_PROFILE']['id']) == 0 ? 'fa-square-o' : 'fa-check-square-o'?>" id="<?=$val['id']?>"></i> Add to Request List</a>
				</div>
				<figure>
					<?
					if($val['logo'] == '')	{
					?>
						<a href="<?=$val['vendor_code']?>"><img src="upload/vendors/thumbnail/No-Logo-Image.jpg" alt="<?=no_magic_quotes($val['vendor'])?>" title="<?=no_magic_quotes($val['vendor'])?>"></a>
					<?
					}
					else	{
					?>
						<a href="<?=$val['vendor_code']?>"><img src="upload/vendors/thumbnail/<?=$val['logo']?>" alt="<?=no_magic_quotes($val['vendor'])?>" title="<?=no_magic_quotes($val['vendor'])?>"></a>
					<?
					}
					?>
					
				</figure>
				<div class="franchise-info">
					<div class="name"><?=no_magic_quotes($val['vendor'])?></div>
					<div class="description"><?=substr(no_magic_quotes($val['description']),0,85)?> ...</div>
					<div class="investment"><strong>Min. Investment:</strong> &pound;<?=number_format($val['min_investment'])?></div>
				</div>
				<footer>
					<div class="controls">
						<a href="<?=$val['vendor_code']?>#contactForm" rel="nofollow"><i class="fa fa-envelope" aria-hidden="true"></i></a>
		
					</div>
					<a href="<?=$val['vendor_code']?>" class="more-link">find out more</a>
				</footer>
			</div><!-- .franchise-box -->
		</div><!-- .col -->
	<?
}	
?>

</div> <!-- row -->