
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		User experience Management
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'cms.css'); ?>" media="all" />
        <script src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>
    <?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
        
         
	<?php endblock(); ?>
    

    
<?php startblock('content'); ?>
    <div class="cms">
    	<div class="user_experience">
    	<h2 class="title">User experience Management</h2>
            <form method="post" action=""> 
            <table>
                  <tr>
                    <th><input type="checkbox" onclick="setCheckboxes(this)"></th>
                    <th>ID</th>
                    <th>Comment</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Approve</th>
                    
                  </tr>
                  <?php $index=0; foreach ($user_experience as $row): ?>
                  <tr>
                    <td class="checkbox">
                      <input type="checkbox"  name="user_experience_id[]" value="<?php ?>">
                    </td>
                    <td><?php echo $row->id;?></td>
                    <td><?php echo $row->comment;?></td>
                    <td><?php echo $row->first_name . ' ' . $row->last_name;?></td>
                    <td><?php echo date('Y', strtotime($row->date));?></td>
                    <td><a href="../discussion/edit_post/<?php echo $row->id;?>">edit</a></td>
                    <td><a href="#">delete</a></td>
                    <td>Approve</td>
                  </tr>
                  <?php endforeach;?>
            </table>
            <input name="submit" type="submit" value="Delete" class="submit">
            </form>
            <a class="return-link" href="<?php echo base_url('/cms');?>">
			Back
			</a>   
      </div>    
</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
