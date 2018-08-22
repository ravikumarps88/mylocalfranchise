<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE songlist SET status='deleted'  WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Song has been deleted.";	
}
//---------------------------------------------------------------------------------------------------


$query = "select * from songlist WHERE status='active' ORDER BY title";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){
			$(function() {
				//showing by status
				$('#status').change(function()	{
					$(location).attr('href','index.php?_page=manage-songlist&status='+$(this).val());
				});
				
			});
		});
	</script>
<? ############################################################################################## ?>

Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_songlist" class="button"  style="float:right;margin-top: -33px;">New song&nbsp;<img src="images/icons/add.png" title="New song" alt="New song"  /></a>
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
    <td width="15%" align="left">Title</td>
    <td width="15%" align="left">Genre</td>
	<td width="20%" align="left">Artist</td>
    <td width="20%" align="left">Release Year</td>
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
              <td width="15%" align="left"><a href="index.php?_page=add_edit_songlist&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['title'])?></a></td>
              <td width="20%" align="left"><?=no_magic_quotes($recordsList[$i]['genre'])?></td>
              <td width="3%" align="left"><?=no_magic_quotes($recordsList[$i]['artist'])?></td>
              <td width="3%" align="left"><?=no_magic_quotes($recordsList[$i]['release_year'])?></td>
			  <td width="3%" align="left"><?=$recordsList[$i]['status']?></td>
              <td width="5%" align="left"><a href="index.php?_page=add_edit_songlist&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
				<a href="index.php?_page=manage-songlist&action=delete&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
          </tr>
       </tbody>   
<? } ?>
      </table> 
        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->           