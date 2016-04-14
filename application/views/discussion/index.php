
<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		Discussion
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
        <script src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>
    <?php endblock(); ?>
    
	<?php startblock('content'); ?>
   
    <p class="mainTitle">Discussion</p>
    <div class="subTitle">
        <span>Post Topics</span>
        <span class="links">
            <a href="<?php echo base_url('discussion/posting');?>">Create Post</a>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <?php if($userInfo==NULL):?>
            <a href="<?php echo base_url('account/authErr');?>">My Posts</a>
            <?php else: ?>  
            <a href="<?php if($userInfo==false) echo base_url('discussion/blog/'); else echo base_url('discussion/blog/'.$userInfo->id);?>">My Posts</a>
            <?php endif ?>
        </span>
    </div>

    <div class="discussion">
    <div class="top">
    <div style="width:520px" class="discussionHeader">Topics</div>
    <div style="width:100px" class="discussionHeader">Replies</div>
    <div style="width:80px" class="discussionHeader"></div>
    </div>
    <div class="bottom">
    <div class="posts">
	<?php $index=0; foreach ($posts as $row): ?>
	<div class="user_post"> 
    <div class="leftcol">
    
    <?php if($row->email=='model@i-mos.org'): ?>
    	      <?php if($row->name==""):?>
              	<img src="<?php echo base_url('uploads/user_photo/5045be202038d_n.png'); ?>" width="50" />
              <?php else: ?>
              	<img src="<?php echo base_url('images/simulation/'.$row->name.".png"); ?>" width="50" />
              <?php endif;?>
							
    <?php else:
		   if ($row->photo_path == ""):?>
    	   <img src="<?php echo resource_url('css', 'images/usericon.gif'); ?>" width="50" />
   		   <?php else:?>
           <img src="<?php echo resource_url('user_image', $row->photo_path.'_n'.$row->photo_ext); ?>" width="50" />
           <?php endif;?>
         
    <?php endif;?>

    </div><!--end leftcol-->
    
    <div class="rightcol">
    <div class="title"><a href="<?php echo base_url('discussion/postDetails?postid='.$row->postid);?>"><?php   echo $row->subject; ?></a></div>
    <div class="date">
        <?php echo "By"?>
        <a href="<?php echo base_url('discussion/blog/'. $row->userid); ?>">
            <span class="displayName">
                <?php if($row->displayname=="i-MOS"&&$row->name!="") echo $row->name; else if($row->displayname=="i-MOS"&&$row->name=="") echo "<span class='italic'>i</span>-MOS";  else echo $row->displayname;?>
            </span>
        </a>
        <?php echo " > "?>
        <?php echo $row->datetime; ?>
        <?php if($userInfo!=false){
            if ($userInfo->id==$row->userid||$userInfo->email=="model@i-mos.org"){?>
                &nbsp;&nbsp;
                <a href="<?php echo base_url('discussion/edit_post/'.$row->postid);?>">Edit</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="<?php echo base_url('discussion/maintain?action=del&blogid='.$row->userid.'&postid='.$row->postid);?>">Delete</a>
        <?php }}?>
    </div>

    <div width="400">
    <div class="short_content" id="s<?php echo $row->postid;?>">
        <?php echo "<s".$row->postid.">"?>
        <?php  echo substr( // remove divs and blank lines
            str_replace("<div>","",
                str_replace("</div>","",
                    str_replace("<p>&nbsp;</p>","",$row->content)
                )
            ),
        0,60); ?>
        <?php echo "</s".$row->postid.">"?>
    </div>
    </div>
    
    </div><!--end rightcol-->
    <div class="replies"><?php echo $countComment[$row->postid];?></div>

    </div><!--end user_post-->
    
    <?php endforeach  ?>
    <div class="backtop"><a href="#">Back to the top</a></div>
    </div><!--end posts-->
    
    
    </div><!--end bottom-->
    </div><!--end discussion-->
 	<script>if($(".displayName").html()=="i-MOS"){
		$(".displayName").attr('class',imos);
	$(".imos").html("<span class='italic'>i</span>-MOS")};
	 </script>
	<?php endblock(); ?>

<?php end_extend(); ?> 
