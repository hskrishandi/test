<?php extend('layouts/layout.php'); ?>
	<?php startblock('title'); ?>
		Resources
	<?php endblock(); ?>

    <?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'resources.css'); ?>" media="all" />
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

	<?php startblock('content'); ?>
		<div id="resources">
			<h2>Resources</h2>

			<div class="page-subtitle">
                <span class="page-subtitle-title">Device Models Reference</span>
				<a class="page-subtitle-more" href="<?php echo base_url('resources/models'); ?>">more</a>
				<span class="page-subtitle-separater">&#x7c;</span>
				<a class="page-subtitle-more" href="<?php echo base_url('resources/post/models'); ?>">Post Reference</a>
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

			<div class="page-subtitle">
                <span class="page-subtitle-title">Tools</span>
                <a class="page-subtitle-more" href="<?php echo base_url('resources/tools'); ?>">more</a>
                <span class="page-subtitle-separater">&#x7c;</span>
                <a class="page-subtitle-more" href="<?php echo base_url('resources/post/tools'); ?>">Post Tools</a>
			</div>


			<?php foreach ($this->config->item('tool_type') as $type => $title) :?>
			<h5 class="sub_title"><?php echo $title; ?></h5>
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
			<hr>
			<?php endforeach; ?>


			<div class="page-subtitle">
                <span class="page-subtitle-title">Organizations</span>
				<a class="page-subtitle-more" href="<?php echo base_url('resources/groups'); ?>">more</a>
				<span class="page-subtitle-separater">&#x7c;</span>
				<a class="page-subtitle-more" href="<?php echo base_url('resources/post/groups'); ?>">Post Organization</a>
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
		<div class="clearFloat"></div>
	<?php endblock(); ?>

<?php end_extend(); ?>
