<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Simulation
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/json2.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.jsonrpc.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.blockUI.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.validate.min.js'); ?>" type="text/javascript"></script>
		<!--[if lt IE 9]><script src="<?php echo resource_url('js', 'library/excanvas.min.js'); ?>" type="text/javascript"></script><![endif]-->
		<script src="<?php echo resource_url('js', 'library/jquery.jqplot.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jqplot/jqplot.canvasTextRenderer.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jqplot/jqplot.canvasAxisTickRenderer.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jqplot/jqplot.canvasAxisLabelRenderer.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jqplot/jqplot.highlighter.min.js'); ?>" type="text/javascript"></script>	
		<script src="<?php echo resource_url('js', 'library/jqplot/jqplot.logAxisRenderer.min.js'); ?>" type="text/javascript"></script>
		
		<script type="text/javascript">
			var model_id = "<?php echo $model_id; ?>";
			var model_name = "<?php echo $model_name; ?>";
			var backend_url = "<?php echo $backend_url; ?>" + model_name;
			
			$(document).ready(function() {
				$.jsonRPC.setup({
				  endPoint: CI_ROOT + 'simulation/ngspice'
				});
				$.jsonRPC.request('simulate', {
				  params: [1, {l: 1e-7, w: 4.5e-7, tox: 1.2e-9, tsi: 1e-8}, {v1: {type: 'vd', init: 0, end: 1, step: 0.1}, v2: {type: 'vs', init: 0, end: 2, step: 0.1}, b1: {type: 'vg', value: 0}}],
				  success: function(result) {
					console.dir(result);
				  },
				  error: function(result) {
					console.dir(result);
				  }
				});
				
				/*$.jsonRPC.request('get_output', {
				  params: ['sim_506eab8cb2bdf1.32049020', 1],
				  success: function(result) {
					console.dir(result);
				  },
				  error: function(result) {
					console.dir(result);
				  }
				});*/
				
			});
		</script>
		<?php start_block_marker('model_script'); ?>
		<?php end_block_marker(); ?>
		
		<script src="<?php echo resource_url('js', 'simulation/utilities.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/simulation.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/plot.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/param_set.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/common.js'); ?>" type="text/javascript"></script>
		
		<script  src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>		
	<?php endblock(); ?>

	<?php startblock('css'); ?>
		<?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'node_sim.css'); ?>"/>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jquery.jqplot.css'); ?>" />		
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
	<?php endblock(); ?>

	<?php startblock('side_menu'); ?>
		<?php echo get_extended_block(); ?>
		<?php $this->load->view('simulation/simulation_block', array('models' => $models)); ?>
	<?php endblock(); ?>

	<?php startblock('content'); ?>
	<div class="simulation-page">	
		<div id="tab_container">
			<ul>
				<li><a href="#description">Description</a></li>
				<li><a href="#params">Parameters</a></li>
				<li><a href="#bias">Biasing</a></li>
				<li><a href="#output">Output Filter</a></li>
				<li><a href="#results">Simulation Results</a></li>
				<li><a href="#comments">Comments</a></li>
			</ul>
			
			<div id="description">
				<?php start_block_marker('model_description'); ?>
				<?php end_block_marker(); ?>
			</div>
			
			<div id="params" class="params no-cookie">
				<div class="clear clearfix">
					<a href="#" class="action_button dl_params" title="Download parameter set">Download</a>						
					<a href="#" class="action_button load_params" title="Upload parameter set">Upload</a>					
					<a href="#" class="action_button save_set" title="Save the current parameter set">Save in user library</a>
				</div>
				
				<div id="param_tabs">
					<?php start_block_marker('model_params'); ?>
					<?php end_block_marker(); ?>
				</div>
								
				<div id="param-sets" class="clear clearfix">	
					<h4>Pre-defined parameter sets:</h4>
					<div class="no-param-set">No pre-defined parameter set</div>
					<div class="param-set-list">
					</div>
				</div>	
			</div>
		  
			<div id="bias" class="params">
				<h3>Bias variables</h3>
				<table>
					<tr>
						<td rowspan="2">
							<label>First Variable:
								<select name="v1">
									<option value="none">Select first variable</option>
									<option value="vd">Vd</option>
									<option value="vg">Vg</option>
									<option value="vs">Vs</option>
								</select>
							</label>

							<label>V1init (Initial voltage) [V]:
								<input size="8" value="0" type="text" name="v1init"/>
							</label>
	
							<label>V1end (Final voltage) [V]:
								<input size="8" value="1" type="text" name="v1end"/>
							</label>
							
							<label>V1step (Step) [V]:
								<input size="8" value="0.1" type="text" name="v1step"/>
							</label>						
						</td>
						<td>
							<label>Second Variable:
								<select name="v2">
									<option value="none">Select second variable</option>
									<option value="vd">Vd</option>
									<option value="vg">Vg</option>
									<option value="vs">Vs</option>
									<option value="constant">Constant</option>
								</select>
							</label>
						</td>
					</tr>
					
					<tr>						
						<td class="v2_c" style="width: 200px">
							<label>Constant Type:
								<select name="b2">
									<option value="none">Select a bias variable</option>
									<option value="vd">Vd</option>
									<option value="vg">Vg</option>
									<option value="vs">Vs</option>
								</select>
							</label>
							
							<label>Value:
								<input size="8" type="text" name="b2_value"/>
							</label>
						</td>
						
						<td class="v2">
							<label>V2init (Initial voltage) [V]:
								<input size="8" value="0" type="text" name="v2init"/>
							</label>
		
							<label>V2end (Final voltage) [V]:
								<input size="8" value="1" type="text" name="v2end"/>
							</label>
							
							<label>V2step (Step) [V]:
								<input size="8" value="0.1" type="text" name="v2step"/>
							</label>					
						</td>
					</tr>

					<tr>
						<td>
							<label>Fixed Bias:
								<select name="b1">
									<option value="none">Select a bias variable</option>
									<option value="vd">Vd</option>
									<option value="vg">Vg</option>
									<option value="vs">Vs</option>
								</select>
							</label>
							
							<label>Value:
								<input size="8" type="text" name="b1_value"/>
							</label>							
						</td>
					</tr>
				</table>
			</div>

			<div id="output">
				<h3>Select output variables to be plotted:</h3>
				
				<?php start_block_marker('model_outputs'); ?>
				<?php end_block_marker(); ?>	

			</div>
		  
			<div id="results">				
				<div class="but_container">
					<a href="#" class="btn_submit">Run simulation</a>					
				</div>		
				<div id="result-container"></div>
			</div>

			<div id="comments">
				<?php $this->load->view('discussion/model_comment', $comment_data); ?>
			</div>			
		</div>
	</div>
	
	<div id="loading" class="hidden">
		<img src="<?php echo base_url('images/loading.gif');?>"/><p>
		Press F5 to refresh if<br/>no response</p>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
