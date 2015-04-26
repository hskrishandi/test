<?php
	$all_events = array("Upcoming Events" => $upcoming_events, "Past Events" => $past_events);
?>

<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		Events
	<?php endblock(); ?>	
	
	<?php startblock('content'); ?>
		<div id="resources">
			<div id="resource-content">
				<?php foreach($all_events as $title => $events): ?>
					<h2 class="title"><?php echo $title; ?></h2>
					<ul class="item-list">
						<?php foreach($events as $entry): ?>
						<li>
                        
                        	<span class="date">[  <?php echo date_range(strtotime($entry->start_date), strtotime($entry->end_date)) ;?> ]</span>
							<?php 
								echo '<a href="' . $entry->website . '" class="entry"  target="_blank" >' . $entry->name . ', '.$entry->full_name.'</a><br>';
								echo $entry->location ;
								if ($entry->website != NULL) {
									echo '<a href="' . $entry->website . '" class="link"  target="_blank" >' .  strip_text($entry->website, MAX_LINK_LENGTH) . '</a>'; 
								}
							?>

						</li>
						<?php endforeach; ?>
					</ul>
					<br/>
				<?php endforeach; ?>
                
			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
