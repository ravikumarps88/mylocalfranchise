<?
require "../lib/app_top_admin.php";
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
if($_REQUEST['action'] == 'edit')	{
	$query = "select * from vouchers WHERE id='{$_REQUEST['id']}'";
	$recordsList = dbQuery($query);
}
//---------------------------------------------------------------------------------------------------
$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"pending","optionText"=>"Pending");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");

?>

<script src="assets/js/neon-custom.js"></script>

<? ############################################################################################## ?>
<!-- DATE PICKER -->
	<script>
		$(document).ready(function(){
			
			$('a[rel=img]').click(function()	{
				$('#jkimg').load("delete_image.php?id="+$(this).attr('id')+"&type=vouchers");	
			});
			
			$("#category_id,#sub_category_id").show();
			$("#category_id_chzn,#sub_category_id_chzn").hide();
			
			$('#category_id').change(function()	{
				$.post('load.php?action=load_sub_categ&category_id='+$(this).val(), function(data) {
	
					if(data.length > 10)	{
						$('#sub_category_id').show();	
						$('#sub_div').css('display','inline');	
						$('#sub_category_id').html('<option value="">Select</option>');			
						$('#sub_category_id').append(data);
					}	
						
				});
			});
			
			$('#voucher_preview').load('load_voucher.php?action=showpreview&vendor_id=<?=$_REQUEST['vendor_id']?>&voucher_id=<?=$_REQUEST['id']?>');
			
			//changing business
			$('#vendor_id').change(function()	{
				$.post('load_voucher.php?action=get_vendor_details&vendor_id='+$(this).val(),function(data)	{
				
					$('#voucher-logo img').attr('src','../upload/vendors/thumbnail/'+data.logo);
					
					str = data.vendor.replace(/\\/g, '')
					$('#voucher-content h2').html(str);
				
				}, "json");
			});
			
			//changing voucher type
			$('.type').click(function()	{
				if($(this).val() == 'online_code')	{
					$('#voucher_preview').hide();
					$('#voucher_code_div').show();
				}	
				else	{
					$('#voucher_preview').show();	
					$('#voucher_code_div').hide();
				}	
			});
			
			//changing voucher headline
			$('#voucher_headline').keyup(function()	{
				$('#voucher-content h1').html($(this).val());
			});
			
			//changing voucher terms
			$('#terms').keyup(function()	{
				$('#terms_span').html($(this).val());	
			});
			
			
			//changing voucher expiry
			$( "#expiry" ).change(function() {
				if($(this).is(":checked")){
					$('#expires').hide();
				}
				else
					$('#expires').show();
			
			});
			
			//changing voucher type
			$('.applyBtn').click(function()	{
				setTimeout(function(){
					$.post('load_voucher.php?action=get_expiry_date&date='+$('.daterange').val(),function(data)	{
						if($("#expiry").is(":checked"))
							$('#expires').hide();
						else
							$('#expires').html('Expires: '+data.expiry_date);
					}, "json");	
				}, 100);	
			});
			
			

		});
	</script>
	
<? ############################################################################################## ?>


        
<form id="rootwizard-2" action="" method="post" enctype="multipart/form-data" class="form-wizard validate">
<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />


<div class="steps-progress">
    <div class="progress-indicator"></div>
</div>

<ul>
    <li class="active">
        <a href="#business" data-toggle="tab"><span>1</span>Business</a>
    </li>
     <li>
        <a href="#categories" data-toggle="tab"><span>2</span>Category</a>
    </li>
    <li>
        <a href="#details" data-toggle="tab"><span>3</span>Details</a>
    </li>
    <li>
        <a href="#tandc" data-toggle="tab"><span>4</span>T's & C's</a>
    </li>
    <li>
        <a href="#validity" data-toggle="tab"><span>5</span>Validity</a>
    </li>
</ul>

