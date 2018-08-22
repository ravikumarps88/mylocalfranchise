<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE portfolio SET status='deleted'  WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Form has been deleted.";	
}
//---------------------------------------------------------------------------------------------------

if ($action=="duplicate") {
	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
if($_REQUEST['sort'] == 'title')
	$sort	= 'title,';
if($_REQUEST['category'])
	$categ	= "AND category LIKE '%{$_REQUEST['category']}%'";	
	
$query 		= "select * from portfolio WHERE $status $categ ORDER BY $sort sort_order";
$recordsList= dbQuery($query);

$query 		= "select * from portfolio_categ WHERE status='active' ORDER BY category";
$categList 	= dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){
			$(function() {
				$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&update=update&table=portfolio'; 
					$.post("update_sortorder.php", order, function(theResponse){
						//alert(theResponse);
					}); 															 
				}								  
				});
			});
			
			//showing by status
			$('#status').change(function()	{
				$(location).attr('href','index.php?_page=manage-portfolio&status='+$(this).val());
			});
		});
	</script>
<? ############################################################################################## ?>
Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select> 
        <span style="float:right;margin-top: -33px;">		
        <? foreach($categList as $val)	{ ?>
            <a href="index.php?_page=manage-portfolio&category=<?=$val['id']?>&status=<?=$_REQUEST['status']?>"  class="button <?=$_REQUEST['category']==$val['id'] ? 'active' : '';?>"  style="float:right;"><?=$val['category']?></a>
        <? }?>
        <a href="index.php?_page=manage-portfolio&status=<?=$_REQUEST['status']?>"  class="button <?=$_REQUEST['category']=='' ? 'active' : '';?>"  style="float:right;">All</a>
        <a href="index.php?_page=add_edit_portfolio&category=<?=$_REQUEST['category']?>" class="button"  style="float:right;">New Portfolio&nbsp;<img src="images/icons/add.png" title="New Portfolio" alt="New Portfolio"  /></a>
		</span>
<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/images-stack.png" alt="" width="16"
            height="16">
            <h3>Portfolio</h3>
            <span></span>
        </div>
        <div class="content">
            <ul class="gallery">
<?
	foreach($recordsList as $val)	{
?>                    

                <li>
                    <a href="../images/portfolio/slideshow/<?=$val['slideshow_img']?>" rel="prettyPhoto[gallery1]">
                    <img src="../images/portfolio/thumb/<?=$val['slideshow_img']?>" width="220" height="75">
                    </a>
                    <ul class="action-list">
                        <li style="margin:0;">
                            Actions
                        </li>
                        <li>
                            <a href="index.php?_page=add_edit_portfolio&action=edit&id=<?=$val['id']?>&category=<?=$_REQUEST['category']?>">Edit</a>
                        </li>
                        <li>
                            <a href="index.php?_page=manage-portfolio&action=delete&id=<?=$val['id']?>&category=<?=$_REQUEST['category']?>" onclick="return confirm ('Are you sure?');">Remove</a>
                        </li>
                    </ul>
                </li>
<?
	}
?>            

            </ul>
        </div> <!-- End of .content -->
    </div> <!-- End of .box -->
</div> <!-- End of .grid_12 -->