
<html>
<head>
	<?php	
		$meta = array(
			array('name' => 'keywords', 'content' => 'i-MOS, iMOS'),
			array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
		);

		echo meta($meta); 	
	?>
	<?php start_block_marker('meta'); ?>
    <?php end_block_marker(); ?>
	<title>
		<?php start_block_marker('title'); ?>Home<?php end_block_marker(); ?> | i-MOS
	</title>
	
	<?php start_block_marker('css'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'reset.css'); ?>" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'style.css'); ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
    <?php end_block_marker(); ?>
	
	<?php start_block_marker('script'); ?>
		<script type="text/javascript">
			var CI_ROOT = "<?php echo base_url();?>";
		</script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'login.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'constant.js'); ?>" type="text/javascript" charset="utf-8"></script>
                <script type="text/javascript" src="<?php echo resource_url('js', 'library/jquery.validate.min.js');?>"></script>
        <script  src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>
        
    <?php end_block_marker(); ?>
</head>

 <body>

    
       <div class="post_details">   
       <div class="posts">

    	<?php  foreach ($posts as $row): ?>
    	
  
      <div class="comment_title"><strong>Comment (<?php echo $countComment;?>): </strong></div>
      
      <?php  foreach ($reply as $reply_row): ?>
      <div class="comment">
      	<div class="user_comment"><?php echo $reply_row->comment;?></div>
        <div class="user_reply_info"><i><?php echo $reply_row->datetime;?></i>&nbsp;&nbsp;<a href="<?php echo base_url('discussion/blog/'. $reply_row->id); ?>">
		
		<?php echo $reply_row->displayname;?></a></div>
        </div>
      <?php endforeach ?>
      <div class="reply">

      <form  id="reply_form" name="reply_form" method="post" action="<?php echo base_url('discussion/submitReplyForm')?>">
      <input type="hidden" name="postid" value="<?php  echo $row->postid;?>" />
      <input type="hidden" name="userid" value="<?php if($userInfo)  echo $userInfo->id;?>" />
      <?php $datetime=date("Y-m-d H:i:s");//current datetime YYYY-MM-DD 00:00:00 UTC+8 ?>
      <input type="hidden" name="datetime" value="<?php echo $datetime;?>" />
     
                        <textarea name="comment" rows="5"  id="comment" style="width:600px;" ></textarea>
     
      
      <div class="error" id="error"></div>
      <div class="form_submit"><a onClick="checkComment()" class="submit" id="submit">Submit</a></div>      
      </form>  
 	</div>
	
    <?php endforeach ?>

    
    
    </div>
 
    
    </div>
    </body>
</html>