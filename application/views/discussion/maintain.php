
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		Discussion
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
    <?php endblock(); ?>
    
            	<?php startblock('script'); ?>
        <?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>
    <?php endblock(); ?>

        
        <?php startblock('content'); ?>



	<?php endblock(); ?>

<?php end_extend(); ?> 