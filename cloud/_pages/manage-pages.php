<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE pages SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Pages has been deleted.";	
}
//---------------------------------------------------------------------------------------------------

if ($action=="duplicate") {
	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");

$content_type	= ($_REQUEST['content_type'] == 'dynamic' ? " AND content_type='dynamic'" : ($_REQUEST['content_type']=='' ? '' : " AND (content_type='content' || content_type='external')"));

$query = "select * from pages WHERE $status $content_type AND parent_id='-1' ORDER BY sort_order";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){
			$(function() {
				$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&update=update&table=pages'; 
					$.post("update_sortorder.php", order, function(theResponse){
						//alert(theResponse);
					}); 															 
				}								  
				});
				
				//showing by status
				$('#status').change(function()	{
					$(location).attr('href','index.php?_page=manage-pages&status='+$(this).val());
				});
				
			});
		});
	</script>
<? ############################################################################################## ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li class="active">
        <strong>Manage Pages</strong>
    </li>
  
</ol>

<a href="index.php?_page=add_edit_pages">
    <button type="button" class="btn btn-primary btn-lg btn-icon pull-right">
        New Page
        <i class="entypo-plus"></i>
    </button>        
</a>
        
<div class="col-sm-2" style="padding-left:0;">      
    <select id="status" class="selectboxit">
        <?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
    </select> 
</div>
<div style="clear:both; height:15px;"></div>
<? if (count($recordsList)==0) { ?>
	<div>No records found!</div>
<? } else { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="4"  class="table table-bordered table-striped datatable" id="table-2">
	<thead>
  <tr>
    <td width="4%" align="left">#</td>
    <td width="14%" align="left">Page</td>
    <td width="22%" align="left">Title</td>    
    <td width="11%" align="left">Template</td>    
    <td width="31%" align="left">URL</td>    
    <td width="5%" align="left">Status</td>

	<td width="13%" align="right">Actions</td>
  </tr>
 
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
              
              <td width="4%" align="left"><?=$i+1?>.</td>
              
              <td width="14%" align="left">
			  	<?=$recordsList[$i]['parent_id'] != '-1' ? '&nbsp;&nbsp;&nbsp;' : ''?><a href="index.php?_page=add_edit_pages&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['page_name'])?></a>
              </td>
              
              <td width="22%" align="left"><?=no_magic_quotes($recordsList[$i]['title_tag'])?></td>
              
              <td width="11%" align="left"><?=getTemplateName($recordsList[$i]['template_id'])?></td>
              
              <td width="31%" align="left">
              	<a href="<?=APP_URL.'/'.$recordsList[$i]['page_alias'].'.html'?>" target="_blank"><?=APP_URL.'/'.$recordsList[$i]['page_alias'].'.html'?></a>              </td>
              
              <td width="5%" align="left"><?=$recordsList[$i]['status']?></td>
              
              <td width="13%" align="right">
              	
                <a href="index.php?_page=add_edit_pages&action=edit&id=<?=$recordsList[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                	<i class="entypo-pencil"></i>
					Edit                </a>
				
                <a href="index.php?_page=manage-pages&action=delete&id=<?=$recordsList[$i]['id']?>"  onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                	<i class="entypo-cancel"></i>
					Delete				</a>              </td>
              
          </tr>
          </tbody>
         </table>     
      </li>
<?
	$query 			= "select * from pages WHERE $status $content_type AND parent_id='{$recordsList[$i]['id']}' ORDER BY sort_order";
	$subRecordsList = dbQuery($query);
 	for ($j=0; $j<count($subRecordsList); $j++) {?>
		<li id="arrayorder_<?=$subRecordsList[$j]['id']?>" style="<?=$j%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="4"  id="" class="table" >
        	<tbody>
			<tr>
              
              <td width="4%" align="left">&nbsp;&nbsp;<?=($i+1).'.'.($j+1)?>.</td>
              
              <td width="14%" align="left">&nbsp;&nbsp;<a href="index.php?_page=add_edit_pages&action=edit&id=<?=$subRecordsList[$j]['id']?>"><?=no_magic_quotes($subRecordsList[$j]['page_name'])?></a></td>
              
              <td width="22%" align="left"><?=no_magic_quotes($subRecordsList[$j]['title_tag'])?></td>
              
              <td width="11%" align="left"><?=getTemplateName($subRecordsList[$j]['template_id'])?></td>
              
              <td width="31%" align="left"><?=APP_URL.'/'.$subRecordsList[$j]['page_alias'].'.html'?></td>
              
              <td width="5%" align="left"><?=$subRecordsList[$j]['status']?></td>
              
              <td width="13%" align="right">
              	<a href="index.php?_page=add_edit_pages&action=edit&id=<?=$subRecordsList[$j]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                	<i class="entypo-pencil"></i>
					Edit                </a>
				
                <a href="index.php?_page=manage-pages&action=delete&id=<?=$subRecordsList[$j]['id']?>"  onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                	<i class="entypo-cancel"></i>
					Delete				</a>              </td>
              
          </tr>
          </tbody>
         </table>     
      </li>
    
      
  
<?
	}
 } 
?>
</ul>
</div>

</table>
<? }?> 