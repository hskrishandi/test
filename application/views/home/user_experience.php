<?php
	$title = 'User Experience';
?>

<?php extend('layout.php'); ?>	
	<?php startblock('title'); ?>
		<?php echo $title; ?>
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
		<div id="experience-page">
		<h2 class="title"><?php echo $title; ?></h2>		
		<ul class="item-list">
			<?php foreach($user_experience as $entry): ?>
			<li>
				<blockquote>
					<?php echo $entry->comment; ?>
				</blockquote>
				<span class="user-detail">
					<?php echo '&ndash; ' . $entry->first_name . ' ' . $entry->last_name . ', ' . $entry->organization . ', ' . date('Y', strtotime($entry->date)); ?>
				</span>
			</li>
			<?php endforeach; ?>
		</ul>
		<a class="return-link" href="<?php echo base_url('home'); ?>">
			Back
		</a>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
