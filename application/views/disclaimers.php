<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Disclaimers
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
	<div id="static-page">
		<h2 class="title">Disclaimers</h2>
		<div>
			<p>WHILE WE ATTEMPT TO PROVIDE SERVICE THE TO COMMUNITY WITH UTTERMOST PROFESSIONALISM, WE ARE NOT RESPONSIBLE FOR ANY POTENTIAL DAMAGES OR LOSSES CAUSED UNEXPECTED EVENTS INCLUDING, BUT NOT LIMITED BY HARDWARE FAILURE, OVERLOADING OF RESOURCES, SOFTWARE BUGS OR ATTACK BY HACKERS. USERS USING OUR SYSTEMS HAVE TO BEAR THE RISK THEMSELVES WHEN USING OUR SERVICES.</p>
            <p>WE DECLARED THAT THE INFORMATION PROVIDED BY THE <?php echo imos_mark() ?> TEAM ON THIS SITE ARE TRUE TO OUR KNOWLEDGE.  USERS WHO PROVIDE INFORMATION TO THE <?php echo imos_mark() ?> SITE DIRECTLY ARE RESPONSIBLE FOR THE INFORMATION THEY PROVIDED.   WHILE THE <?php echo imos_mark() ?> TEAM WILL PROVIDE MODERATION FOR SUCH INFORMATION, WE ARE NOT RESPONSIBLE FOR ACCURACY OF THE INFORMATION INCLUDING COPYRIGHT ISSUES.  ANY INFORMATION THAT YOU THINK MAY BE DISTURBING OR INACCURATE, YOU MAY REPORT IT TO THE <?php echo imos_mark() ?> TEAM AND WE WILL TRY OUR BEST TO RECTIFY IT.</p>
		</div>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 
