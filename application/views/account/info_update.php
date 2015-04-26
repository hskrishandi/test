<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Account Update
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'info_update.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/ajaxfileupload.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'info_update.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
		<div class="account_update">
			<div class="forms">
			<h2 class="title">Account Update</h2>
			<h4><?php if(isset($msg)) echo $msg ?></h4>
			<h4 class="title">Personal Information:</h4>
			<form action="<?php echo base_url('account/infoUpdate')?>" method="post" class="form_update" enctype='multipart/form-data'>
			<table class="form_table" >
				<tr>
					<td class="title">LAST NAME*:</td>
					<td><input type="text" name="last_name" class="<?php if (form_error('last_name') !=="") echo 'err' ?>" value="<?php echo set_value('last_name', $userinfo->last_name); ?>"/><br />
					<h4 class="error"><?php echo form_error('last_name');?></h4>
					</td>
					<td class="title">FIRST NAME*:</td>
					<td><input type="text" name="first_name" class="<?php if (form_error('first_name') !=="") echo 'err' ?>" value="<?php echo set_value('first_name', $userinfo->first_name); ?>"/><br />
					<h4 class="error"><?php echo form_error('first_name');?></h4>
					</td>
				</tr>
				<tr>

				</tr>
				<tr>
					<td class="title">DISPLAY NAME*:</td>
					<td><input type="text" name="displayname" class="<?php if (form_error('displayname') !=="") echo 'err' ?>" value="<?php echo set_value('displayname',$userinfo->displayname); ?>"/><br />
					<h4 class="error"><?php echo form_error('displayname');?></h4>
					</td>
					<td class="title">ADDRESS:</td>
					<td><input type="text" name="address"  value="<?php echo set_value('address', $userinfo->address); ?>"/></td>
				</tr>
				<tr>
					<td class="title">COMPANY*:</td>
					<td><input type="text" name="organization" class="<?php if (form_error('organization') !=="") echo 'err' ?>"  value="<?php echo set_value('organization', $userinfo->organization); ?>"/>
					<h4 class="error"><?php echo form_error('organization');?> </h4>
					</td>
					<td class="title">POSITION TITLE:</td>
					<td><input type="text" name="position"  value="<?php echo set_value('position', $userinfo->position); ?>"/></td>
				</tr>
				<tr>
					<td class="title">TEL:</td>
					<td><input type="text" name="tel"  value="<?php echo set_value('tel', $userinfo->tel); ?>"/></td>
										<td class="title">FAX:</td>
					<td><input type="text" name="fax"  value="<?php echo set_value('fax', $userinfo->fax); ?>"/></td>
				</tr>
				</table>
				<input type="hidden" name="submited" value="1"/>
				<br />
				<h4 class="title">User Picture:</h4>
				<div class="user_pic">
					<div class="pic">
						
						<?php
							if ($userinfo->photo_path !== ""){
						?>
						<img src="<?php echo resource_url('user_image', $userinfo->photo_path.'_n'.$userinfo->photo_ext);?>" />
						<?php
						 }else{
						 ?>
						<div class="no_pic"><center>No Picture Submitted</center></div>
						<?php
							}
						?>
					</div>
					<div class="pic_sel">
							<div>Please select the user picture and click Upload:</div>
							<div class="pic_form">
							
								<input type='file' name="photo" value="<?php if(isset($photo_value)) echo $photo_value?>"/>
								<a class="submit" id="submit">Upload</a>
							</div>
							<h4 class="error"><?php if (isset($photo_err)) echo $photo_err;?></h4>
					</div>
				</div>
				<div class="verification">
					<div  class="div_inline float_right">
						<div class="form_submit">
						<a class="submit" id="submit">Submit</a>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
		
		
	<?php endblock(); ?>

<?php end_extend(); ?> 
