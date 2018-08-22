<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE mp3songs SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Song has been deleted.";	
}
//---------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");

$query = "select * from mp3songs WHERE $status ORDER BY sort_order";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){
			$(function() {
				$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&update=update&table=mp3songs'; 
					$.post("update_sortorder.php", order, function(theResponse){
						//alert(theResponse);
					}); 															 
				}								  
				});
				
				//showing by status
				$('#status').change(function()	{
					$(location).attr('href','index.php?_page=manage-mp3songs&status='+$(this).val());
				});
				
			});
		});
	</script>
<? ############################################################################################## ?>
Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_mp3songs" class="button"  style="float:right;margin-top: -33px;">New Song&nbsp;<img src="images/icons/add.png" title="New Song" alt="New Song"  /></a>
<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/shadeless/table-excel.png" width="16" height="16">
            <h3>Playlist Songs</h3><span></span>
        </div>
        <div class="content">
<table width="100%" border="0" cellspacing="0" cellpadding="4"  id="" class="table">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr>
    <td width="1%" align="left">#</td>
    <td width="30%" align="left">Title</td>
    <td width="21%" align="left">Artist/Author</td>    
    <td width="20%" align="left">Song</td>    
    <td width="16%" align="left">Status</td>
	<td width="12%" align="right">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
</table>  
<div id="list">

    <ul style="list-style:none outside; padding:0; margin:0;">
<? for ($i=0; $i<count($recordsList); $i++) {?>
		<li id="arrayorder_<?=$recordsList[$i]['id']?>" style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="4"  id="" class="table">
        	<tbody>
			<tr>
              <td width="1%" align="left"><?=$i+1?>.</td>
              <td width="30%" align="left"><a href="index.php?_page=add_edit_mp3songs&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['title'])?></a></td>
              <td width="21%" align="left"><?=no_magic_quotes($recordsList[$i]['artist'])?></td>
              <td width="20%" align="left"><?=no_magic_quotes($recordsList[$i]['song'])?></td>
              <td width="16%" align="left"><?=$recordsList[$i]['status']?></td>
              <td width="12%" align="right">
              	<a href="index.php?_page=add_edit_mp3songs&action=edit&id=<?=$recordsList[$i]['id']?>" style="float:right;"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
				<a href="index.php?_page=manage-mp3songs&action=delete&id=<?=$recordsList[$i]['id']?>" style="float:right;"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
          </tr>
          </tbody>
         </table>     
      </li>
<?
	
 } 
?>
</ul>
</div>

</table>

        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->
