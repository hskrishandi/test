
<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Discussion
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
        <script src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>
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
                            <a href="<?php if($userInfo==false) echo base_url('discussion/blog/'); else echo base_url('discussion/blog/'.$userInfo->id);?>">My Blog</a>
                           	<?php endif ?>
						</li>
					</ul>
				<p></p>
			</div>
		</div>
	<?php endblock(); ?>
    

    
	<?php startblock('content'); ?>
   
       <div class="discussion">
    <div class="active_users">
 	     <table >
        <tr>
          <td colspan="7"><div><h3 class="title">Most Active Users</h3></div></td>
        </tr>
        <tr>
        <?php foreach ($activeUser as $activeUser_row): ?>
	  <td><div class="user_icon"><center>
		<?php if ($activeUser_row->photo_path !== "") { ?>
		<img src="<?php echo resource_url('user_image',  $activeUser_row->photo_path."_n".$activeUser_row->photo_ext); ?>" alt="" width="80" />
<?php } else { ?>
		<img src="<?php echo resource_url('css', 'images/usericon.gif'); ?>" alt="" width="80" />
<?php } ?>
		</br><a href="<?php echo base_url('discussion/blog/'. $activeUser_row->id); ?>"><span class="displayName"><?php if($activeUser_row->displayname=="i-MOS")echo"<span class='italic'>i</span>-MOS"; else echo $activeUser_row->displayname;?></span></a></center></td>

	<?php endforeach ?>
        </tr>
      </table>
  
    </div> <!--active user-->
    
    <div class="bottom">
    <div class="posts">
	<?php $index=0; foreach ($posts as $row): ?>
	<div class="user_post"> 
    <div class="leftcol">
    
    <?php if($row->email=='model@i-mos.org'): ?>
    	      <?php if($row->name==""):?>
              	<img src="<?php echo base_url('uploads/user_photo/5045be202038d_n.png'); ?>" width="100" />
              <?php else: ?>
              	<img src="<?php echo base_url('images/simulation/'.$row->name.".png"); ?>" width="100" />
              <?php endif;?>
							
    <?php else:
		   if ($row->photo_path == ""):?>
    	   <img src="<?php echo resource_url('css', 'images/usericon.gif'); ?>" width="100" />
   		   <?php else:?>
           <img src="<?php echo resource_url('user_image', $row->photo_path.'_n'.$row->photo_ext); ?>" width="100" />
           <?php endif;?>
         
    <?php endif;?>

    <div class="displayname"><a href="<?php echo base_url('discussion/blog/'. $row->userid); ?>"><span class="displayName"><?php if($row->displayname=="i-MOS"&&$row->name!="") echo $row->name; else if($row->displayname=="i-MOS"&&$row->name=="") echo "<span class='italic'>i</span>-MOS";  else echo $row->displayname;?></span></a></div>
    </div><!--end leftcol-->
    
    <div class="rightcol">
    <div class="title"><a href="<?php echo base_url('discussion/postDetails?postid='.$row->postid);?>"><?php   echo $row->subject; ?></a></div>
    <div class="date"><i><?php   echo $row->datetime; ?></i></div>
<div></div>
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
    </div><!--end rightcol-->
    
    </div><!--end user_post-->
    <div class="post_tool"><?php if($userInfo!=false){ if($row->userid==$userInfo->id||$userInfo->email=="model@i-mos.org"){?><a href="<?php echo base_url('discussion/edit_post/'.$row->postid);?>">Edit</a> <a href="<?php echo base_url('discussion/maintain?action=del&pre=discussion&postid='.$row->postid);?>">Delete</a><?php }}?> <a href="<?php echo base_url('discussion/postDetails?postid='.$row->postid);?>">Comment(<?php echo $countComment[$row->postid];?>)</a></div>
    
    <?php endforeach  ?>
    </div><!--end posts-->
    
    <div class="most_comments">
    <div class="most_comment_title"><h3 class="title">Most comment</h3></div>
        <?php 
		foreach ($mostComment as $mostComment_row): ?> 
         <div class="icon">
 		<?php if ($mostComment_row->photo_path == ""){ ?>
			<img src="<?php echo resource_url('css', 'images/usericon.gif'); ?>" alt="" width="80" />
		    <?php } else { ?>
			<img src="<?php echo resource_url('user_image', $mostComment_row->photo_path.'_n'.$mostComment_row->photo_ext); ?>" alt="" width="80" />
		<?php } ?> 
              <br/><a href="<?php echo base_url('discussion/blog/'. $mostComment_row->id); ?>"><span class="displayName"><?php echo $mostComment_row->displayname;?></span></a>    
          </div>
        
        <?php endforeach ?>
      
    </div><!--end most_comments-->
    
    </div><!--end bottom-->
    </div><!--end discussion-->
 	<script>if($(".displayName").html()=="i-MOS"){
		$(".displayName").attr('class',imos);
	$(".imos").html("<span class='italic'>i</span>-MOS")};
	 </script>
	<?php endblock(); ?>

<?php end_extend(); ?> 
