<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		Developer
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'developer.css'); ?>" media="all" />
    <?php endblock(); ?>
	
	
	<?php startblock('banner'); ?>
	<img id="slideImage" class="slide" src="<?php echo resource_url('img', 'develop/developerslider.png'); ?>" />
	<?php endblock(); ?>
	<?php startblock('content'); ?>
	<div id="developer">
		
		<div  id="tos-page">
			<form action="" method="post" enctype="multipart/form-data">
				
				<div class="tos">
					<h2>Terms of Service:</h2>
					<br/>
					1. You must own all content uploaded to i-MOS without copyright disputation. When you upload a model on i-MOS, you are granting us a license to distribute on i-MOS site for other users to run simulation. You can revoke the license with a written notice to the i-MOS team. <br/> <br/>
					2. We hold the right to modify the model. As the simulation is powered with Ngspice simulation engine while the model is implemented with Verilog-A code. The technique gap between Verilog-A model and Ngspice leads to the necessary. Please be noted that not all model can be implemented in i-MOS although we will try our best.<br/> <br/>
					3. We hold the right to modify or update the terms without notice. The modifications will be enforced immediately once posted on the agreement. Your further use of the platform will be considered your acceptance of the changes. So please continuously keep on visiting this page to keep up with the modifications.
					
					<input class="submit" type="submit" name="response" value="Cancel" />
					<input class="submit" type="submit" name="response" value="I Agree" />
			
				</div>
				
			</form>
		</div>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 