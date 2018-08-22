<?
//---------------------------------------------------------------------------------------------------

	$sort	= 'event_type';
		
	if($_REQUEST['sort'] == 'event_type')
		$sort	= 'event_type';
		
$query = "select * from event_type WHERE status='active' ORDER BY $sort";
$recordsList = dbQuery($query);

?>

Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_eventtype" class="button"  style="float:right;margin-top: -33px;">New Event Type&nbsp;<img src="images/icons/add.png" title="New Event Type" alt="New Event Type"  /></a>
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
  <tr class="headerRow">
    <td width="1%" align="left">#</td>
    <td width="15%" align="left"><a href="index.php?_page=event_type&sort=event_type">Event Type</a></td>
    <td width="11%" align="left">Status</td>
	<td width="14%" align="left">Last Edited</td>
	<td width="7%" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<? for ($i=0; $i<count($recordsList); $i++) {?>
			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
              <td width="2%" align="left"><?=$i+1?></td>
              <td width="15%" align="left"><a href="index.php?_page=add_edit_eventtype&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['event_type'])?></a></td>
              <td width="11%" align="left"><?=$recordsList[$i]['status']?></td>
              <td width="15%" align="left"><?=$recordsList[$i]['updated_on']?></td>
              <td width="6%" align="left"><a href="index.php?_page=add_edit_eventtype&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a></td>
          </tr>
 
<? } ?>
</table>
        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->           