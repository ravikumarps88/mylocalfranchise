<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE templates SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "image has been deleted.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
$query = "select * from templates WHERE $status";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){
		
			//showing by status
			$('#status').change(function()	{
				$(location).attr('href','index.php?_page=manage-templates&status='+$(this).val());
			});
		});
	</script>

<? ############################################################################################## ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li class="active">
        <strong>Manage Templates</strong>
    </li>

</ol>

<form role="form" class="form-horizontal form-groups-bordered">

<a href="index.php?_page=add_edit_templates">
<button type="button" class="btn btn-primary btn-lg btn-icon pull-right">
    New Template
    <i class="entypo-plus"></i>
</button>       
</a> 
        
<div class="col-sm-2" style="padding-left:0;">      
    <select id="status" class="selectboxit" data-first-option="false">
        <?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
    </select> 
</div>
<div style="clear:both; height:15px;"></div>
        
<table width="100%" border="0" cellspacing="0" cellpadding="4"   class="table table-bordered table-striped datatable" id="table-2">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr class="headerRow">
    <td width="66" align="left">#</td>
    <td width="512" align="left">Template</td>
    <td width="260" align="left">Status</td>
    <td width="660" align="left">Added/Edited</td>
	<td width="469" align="left">Actions</td>
  </tr>
  </thead>
<? }?>  
</tr>
<tbody>
<? for ($i=0; $i<count($recordsList); $i++) {?>

			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
             
              <td width="66" align="left"><?=$i+1?></td>
              
              <td width="512" align="left"><a href="index.php?_page=add_edit_templates&action=edit&id=<?=$recordsList[$i]['id']?>" style="text-decoration:underline;"><?=$recordsList[$i]['tmp_name']?></a></td>
              
              <td width="260" align="left"><?=$recordsList[$i]['status']?></td>
              
              <td width="660" align="left"><?=$recordsList[$i]['updated_on'] == '0000-00-00 00:00:00' ? date('d-m-Y, h:i s',strtotime($recordsList[$i]['inserted_on'])) : date('d-m-Y, h:i a',strtotime($recordsList[$i]['updated_on'])) ?></td>
              
              <td width="469" align="left">
              	<a href="index.php?_page=add_css&tid=<?=$recordsList[$i]['id']?>" class="btn btn-info btn-sm btn-icon icon-left" >
                	<i class="entypo-info"></i>
					Add CSS                
                </a>
              	
                
              	<a href="index.php?_page=add_edit_templates&action=edit&id=<?=$recordsList[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                	<i class="entypo-pencil"></i>
					Edit                
                </a>
				
                <a href="index.php?_page=manage-templates&action=delete&id=<?=$recordsList[$i]['id']?>" onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                	<i class="entypo-cancel"></i>
					Delete
				</a>
                	
              </td>
    </tr>

  
<? } ?>
</tbody>
</table>

</form>