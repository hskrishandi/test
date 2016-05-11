<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		Change Password
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'changePass.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'changePass.css'); ?>" media="all" />
    <?php endblock(); ?>

	<?php startblock('content'); ?>
		<!-- <div class="change_pass">
			<div class="forms">
			<h2 class="title">Change Password</h2>
			<h4>Please enter the required information to change password.</h4>
			<br />
			<form class="form">
			<table class="form_table" >
				<tr>
					<td class="title">E-mail:</td>
					<td><input type="text" name="email"  value=""/ class="email"><br />
					</td>
				</tr>
				<tr>
					<td class="title">Old Password:</td>
					<td><input type="password" name="old_pass"  value=""/ class="old_pass"><br />
					</td>
				</tr>
				<tr>
					<td class="title">&nbsp </td>
					<td>&nbsp</td>
				</tr>
				<tr>
					<td class="title">New Password:</td>
					<td><input type="password" name="new_pass"  value=""/ class="new_pass"><br />
					</td>
				</tr>
				<tr>
					<td class="title">Retype New Password:</td>
					<td><input type="password" name="new_pass_re" value="" class="new_pass_re"/>
					<h4 class="error">&nbsp </h4>
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

        <div style="clear:both;"></div> -->

        <div class="form change_pass">
            <h2>Change Password</h2>
            <h4>Please enter the required information to change password</h4>
            <form class="form-horizontal">
                <div id="form-group-email" class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input id="email" name="email" type="text" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div id="form-group-oldpass" class="form-group">
                    <label for="old_pass" class="col-sm-2 control-label">Old Password <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input id="old_pass" name="old_pass" type="password" class="form-control" placeholder="Old Password">
                    </div>
                </div>
                <div id="form-group-newpass" class="form-group">
                    <label for="new_pass" class="col-sm-2 control-label">New Password <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input id="new_pass" name="new_pass" type="password" class="form-control" placeholder="New Password">
                    </div>
                </div>
                <div id="form-group-newpassre" class="form-group">
                    <label for="new_pass_re" class="col-sm-2 control-label">Retype Password <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input id="new_pass_re" name="new_pass_re" type="password" class="form-control" placeholder="Retype New Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button id="submit" type="button" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>


	<?php endblock(); ?>

<?php end_extend(); ?>
