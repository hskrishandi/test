<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Terms of Use
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
	<div id="static-page">
		<h2 class="title">Terms of Use</h2>
		<div>
			<p><?php echo imos_mark() ?> (Interactive Modeling and Online Simulation) is an academic based university project intended for the greater benefit of the modeling community who would like to access, evaluate or distribute models with a readily accessible platform. The <?php echo imos_mark() ?> platform is maintained and administered by a team of scholars and students at the Hong Kong University of Science and Technology. Once your submitted your registration and it is accepted by the <?php echo imos_mark() ?> site, it marks that you have read, accepted and will follow the restrictions imposed by the below stated terms of use.</p>
			<h3>Registration and Personal Information</h3>
			<p>Currently, all the services provided by the <?php echo imos_mark() ?> are free of charge, but some of them require prior registration.  During the registration process, one should provide complete and accurate personal data.  Using fake names or creating fake accounts are not acceptable.  Once suspicious cases are found, the <?php echo imos_mark() ?> team has the right to terminate the accounts involved without any prior notice.</p>
			<h3>Third Party Usage</h3>
			<p>The <?php echo imos_mark() ?> denounces the use of your ID and password for the third party other than the registered user.  One should not share his/her account and password with others.  Users are responsible for their own confidentiality.  Any theft of data due to password sharing or hacking will be the responsibility of the user himself/herself.  The <?php echo imos_mark() ?> will not be responsible for results of such acts.</p>
			<h3>Conduct and Language</h3>
			<p>The content of the <?php echo imos_mark() ?> is monitored on a daily basis by the administrative team.  We enforce the practice of politeness and chivalry when interacting with other people.  Uses of obscene, threatening and defamatory remarks will lead to immediate termination of accounts.  Any acts that lead to violation of law such as copyright issues will also lead to immediate termination of account.  We expect the users to use the resources provided in a responsible and careful manner.  The server is a shared resource.   After a user completed his/her task and saved his/her data, he/she should log off so that other users can gain better access to the shared resources.</p>
			<h3>Right of Termination</h3>
			<p><?php echo imos_mark() ?> team retains the right to terminate any account based on improper conducts violating any Terms of Use. Termination would be in effect immediately without notice and the user will no longer be able to retain his/her user privilege.</p>
			<h3>Non-Commercial Use</h3>
			<p><?php echo imos_mark() ?> is an academic based non-profit platform service.  Posting of advertisements of commercial activity on the site or in the discussion group is not allowed.  Exception maybe granted for activities of interest to the majority of the <?php echo imos_mark() ?> community, but prior approval by the <?php echo imos_mark() ?> team is required.</p>
			<h3>Academic Use</h3>
			<p>If a user utilized the <?php echo imos_mark() ?> platform and came up with results that lead to academic publication, the user is expected to explicitly cite the <?php echo imos_mark() ?> website and corresponding documents listed by <?php echo imos_mark() ?>.</p>
			<h3>Content Upload</h3>
			<p>Users may upload information or post messages with the framework setup by <?php echo imos_mark() ?>.  A specific group of users can applied to become developer status.  Developers may upload their models to the <?php echo imos_mark() ?> platform.  The <?php echo imos_mark() ?> team reserves the right to reject any submission, either postings or models, without specific reasons.  For model upload, it is the responsibility of the developers to ensure the uploaded models do not include any virus or corrupt code that can render improper server functions. Performing such acts may lead to termination of account.  In some serious cases, it may lead to legal actions.  It is also the responsibility for model developer to ensure the uploaded model conform to the specification as spelt out by the <?php echo imos_mark() ?> team.  Models do not conform to the specifications may be rejected. </p>
			<h3>Copyright Infringement</h3>
			<p>Users who uploaded material to the platform are responsible for all the copyright issues.  We assume the material uploaded to be original.  In the case of citing other sources, the author is responsible for its accuracy and completeness.  <?php echo imos_mark() ?> will pass all the copyright responsible for all uploaded material to the users uploading them. </p>
			<h3>Dispute</h3>
			<p>In case of any dispute with <?php echo imos_mark() ?> over the resources or content, the decision made by <?php echo imos_mark() ?> will be considered final and unchallengeable.</p>
			<h3>Right of Modification/Update</h3>
			<p>The <?php echo imos_mark() ?> team has the sole right to modify and update the Terms of Use. The modifications will be enforced immediately once announced.  Further usage of the platform will be considered the user’s acceptance of the changes.  So please visit this page frequently to keep up with the modifications.</p>
		</div>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 