<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Contributors
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'credits.css'); ?>" />
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
				<img src="<?php echo resource_url('img', 'credits/' . $img); ?>" alt="" />
			<?php endforeach; ?>
		</div>
		<p class="subTitle">The i-Mos Team</p>
		<div class="divContainer">
			<div id="col1">
				<br>
				<span>Principal Investigator</span>
				<br>Prof. Mansun Chan
				<br>
				<br>
				<span>Project Officer</span>
				<br>Dr. Lining Zhang
				<br>
				<br>
				<span>Project Manager</span>
				<br>Lam Kai Chi Alex
				<br>
				<br>
				<span>Members</span>
				<br>Raju Salahuddin
				<br>Clarissa Cyrilla Prawoto
				<br>Yin Sun
				<br>Ying Zhu
				<br>Salahuddin Shairfe Muhammad
				<br>
				<br>
				<span>Programmers</span>
				<br>Kent Wang
				<br>Keda Ruan
				<br>Lei Sun
				<br>
				<br>
				<span>User Interface Designer</span>
				<br>Lawrence Choy
			</div>
			<div id="col2">
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