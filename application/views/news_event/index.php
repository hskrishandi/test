<!--edited by Grace-->
<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		Resources
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
		<!-- slideImage-->
		<div id="slideBox" class="clearfix">
			<img id="slideImage" class="slide" src="<?php echo resource_url('img', 'news/news.jpg'); ?>" />
			<p id="slideText">
				News and<br/>Events<br/>
			</p>
		</div>
		<!--SlideImage End-->
		<div id="resources">
			<p id="newsEventHL">News and Event Highlights</p>
			<div>
				<img class="highlightImage" src="<?php echo resource_url('img', 'home/NLimage1.jpg'); ?>" />
				<img class="highlightImage" src="<?php echo resource_url('img', 'home/NLimage2.jpg'); ?>" />
				<img  id="lastImage" src="<?php echo resource_url('img', 'home/NLimage3.jpg'); ?>" />
			</div>
			<div class="title">Latest News
				<a class="more" href="<?php echo base_url('news_event/news'); ?>">more</a>
				<div class="postSeparateLine">
					&#x7c;
				</div>
				<a class="post" href="<?php echo base_url('resources/post/news'); ?>">Post News</a>
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
			<div class="title">Upcoming Events
				<a class="more" href="<?php echo base_url('news_event/events'); ?>">more</a>
				<div class="postSeparateLine">
					&#x7c;
				</div>
				 <a class="post" href="<?php echo base_url('resources/post/events'); ?>">Post Event</a>
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
			<div class="title">Past Events
				<a class="more" href="<?php echo base_url('news_event/events'); ?>">more</a>
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
