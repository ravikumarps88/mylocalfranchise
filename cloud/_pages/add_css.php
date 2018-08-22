<?
//---------------------------------------------------------------------------------------------------
if($_REQUEST['add_css'])	{
	$css_id	 	= addslashes($_REQUEST['css']);
	$template_id= addslashes($_REQUEST['tid']);

	$dbFields = array();
	$dbFields['css_id'] 		= $css_id;
	$dbFields['template_id'] 	= $template_id;	

	$specialFields = array();

	$dbFields['inserted_on'] 		= 'now()';
	$specialFields = array('inserted_on');	
	$INFO_MSG = "CSS association has been added.";
	
	dbPerform("template_css", $dbFields, $specialFields, $cond);
}
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("DELETE FROM  template_css WHERE id='{$_REQUEST['assoc_id']}'");
	$INFO_MSG = "CSS Association with the template has been deleted.";	
}
//---------------------------------------------------------------------------------------------------
$query 	= "select c.*,tc.id as tcid from css c LEFT JOIN template_css tc ON c.id=tc.css_id WHERE template_id='{$_REQUEST['tid']}'";
$recordsList = dbQuery($query);

$sql		=  "SELECT css_id FROM template_css WHERE template_id='{$_REQUEST['tid']}'";
$css_arr	= dbQuery($sql);
foreach($css_arr as $val)	{
	$css_ids	.= $val['css_id'].',';
}
$css_ids	= ($css_ids == "" ? 0 : substr($css_ids,0,strlen($css_ids)-1));

$sql	=  "SELECT id AS optionId, css_name AS optionText FROM css WHERE status='active' AND id NOT IN ($css_ids)";
$cssArr	= dbQuery($sql);
?>

<? ############################################################################################## ?>
<? displayMessages(); ?>

<a href="index.php?_page=manage-templates">
    <button type="button" class="btn btn-default btn-icon pull-right">
        Back
        <i class="entypo-plus"></i>
    </button>        
</a>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-bordered table-striped datatable" id="table-2">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr class="headerRow">
    <td width="8" align="left">#</td>
    <td width="238" align="left">CSS</td>
    <td width="238" align="left">Media Type</td>
    <td width="238" align="left">Status</td>
    <td width="225" align="left">Added/Edited</td>
	<td width="83" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
</thead>
<tbody>
<? for ($i=0; $i<count($recordsList); $i++) {?>

			<tr>
                <td width="24" align="left"><?=$i+1?></td>
              
              <td width="220" align="left"><?=$recordsList[$i]['css_name']?></td>
              <td width="220" align="left"><?=$recordsList[$i]['media_type']?></td>
              <td width="220" align="left"><?=$recordsList[$i]['status']?></td>
              <td width="239" align="left"><?=$recordsList[$i]['updated_on'] == '0000-00-00 00:00:00' ? $recordsList[$i]['inserted_on'] : $recordsList[$i]['updated_on'] ?></td>
              <td width="88" align="left">
              <a href="index.php?_page=add_edit_css&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
			<a href="index.php?_page=add_css&action=delete&assoc_id=<?=$recordsList[$i]['tcid']?>&tid=<?=$_REQUEST['tid']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure want to delete the association?');" title="Delete" alt="Delete" /></a></td>
          </tr>

  
<? } ?>
</tbody>
</table>   

<form action="" method="post">
<input type="hidden" name="tid" value="<?=$_REQUEST['tid']?>" />

<div class="form-group">
    <label class="col-sm-1 control-label">Add a Stylesheet</label>
    
    <div class="col-sm-2">
        <select name="css" class="selectboxit">
			<?=htmlOptions($cssArr);?>
        </select>
        
    </div>
    
    <div class="col-sm-2">
        <button name="add_css" type="submit" class="btn btn-primary">Add</button>
    </div>
</div>
            
</form>