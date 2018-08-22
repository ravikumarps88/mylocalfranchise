<?

//---------------------------------------------------------------------------------------------------

if ($action=="edit") {
	if ($process=="yes") {	
		$id = $_POST['id'];
		//$title = $_POST['title'];
		if($_REQUEST['type'] == 'superadmin')
			$cfgval = $_POST['cfgval_'.$_REQUEST['id']];
		else	
			$cfgval = $_POST['cfgval'];
		
		if ($id=="") {
			header("index.php?_page=settings");
			exit;
		}		
		
		$dbFields = array();
		$dbFields['cfgval'] = $cfgval;

		$specialFields = array();		
		
		dbPerform("config", $dbFields, $specialFields, "id='$id'");
		$INFO_MSG = "Configuration value was edited.";
		$action = "list";
	} else {
		$id = $_GET['id'];
		$title = $_GET['title'];
		$query = "select * from config where id='".mre($id)."'";
		$recordDetails = dbQuery($query, 'single');
		$cfgval 	= $recordDetails['cfgval'];
		$edit_type 	= $recordDetails['edit_type'];
		
		//$validationStr = (trim($recordDetails['validationJs'])!="" ? $recordDetails['validationJs'] : "var valRules=new Array();\nvalRules[0]='cfgval:Config value|required';");
		//$validationStr = (trim($recordDetails['validationJs'])!="" ? $recordDetails['validationJs'] : "var valRules=new Array();");
	}
}

//---------------------------------------------------------------------------------------------------

if ($action=="list") {
	$query = "select * from config where editable='yes' AND type='{$_REQUEST['type']}' order by title";
	$recordsList = dbQuery($query);
}

?>

<? ############################################################################################## ?>



<? if ($action=="list") { ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li class="active">
        <strong>Manage Settings</strong>
    </li>

</ol>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-bordered datatable" id="table-1">
	<thead>
<? if (count($recordsList)==0) { ?>
	
	<tr><td colspan="5" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr>
    <td width="2%">#</td>
    <td width="34%">Configuration</td>
    <td width="56%">Value</td>
    <td width="8%">Action</td>
  </tr>
  </thead>
  <tbody>
  <? for ($i=0; $i<count($recordsList); $i++) {?>
  	
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td><?=$i+1?></td>
		<td><a href="index.php?_page=settings&action=edit&id=<?=$recordsList[$i]['id']?>&title=<?=ue($recordsList[$i]['title'])?>&type=<?=$_REQUEST['type']?>" title="Edit"><?=he($recordsList[$i]['title'])?></a>&nbsp;</td>
		<td>
        	<?if($recordsList[$i]['edit_type'] == 'radio')	{?>    
            	<form name="frmAdd" id="formsettings<?=$recordsList[$i]['id']?>" action="index.php?_page=settings&action=edit&process=yes&type=<?=$_REQUEST['type']?>" method="post">
                    <input type="hidden" name="id" value="<?=$recordsList[$i]['id']?>" />
                    <input type="hidden" name="cfgval_<?=$recordsList[$i]['id']?>" id="cfgval_<?=$recordsList[$i]['id']?>" />
                </form>
                <div id="<?=$recordsList[$i]['id']?>" style="float:left;width:120px; margin-top:10px;"></div>
                <script type="text/javascript">
      
                $('#<?=$recordsList[$i]['id']?>').iphoneSwitch("<?=$recordsList[$i]['cfgval']?>", 
                 function() {
                   $('#cfgval_<?=$recordsList[$i]['id']?>').attr('value','on');
				   $('#formsettings<?=$recordsList[$i]['id']?>').submit();
                  },
                  function() {
                   $('#cfgval_<?=$recordsList[$i]['id']?>').attr('value','off');
				   $('#formsettings<?=$recordsList[$i]['id']?>').submit();
                  },
                  {
                    switch_on_container_path: 'images/iphone_switch_container_off.png'
                  });
              </script>
			<?}else{?>
				<?=he(limitedString($recordsList[$i]['cfgval'], 40))?>&nbsp;
            <?}?>    
        </td>
		<td>
        	<a href="index.php?_page=settings&action=edit&id=<?=$recordsList[$i]['id']?>&title=<?=ue($recordsList[$i]['title'])?>&type=<?=$_REQUEST['type']?>" class="btn btn-default btn-sm btn-icon icon-left">
                <i class="entypo-pencil"></i>
                Edit                
            </a>
             
		</td>
	  </tr>
    	
  <? } ?>
  
<? } ?>
	</tbody>
</table>
        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 --> 
<? } ?>

<? ############################################################################################## ?>

<? if ($action=="edit") { ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li>
        <a href="javascript:history.go(-1)">Manage Settings</a>
    </li>
    <li class="active">
        <strong>Add/Edit Settings</strong>
    </li>
</ol>

<form name="frmAdd" action="index.php?_page=settings&action=edit&process=yes&type=<?=$_REQUEST['type']?>" method="post">
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="title" value="<?=he($title)?>" />

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-bordered datatable" id="table-1">
  <tr>
    <td>
    	Edit Settings - <?=he($title)?>:<br />
    	<?if($edit_type == 'password')	{?>
            <input name="cfgval" type="password" id="cfgval" value="<?=he($cfgval)?>"  class="form-control" />
        <?} else if($edit_type == 'radio')	{?>    
            <input type="hidden" name="cfgval" id="cfgval" />
            <div id="1" style="float:left;width:120px; margin-top:10px;"></div>
            <script type="text/javascript">
  
    $('#1').iphoneSwitch("<?=$cfgval?>", 
     function() {
       $('#cfgval').attr('value','on');
      },
      function() {
       $('#cfgval').attr('value','off');
      },
      {
        switch_on_container_path: 'images/iphone_switch_container_off.png'
      });
  </script>
        <?}else{?>
            <textarea name="cfgval" id="cfgval" class="form-control"><?=he($cfgval)?></textarea>
        <?}?>
    
    	
	</td>
  </tr>
  
  <tr>
    <td colspan="3" style="padding-top:20px; border:none;">	
    	<p class="bs-example">
            <a href="index.php?_page=settings&type=<?=$_REQUEST['type']?>" class="bs-example">
                <button type="button" class="btn btn-primary pull-right">Back</button>
            </a>
                
            <button type="submit" class="btn btn-primary pull-right">Save</button>
		</p>	                
    </td>
  </tr>
</table>

</form>

<? } ?>