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
		<script src="<?php echo resource_url('js', 'developer/user_models.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.jqplot.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.validate.min.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>

	<?php startblock('content'); ?>
	<div id="developer">
		<div class="form-page" id="user_models">
			<div class="">
				<h3>In Progress</h3>
				<table class="user_models_table">
				<thead>
				<tr>
					<th class="sthead">Model No.</th>
					<th class="sthead">Model Name</th>
					<th class="lthead">Last Update Date</th>
					<th class="progressbar_col">Update</th>
					<th class="progressbar_col">Delete</th>
				</tr>
				</thead>
				<!-- ko if:models_info.incomplete().length>0 -->
				<tbody data-bind="foreach: models_info.incomplete">
				<tr>
					<td class="scol" data-bind="text: $index()+1"></td>
					<td class="scol" data-bind="text: model_name"></td>
					<td class="lcol" data-bind="text: last_update_time"></td>
					<td><a data-bind="attr: {id:model_id}" class="update_button"  name="response" value="Update">Update</a></td>
					<td style="padding: 0px"><a data-bind="attr: {id:model_id}" class="delete_button" value="Delete"><img src="<?php echo base_url('images/icons/delete-icon.png'); ?>" ></a></td>
				</tr>
				</tbody>
				<!-- /ko -->
				<!-- ko ifnot:models_info.incomplete().length>0 -->
				<tbody>
				<tr>
					<td colspan=5>You do not have any in-progress models<br/><a id="new_model_button" class="update_button"  name="response" value="New Model">New Model</a></td>
				</tr>
				</tbody>
				<!-- /ko -->
				</table>

				<h3>History</h3>
				<table class="user_models_table">
				<thead>
				<tr>
					<th class="thead">Model No.</th>
					<th class="thead">Model Name</th>
					<th class="thead">Submit Date</th>
				</tr>
				</thead>
				<!-- ko if:models_info.complete().length>0 -->
				<tbody data-bind="foreach: models_info.complete">
				<tr>
					<td class="col" data-bind="text: $index()+1"></td>
					<td class="col" data-bind="text: model_name"></td>
					<td class="col" data-bind="text: last_update_time"></td>
				</tr>
				</tbody>
				<!-- /ko -->
				<!-- ko ifnot:models_info.complete().length>0 -->
				<tbody>
				<tr>
					<td colspan=3>You have not submit any models</td>
				</tr>
				</tbody>
				<!-- /ko -->
				</table>

			</div>
		</div>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
