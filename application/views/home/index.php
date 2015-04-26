<?php 
	$showcase_img = array('Circuit_320x240.jpg', 'IV_320x240.jpg', 'IV_320x240.png');
?>

<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Home
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'home.css'); ?>" media="all" />
    <?php endblock(); ?>
	
	<?php startblock('script'); ?>
        <?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'home.js'); ?>" type="text/javascript" charset="utf-8"></script>
	<?php endblock(); ?>

	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>

	<?php startblock('content'); ?>
		<div id="home">

			<div id="description">
				<div class="title">
					<h2>The <span class="italic">i</span>-MOS Project</h2>
					<h3>An Open Platform for Device Modeling and Circuit Simulation</h3>
				</div>
				<p>
					<span class="italic">i</span>-MOS is an open platform for model developers and circuit designers to interact. Model developers can implement their models over the <span class="italic">i</span>-MOS platform to promote their acceptance and obtain user feedback. Circuit designers can use the platform to try out the most recent models of many newly developed devices before they are released by EDA vendors. The platform provides a standard interface so that users can evaluate and compare models easily. Standard benchmark tests can also be performed on the models. Currently, the platform can only output the characteristics of models. In phase II of the project, an online simulation engine will be provided and users can directly perform simulation over the <span class="italic">i</span>-MOS server any time and anywhere as long as they can get connected to the Internet.
				</p>
				<p>
					Please note that the site is lightly moderated. We'll honor all the postings, but we will exercise our right to remove spam, hostile, irrelevant and offending postings.
				</p>
				<h3 style="color:#FF3300">The users' manual is available here. &gt;&gt; <a style="color:#FF3300" href="<?php echo base_url('home/manual'); ?>"><span class="italic">i</span>-MOS Users' Manual</a></h3>
				<h3 style="color:#FF3300">The ngspice manual is available here. &gt;&gt; <a style="color:#FF3300" href="http://ngspice.sourceforge.net/docs.html" target="_blank">Ngspice Manual</a></h3>
			</div>

			<div id="showcase">
				<?php foreach($showcase_img as $img): ?>
					<img src="<?php echo resource_url('img', 'home/' . $img); ?>" width="260" height="195" alt="" />
				<?php endforeach; ?>
			</div>

			<div class="divider clear"></div>

			<div id="info" class="clearfix">
				<div id="activities" class="column first">
					<h3 class='title'><span class="italic">i</span>-MOS Activities</h3>
					<ul class="item-list">
						<?php foreach($activities as $entry): ?>
						<li>
							<span class="date">[ <?php echo date('d M Y', $entry->date); ?> ]</span>							
							<?php echo $entry->content; ?>
						</li>
						<?php endforeach; ?>
					</ul>
					<a class="more" href="<?php echo base_url('home/activities'); ?>">more</a>
				</div>

				<div id="user-experience" class="column last">
					<h3 class='title'>User Experience</h3>
					<ul class="item-list">
						<?php foreach($user_experience as $entry): ?>
						<li>
							<blockquote>
								<?php echo $entry->comment; ?>
							</blockquote>
							<span class="user-detail">
								<?php echo '&ndash; ' . $entry->first_name . ' ' . $entry->last_name . ', ' . $entry->organization . ', ' . date('Y', strtotime($entry->date)); ?>
							</span>
						</li>
						<?php endforeach; ?>
					</ul>
					<a class="more" href="<?php echo base_url('home/user_experience'); ?>">more</a>
					<a class="post" href="<?php echo base_url('home/post_experience'); ?>">post</a>
				</div>
			</div>

		</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 
