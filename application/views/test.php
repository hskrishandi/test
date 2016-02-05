<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Test
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'contacts.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
		
		<div class="test">
			<div class="fivestar" id="a"/></div>
			<div class="fivestar" id="b"/></div>
		</div>
		
		
	<?php endblock(); ?>

<?php end_extend(); ?> 
