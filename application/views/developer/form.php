<?php extend('layouts/layout.php'); ?>

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

<?php startblock('banner'); ?>
<img src="<?php echo resource_url('img', 'develop/developerslider.png'); ?>" />
<?php endblock(); ?>

<?php startblock('content'); ?>
<div id="developer">
	<form data-bind="with:formDataStatus" id="developer_form" method="post" enctype="multipart/form-data">
		<div class="form-page" id="page1" >
			<h2 class="formStepTitle">Step 1: Fill in the description of your model</h2>
			<div class="labels">
				<div class="label_left">
					<label>
						<span>Title*</span>
						<input type="text" name="title" data-bind="value:title" class="<?php if (form_error('title') !=="") echo 'err' ?>" value="<?php echo set_value('title'); ?>" />
						<p class="error" id="title_error"></p>
					</label>
					<label>
						<span>Authors List*</span>
						<input type="text" name="author_list" data-bind="value:author_list" />
						<p class="error" id="author_list_error"></p>
					</label>
					<label>
						<span>Organization*</span>
						<input type="text" name="organization" data-bind="value:organization" />
						<p class="error" id="organization_error"></p>
					</label>
					<label>
						<span>E-mail*</span>
						<input type="text" name="contact" data-bind="value:contact" />
						<p class="error" id="contact_error"></p>
					</label>
					<label>
						<span style="vertical-align: top">Description</span>
						<textarea rows="10" name="description" data-bind="value:description"></textarea>
						<p class="error" id="description_error"></p>
					</label>
					<label>
						<span>Reference*</span>
						<input type="text" name="reference" data-bind="value:reference" />
						<p class="error" id="reference_error"></p>
					</label>
				</div>
				<div class="label_right">
					<div class="uploadFile">
						<img class="uploadImg" src="<?php echo resource_url('img', 'develop/uploadStruct.png'); ?>" />
						&nbsp;&nbsp;
						<span>Upload the structure of the device in JPG/PDF</span>
						<input type="file" name="structure" value="" />

					</div>
					<hr/>
					<input type="hidden" name="structure" data-bind="value: structure" />
					<img id="imagePreview">
				</img>
				<span>Device Structure Preview: </span><span class="uploaded previewFileName">No file selected</span>
				<p class="error" id="structure_error"></p>

			</div>

		</div>
	</div>
	<div class="form-page" id="page2">
		<h2 class="formStepTitle">Step 2: Upload your model code to <i>i</i>-MOS</h2>
		<div class="labels">
			<div class="label_left">
				<label>
					<span>Are you the author of the model code?</span>
					<input type="radio" id="radio1" name="is_author" data-bind="checked:is_author" value="Yes" />
					<label class="radioBut" for="radio1"><span></span>Yes</label>
					<input type="radio" id="radio2"name="is_author" data-bind="checked:is_author" value="No" />
					<label class="radioBut" for="radio2"><span></span>No</label>
					<p class="error" id="is_author_error"></p>
				</label>

				<label>
					<span>Has the code gone through the convergence test?</span>
					<input type="radio" id="radio3" name="is_author" data-bind="checked:has_tested" value="Yes" />
					<label class="radioBut" for="radio3"><span></span>Yes</label>
					<input type="radio" id="radio4"name="is_author" data-bind="checked:has_tested" value="No" />
					<label class="radioBut" for="radio4"><span></span>No</label>
					<p class="error" id="has_tested_error"></p>
				</label>
				<label>
					<span class="lastSpan">What simulator did you use previously with this model?</span>
					<input type="text" name="pre_simulator" data-bind="value:pre_simulator" />
					<p class="error" id="pre_simulator_error"></p>
				</label>
			</div>
			<div class="label_right">
				<div class="uploadFile">
					<img class="uploadImg" src="<?php echo resource_url('img', 'develop/modelLibrary.png'); ?>" />
					&nbsp;&nbsp;
					<span>Upload the model code in a zipped file</span>
					<input type="file" name="model_code" value="" id="inputfile"/>

				</div>
				<hr/>

				<img class="fileImg" src="<?php echo resource_url('img', 'develop/fileImage.png'); ?>"/>
				<label class="uploadMessage">
					<p>Only Verilog-A or ddC codes are accepted.</p>
					<input type="hidden" name="model_code" data-bind="value: model_code" />
					<span class="uploaded">No File selected</span>
					<p class="error" id="model_code_error"></p>
				</label>


			</div>
		</div>
	</div>
	<div class="form-page" id="page3">
		<h2 class="formStepTitle">Step 3: Upload the parameter files and Output options</h2>
		<div class="labels">
			<div class="label_left">
				<div class="uploadFile">
					<img class="uploadImg" src="<?php echo resource_url('img', 'develop/radioBut.png'); ?>" />
					&nbsp;&nbsp;
					<span>Upload parameter lists with default parameters (.csv / .xls / .xlsx)</span>
					<input type="file" name="parameter_list" value="" />

				</div>
				<hr/>

				<img class="fileImg" src="<?php echo resource_url('img', 'develop/fileImage.png'); ?>"/>
				<label class="uploadMessage">
					<p>
						<span>Parameter Template:</span>
						<a href="<?php echo base_url('home/download/developer_form/parameter template.xlsx'); ?>" >Download</a>
					</p>
					<input type="hidden" name="parameter_list" data-bind="value: parameter_list" />
					<span class="uploaded">No File selected</span>
					<p class="error" id="parameter_list_error"></p>
				</label>



			</div>
			<div class="label_right">
				<div class="uploadFile">
					<img class="uploadImg" src="<?php echo resource_url('img', 'develop/radioBut.png'); ?>" />
					&nbsp;&nbsp;
					<span>Upload output variable lists from the model (.csv / .xls / .xlsx)</span>
					<input type="file" name="output_list" value="" />

				</div>
				<hr/>

				<img class="fileImg" src="<?php echo resource_url('img', 'develop/fileImage.png'); ?>"/>
				<label class="uploadMessage">
					<p>
						<span>Output Template:</span>
						<a href="<?php echo base_url('home/download/developer_form/Output variable template.xlsx'); ?>" >Download</a>
					</p>
					<input type="hidden" name="output_list" data-bind="value: output_list" />
					<span class="uploaded">No File selected</span>
					<p class="error" id="output_list_error"></p>
				</label>


			</div>
		</div>
	</div>
	<div class="form-page" id="page4">
		<h2 class="formStepTitle">Step 4: Submit Model for implementation</h2>
		<div class="labels" >
			<label class="label_left">
				Thank you for contributing the model to the community.<br/><br/>The <i>i</i>-MOS team will usually takes about 1 month to implement one model. You will be contacted with the estimated time when the model can be done according to the current work load.<br/><br/>By clicking the Submit button, you will transfer the code to <i>i</i>-MOS server, and then will be redirected to the Home page.
			</label>
			<div class="submit_area">
				<img src="<?php echo resource_url('img', 'develop/modelLibrary.png'); ?>"/>
			</div>
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
