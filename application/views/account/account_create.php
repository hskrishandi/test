<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Registration
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'account_create.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'account_create.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
		<div class="account_create">
			<div class="forms">
			<h2 class="title">Registration</h2>
			<h4><?php if(isset($msg)) echo $msg ?></h4>
			<h4 class="title">Personal Information:</h4>
			<form action="<?php echo base_url('account/create_submit')?>" method="post" class="form">
			<table class="form_table" >
				<tr>
					<td class="title">LAST NAME*:</td>
					<td><input type="text" name="last_name" class="<?php if (form_error('last_name') !=="") echo 'err' ?>" value="<?php echo set_value('last_name'); ?>"/><br />
					<h4 class="error"><?php echo form_error('last_name');?></h4>
					</td>
					<td class="title">FIRST NAME*:</td>
					<td><input type="text" name="first_name" class="<?php if (form_error('first_name') !=="") echo 'err' ?>" value="<?php echo set_value('first_name'); ?>"/><br />
					<h4 class="error"><?php echo form_error('first_name');?></h4>
					</td>
				</tr>
				<tr>

				</tr>
				<tr>
					<td class="title">DISPLAY NAME*:</td>
					<td><input type="text" name="displayname" class="<?php if (form_error('displayname') !=="") echo 'err' ?>" value="<?php echo set_value('displayname'); ?>"/><br />
					<h4 class="error"><?php echo form_error('displayname');?></h4>
					</td>
					<td class="title">ADDRESS:</td>
					<td><input type="text" name="address"  value="<?php echo set_value('address'); ?>"/></td>
				</tr>
				<tr>
					<td class="title">COMPANY*:</td>
					<td><input type="text" name="organization" class="<?php if (form_error('organization') !=="") echo 'err' ?>"  value="<?php echo set_value('organization'); ?>"/>
					<h4 class="error"><?php echo form_error('organization');?> </h4>
					</td>
					<td class="title">POSITION TITLE:</td>
					<td><input type="text" name="position"  value="<?php echo set_value('position'); ?>"/></td>
				</tr>
				<tr>
					<td class="title">TEL:</td>
					<td><input type="text" name="tel"  value="<?php echo set_value('tel'); ?>"/></td>
										<td class="title">FAX:</td>
					<td><input type="text" name="fax"  value="<?php echo set_value('fax'); ?>"/></td>
				</tr>
				</table>
			<br />
			<h4 class="title">Account Information:</h4>
			<div>
			<table class="form_table" >
				<tr>
					<td class="title">E-MAIL ADDRESS*:</td>
					<td><input type="input" name="email" class="<?php if (form_error('email') !=="") echo 'err' ?>"  value="<?php echo set_value('email'); ?>"/>
					<h4 class="error"><?php echo form_error('email');?> </h4>
				</tr>
				<tr>
					<td colspan="2">The E-MAIL ADDRESS is for log-in use. Please make sure the E-MAIL ADDRESS is correct.</td>
				</tr>
				<tr>
					<td class="title">PASSWORD*:</td>
					<td><input type="password" name="password" class="<?php if (form_error('password') !=="") echo 'err' ?>"  value="<?php echo set_value('password'); ?>"/>
					<h4 class="error"><?php echo form_error('password');?> </h4>
				</tr>
				<tr>
					<td class="title">PASSWORD RE-TYPE:</td>
					<td><input type="password" name="retypepassword" class="<?php if (form_error('retypepassword') !=="") echo 'err' ?>"  value="<?php echo set_value('retypepassword'); ?>"/>
					<h4 class="error"><?php echo form_error('retypepassword');?> </h4>
				</tr>
				<tr>
					<td colspan="2">
					<div class="div_inline">
					<h4 class="title" style="font-weight:900;">Verification code:</h4>
	     			 <script type="text/javascript">
					 var RecaptchaOptions = {
						lang : 'fr',
						theme : 'white'
					 };
					 </script>
					<?php
						$publickey = "6LfKDtASAAAAADfqnqFzbxPZQRzzdA0wggu8GhkN"; // you got this from the signup page
						echo recaptcha_get_html($publickey);
					?>
					<h4 class="error"><?php if (isset($err['verification'])) echo $err['verification'] ?></h4>
					</div>
				</td>
				</tr>
			</table>
			</div>
					<div style="width:600px;">
						<div class="form_submit">
						<a class="submit">Submit</a>
						</div>
					</div>
			</from>
			</div>
		</div>
		
		
	<?php endblock(); ?>

<?php end_extend(); ?> 
