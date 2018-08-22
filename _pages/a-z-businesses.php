<?
$_SESSION['dis_mode']	= ($_REQUEST['dis_mode'] == '' ? ($_SESSION['dis_mode']==''?'grid':$_SESSION['dis_mode']) : $_REQUEST['dis_mode']);
$vendors_list	= getVendorsListFiltered($_REQUEST['letter']);
?>

<div class="business-list">
    <nav>
        <ul class="pagination">
        	<li><a href="all-vouchers-<?=$_SESSION['dis_mode']?>-0.html">0-9</a></li>
            <?foreach(range('a', 'z') as $letter) {?>
                <li <?=$letter==$_REQUEST['letter']?'class="active"':''?>><a href="all-vouchers-<?=$_SESSION['dis_mode']?>-<?=$letter?>.html"><?=strtoupper($letter)?></a></li>
            <?}?>
        </ul>
    </nav>
    <div class="business-list-toolbar">
        <div class="title"><?=strtoupper($_REQUEST['letter'])?></div>
        <div class="controls"><a href="#" <?=$_SESSION['dis_mode'] == 'list' ? 'class="active"' : ''?> data-toggle="list-view"><span class="fa fa-th-list"></span></a><a href="#" <?=$_SESSION['dis_mode'] == 'grid' ? 'class="active"' : ''?> class="last" data-toggle="grid-view"><span class="fa fa-th-large"></span></a></div>
    </div>
    
    <div class="business-list-content <?=$_SESSION['dis_mode'] == 'list' ? 'active' : ''?>">
        <ul
            <?foreach($vendors_list as $val)	{?>
            	<li><a href="business/<?=$val['vendor_code']?>"  title="<?=no_magic_quotes($val['vendor'])?>"><?=no_magic_quotes($val['vendor'])?></a></li>
            <?}?>
    	</ul>     
    </div> <!-- .business-list-content -->
    
    <div class="business-grid-content  <?=$_SESSION['dis_mode'] == 'grid' ? 'active' : ''?>">
        <?foreach($vendors_list as $val)	{?>
            <div class="business-logo">
            	<a href="business/<?=$val['vendor_code']?>">
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
                	
                </a>
            	<a class="fav_vendor fav <?=!checkInFav($_SESSION['USER_PROFILE']['id'], $val['id']) ? 'added' : ''?> favourite" name="fav_add_<?=$val['id']?>" href="javascript:void(0);" val="<?=$val['id']?>"><span class="fa fa-heart"></span> Favourite</a>
            </div> <!-- .business-logo -->
        <?}?>
    </div> <!-- .business-grid-content -->
    
</div>