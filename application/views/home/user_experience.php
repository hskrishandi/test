<?php extend('layouts/layout.php'); ?>
	<?php startblock('title'); ?> User Experience
    <?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'home.css'); ?>" media="all" />
    <?php endblock(); ?>

	<?php startblock('content'); ?>
		<div class="experience-page">
    		<h2>User Experience</h2>
    		<ul class="item-list">
    			<?php foreach($user_experience as $entry): ?>
    			<li>
    				<blockquote>
    					<?php echo $entry->comment; ?>
    				</blockquote>
    				<span class="user-detail">
    					<?php echo '&ndash; ' . $entry->first_name . ' ' . $entry->last_name . ', ' . $entry->organization . ', ' . date('Y', strtotime($entry->date)); ?>
    				</span>
                    <div class="clearFloat"></div>
    			</li>
    			<?php endforeach; ?>
    		</ul>
            <div class="return-link">
                <a href="<?php echo base_url(); ?>">Back</a>
            </div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
