<?
require "../lib/app_top_admin.php";

if($_REQUEST['action'] == 'showpreview')	{

	$voucher	= dbQuery("SELECT * FROM vouchers WHERE id='{$_REQUEST['voucher_id']}'", 'single');
?>

    <link rel="stylesheet" type="text/css" href="../css/print.css">
    
    <div id="voucher" class="clearfix" style="width:815px;">
        <div class="clearfix">
            <div id="voucher-logo">
                <?if($_REQUEST['voucher_id'] != '')	{?>
                    <img src="../upload/vendors/thumbnail/<?=getFieldValue($voucher['vendor_id'], 'logo', 'vendors')?>">
                <?} elseif($_REQUEST['vendor_id'] != '') {?>    
                    <img src="../upload/vendors/thumbnail/<?=getFieldValue($_REQUEST['vendor_id'], 'logo', 'vendors')?>">
   
                <?} else {?>    
                    <img src="../upload/vendors/thumbnail/No-Logo-Image.jpg">
                <?}?>
            </div> <!-- #voucher-logo -->
            <div id="voucher-content">
                <h1><?=$_REQUEST['voucher_id'] != '' ? no_magic_quotes($voucher['voucher']) : 'Voucher Headline'?></h1>
                <h2><?=$_REQUEST['voucher_id'] != '' ? no_magic_quotes(getFieldValue($voucher['vendor_id'], 'vendor', 'vendors')) : 'Business Name'?></h2>
                <p id="expires">Expires: <?=$_REQUEST['voucher_id'] != '' ? date("d/m/y", strtotime($voucher['valid_to'])) : 'Date'?></p>
            </div> <!-- #voucher-content -->
        </div> <!-- .clearfix -->
        <div id="voucher-footer">	
            <h3>
                <?if($_REQUEST['voucher_id'] != '')	{?>
                    <?=no_magic_quotes(getFieldValue($voucher['vendor_id'], 'addr1', 'vendors'))?> 
                    <?=no_magic_quotes(getFieldValue($voucher['vendor_id'], 'addr2', 'vendors'))?>, 
                    <?=no_magic_quotes(getFieldValue($voucher['vendor_id'], 'postcode', 'vendors'))?> - 
                    <?=no_magic_quotes(getFieldValue($voucher['vendor_id'], 'phone', 'vendors'))?>
                <?} else	{?>
                    Addreess Line1
                    Addreess Line2, 
                    Postcode - 
                    Phone
                <?}?>     
            </h3>
            
            <p><strong>Terms and Conditions</strong></p>
            <?if($voucher['terms'] != '')	{?>
                <span  id="terms_span"><?=no_magic_quotes($voucher['terms'])?></span>
            <?}else	{?>
                <span  id="terms_span">1. Terms terms terms terms terms terms </span>
            <?}?>
        </div> <!-- #voucher-footer -->
        <div id="logo">
            <img src="../img/logo-print.png" alt="Saverplaces.co.uk" width="140">
        </div> <!-- #logo -->
    </div> <!-- #voucher -->
    
<?
}

if($_REQUEST['action'] == 'get_vendor_details')	{
	$vendor	= dbQuery("SELECT * FROM vendors WHERE id='{$_REQUEST['vendor_id']}'", 'single');
	
	if($vendor['logo'] == '')	{
		$thumb_image	= "No-Logo-Image.jpg";
	}
	else	{
		$thumb_image	= $vendor['logo'];
	}
	
	echo json_encode(array('logo'=>$thumb_image,'vendor'=>$vendor['vendor'],'addr1'=>$vendor['addr1'],'addr2'=>$vendor['addr2'],'postcode'=>$vendor['postcode'],'phone'=>$vendor['phone']));
}


if($_REQUEST['action'] == 'get_expiry_date')	{
	$date_range	= explode(' - ',$_REQUEST['date']);	
	echo json_encode(array('expiry_date'=>$date_range[1]));
}
?>    