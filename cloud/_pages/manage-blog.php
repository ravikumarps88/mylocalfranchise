<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE news SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Blog entry has been deleted.";	
}

//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
$sort = 'id';
if($_REQUEST['sort'] == 'status')
	$sort	= 'status';
	
$query = "select * from news WHERE $status ORDER BY sort_order ASC";
$recordsList = dbQuery($query);


$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusArr[]	= array("optionId"=>"all","optionText"=>"All");
?>


<?

if ($action=="postfb") {

	$dzid 		= $_REQUEST['id'];
	$dztitle 	= $_REQUEST['title'];
	
		
	//posting to facebook
	include_once '../lib/facebook_app/php/facebook.php';
	define('FB_APIKEY', 'caf2cc5e987b869f431eb79b9b9fd623');
	define('FB_SECRET', 'd46f00e4cfd87bcda6f11dc079835001');
	define('FB_SESSION', '0e1bf18305af42696dbe9031-100002017580571');

	try {
		$facebook = new Facebook(FB_APIKEY, FB_SECRET);
		$facebook->api_client->session_key = FB_SESSION;
		$fetch = array('friends' =>
		array('pattern' => '.*',
		'query' => "select uid2 from friend where uid1={$user}"));
		$facebook->api_client->admin_setAppProperties(array('preload_fql' => json_encode($fetch)));
		
		$message = $dztitle .  'http://www.wine-source.com/blog'.$dzid.'-'.urlencode(no_magic_quotes(str_replace("/","",$dztitle)));
		
		if( $facebook->api_client->stream_publish($message))
			$INFO_MSG .= "Blog entry [" . $dztitle . "] has been posted to Facebook. (ID: " . $dzid . ')';
	} 
	catch(Exception $e) {
		$INFO_MSG .= 'Posting to Facebook failed';
	}
}


if ($action=="tweet") {
	$dzid 		= $_REQUEST['id'];
	$dztitle 	= $_REQUEST['title'];
	$message = $dztitle .  '&nbsp;-&nbsp;http://www.wine-source.com/blog'.$dzid.'-'.urlencode(no_magic_quotes(str_replace("/","",$dztitle)));
	
	define('OAUTH_CONSUMER_KEY', 'O7b635vzIF89mRoxOYMWHQ');
	define('OAUTH_CONSUMER_SECRET', 'VwwUJ9BvI4ZD91t5ovKTVwhASqHzmExn0lKBf7rTjZ8');
	
	$access_token='177226298-JHd586TYrrV4wUDLzRYr66S8Ig6xZHzZjux2IUZr';
	$access_token_secret='hba0UjoZvRuuEU6osJT7ENzan5yOJe0VeHqWZTM4yMg';
	$tweet = $message;
	
	// POST a tweet using OAuth authentication
	$retarr = post_tweet(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET,
							   $tweet, $access_token, $access_token_secret,
							   true, true);
	
	// check for success or failure
	if ($retarr[0][http_code] == 200) {
		$INFO_MSG .= "Successfully tweeted.";
		
	} else {
		$INFO_MSG .= "Tweet failed";
	}
}

?>

<?

//---------------------------------------------------------------------------------------------------

if ($action=="approve") {
	dbQuery("UPDATE news SET status='approved',updated_on=now() WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "News has been approved.";	
}

//---------------------------------------------------------------------------------------------------

//if($_REQUEST['sort'] == 'title')
//	$sort	= 'id,';
//$query = "select * from news WHERE status!='deleted' ORDER BY sort_order DESC";
//$recordsList = dbQuery($query);

?>



<? ############################################################################################## ?>

	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
	<script>
		$(document).ready(function(){
			$(function() {
				$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&update=update&table=news'; 
					$.post("update_sortorder.php", order, function(theResponse){
						//alert(theResponse);
					}); 															 
				}								  
				});
			});
		});
	</script>
<? ############################################################################################## ?>

