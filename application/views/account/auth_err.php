<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		Unauthoried Access
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'login_page.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'auth_err.css'); ?>" media="all" />
    <?php endblock(); ?>

	<?php startblock('content'); ?>
		<?php if($logined === false): ?>
			<div class="auth_err">
				<h2 class="title">Authentication Required</h2>
				<p>This page requires user authentication. Please login to access the service.<br />If you are not yet a registered <?php echo imos_mark() ?> user, you may register for free by clicking the Registration button on the top right corner of the page.</p>

                <form class="form-horizontal" method="post" action="<?php echo base_url('account/loginForm') ?>">
                    <div class="form-group<?php echo $error == 'noaccpass' ? ' has-error' : '' ?>">
                        <label for="loginEmail" class="col-sm-2 control-label">Email<sup>*</sup></label>
                        <div class="col-sm-10">
                            <input name="email" type="email" class="form-control" id="loginEmail" placeholder="Email" value="<?php echo isset($email) ? $email : '' ?>">
                        </div>
                    </div>
                    <div class="form-group<?php echo $error == 'noaccpass' ? ' has-error' : '' ?>">
                        <label for="loginPassword" class="col-sm-2 control-label">Password<sup>*</sup></label>
                        <div class="col-sm-10">
                            <input name="pwd" type="password" class="form-control" id="loginPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <a href="<?php echo base_url('account/create') ?>">Registration</a>
                            <a class="col-sm-offset-1" href="<?php echo base_url('account/newPass') ?>">Request new password</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Sign in</button>
                        </div>
                    </div>
                </form>

                <?php if($error == 'noactive'): ?>
                    <script type="text/javascript">
                        alert(LogInAccInActMsg);
                    </script>
                <?php endif; ?>

				<!-- <div class="forms">
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
				</div> -->
			</div>
		<?php else: ?>
			<div class="auth_err">
				<h2 class="title">Unauthoried Access</h2>
				<h4>The page is unauthorized by the account.</h4>
				<h4>You will be redirected to <?php echo imos_mark() ?> within <span id="sec"></span> seconds or click <a href="<?php echo base_url('/') ?>">here</a> immediately</h4>

			</div>
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
		<?php endif; ?>
	<?php endblock(); ?>

<?php end_extend(); ?>
