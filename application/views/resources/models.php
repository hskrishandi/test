<?php extend('layouts/layout.php'); ?>
	<?php startblock('title'); ?>
		Device Models
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
                <span class="page-subtitle-title">Device Models Reference</span>
				<a class="page-subtitle-more" href="<?php echo base_url('resources/post/models'); ?>">Post Reference</a>
			</div>
            <ul class="item-list">
				<?php foreach($models as $status => $entries): ?>
						<?php foreach($entries as $entry): ?>
						<li>
                            <a href="<?php echo $entry->website; ?>" class="entry"  target="_blank">
                                <h5>
                                    <?php
                                        echo $entry->name;
                                        if ($entry->author != NULL) {
                                            echo ', ' . $entry->author;
                                        }
                                    ?>
                                </h5>
                                <p>
                                    <?php echo strip_text($entry->website, MAX_LINK_LENGTH) ?>
                                </p>
                            </a>
						</li>
						<?php endforeach; ?>
                        <?php endforeach; ?>
					</ul>
					<br/>

			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
