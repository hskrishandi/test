<?php
	$this->load->helper('credits');
	$credit_img = credits_icons(); 
?>

<div class="block">
	<div class="credits">
		<h2>Credits</h2>
		<div>	
			<?php foreach($credit_img as $img): ?>
				<img src="<?php echo resource_url('img', 'credits/' . $img); ?>" alt="" />
			<?php endforeach; ?>
		</div>
	</div>
</div>
