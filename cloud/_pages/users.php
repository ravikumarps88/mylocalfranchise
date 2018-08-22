<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE users SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "User has been set to status deleted.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : ($_REQUEST['status'] == 'pending' ? 'pending' : 'active')))."'");

$query 			= "SELECT * FROM users WHERE $status ORDER BY firstname";
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
			$(location).attr('href','index.php?_page=users&status='+$(this).val());
		});
	});
</script>
<? ############################################################################################## ?>


<div class="col-sm-2" style="padding-left:0;">      
    <select id="status" class="selectboxit" data-first-option="false">
        <?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
    </select> 
</div>



<a href="index.php?_page=add_edit_users">
    <button type="button" class="btn btn-primary btn-lg btn-icon pull-right">
        Add User
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
    <td width="49" align="left">#</td>
    <td width="435" align="left">User</td>
    <td width="435" align="left">E-mail</td>
    <td width="295" align="left">Status</td>
    <td width="467" align="left">Access Level</td>
	<td width="278" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<tbody>
<? for ($i=0; $i<count($recordsList); $i++) {?>

			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
              
              <td width="49" align="left"><?=$i+1?></td>
              
              <td width="435" align="left"><a href="index.php?_page=add_edit_users&action=edit&id=<?=$recordsList[$i]['id']?>"><?=$recordsList[$i]['firstname'].' '.$recordsList[$i]['lastname']?></a></td>
              
              <td width="435" align="left"><?=$recordsList[$i]['email']?></td>
              
              <td width="295" align="left"><?=$recordsList[$i]['status']?></td>
              
              <td width="467" align="left"><?=$recordsList[$i]['type']?></td>
              
              <td width="278" align="left">
              	
              	<a href="index.php?_page=add_edit_users&action=edit&id=<?=$recordsList[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                	<i class="entypo-pencil"></i>
					Edit                
                </a>
				
                <a href="index.php?_page=users&action=delete&id=<?=$recordsList[$i]['id']?>"  onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                	<i class="entypo-cancel"></i>
					Delete				
                </a>              
              </td>
    </tr>

  
<? } ?>
</tbody>
</table>