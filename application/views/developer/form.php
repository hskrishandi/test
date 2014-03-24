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
		<script src="<?php echo resource_url('js', 'library/knockout.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.localPersist.js'); ?>" type="text/javascript"></script>
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
				<h3>Step 1: Fill in the description of your model (Things that should be included but not limited)</h3>
				<div class="labels">
					<label>
						<span>TITLE:</span>
						<input type="text" name="title" data-bind="value:title" />
					</label>
					<label>
						<span>Authors List:</span>
						<input type="text" name="author_list" data-bind="value:authorList" />
					</label>
					<label>
						<span>Organization:</span>
						<input type="text" name="organization" value="" />
					</label>
					<label>
						<span>Contact:</span>
						<input type="text" name="contact" value="" />
					</label>
					<label>
						<span style="width:90%">Description of the model submitted:</span>
						<textarea rows="5" name="description" value=""></textarea>
					</label>
					<label>
						<span>Reference:</span>
						<input type="text" name="reference" value="" />
					</label>
					<label>
						<span>Structure of the device in JPG/PDF:</span>
						<input type="file" name="structure" value="" />
					</label>
				</div>
			</div>
			<div class="form-page" id="page2">
				<h3>Step 2: Upload your model code to i-MOS (only Verylog-A or C codes are accepted)</h3>
				<div class="labels">
					<label>
						<span>Are you the author of the model code?</span>
						<input type="text" name="is_author" value="" />
					</label>
					<label>
						<span>Has the code gone through the convergence test?</span>
						<input type="text" name="has_tested" value="" />
					</label>
					<label>
						<span>What simulator did you use previously with this model?</span>
						<input type="radio" name="pre_simulator" value="Yes" />Yes
						<input type="radio" name="pre_simulator" value="No" />No
					</label>
					<label>
						<span>Would you like to be contacted by i-MOS team?</span>
						<input type="radio" name="can_contacted" value="Yes" />Yes
						<input type="radio" name="can_contacted" value="No" />No
					</label>
					<label>
						<span>Upload the model code in a zipped file:</span>
						<input type="file" name="model_code" value="" />
					</label>
				</div>
			</div>
			<div class="form-page" id="page3">
				<h3>Step 3: Upload the parameter files and Output options</h3>
				<div class="labels">
					<label>
						<span>1. The parameter lists with default parameters(.csv)</span>
						<input type="file" name="parameter_list" value="" />
					</label>
					<label>
						<span>2. How do you like to categorized the parameters?</span>
						<input type="file" name="figure" value="" />			  
					</label>
					<label>
						<span>3. The output variable lists from the model(.txt)</span>
						<input type="file" name="code" value="" />			  
					</label>
				</div>
			</div>
			<div class="form-page" id="page4">
				<h3>Step 4: We are almost done</h3>
				<div class="labels" style="font-size:15px">
					Thank you for contributing the model to the community.<br/><br/>The i-MOS team will usually takes about 1 month to implement one model. You will be contacted with the estimated time when the model can be done according to the current work load.<br/><br/>By clicking the Finish button, you will transfer the code to i-MOS server, and then will be redirected to the Home page.
				</div>
			</div>
		</form>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 