<!--edited by Grace-->
<?php extend('layouts/layout.php'); ?>	
	<?php startblock('title'); ?>
		News And Event
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
	<img id="slideImage" class="slide" src="<?php echo resource_url('img', 'news/news.png'); ?>" />
	<?php endblock(); ?>
	<?php startblock('content'); ?>
		<div id="resources">
			<p id="newsEventHL">News and Event Highlights</p>
			<div class="highlightImageContainer">
				<img class="highlightImage" src="<?php echo resource_url('img', 'home/NLimage1.jpg'); ?>" />
				<img class="highlightImage" src="<?php echo resource_url('img', 'home/NLimage2.jpg'); ?>" />
				<img  id="lastImage" src="<?php echo resource_url('img', 'home/NLimage3.jpg'); ?>" />
			</div>
			<div class="page-subtitle">Latest News
				<a href="<?php echo base_url('news_event/news'); ?>">more</a>
				<div class="postSeparateLine">
					&#x7c;
				</div>
				<a href="<?php echo base_url('resources/post/news'); ?>">Post News</a>
			</div>
			<ul class="item-list">
				<?php foreach($news as $entry): ?>
					<li>
						<?php 
							echo '<a href="' . base_url('news_event/news/' . $entry->id) . '" class="entryTitle"  >' . $entry->title . '</a>';
						?>
						<span class="date"> <?php echo date('d M Y', $entry->post_date); ?></span>
						<div class="newsPreview">
							
						</div>
					</li>
				<?php endforeach;?>
			</ul>
			<div class="page-subtitle">Upcoming Events
				<a href="<?php echo base_url('news_event/events'); ?>">more</a>
				<div class="postSeparateLine">
					&#x7c;
				</div>
				 <a href="<?php echo base_url('resources/post/events'); ?>">Post Event</a>
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
			<div class="page-subtitle">Past Events
				<a href="<?php echo base_url('news_event/events'); ?>">more</a>
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
