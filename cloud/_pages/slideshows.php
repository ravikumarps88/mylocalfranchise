<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE slideshows SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "image has been deleted.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
	$sort	= 'slideshow';
		
	if($_REQUEST['sort'] == 'slideshow')
		$sort	= 'slideshow';
		
$query = "select * from slideshows WHERE $status ORDER BY $sort";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){

			//showing by status
			$('#status').change(function()	{
				$(location).attr('href','index.php?_page=slideshows&status='+$(this).val());
			});
		});
	</script>
<? ############################################################################################## ?>
Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_slideshows" class="button"  style="float:right;margin-top: -33px;">New slideshow&nbsp;<img src="images/icons/add.png" title="New slideshow" alt="New slideshow"  /></a>
<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/shadeless/table-excel.png" width="16" height="16">
            <h3>Pages</h3><span></span>
        </div>
        <div class="content">
<table width="100%" border="0" cellspacing="0" cellpadding="4"  id="table-example" class="table">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr>
    <td width="1%" align="left">#</td>
    <td width="13%" align="left"><a href="index.php?_page=slideshows&sort=title">Slideshow</a></td>
    <td width="10%" align="left">Embed Code</td>
    <td width="11%" align="left">Transition</td>
    <td width="15%" align="left">Slide width</td>
    <td width="18%" align="left">Slide height</td>
    <td width="7%" align="left">Status</td>
	<td width="16%" align="left">Last Edited</td>
	<td width="9%" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<? for ($i=0; $i<count($recordsList); $i++) {?>

			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
                <td width="2%" align="left"><?=$i+1?></td>
              <td width="12%" align="left"><a href="index.php?_page=add_edit_slideshows&action=edit&id=<?=$recordsList[$i]['id']?>"><?=$recordsList[$i]['slideshow']?></a></td>
              <td width="11%" align="left"><?=$recordsList[$i]['embed_code']?></td>
              <td width="11%" align="left"><?=$recordsList[$i]['transition']?></td>
              <td width="14%" align="left"><?=$recordsList[$i]['slide_width']?>&nbsp;pixels</td>
              <td width="18%" align="left"><?=$recordsList[$i]['slide_height']?>&nbsp;pixels</td>
              <td width="7%" align="left"><?=$recordsList[$i]['status']?></td>
              <td width="16%" align="left"><?=$recordsList[$i]['updated_on'] == '0000-00-00 00:00:00' ? date('d-m-Y, h:i s',strtotime($recordsList[$i]['inserted_on'])) : date('d-m-Y, h:i a',strtotime($recordsList[$i]['updated_on'])) ?></td>
              <td width="9%" align="left"><a href="index.php?_page=add_edit_slideshows&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
			<a href="index.php?_page=slideshows&action=delete&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
          </tr>
<? } ?>
</table>     
        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->  