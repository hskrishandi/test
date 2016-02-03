<?php echo doctype('html5') ?>
<html>

<?php $menu_items = array('News' => base_url('resources'),
						'Discussion' => base_url('discussion'),
						'Users Manual' => base_url('home/manual'),
						'Ngspice Manual' => 'http://ngspice.sourceforge.net/docs.html',
						'Developer' => base_url('developer')); ?>

<head>
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	<?php	
		$meta = array(
			array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
			array('name' => 'description', 'content' => 'Integrated circuit interactive Modeling and Online Simulation Platform'),
			array('name' => 'keywords', 'content' => 'i-MOS,iMOS,i-mos,imos'),
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
		<link rel="stylesheet" type="text/css" href="<?php if (current_url() != base_url() && current_url() != base_url('home')) echo resource_url('css', 'style.css'); ?>" media="all" /><!-- <==This is for transaction from old ui to new ui. Once the new ui is finished, this should be removed. -->
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'fonts.css'); ?>" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'layout.css'); ?>" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'header.css'); ?>" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'footer.css'); ?>" media="all" />
		<!--<link rel="stylesheet" type="text/css" href="<?php echo resource_url('js', 'star-rating/jquery.rating.css'); ?>" media="all" />-->
    <?php end_block_marker(); ?>

	<?php start_block_marker('script'); ?>
		<script type="text/javascript">
			var CI_ROOT = "<?php echo base_url();?>";
			var M_TIME = "<?php echo microtime(true); ?>";
		</script>
		
        
        <script src="https://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
        
		<script src="<?php echo resource_url('js', 'scripts.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'menuBar.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'login.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'constant.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<!--<script src="<?php echo resource_url('js', 'fivestar.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'star-rating/jquery.form.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'star-rating/jquery.MetaData.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'star-rating/jquery.rating.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'jTPS.js'); ?>" type="text/javascript" charset="utf-8"></script>-->
		
    <?php end_block_marker(); ?>	
</head>
<body>


<div id="page">

	<!-- MenuBar - Start -->
	<div id="MenuBar">
		<?php start_block_marker('MenuBar'); ?>
		<a href="<?php echo base_url(); ?>">
			<img id="logo" src="<?php echo resource_url('img', 'home/Logo.png'); ?>" />
		</a>
		
		<div id="Applications">
			<a class="ApplicationButton" href="<?php echo base_url('modelsim'); ?>">
				<img class="ApplicationIcon" src="<?php echo resource_url('img', 'home/icon_ML.png'); ?>"/>
				<p class="ApplicationName">
					Model Library
				</p>
			</a>
			<a class="ApplicationButton" target="_blank" href="<?php echo base_url('txtsim'); ?>">
				<img class="ApplicationIcon" src="<?php echo resource_url('img', 'home/icon_SP.png'); ?>"/>
				<p class="ApplicationName">
					Simulation Platform
				</p>
			</a>
		</div>
		
		<a id="SiteMenu" class="MenuButton" href="#">
			<p>
				Site Menu
			</p>
		</a>
		<p class="separateLine">
			&#x7c;
		</p>
		<a id="ContactUs" class="MenuButton" href="#">
			<p>
				Contact Us
			</p>
		</a>
		
		<div id="SearchBox">
			<form accept-charset="UTF-8" id="searchForm" method="get" action="<?php echo base_url('search') ?>">
				<div id="searchFormGroup">
					<input id="searchTextInput" type="text" maxlength="128" value="<?php echo htmlspecialchars($this->input->get('q', TRUE)); ?>" placeholder="Search" name="q"></input>
				</div>
			</form>
		</div>
		
		<a id="UserBox" class="clearfix" href="#">
			<div id="UserIcon"></div>
			<p id="UserName">Login</p>
		</a>
		
	</div>
	
	<!-- MenuDropDowns - Start -->
	<div id="MenuItemsBox" class="MenuDropDown" style="display:none;">
		<ul>
		<?php foreach ($menu_items as $title => $url) : ?>
			<il>
				<a href="<?php echo $url; ?>"><?php echo $title; ?></a>
			</il>
		<?php endforeach; ?>
		</ul>
	</div>
	
	<?php $this->load->view('menubar_contactbox'); ?>
	
	<div id="block-user" class="MenuDropDown" style="display:none;"></div>
	<!-- MenuDropDowns - End -->
	
	<?php end_block_marker(); ?>

	<!-- MenuBar - End -->


	<div id="main_content">
		<?php start_block_marker('main_content'); ?>
		<?php end_block_marker(); ?>
		
		<div id="side_menu">
			<?php start_block_marker('side_menu'); ?>
			<?php end_block_marker(); ?>
		</div>
		
		<div id="content" style="clearfix">
			<?php start_block_marker('content'); ?>
			<?php end_block_marker(); ?>
		</div>
		
	</div>


	<!-- Footer - Start-->
	<?php start_block_marker('FooterBox'); ?>
    <div id="FooterBox" class="clearfix">
        <p id="footerLeftText" class="footerText">
        <span>All rights reserved. &copy; 2015 i-MOS Team</span><br />
        </p>
        <p id="footerCenterText" class="footerText">
        <span>&#x2a;&#x2a; Best viewed by Chrome 25&#x2b;, Firefox 15&#x2b; &amp; Safari 5&#x2b; with 1024x768&#x2b; screen resolution.</span><br />
        </p>
        <p id="footerRightText" class="footerText">
        <span><a href="<?php echo base_url('page/terms');?>">Terms of Use</a>  &nbsp;&nbsp;  &#x7c;  &nbsp;&nbsp;  <a href="<?php echo base_url('page/privacy');?>">Privacy Policy</a>  &nbsp;&nbsp;  &#x7c;  &nbsp;&nbsp;  <a href="<?php echo base_url('page/disclaimers');?>">Disclaimers</a>  &nbsp;&nbsp;  &#x7c;  &nbsp;&nbsp;  <a href="<?php echo base_url('page/sitemap');?>">Sitemap</a></span><br />
        </p>
    </div>
	<?php end_block_marker(); ?>

    <!-- Footer - End-->

</div>

</body>
</html>



				
