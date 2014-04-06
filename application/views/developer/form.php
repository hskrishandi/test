<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Developer
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
		<?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jquery-ui/themes/base/jquery-ui.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'developer.css'); ?>" media="all" />
    <?php endblock(); ?>
		
	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'library/jquery-ui.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.localPersist.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'developer/developer.js'); ?>" type="text/javascript" charset="utf-8"></script>
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
	<div id="developer">
		<form /*action="<?php echo base_url('developer/submit/step4')?>"*/ data-bind="with:formDataStatus" id="developer_form" method="post" enctype="multipart/form-data">
			<div class="form-page" id="page1" >
				<h3>Step 1: Fill in the description of your model</h3>
				<div class="labels">
					<label>
						<span>TITLE*:</span>
						<input type="text" name="title" data-bind="value:title" class="<?php if (form_error('title') !=="") echo 'err' ?>" value="<?php echo set_value('title'); ?>" />
						<p class="error" id="title_error"></p>
					</label>
					<label>
						<span>Authors List*:</span>
						<input type="text" name="author_list" data-bind="value:author_list" />
						<p class="error" id="author_list_error"></p>
					</label>
					<label>
						<span>Organization*:</span>
						<input type="text" name="organization" data-bind="value:organization" />
						<p class="error" id="organization_error"></p>
					</label>
					<label>
						<span>E-mail*:</span>
						<input type="text" name="contact" data-bind="value:contact" />
						<p class="error" id="contact_error"></p>
					</label>
					<label>
						<span style="vertical-align: top">Description:</span>
						<textarea rows="5" name="description" data-bind="value:description"></textarea>
						<p class="error" id="description_error"></p>
					</label>
					<label>
						<span>Reference*:</span>
						<input type="text" name="reference" data-bind="value:reference" />
						<p class="error" id="reference_error"></p>
					</label>
					<label>
						<span>Structure of the device in JPG/PDF:</span>
						<input type="file" name="structure" value="" />
						<input type="hidden" name="structure" data-bind="value: structure" />
						<span class="uploaded" data-bind="if: structure">Uploaded!</span>
						<p class="error" id="structure_error"></p>
					</label>
				</div>
			</div>
			<div class="form-page" id="page2">
				<h3>Step 2: Upload your model code to <i>i</i>-MOS (only Verilog-A or C codes are accepted)</h3>
				<div class="labels">
					<label>
						<span>Are you the author of the model code?</span>
						<input type="radio" name="is_author" data-bind="checked:is_author" value="Yes" />Yes
						<input type="radio" name="is_author" data-bind="checked:is_author" value="No" />No
						<p class="error" id="is_author_error"></p>
					</label>
					<label>
						<span>Has the code gone through the convergence test?</span>
						<input type="radio" name="has_tested" data-bind="checked:has_tested" value="Yes" />Yes
						<input type="radio" name="has_tested" data-bind="checked:has_tested" value="No" />No
						<p class="error" id="has_tested_error"></p>
					</label>
					<label>
						<span>What simulator did you use previously with this model?</span>
						<input type="text" name="pre_simulator" data-bind="value:pre_simulator" />
						<p class="error" id="pre_simulator_error"></p>
					</label>
					<!--<label>
						<span>Would you like to be contacted by i-MOS team?</span>
						<input type="radio" name="can_contacted" data-bind="checked:can_contacted" value="Yes" />Yes
						<input type="radio" name="can_contacted" data-bind="checked:can_contacted" value="No" />No
						<p class="error" id="can_contacted_error"></p>
					</label>-->
					<label>
						<span>Upload the model code in a zipped file:</span>
						<input type="file" name="model_code" value="" />
						<input type="hidden" name="model_code" data-bind="value: model_code" />
						<span class="uploaded" data-bind="if:model_code">Uploaded!</span>
						<p class="error" id="model_code_error"></p>
					</label>
				</div>
			</div>
			<div class="form-page" id="page3">
				<h3>Step 3: Upload the parameter files and Output options</h3>
				<div class="labels">
					<label>
						<span>1. The parameter lists with default parameters(.csv|.xls|.xlsx)</span>
						<input type="file" name="parameter_list" value="" />
						<input type="hidden" name="parameter_list" data-bind="value: parameter_list" />
						<span class="uploaded" data-bind="if:parameter_list">Uploaded!</span>
						<p class="error" id="parameter_list_error"></p>
					</label>
					<label>
						<span>&nbsp;&nbsp;Please follow the suggested format:</span>
						<a href="<?php echo base_url('home/download/developer_form/parameter template.xlsx'); ?>" >Parameter Template</a>
					</label>
					<label>
						<span>2. The output variable lists from the model(.csv|.xls|.xlsx)</span>
						<input type="file" name="output_list" value="" />
						<input type="hidden" name="output_list" data-bind="value: output_list" />
						<span class="uploaded" data-bind="if:output_list">Uploaded!</span>
						<p class="error" id="output_list_error"></p>
					</label>
					<label>
						<span>&nbsp;&nbsp;Please follow the suggested format:</span>
						<a href="<?php echo base_url('home/download/developer_form/Output variable template.xlsx'); ?>" >Output Template</a>
					</label>
				</div>
			</div>
			<div class="form-page" id="page4">
				<h3>Step 4: We are almost done</h3>
				<div class="labels" style="font-size:15px">
					Thank you for contributing the model to the community.<br/><br/>The <i>i</i>-MOS team will usually takes about 1 month to implement one model. You will be contacted with the estimated time when the model can be done according to the current work load.<br/><br/>By clicking the Submit button, you will transfer the code to <i>i</i>-MOS server, and then will be redirected to the Home page.
				</div>
			</div>
		</form>
	</div>
	<div id="validation_alert">
	<!--<label class="show">Incomplete step:</label>-->
	<label class="hidden alert_button" id='step1_alert'><a><u>Step 1</u></a>: Description incomplete</label>
	<label class="hidden alert_button" id='step2_alert'><a><u>Step 2</u></a>: Model code incomplete</label>
	<label class="hidden alert_button" id='step3_alert'><a><u>Step 3</u></a>:Parameter incomplete</label>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 