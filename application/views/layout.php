<?php
	$menu_items = array(
		'home' => array('title' => 'Home', 'url' => base_url()),
		'modelsim' => array('title' => 'Models', 'url' => base_url('modelsim')),
		'txtsim' => array('title' => 'Simulation', 'url' => base_url('txtsim')),
		'developer' => array('title' => 'Developer', 'url' => base_url('developer')),
		'discussion' => array('title' => 'Discussion', 'url' => base_url('discussion')),
		'resources' => array('title' => 'Resources', 'url' => base_url('resources')),
		'contacts' => array('title' => 'Contacts', 'url' => base_url('contacts'))
	);
?>

<?php echo doctype('html5') ?>
<html>

<head>
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	<?php	
		$meta = array(
			array('name' => 'keywords', 'content' => 'i-MOS, iMOS'),
			array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
		);

		echo meta($meta); 	
	?>
	<?php start_block_marker('meta'); ?>
    <?php end_block_marker(); ?>
	<title>
		<?php start_block_marker('title'); ?>Home<?php end_block_marker(); ?> | i-MOS
	</title>
	
	<?php start_block_marker('css'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'reset.css'); ?>" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'style.css'); ?>" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('js', 'star-rating/jquery.rating.css'); ?>" media="all" />
    <?php end_block_marker(); ?>
	
	<?php start_block_marker('script'); ?>
		<script type="text/javascript">
			var CI_ROOT = "<?php echo base_url();?>";
			var M_TIME = "<?php echo microtime(true); ?>";
		</script>
		
        
        <script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
        
       
		<script src="<?php echo resource_url('js', 'login.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'constant.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'fivestar.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'star-rating/jquery.form.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'star-rating/jquery.MetaData.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'star-rating/jquery.rating.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'jTPS.js'); ?>" type="text/javascript" charset="utf-8"></script>
		
    <?php end_block_marker(); ?>
</head>
<body>

<div id="page">

	<div id="header">
		<div id="logo">
			<a href="<?php echo base_url() ?>" title="" rel="home">
				<img id="site_logo" src="<?php echo resource_url('img', 'logo.png'); ?>" alt="iMos" />
			</a>
		</div>
        
		<div id="block-user">

		</div>
	</div>
	
	<div id="header_bar_margin">
		<div id="header_bar"></div>
	</div>
                
	<div id="main_menu">	
		<ul class="menu">
		<?php 
			$last_key = end(array_keys($menu_items));
			foreach($menu_items as $key => $item): 
		?>
				<li <?php echo ($key == $last_key ? 'class="last"' : ''); ?>>
					<?php echo '<a href="' . $item['url'] . '" title="">'; ?>
						<?php echo $item['title']; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
                
	<div id="main_page">
    
	<div id="side_menu">
	<?php start_block_marker('side_menu'); ?>
		<div class="block block-search" id="block-search-form">
			<div class="content">
				<form accept-charset="UTF-8" id="search-block-form" method="get" action="<?php echo base_url('search') ?>">
					<div class="container-inline">
						<div class="form-item form-type-textfield form-item-search-block-form">
							<label for="edit-search-block-form">Search </label>
							<input type="text" class="form-text" maxlength="128" size="18" value="<?php if (isset($_GET['q'])) echo $_GET['q']?>" name="q" id="edit-search-block-form" title="Enter the terms you wish to search for." />
						</div>
						<div id="edit-actions--2" class="form-actions form-wrapper">
							<input type="submit" class="form-submit" value="Go" name="op" id="edit-submit--2">
						</div>
					</div>
				</form>
				
			</div>
		</div>
		
	<?php end_block_marker(); ?>
	</div>
	
	<div id="content" style="clearfix">
		<?php start_block_marker('content'); ?>
		<?php end_block_marker(); ?>
	</div>
	
	</div>

	<div id="footer"> 
		<ul class="menu">
			<li><a href="<?php echo base_url('page/terms'); ?>">Terms of Use</a></li>
			<li><a href="<?php echo base_url('page/privacy'); ?>">Privacy Policy</a></li>
			<!-- <li><a href="<?php echo base_url('page/map'); ?>">Site Map</a></li> -->
			<li><a href="<?php echo base_url('page/disclaimers'); ?>">Disclaimers</a></li>
            <li class="last"><a href="<?php echo base_url('page/sitemap'); ?>">Sitemap</a></li>
		</ul>	
	</div>	
	<div id="bestSetting">
		** Best viewed by Chrome 25+, Firefox 15+ & Safari 5+ with 1024x768+ screen resolution.
	</div>
	<div id="copyright">
		All rights reserved. &copy; <?php echo date("Y"); ?> <span class="italic">i</span>-MOS Team
	</div>

</div>

</body>
</html>



				
