<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Computer Nodes Monitor
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'library/knockout.js'); ?>" type="text/javascript"></script>	
		<script src="<?php echo resource_url('js', 'monitor.js'); ?>?<?php echo time(); ?>" type="text/javascript"></script>

	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'cms.css'); ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jTPS.css'); ?>" media="all" />
        <style>
        	table td {
        		text-align: center;
        	}
        </style>
    <?php endblock(); ?>
	<?php startblock('content'); ?>
	<p align="right">Last Updated: <font data-bind="text: updatedat"></font></p>
	<div class="cms">
		<div class="node_monitor user_experience">
			Computer Nodes:<br />
			<table>
				<thead>
					<tr>
						<th>Node Name</th>
						<th>Hostname</th>
						<th>Status</th>
						<th>Apache</th>
						<th>Mysql</th>
						<th>Clear Temp. Folder</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: nodes">
					<tr>
						<td data-bind="text: name"></td>
						<td data-bind="text: hostname"></td>
						<td data-bind="html: ping"></td>
						<td data-bind="html: httpd"></td>
						<td data-bind="html: mysqld"></td>
						<td><span data-bind="click: clearTemp" style="cursor:pointer">Clear</span></td>
					</tr>
				</tbody>
			</table>

			<br /><br />
			Processes:<br />

			<table>
				<thead>
					<tr>
						<th>Node</th>
						<th>Process Id</th>
						<th>Process</th>
						<th>Running Time</th>
						<th>Terminate</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: nodes">
				<!-- ko foreach: ngspice -->
					<tr>
						<td data-bind="text: $parent.name"></td>
						<td data-bind="text: pid"></td>
						<td>ngspice</td>
						<td data-bind="text: time"></td>
						<td><span data-bind="click: $parent.terminate.bind($data, pid)" style="cursor:pointer">Terminate</span></td>
					</tr>
				<!-- /ko -->
				</tbody>
			</table>
		</div>
	</div>
		
	<?php endblock(); ?>

<?php end_extend(); ?> 
