<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE slideshow_img SET status='deleted' WHERE id='{$_REQUEST['sid']}'");
	$INFO_MSG = "Slide has been deleted.";
	$action	= 'edit';	
}
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		$slideshow 		= addslashes($_REQUEST['slideshow']);
		$slide_width	= addslashes($_REQUEST['slide_width']);
		$slide_height	= addslashes($_REQUEST['slide_height']);
		$transition 	= addslashes($_REQUEST['transition']);
		$speed 			= addslashes($_REQUEST['speed']);
		$pauseonhover 	= addslashes($_REQUEST['pauseonhover']);
		$timeout 		= addslashes($_REQUEST['timeout']);
		$status			= addslashes($_REQUEST['status']);

		$dbFields = array();
		$dbFields['slideshow'] 		= $slideshow;
		$dbFields['slide_width'] 	= $slide_width;
		$dbFields['slide_height']	= $slide_height;
		$dbFields['transition'] 	= $transition;
		$dbFields['speed'] 			= $speed;
		$dbFields['timeout'] 		= $timeout;
		$dbFields['pauseonhover'] 	= $pauseonhover;
		$dbFields['status'] 		= $status;
	
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Slideshow has been edited.";
		}	
		else	{
			$embed_code					= post_slug($_REQUEST['slideshow']);
			$dbFields['embed_code'] 	= "{".$embed_code."}";
			$dbFields['inserted_on'] 	= 'now()';
			$specialFields = array('inserted_on');	
			$INFO_MSG = "Slideshow has been added.";
		}
		
		dbPerform("slideshows", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	
			$new_id		=  mysql_insert_id();
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
}
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
	$query = "select * from slideshows WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

//define transition type array
$transitionArr	= array();
$transitionArr[]	= array("optionId"=>"all","optionText"=>"All");
$transitionArr[]	= array("optionId"=>"scrollLeft","optionText"=>"scrollLeft");
$transitionArr[]	= array("optionId"=>"scrollDown","optionText"=>"scrollDown");

$transitionArr[]	= array("optionId"=>"scrollRight","optionText"=>"scrollRight");
$transitionArr[]	= array("optionId"=>"scrollUp","optionText"=>"scrollUp");
$transitionArr[]	= array("optionId"=>"fade","optionText"=>"fade");

$transitionArr[]	= array("optionId"=>"blindX","optionText"=>"blindX");
$transitionArr[]	= array("optionId"=>"zoom","optionText"=>"zoom");
$transitionArr[]	= array("optionId"=>"blindY","optionText"=>"blindY");

$transitionArr[]	= array("optionId"=>"cover","optionText"=>"cover");
$transitionArr[]	= array("optionId"=>"uncover","optionText"=>"uncover");
$transitionArr[]	= array("optionId"=>"toss","optionText"=>"toss");

$transitionArr[]	= array("optionId"=>"shuffle","optionText"=>"shuffle");
$transitionArr[]	= array("optionId"=>"slideX","optionText"=>"slideX");
$transitionArr[]	= array("optionId"=>"turnLeft","optionText"=>"turnLeft");

$transitionArr[]	= array("optionId"=>"turnRight","optionText"=>"turnRight");
$transitionArr[]	= array("optionId"=>"curtainX","optionText"=>"curtainX");
$transitionArr[]	= array("optionId"=>"turnDown","optionText"=>"turnDown");

$transitionArr[]	= array("optionId"=>"turnRight","optionText"=>"turnRight");
$transitionArr[]	= array("optionId"=>"fadeZoom","optionText"=>"fadeZoom");
$transitionArr[]	= array("optionId"=>"curtainY","optionText"=>"curtainY");
$transitionArr[]	= array("optionId"=>"turnUp","optionText"=>"turnUp");


?>

<? ############################################################################################## ?>

	<script>
		$(document).ready(function(){
		
			$('#submit').click(function()	{
				$('#form_slideshow').submit();
			})
			
			$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&update=update&table=slideshow_img'; 
					$.post("update_sortorder.php", order, function(theResponse){
						//alert(theResponse);
					}); 															 
				}								  
			});
				
			//showing by status
			$('#status').change(function()	{
				$(location).attr('href','index.php?_page=add_edit_slideshows&action=edit&id=<?=$_REQUEST['id']?>&status='+$(this).val());
			});	
		});
	</script>
	<script language="javascript">
		var valRules=new Array();
		valRules[0]='title:Title|required';
		valRules[1]='phone:Telephone|required';
	</script>
<? ############################################################################################## ?>

