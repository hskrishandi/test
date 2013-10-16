
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		User Management
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
			
			page('#usersTable');
			
		});
</script>
    	<div class="users">
        	<h2 class="title">User Management</h2>	
            <form method="post" action="" name="form"> 
            <table id="usersTable">
            	  <thead>
                  <tr>
                    <th width="20" id="users_checkbox"><input type="checkbox"  name="allbox" onclick="CheckAll('users_id[]','form');"></th>
                    <th width="12" sort="decrip">ID</th>
                    <th sort="decrip">Displayname</th>
                    <th sort="decrip">organization</th>
                    <th width="200" sort="decrip">email</th>
                    <th width="30" sort="decrip">Edit</th>
 
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php $index=0; foreach ($allUserInfo as $row): ?>
                  <tr id="<?php echo 'users'.$row->id;?>" <?php if($row->status==1) echo 'style="color:#CCC"'?>>
                    <td class="checkbox">
                      <input id="usersCheckBox<?php echo $row->id;?>" type="checkbox"  name="users_id[]" value="<?php echo $row->id;?>">
                    </td>
                    <td><?php echo $row->id;?></td>
                    <td><?php echo $row->displayname;?></td>
                    <td><?php echo $row->organization;?></td>
                    <td><?php echo $row->email;?></td>
                    <td><a href="info_update?id=<?php echo $row->id;?>">edit</a></td>
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
            <input type="hidden" name="type" value="users" />
            <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form, 0,'users','users')">
			<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form, 1,'users','users')">
            <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form,'users','users')"         	/>
            </form>
            <a class="return-link" href="<?php echo base_url('/cms');?>">
			Back
			</a>
		</div>
        
	</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
