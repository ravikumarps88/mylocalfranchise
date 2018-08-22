<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE users SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "User has been set to status 'deleted'.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : ($_REQUEST['status'] == 'pending' ? 'pending' : 'active')))."'");
$sort	= 'lastname';
if($_REQUEST['sort'] == 'lastname')
	$sort	= 'lastname';
	
$query = "select * from users WHERE $status ORDER BY $sort";
$recordsList = dbQuery($query);


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
<? displayMessages(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="contentTable" id="pfolio">
	<tr><td colspan="9">
    <span class="right">
    	Show:&nbsp;<select id="status">
        	<?=htmlOptions($statusArr, $_REQUEST['status']);?>
        </select>
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_blogusers" >Add New User&nbsp;<img src="images/icons/icon_add.png" title="New User" alt="New User"  /></a>    
        </span></td></tr>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr class="headerRow">
    <td width="2%" align="left">#</td>
    <td width="23%" align="left"><a href="index.php?_page=users&sort=lastname">User</a></td>
   <!-- <td width="15%" align="left">Email</td> 
    <td width="8%" align="left">Phone</td> -->
    <td width="4%" align="left">Status</td>
	<td width="10%" align="left">Last Edited</td>
	<td width="10%" align="left">Actions</td>
  </tr>
<? }?>  
</tr>

<? for ($i=0; $i<count($recordsList); $i++) {?>
			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
                <td width="2%" align="left"><?=$i+1?></td>
              <td width="23%" align="left"><a href="index.php?_page=add_edit_blogusers&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['firstname'])?>&nbsp;<?=no_magic_quotes($recordsList[$i]['lastname'])?></a></td>
            <!--  <td width="15%" align="left"><?=$recordsList[$i]['email']?></td>
              <td width="8%" align="left"><?=$recordsList[$i]['phone']?></td>  -->
              <td width="4%" align="left"><?=$recordsList[$i]['status']?></td>
              <td width="10%" align="left"><?=$recordsList[$i]['updated_on'] == '0000-00-00 00:00:00' ? date('d-m-Y, h:i a',strtotime($recordsList[$i]['inserted_on'])) : date('d-m-Y, h:i a',strtotime($recordsList[$i]['updated_on'])) ?></td>
              <td width="10%" align="left">
              <a href="index.php?_page=add_edit_blogusers&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
              
			  <a href="index.php?_page=users&action=delete&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
  </tr>
<? } ?>
</table>  