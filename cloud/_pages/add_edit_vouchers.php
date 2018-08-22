<?
//---------------------------------------------------------------------------------------------------

if ($action=="save") {
		foreach($_REQUEST as $key=>$val)
			$$key	= addslashes($val);

		$date_range	= explode(' - ',$date_range);	
		
		$valid_from	= ($date_range[0] == '' ? 'now()' : "'".convertToMysqlDate($date_range[0], '/')."'");
		$valid_to 	= ($date_range[1] == '' ? 'now()' : "'".convertToMysqlDate($date_range[1], '/')."'");
	
		if($_FILES['image']['size'] > 0)	{
			$filename	= '../upload/vouchers/'.$_FILES['image']['name'];
			$image_name	= $_FILES['image']['name'];
			copy($_FILES['image']['tmp_name'],$filename);
		}
		
		$dbFields = array();
		$dbFields['vendor_id']		= $vendor_id;
		$dbFields['category_id'] 	= ($sub_category_id == '' ? $category_id : $sub_category_id);
		$dbFields['voucher'] 		= $voucher;
		
		$dbFields['description'] 	= $description;
		$dbFields['terms'] 			= $terms;
		
		$dbFields['value'] 			= $value;
		$dbFields['discount'] 		= $discount;
		$dbFields['valid_from'] 	= $valid_from;
		$dbFields['valid_to'] 		= $valid_to;
		
		$dbFields['expiry'] 		= ($expiry == 'on' ? 'yes' : 'no');
	
		$dbFields['type']			= $type;	
		if($type == 'online_code')
			$dbFields['voucher_code']	= $voucher_code;
		
		if($image_name != '')
			$dbFields['image'] 		= $image_name;

		$dbFields['status'] 		= $status;
		
		
		$specialFields = array();
		if($_REQUEST['id'] != '')	{		
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on','valid_from','valid_to');
			$cond	= "id=".$_REQUEST['id'];
			$INFO_MSG = "Voucher entry has been edited.";
		}	
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on','valid_from','valid_to');
			$INFO_MSG = "Voucher entry has been posted.";
		}
		
		dbPerform("vouchers", $dbFields, $specialFields, $cond);
		$action = "edit";
		
		if($_REQUEST['id'] == '')	{
			$new_id		=  mysql_insert_id();
		}	
		
		$_REQUEST['id']	= ($_REQUEST['id'] == '' ? $new_id: $_REQUEST['id']);
		
		
		
		
}

//---------------------------------------------------------------------------------------------------
if($action == 'edit')	{
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
		});
	</script>
	
<? ############################################################################################## ?>

<div class="modal-dialog">
		<div class="modal-content">
        
            <form id="rootwizard-2" action="" method="post" enctype="multipart/form-data" class="form-wizard validate">
            <input type="hidden" id="action" name="action" value="save" />
            <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
            
            <p class="bs-example">
                <a href="index.php?_page=vouchers" class="bs-example">
                    <button type="button" class="btn btn-primary pull-right">Back</button>
                </a>
            </p> 
            <div style="clear:both; height:15px;"></div>
            
            <div class="steps-progress">
                <div class="progress-indicator"></div>
            </div>
            
            <ul>
                <li class="active">
                    <a href="#business" data-toggle="tab"><span>1</span>Business/Category</a>
                </li>
                <li>
                    <a href="#details" data-toggle="tab"><span>2</span>Details</a>
                </li>
                <li>
                    <a href="#tandc" data-toggle="tab"><span>3</span>T&C</a>
                </li>
                <li>
                    <a href="#validity" data-toggle="tab"><span>4</span>Validity</a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane active" id="business">
                    <div class="row">
                            
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="vendor_id">Business</label>
                                
                                <select name="vendor_id" id="vendor_id" class="form-control" data-validate="required">
                                    <option value="">Select</option>
                                    <?=htmlOptions($vendorCategArr, $recordsList[0]['vendor_id']);?>
                                </select>
                                
                                
                                
                                
                                
                        
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="category_id">Category</label>
            
                                <select name="category_id" id="category_id" class="form-control" data-validate="required">
                                    <option value="">Select</option>
                                    <?=htmlOptions($voucherCategArr, (getParentId($recordsList[0]['category_id']) == 0 ? $recordsList[0]['category_id'] : getParentId($recordsList[0]['category_id'])));?>
                                </select>
                             </div>
                                
                            <div id="sub_div" style="display:<?=$recordsList[0]['category_id'] == 0 ? 'none' : 'inline;'?>">
                                <div class="form-group">
                                    <label class="control-label" for="sub_category_id">Sub Category</label>
                                  
                                    <select name="sub_category_id" id="sub_category_id" class="form-control" data-validate="required">
                                        <option value="">Select</option>
                                        <?=htmlOptions(getSubcategoryArray(getParentId($recordsList[0]['category_id']) == 0 ? $recordsList[0]['category_id'] : getParentId($recordsList[0]['category_id'])), $recordsList[0]['category_id']);?>
                                    </select>
                                </div>
                            </div>
                        
                            
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="type">Voucher Type</label>
                                <div class="radio radio-replace" style="margin-bottom:10px;">
                                    <input type="radio" name="type" value="printable" <?=$recordsList[0]['type']=='printable'?'checked="checked"':''?> style="width:20px; display:inline;"   />
                                    <label>Printable</label>
                                </div>
                               
                                <div class="radio radio-replace">    
                                    <input type="radio" name="type" value="online_code" <?=$recordsList[0]['type']=='online_code'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                                    <label>Online code</label>
                                </div>
                            </div>
                        </div>
                        
                    </div>  
                </div>
                
                
                
                
                <div class="tab-pane" id="details">
                    <div class="row">
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="voucher">Voucher Headline</label>
                                <input type="text" name="voucher" value="<?=no_magic_quotes($recordsList[0]['voucher'])?>" id="voucher" class="form-control" data-validate="required"  />	
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="voucher_code">Voucher code</label>
                                <input type="text" name="voucher_code" value="<?=no_magic_quotes($recordsList[0]['voucher_code'])?>" id="form_name" class="form-control"  />
                        
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="description">More information (Optional)</label>
                                <textarea name="description" class="form-control" id="description" class="pref tareahs bodycopy" ><?=no_magic_quotes($recordsList[0]['description'])?></textarea>
                            </div>
                        </div>
                        
                    </div>  
                </div>
            
                
                <div class="tab-pane" id="tandc">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="terms">Terms</label>
                                <textarea name="terms" class="form-control" id="terms" class="pref tareahs bodycopy" data-validate="required" ><?=no_magic_quotes($recordsList[0]['terms'])?></textarea>
                                
                            </div>
                        </div>
                        
                    </div>  
                </div>
                
                
                <div class="tab-pane" id="validity">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="dates">Valid Date Range</label>
                                <input type="text" data-validate="required" name="date_range" value="<?=$recordsList[0]['valid_from'] != '' ? convertMysqlToDate(date('Y-m-d',strtotime($recordsList[0]['valid_from'])), '-') : '' ?> - <?=$recordsList[0]['valid_to'] != '' ? convertMysqlToDate(date('Y-m-d',strtotime($recordsList[0]['valid_to'])), '-') : '' ?>" class="form-control daterange" data-format="DD-MM-YYYY" />
                        
                            </div>
                        </div>
                        
                        <div class="col-md-6">
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
        
	</div>
</div>


