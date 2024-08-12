<div class="container">
	<div class="card mt-5 col-md-6">
		<div class="card-body">
		<?php echo $this->Form->create('Profile', array(
    	'enctype' => 'multipart/form-data'
	));?>
	<div class="row mt-5">
		<div class="col-md-12">
			<div class="d-flex gap-3 justify-content-center">
				<div class="card">
					<div class="card-body">
						<img style="max-width: 100px; max-height: 300px;" id="imagePreview" src="<?php echo $profile['info']['image_path'] ? '../'.$profile['info']['image_path'] : '../img/avatar.png' ?>" alt="">
						<!-- <object style="max-width: 100px; max-height: 300px;" data="../<?php echo $profile['info']['image_path']?>" type="image/png">
						</object> -->
						<!-- <img style="max-width: 100px; max-height: 300px;" id="imagePreview" src="data:image/png;base64,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" alt=""> -->
					</div>
				</div>
			</div>
			<?php if($this->Session->read('Message.flash')){
				echo '<div class="alert alert-danger my-2" role="alert">
						'.$this->Flash->render().'
					</div>';
			 } ?>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-md-12">
			<?php echo $this->Form->file('image');?>
			<?php echo $this->Form->input('email',['label' => 'Email Address','div' => 'form-group mt-2','class'=> 'form-control', 'value'=> $profile['email']]);?>
			<?php echo $this->Form->input('name',['label' => 'Name','div' => 'form-group','class'=> 'form-control', 'value'=> $profile['info']['name']]);?>
			<!-- <?php echo $this->Form->input('birthdate',['label' => 'Birth Date','div' => 'form-group','class'=> 'form-control']);?> -->
			<div class="form-group required">
				<label for="ProfileName">Birthdate</label>
				<input name="data[Profile][birthdate]" class="form-control" value="<?php echo $profile['info']['birthdate']?>" type="text" id="ProfileBirthdate" required="required"></div>
			<div class="form-group">
				<p for="">Gender</p>
				<?php
					// echo $this->Form->label('Profile.gender','Gender');
					$options = array('M' => 'Male', 'F' => 'Female');
					$attributes = array('legend' => false,'value'=>$profile['info']['gender']);
					echo $this->Form->radio('gender', $options, $attributes);
				?>
			</div>
			<div class="form-group">
				<p>Hubby:</p>
				<?php
					echo $this->Form->textarea('hubby', array('escape' => false,'rows' => '5', 'cols' => '30','value'=>$profile['info']['hubby']));
				?>

			</div>


		</div>
	</div>

	<?php
		$options = array(
			'label' => 'Update',
			'class' => 'btn btn-primary'
		);
		echo $this->Form->end($options);
	?>
		</div>
	</div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<script>
	$(function(){
		$("#ProfileBirthdate").datepicker({
			dateFormat: "yy-mm-dd",
			changeYear: true,
			// setDate: '<?php echo $profile['info']['birthdate'] ?>'
		});
		$("#ProfileImage").on('change',function(){
			var file = this.files[0];
			if (file) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#imagePreview').attr('src', e.target.result);
				}
				reader.readAsDataURL(file);
			}
		})
	})
</script>
