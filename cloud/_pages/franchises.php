<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE franchises SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Vendor has been set to status 'deleted'.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : ($_REQUEST['status'] == 'pending' ? 'pending' : 'active')))."'");

//If franchisee login show only the business related to them
if($_SESSION['ADMIN_USER_PROFILE']['type'] == 'admin')	{
	$whrFranchisee	= " AND users_id='{$_SESSION['ADMIN_USER_PROFILE']['id']}'";
}

//If business login show only the business of them
if($_SESSION['ADMIN_USER_PROFILE']['type'] == 'user')	{
	$whrFranchisee	= " AND email='{$_SESSION['ADMIN_USER_PROFILE']['email']}'";
	
	$query 		= "SELECT * FROM franchises WHERE $status $whrFranchisee ORDER BY vendor";
	$vendor_id	= dbQuery($query, 'singlecolumn');
	
	header("Location:index.php?_page=add_edit_franchise&action=edit&id=".$vendor_id);
}

$from_date	= ($_REQUEST['from_date'] == '' ? date('d/m/y', strtotime('-6 months')) : $_REQUEST['from_date']);
$to_date	= ($_REQUEST['to_date'] == '' ? date('d/m/y') : $_REQUEST['to_date']);

$from_date_q	= convertToMysqlDate($from_date,'/');
$to_date_q		= convertToMysqlDate($to_date,'/');

$query 			= "SELECT * FROM franchises WHERE $status $whrFranchisee ORDER BY vendor";
$recordsList 	= dbQuery($query);

$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"pending","optionText"=>"Pending");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusArr[]	= array("optionId"=>"all","optionText"=>"All");


?>
<? ############################################################################################## ?>
<script>
	$(document).ready(function(){

		//showing by status
		$('#status').change(function()	{
			$(location).attr('href','index.php?_page=franchises&status='+$(this).val());
		});
	});
</script>
<? ############################################################################################## ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li class="active">
        <strong>Businesses</strong>
    </li>
</ol>
        
<div class="col-sm-2" style="padding-left:0;">      
    <select name="status" id="status" class="selectboxit">
        <?=htmlOptions($statusArr, $_REQUEST['status']);?>
    </select> 
</div>

<form action="" method="post">
<div class="form-group">
    <label class="col-sm-1 control-label">From</label>
    
    <div class="col-sm-2">
        <div class="input-group">
            <input type="text" class="form-control datepicker" name="from_date" value="<?=$from_date?>" data-format="dd/mm/yy">
            
            <div class="input-group-addon">
                <a href="#"><i class="entypo-calendar"></i></a>
            </div>
        </div>
    </div>
    
    <label class="col-sm-1 control-label">To</label>
    
    <div class="col-sm-3">
        <div class="input-group">
            <input type="text" class="form-control datepicker" name="to_date" value="<?=$to_date?>" data-format="dd/mm/yy">
            
            <div class="input-group-addon">
                <a href="#"><i class="entypo-calendar"></i></a>
            </div>
            
            <button type="submit" name="save" class="btn btn-primary pull-right">Search</button>
        </div>
    </div>
</div>
</form>
<a href="index.php?_page=add_edit_franchise">
    <button type="button" class="btn btn-primary btn-lg btn-icon pull-right">
        Add Business
        <i class="entypo-plus"></i>
    </button>        
</a>

        

<div style="clear:both; height:15px;"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="4"  class="table table-bordered datatable" id="table-1">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr class="headerRow">
    <td width="17" align="left">#</td>
    <td width="209" align="left">Business</td>
    <!--<td width="314" align="left">E-mail</td>-->
    <td width="132" align="left">Profile Views</td>
    <td width="138" align="left">Search Views</td>
    <td width="60" align="left">Enquir.</td>
    <td width="179" align="left">Profile Views(Date)</td>
    <td width="181" align="left">Search Views(Date)</td>
    <td width="60" align="left">Enquir.(Date)</td>
    <!--<td width="38" align="left">Status</td>-->
	<td width="217" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<tbody>
<? for ($i=0; $i<count($recordsList); $i++) {
	$search_count	= dbQuery("SELECT COUNT(*) FROM franchise_views WHERE type='search_view' AND franchise_id='{$recordsList[$i]['id']}' AND DATE(inserted_on) >= '$from_date_q' AND DATE(inserted_on) <= '$to_date_q'",'count');
	$profile_count	= dbQuery("SELECT COUNT(*) FROM franchise_views WHERE type='profile_view' AND franchise_id='{$recordsList[$i]['id']}' AND DATE(inserted_on) >= '$from_date_q' AND DATE(inserted_on) <= '$to_date_q'",'count');
	
	$enquiries		= dbQuery("SELECT count(*) FROM request_details WHERE franchise_id='{$recordsList[$i]['id']}'",'count');
	
	$enquiries_date		= dbQuery("SELECT count(*) FROM request_details WHERE franchise_id='{$recordsList[$i]['id']}' AND DATE(inserted_on) >= '$from_date_q' AND DATE(inserted_on) <= '$to_date_q'",'count');
?>

			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
              
              <td width="17" align="left"><?=$i+1?></td>
              
              <td width="209" align="left"><a href="index.php?_page=add_edit_franchise&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['vendor'])?></a></td>
              
              <!--<td width="314" align="left"><?=$recordsList[$i]['email']?></td>-->
              
              <td width="132" align="left"><?=$recordsList[$i]['profile_views']?></td>
              
              <td width="138" align="left"><?=$recordsList[$i]['search_views']?></td>
              
              <td width="60" align="left"><?=$enquiries?></td>
              
              <td width="179" align="left"><?=$profile_count?></td>
              
              <td width="181" align="left"><?=$search_count?></td>
              
              <td width="60" align="left"><?=$enquiries_date?></td>
              
             <!-- <td width="38" align="left"><?=$recordsList[$i]['status']?></td>-->
              
              
              <td width="217" align="left">
              	
              	<a href="index.php?_page=add_edit_franchise&action=edit&id=<?=$recordsList[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                	<i class="entypo-pencil"></i>
					Edit                </a>
				
                <a href="index.php?_page=franchises&action=delete&id=<?=$recordsList[$i]['id']?>"  onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                	<i class="entypo-cancel"></i>
					Delete                </a>              
                    
                    <a href="export_enquiries.php?franchise_id=<?=$recordsList[$i]['id']?>" class="bs-example pull-right" title="Export Enquiries">
                        <i class="entypo-export"></i>                    </a>              </td>
    </tr>

  
<? } ?>
</tbody>
</table>