<link rel="stylesheet" type="text/css" href="dist/fontawesome/css/all.min.css">

<div class="col-md-12 col-lg-12" style="padding: 20px;">
    <div class="container box p-3 ">
        <h3>Masterfile</h3><hr>
    
    <!-- Progress bar HTML -->
	   <div class="hidden-loader" style="z-index: 2; height: 100%; width: 100%; top: 50%; left: 50%; position: fixed; ">
        <i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i>
      </div>


        <div class="col-lg-6 col-md-4 mb-3">
        	<?php echo form_open_multipart('upload/save_data', array( 'id' => 'add_da_form', 'class' => 'needs-validation', 'novalidate' => true));?>
				<div class="form-group">
					<label for="file">File to Upload <span style="color: red"><i>(Only Excel/CSV File allowed).</i></span></label>
		      		<input type="file" class="form-control" id="file_upload" name="userfile" required>
					
				</div>
				<button type="submit" class="btn btn-primary" name="submit" id="import_btn" value="submit"><span class="fa fa-file-import"></span> Import</button>
			<?php echo form_close();?>
	    </div>


    </div>
</div>


<!-- Defaults -->
<script src="dist/js/jquery.min.js"></script>
<script src="dist/js/popper.min.js"></script>
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/jquery.form.validator.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){   
  $('.hidden-loader').hide(); 
});

 $('#import_btn').click(function(){
  $('.hidden-loader').fadeIn(); 
});
</script>