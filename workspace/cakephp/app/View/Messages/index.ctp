<style>
	.message-card {
		padding: 1rem;
		border: solid 1px;
		border-radius: 10px;
		display: flex;
		gap: 1rem;
	}
	.message-card > img{
		width: 100px;
		height: 100px;
		object-fit: cover;
	}
	.message-card:hover{
		background-color: #a7d1ff45;
		cursor: pointer;
	}
</style>
<div class="container">
	<div class="card mt-5 shadow-lg">
		<div class="card-body">
			<div class="d-flex justify-content-between">
				<h3 class="card-title mb-5">Message list</h3>
				<a href="<?php echo $this->Html->url(['action'=> 'new'])?>" style="height:45px" class="btn btn-primary">New Message</a>
			</div>
			<div class="messages-list">
			<?php
				if(isset($results)){
					foreach($results as $key=>$val){
					$img = $val['users_profile']['image_path'] ?:  './img/avatar.png';

					echo '
					<div class="message-card mb-2 '.($logged_user['id'] == $val['m1']['sender_id'] ? 'flex-row-reverse' : '').'" data-token="'.$val['m1']['token'].'">
						<img src="'.$img.'" alt="">
						<div class="d-flex flex-column justify-content-between flex-fill">
							<small class="text-muted">'.$val['users_profile']['name'].'</small>
							<div class="content">'.$val['m1']['content'].'</div>
							<div class="d-flex justify-content-between '.($logged_user['id'] == $val['m1']['sender_id'] ? 'flex-row-reverse' : '').'">
								<a href="#" data-token="'.$val['m1']['token'].'"  class="delete-conversation text-danger"><small><i class="fa fa-trash" aria-hidden="true"></i> delete conversation</small></a>
								<div class="date-time text-muted font-weight-lighter text-right" style="font-size: 14px;">'.date("F d, Y ga",strtotime($val['m1']['timestamp'])).'</div>
							</div>
						</div>
					</div>';
				}
			}

			echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled d-none'));
			// echo $this->Paginator->numbers();
			echo $this->Paginator->next('Show more »', null, null, array('class' => 'disabled d-none'));
			?>
			</div>


		</div>
	</div>
</div>

<script>
	$(function(){
		$(".delete-conversation").click(function(e){
			e.preventDefault();
			let _this = $(this);
			let token = _this.data('token');
			Swal.fire({
				title: "Do you want to delete the conversation?",
				showDenyButton: true,
				confirmButtonText: "Delete",
				}).then((result) => {
				if (result.isConfirmed) {
					$.post('/cakephp/messages/delete_conversation',{token},function(res){
						console.log(res);
						_this.closest('.message-card').fadeOut();
					},'json');
				}
			});
		})

		$(".message-card").click(function(e){
			let _this = $(this);
			let token = _this.data('token');
			window.location.href = '/cakephp/messages/details/'+token;
		})
	});
</script>
