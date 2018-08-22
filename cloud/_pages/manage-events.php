<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE events SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Event has been deleted.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] 	== 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
$sort	= ($_REQUEST['sort'] 	== '' ? 'sort_order' : $_REQUEST['sort']);
	
$query = "select * from events WHERE $status ORDER BY $sort";
$recordsList = dbQuery($query);

$sortOrderArr	= array();
$sortOrderArr[]	= array("optionId"=>"sort_order","optionText"=>"Select");
$sortOrderArr[]	= array("optionId"=>"event_name","optionText"=>"Event Name");
$sortOrderArr[]	= array("optionId"=>"event_date","optionText"=>"Event Date");

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){
			$(function() {
				$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&update=update'; 
					$.post("update_events.php", order, function(theResponse){
						//alert(theResponse);
					}); 															 
				}								  
				});
				
				//showing by status
				$('#status').change(function()	{
					$(location).attr('href','index.php?_page=manage-events&sort=<?=$_REQUEST['sort']?>&status='+$(this).val());
				});
				
				//sorting order
				$('#sort').change(function()	{
					$(location).attr('href','index.php?_page=manage-events&status=<?=$_REQUEST['status']?>&sort='+$(this).val());
				});
			});
		});
	</script>
<? ############################################################################################## ?>

Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_events" class="button"  style="float:right;margin-top: -33px;">New events&nbsp;<img src="images/icons/add.png" title="New events" alt="New events"  /></a>
<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/shadeless/table-excel.png" width="16" height="16">
            <h3>Images</h3><span></span>
        </div>
        <div class="content">
<table width="100%" border="0" cellspacing="0" cellpadding="4" id="table-example" class="table">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr>
    <td width="2%" align="left">#</td>
    <td width="15%" align="left">Event</td>
    <td width="15%" align="left">Date(s)</td>
    <td width="10%" align="left">Time(s)</td>
    <td width="10%" align="left">Repeating Event</td>
    <td width="15%" align="left">Banner Thumbnail</td>
	<td width="20%" align="left">URL</td>
    <td width="3%" align="left">Status</td>
	<td width="5%" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<? for ($i=0; $i<count($recordsList); $i++) {?>
		<tbody>	
			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
                <td width="2%" align="left"><?=$i+1?></td>
              <td width="15%" align="left"><a href="index.php?_page=add_edit_events&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['event_name'])?></a></td>
              <td width="15%" align="left"><a href="index.php?_page=add_edit_events&action=edit&id=<?=$recordsList[$i]['id']?>"><?=date("dS M, Y", strtotime($recordsList[$i]['event_date']))?></a></td>
              <td width="10%" align="left"><a href="index.php?_page=add_edit_events&action=edit&id=<?=$recordsList[$i]['id']?>"><?=date("ga",strtotime($recordsList[$i]['event_date'].' '.$recordsList[$i]['time_from']))?> - <?=date("ga",strtotime($recordsList[$i]['event_date'].' '.$recordsList[$i]['time_to']))?></a></td>
              <td width="10%" align="left"><?=$recordsList[$i]['event_repeat']?></td>
              <td width="15%" align="left"><a href="index.php?_page=add_edit_events&action=edit&id=<?=$recordsList[$i]['id']?>"><?=$recordsList[$i]['event_img'] != '' ? '<img src="../images/events/thumb/'.$recordsList[$i]['event_img'].'" />' : ''?><a/></td>
              <td width="20%" align="left"><?=$recordsList[$i]['url']?></td>
			  <td width="3%" align="left"><?=$recordsList[$i]['status']?></td>
              <td width="5%" align="left"><a href="index.php?_page=add_edit_events&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
			<a href="index.php?_page=manage-events&action=delete&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
          </tr>
       </tbody>   
<? } ?>
      </table> 
        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->           