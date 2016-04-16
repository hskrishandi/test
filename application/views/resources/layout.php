<?php
	$resources_items = array(
		'news' => array('title' => 'News', 'url' => base_url('resources/news')),
		'events' => array('title' => 'Events', 'url' => base_url('resources/events')),
		'articles' => array('title' => 'Articles', 'url' => base_url('resources/articles')),
		'groups' => array('title' => 'Organizations', 'url' => base_url('resources/groups')),
		'models' => array('title' => 'Device Models', 'url' => base_url('resources/models')),
		'tools' => array('title' => 'Tools', 'url' => base_url('resources/tools'))
	);
?>

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
    
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
		<div class="block">
			<div class="resources">
				<h2>Resources</h2>
				<p>
					<ul class="menu">
					<?php foreach($resources_items as $key => $item): ?>
						<li>
							<?php echo '<a href="' . $item['url'] . '" title="">'; ?>
								<?php echo $item['title']; ?>
							</a>
						</li>
					<?php endforeach; ?>
					</ul>
				</p>
			</div>
		</div>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	

<?php end_extend(); ?>
