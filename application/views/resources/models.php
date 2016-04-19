<?php extend('resources/layout.php'); ?>
	<?php startblock('title'); ?>
		Device Models
	<?php endblock(); ?>

	<?php startblock('side_menu'); ?>
	<?php endblock(); ?>

	<?php startblock('content'); ?>
		<div id="resources">
			<p class="page-title">Resources</p>
            <div class="page-subtitle">Device Models Reference
				<div class="postSeparateLine">
				</div>
				<a class="page-subtitle-more" href="<?php echo base_url('resources/post/models'); ?>">Post Reference</a>
			</div>
            <ul class="item-list">
				<?php foreach($models as $status => $entries): ?>


						<?php foreach($entries as $entry): ?>
						<li>
							<?php
								echo '<a href="' . $entry->website . '" class="entry"  target="_blank" >' . $entry->name;
								if ($entry->author != NULL) {
									echo ', ' . $entry->author;
								}
								echo '</a>';
								if ($entry->website != NULL) {
									echo '<a href="' . $entry->website . '" class="link"  target="_blank" >' . strip_text($entry->website, MAX_LINK_LENGTH) . '</a>';
								}
							?>

						</li>
						<?php endforeach; ?>
                        <?php endforeach; ?>
					</ul>
					<br/>

			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
