<?php extend('layouts/layout.php'); ?>

	<?php startblock('meta'); ?>
	<?php
		$meta = array(
			array('name' => 'CACHE-CONTROL', 'content' => 'NO-CACHE', 'type' => 'equiv'),
			array('name' => 'PRAGMA', 'content' => 'NO-CACHE', 'type' => 'equiv'),
			array('name' => 'ROBOTS', 'content' => 'NONE'),
			array('name' => 'EXPIRES', 'content' => '-1', 'type' => 'equiv'),
		);
		echo meta($meta); ?>


	<?php endblock(); ?>

	<?php startblock('title'); ?>
		Registration Completed
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
			<h2 class="title">Registration Completed!</h2>
			<p>Thank your for registering. You will receive a E-mail for account activation. Please follow the instruction given in the E-mail to activate your account.</p>
			<p>You will be redirected to <?php echo imos_mark() ?> within <span id="sec"></span> seconds or click <a href="<?php echo base_url('/') ?>">here</a> immediately</p>
		<script>
		$(document).ready(function() {
			var i = 10;
			$('#sec').html(i);
			var sec1 = window.setInterval(
				function(){
					$('#sec').html(--i);

				}
				,1000);
			window.setTimeout ( function() {
				clearInterval(sec1);
				window.location = '<?php echo base_url('/') ?>'; }
				, 10000);

		});
		</script>
		</div>


	<?php endblock(); ?>

<?php end_extend(); ?>
