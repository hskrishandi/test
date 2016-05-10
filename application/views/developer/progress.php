<?php extend('layouts/layout.php'); ?>

<?php startblock('title'); ?>
Developer
<?php endblock(); ?>

<?php startblock('css'); ?>
<?php echo get_extended_block(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome.min.css'); ?>">
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome-ie7.min.css'); ?>"><![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jquery-ui/themes/base/jquery-ui.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'developer.css'); ?>" media="all" />
<?php endblock(); ?>

<?php startblock('script'); ?>
<?php echo get_extended_block(); ?>
<script src="<?php echo resource_url('js', 'library/jquery-ui.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo resource_url('js', 'library/json2.js'); ?>" type="text/javascript"></script>
<script src="<?php echo resource_url('js', 'library/knockout.js'); ?>" type="text/javascript"></script>
<script src="<?php echo resource_url('js', 'library/knockout.localPersist.js'); ?>" type="text/javascript"></script>
<script src="<?php echo resource_url('js', 'developer/progress.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo resource_url('js', 'library/jquery.jqplot.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo resource_url('js', 'library/jquery.validate.min.js'); ?>" type="text/javascript"></script>
<?php endblock(); ?>

<?php startblock('banner'); ?>
<img src="<?php echo resource_url('img', 'develop/developerslider.png'); ?>" />
<?php endblock(); ?>


<?php startblock('content'); ?>
<div id="developer">
	<div id="progress-page" class="clearfix">
		<table id="button_table">
			<tr>
				<td class="progress_button" >
					<a id="newModel_temp" class="progress_bar" name="response" value="New Model" href="<?php echo base_url('/developer/tos?model_id=0') ?>">
						<img src="<?php echo resource_url('img', 'develop/newModel.png'); ?>" />
					</a>
				</td>
				<td rowspan="2">Please click to submit NEW model/Update which will direct to the description, upload model Verilog-A or C- code and parameter template pages. Generally, the processing time for each model is estimated to be 1 month (note: subject to the completeness of the model provided). The table 1, shows the status of the model received, processed and completed by the i-MOS team. After submission, each model developer can check their model status in the table. Model developer will be contacted by the i-MOS team upon successful completion of their model.</td>
			</tr>
			<tr>
				<td class="progress_button">
					<a id="update_temp" class="progress_bar"  name="response" value="Update" href="<?php echo base_url('/developer/user_models') ?>">
						<img src="<?php echo resource_url('img', 'develop/updateModel.png'); ?>" />
					</a>
				</td>
			</tr>
		</table>

		<div class="tbody-scroll">
			<table class="progress_table">
				<thead>
					<tr>
						<th class="thead">Model No.</th>
						<th  class="thead2">Model Name</th>
						<th  class="thead">Contributor</th>
						<th>Progress</th>
					</tr>

				</thead>
				<tbody>
					<!-- ko foreach: models_info -->
					<tr>
						<td class="col" data-bind="text: model_num"></td>
						<td class="col2" data-bind="text: model_name"></td>
						<td class="col" data-bind="text: user_name"></td>
						<td ><ul class="progress_col" data-bind="attr:{id: progressbar_id}"><li></li><li></li><li></li></ul></td>
					</tr>
					<!-- /ko -->
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php endblock(); ?>

<?php end_extend(); ?>
