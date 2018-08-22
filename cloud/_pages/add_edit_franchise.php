<?
//If business login show only the business of them
if($_SESSION['ADMIN_USER_PROFILE']['type'] == 'user' && $_SESSION['ADMIN_USER_PROFILE']['email'] != getFieldValue($_REQUEST['id'], 'email', 'franchises'))	{
	$whrFranchisee	= " email='{$_SESSION['ADMIN_USER_PROFILE']['email']}'";
	
	$query 		= "SELECT * FROM franchises WHERE $whrFranchisee";
	$vendor_id	= dbQuery($query, 'singlecolumn');
	
	header("Location:index.php?_page=add_edit_franchises&action=edit&id=".$vendor_id);
}

//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
if($action=="delete_news") {
	dbQuery("UPDATE news SET status='deleted' WHERE id='{$_REQUEST['news_id']}'");
	$INFO_MSG = "News has been deleted.";	
}

//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
if($action=="delete_testimonials") {
	dbQuery("UPDATE testimonials SET status='deleted' WHERE id='{$_REQUEST['testimonial_id']}'");
	$INFO_MSG = "Testimonials has been deleted.";	
}

//---------------------------------------------------------------------------------------------------
if($_REQUEST['action'] == 'save')	{
	//echo "<pre>";
	//print_r($_REQUEST);
	
	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);
	//if(!vendorEmailExist($email, $_REQUEST['id']))	{
	
		//adding to franchises	
		$dbFields = array();
		if($_FILES['logo']['size'] > 0)	{
			$filename	= '../upload/vendors/original/'.$_FILES['logo']['name'];
			copy($_FILES['logo']['tmp_name'],$filename);
			list($width, $height) = getimagesize($filename);
		
			$dbFields['logo_width']			= $width;	
			$dbFields['logo_height'] 		= $height;
			
			$filename	= '../upload/vendors/thumbnail/'.$_FILES['logo']['name'];
			ResizeImage($_FILES['logo']['tmp_name'], '200', '200', $filename);
			
			/*$targ_w = $targ_h = 135;
			$jpeg_quality = 90;
			
			$src 	= '../upload/vendors/original/'.$_FILES['logo']['name'];
			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			
			imagecopyresampled($dst_r,$img_r,0,0,$_REQUEST['x'],$_REQUEST['y'],$targ_w,$targ_h,$_REQUEST['w'],$_REQUEST['h']);
			
			imagejpeg($dst_r, $filename, $jpeg_quality);*/

			$logo		= $_FILES['logo']['name'];
			
			$dbFields['logo'] 	= $logo;
		}
		
		if(isset($_REQUEST['logo_upload']) && $_FILES['logo']['size'] == 0)	{
			
			$filename	= '../upload/vendors/thumbnail/'.getFieldValue($_REQUEST['id'], 'logo', 'franchises');
			
			$targ_w = $targ_h = 200;
			$jpeg_quality = 90;
			
			$src 	= '../upload/vendors/original/'.getFieldValue($_REQUEST['id'], 'logo', 'franchises');
			$type = exif_imagetype($src);
			
			switch ($type) { 
				case 1 : 
					$img_r = imagecreatefromgif($src); 
				break; 
				case 2 : 
					$img_r = imagecreatefromjpeg($src); 
				break; 
				case 3 : 
					$img_r = imagecreatefrompng($src); 
				break; 
				case 6 : 
					$img_r = imagecreatefromwbmp($src); 
				break; 
			}  
			
			
			//$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			
			imagecopyresampled($dst_r,$img_r,0,0,$_REQUEST['x'],$_REQUEST['y'],$targ_w,$targ_h,$_REQUEST['w'],$_REQUEST['h']);
			
			imagejpeg($dst_r, $filename, $jpeg_quality);
			
		}
				
		$dbFields['vendor'] 		= $vendor;
		$dbFields['category_id'] 	= ($sub_category_id == '' ? $category_id : $sub_category_id);
		$dbFields['vendor_code']	= str_replace(' ','',$vendor_code);
		$dbFields['profile'] 		= $profile;
		$dbFields['franchise_desc'] = $franchise_desc;
		$dbFields['description'] 	= $description;
		
		$dbFields['min_investment']	= $min_investment;
		$dbFields['established']	= $established;
		$dbFields['break_even_time']= $break_even_time;
		$dbFields['franchise_no']	= $franchise_no;
		
		$dbFields['min_invest_show']	= ($min_invest_show == 'on' ? 'yes' : 'no');
		$dbFields['established_show']	= ($established_show == 'on' ? 'yes' : 'no');
		$dbFields['break_even_show']	= ($break_even_show == 'on' ? 'yes' : 'no');
		$dbFields['franchise_no_show']	= ($franchise_no_show == 'on' ? 'yes' : 'no');
		
		foreach(getLifestyles() as $val)	{
			if($_REQUEST['lifestyles'][$val['id']]	== 'on')
				$lifestyles	.= $val['id'].',';
		}
		$dbFields['lifestyles'] 		= ','.$lifestyles;
		
		foreach(getNonLifestyles() as $val)	{
			if($_REQUEST['spons_non_categs'][$val['id']]	== 'on')
				$spons_non_categs	.= $val['id'].',';
		}
		$dbFields['spons_non_categs'] 		= ','.$spons_non_categs;
		
		foreach(getFranchiseCategoriesAll() as $val)	{
			if($_REQUEST['spons_categs'][$val['id']]	== 'on')
				$spons_categs	.= $val['id'].',';
		}
		$dbFields['spons_categs'] 		= ','.$spons_categs;
			
		$dbFields['firstname'] 		= $firstname;
		$dbFields['surname'] 		= $surname;
		
		$dbFields['addr1'] 			= $addr1;
		$dbFields['addr2'] 			= $addr2;
		$dbFields['city'] 			= $city;
		$dbFields['state'] 			= $county;
		$dbFields['postcode'] 		= $postcode;
		
		$dbFields['map'] 			= $map;
		
		$dbFields['phone'] 			= $phone;
		$dbFields['website'] 		= $website;
		
		$dbFields['facebook'] 		= $facebook;
		$dbFields['twitter'] 		= $twitter;
		
		$dbFields['video'] 		= $video;
		
		$dbFields['email'] 			= $email;
		$dbFields['email_cc']		= $email_cc;
		if($password != '' && ($password==$password_again))
			$dbFields['password'] 		= md5($password);
		elseif($password != '')
			$pwd_msg	= ' Password mismatch';

		$dbFields['featured'] 			= $featured;
		$dbFields['featured2'] 			= $featured2;
		$dbFields['featured3'] 			= $featured3;
		$dbFields['featured4'] 			= $featured4;
		$dbFields['featured5'] 			= $featured5;
		
		$dbFields['is_news'] 			= $is_news;
		$dbFields['is_testimonial'] 	= $is_testimonial;
		
		if(isset($status))
			$dbFields['status'] 		= $status;
		
		$specialFields = array();
		
		if($_REQUEST['id'])	{
			$dbFields['updated_on'] 		= 'now()';
			$specialFields = array('updated_on');
			$cond	= "id=".$_REQUEST['id'];
			
			$INFO_MSG = "Franchise has been edited.";
			dbPerform("franchises", $dbFields, $specialFields, $cond);
		}
		else	{
			$dbFields['inserted_on'] 		= 'now()';
			$specialFields = array('inserted_on');
			$INFO_MSG = "Franchise has been added.";
			dbPerform("franchises", $dbFields, $specialFields);
			
			$_REQUEST['id']	= ($_REQUEST['id'] == '' ? mysql_insert_id() : $_REQUEST['id']);
			
			//update business code
			$code	= '1000'.$_REQUEST['id'];
			dbQuery("UPDATE franchises SET vendor_code = '$code' WHERE id='{$_REQUEST['id']}'");
			
			//==============================================================================
			//==============================================================================
			//create user account and email business
			
			//email user
			$data[0] = $email;
			$data[1] = SITE_NAME;
			$data[2] = EMAIL;
			$data[3] = 'Business Added';
			$data[4] = "<p>Hi ".ucfirst($firstname).",<br><br>
			
						Many thanks for registering ".ucfirst($vendor)." with Saverplaces.co.uk, your registration is now complete.	<br />

						To log into your account and view your business details and current live vouchers please visit www.saverplaces.co.uk/fsadmin using the details below.
						<br /><br>
						
						<strong>Business: </strong>".ucfirst($vendor)."<br />
						<strong>Username:</strong> ".$email."<br />
						<strong>Password:</strong> ".$password."<br />
						 
						</p>
						
						<p>
							Many Thanks,<br/>
							The Saverplaces Team
					  	</p>";
			mailbox('',$data);
			
			// email to admin
			$data[0] = CONTACT_EMAIL;
			$data[1] = SITE_NAME;
			$data[2] = EMAIL;
			$data[3] = 'Registration Form received';
			$data[4] = "<p>Hello Admin,<br /><br />
						Business Added:
						<u><strong>Business user details</strong></u><br>
						Please find details below:<br /><br>
						<strong>Business: </strong>".ucfirst($vendor)."<br />
						<strong>Name: </strong>".ucfirst($firstname)." ".$surname."<br />
						<strong>Town:</strong> ".$city." - ".$county."<br />
						<strong>Email:</strong> ".$email."<br />
						</p>

						<p>Many Thanks</p>
						<strong>".SITE_NAME." Team</strong>";
			mailbox('',$data);
			
			
			//end
			//==============================================================================
			//==============================================================================
		}
		
	/*}//duplicate email check
	else
		$ERR_MSG	=  "Email already exist, Try again!!<br />";*/	
}

