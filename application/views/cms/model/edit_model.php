
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		model
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'cms.css'); ?>" media="all" />

        <script src="<?php echo resource_url('js', 'cms.js'); ?>" type="text/javascript"></script>
    <?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
        
         
	<?php endblock(); ?>

<?php startblock('content'); ?>


    <div class="cms">
    	<div class="edit_model">
        	<h2 class="title">model Management</h2>
        	<form name="form1" method="post" action="edit_model_submit">
            <?php foreach ($models as $row): ?>
        	  <table>
        	    <tr>
        	      <td>Name</td>
        	      <td><input name="name" type="text" id="name" value="<?php echo $row->name;?>" size="40" /></td>
      	      </tr>
        	    <tr>
        	      <td>Short Name</td>
        	      <td><input name="short_name" type="text" id="short_name" value="<?php echo $row->short_name;?>" size="40"></td>
      	      </tr>
        	    <tr>
        	      <td>Icon Name</td>
        	      <td><input name="icon_name" type="text" id="icon_name" value="<?php echo $row->icon_name;?>" size="40"></td>
      	      </tr>
        	    <tr>
        	      <td>Desc Name</td>
        	      <td><input name="desc_name" type="text" id="desc_name" value="<?php echo $row->desc_name;?>" size="40"></td>
      	      </tr>
        	    <tr>
        	      <td>Organization</td>
        	      <td><input name="organization" type="text" id="organization" value="<?php echo $row->organization;?>" size="40"></td>
      	      </tr>
        	    <tr>
        	      <td>Type</td>
        	      <td><input name="type" type="text" id="type" value="<?php echo $row->type;?>" size="40"></td>
      	      </tr>
        	    <tr>
        	      <td colspan="2"><input  type="submit" value="Submit" class="submit" ></td>
      	      </tr>
      	    </table>
            <input name="model_id" type="hidden" value="<?php echo $row->id;?>" />
   	      </form>
          <?php endforeach;?>
<a class="return-link" href="<?php echo base_url('/cms/model');?>">
	Back
	</a>
		</div>
        
	</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
