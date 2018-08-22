<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE videos SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Video has been deleted.";	
}
//---------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");

$query = "select * from videos WHERE $status ORDER BY inserted_on DESC";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){
			$(function() {
		
				//showing by status
				$('#status').change(function()	{
					$(location).attr('href','index.php?_page=manage-videos&status='+$(this).val());
				});
				
			});
		});
	</script>
<? ############################################################################################## ?>
Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_videos" class="button"  style="float:right;margin-top: -33px;">New Video&nbsp;<img src="images/icons/add.png" title="New Video" alt="New Video"  /></a>
<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/shadeless/table-excel.png" width="16" height="16">
            <h3>Videos</h3><span></span>
        </div>
        <div class="content">
<table width="100%" border="0" cellspacing="0" cellpadding="4"  id="" class="table">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr>
    <td width="1%" align="left">#</td>
    <td width="6%" align="left">Image</td>
    <td width="23%" align="left">Title</td>    
    <td width="54%" align="left">Url</td>    
    <td width="8%" align="left">Status</td>
	<td width="8%" align="right">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<tbody>
<? for ($i=0; $i<count($recordsList); $i++) {
	$url_parts = parse_url($recordsList[$i]['url']);
	parse_str($url_parts['query'], $path_parts);
?>

    <tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
      <td width="1%" align="left"><?=$i+1?>.</td>
      <td width="6%" align="left"><a href="index.php?_page=add_edit_videos&action=edit&id=<?=$recordsList[$i]['id']?>"><?=$recordsList[$i]['image'] != '' ? ($path_parts['v']=='' ? '<img src="../images/videos/thumb/'.$recordsList[$i]['image'].'" width="130"  />' : '<img src="'.$recordsList[$i]['image'].'" />')  : ''?></a></td>
      <td width="23%" align="left"><?=no_magic_quotes($recordsList[$i]['title'])?></td>
      <td width="54%" align="left"><?=no_magic_quotes($recordsList[$i]['url'])?></td>
      <td width="8%" align="left"><?=$recordsList[$i]['status']?></td>
      <td width="8%" align="right">
        <a href="index.php?_page=add_edit_videos&action=edit&id=<?=$recordsList[$i]['id']?>" style="float:right;"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
        <a href="index.php?_page=manage-videos&action=delete&id=<?=$recordsList[$i]['id']?>" style="float:right;"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
  </tr>
<?
	}
?>
</tbody>
</table>

        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->