//==================================================================================================================
//==================================================================================================================

//news
if (isset($_REQUEST['news'])) {

	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);

	if($_FILES['news_image']['size'] > 0)	{
		$filename	= '../images/news/'.$_FILES['news_image']['name'];
		$image_name	= $_FILES['news_image']['name'];
		copy($_FILES['news_image']['tmp_name'],$filename);
		$filename	= '../images/news/thumbnail/'.$_FILES['news_image']['name'];
		ResizeImage($_FILES['news_image']['tmp_name'], THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, $filename);
		
		$filename	= '../images/news/resize/'.$_FILES['news_image']['name'];
		ResizeImage($_FILES['news_image']['tmp_name'], RESIZE_WIDTH, RESIZE_HEIGHT, $filename);
	}
	
	$dbFields = array();
	$dbFields['title'] 	= $news_title;
	$dbFields['news'] 	= $news;
	
	$dbFields['category_id']	= $news_category_id;
	$dbFields['franchise_id']	= $_REQUEST['id'];
	
	if($image_name != '')
		$dbFields['image'] 		= $image_name;
	
	$specialFields = array();
	if($_REQUEST['news_id'] != '')	{		
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_REQUEST['news_id'];
		$INFO_MSG = "News has been edited.";
	}	
	else	{
		$dbFields['updated_on'] 		= 'now()';
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on','updated_on');
		$INFO_MSG = "News has been posted.";
	}
	
	$new_id		= dbPerform("news", $dbFields, $specialFields, $cond);
	$action = "edit";
	
	if($_REQUEST['news_id'] == '')	{
		dbQuery("UPDATE news SET sort_order='$new_id' WHERE id='$new_id'");
	}	
	
}//news

