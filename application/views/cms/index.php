
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		Content Management System
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
    	<h2 class="title">Content Management System</h2>
        <div class="item">
    	<table>
    	  <tr>
          	<td>Index page description(0)</td>
    	    <td><a href="<?php echo base_url('/cms/activities');?>">i-MOS Activities(0)</a></td>
    	    <td><a href="<?php echo base_url('/cms/user_experience');?>">User Experience(0)</a></td>    	    
    	    <td><a href="<?php echo base_url('cms/discussion');?>">Discussion(0)</a></td>
  	    </tr>
    	  <tr>
    	    <td><a href="<?php echo base_url('cms/resources');?>">Resources(<?php echo $disapproved_res;?>)</a></td>
    	    <td><a href="<?php echo base_url('/cms/users');?>">Users(0)</a></td>
    	    <td>Sitemap(0)</td>
    	    <td><a href="<?php echo base_url('/cms/monitor'); ?>">Computer Nodes Monitor</a></td>
  	    </tr>
    	  <tr>
    	    <td><a href="">Computer Nodes Management</a></td>
    	    <td>&nbsp;</td>
    	    <td>&nbsp;</td>
    	    <td>&nbsp;</td>
  	    </tr>
  	  </table>
      </div>
</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
