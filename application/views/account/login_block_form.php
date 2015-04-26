			<div id="block-user-login">
			<form id="login" accept-charset="UTF-8" method="post" action="">
				<div class="form-item">
					<label for="edit-name">E-mail</label>
					<input type="text" class="form-text required" maxlength="60" size="15" value="" name="name" id="login-name" />
				</div>
				<div class="form-item">
					<label for="edit-password">Password</label>
					<input type="password" class="form-text required" maxlength="60" size="15" value="" name="password" id="login-password" />
				</div>
				<div class="item-list">
					<ul>
						<li style="color:#FFF"><a href="<?php echo base_url('account/create') ?>">Registration</a></li>
						<li><a href="<?php echo base_url('account/newPass') ?>">Request new password</a></li>
					</ul>
				</div>
                <input id="login-submit" class="form-submit" type="button" value="Log in" name="login" />
			</form>
			</div>