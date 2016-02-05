
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		model
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
			
			page('#modelTable');
			
		});
</script>

    <div class="cms">
    	<div class="model">
        	<h2 class="title">model Management</h2>	
            <form name="form" method="post" action=""> 
            <table id="modelTable">
            	  <thead>
                  <tr>
                    <th><input type="checkbox" name="allbox" onclick="CheckAll('model_id[]','form');"></th>
                    <th>Name</th>
                    <th>Short Name</th>
                    <th>Icon Name</th>
                    <th>Desc Name</th>
                    <th>Organization</th>
                    <th>Type</th>
                    <th>Edit</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($models as $row): ?>
                  <tr id="<?php echo 'model'.$row->id;?>">
                    <td id="<?php echo $row->id;?>" class="checkbox" >
                      <input id="modelCheckBox<?php echo $row->id;?>" type="checkbox"  name="model_id[]" value="<?php echo $row->id;?>">
                    </td>
                    <td><?php echo $row->name;?></td>
                    <td><?php echo $row->short_name;?></td>
                    <td><?php echo $row->icon_name;?></td>
                    <td><?php echo $row->desc_name;?></td>
                    <td><?php echo $row->organization;?></td>
                    <td><?php echo $row->type;?></td>
                    <td><a href="model/edit_model?id=<?php echo $row->id;?>">edit</a></td>
                  </tr>
                  <?php endforeach;?>
                  </tbody>
                    <tfoot class="nav">
                        <tr>
                            <td colspan="8">
                                <div class="pagination"></div>
                                <div class="paginationTitle">Page</div>
                                <div class="selectPerPage"></div>
                                <div class="status"></div>
                            </td>
                        </tr>
                    </tfoot>  
            </table>
            <input type="hidden" name="type" value="model" />
            <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form,'model','model')"         	/>
            </form>
            <a class="return-link" href="<?php echo base_url('/cms');?>">
			Back
			</a>
		</div>
        
	</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
