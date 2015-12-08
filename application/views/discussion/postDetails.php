
<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Discussion
	<?php endblock(); ?>
    
    
  <?php startblock('css'); ?>
    <?php echo get_extended_block(); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
  <?php endblock(); ?>

  <?php startblock('script'); ?>
    <?php echo get_extended_block(); ?>
  	<script src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>
  	<script src="<?php echo resource_url('js', 'ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
  <?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
	<?php echo get_extended_block(); ?>
	<?php $this->load->view('account/account_block'); ?>




	<div class="block">
			<div>
				<h2>Dicussion</h2>
				<p></p>
					<ul class="menu">
						<li>
							<a href="<?php echo base_url('discussion/posting');?>">Create Post</a>
						</li>
                        <li>
                        	<?php if($userInfo==NULL):?>
							<a href="<?php echo base_url('account/authErr');?>">My Blog</a>
                            <?php else: ?>  
                            <a href="<?php if($userInfo==false) {echo base_url('discussion/blog/');} else {echo base_url('discussion/blog/'.$userInfo->id); $userid=$userInfo->id;}?>">My Blog</a>
                           	<?php endif ?>
						</li>
					</ul>
				<p></p>
				
			</div>
		</div>
	<?php endblock(); ?>
    

    
	<?php startblock('content'); ?>
    

    <script>
	$(document).ready(function(){
						$('#submit').click(function(){
							//$('#commentForm').submit();	
							$('#reply_form').submit();	

						})
});
	</script>
	 
    
       <div class="post_details">   
       <div class="posts">

    	<?php   foreach ($posts as $row): ?>
    	<div class="user_post">
  
      
      <div><h3 class="title"><?php   echo $row->subject; ?></h3></div> 
      <div class="date"><i><?php   echo $row->datetime; ?></i>&nbsp;  <a href="<?php echo base_url('discussion/blog/'. $row->id); ?>"><?php echo $row->displayname;?></a></div>
      <div class="post_content"><?php   echo $row->content; ?></div>
      <div class="comment_title"><strong>Comment (<?php echo $countComment;?>): </strong></div>
      
      <?php  foreach ($reply as $reply_row): ?>
      	<div class="comment" id="commentid<?php echo $reply_row->commentid;?>">
      	<div class="user_comment"><?php echo $reply_row->comment;?></div>
        <div class="user_reply_info"> <i><?php echo $reply_row->datetime.' by';?></i>&nbsp;&nbsp;<a href="<?php echo base_url('discussion/blog/'. $reply_row->id); ?>"><?php echo $reply_row->displayname;?></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($userInfo!=false){ if($userInfo->id==$reply_row->id || $userInfo->class==99){?><a href="Javascript:void(0);" onclick="del_comment('<?php echo $reply_row->commentid;?>','<?php echo base_url();?>');">Delete</a><?php }}?></div>
        </div>
      <?php endforeach ?>
      <div class="reply">
      
      <div id="error"></div>  
      
      <form  id="reply_form" name="reply_form" method="post" action="<?php echo base_url('discussion/submitReplyForm')?>">
      <input type="hidden" name="postid" value="<?php  echo $row->postid;?>" />
      
      <?php $datetime=date("Y-m-d H:i:s");//current datetime YYYY-MM-DD 00:00:00 UTC+8 ?>
      <input type="hidden" name="datetime" value="<?php echo $datetime;?>" />
                        <textarea name="comment"  id="comment"></textarea>
         			<script type="text/javascript">

				
				CKEDITOR.replace( 'comment',
    {
        on :
        {
            instanceReady : function( ev )
            {
                // Output paragraphs as <p>Text</p>.
                this.dataProcessor.writer.setRules( 'p',
                    {
                        indent : false,
                        breakBeforeOpen : false,
                        breakAfterOpen : false,
                        breakBeforeClose : false,
                        breakAfterClose : false
                    });
            }
        }
    });		
	
					CKEDITOR.replace( 'comment' );
				toolbar : 'MyToolbar';	
			</script>

      <div class="form_submit"><a class="submit" id="submit">Submit</a></div>
      <input name="first_name" type="hidden" value="<?php echo $row->first_name;?>" />
      <input name="last_name" type="hidden" value="<?php echo $row->last_name;?>" />
      <?php if($userInfo==false) {$userid=0; echo '<script>checkLogin("submit")</script>';}?>
      <input type="hidden" name="userid" value="<?php  echo $userid;?>" />
      </form>

 	</div>
    </div>
    <?php endforeach ?>

    
    
    </div>
 
    
    </div>
	<?php endblock(); ?>

<?php end_extend(); ?> 
