<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Developer
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'developer.css'); ?>" media="all" />
    <?php endblock(); ?>
		
	<?php startblock('script'); ?>
        <?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'developer.js'); ?>" type="text/javascript" charset="utf-8"></script>
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
	<div id="developer">
		<form action="<?php echo base_url('developer/submit')?>" method="post" enctype="multipart/form-data">
			<div class="form-page" id="page1">				
				<label>
					Model name:
					<input type="text" name="model_name" value="" />			  
				</label>
				<label>
					Version:
					<input type="text" name="version" value="1.0" />			  
				</label>
				<label>
					Credits:
					<input type="text" name="credits" value="" />			  
				</label>
				<label>
					Device category:
					<select name="device_cat">
						<option value="default" selected="selected">-- Select from list --</option>
					</select> 		  
				</label>
				<label>
					Email:
					<input type="text" name="email" value="" />			  
				</label>
			</div>
			<div class="form-page" id="page2">
				<label>
					Model description:
					<textarea rows="6" cols="50" name="model_description"></textarea>			  
				</label>
				<label>
					Reference:
					<textarea rows="6" cols="50" name="reference"></textarea> 
				</label>
				<label>
					Device structure figure:
					<input type="file" name="figure" value="" />			  
				</label>
				<label>
					Verilog-A model code:
					<input type="file" name="code" value="" />			  
				</label>	
			</div>
		</form>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 