//==================================================================================================================
//==================================================================================================================

//news
if (isset($_REQUEST['testimonial'])) {

	foreach($_REQUEST as $key=>$val)
		$$key	= addslashes($val);

	$dbFields = array();
	$dbFields['name'] 	= $name;
	$dbFields['company']= $company;
	
	$dbFields['testimonial']	= $testimonials;
	$dbFields['franchise_id']	= $_REQUEST['id'];
	
	if($image_name != '')
		$dbFields['image'] 		= $image_name;
	
	$specialFields = array();
	if($_REQUEST['testimonials_id'] != '')	{		
		$dbFields['updated_on'] 		= 'now()';
		$specialFields = array('updated_on');
		$cond	= "id=".$_REQUEST['testimonials_id'];
		$INFO_MSG = "Testimonial has been edited.";
	}	
	else	{
		$dbFields['updated_on'] 		= 'now()';
		$dbFields['inserted_on'] 		= 'now()';
		$specialFields = array('inserted_on','updated_on');
		$INFO_MSG = "Testimonial has been posted.";
	}
	
	dbPerform("testimonials", $dbFields, $specialFields, $cond);
	$action = "edit";
	
}//news
	
$INFO_MSG	= $INFO_MSG.$pwd_msg;
$profile	= dbQuery("SELECT * FROM franchises WHERE id='{$_REQUEST['id']}'", 'single');

$franchise_testimonials	= dbQuery("SELECT * FROM testimonials WHERE franchise_id='{$_REQUEST['id']}' AND status='active'");
$franchise_news			= dbQuery("SELECT * FROM news WHERE franchise_id='{$_REQUEST['id']}' AND status='active'");

$filename	= '../upload/vendors/original/'.$profile['logo'];
/*list($width, $height) = getimagesize($filename);
if($profile['logo_width'] == 0)
	$profile['logo_width'] = $width;
if($profile['logo_height'] == 0)
	$profile['logo_height'] = $height;		*/


$statusArr	= array();
$statusArr[]	= array("optionId"=>"active","optionText"=>"Active");
$statusArr[]	= array("optionId"=>"pending","optionText"=>"Pending");
$statusArr[]	= array("optionId"=>"inactive","optionText"=>"Inactive");
$statusArr[]	= array("optionId"=>"deleted","optionText"=>"Deleted");
$statusArr[]	= array("optionId"=>"all","optionText"=>"All");

?>

<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/jquery.counter-1.0.min.js"></script>

<!-- TinyMCE -->
<script type="text/javascript">
	
tinyMCE.init({	
// General options
	mode : "exact",
	elements : "content",
	theme : "advanced",
	plugins : "table,advimage,media",
	//content_css : "<?=APP_URL?>/stylesheet.php?id=<?=$pagename?>", 
	
	// Theme options
	theme_advanced_buttons1 : "save,cut,paste,pastetext,pasteword,copy,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,formatselect,sub,sup,image,media",
  theme_advanced_buttons2 : "bold,italic,underline,strikethrough,advhr,separator,bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,customdropdown,cmslinker,link,unlink,anchor,charmap,cleanup,separator,forecolor,backcolor,separator,code,help|advhr,removeformat,tablecontrols",
  theme_advanced_buttons3 : "",
  theme_advanced_buttons4 : "",
  extended_valid_elements : "object[width|height|classid|codebase],param[name|value],embed[src|type|width|height|flashvars|wmode],iframe[width|height|frameborder|scrolling|marginheight|marginwidth|src]",
  
	table_inline_editing : true,
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	file_browser_callback : "PUBNETFilePicker",
	relative_urls : false

});

