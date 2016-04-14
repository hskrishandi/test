<?php extend('layouts/layout.php'); ?>

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
        <span>Post</span>
        <span class="links">
            <a href="<?php echo base_url('discussion/posting');?>">Create Post</a>
            &nbsp;&nbsp;|&nbsp;&nbsp;
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

    <div class="post_details">   
        <div class="posts">
        	<?php foreach ($posts as $row): ?>
        	<div class="user_post" style="border:none">

                <div class="postContent">
                    <div class="leftPanel">
                        <div><h1 class="title"><?php echo $row->subject; ?></h1></div> 
                        <div class="date"><?php echo $row->datetime; ?>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('discussion/blog/'. $row->id); ?>"><?php echo $row->displayname;?></a></div>
                        <div class="post_content"><?php echo $row->content; ?></div>
                    </div>
                    <div class="rightPanel">
                        <div>
                            <?php if($row->email=='model@i-mos.org'): ?>
                                <?php if($row->name==""):?>
                                    <img src="<?php echo base_url('uploads/user_photo/5045be202038d_n.png'); ?>" width="75" />
                                <?php else: ?>
                                    <img src="<?php echo base_url('images/simulation/'.$row->name.".png"); ?>" width="75" />
                                <?php endif;?>
                                                    
                            <?php else:
                                if ($row->photo_path == ""):?>
                                    <img src="<?php echo resource_url('css', 'images/usericon.gif'); ?>" width="75" />
                                <?php else:?>
                                    <img src="<?php echo resource_url('user_image', $row->photo_path.'_n'.$row->photo_ext); ?>" width="75" />
                                <?php endif;?>
                                 
                            <?php endif;?>
                        </div>
                        <div class="userName">
                            <a href="<?php echo base_url('discussion/blog/'. $row->userid); ?>">
                                <span class="displayName">
                                    <?php if($row->displayname=="i-MOS"&&$row->name!="") echo $row->name; else if($row->displayname=="i-MOS"&&$row->name=="") echo "<span class='italic'>i</span>-MOS";  else echo $row->displayname;?>
                                </span>
                            </a>
                        </div>
                        <?php if($userInfo!=false){
                            if ($userid==$row->userid||$userInfo->email=="model@i-mos.org"){?>
                                <br>
                                <a href="<?php echo base_url('discussion/edit_post/'.$row->postid);?>">&gt; Edit</a>
                                <br>
                                <a href="<?php echo base_url('discussion/maintain?action=del&blogid='.$row->userid.'&postid='.$row->postid);?>">&gt; Delete</a>
                        <?php }}?>
                    </div>
                </div>

                 <div class="comment_title"><strong>Comment (<?php echo $countComment;?>): </strong></div>
                <?php  foreach ($reply as $reply_row): ?>
                <div class="comment" id="commentid<?php echo $reply_row->commentid;?>">
                    <div class="user_comment"><?php echo $reply_row->comment;?></div>
                    <div class="user_reply_info">
                        <div class="replyUser"><a href="<?php echo base_url('discussion/blog/'. $reply_row->id); ?>"><?php echo $reply_row->displayname; ?></a></div>
                        <div><?php $dateseg = explode(" ", $reply_row->datetime); echo $dateseg[0] ?></div>
                        <div><?php echo $dateseg[1] ?></div>
                    </div>
                </div>
                <?php endforeach ?>

                <div class="navigation">
                    <a href="#">Back to the top</a>
                    <a href="<?php echo base_url('discussion/'); ?>" style="float:right">Back to Discussion Page</a>
                </div>

                <div class="commentheader">Write a comment:</div>
      
                <div class="reply">
                    <div id="error"></div>
                    <div class="formContent">
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
                                    instanceReady: function(ev) {
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

                        <div class="form_submit"><a class="submit" id="submit">Post Comment</a></div>
                        <input name="first_name" type="hidden" value="<?php echo $row->first_name;?>" />
                        <input name="last_name" type="hidden" value="<?php echo $row->last_name;?>" />
                        <?php if($userInfo==false) {$userid=0; echo '<script>checkLogin("submit")</script>';}?>
                        <input type="hidden" name="userid" value="<?php if($userInfo!=false) echo $userInfo->id;?>" />
                        </form>
                    </div>
                    <?php if ($userInfo!=false): ?>
                    <div class="userInfo">
                        <div>
                            <?php if($userInfo->email=='model@i-mos.org'): ?>
                                <?php if($userInfo->name==""):?>
                                    <img src="<?php echo base_url('uploads/user_photo/5045be202038d_n.png'); ?>" width="75" />
                                <?php else: ?>
                                    <img src="<?php echo base_url('images/simulation/'.$userInfo->name.".png"); ?>" width="75" />
                                <?php endif;?>
                                            
                            <?php else:
                                if ($userInfo->photo_path == ""):?>
                                    <img src="<?php echo resource_url('css', 'images/usericon.gif'); ?>" width="75" />
                                <?php else:?>
                                    <img src="<?php echo resource_url('user_image', $userInfo->photo_path.'_n'.$userInfo->photo_ext); ?>" width="75" />
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
                <?php endif; ?>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endblock(); ?>

<?php end_extend(); ?> 