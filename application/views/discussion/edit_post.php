
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		Discussion
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
        <script src="<?php echo resource_url('js', 'ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
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

    <p class="mainTitle">Discussion</p>
    <div class="subTitle">
        <span>Edit post</span>
        <span class="links">
            <?php if($userInfo==NULL):?>
            <a href="<?php echo base_url('account/authErr');?>">My Posts</a>
            <?php else: ?>  
            <a href="<?php 
                if ($userInfo==false) {
                    echo base_url('discussion/blog/');
                } else {
                    echo base_url('discussion/blog/'.$userInfo->id);
                    $userid=$userInfo->id;
                }
            ?>">My Posts</a>
            <?php endif ?>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="<?php echo base_url('discussion/'); ?>">Back to Discussion Page</a>
        </span>
    </div>

       <div class="discussion" style="border:none;padding:0;margin:0">
       	<?php $index=0; foreach ($posts as $row): ?>
       <div class="posting">
       
       <form id="posting" name="posting" method="post" action="<?php echo base_url('discussion/maintain?action=edit&postid='.$row->postid)?>">

        <div class="prompt">
            <div class="topic">Topic:</div>
            <div class="content_title">Content:</div>
        </div>

       <div class="form">
                  <input type="hidden" name="userid" value="<?php  echo $userInfo->id;?>" />
           <?php $datetime=date("Y-m-d H:i:s");//current datetime YYYY-MM-DD 00:00:00 UTC+8 ?>
           <input type="hidden" name="datetime" value="<?php echo $datetime;?>" />

         
         <div class="topic"><input class="subject" name="subject" type="text" size="60" value="<?php echo $row->subject;?>"/></div>
         
         
         <div class="content_title"></div>

         <div class="content">
                  <textarea name="editor1"  id="editor1"><?php echo $row->content;?></textarea>
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

         </div>
       </form>
       </div>
       <?php endforeach  ?>
</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 
