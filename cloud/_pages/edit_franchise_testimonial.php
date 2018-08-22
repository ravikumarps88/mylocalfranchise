<?php
$query = "SELECT * FROM testimonials WHERE id='{$_REQUEST['testimonial_id']}'";
$recordsList = dbQuery($query);
?>

<form id="rootwizard-2" action="index.php?_page=add_edit_franchise" method="post" enctype="multipart/form-data">

<input type="hidden" id="action" name="testimonial" value="save" />
<input type="hidden" name="testimonials_id" value="<?=$_REQUEST['testimonial_id']?>" />
<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
   
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Name - Business Name:<br />
        	<input type="text" name="name" value="<?=no_magic_quotes($recordsList[0]['name'])?>" id="form_name" class="form-control" required  /></td>
	  </tr>
      
      <!--<tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Company:<br />
        	<input type="text" name="company" value="<?=no_magic_quotes($recordsList[0]['company'])?>" id="form_name" class="form-control"  /></td>
	  </tr>-->
	  <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="3">
        	Testimonial:<br />
        	<textarea name="testimonials" id="testimonials" class="form-control autogrow" style="height:200px;" required ><?=no_magic_quotes($recordsList[0]['testimonial'])?></textarea>
        </td>
      </tr>
        
      <tr onmouseover="this.className = 'mouseOverRow';" onmouseout="this.className = '';">
		<td colspan="2">
            <button type="submit" name="testimonial" class="btn btn-primary pull-right">Save</button>
            <a href="index.php?_page=add_edit_franchise&action=edit&id=<?=$_REQUEST['id']?>" class="bs-example">
                <button type="button" class="btn btn-primary btn-icon pull-left">Back <i class="entypo-back"></i></button>
            </a>
		</td>
	  </tr>
      <br /><br />
      
</table>
</form>
