<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE gallery SET status='deleted'  WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "Image has been deleted.";	
}
//---------------------------------------------------------------------------------------------------

if ($action=="duplicate") {
	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
if($_REQUEST['sort'] == 'title')
	$sort	= 'title,';
if($_REQUEST['category'])
	$categ	= "AND category='{$_REQUEST['category']}'";	
	
$query = "select * from gallery WHERE $status $categ ORDER BY $sort sort_order";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	
	<script>
		$(document).ready(function(){
			$(function() {
				$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&update=update&table=gallery'; 
					$.post("update_sortorder.php", order, function(theResponse){
						//alert(theResponse);
					}); 															 
				}								  
				});
			});
			//showing by status
			$('#status').change(function()	{
				$(location).attr('href','index.php?_page=manage-images&status='+$(this).val());
			});
		});
	</script>
<? ############################################################################################## ?>
Show:&nbsp;<select id="status" style="float:right; width:200px;">
        	<?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
        </select> 
        <a href="index.php?_page=add_edit_gallery" class="button"  style="float:right;margin-top: -33px; margin-right:150px;">New Image&nbsp;<img src="images/icons/add.png" title="New Image" alt="New Image"  /></a>
        <a href="index.php?_page=bulk_gallery" class="button"  style="float:right;margin-top: -33px;">Group/Bulk Upload&nbsp;<img src="images/icons/add.png" title="Group/Bulk Upload" alt="Group/Bulk Upload"  /></a>
<div class="grid_12">
    <div class="box">
        <div class="header">
            <img src="img/icons/packs/fugue/16x16/images-stack.png" alt="" width="16"
            height="16">
            <h3>Image Gallery</h3>
            <span></span>
        </div>
        <div class="content" id="list">
            <ul class="gallery">
<?
	foreach($recordsList as $val)	{
?>                    

                <li id="arrayorder_<?=$val['id']?>">
                    <a href="../images/gallery/slideshow/<?=$val['slideshow_img']?>" rel="prettyPhoto[gallery1]">
                    <img src="../images/gallery/thumb/<?=$val['slideshow_img']?>" height="75">
                    </a>
                    <ul class="action-list">
                        <li>
                            Actions
                        </li>
                        <li>
                            <a href="index.php?_page=add_edit_gallery&action=edit&id=<?=$val['id']?>&category=<?=$_REQUEST['category']?>">Edit</a>
                        </li>
                        <li>
                            <a href="index.php?_page=manage-gallery&action=delete&id=<?=$val['id']?>&category=<?=$_REQUEST['category']?>" onclick="return confirm ('Are you sure?');">Remove</a>
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