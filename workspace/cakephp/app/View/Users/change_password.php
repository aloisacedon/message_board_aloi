<style>
	.error-message{
		color: #c62828;
		font-size: smaller;
	}
</style>
<div class="container">
	<div class="row mt-5">
		<div class="col-md-4 offset-md-3">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Change Password</h4>

					<?php
					if($this->Session->check('Message.flash'))
					{
						echo '<div class="alert alert-danger">'. $this->Session->flash('flash') .'</div>';
					} ?>

					<?php
					// Display validation errors
					if ($this->User->validationErrors) {
						echo '<ul>';
						foreach ($this->User->validationErrors as $field => $errors) {
							foreach ($errors as $error) {
								echo '<li class="text-danger">' . h($error) . '</li>';
							}
						}
						echo '</ul>';
					}
					?>

					<?php echo $this->Form->create('User'); ?>
					<?php echo $this->Form->input('password', array('label' => 'New password', 'type' => 'password','div' => 'form-group','class'=> 'form-control')); ?>
					<?php echo $this->Form->input('confirm_password', array('label' => 'Confirm new password', 'type' => 'password','div' => 'form-group','class'=> 'form-control')); ?>

					<?php
					 $options = array(
							'label' => 'Submit',
							'class' => 'btn btn-primary'
						);
					 echo $this->Form->end($options);
					 ?>


				</div>
			</div>

		</div>
	</div>
</div>
