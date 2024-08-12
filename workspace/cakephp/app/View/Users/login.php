<div class="container">
	<div class="row mt-5">
		<div class="col-md-4 offset-3">
			<div class="lead mb-3">Login to your account!</div>
			<div class="card">
				<div class="card-body">
					<!-- <div class="card-title">Login</div> -->
					<div class="users form">
						<?php echo $this->Flash->render('auth'); ?>
						<?php
							if($this->Session->check('Message.flash'))
							{
								echo '<div class="alert alert-danger">'. $this->Session->flash('flash') .'</div>';
							} ?>

						<?php echo $this->Form->create('User'); ?>
							<fieldset>
								<!-- <legend>
									<?php echo __('Please enter your username and password'); ?>
								</legend> -->
								<?php echo $this->Form->input('email', array('label' => 'Email','div' => 'form-group','type' => 'email','class'=> 'form-control')); ?>
								<?php echo $this->Form->input('password', array('label' => 'Password', 'type' => 'password','div' => 'form-group','class'=> 'form-control')); ?>
							</fieldset>
						<?php echo $this->Form->end(__('Login')); ?>
					</div>

				</div>
			</div>
			<p class="text-center mt-2">
				<a href="./register"  >Click here to Register here</a>
			</p>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // $(document).ready(function(){
    //    $("input[value='Login").click(function(){
    //         $.ajax({
    //             url: "/cakephp/users/ajaxLogin",
    //             type: "POST",
    //             data: {
    //                 email: $("input[name='data[User][email]']").val(),
    //                 password: $("input[name='data[User][password]']").val()
    //             },
    //             success: function(response){
    //                 var res = JSON.parse(response);
    //                 if (res.status == "success") {
    //                     window.location.href = "/cakephp/users/index";
    //                 }
    //             }
    //         });
    //         return false;
    //    });
    // });
</script>