function toggleEditor(id) {
	if (!tinyMCE.getInstanceById(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}

function PUBNETFilePicker (field_name, url, type, win) {
     
  var cmsURL = "<?=APP_URL?>/filepicker.php";
  
  tinyMCE.activeEditor.windowManager.open({
  
    file : cmsURL,
    title : 'File Selection',
    width : '700',
    height : '500',
    resizable : "yes",
    scrollbars : "yes",
    inline : "yes",
    close_previous : "no"
  
  }, {
    window : win,
    input : field_name
  });
  return false;
}
</script>
<script type="text/javascript"> 
	$(document).ready(function() { 
		
		/*// Example 3 - crop the thumbnail
		var img_3_w = '<?=$profile['logo_width']?>',
			img_3_h = '<?=$profile['logo_height']?>';
		
		$('#jcrop-3').Jcrop({
			onChange: showPreview,
			onSelect: showPreview,
			aspectRatio: 1
		}, function()
		{
			this.setSelect([200, 200, 120, 40]);
		});
		function showPreview(coords)
		{
			var rx = 200 // coords.w;
			var ry = 200 // coords.h;
		
			$('#preview').css({
				width: Math.round(rx * img_3_w) + 'px',
				height: Math.round(ry * img_3_h) + 'px',
				marginLeft: '-' + Math.round(rx * coords.x) + 'px',
				marginTop: '-' + Math.round(ry * coords.y) + 'px'
			});
			
			$('#x').val(coords.x);
			$('#y').val(coords.y);
			$('#w').val(coords.w);
			$('#h').val(coords.h);
		}*/
		
		/*$("#logo_upload").click(function()	{
			var request = new FormData();                   
			$.each(context.prototype.fileData, function(i, obj) { request.append(i, obj.value.files[0]); });    
			request.append('action', 'upload');
			request.append('id', response.obj.id);

			$.ajax({
				url: "load.php?action=upload_logo", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: request, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					alert(data);
				}
			});
		});*/
		
		$('.vmodal-news').click(function(event)	{
    		jQuery('#modal-news').modal('show', {backdrop: 'static'});
			jQuery("#modal-news").css( {position:"absolute", top:event.pageY-300, left:0});
			//jQuery('#modal-cs').css('max-height', jQuery(window).height());
		
			$.ajax({
				url: "load_news.php?news_id="+$(this).attr('id'),
				success: function(response)
				{
					jQuery('#modal-news .modal-body').html(response);
				}
			});	        
        });
		
		$('.vmodal-testimonials').click(function(event)	{
    		jQuery('#modal-testimonials').modal('show', {backdrop: 'static'});
			jQuery("#modal-testimonials").css( {position:"absolute", top:event.pageY-300, left:0});
			//jQuery('#modal-cs').css('max-height', jQuery(window).height());
		
			$.ajax({
				url: "load_testimonials.php?testimonial_id="+$(this).attr('id'),
				success: function(response)
				{
					jQuery('#modal-testimonials .modal-body').html(response);
				}
			});	        
        });
		
		$("#lifestyle_all").click(function()	{
			$(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
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





<div class="row">
				
  <div class="col-md-12">

    <a href="index.php?_page=franchises" class="bs-example">
        <button type="button" class="btn btn-primary btn-icon pull-right">Back <i class="entypo-back"></i></button>
    </a>
    
    <a href="index.php?_page=enquiry&franchise_id=<?=$_REQUEST['id']?>" class="bs-example">
        <button type="button" class="btn btn-primary btn-icon pull-right">Enquiries <i class="entypo-list"></i></button>
    </a>
    
    <a href="export_enquiries.php?franchise_id=<?=$_REQUEST['id']?>" class="bs-example">
        <button type="button" class="btn btn-primary btn-icon pull-right">Export Enquiries <i class="entypo-list"></i></button>
    </a>
   </div>
</div> 


<form id="rootwizard-2" method="post" action="" class="form-wizard validate nonmodal" enctype="multipart/form-data">

<input type="hidden" id="action" name="action" value="save" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />

<!--<input type="hidden" id="x" name="x" />
<input type="hidden" id="y" name="y" />
<input type="hidden" id="w" name="w" />
<input type="hidden" id="h" name="h" />-->

<div style="clear:both; height:15px;"></div>

<div class="steps-progress">
    <div class="progress-indicator"></div>
</div>

<ul>
    <li <?=isset($_REQUEST['logo_upload']) || isset($_REQUEST['news']) || isset($_REQUEST['testimonial']) ? '' : 'class="active"'?>>
        <a href="#details" data-toggle="tab"><span>1</span>Business Details</a>
    </li>
    <li>
        <a href="#profile" data-toggle="tab"><span>2</span>Profile</a>
    </li>
    <!--<li <?=isset($_REQUEST['logo_upload']) ? 'class="active"' : ''?> >
        <a href="#logo" data-toggle="tab"><span>2</span>Logo</a>
    </li>-->
    <li>
        <a href="#contact" data-toggle="tab"><span>3</span>Contact Details</a>
    </li>
    <li <?=isset($_REQUEST['news']) ? 'class="active"' : ''?>>
        <a href="#news" data-toggle="tab"><span>4</span>News</a>
    </li>
    <li <?=isset($_REQUEST['testimonial']) ? 'class="active"' : ''?>>
        <a href="#testimonials" data-toggle="tab"><span>5</span>Testimonials</a>
    </li>
    <li>
        <a href="#addons" data-toggle="tab"><span>6</span>Options</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane <?=isset($_REQUEST['logo_upload']) || isset($_REQUEST['news']) || isset($_REQUEST['testimonial']) ? '' : 'active'?>" id="details">
    	<div class="row">
        
        	<div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="category_id">Category</label>

                    <select name="category_id" id="category_id" class="select2" data-validate="required">
                        <option value="">Select</option>
                        <?=htmlOptions($franchiseCategArr, (getParentId($profile['category_id']) == 0 ? $profile['category_id'] : getParentId($profile['category_id'])));?>
                    </select>
                 </div>
                    
                <div id="sub_div" style="display:<?=$profile['category_id'] == 0 ? 'none' : 'inline;'?>">
                    <div class="form-group">
                        <label class="control-label" for="sub_category_id">Sub Category</label>
                      
                        <select name="sub_category_id" id="sub_category_id" class="select2">
                            <option value="">Select</option>
                            <?=htmlOptions(getSubcategoryArray(getParentId($profile['category_id']) == 0 ? $profile['category_id'] : getParentId($profile['category_id'])), $profile['category_id']);?>
                        </select>
                    </div>
                </div>
            
                
            </div> 
				
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="vendor">Business Name</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['vendor'])?>" id="vendor" name="vendor" data-validate="required" placeholder="Enter business name"  />	
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="vendor">Business Code (URL - without spaces)</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['vendor_code'])?>" id="vendor_code" name="vendor_code" data-validate="required" placeholder="Enter business code used in URL"  />	
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="website">Website:&nbsp;(Eg: www.example.com) (exclude http://)</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['website'])?>" id="website" name="website"  placeholder="Your website"  />
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="email">E-mail address</label>
					<input  type="text" class="form-control" value="<?=no_magic_quotes($profile['email'])?>" id="email" name="email" data-validate="required,email" placeholder="Enter a contact email address "  />
                </div>
        	</div>
        
  
 
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="description">Short description</label>
                    <textarea class="form-control autogrow" name="description" id="description" rows="5" placeholder="Enter some more details about your business"><?=no_magic_quotes($profile['description'])?></textarea>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="phone">Facebook (Include https://)</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['facebook'])?>" id="facebook" name="facebook"  />
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="phone">Twitter (Include https://)</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['twitter'])?>" id="twitter" name="twitter"  />
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="email">E-mail address (CC)</label>
					<input  type="text" class="form-control" value="<?=no_magic_quotes($profile['email_cc'])?>" id="email_cc" name="email_cc" data-validate="email" placeholder="Enter a contact email address CC"  />
                </div>
        	</div>
              
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="password">Create a Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="Please choose your own password" />
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="password_again" name="password_again" value="" placeholder="Please confirm your password" />
                </div>
            </div>
            
            <?
            if($_SESSION['ADMIN_USER_PROFILE']['type'] == 'admin' || $_SESSION['ADMIN_USER_PROFILE']['type'] == 'superadmin')	{
            ?>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="status">Status</label>
                    <select name="status" class="selectboxit">
                        <?=htmlOptions($statusArr, $profile['status']);?>
                    </select>
                </div>
            </div>
            <?
            }
            ?>
            
            <button type="submit" name="save" class="btn btn-primary pull-right">Save</button>
        
      </div>   
    </div>
          
 	
    <div class="tab-pane" id="profile">
    	<div class="row">
			<div class="col-md-12">
                <div class="form-group">
                    <input type="file" id="logo" name="logo" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse"  /> Upload your logo 
                    <img src="../upload/vendors/thumbnail/<?=$profile['logo']?>" class="img-responsive img-rounded" style="margin-top:5px;" />
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="description">Profile</label>
					<textarea class="form-control" name="profile" id="content" style="width:100%; height:600px;" placeholder="Enter your profile details"><?=no_magic_quotes($profile['profile'])?></textarea>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="description">Franchise Description</label>
					<textarea class="form-control autogrow" name="franchise_desc" id="franchise_desc" rows="5" placeholder="Enter profile description"><?=no_magic_quotes($profile['franchise_desc'])?></textarea>
                </div>
            </div>
            <button type="submit" name="save" class="btn btn-primary pull-right">Save</button>
        </div>
    </div>
    
    
    <!--<div class="tab-pane <?=isset($_REQUEST['logo_upload']) ? 'active' : ''?>" id="logo">
    	<div class="row">
        
        	<div class="col-md-12">
                <div class="form-group">
                    <input type="file" id="logo" name="logo" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse"  /> Upload your logo 
                    
                    <input type="submit" id="logo_upload" name="logo_upload" value="Upload"  />
                    
                    <img src="../upload/vendors/thumbnail/<?=$profile['logo']?>" class="img-responsive img-rounded" style="margin-top:5px;" />
                </div>
            </div>
            
        	<div class="col-md-12">
		
                <div class="panel panel-primary" data-collapsed="0">
                	
                
                    <div class="panel-body">
                        
                        
                        <div class="thumbnail-highlight">
                            <img id="jcrop-3" src="../upload/vendors/original/<?=$profile['logo']?>" class="img-responsive img-rounded" />
                        </div>
                        
                    </div>
                    
                    <div class="panel-body">
                        
                        <h4>Thumbnail Preview</h4>
                        
                        <div style="width:200px; height:200px; overflow:hidden;" class="thumbnail-highlight">
                        	<img src="../upload/vendors/original/<?=$profile['logo']?>" class="img-rounded" id="preview" />    
                        </div>
                    </div>
                    
                </div>
                
                <button type="submit" name="save" class="btn btn-primary pull-right">Save</button>
            
            </div>
			
        </div>  
    </div>-->
    
    <div class="tab-pane" id="contact">
    	<div class="row">
		
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="firstname">First Name</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['firstname'])?>" id="firstname" name="firstname" placeholder="First Name"  />	
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="surname">Surname</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['surname'])?>" id="surname" name="surname"  placeholder="Surname"  />
                </div>
            </div>
         
          </div>
          
          <div class="row">  
            
            <div class="col-md-6">
                <div class="form-group">
            
                    <label class="control-label" for="addr1">Address 1</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['addr1'])?>" id="addr1" name="addr1" placeholder="Address line 1"  />	
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="addr2">Address 2</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['addr2'])?>" id="addr2" name="addr2" placeholder="Address line 2"  />	
                </div>
            </div>
         </div>
         
         <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="city">City</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['city'])?>" id="city" name="city" placeholder="City"  />	
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="county">County</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['state'])?>" id="county" name="county" placeholder="County"  />	
                </div>
            </div>
         </div>
         
         <div class="row">
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="postcode">Postcode</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['postcode'])?>" id="postcode" name="postcode" placeholder="Postcode"  />	
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="phone">Phone Number</label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['phone'])?>" id="phone" name="phone" placeholder="Contact phone number"  />	
                </div>
            </div>
            
            <button type="submit" name="save" class="btn btn-primary pull-right">Save</button>
            
        </div>
            
       <!--  <div class="row">
            
           <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="phone">Map</label>
                    <textarea name="map" class="form-control autogrow" rows="5" placeholder="Embed code for google map"><?=no_magic_quotes($profile['map'])?></textarea>
                </div>
            </div>
        </div>-->
        
    </div>

    
    <div class="tab-pane <?=isset($_REQUEST['news']) ? 'active' : ''?>" id="news">
    	<div class="row">
        	<div class="col-md-12">
					
                <div class="panel panel-primary" data-collapsed="0">
                
                    <div class="panel-heading">
                        <div class="panel-title">
                            News
                        </div>
                        
                        <div class="panel-options">
                                <a href="index.php?_page=edit_franchise_news&id=<?=$_REQUEST['id']?>" class="">
                                    <button type="button" class="btn btn-primary btn-sm btn-icon pull-right">
                                        Add News
                                        <i class="entypo-plus"></i>
                                    </button>        
                                </a>

                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                    
    
