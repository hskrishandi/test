<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		Organizations
	<?php endblock(); ?>	
	
	<?php startblock('side_menu'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
		<div id="resources">		
			<p class="page-title">Resources</p>
				<div class="page-subtitle">Organizations
					<div class="postSeparateLine">
					</div>
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
