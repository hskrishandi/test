Dear <?php echo $userinfo->displayname ?>,

<p>
The new password of your <span style="font-family: times,cursive;font-style: italic;display:inline;">i</span>-MOS account is given below:
</p>
<p>
E-mail: <?php echo $email ?><br />
Password: <?php echo $password ?>
</p>

<p>You can change your password via the following link:<br />

<?php
	$url = site_url('account/changePass');
?>
	<a herf="<?php echo $url?>"><?php echo $url ?></a>
</p>

Best Regards,<br />
<span style="font-family: times,cursive;font-style: italic;display:inline;">i</span>-MOS Team