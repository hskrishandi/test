<?php
	$title = 'i-MOS Activities';
?>

<?php extend('layout.php'); ?>	
	<?php startblock('title'); ?>
		<?php 
			echo $title;
		?>
	<?php endblock(); ?>	
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'home.css'); ?>" media="all" />
    <?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
		<div id="activity-page">
			<h2 class="title"><?php echo imos_mark().' Activities'; ?></h2>
			<ul class="item-list">
				<?php foreach($activities as $entry): ?>
				<li>
					<span class="date">[ <?php echo date('d M Y', $entry->date); ?> ]</span>					
					<?php echo $entry->content; ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<a class="return-link" href="<?php echo base_url('home'); ?>">
				Back
			</a>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
