
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		Discussion
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
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
       <div class="discussion">
       
       <div class="posting">
       <form id="posting" name="posting" method="post" action="<?php echo base_url('discussion/submitPostForm')?>">
       
                  <input type="hidden" name="userid" value="<?php  echo $userid;?>" />
           <?php $datetime=date("Y-m-d H:i:s");//current datetime YYYY-MM-DD 00:00:00 UTC+8 ?>
           <input type="hidden" name="datetime" value="<?php echo $datetime;?>" />

         <h2 class="title">Create a new post</h2>
         <div class="topic">Topic:<input class="subject" name="subject" type="text" size="60" /></div>
         
         
         <div class="content_title">Content:</div>

         <div class="content">
                  <textarea name="editor1"  id="editor1"></textarea>
         			<script type="text/javascript">
								CKEDITOR.replace( 'editor1',
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
	
					CKEDITOR.replace( 'editor1' );
				toolbar : 'MyToolbar';
			</script>
       	 
         </div>
         <div class="submit"><input type="submit" name="submit" value="Submit" class="submit" /></div>

         
       </form>
       </div>
</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 
