<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Privacy Policy
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
	<div id="static-page">
		<h2 class="title">Privacy Policy</h2>
		<div>
			<p>We, the <?php echo imos_mark() ?> team, as responsible members of the scientific community uphold your privacy and try our level best to maintain highest standards possible.  All information collected will solely be used to control access to the <?php echo imos_mark() ?> platform.  No information will be released to a third party without consent of the corresponding users.</p>
			<h3>Registered Users</h3>
			<p>We required users to registered in order to make sure all activities on the <?php echo imos_mark() ?> site is authentic.  Only the part of user profile you have agreed to be released to the public will be posted when you upload information.  No other information is shared with any third party. The release of information is totally based on choice of the users when submitting the profile.</p>
			<h3>Developers</h3>
			<p>The developers are special class of users who have the privilege to upload models to the site.  Extra information as agreed by the developers will be released to the public for direct communication between users and the model developers for questions concerning the model.  The model information including source code will be kept strictly confidential and will not be released to the public or specific users unless otherwise agreed by the developers. </p>
			<h3>Mode of Communication</h3>
			<p>The <?php echo imos_mark() ?> platform allows direct communication between users to <?php echo imos_mark() ?> administrators and users-to-users using different tools made available including discussion group, e-mail, etc.  Most of the user-to-user communications between on the platform are done anonymously with a self-selected display name.  Sending request to the <?php echo imos_mark() ?> team require real communication information for authentication purpose.</p>
			<h3>Update Policy</h3>
			<p>The <?php echo imos_mark() ?> team has the sole right to modify and update the Privacy. The modifications will be enforced immediately once announced.  Further usage of the platform will be considered the user’s acceptance of the changes.  So please visit this page frequently to keep up with the modifications.</p>
		</div>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 
