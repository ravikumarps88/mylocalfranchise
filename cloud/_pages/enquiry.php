<?
if($_REQUEST['franchise_id'])
	$franchise_id	= "franchise_id='{$_REQUEST['franchise_id']}'";		
		
$query = "SELECT * FROM request_details
				WHERE 
					$franchise_id 
				ORDER BY 
					inserted_on";
				
$recordsList = dbQuery($query);
?>
<? ############################################################################################## ?>
	
<script>
	$(document).ready(function(){
		
	});
	
</script>


<? ############################################################################################## ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
	<li>
        <a href="index.php?_page=franchises"><i class="entypo-home"></i>Franchises</a>
    </li>
    <li class="active">
        <strong>Enquiries</strong>
    </li>
</ol>

<div class="row">
				
  <div class="col-md-12">

    <a href="index.php?_page=add_edit_franchise&id=<?=$_REQUEST['franchise_id']?>" class="bs-example">
        <button type="button" class="btn btn-primary btn-icon pull-right">Back <i class="entypo-back"></i></button>
    </a>
    
    <a href="export_enquiries.php?franchise_id=<?=$_REQUEST['franchise_id']?>" class="bs-example">
        <button type="button" class="btn btn-primary btn-icon pull-right">Export <i class="entypo-list"></i></button>
    </a>
   </div>
</div> 

<div style="clear:both; height:15px;"></div>

<? if (count($recordsList)==0) { ?>
	<table style="height:20px;">
    	<tr><td style="border:none; padding:0px;">No enquiries!</td></tr>
    </table>
<? } else {?>  

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-bordered datatable" id="table-1">
	<thead>
	  <tr class="headerRow" >
        <td width="1%" align="left">#</td>
        <td width="15%" align="left">Name</td>
        <td width="14%" align="left">Email</td>
        <td width="14%" align="left">Address</td>
        <td width="11%" align="left">Liquid Capital</td>   
        <td width="11%" align="left">Time Frame</td>   
        <td width="12%" align="left">Preferred Location</td>    
        <td width="22%" align="left">Message</td>
	 </tr>
	</thead>
    
    <tbody>
<? for ($i=0; $i<count($recordsList); $i++) {?>
       	
			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
              <td width="1%" align="left"><?=$i+1?></td>
              
              <td width="15%" align="left"><?=no_magic_quotes($recordsList[$i]['firstname'])?> <?=no_magic_quotes($recordsList[$i]['lastname'])?></td>
              
			  <td width="14%" align="left"><?=no_magic_quotes($recordsList[$i]['email'])?></td>
              
			  <td width="14%" align="left">
			  	<?=no_magic_quotes($recordsList[$i]['address1'])?><br />
                <?=no_magic_quotes($recordsList[$i]['address2'])?><br />
                <?=no_magic_quotes($recordsList[$i]['city'])?>, 
                <?=no_magic_quotes($recordsList[$i]['postcode'])?>
             </td>
              
              <td width="11%" align="left"><?=$recordsList[$i]['liquid_capital']?></td>
              
              <td width="11%" align="left"><?=$recordsList[$i]['timeframe']?></td>
                            
              <td width="12%" align="left"><?=$recordsList[$i]['preferred_location']?></td>	
              
		      <td width="22%" align="left"><?=nl2br($recordsList[$i]['message'])?></td>	
      </tr>
          
<? } ?>
	<tbody>
</table>


<? } ?>