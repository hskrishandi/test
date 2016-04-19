<?php extend('layouts/layout.php'); ?>
	<?php startblock('title'); ?>
		Organizations
	<?php endblock(); ?>

    <?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'resources.css'); ?>" media="all" />
    <?php endblock(); ?>

    <?php startblock('script'); ?>
        <?php echo get_extended_block(); ?>
        <script type="text/javascript" src="<?php echo resource_url('js', 'library/jquery.validate.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo resource_url('js', 'resources.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo resource_url('js', 'calendarDateInput.js'); ?>">
            /***********************************************
            * Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
            * Script featured on and available at http://www.dynamicdrive.com
            * Keep this notice intact for use.
            ***********************************************/
        </script>
    <?php endblock(); ?>

	<?php startblock('content'); ?>
		<div id="resources">
			<h2>Resources</h2>
				<div class="page-subtitle">
                    <span class="page-subtitle-title">Organizations</span>
					<a class="page-subtitle-more" href="<?php echo base_url('resources/post/groups'); ?>">Post Organization</a>
				</div>
				<ul class="item-list">
					<?php foreach($groups as $entry): ?>
					<li>
						<?php
							echo '<a href="' . $entry->website . '" class="entry"  target="_blank" >' . $entry->name . '</a>';
							if ($entry->website != NULL) {
								echo '<a href="' . $entry->website . '" class="link"  target="_blank" >' .  strip_text($entry->website, MAX_LINK_LENGTH) . '</a>';
							}
						?>


					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