<script>
	$(document).ready(function(){

		//showing by status
		$('#status').change(function()	{
			$(location).attr('href','index.php?_page=manage-blog&status='+$(this).val());
		});
	});
</script>
<? ############################################################################################## ?>

Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select>    
        &nbsp;&nbsp;&nbsp;
        <a href="index.php?_page=add_edit_blog" class="button"  style="float:right;margin-top: -33px;">New Blog&nbsp;<img src="images/icons/add.png" title="New Blog" alt="New Blog"  /></a>
<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/shadeless/table-excel.png" width="16" height="16">
            <h3>Blog/News</h3><span></span>
        </div>
        <div class="content">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table" id="table-example">
	<thead>
<? if (count($recordsList)==0) { ?>
	<tr><td colspan="9" style="border:none; padding:0px;">No records found!</td>
<? } else { ?>
  <tr>
    <td width="1%" align="left">#</td>
    <td width="4%" align="left">Image</td>
    <td width="10%" align="left"><a href="index.php?_page=manage-blog&sort=user">User</a></td>
    <td width="9%" align="left"><a href="index.php?_page=manage-blog&sort=category">Category</a></td>
    <td width="22%" align="left"><a href="index.php?_page=manage-blog&sort=title">News title</a></td>
	<td width="13%" align="left"><a href="index.php?_page=manage-blog&sort=status">Status</a></td>
	<td width="11%" align="left">Actions</td>
  </tr>
<? }?>  
</tr>
	</thead>
<? for ($i=0; $i<count($recordsList); $i++) {?>
       	<tbody>
			<tr style="<?=$i%2==0 ? 'background-color:#FFF;' : 'background-color:#F4F4F8;';?>">
                <td width="1%" align="left"><?=$i+1?></td>
              <td width="4%" align="left"><a href="index.php?_page=add_edit_blog&action=edit&id=<?=$recordsList[$i]['id']?>"><?=$recordsList[$i]['image'] != '' ? '<img src="../images/news/'.$recordsList[$i]['image'].'" width="50" height="50" />' : ''?></a></td>
			  <td width="10%" align="left"><?=ucfirst(no_magic_quotes(getUser($recordsList[$i]['user_id'])))?></td>
			  <td width="9%" align="left"><?=getNewsCategory(no_magic_quotes($recordsList[$i]['category']))?></td>
              <td width="22%" align="left"><a href="index.php?_page=add_edit_blog&action=edit&id=<?=$recordsList[$i]['id']?>"><?=no_magic_quotes($recordsList[$i]['title'])?></a></td>
              <td width="13%" align="left"><?=$recordsList[$i]['status']?></td>	
              <td width="11%" align="left">
              <a href="index.php?_page=add_edit_blog&action=edit&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/edit.png" title="Edit" alt="Edit" /></a>&nbsp;&nbsp;
			<a href="index.php?_page=manage-blog&action=delete&id=<?=$recordsList[$i]['id']?>"><img src="images/icons/delete.png"  onclick="return confirm ('Are you sure?');" title="Delete" alt="Delete" /></a>&nbsp;&nbsp;
			<!--<a title="Post to Facebook"  href="index.php?_page=manage-blog&action=postfb&id=<?=$recordsList[$i]['id']?>&title=<?=$recordsList[$i]['title']?>"><span style="font-size: 9px"><img src="./images/facebook.png"></span></a>&nbsp;&nbsp;
            <a title="Post to Twitter" href="index.php?_page=manage-blog&action=tweet&id=<?=$recordsList[$i]['id']?>&title=<?=$recordsList[$i]['title']?>"><span style="font-size: 9px"><img src="./images/twitter.png"></span></a>-->
            <!--<img src="./images/linkedin.png" title="LinkedIn Posting Disabled" style="margin-left: 5px; cursor: wait; opacity: .2"/>-->
            
				</td>
          </tr>
          <tbody>
<? } ?>
</table>     

        </div> <!-- End of .content -->
        <div class="clear"></div>
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->