
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
    <?php endblock(); ?>
        
        <?php startblock('content'); ?>
        <?php if($userInfo!=false) $userid= $userInfo->id; ?>
        <div class="blog">

    <p class="mainTitle">Discussion</p>
    <div class="subTitle">
        <span>My Posts</span>
        <span class="links">
            <a href="<?php echo base_url('discussion/posting');?>">Create Post</a>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="<?php echo base_url('discussion/'); ?>">Back to Discussion Page</a>
        </span>
    </div>
        
    <div class="bottom">
    <div class="entries">
    <?php if($posts==NULL) echo "This is no blog entry."; else if($posts==NULL&&$userInfo!=false&&$blogOwnerid==$userid) echo'This is no blog entry.</br></br>You can <a href="'.base_url('discussion/posting').'"><u>click here</u></a> to create a new blog entry.'?>
	<?php $index=0; foreach ($posts as $row): ?>
   
    <div class="user_entry">
    <div class="entry_topic"><a href="<?php echo base_url('discussion/postDetails?postid='.$row->postid);?>"><?php   echo $row->subject; ?></a></div>
    <div class="date"><i><?php echo $row->datetime;?></i></div>
    <div class="entry_tool">
        <?php if($userInfo!=false) { 
            if($blogOwnerid==$userid||$userInfo->email=="model@i-mos.org"){?>
                <a href="<?php echo base_url('discussion/edit_post/'.$row->postid);?>">Edit</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="<?php echo base_url('discussion/maintain?action=del&pre=blog&blogid='.$blogOwnerid.'&postid='.$row->postid);?>">Delete</a>
        <?php }}?>
    </div> 
    <div class="content">   
    
    <table width="530">
    <tr>
    <td>
    <div class="short_content" id="s<?php echo $row->postid;?>"><?php echo "<s".$row->postid.">"?><?php  echo substr($row->content,0,400); ?><?php echo "</s".$row->postid.">"?><div id="readMore<?php echo $row->postid;?>"><a  class="readMore" onclick="swap('s<?php echo $row->postid;?>','l<?php echo $row->postid;?>');" href="javascript:void(0)">Read more</a></div></div>
    </td>
    </tr>
    </table>

    <table width="530">
    <tr>
    <td>
    <span class="long_content" id="l<?php echo $row->postid;?>"><?php echo "<l".$row->postid.">"?><?php  echo $row->content; ?><?php echo "</l".$row->postid.">"?><span id="readMore<?php echo $row->postid;?>"><a class="readLess" onclick="swap('l<?php echo $row->postid;?>','s<?php echo $row->postid;?>');" href="javascript:void(0)">Read less</a></span></span>
    </td>
    </tr>
    </table> 
    
    <?php echo "<script language='javascript'>checkContent(".$row->postid.",".substr_count($row->content, '<br />').",".strlen($row->content).");</script>" ;?>
    
    </div> 
    
    <?php endforeach;?>
	</div><!--end entry-->
    </div><!--end bottom-->
    </div>
    
	<?php endblock(); ?>

<?php end_extend(); ?> 
