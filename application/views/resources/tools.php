<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		Tools
	<?php endblock(); ?>	
	
	<?php startblock('content'); ?>
		<div id="resources">
			<p id="pageTitle">Resources</p>
				
			<div class='title'>Tools
				<div class="postSeparateLine">
				</div>
				<a class="post" href="<?php echo base_url('resources/post/tools'); ?>">Post Tools</a>
			</div>
			
			<?php foreach($tools as $title => $entries): ?>
			<h2 class="sub_title"><?php echo $title; ?></h2>
					<ul class="item-list">

						<?php foreach($entries as $entry): ?>
						<li>
							<?php 
								echo '<span class="name">' . $entry->name. '</span>';
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
					<hr>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
