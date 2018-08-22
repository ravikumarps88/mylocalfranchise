<?
require "../lib/app_top_admin.php";
if($_REQUEST['action'] == 'load_postcode'){
?>
<script type="text/javascript"> 
$(document).ready(function() { 
	$(".postcode").click(function()	{
		$.post('postcodes.php', {check:$(this).attr('checked'), ids:$(this).attr('val'), action:'add_edit_postcode'}, function(data) {
		  //actions
		});
	})
});
</script> 
<span style="float:left; margin-right:10px;">
<?
	$i=0;
    foreach(getActivePostcodes($_REQUEST['postcode']) as $val)	{
        $i++;
?>
        <input type="checkbox" class="postcode" val="<?=$_REQUEST['vendor_id'].'_'.$val['id']?>" <?=chkUserPostcodeExist($_REQUEST['vendor_id'],$val['id']) == 0 ? '' : "checked='checked'"?>  />&nbsp;<?=$val['postcode'].', '.$val['town']?><br />
<?
        if($i % 3 == 0) echo "</span><span style='float:left; margin-right:10px;'>";				
    }	
}


if($_REQUEST['action'] == 'load_sub_categ'){
	echo htmlOptions(getSubcategoryArray($_REQUEST['category_id']));
}


//==================================================================================================
//==================================================================================================

if($_REQUEST['action'] == 'upload_logo'){
	print_r($_REQUEST);
	echo 'here';
}
?>