<? if (count($franchise_news)==0) { ?>
    No records found!
<? } else { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="4"  class="table table-bordered table-striped datatable" id="table-1">
        <thead>
    
      <tr>
        <td width="2%" align="left">#</td>
        <td width="3%" align="left">Image</td>
        <td width="21%" align="left">Category</td>
        <td width="36%" align="left">Title</td>
        <td width="20%" align="left">Status</td>
        <td width="18%" align="left">Actions</td>
      </tr>
    
        </thead>
    <tbody>    
    <? for ($i=0; $i<count($franchise_news); $i++) {?>
            
                <tr>
                  <td width="2%" align="left"><?=$i+1?></td>
                  
                  <td width="3%" align="left"><?=$franchise_news[$i]['image'] != '' ? '<img src="../images/news/'.$franchise_news[$i]['image'].'" height="50" />' : ''?></td>
                  
                  <td width="21%" align="left"><?=getNewsCategory(no_magic_quotes($franchise_news[$i]['category_id']))?></td>
                  
                  <td width="36%" align="left"><?=no_magic_quotes($franchise_news[$i]['title'])?></td>
                  
                  <td width="20%" align="left"><?=$franchise_news[$i]['status']?></td>	
                  
                  <td width="18%" align="left">
                    
                    <a href="index.php?_page=edit_franchise_news&id=<?=$_REQUEST['id']?>&news_id=<?=$franchise_news[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit                </a>
                    
                    <a href="index.php?_page=add_edit_franchise&action=delete_news&id=<?=$_REQUEST['id']?>&news_id=<?=$franchise_news[$i]['id']?>"  onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                        <i class="entypo-cancel"></i>
                        Delete				</a>				</td>
        </tr>
              
    <? } ?>
    <tbody>
    </table>
<? }?>
            
                </div>
                
                </div>
            
            </div>
            
        </div>  
    </div>
    
    
    <div class="tab-pane <?=isset($_REQUEST['testimonial']) ? 'active' : ''?>" id="testimonials">
    	<div class="row">			
        	<div class="col-md-12">
					
                <div class="panel panel-primary" data-collapsed="0">
                
                    <div class="panel-heading">
                        <div class="panel-title">
                            Testimonials
                        </div>
                        
                        <div class="panel-options">
                                <a href="index.php?_page=edit_franchise_testimonial&id=<?=$_REQUEST['id']?>" class="">
                                    <button type="button" class="btn btn-primary btn-sm btn-icon pull-right">
                                        Add Testimonial
                                        <i class="entypo-plus"></i>
                                    </button>        
                                </a>

                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                    
    
