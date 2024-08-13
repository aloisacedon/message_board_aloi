<style>
	.message-card {
		padding: 1rem;
		border: solid 1px;
		border-radius: 10px;
		display: flex;
		gap: 1rem;
		/* height: 100px;
		overflow: hidden; */
	}
	.message-card a > img{
		width: 50px;
		height: 50px;
		object-fit: cover;
		border-radius: 100px;
		box-shadow: 3px 2px 1rem rgba(0, 0, 0, .175);
	}

	.truncate {
		width: 450px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.read-more, .read-less {
		color: blue;
		cursor: pointer;
		text-decoration: underline;
	}

</style>
<div class="container">
	<div class="card mt-5 shadow-lg">
		<div class="card-body">
			<div class="d-flex justify-content-between">
				<h3 class="card-title mb-5">Message Details</h3>
				<!-- <a href="<?php echo $this->Html->url(['action'=> 'new'])?>" style="height:45px" class="btn btn-primary">New Message</a> -->
			</div>
			<div class="col-md-6 ml-auto card shadow-lg mb-3">
				<div class="card-body ">
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Search messages" aria-label="Search messages" id="search_input" aria-describedby="search-btn">
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" id="search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
					</div>
					</div>
				<form id="replyDetailsForm" method="post" accept-charset="utf-8">
					<input type="hidden" name="receiver_id" value="<?php echo $receiver_id?>" id="replyReceiverId">
					<input type="hidden" name="sender_id" value="<?php echo $logged_user['id']?>" id="replySenderId">
					<div class="form-group">
						<textarea name="content" div="form-group" class="form-control" id="replyContent"></textarea>
					</div>

					<button class="btn btn-primary d-block ml-auto" id="replybtn">Reply message</button>
				</form>
					<!-- <?php echo $this->Form->create('reply')?>

					<?php echo $this->Form->input('receiver_id', array('type' => 'hidden', 'value' => $receiver_id)); ?>
					<?php echo $this->Form->input('sender_id', array('type' => 'hidden', 'value' => $logged_user['id'])); ?>
					<div class="form-group">
						<?php echo $this->Form->textarea('content',['label' => 'Message','div' => 'form-group','class'=> 'form-control'])?>
					</div>

					<?php
					$options = array(
						'label' => 'Reply message',
						'class' => 'btn btn-primary d-block ml-auto'
					);
					echo $this->Form->end($options)?> -->
				</div>
			</div>
			<div class="messages-list" id="messages">
			<?php
				if(isset($results)){
					// exit(var_dump($results));
					foreach($results as $key=>$val){
						$href = ($logged_user['id'] == $val['m1']['sender_id']) ? '/cakephp/profile' : '/cakephp/profile?id='.$val['m1']['sender_id'];
						$displayName = ($logged_user['id'] == $val['m1']['sender_id']) ? '' : $val['up1']['name'];
						$del_btn = ($logged_user['id'] == $val['m1']['sender_id']) ? '<a href="#" data-id="'.$val['m1']['id'].'"  class="delete-text text-danger"><small><i class="fa fa-trash" aria-hidden="true"></i> delete conversation</small></a>' : '';
						$img = $val['up1']['image_path'] ?:  "img/avatar.png";
						$you = ($logged_user['id'] == $val['m1']['sender_id']) ? '<p class="text-center text-muted mt-1"><small>You</small></p>' : '';
						$content = $val['m1']['content'];
						$truncate_class = '';
						$see_more = '';
						if(strlen($content) > 50){
							$truncate_class = 'truncate';
							$see_more = '<a href="#" class="truncate-toggle" >see more</a>';
						}
						echo '
						<div class="message-card mb-2 '.($logged_user['id'] == $val['m1']['sender_id'] ? 'flex-row-reverse border border-info' : '').'">
							<a href="'.$href.'">
								<img src="../../'.$img.'" alt="">
								'.$you.'
							</a>
							<div class="d-flex flex-column justify-content-between flex-fill">
								<small class="text-muted">'.$displayName.'</small>
								<div class="content '.$truncate_class.'">'.$content.' </div>
								<div class="d-flex justify-content-between '.($logged_user['id'] == $val['m1']['sender_id'] ? 'flex-row-reverse' : '').'">

									'.$del_btn.'
									<div class="date-time text-muted font-weight-lighter text-right" style="font-size: 14px;">'.date("F d, Y ga",strtotime($val['m1']['timestamp'])).' '.$see_more.'</div>
								</div>
							</div>
						</div>';
					}
				}

			echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled d-none'));
			echo $this->Paginator->next('Show more »', null, null, array('class' => 'disabled d-none'));
			?>
			</div>


		</div>
	</div>
</div>
<script>
	$(function(){
		$("#replybtn").click(function(e){
			e.preventDefault();
			let form = $("#replyDetailsForm").serializeArray();
			$.post('/cakephp/messages/reply',form,function(res){

				if(res.status == 'failed'){
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: res.msg
					});
				}else{
					console.log(res.data);
					$("#replyContent").val('');
					$("#messages").load(location.href + " #messages");
				}
			},'json')
		})

		$(document).on('click','.delete-text',function(e){
			e.preventDefault();
			let _this = $(this);
			let id = _this.data('id');
			Swal.fire({
				title: "Do you want to delete this text?",
				showDenyButton: true,
				confirmButtonText: "Delete",
				}).then((result) => {
				if (result.isConfirmed) {
					$.post('/cakephp/messages/delete_text',{id},function(res){
						console.log(res);
						_this.closest('.message-card').fadeOut();
					},'json');
				}
			});
		})

		$(document).on('click','.truncate-toggle',function(e){
			e.preventDefault();

			$(this).parent().parent().prev().toggleClass('truncate content');
			if($(this).parent().parent().prev().hasClass('truncate')){
				$(this).text('See more');
			}else{
				$(this).text('See less');
			}
		})


		$("#search-btn").click(function(e){
			e.preventDefault();
			let logged_id = parseInt('<?= $logged_user['id']?>');
			$.getJSON('/cakephp/messages/search_messages',{token:'<?php echo $this->request->params['pass'][0]?>',term:$("#search_input").val() },function(res){
				console.log(res);
				if(res.status == 'success'){
					$("#messages").empty();
					let messages = '';
					$.each(res.data,function(idx,val){
						console.log(logged_id,val['sender']['id']);
						let del_btn = (logged_id == val['sender']['id']) ? `<a href="#" data-id="${val.m1.id}"  class="delete-text text-danger"><small><i class="fa fa-trash" aria-hidden="true"></i> delete conversation</small></a>` : '';
						let href = (logged_id == val['m1']['sender_id']) ? '/cakephp/profile' : '/cakephp/profile?id='+val['m1']['sender_id'];
						let img = val['sender']['image_path'] ? val['sender']['image_path'] :  "img/avatar.png";
						let you = (logged_id == val['m1']['sender_id']) ? '<p class="text-center text-muted mt-1"><small>You</small></p>' : '';
						let content = val['m1']['content'];
						let displayName = (logged_id == val['m1']['sender_id']) ? '' : val['sender']['name'];
						let truncate_class = '';
						let see_more = '';
						if(content.length > 50){
							truncate_class = 'truncate';
							see_more = '<a href="#" class="truncate-toggle" >see more</a>';
						}
						messages += `<div class="message-card mb-2 ${(logged_id == val['m1']['sender_id']) ? 'flex-row-reverse border border-info' : ''}">
							<a href="${href}">
								<img src="../../${img}" alt="">
								${you}
							</a>
							<div class="d-flex flex-column justify-content-between flex-fill">
								<small class="text-muted">${displayName}</small>
								<div class="content ${truncate_class}">${content} </div>
								<div class="d-flex justify-content-between ${logged_id == val['m1']['sender_id'] ? 'flex-row-reverse' : ''}">

									${del_btn}
									<div class="date-time text-muted font-weight-lighter text-right" style="font-size: 14px;">${date_format(val['m1']['timestamp'])} ${see_more}</div>
								</div>
							</div>
						</div>`;
					});
					messages += '<div class="row"><a class="btn btn-link" onclick="window.location.reload()">Back to messages</a></div>';
					$("#messages").html(messages);
				}else{
					window.location.reload();
				}
			})
		})
	});

	function date_format(timestamp){
		const date = new Date(timestamp);

		const options = {
			month: 'long',  // Full month name
			day: '2-digit', // Day of the month, 2 digits
			year: 'numeric' // Full numeric year
		};

		const formattedDate = date.toLocaleDateString('en-US', options);
		const hours = date.getHours() % 12 || 12; // Convert 24h to 12h, handling midnight (0)
		const ampm = date.getHours() >= 12 ? 'pm' : 'am';

		const finalFormattedDate = `${formattedDate} ${hours}${ampm}`;
		return finalFormattedDate;
		// console.log(finalFormattedDate);
	}
</script>
