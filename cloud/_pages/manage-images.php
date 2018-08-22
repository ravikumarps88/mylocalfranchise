<?
//---------------------------------------------------------------------------------------------------
if ($action=="delete") {
	dbQuery("UPDATE images SET status='deleted' WHERE id='{$_REQUEST['id']}'");
	$INFO_MSG = "image has been deleted.";	
}
//---------------------------------------------------------------------------------------------------
$status	= ($_REQUEST['status'] == 'all' ? '1' : "status='".($_REQUEST['status'] == 'deleted' ? 'deleted' : ($_REQUEST['status'] == 'inactive' ? 'inactive' : 'active'))."'");
$query = "select * from images WHERE $status ORDER BY sort_order";
$recordsList = dbQuery($query);

?>
<? ############################################################################################## ?>

	
	<script>
		$(document).ready(function(){
			$(function() {
				$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&update=update'; 
					$.post("update_images.php", order, function(theResponse){
						//alert(theResponse);
					}); 															 
				}								  
				});
			});
			
			//showing by status
			$('#status').change(function()	{
				$(location).attr('href','index.php?_page=manage-images&status='+$(this).val());
			});
			
			$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto();
		});
	</script>
<? ############################################################################################## ?>

<ol class="breadcrumb bc-3">
    <li>
        <a href="index.php?_page=home"><i class="entypo-home"></i>Home</a>
    </li>
    <li class="active">
        <strong>Manage Images</strong>
    </li>
    
</ol>

<a href="index.php?_page=add_edit_images">
    <button type="button" class="btn btn-primary btn-lg btn-icon pull-right">
        New Image
        <i class="entypo-camera"></i>
    </button>        
</a>

<a href="index.php?_page=bulk_images">
    <button type="button" class="btn btn-primary btn-lg btn-icon pull-right">
        Group/Bulk Upload
        <i class="entypo-picture"></i>
    </button>        
</a>
        
<div class="col-sm-2" style="padding-left:0;">      
    <select id="status" class="selectboxit" data-first-option="false">
        <?=htmlOptions($statusShowArr, $_REQUEST['status']);?>
    </select> 
</div>

<div class="gallery-env" style="clear:both;">
<hr />
	<div class="row gallery">
	
<?
	foreach($recordsList as $val)	{
?>  	

		<div class="col-sm-2 col-xs-4" data-tag="1d">
        
            <article class="image-thumb">
                
                <a href="../upload/<?=$val['images_img']?>" rel="prettyPhoto[gallery1]" class="image">
                    <img src="../upload/thumbnail/<?=$val['images_img']?>" >
                </a>
                
                <div class="image-options">
                    <a href="index.php?_page=add_edit_images&action=edit&id=<?=$val['id']?>" class="edit"><i class="entypo-pencil"></i></a>
                    <a href="index.php?_page=manage-images&action=delete&id=<?=$val['id']?>" class="delete"><i class="entypo-cancel"></i></a>
                </div>
                
            </article>
        
        </div>
<?
	}
?>            

	</div>
</div>
    