<div class="post_details">
	<div class="rating">
		<strong>Model Rating: </strong><div class="fivestar" id="<?php echo $model_name; ?>"/></div>
	</div>

	<div class="posts">

        <script>
	$(document).ready(function(){
						$('#submit').click(function(){

							$('#reply_form').submit();
								})
});
	</script>

	<?php  foreach ($posts as $row): ?>

		<div class="comment_title"><strong>Comment (<?php echo $countComment;?>): </strong></div>

		<?php  foreach ($reply as $reply_row): if($reply_row->type=="model"): ?>
			<div class="comment" id="commentid<?php echo $reply_row->commentid;?>">
			<div class="user_comment" ><?php echo $reply_row->comment;?></div>
			<div class="user_reply_info"> <i><?php echo $reply_row->datetime.' by';?></i>&nbsp;&nbsp;<a href="<?php echo base_url('discussion/blog/'. $reply_row->id); ?>"><?php echo $reply_row->displayname;?></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($userInfo!=false){ if($userInfo->id==$reply_row->id || $userInfo->class==99){?><a href="Javascript:void(0);" onclick="del_comment('<?php echo $reply_row->commentid;?>','<?php echo base_url();?>');">Delete</a><?php }}?></div>
			</div>
		<?php endif; endforeach ?>
		<div class="reply">
			<form  id="reply_form" name="reply_form" method="post" action="<?php echo base_url('discussion/submitReplyForm/model')?>">
				<input type="hidden" name="postid" value="<?php  echo $row->postid;?>" />
				<input type="hidden" name="userid" value="<?php if($userInfo)  echo $userInfo->id;?>" />
				<?php $datetime=date("Y-m-d H:i:s"); ?>
				<input type="hidden" name="datetime" value="<?php echo $datetime;?>" />
				<textarea name="comment" rows="5"  id="comment" style="width:600px;" ></textarea>
				<div class="error" id="error"></div>
				<div class="form_submit"><a onclick="form[0].sumbit()" class="submit" id="submit">Submit</a></div>
      			<input name="first_name" type="hidden" value="<?php echo $row->first_name;?>" />
      			<input name="last_name" type="hidden" value="<?php echo $row->last_name;?>" />
			</form>
		</div>

	<?php endforeach ?>

	</div>
</div>
