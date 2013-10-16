<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Developer
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'developer.css'); ?>" media="all" />
    <?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
	<div id="developer">
		<h2 class="title">Uploading Models</h2>
		<br/>
		<p>
			We are in the process to develop an automatic authoring tool for model developers to upload their models to the i-MOS platform.  However, such tool is not yet available.  In the mean time, if you are interested to release your model through the i-MOS platform, please contact <a href="mailto:model@i-mos.org">model@i-mos.org</a> by e-mailing the following information to us:
		</p>		
		<ol id="model_info">
			<li>1) A short description of the model including model name, authors, and organization</li>
			<li>2) A file containing the Verilog-A code of the model</li>
			<li>3) A list of parameters and their default values</li>
			<li>4) Quantities can be output by the model</li>
		</ol>		
		<p>
			Once the model is verified to be complete, we shall include that in our simulation engine.
		</p>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 