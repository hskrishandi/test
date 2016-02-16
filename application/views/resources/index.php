<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		Resources
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
		<div id="resources">
			<div class="row">
				<div class="block">
					<h3 class='title'>News</h3>
                    <a class="more" href="<?php echo base_url('resources/news'); ?>">more</a>
					<a class="post" href="<?php echo base_url('resources/post/news'); ?>">post</a>
					<ul class="item-list">
						<?php foreach($news as $entry): ?>
							<li>
                            	<span class="date">[ <?php echo date('d M Y', $entry->post_date); ?> ]</span>
								<?php 
									echo '<a href="' . base_url('resources/news/' . $entry->id) . '" class="link">' . $entry->title . '</a>'; 
								?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="block">
					<h3 class='title'>Events</h3>
					<a class="more" href="<?php echo base_url('resources/events'); ?>">more</a>
                    <a class="post" href="<?php echo base_url('resources/post/events'); ?>">post</a>
					<ul class="item-list">
						<?php foreach($events as $entry): ?>
							<li>
                            
                            	<span class="date">[ <?php echo date_range(strtotime($entry->start_date), strtotime($entry->end_date)) ;?> ]</span>
								<?php 
									$content = $entry->name;
									$content .= ', ' . $entry->location;
									if ($entry->website != NULL) {
										echo '<a href="' . $entry->website . '" class="link"  target="_blank">' . $content . '</a>'; 
									} else {
										echo $content;
									}
								?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="row">
				<div class="block">
					<h3 class='title'>Articles</h3>
					<a class="more" href="<?php echo base_url('resources/articles'); ?>">more</a>
                    <a class="post" href="<?php echo base_url('resources/post/articles'); ?>">post</a>
					<ul class="item-list">
						<?php foreach($articles as $entry): ?>
							<li>
								<?php 
									$content = $entry->name;
									if ($entry->author != NULL) {
										$content .= '<br/>(' . $entry->author;
										if ($entry->year != NULL)
											$content .= ', ' . $entry->year;
										$content .= ')';
									} else if ($entry->year != NULL) {
											$content .= '<br/>(' . $entry->year . ')';
									}

									if ($entry->website != NULL) {
										echo '<a href="' .  /*$entry->website*/ base_url('resources/articles/' . $entry->id)  . '" class="link">' . $content . '</a>'; 
									} else {
										echo $content;
									}
								?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="block">
					<h3 class='title'>Organizations</h3>
					<a class="more" href="<?php echo base_url('resources/groups'); ?>">more</a>
                    <a class="post" href="<?php echo base_url('resources/post/groups'); ?>">post</a>
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
				<div class="clear"></div>
			</div>
			
			<div class="row">
				<div class="block">
					<h3 class='title'>Device Models</h3>
					<a class="more" href="<?php echo base_url('resources/models'); ?>">more</a>
                    <a class="post" href="<?php echo base_url('resources/post/models'); ?>">post</a>
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
				</div>

				<div class="block">
					<h3 class='title'>Tools</h3>
					<a class="more" href="<?php echo base_url('resources/tools'); ?>">more</a>
                    <a class="post" href="<?php echo base_url('resources/post/tools'); ?>">post</a>
					<ul class="item-list">
						<?php foreach($tools as $entry): ?>
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
				<div class="clear"></div>
			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