<? displayMessages(); ?>
<form id="form_slideshow" action="" method="post" enctype="multipart/form-data">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="4" ><span class="right">
    	Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        <a href="index.php?_page=slideshows" id="back" class="button" style="float:right;">Back</a><button style="float:right;"><a id="submit" style="cursor:pointer;">Save</a></button><?if($_REQUEST['id'] != ''){?><a href="index.php?_page=add_edit_slideshow_images&sid=<?=$_REQUEST['id']?>"  class="button" style="float:right;">Add Slide&nbsp;<img src="images/icons/add.png" title="New slideshow" alt="New slideshow"  /></a><?}?></span></td>
	  </tr> 	
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="42%" >
        	Slideshow:<br />
        	<input type="text" name="slideshow" value="<?=$recordsList[0]['slideshow']?>" id="form_name" class="pref" size="70"  /></td>
	  <td width="44%">
      	Status:<br />
			<select name="status">
				<?=htmlOptions($statusArr, $recordsList[0]['status']);?>
			</select>
		</td>
      </tr>
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="42%" >
        	 width (pixels):<br />
        	<input type="text" name="slide_width" value="<?=$recordsList[0]['slide_width']?>" id="form_name" class="tpref" size="70"  /></td>
		<td width="42%" >
        	Slideshow height (pixels):<br />
        	<input type="text" name="slide_height" value="<?=$recordsList[0]['slide_height']?>" id="form_name" class="tpref" size="70"  /></td>
	  </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td width="42%" >
        	Delay (milliseconds):<br />
        	<input type="text" name="speed" value="<?=$recordsList[0]['speed']?>" id="form_name" class="tpref" size="70"  /></td>
		<td width="42%" >
        	Transition (milliseconds):
        	<input type="text" name="timeout" value="<?=$recordsList[0]['timeout']?>" id="form_name" class="tpref" size="70"  /></td>
	  </tr>
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
	  	<td width="44%">
        	Transition:<br />
			<select name="transition">
				<?=htmlOptions($transitionArr, $recordsList[0]['transition']);?>
			</select>
		</td>
		<td>
        	Pause on Hover:<br />
        	
            <input type="hidden" name="pauseonhover" id="pauseonhover" />
            <div id="1" style="float:left;width:120px; margin-top:10px;"></div>
            <script type="text/javascript">
  
			$('#1').iphoneSwitch("<?=$recordsList[0]['pauseonhover']=='yes' ? 'on' : 'off'?>", 
			 function() {
			   $('#pauseonhover').attr('value','yes');
			  },
			  function() {
			   $('#pauseonhover').attr('value','no');
			  },
			  {
				switch_on_container_path: 'images/iphone_switch_container_off.png'
			  });
		  </script>
       </td>
	</tr>
</table>
</form>


<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/shadeless/table-excel.png" width="16" height="16">
            <h3>Slides</h3><span></span>
        </div>
        <div class="content" style="padding:0;">
        
    <div id="list">
    
    <table cellpadding="0" cellspacing="0" border="0" width="100%"  id="" class="table">
    <thead>
    <tr>
      <td width="4%" align="left">#</td>
      <td width="16%" align="left">Thumbnail</td>
      <td width="22%" align="left">Image title</td>
      <td width="22%" align="left">Link URL</td>
      <td width="8%" align="left">Status</td>
      <td width="16%" align="left">Added/Edited</td>
    	<td width="12%" align="left">Actions</td>
    </tr>
    </thead>
    </table>
    <ul style="list-style:none outside; padding:0; margin:0;">
    	
<?
			$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
			$sub_img	= getSlideshowImages($_REQUEST['id'], $status);
			$j=0;
			foreach($sub_img as $val)	{	
				$j++;
?>
			<li id="arrayorder_<?=$val['id']?>" style="<?=$i%2==0 ? 'background-color:#CED5FF;' : 'background-color:#FFF8CE;';?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table" >
            	<tbody>
				<tr>
                  <td width="4%" align="left">&nbsp;&nbsp;<?=$j?></td>
                  <td width="16%" align="left"><a href="index.php?_page=add_edit_slideshow_images&action=edit&id=<?=$val['id']?>&sid=<?=$_REQUEST['id']?>"><?=$val['slideshow_img'] != '' ? '<img src="../images/slideshow/thumb/'.$val['slideshow_img'].'" width="100"  />' : ''?></a></td>
                  <td width="22%" align="left"><a href="index.php?_page=add_edit_slideshow_images&action=edit&id=<?=$val['id']?>&sid=<?=$_REQUEST['id']?>"><?=$val['title']?></a></td>
                  <td width="22%" align="left"><?=$val['url']?></td>
                  <td width="8%" align="left"><?=$val['status']?></td>
                  <td width="16%" align="left"><?=$val['updated_on'] == '0000-00-00 00:00:00' ? date('d-m-Y, h:i s',strtotime($val['inserted_on'])) : date('d-m-Y, h:i a',strtotime($val['updated_on'])) ?></td>
                  <td width="12%" align="left"><a href="index.php?_page=add_edit_slideshow_images&action=edit&id=<?=$val['id']?>&sid=<?=$_REQUEST['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
                	<a href="index.php?_page=add_edit_slideshows&action=delete&sid=<?=$val['id']?>&id=<?=$_REQUEST['id']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a></td>
           	  </tr>
              </tbody>
            </table>
            </li>

<?
			}	
?>          
	</ul>
   	</div> 
        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->      