<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE vouchers SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Voucher entry has been deleted.";	
}

if ($action=="save") {
		foreach($_REQUEST as $key=>$val)
			$$key	= addslashes($val);

		$date_range	= explode(' - ',$date_range);	
		
		$valid_from	= ($date_range[0] == '' ? 'now()' : "'".convertToMysqlDate($date_range[0], '/')."'");
		$valid_to 	= ($date_range[1] == '' ? 'now()' : "'".convertToMysqlDate($date_range[1], '/')."'");
	
		if($_FILES['image']['size'] > 0)	{
			$filename	= '../upload/vouchers/'.$_FILES['image']['name'];
			$image_name	= $_FILES['image']['name'];
			copy($_FILES['image']['tmp_name'],$filename);
		}
		
		$dbFields = array();
		$dbFields['vendor_id']		= $vendor_id;
		$dbFields['category_id'] 	= ($sub_category_id == '' ? $category_id : $sub_category_id);
		$dbFields['voucher'] 		= $voucher;
		
		$dbFields['description'] 	= $description;
		$dbFields['terms'] 			= $terms;
		
		$dbFields['value'] 			= $value;
		$dbFields['discount'] 		= $discount;
		$dbFields['valid_from'] 	= $valid_from;
		$dbFields['valid_to'] 		= $valid_to;
		
		$dbFields['expiry'] 		= ($expiry == 'on' ? 'yes' : 'no');
		
		$dbFields['type']			= $type;	
		if($type == 'online_code')
			$dbFields['voucher_code']	= $voucher_code;
		
		if($image_name != '')
			$dbFields['image'] 		= $image_name;

		$dbFields['status'] 		= 'active';
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on','valid_from','valid_to');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Voucher entry has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on','valid_from','valid_to');
			$INFO_MSG = "Voucher entry has been posted.";
		}
		
		dbPerform("vouchers", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
		
		
		$vendor_id = '';
		
}

//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "v.status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : ($_REQUEST['status'] == 'pending' ? 'pending' : 'active')))."'");

if($_REQUEST['category'])	{
	$categ	= "AND category_id='{$_REQUEST['category']}'";	
	
	if(getFieldValue($_REQUEST['category'], 'parent_id', 'voucher_categories') == 0)	{
		//Get sub categories
		$sub_categs	= dbQuery("SELECT id FROM voucher_categories WHERE parent_id = '{$_REQUEST['category']}' AND status='active'");
		$sub_categs_list = '';
		foreach($sub_categs as $scategs)
			$sub_categs_list	.= $scategs['id'].',';
		$sub_categs_list	= substr($sub_categs_list,0,strlen($return)-1);
		
		$whrincateg	= ($_REQUEST['category'] != '' ? " AND v.category_id IN (".$sub_categs_list.")" : '');
	}
	else						
		$whrincateg	= ($_REQUEST['category'] != '' ? " AND v.category_id IN (".$_REQUEST['category'].")" : '');
}

//If franchisee login show only the business related to them
if($_SESSION['ADMIN_USER_PROFILE']['type'] == 'admin')	{
	$whrFranchisee	= " AND users_id='{$_SESSION['ADMIN_USER_PROFILE']['id']}'";
}

//If business login show only the business of them
if($_SESSION['ADMIN_USER_PROFILE']['type'] == 'user')	{
	$whrFranchisee	= " AND vnd.email='{$_SESSION['ADMIN_USER_PROFILE']['email']}'";
	
	$query			 		= "SELECT * FROM vendors WHERE email='{$_SESSION['ADMIN_USER_PROFILE']['email']}'";
	$_REQUEST['vendor_id']	= dbQuery($query, 'singlecolumn');
}
	
if($_REQUEST['vendor_id'])
	$vendor_id	= "AND vendor_id='{$_REQUEST['vendor_id']}'";		
		
	$query = "SELECT v.* FROM vouchers v
				LEFT JOIN vendors vnd
					ON v.vendor_id = vnd.id
				LEFT JOIN voucher_categories vcat
								ON vcat.id = v.category_id	
				WHERE $status $whrincateg $vendor_id $whrFranchisee ORDER BY voucher";
				
$recordsList = dbQuery($query);


$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusArr[]	= array("optionId"=>"all","optionText"=>"All");




?>
<? ############################################################################################## ?>
	
