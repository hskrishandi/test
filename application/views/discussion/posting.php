
<?php extend('layouts/layout.php'); ?>

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
    			$('#reply_form').submit();	
    		});
        });
	</script>

    <p class="mainTitle">Discussion</p>
    <div class="subTitle">
        <span>Create a new post</span>
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


    <div class="posting">
        <div class="prompt">
            <div class="topic">Topic:</div>
            <div class="content_title">Content:</div>
        </div>
        <div class="formContent">
            <form id="posting" name="posting" method="post" action="<?php echo base_url('discussion/submitPostForm')?>">
                <input type="hidden" name="userid" value="<?php  echo $userid;?>" />
                <?php $datetime=date("Y-m-d H:i:s");//current datetime YYYY-MM-DD 00:00:00 UTC+8 ?>
                <input class="subject" name="subject" type="text" style="width:100%" />
                <input type="hidden" name="datetime" value="<?php echo $datetime;?>" />
                <div class="inputcontent">
                    <textarea name="editor1"  id="editor1"></textarea>
             	    <script type="text/javascript">
    				    CKEDITOR.replace('editor1',
                        {
                            on :
                            {
                                instanceReady: function(ev) {
                                    // Output paragraphs as <p>Text</p>.
                                    this.dataProcessor.writer.setRules('p',
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
                            <div class="submit"><input type="submit" name="submit" value="Post Topic" class="submit" /></div>
            </form>
        </div>
        <div class="userInfo">
            <div>
                <?php if($userInfo->email=='model@i-mos.org'): ?>
                    <?php if($userInfo->name==""):?>
                        <img src="<?php echo base_url('uploads/user_photo/5045be202038d_n.png'); ?>" width="100" />
                    <?php else: ?>
                        <img src="<?php echo base_url('images/simulation/'.$userInfo->name.".png"); ?>" width="100" />
                    <?php endif;?>
                                
                <?php else:
                    if ($userInfo->photo_path == ""):?>
                        <img src="<?php echo resource_url('css', 'images/usericon.gif'); ?>" width="100" />
                    <?php else:?>
                        <img src="<?php echo resource_url('user_image', $userInfo->photo_path.'_n'.$userInfo->photo_ext); ?>" width="100" />
                    <?php endif;?>     
                <?php endif;?>
            </div>
            <div class="userName">
                <?php if($userInfo->displayname=="i-MOS"&&$userInfo->name!="")
                    echo $userInfo->name;
                else if($userInfo->displayname=="i-MOS"&&$userInfo->name=="")
                    echo "<span class='italic'>i</span>-MOS";
                else echo $userInfo->displayname;?>
            </div>
            <div><?php echo date("Y-m-d"); ?></div>
            <div><?php echo date("H:i:s"); ?></div>
        </div>
    </div>
<?php endblock(); ?>

<?php end_extend(); ?> 
