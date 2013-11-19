
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		Node Management
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


    <div class="cms">
<script>
					  
$(function () { 
			
			page('#nodesTable');
			
		});
</script>
    	<div class="users">
        	<h2 class="title">Node Management</h2>	
            <form method="post" action="" name="form"> 
            <table id="nodesTable">
            	  <thead>
                  <tr>
                    <th width="20" id="nodes_checkbox"><input type="checkbox"  name="allbox" onclick="CheckAll('nodes_id[]','form');"></th>
                    <th width="12" sort="decrip">ID</th>
                    <th sort="decrip">Nodename</th>
                    <th sort="decrip">Hostname</th>
                    <th width="170" sort="decrip">Path</th>
                    <th width="30" sort="decrip">Edit</th>
                    <th width="30" sort="decrip">Delete</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php $index=0; foreach ($nodes as $row): ?>
                  <tr id="<?php echo 'nodes'.$row->id;?>">
                    <td class="checkbox">
                      <input id="nodesCheckBox<?php echo $row->id;?>" type="checkbox"  name="nodes_id[]" value="<?php echo $row->id;?>">
                    </td>
                    <td><?php echo $row->id;?></td>
                    <td><?php echo $row->nodename;?></td>
                    <td><?php echo $row->hostname;?></td>
                    <td><?php echo $row->path;?></td>
                    <td><a href="<?php echo base_url("/cms/nodes/edit?name=" . $row->nodename);?>">edit</a></td>
                    <td><a href="<?php echo base_url("/cms/nodes/delete?name=" . $row->nodename);?>">delete</a></td>
                  </tr>
                  <?php endforeach;?>
                  </tbody>
                    <tfoot class="nav">
                        <tr>
                            <td colspan="7">
                                <div class="pagination"></div>
                                <div class="paginationTitle">Page</div>
                                <div class="selectPerPage"></div>
                                <div class="status"></div>
                            </td>
                        </tr>
                    </tfoot>  
            </table>
            <input type="hidden" name="type" value="nodes" />
            <a href="<?php echo base_url("/cms/nodes/add"); ?>"><button class="submit" type="button">Add</button></a>
            <!--
            <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form, 0,'nodes','nodes')">
			<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form, 1,'nodes','nodes')">
            <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form,'nodes','nodes')"         	/>
            -->
            </form>
            <a class="return-link" href="<?php echo base_url('/cms');?>">
			Back
			</a>
		</div>
        
	</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
