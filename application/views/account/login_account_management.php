<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		<?php echo $title ?>
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'login_account_management.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'auth_err.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
        <div class="form auth_err">
            <h2><?php echo $title ?></h2>
            <h4>Please login again to update account information.</h4>
            <form class="form-horizontal" action="" method="post" id="login" accept-charset="UTF-8">
                <div id="form-group-email" class="form-group">
                    <label for="login-name" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input id="login-name" name="name" type="text" class="form-control required" placeholder="Email">
                    </div>
                </div>
                <div id="form-group-password" class="form-group">
                    <label for="login-password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input id="login-password" name="password" type="password" class="form-control required" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" id="login-submit" class="btn btn-default">Login</button>
                    </div>
                </div>
            </form>
        </div>
	<?php endblock(); ?>

<?php end_extend(); ?>