<div class="tab-content">

    <div class="tab-pane active" id="business">
        <div class="row">
                
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="vendor_id1">Business</label>
                    
                    <select name="vendor_id" id="vendor_id"  class="select2" data-allow-clear="true" data-validate="required" >
                        <?
						if($_SESSION['ADMIN_USER_PROFILE']['type'] == 'user')	{
						?>
                        	<option value="<?=($recordsList[0]['vendor_id']== '' ? $_REQUEST['vendor_id'] : $recordsList[0]['vendor_id'])?>"><?=getFieldValue(($recordsList[0]['vendor_id']== '' ? $_REQUEST['vendor_id'] : $recordsList[0]['vendor_id']), 'vendor', 'vendors')?></option>
                        <?
						}
						else	{
                        ?>
                        	<option value="">Select Business</option>
                        	<?=htmlOptions($vendorCategArr, ($recordsList[0]['vendor_id']== '' ? $_REQUEST['vendor_id'] : $recordsList[0]['vendor_id']));?>
                        <?
						}
                        ?>
                    </select>
            
                </div>
            </div>
            
            
             <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="type">Voucher Type</label>
                    <div class="radio radio-replace" style="margin-bottom:10px;">
                        <input type="radio" name="type" class="type" value="printable" <?=$recordsList[0]['type']=='printable' || $recordsList[0]['type']==''?'checked="checked"':''?> style="width:20px; display:inline;"   />
                        <label>Printable</label>
                    </div>
                   
                    <div class="radio radio-replace">    
                        <input type="radio" name="type" class="type" value="online_code" <?=$recordsList[0]['type']=='online_code'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                        <label>Online code</label>
                    </div>
                </div>
            </div>
      </div>
    </div>
            
  	
    <div class="tab-pane" id="categories">          
      <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="category_id">Category</label>

                    <select name="category_id" id="category_id" class="select2" data-validate="required">
                        <option value="">Select</option>
                        <?=htmlOptions($voucherCategArr, (getParentId($recordsList[0]['category_id']) == 0 ? $recordsList[0]['category_id'] : getParentId($recordsList[0]['category_id'])));?>
                    </select>
                 </div>
                    
                <div id="sub_div" style="display:<?=$recordsList[0]['category_id'] == 0 ? 'none' : 'inline;'?>">
                    <div class="form-group">
                        <label class="control-label" for="sub_category_id">Sub Category</label>
                      
                        <select name="sub_category_id" id="sub_category_id" class="select2" data-validate="required">
                            <option value="">Select</option>
                            <?=htmlOptions(getSubcategoryArray(getParentId($recordsList[0]['category_id']) == 0 ? $recordsList[0]['category_id'] : getParentId($recordsList[0]['category_id'])), $recordsList[0]['category_id']);?>
                        </select>
                    </div>
                </div>
            
                
            </div>            
           
            
        </div>  
    </div>
    
    
    <div class="tab-pane" id="details">
        <div class="row">
        
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="voucher">Voucher Headline</label>
                    <input type="text" name="voucher" value="<?=no_magic_quotes($recordsList[0]['voucher'])?>" id="voucher_headline" class="form-control" data-validate="required"  />	
                </div>
            </div>
            
            <div class="col-md-12" style="<?=$recordsList[0]['type']=='online_code'?'':'display:none;'?>" id="voucher_code_div">
                <div class="form-group">
                    <label class="control-label" for="voucher_code">Voucher code</label>
                    <input type="text" name="voucher_code" value="<?=no_magic_quotes($recordsList[0]['voucher_code'])?>" id="form_name" class="form-control"  />
            
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="description">More information (Optional)</label>
                    <textarea name="description" class="form-control" id="description" ><?=no_magic_quotes($recordsList[0]['description'])?></textarea>
                </div>
            </div>
            
        </div>  
    </div>
    
    
    

    
    <div class="tab-pane" id="tandc">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="terms">Terms</label>
                    <textarea name="terms" class="form-control" id="terms" ><?=no_magic_quotes($recordsList[0]['terms'])?></textarea>
                    
                </div>
            </div>
            
        </div>  
    </div>
    
    
    <div class="tab-pane" id="validity">
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="dates">Valid Date Range</label>
                    <input type="text" data-validate="required" name="date_range" value="<?=$recordsList[0]['valid_from'] != '' ? convertMysqlToDate(date('Y-m-d',strtotime($recordsList[0]['valid_from'])), '-') : '' ?> - <?=$recordsList[0]['valid_to'] != '' ? convertMysqlToDate(date('Y-m-d',strtotime($recordsList[0]['valid_to'])), '-') : '' ?>" class="form-control daterange" data-format="DD/MM/YYYY" />
            
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <input type="checkbox" id="expiry" name="expiry" style="width:20px; display:inline;" <?=$recordsList[0]['expiry']=='yes'?'checked="checked"':''?>  />No Expiry Date<br />
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary pull-right">Save</button>
                
        </div>  
    </div>
    
    <ul class="pager wizard">
        <li class="previous">
            <a href="#"><i class="entypo-left-open"></i> Previous</a>
        </li>
        
        <li class="next">
            <a href="#">Next <i class="entypo-right-open"></i></a>
        </li>
    </ul>
    
    
</div>

</form>
        
	