<script>
	$(document).ready(function(){
		
		//showing by status
		$('#status').change(function()	{
			$(location).attr('href','index.php?_page=vouchers&status='+$(this).val()+'&category=<?=$_REQUEST['category']?>&vendor_id=<?=$_REQUEST['vendor_id']?>');
		});
		
		//showing by category
        $('#category').change(function()	{
            $(location).attr('href','index.php?_page=vouchers&category='+$(this).val()+'&status=<?=$_REQUEST['status']?>&vendor_id=<?=$_REQUEST['vendor_id']?>');
        });
		
		//showing by vendor
        $('#vendor_ids').change(function()	{
            $(location).attr('href','index.php?_page=vouchers&vendor_id='+$(this).val()+'&status=<?=$_REQUEST['status']?>&category=<?=$_REQUEST['category']?>');
        });
		
		
		$('.vmodal').click(function()	{
    		jQuery('#modal-7').modal('show', {backdrop: 'static'});
		
			$.ajax({
				url: "load_add_edit_vouchers.php?action=edit&vendor_id=<?=$_REQUEST['vendor_id']?>&id="+$(this).attr('id'),
				success: function(response)
				{
					jQuery('#modal-7 .modal-body').html(response);
				}
			});	        
        });
		
	});
	
	
</script>


<? ############################################################################################## ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>

    <li class="active">
        <strong>Vouchers</strong>
    </li>
</ol>

<div class="col-sm-3" style="padding-left:0;">
    <select id="category" class="selectboxit">
        <option value="">Select Category</option>
        <?=htmlOptions($voucherCategArr, $_REQUEST['category']);?>
    </select>
</div>
 
<div class="col-sm-2">      
    <select id="status" class="selectboxit" data-first-option="false">
        <?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
    </select> 
</div>
 
<a href="javascript:void(0);" id="" class="vmodal">
    <button type="button" class="btn btn-primary btn-lg btn-icon pull-right">
        Add Voucher
        <i class="entypo-plus"></i>
    </button>        
</a>
        

<div style="clear:both; height:15px;"></div>

<? if (count($recordsList)==0) { ?>
	<table style="height:20px;">
    	<tr><td style="border:none; padding:0px;">No Vouchers found!</td></tr>
    </table>
<? } else {?>  

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-bordered datatable" id="table-1">
	<thead>
	  <tr class="headerRow" >
        <td width="1%" align="left">#</td>
        <td width="3%" align="left">Logo</td>
        <td width="10%" align="left">Business Name</td>
        <td width="25%" align="left">Voucher</td>
        <td width="18%" align="left">Category</td>   
        <td width="10%" align="left">Views</td>   
        <td width="9%" align="left">Clicks</td>    
        <td width="10%" align="left">Expiry Date</td>
        <td width="14%" align="left">Actions</td>
	 </tr>
	</thead>
    
    <tbody>
<? for ($i=0; $i<count($recordsList); $i++) {?>
       	
			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
              <td width="1%" align="left"><?=$i+1?></td>
              
              <td width="3%" align="left"><a href="javascript:;" id="<?=$recordsList[$i]['id']?>" class="vmodal"><img src="../upload/vendors/thumbnail/<?=getFieldValue($recordsList[$i]['vendor_id'], 'logo', 'vendors')?>" width="50" /></a></td>
              
              <td width="10%" align="left"><a href="index.php?_page=add_edit_vendors&action=edit&id=<?=$recordsList[$i]['vendor_id']?>"><?=no_magic_quotes(getFieldValue($recordsList[$i]['vendor_id'], 'vendor' , 'vendors'))?></a></td>
              
			  <td width="25%" align="left"><?=no_magic_quotes($recordsList[$i]['voucher'])?></td>
              
			  <td width="18%" align="left"><?=no_magic_quotes(getFieldValue($recordsList[$i]['category_id'], 'category' , 'voucher_categories'))?></td>
              
              <td width="10%" align="left"><?=$recordsList[$i]['views']?></td>
              
              <td width="9%" align="left"><?=$recordsList[$i]['clicks']?></td>
              
              
              <td width="10%" align="left"><?=$recordsList[$i]['expiry'] == 'no' ? date('d/m/Y', strtotime($recordsList[$i]['valid_to'])) : 'No Expiry Date'?></td>	
              
          <td width="14%" align="left">
                  	<!--<a href="index.php?_page=add_edit_vouchers&action=edit&id=<?=$recordsList[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit                
                    </a>-->
                    
                    <a href="javascript:;" id="<?=$recordsList[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left vmodal">
                    	<i class="entypo-pencil"></i>
                        Edit                    </a>    
                    
                    <a href="index.php?_page=vouchers&action=delete&id=<?=$recordsList[$i]['id']?>"  onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                        <i class="entypo-cancel"></i>
                        Delete                    </a>   			   </td>
      </tr>
          
<? } ?>
	<tbody>
</table>


<? } ?>