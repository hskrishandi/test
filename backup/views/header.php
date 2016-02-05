<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
"http://www.w3.org/TR/html4/frameset.dtd">

<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title ?> | i-MOS</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url?>css/style.css" />
</head>
<body>
	<div id="page-wrapper">
		<div id="page">
				<div id="header">
					<div id="logo">
						<a href="" title="" rel="home" id="logo">
							<img id="site_logo" src="<?php echo $base_url?>img/logo.png" alt="" />
						</a>
					</div>
					<div id="block-user-login">
						<form id="login" accept-charset="UTF-8" method="post">
							<div class="form-item">
								<label for="edit-name">Username</label>
								<input type="text" class="form-text required" maxlength="60" size="15" value="" name="name" id="edit-name">
							</div>
							<div class="form-item">
								<label for="edit-name">Password</label>
								<input type="text" class="form-text required" maxlength="60" size="15" value="" name="name" id="edit-name">
							</div>
							<div class="item-list">
								<ul>
									<li>Create new account</li>
									<li>Request new password</li>
								</ul>
							</div>
							<input id="edit-submit" class="form-submit" type="submit" value="Log in" name="op">
						</form>
					</div>
				</div>
				<div id="header_bar_margin">
					<div id="header_bar"></div>
				</div>

				