<? if (count($franchise_testimonials)==0) { ?>
	No records found!
<? } else { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="4"  class="table table-bordered table-striped datatable" id="table-1">
        <thead>

      <tr>
        <td width="2%" align="left">#</td>
        <td width="36%" align="left">Title</td>
        <td width="36%" align="left">Testimonial</td>
        <td width="20%" align="left">Status</td>
        <td width="18%" align="left">Actions</td>
      </tr>
    
    
        </thead>
    <tbody>    
    <? for ($i=0; $i<count($franchise_testimonials); $i++) {?>
            
                <tr>
                  <td width="2%" align="left"><?=$i+1?></td>
                  
                  <td width="21%" align="left"><?=no_magic_quotes($franchise_testimonials[$i]['name'])?></td>
                  
                  <td width="36%" align="left"><?=no_magic_quotes($franchise_testimonials[$i]['testimonial'])?></td>
                  
                  <td width="20%" align="left"><?=$franchise_testimonials[$i]['status']?></td>	
                  
                  <td width="18%" align="left">
                    
                    <a href="index.php?_page=edit_franchise_testimonial&id=<?=$_REQUEST['id']?>&testimonial_id=<?=$franchise_testimonials[$i]['id']?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit                </a>
                    
                    <a href="index.php?_page=add_edit_franchise&action=delete_testimonials&id=<?=$_REQUEST['id']?>&testimonial_id=<?=$franchise_testimonials[$i]['id']?>"  onclick="return confirm ('Are you sure?');" class="btn btn-danger btn-sm btn-icon icon-left">
                        <i class="entypo-cancel"></i>
                        Delete				</a>				</td>
        </tr>
              
    <? } ?>
    <tbody>
    </table>
<? }?>  
            
                </div>
                
                </div>
            
            </div>    	
        </div>  
    </div>
    
    
    <div class="tab-pane" id="addons">
    	<div class="row">
			
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="description">Video</label>
					<textarea class="form-control autogrow" name="video" id="video" rows="5" placeholder="Enter your embed code for the video"><?=no_magic_quotes($profile['video'])?></textarea>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="city">Minimum Investment - Show<input type="checkbox" name="min_invest_show" <?=$profile['min_invest_show']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   /></label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['min_investment'])?>" id="min_investment" name="min_investment" placeholder="Minimum Investment"  />	
                </div>
            </div>
            
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="city">Established Year - Show<input type="checkbox" name="established_show" <?=$profile['established_show']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   /></label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['established'])?>" id="established" name="established" placeholder="Established year"  />	
                </div>
            </div>
            
            
                
        </div>
        
        <div class="row">
        	<div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="city">Est. Time to break even - Show<input type="checkbox" name="break_even_show" <?=$profile['break_even_show']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   /></label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['break_even_time'])?>" id="break_even_time" name="break_even_time" placeholder="Estimate Time to break even"  />	
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="city">No. Of Franchisees - Show<input type="checkbox" name="franchise_no_show" <?=$profile['franchise_no_show']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   /></label>
                    <input  type="text" class="form-control" value="<?=no_magic_quotes($profile['franchise_no'])?>" id="franchise_no" name="franchise_no" placeholder="No. Of Franchisees"  />	
                </div>
            </div>
            
        	<div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="website">Testimonial</label>
                    
                    <div class="radio radio-replace" style="margin-bottom:10px;">
                        <input type="radio" name="is_testimonial" value="yes" <?=$profile['is_testimonial']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   />
                        <label>Yes</label>
                    </div>
                   
                    <div class="radio radio-replace">    
                        <input type="radio" name="is_testimonial" value="no" <?=$profile['is_testimonial']=='no'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                        <label>No</label>
                    </div>
                    
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="website">News</label>
                    
                    <div class="radio radio-replace" style="margin-bottom:10px;">
                        <input type="radio" name="is_news" value="yes" <?=$profile['is_news']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   />
                        <label>Yes</label>
                    </div>
                   
                    <div class="radio radio-replace">    
                        <input type="radio" name="is_news" value="no" <?=$profile['is_news']=='no'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                        <label>No</label>
                    </div>
                    
                </div>
            </div>
            
        </div>
        
        
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="description">Lifestyles</label>
<? 
					$lifestyle_arr	= explode(',',$profile['lifestyles']);
					foreach(getLifestyles() as $val)	{
?>
						<input type="checkbox" name="lifestyles[<?=$val['id']?>]" <?=in_array($val['id'],$lifestyle_arr) ? "checked='checked'" : ''?>  />&nbsp;<span style="margin-right:10px;"><?=no_magic_quotes($val['lifestyle'])?></span>
<?				
					}
