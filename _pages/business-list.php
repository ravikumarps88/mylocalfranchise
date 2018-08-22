<?
$vendors_list	= getVendorsList($_REQUEST['letter']);
?>
<ul class="unstyled azbox" id="companies">
	<li>
    	<div class="azbox">
        	<ul>
            	<?foreach(range('a', 'z') as $letter) {?>
                	<li><a <?=$letter==$_REQUEST['letter']?'style="text-decoration:underline; color:#35B9E9;"':''?> href="voucher/<?=$letter?>/all-voucher-codes"><?=strtoupper($letter)?></a></li>
                <?}?>
                <li><a <?=$letter=='0'?'style="text-decoration:underline; color:#35B9E9;"':''?> href="voucher/0/all-voucher-codes">0-9</a></li>
            </ul>
        </div>
    </li>
</ul>

<h4><?=$_REQUEST['letter'] == '0' ? '0-9' : (strtoupper($_REQUEST['letter']))?></h4>
<?foreach($vendors_list as $val)	{?>
	<div class="vendor_list" ><a href="business_details.html?id=<?=$val['id']?>"><?=no_magic_quotes($val['vendor'])?></div>	
<?}?>