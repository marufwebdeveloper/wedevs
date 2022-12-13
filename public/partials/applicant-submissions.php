<form method="post" enctype="multipart/form-data">
	<?php wp_nonce_field( 'applicant_submission_nonce_action', 'nnc_applicant_submission' );
	?>
	<input type="hidden" name="id" value="<?php echo $data->id??''; ?>">

	<div class="wd-form-control">
		<label class="wd-form-label">First Name</label>
		<input type="text" class="wd-form-field" name="first_name" value="<?php echo $data->first_name??''; ?>" required>
	</div>
	<div class="wd-form-control">
		<label class="wd-form-label">Last Name</label>
		<input type="text" class="wd-form-field" name="last_name" value="<?php echo $data->last_name??''; ?>" required>
	</div>
	<div class="wd-form-control">
		<label class="wd-form-label">Email</label>
		<input type="email" class="wd-form-field" name="email" value="<?php echo $data->email??''; ?>" required>
	</div>
	<div class="wd-form-control">
		<label class="wd-form-label">Mobile</label>
		<input type="text" class="wd-form-field" name="mobile" value="<?php echo $data->mobile??''; ?>" required>
	</div>
	<div class="wd-form-control">
		<label class="wd-form-label">Post</label>
		<input type="text" class="wd-form-field" name="post" value="<?php echo $data->post??''; ?>">
	</div>
	<div class="wd-form-control">
		<label class="wd-form-label">Address</label>
		<textarea class="wd-form-field" name="address"><?php echo $data->address??''; ?></textarea>
	</div>
	<div class="wd-form-control">
		<label class="wd-form-label">
			Upload CV
			<?php 
			if(isset($data->cv_name)&&$data->cv_name){				
				echo "<input type='hidden' name='pre_file_name' value='$data->cv_name'/><a href='".WdApplicantCv('url')."/$data->cv_name' target='_blank' style='font-size:16px'><b><i>See</i></b></a>";
			}
			?>
		</label>
		<input type="file" name="aplicant_cv">
	</div>
	<div class="wd-form-control" style="margin-top: 30px">
		<button class="wd-btn-primary" style="width:100%;max-width: 200px">Submit</button>
	</div>
</form>


