<?php extend('layouts/layout.php'); ?>

<?php startblock('title'); ?>
    Events
<?php endblock(); ?>

<?php startblock('css'); ?>
    <?php echo get_extended_block(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'news_event.css'); ?>" media="all" />
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

<?php startblock('banner'); ?>
    <img src="<?php echo resource_url('img', 'news/news.png'); ?>" />
<?php endblock(); ?>

<?php startblock('content'); ?>
<div id="resources">
    <div class="page-subtitle">
        <span class="page-subtitle-title">Upcoming Events</span>
        <a class="page-subtitle-more" href="<?php echo base_url('news_event'); ?>" onclick="history.go(-1); return false;">Back to News and Event</a>
    </div>
	<ul class="item-list">
		<?php foreach($upcoming_events as $entry): ?>
		<li>
			<?php
			echo '<div class="entryTitle">'.$entry->full_name.'</div>';
			echo '<span class="date">'. date_range(strtotime($entry->start_date), strtotime($entry->end_date)).' &#x7c; '.$entry->location.'</span>';
			if ($entry->website != NULL) {
				echo '<a href="' . $entry->website . '" class="link"  target="_blank" >' .  strip_text($entry->website, MAX_LINK_LENGTH) . '</a>';
			}
			?>

		</li>
	<?php endforeach; ?>
	</ul>
    <div class="page-subtitle">
        <span class="page-subtitle-title">Past Events</span>
    </div>
	<ul class="item-list">
		<?php foreach($past_events as $entry): ?>
		<li>
			<?php
			echo '<div class="entryTitle">'.$entry->full_name.'</div>';
			echo '<span class="date">'. date_range(strtotime($entry->start_date), strtotime($entry->end_date)).' &#x7c; '.$entry->location.'</span>';
			if ($entry->website != NULL) {
				echo '<a href="' . $entry->website . '" class="link"  target="_blank" >' .  strip_text($entry->website, MAX_LINK_LENGTH) . '</a>';
			}
			?>

		</li>
	<?php endforeach; ?>
	</ul>


</div>
<?php endblock(); ?>

<?php end_extend(); ?>
