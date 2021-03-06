<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE lifestyles SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Set to status deleted.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
$sort	= 'category';
	
$query = "select * from lifestyles WHERE $status ORDER BY lifestyle";
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
			$(location).attr('href','index.php?_page=manage-lifestyles&status='+$(this).val());
		});
	});
</script>
<? ############################################################################################## ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li class="active">
        <strong>Lifestyles</strong>
    </li>

</ol>

<a href="index.php?_page=add_edit_lifestyles">
    <button type="button" class="btn btn-primary btn-lg btn-icon pull-right">
        New Entry
        <i class="entypo-plus"></i>
    </button>        
</a>
        
<div class="col-sm-2" style="padding-left:0;">      
    <select id="status" class="selectboxit" data-first-option="false">
        <?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
    </select> 
</div>
<div style="clear:both; height:15px;"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="4"  class="table table-bordered table-striped datatable" id="table-2">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr>
	<td width="2%" align="left" style="visibility:hidden;">#</td>
    <td width="2%" align="left">#</td>
    <td width="23%" align="left">Lifestyle</td>
    <td width="23%" align="left">Title</td>
    <td width="23%" align="left">Meta Description</td>
    <td width="23%" align="left">Keyword</td>
    <td width="4%" align="left">Status</td>
	<td width="10%" align="left">Last Edited</td>
	<td width="10%" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<tbody>
<? 
	$k=1;
	for ($i=0; $i<count($recordsList); $i++) {
	
?>
		
        <tr>
          <td width="2%" align="left" style="visibility:hidden;"><?=$k?></td> 	
          <td width="2%" align="left"><?=$i+1?></td>
          <td width="23%" align="left">
          	<a href="index.php?_page=add_edit_lifestyles&action=edit&id=<?=$recordsList[$i]['id']?>">
				<strong><?=no_magic_quotes($recordsList[$i]['lifestyle'])?></strong>
            </a>
          </td>
          
          <td width="23%" align="left">
          	<a href="index.php?_page=add_edit_lifestyles&action=edit&id=<?=$recordsList[$i]['id']?>">
				<strong><?=no_magic_quotes($recordsList[$i]['title_tag'])?></strong>
            </a>
          </td>
          
          <td width="23%" align="left">
          	<a href="index.php?_page=add_edit_lifestyles&action=edit&id=<?=$recordsList[$i]['id']?>">
				<strong><?=no_magic_quotes($recordsList[$i]['meta_description'])?></strong>
            </a>
          </td>
          
          <td width="23%" align="left">
          	<a href="index.php?_page=add_edit_lifestyles&action=edit&id=<?=$recordsList[$i]['id']?>">
				<strong><?=no_magic_quotes($recordsList[$i]['meta_keywords'])?></strong>
            </a>
          </td>
          
          
          <td width="4%" align="left"><?=$recordsList[$i]['status']?></td>
          <td width="10%" align="left"><?=$recordsList[$i]['updated_on'] == '0000-00-00 00:00:00' ? date('d-m-Y, h:i a',strtotime($recordsList[$i]['inserted_on'])) : date('d-m-Y, h:i a',strtotime($recordsList[$i]['updated_on'])) ?></td>
          <td width="10%" align="left">
          	<a href="index.php?_page=add_edit_lifestyles&action=edit&id=<?=$recordsList[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                <i class="entypo-pencil"></i>
                Edit                
            </a>
            
            <a href="index.php?_page=manage-lifestyles&action=delete&id=<?=$recordsList[$i]['id']?>"  onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                <i class="entypo-cancel"></i>
                Delete				
            </a>
          </td>
        </tr>
	
        

  
<? $k++;
	}
?>
</tbody>
</table>