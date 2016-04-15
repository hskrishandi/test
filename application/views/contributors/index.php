<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		Contributors
	<?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'contributors.css'); ?>" />
	<?php endblock(); ?>

	<?php startblock('content'); ?>
		<p class="mainTitle">Contributors</p>
		<p class="subTitle">Credits</p>
		<div class="divContainer">
			<br>The Hong Kong University of Science and Technology (HKUST)
			<br>The University of Hong Kong (HKU)
			<br>The Chinese University
			<br>SOC LAB
			<br>University Grants Committee
		</div>
		<div class="divIcons">
			<?php
				$this->load->helper('credits');
				$credit_img = credits_icons();
			?>
			<?php foreach($credit_img as $img): ?>
				<img src="<?php echo resource_url('img', 'contributors/' . $img); ?>" alt="" />
			<?php endforeach; ?>
		</div>
		<p class="subTitle">The i-Mos Team</p>
		<div class="divContainer">
			<div class="col1">
				<br>
				<span>Principal Investigator</span>
				<br>Prof. Mansun Chan
				<br>
				<br>
				<span>Project Director</span>
				<br>Dr. Lining Zhang
				<br>
				<br>
				<span>Project Manager</span>
				<br>Lam Kai Chi Alex
				<br>
				<br>
				<span>Members</span>
				<br>Leon Liang
				<br>Yankun Cao
				<br>Wong Man Ting Grace
				<br>Chu Chun Kit Tony
				<br>
				<br>
				<span>User Interface Designer</span>
				<br>Lawrence Choy
			</div>
			<div class="col2">
				<br>
				<span>Past Contributors</span>
				<br>Chun Ming Kenneth Au
				<br>Xiaoxu Cheng
				<br>Muthupandian Cheralathan
				<br>Sai Kin Cheung
				<br>Richeng Huang
				<br>Xiaodong Meng
				<br>Ngai Sing Ben Ng
				<br>Ka Chun Cyrix Tam
				<br>Wing Hang Seifer Tsang
				<br>Hao Wang
				<br>Kwok Shiu Andy Wong
				<br>Aixi Zhang
				<br>Hamza Zia
				<br>Raju Salahuddin
				<br>Clarissa Cyrilla Prawoto
				<br>Yin Sun
				<br>Ying Zhu
				<br>Salahuddin Shairfe Muhammad
				<br>Kent Wang
				<br>Keda Ruan
				<br>Lei Sun
				<br>
				<br>
				<span>Collaborators</span>
				<br>Prof. Xinnan Lin
				<br>(Peking University Shenzhen)
				<br>Dr. Stanislav Markov
				<br>(The University of Hong Kong)
				<br>Prof. Yu Cao
				<br>(Arizona State University)
				<br>Prof. Jin He
				<br>(Peking University)
				<br>Prof. Yan Wang
				<br>(Tsinghua University)
				<br>Prof. Philip Wong
				<br>(Stanford University)
			</div>
		</div>
	<?php endblock(); ?>
<?php end_extend(); ?>