?>
                </div>
            </div>
            
        </div>
        
        <div class="row">
        	<div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="website">Featured</label>
                    
                    <div class="radio radio-replace" style="margin-bottom:10px;">
                        <input type="radio" name="featured" value="yes" <?=$profile['featured']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   />
                        <label>Yes</label>
                    </div>
                   
                    <div class="radio radio-replace">    
                        <input type="radio" name="featured" value="no" <?=$profile['featured']=='no'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                        <label>No</label>
                    </div>
                    
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="website">Featured 2 (Home page)</label>
                    
                    <div class="radio radio-replace" style="margin-bottom:10px;">
                        <input type="radio" name="featured2" value="yes" <?=$profile['featured2']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   />
                        <label>Yes</label>
                    </div>
                   
                    <div class="radio radio-replace">    
                        <input type="radio" name="featured2" value="no" <?=$profile['featured2']=='no'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                        <label>No</label>
                    </div>
                    
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="website">Featured 3 (Search hero)</label>
                    
                    <div class="radio radio-replace" style="margin-bottom:10px;">
                        <input type="radio" name="featured3" value="yes" <?=$profile['featured3']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   />
                        <label>Yes</label>
                    </div>
                   
                    <div class="radio radio-replace">    
                        <input type="radio" name="featured3" value="no" <?=$profile['featured3']=='no'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                        <label>No</label>
                    </div>
                    
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="website">Featured 4 (Top searches)</label>
                    
                    <div class="radio radio-replace" style="margin-bottom:10px;">
                        <input type="radio" name="featured4" value="yes" <?=$profile['featured4']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   />
                        <label>Yes</label>
                    </div>
                   
                    <div class="radio radio-replace">    
                        <input type="radio" name="featured4" value="no" <?=$profile['featured4']=='no'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                        <label>No</label>
                    </div>
                    
                </div>
            </div>
            
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="website">Featured 5 (Home page banner)</label>
                    
                    <div class="radio radio-replace" style="margin-bottom:10px;">
                        <input type="radio" name="featured5" value="yes" <?=$profile['featured5']=='yes'?'checked="checked"':''?> style="width:20px; display:inline;"   />
                        <label>Yes</label>
                    </div>
                   
                    <div class="radio radio-replace">    
                        <input type="radio" name="featured5" value="no" <?=$profile['featured5']=='no'?'checked="checked"':''?>  style="width:20px; display:inline;" />
                        <label>No</label>
                    </div>
                    
                </div>
            </div>
            
        	<button type="submit" name="save" class="btn btn-primary pull-right">Save</button>  
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="description">Sponsored Categories</label>
<? 
					$spons_categs_arr	= explode(',',$profile['spons_categs']);
					foreach(getFranchiseCategoriesAll() as $val)	{
?>
						<input type="checkbox" name="spons_categs[<?=$val['id']?>]" <?=in_array($val['id'],$spons_categs_arr) ? "checked='checked'" : ''?>  style="" />&nbsp;<span style="margin-right:10px;"><?=no_magic_quotes($val['category'])?></span>
<?				
					}
