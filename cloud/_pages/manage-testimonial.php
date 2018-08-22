<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE testimonials SET status='deleted'  WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Form has been deleted.";	
}
//---------------------------------------------------------------------------------------------------

$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
$query = "select * from testimonials WHERE $status ORDER BY name";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
	<script>
		$(document).ready(function(){
			$(function() {
				//showing by status
				$('#status').change(function()	{
					$(location).attr('href','index.php?_page=manage-testimonial&status='+$(this).val());
				});
			});
		});
	</script>
<? ############################################################################################## ?>
Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select> 
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_testimonial" class="button"  style="float:right;margin-top: -33px;">New Testimonial&nbsp;<img src="images/icons/add.png" title="New Testimonial" alt="New Testimonial"  /></a>

<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/images-stack.png" alt="" width="16"
            height="16">
            <h3>Testimonials</h3>
            <span></span>
        </div>
        <div class="content">

<? displayMessages(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table" id="table-example">
<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr class="headerRow">
    <th class="sorting" width="1%" align="left">#</th>
    <th class="sorting" width="2%" align="left">Image</th>
    <th class="sorting" width="10%" align="left">Name</th>
    <th class="sorting" width="13%" align="left">Position</th>
    <th class="sorting" width="13%" align="left">Company</th>
    <th class="sorting" width="44%" align="left">Testimonial</th>
    <th class="sorting" width="44%" align="left">Status</th>
	<th class="sorting" width="5%" align="left">Last Edited</th>
	<th class="sorting" width="3%" align="left">Actions</th>
  </tr>
<? }?>  
</tr>
</thead>
<tbody>
<? for ($i=0; $i<count($recordsList); $i++) {?>
    <tr style="<?=$i%2==0 ? 'background-color:#CED5FF;' : 'background-color:#FFF8CE;';?>">
        <td width="1%" align="left"><?=$i+1?></td>
       <td width="2%" align="left"> <a href="index.php?_page=add_edit_testimonial&action=edit&id=<?=$recordsList[$i]['id']?>"><?=$recordsList[$i]['photo'] != '' ? '<img src="../images/testimonial/'.$recordsList[$i]['photo'].'" width="50" height="50px;"  />' : ''?><a/></td>
       <td width="10%" align="left"><a href="index.php?_page=add_edit_testimonial&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['name'])?><a/></td>
      <td width="13%" align="left"><?=no_magic_quotes($recordsList[$i]['position'])?></td>
      <td width="13%" align="left"><?=no_magic_quotes($recordsList[$i]['company'])?></td>
      <td width="44%" align="left"><?=no_magic_quotes($recordsList[$i]['testimonial'])?></td>
      <td width="5%" align="left"><?=$recordsList[$i]['status']?></td>
      <td width="3%" align="left"><?=$recordsList[$i]['updated_on']?></td>
      <td width="9%" align="left"><a href="index.php?_page=add_edit_testimonial&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
    <a href="index.php?_page=manage-testimonial&action=delete&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
  </tr>

      </li>
  
<? } ?>
</tbody>
</table>

</div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->
