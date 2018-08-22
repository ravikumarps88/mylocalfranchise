<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE news_categories SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Category has been set to status 'deleted'.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
$sort	= 'category';
if($_REQUEST['sort'] == 'category')
	$sort	= 'category';
	
$query = "select * from news_categories WHERE $status ORDER BY $sort";
$recordsList = dbQuery($query);


$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusArr[]	= array("optionId"=>"all","optionText"=>"All");
?>
<? ############################################################################################## ?>
<script>
	$(document).ready(function(){

		//showing by status
		$('#status').change(function()	{
			$(location).attr('href','index.php?_page=news_categories&status='+$(this).val());
		});
	});
</script>
<? ############################################################################################## ?>
Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_news_categories" class="button"  style="float:right;margin-top: -33px;">New Category&nbsp;<img src="images/icons/add.png" title="New Category" alt="New Category"  /></a>
<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/shadeless/table-excel.png" width="16" height="16">
            <h3>Blog/News Category</h3><span></span>
        </div>
        <div class="content">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table" id="table-example">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr>
    <td width="2%" align="left">#</td>
    <td width="23%" align="left"><a href="index.php?_page=news_categories&sort=lastname">Category</a></td>
    <td width="4%" align="left">Status</td>
	<td width="10%" align="left">Last Edited</td>
	<td width="10%" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<? for ($i=0; $i<count($recordsList); $i++) {?>
		<tbody>
			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
           	 
	          <td width="2%" align="left"><?=$i+1?></td>
              <td width="23%" align="left"><a href="index.php?_page=add_edit_news_categories&action=edit&id=<?=$recordsList[$i]['id']?>"><?=$recordsList[$i]['category']?></a></td>
              <td width="4%" align="left"><?=$recordsList[$i]['status']?></td>
              <td width="10%" align="left"><?=$recordsList[$i]['updated_on'] == '0000-00-00 00:00:00' ? date('d-m-Y, h:i a',strtotime($recordsList[$i]['inserted_on'])) : date('d-m-Y, h:i a',strtotime($recordsList[$i]['updated_on'])) ?></td>
              <td width="10%" align="left">
              <a href="index.php?_page=add_edit_news_categories&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
              
			  <a href="index.php?_page=news_categories&action=delete&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
  			</tr>
		</tbody>
<? } ?>
</table>

        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->  