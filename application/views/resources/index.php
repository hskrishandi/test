<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		Resources
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
		<div id="resources">
			<p id="pageTitle">Resources</p>
			
			<div class='title'>Device Models Reference
				<a class="more" href="<?php echo base_url('resources/models'); ?>">more</a>
				<div class="postSeparateLine">
					&#x7c;
				</div>
				<a class="post" href="<?php echo base_url('resources/post/models'); ?>">Post Reference</a>
			</div>
			<ul class="item-list">
				<?php foreach($models as $entry): ?>
					<li>
						<?php 
							$content = $entry->name;
							if ($entry->author != NULL) {
								$content .= ', ' . $entry->author;
							}
							if ($entry->website != NULL) {
								echo '<a href="' . $entry->website . '" class="link"  target="_blank">' . $content . '</a>'; 
							} else {
								echo $content;
							}
						?>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class='title'>Tools
			<a class="more" href="<?php echo base_url('resources/tools'); ?>">more</a>
			<div class="postSeparateLine">
				&#x7c;
			</div>
			<a class="post" href="<?php echo base_url('resources/post/tools'); ?>">Post Tools</a>
			</div>
			

			<?php foreach ($this->config->item('tool_type') as $type => $title) :?>
			<h2 class="sub_title"><?php echo $title; ?></h2>
			<ul class="item-list">
			<?php if($type == 'device_sim'){ ?>
				<?php foreach($tools1 as $entry): ?>
					<li>
						<?php
								echo '<a href="' . $entry->website . '" class="entry"  target="_blank" >' . $entry->name . '</a>';
								if ($entry->description != NULL) {
									echo ' - <span class="description">' . nl2br($entry->description) . '</span>';
								}
						?>
					</li>
				<?php endforeach; ?>
			<?php } elseif($type == 'circuit_sim') {?>
				<?php foreach($tools2 as $entry): ?>
					<li>
						<?php
								echo '<a href="' . $entry->website . '" class="entry"  target="_blank" >' . $entry->name . '</a>';
								if ($entry->description != NULL) {
									echo ' - <span class="description">' . nl2br($entry->description) . '</span>';
								}
						?>
					</li>
				<?php endforeach; ?>
			<?php } elseif($type == 'param_extract') {?>
				<?php foreach($tools3 as $entry): ?>
					<li>
						<?php
								echo '<a href="' . $entry->website . '" class="entry"  target="_blank" >' . $entry->name . '</a>';
								if ($entry->description != NULL) {
									echo ' - <span class="description">' . nl2br($entry->description) . '</span>';
								}
						?>
					</li>
				<?php endforeach; ?>
			<?php }else { ?>
				<?php foreach($tools4 as $entry): ?>
					<li>
						<?php
								echo '<a href="' . $entry->website . '" class="entry"  target="_blank" >' . $entry->name . '</a>';
								if ($entry->description != NULL) {
									echo ' - <span class="description">' . nl2br($entry->description) . '</span>';
								}
						?>
					</li>
				<?php endforeach; ?>
			<?php } ?>
			</ul>
			<br/>
			<hr>
			<?php endforeach; ?>

			
			<div class="title">Organizations
				<a class="more" href="<?php echo base_url('resources/groups'); ?>">more</a>
				<div class="postSeparateLine">
					&#x7c;
				</div>
				<a class="post" href="<?php echo base_url('resources/post/groups'); ?>">Post Organization</a>
			</div>
			<ul class="item-list">
				<?php foreach($groups as $entry): ?>
					<li>
						<?php 
							if ($entry->website != NULL) {
								echo '<a href="' . $entry->website . '" class="link"  target="_blank">' . $entry->name . '</a>'; 
							} else {
								echo $entry->name;
							}
						?>
					</li>
				<?php endforeach; ?>
			</ul>

		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
