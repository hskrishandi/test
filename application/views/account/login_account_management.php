<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		<?php echo $title ?>
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'login_account_management.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'auth_err.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
			<div class="auth_err">
				<h2 class="title"><?php echo $title ?></h2>
				<h4>Please login again to update account information.</h4>
				
				<div class="forms">
				<div id="user-login">
				<form id="login" accept-charset="UTF-8" method="post" action="">
					<div class="item">
						<div class="title">E-mail*: </div>
						<div><input type="text" class="form-text required" maxlength="60" size="15" value="" name="name" id="login-name" /></div>
					</div>
					<div class="item">
						<div class="title">Password*: </div>
						<div><input type="password" class="form-text required" maxlength="60" size="15" value="" name="password" id="login-password" /><div id="err">&nbsp </div> </div>
					</div>
					<div class="page-function-block">
						<div class="page-item-list">
							<ul>
								<li><a href="<?php echo base_url('account/create') ?>">Registration</a></li>
								<li><a href="<?php echo base_url('account/newPass') ?>">Request new password</a></li>
							</ul>
							
						</div>
						<div class="page-submit-block"><a class="submit" id="login-submit">Log in</a></div>
					</div>
				</form>
				</div>
				</div>
			</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 
