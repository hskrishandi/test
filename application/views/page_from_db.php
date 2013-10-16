<?php extend('layout.php'); ?>

	<?php startblock('content'); ?>
		<h2 class="title"><?php echo $title; ?></h2>
		<div>
			<?php echo $content; ?>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 