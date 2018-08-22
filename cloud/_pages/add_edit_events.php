<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$event_name 	= addslashes(remove_sp_characters($_REQUEST['event_name']));
		$event_date 	= ($_REQUEST['event_date'] == '' ? '' : convertToMysqlDate($_REQUEST['event_date'], '/'));
		
		$time_from		= $_REQUEST['time_from_hour'].':'.$_REQUEST['time_from_min'].':00';
		$time_to		= $_REQUEST['time_to_hour'].':'.$_REQUEST['time_to_min'].':00';
		
		
		$event_repeat	= addslashes($_REQUEST['event_repeat']);
		$repeat_until	= ($_REQUEST['repeat_until'] == '' ? '' : convertToMysqlDate($_REQUEST['repeat_until'], '/'));
		$description 	= addslashes(remove_sp_characters($_REQUEST['description']));
		$url			= addslashes($_REQUEST['url']);
		$event_type		= addslashes($_REQUEST['event_type']);

		$status			= addslashes($_REQUEST['status']);
	
		if($_FILES['event_img']['size'] > 0)	{
			$filename	= '../images/events/'.$_FILES['event_img']['name'];
			$img_name	= $_FILES['event_img']['name'];
			copy($_FILES['event_img']['tmp_name'],$filename);
			
			$filename	= '../images/events/thumb/'.$_FILES['event_img']['name'];
			$thumb_name	= $_FILES['event_img']['name'];
			ResizeImage($_FILES['event_img']['tmp_name'], THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, $filename);
		}
		
		$dbFields = array();
		$dbFields['user_id'] 			= $_SESSION['ADMIN_USER_PROFILE']['id'];
		$dbFields['event_name'] 		= $event_name;
		$dbFields['event_date'] 		= $event_date;
		$dbFields['time_from'] 			= $time_from;
		$dbFields['time_to'] 			= $time_to;
		$dbFields['event_repeat'] 		= $event_repeat;
		$dbFields['repeat_until'] 		= $repeat_until;
		$dbFields['description'] 		= $description;
		if($img_name != '')		{
			$dbFields['event_img'] 		= $img_name;
			$dbFields['thumb_img'] 		= $thumb_name;
		}	

		$dbFields['url'] 			= $url;	
		$dbFields['event_type'] 	= $event_type;

		$dbFields['status'] 		= $status;
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Event has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Event has been added.";
		}
		
		dbPerform("events", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
			dbQuery("UPDATE events SET sort_order='$new_id' WHERE id='$new_id'");
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from events WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
	
	$time_from		= explode(':',$recordsList[0]['time_from']);
	$time_from_hour	= $time_from[0];
	$time_from_min	= $time_from[1];
	
	$time_to		= explode(':',$recordsList[0]['time_to']);
	$time_to_hour	= $time_to[0];
	$time_to_min	= $time_to[1];
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

$hourArr	= array();
$hourArr[]	= array("optionId"=>"00","optionText"=>"00");
$hourArr[]	= array("optionId"=>"01","optionText"=>"01");
$hourArr[]	= array("optionId"=>"02","optionText"=>"02");
$hourArr[]	= array("optionId"=>"03","optionText"=>"03");
$hourArr[]	= array("optionId"=>"04","optionText"=>"04");
$hourArr[]	= array("optionId"=>"05","optionText"=>"05");
$hourArr[]	= array("optionId"=>"06","optionText"=>"06");
$hourArr[]	= array("optionId"=>"07","optionText"=>"07");
$hourArr[]	= array("optionId"=>"08","optionText"=>"08");
$hourArr[]	= array("optionId"=>"09","optionText"=>"09");
$hourArr[]	= array("optionId"=>"10","optionText"=>"10");
$hourArr[]	= array("optionId"=>"11","optionText"=>"11");
$hourArr[]	= array("optionId"=>"12","optionText"=>"12");
$hourArr[]	= array("optionId"=>"13","optionText"=>"13");
$hourArr[]	= array("optionId"=>"14","optionText"=>"14");
$hourArr[]	= array("optionId"=>"15","optionText"=>"15");
$hourArr[]	= array("optionId"=>"16","optionText"=>"16");
$hourArr[]	= array("optionId"=>"17","optionText"=>"17");
$hourArr[]	= array("optionId"=>"18","optionText"=>"18");
$hourArr[]	= array("optionId"=>"19","optionText"=>"19");
$hourArr[]	= array("optionId"=>"20","optionText"=>"20");
$hourArr[]	= array("optionId"=>"21","optionText"=>"21");
$hourArr[]	= array("optionId"=>"22","optionText"=>"22");
$hourArr[]	= array("optionId"=>"23","optionText"=>"23");

$minArr	= array();
$minArr[]	= array("optionId"=>"00","optionText"=>"00");
$minArr[]	= array("optionId"=>"15","optionText"=>"15");
$minArr[]	= array("optionId"=>"30","optionText"=>"30");
$minArr[]	= array("optionId"=>"45","optionText"=>"45");


$repeatArr	= array();
$repeatArr[]	= array("optionId"=>"no","optionText"=>"No");
$repeatArr[]	= array("optionId"=>"weekly","optionText"=>"Weekly");
$repeatArr[]	= array("optionId"=>"monthly","optionText"=>"Monthly");

$sql 			=  "SELECT id AS optionId, event_type AS optionText FROM event_type WHERE status='active'";
$eventTypeArr	= dbQuery($sql);
?>

<? ############################################################################################## ?>
<!-- DATE PICKER -->
	<script>
		$(document).ready(function(){
			//$('#date').datepicker({ dateFormat:'dd/mm/yy' , minDate: '-0D' });
			//$('#rdate').datepicker({ dateFormat:'dd/mm/yy' , minDate: '-0D' });
			
			$('#submit').click(function()	{
				$('#form_event').submit();
			})
			
			$('#event_type').change(function()	{
				if($(this).val() == 'new')
					$(location).attr('href','index.php?_page=add_edit_eventtype');
			})
		});
	</script>
	<script language="javascript">
		var valRules=new Array();
		valRules[0]='title:Title|required';
		valRules[1]='phone:Telephone|required';
	</script>
<? ############################################################################################## ?>

<? displayMessages(); ?>
<form id="form_event" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="4" >
        	<a href="index.php?_page=manage-events" id="back" class="button" style="float:right;">Back</a>&nbsp;&nbsp;&nbsp;<button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button>
		</td>
	  </tr> 	
	  
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
	  	<td>
        	Event name:<br />
        	<input type="text" name="event_name" value="<?=no_magic_quotes($recordsList[0]['event_name'])?>" id="form_name" class="pref"  /></td>
	  	<td>
        	Event Type:<br />
	  		<select name="event_type" id="event_type">
            	<option value="">Select</option>
	  			<?=htmlOptions($eventTypeArr, $recordsList[0]['event_type']);?>
                <option value="new">Add new event type</option>
	  		</select>	  	</td>
        
	  </tr>
      
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Event Date: (FORMAT: dd/mm/yyyy)<br />
	        <input type="text" name="event_date" value="<?=$recordsList[0]['event_date'] != '' ? convertMysqlToDate($recordsList[0]['event_date'], '-') : date('d/m/Y'); ?>" id="date"  />		  
        </td>
        
        <td>
        	Time from / to:<br />
        	<div style="float:left;"><select name="time_from_hour" style="width:60px; "><?=htmlOptions($hourArr, $time_from_hour);?></select></div><div style="float:left;"><select name="time_from_min" style="width:60px; "><?=htmlOptions($minArr, $time_from_min);?></select> </div> 
            <div class="clear"></div>
            until<br />
	  		<div style="float:left;"><select name="time_to_hour" style="width:60px; "><?=htmlOptions($hourArr, $time_to_hour);?></select></div><div style="float:left;"><select name="time_to_min" style="width:60px; "><?=htmlOptions($minArr, $time_to_min);?></select> </div>       
		</td>
	  		
  </tr>
     
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
	  	<td>
        	Repeat:<br />
	  		<select name="event_repeat">
	  			<?=htmlOptions($repeatArr, $recordsList[0]['event_repeat']);?>
	  		</select>	  	</td>
		<td width="37%">
        	Repeat Until (Date): (FORMAT: dd/mm/yyyy)<br />
        	<input type="text" name="repeat_until" value="<?=$recordsList[0]['event_date'] != '' ? convertMysqlToDate($recordsList[0]['repeat_until'], '-') : date('d/m/Y'); ?>" id="rdate"  /></td>
  </tr>

	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td>
        	Event description:<br />
        	<textarea name="description" rows="10" style="width: 95%"><?=no_magic_quotes($recordsList[0]['description'])?></textarea></td>
		<td>
        	Url:<br />
        	<input type="text" name="url" value="<?=$recordsList[0]['url']?>" id="form_name" class="pref"  /></td>
	  </tr>
      
	<tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">		
    	<td>Event Image:&nbsp;<br />
		  <?=$recordsList[0]['event_img'] != '' ? '<img src="../images/events/thumb/'.$recordsList[0]['event_img'].'" />' : ''?>	
          <input type="file" name="event_img"  />    
	    </td>
		<td>
        	Status:<br />
			<select name="status">
				<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
			</select>		</td>
  </tr>
</table>
