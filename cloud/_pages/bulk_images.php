<form id="form_images" action="" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
	  <tr onMouseOver="this.className = 'mouseOverRow';" onMouseOut="this.className = '';">
		<td colspan="3" >
        	<a href="index.php?_page=manage-images" class="bs-example">
                <button type="button" class="btn btn-primary pull-right">Back</button>
            </a>
        </td>
	  </tr> 	
      <tr>  

		<td width="41%">
            <div id="file-uploader">		
                <noscript>			
                    <p>Please enable JavaScript to use file uploader.</p>
                    <!-- or put a simple form for upload here -->
                </noscript>         
            </div>
            
            <script src="fileuploader.js" type="text/javascript"></script>
            <script>        
                function createUploader(){            
                    var uploader = new qq.FileUploader({
                        element: document.getElementById('file-uploader'),
                        action: 'image_upload.php',
                        debug: true
                    });           
                }
                
                // in your app create uploader as soon as the DOM is ready
                // don't wait for the window to load  
                window.onload = createUploader;     
            </script>
            
        </td>
	  </tr>
  
      
</table>
</form>