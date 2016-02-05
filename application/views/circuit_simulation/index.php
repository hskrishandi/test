
<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Circuit simulation
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		
    <?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
    

    
	<?php startblock('content'); ?>
    <div class="circuit_simulation">
    <div class="left_tool">
 	
    </div>
    <div class="circuit_board"></div>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 