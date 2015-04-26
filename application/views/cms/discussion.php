
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		Discussion
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'cms.css'); ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jTPS.css'); ?>" media="all" />
        <script src="<?php echo resource_url('js', 'cms.js'); ?>" type="text/javascript"></script>
    <?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
        
         
	<?php endblock(); ?>

<?php startblock('content'); ?>
<script>
					  
$(function () { 
			
			page('#discussionTable');
			
		});
</script>

    <div class="cms">
    	<div class="discussion">
        	<h2 class="title">Discussion Management</h2>	
            <form name="form" method="post" action=""> 
            <table id="discussionTable">
            	  <thead>
                  <tr>
                    <th><input type="checkbox" name="allbox" onclick="CheckAll('post_id[]','form');"></th>
                    <th>Post ID</th>
                    <th>Subject</th>
                    <th>Author</th>
                    <th>Datetime</th>
                    <th>Edit</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php $index=0; foreach ($posts as $row): ?>
                  <tr id="<?php echo 'discussion'.$row->postid;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                    <td id="<?php echo $row->postid;?>" class="checkbox" >
                      <input id="discussionCheckBox<?php echo $row->postid;?>" type="checkbox"  name="post_id[]" value="<?php echo $row->postid;?>">
                    </td>
                    <td><?php echo $row->postid;?></td>
                    <td><a id="<?php echo 'discussionEdit'.$row->postid;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="<?php echo base_url('discussion/postDetails?postid='.$row->postid);?>"><?php echo $row->subject;?></a></td>
                    <td><?php echo $row->displayname;?></td>
                    <td><?php echo $row->datetime;?></td>
                    <td><a id="<?php echo 'discussionLink'.$row->postid;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="../discussion/edit_post/<?php echo $row->postid;?>">edit</a></td>
                  </tr>
                  <?php endforeach;?>
                  </tbody>
                    <tfoot class="nav">
                        <tr>
                            <td colspan="6">
                                <div class="pagination"></div>
                                <div class="paginationTitle">Page</div>
                                <div class="selectPerPage"></div>
                                <div class="status"></div>
                            </td>
                        </tr>
                    </tfoot>  
            </table>
            <input type="hidden" name="type" value="discussion" />
            <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form, 0,'discussion','discussion')">
			<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form, 1,'discussion','discussion')">
            <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form,'discussion','discussion')"         	/>
            </form>
            <a class="return-link" href="<?php echo base_url('/cms');?>">
			Back
			</a>
		</div>
        
	</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
