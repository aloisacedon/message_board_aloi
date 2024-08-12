<div class="container">
		<?php
		// exit(var_dump($this->Session->check('Message.flash')));
		if($this->Session->check('Message.flash'))
		{
			echo '<div class="alert alert-info mt-2">'. $this->Session->flash('flash') .'</div>';
		} ?>
	<div class="card mt-5 shadow-lg">


		<div class="card-body">
				<h2 class="card-title mb-2">User Profile</h2>
				<div class="row mt-5">
				<div class="col-md-12">
					<div class="d-flex gap-3">
						<div class="card w-25">
							<div class="card-body">
								<object class="img-fluid" data="<?php echo $profile['info']['image_path']?>" type="image/png">
									<img class="img-fluid" src="img/avatar.png" alt="">
								</object>
							</div>
						</div>
						<div class="ml-md-5">
							<p class="lead"><?php echo $profile['info']['name']?></p>
							<p>Gender: <?php echo $profile['info']['gender'] == "M" ? 'Male' :'Female' ?></p>
							<p>Birthdate: <?php echo date("F d, Y",strtotime($profile['info']['birthdate']));?></p>
							<p>Joined: <?php echo date("F d, Y ga",strtotime($profile['joined'])) ?></p>
							<p>Last Login: <?php echo date("F d, Y ga",strtotime($profile['last_login_time']))?></p>
						</div>

					</div>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-md-6">
					<p>Hubby:</p>
					<p><?php echo $profile['info']['hubby']?></p>
				</div>
			</div>
			<div class="row justify-content-end px-5">
				<?php if($profile['edit']){?>
					<a href="<?php echo $this->Html->url(['controller' => 'profile','action' => 'edit']); ?>" class="btn btn-info">Edit Profile</a>
				<?php }?>
			</div>
		</div>
	</div>

</div>
