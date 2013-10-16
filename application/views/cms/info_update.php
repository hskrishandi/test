<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Account Management
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'info_update.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'info_update.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
		<div class="account_update">
			<div class="forms">
			<h2 class="title">Account Management</h2>
			<h4 class="title">Personal Information:</h4>
            
			<form action="info_update_submit" method="post" class="form_update" enctype="multipart/form-data">			<?php foreach ($usr_info as $row):?>
			<table class="form_table">
				<tbody><tr>
					<td class="title">LAST NAME*:</td>
					<td><input type="text" name="last_name" value="<?php echo $row->last_name;?>" ><br>
					<h4 class="error"></h4>
					</td>
					<td class="title">FIRST NAME*:</td>
					<td><input type="text" name="first_name"  value="<?php echo $row->first_name;?>"><br>
					<h4 class="error"></h4>
					</td>
				</tr>
				<tr>
					<td class="title">DISPLAY NAME*:</td>
					<td><input type="text" name="displayname" value="<?php echo $row->displayname;?>" ><br>
					<h4 class="error"></h4>
					</td>
					<td class="title">ADDRESS:</td>
					<td><input type="text" name="address" value="<?php echo $row->address;?>"></td>
				</tr>
				<tr>
					<td class="title">COMPANY*:</td>
					<td><input type="text" name="organization" class="" value="<?php echo $row->organization;?>">
					<h4 class="error"> </h4>
					</td>
					<td class="title">POSITION TITLE:</td>
					<td><input type="text" name="position" value="<?php echo $row->position;?>"></td>
				</tr>
				<tr>
					<td class="title">TEL:</td>
					<td><input type="text" name="tel" value="<?php echo $row->tel;?>"></td>
										<td class="title">FAX:</td>
					<td><input type="text" name="fax" value="<?php echo $row->fax;?>"></td>
				</tr>
          					<td colspan="4" class="title"><a style="margin-right:60px" class="submit" id="submit">Submit</a></td>
					</tr>
				</tbody></table>
               <?php endforeach;?>
               <input type="hidden" name="id" value="<?php echo $row->id;?>">
				<input type="hidden" name="send" value="1">
                
			</form>
            
			</div>
		</div>
		
		
	<?php endblock(); ?>

<?php end_extend(); ?> 
