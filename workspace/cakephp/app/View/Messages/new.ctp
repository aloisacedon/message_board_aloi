<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="container">
	<div class="card shadow-lg mt-5">
		<div class="card-body">
			<h3 class="card-title">Create new message</h3>
			<?php echo $this->Form->create('new')?>
			<div class="form-group">
				<label for="">Recipient</label>
				<select class="form-control select-recipient" name="data[new][receiver_id]">
					<?php
						foreach($users as $key=>$val){
							echo '<option value="'.$val['User']['id'].'">'.$val['Profile']['name'].'</option>';
						}
					?>
				</select>
			</div>
			<?php echo $this->Form->input('sender_id', array('type' => 'hidden', 'value' => $sender_id)); ?>
			<div class="form-group">
				<label for="content">Message</label>
				<?php echo $this->Form->textarea('content',['label' => 'Message','div' => 'form-group','class'=> 'form-control'])?>
			</div>
			<?php echo $this->Form->end('send')?>
		</div>
	</div>
</div>

<script>
	$(function(){
		$('.select-recipient').select2({
			// minimumResultsForSearch: 20
		});
	});
</script>