?>
                </div>
            </div>
            
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="description">Sponsor Popular/Investment</label>
<? 
					$spons_non_categs_arr	= explode(',',$profile['spons_non_categs']);
					foreach(getNonLifestyles() as $val)	{
?>
						<input type="checkbox" name="spons_non_categs[<?=$val['id']?>]" <?=in_array($val['id'],$spons_non_categs_arr) ? "checked='checked'" : ''?>  style="" />&nbsp;<span style="margin-right:10px;"><?=no_magic_quotes($val['lifestyle'])?></span>
<?				
					}
?>
                </div>
            </div>
            
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

<!-- Modal 7 (Ajax Modal)-->
<div class="modal fade" id="modal-news">
	<div class="modal-dialog" style="width:80%;">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Close">&times;</button>
                <h4 class="modal-title">Add / Edit News</h4>
			</div>
			
			<div class="modal-body">
			
				Content is loading...
				
			</div>
			
		</div>
	</div>
    
</div>

<!-- Modal 7 (Ajax Modal)-->
<div class="modal fade" id="modal-testimonials">
	<div class="modal-dialog" style="width:80%;">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Close">&times;</button>
                <h4 class="modal-title">Add / Edit Testimonials</h4>
			</div>
			
			<div class="modal-body">
			
				Content is loading...
				
			</div>
			
		</div>
	</div>
    
</div>

</form>