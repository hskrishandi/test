<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		Request New Password
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'newPass.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>


	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'newPass.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
		<div class="newPass">
			<div class="forms">
			<h2 class="title">Request New Password</h2>
			<h4>Please enter your E-mail address to receive a new password.</h4>
			<br />
			<form class="form">
			<table class="form_table" >
				<tr>
					<td class="title">E-mail:</td>
					<td><input type="text" name="email"  value=""/ class="email"><br />
					</td>
				</tr>
				<tr >
					<td></td>
					<td class="submit"><a class="submit" id="submit">Submit</a></td>
				</tr>
				</table>
			</from>
			</div>
		</div>


	<?php endblock(); ?>

<?php end_extend(); ?>
