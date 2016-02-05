<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		Tools
	<?php endblock(); ?>	
	
	<?php startblock('content'); ?>
		<div id="resources">
			<div id="resource-content">
				<?php foreach($tools as $title => $entries): ?>
					<h2 class="title"><?php echo $title; ?></h2>
					<ul class="item-list">
						<?php foreach($entries as $entry): ?>
						<li>
							<?php 
								echo '<a href="' . $entry->website . '" class="entry"  target="_blank" >' . $entry->name . '</a>';
								if ($entry->description != NULL) {
									echo ' - <span class="description">' . nl2br($entry->description) . '</span>';
								}
								if ($entry->website != NULL) {
									echo '<a href="' . $entry->website . '" class="link"  target="_blank" >' . strip_text($entry->website, MAX_LINK_LENGTH) . '</a>'; 
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
