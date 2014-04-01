<?php extend('layout.php'); ?>

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
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
	<div id="developer">
		<div class="form-page" id="progress-page">
		<div class="progress">
		1.To submit NEW model/ Update. Please click the appropriate button below which will direct to the model submission three step pages.<br/> <br/>
		2.Generally, the processing time for each model is estimated to be 1 month. ( Note: Subject to the completeness of the model provided)<br/> <br/>
		3.The table 1 shows the status of the model received, processed and completed by the i-MOS team.<br/> <br/>
		4.After submission, each model developer can check their model status in the table.<br/> <br/>
		5.Model developer will be contacted by the i-MOS team upon successful completion of their model.<br/> <br/>
		</div>
			<div class="progress-form">
			<div class="buttons">
				<a id="newModel" class="progress_bar" name="response" value="New Model">New Model</a>
				<a id="update" class="progress_bar"  name="response" value="Update">Update</a>
			</div>
			</div>
			<div>
				<table class="progress_table">
				<tr>
					<th rowspan=2 class="thead">Model No.</th>
					<th rowspan=2 class="thead">Model Name</th>
					<th rowspan=2 class="thead">Contributor</th>
					<th colspan=4 class="progressbar_col">Progress</th>
				</tr>
				<tr>
					<th class="small_cell">Received</th>
					<th class="small_cell">Processing</th>
					<th class="small_cell">Completed</th>
				</tr>
				<!-- ko foreach: models_info -->
				<tr>
						<td class="col" data-bind="text: $index()+1"></td>
						<td class="col" data-bind="text: model_name"></td>
						<td class="col" data-bind="text: user_name"></td>
						<td colspan=4 class="progressbar_col"><div data-bind="attr:{id: progressbar_id}"></div></td>
				</tr>
				<!-- /ko -->
				</table>
			</div>
		</div>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 