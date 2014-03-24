<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Simulation
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js" type="text/javascript"></script>
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
			var backend_url = CI_ROOT + 'simulation/ngspice';

			var graph_map = {
			<?php 
				for($i = 0; $i < count($outputs); ++$i) {
					$value = $outputs[$i];
					echo ($i > 0 ? ',' : '') . '"' . strtolower($value->name) . '"' . ": { column: " . $value->column_id . ", name: \" " . $value->name . "[" . $value->unit . "]\"}\n";
				} 
			?>};
		</script>
		<?php start_block_marker('model_script'); ?>
		<?php end_block_marker(); ?>
		
		<script src="<?php echo resource_url('js', 'simulation/utilities.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/simulation.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/plot.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/param_set.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/script.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'simulation/validation.js'); ?>" type="text/javascript"></script>	
		<script src="<?php echo resource_url('js', 'simulation/model_library.js'); ?>" type="text/javascript"></script>		
		
		<script  src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>		
	<?php endblock(); ?>

	<?php startblock('css'); ?>
		<?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
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
					<a href="#" class="action_button dl_params" title="Save parameter set from file">Save</a>						
					<a href="#" class="action_button load_params" title="Load parameter set from file">Load</a>					
					<a href="#" class="action_button save_set" title="Include the current parameter set in user library"><< Include in user library</a>
				</div>
				
				<div id="param_tabs">
					<?php 
						ob_start(); 
						$has_instance = false;
						$has_model = false;
					?>		
					<div id="instance_param" class="clearfix">	
						<?php foreach($params as $key => $value): 
								if (!$value->instance) continue;
								$has_instance = true;
						?>
							<label><?php echo $value->name . ($value->description ? " (" . $value->description . ")" : "") . ($value->unit != '' ? " [" . $value->unit . "]" : ""); ?>:
								<input size="4" type="text" name="<?php echo strtolower($value->name); ?>" value="<?php echo $value->default; ?>"/>
							</label>
						<?php endforeach; ?>	
					</div>	

					<div id="model_param" class="clearfix">		
						<?php foreach($params as $key => $value): 
								if ($value->instance) continue;
								$has_model = true;
						?>
							<label><?php echo $value->name . ($value->description ? " (" . $value->description . ")" : "") . ($value->unit != '' ? " [" . $value->unit . "]" : ""); ?>:
								<input size="4" type="text" name="<?php echo strtolower($value->name); ?>" value="<?php echo $value->default; ?>"/>
							</label>
						<?php endforeach; ?>
					</div>	
					<?php						
						$params = ob_get_contents();
						ob_end_clean();
					?>
					
					<ul>
						<?php if ($has_instance) { ?><li><a href="#instance_param">Instance parameters</a></li><?php } ?>
						<?php if ($has_model) { ?><li><a href="#model_param">Model parameters</a></li><?php } ?>
					</ul>
					<?php echo $params ?>
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
									<?php foreach($bias as $key => $value): ?>
										<option value="<?php echo strtolower($value->name); ?>"><?php echo $value->name; ?></option>
									<?php endforeach; ?>
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
									<?php foreach($bias as $key => $value): ?>
										<option value="<?php echo strtolower($value->name); ?>"><?php echo $value->name; ?></option>
									<?php endforeach; ?>
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
									<?php foreach($bias as $key => $value): ?>
										<option value="<?php echo strtolower($value->name); ?>"><?php echo $value->name; ?></option>
									<?php endforeach; ?>
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
									<?php foreach($bias as $key => $value): ?>
										<option value="<?php echo strtolower($value->name); ?>"><?php echo $value->name; ?></option>
									<?php endforeach; ?>
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
				
				<table>
					<tr>
						<?php
							$num_cols = count($outputs);
							if ($num_cols > 3) $num_cols = 3;
							
							for ($i = 0; $i < $num_cols; ++$i) :
						?>
							<th <?php echo ($i == 0 ? "" : 'colspan="2"'); ?>></th>
							<th>linear</th>
							<th>log</th>
						<?php endfor; ?>
					</tr>
					
					<?php
					    $output_count = count($outputs);
						for ($i = 0; $i < ceil(count($outputs)/3.0); ++$i) :
					?>
						<tr>
						<?php for ($j = 3*$i; $j < 3*$i+3 && $j < count($outputs); ++$j) : ?>
							<td <?php echo ($j % 3 == 0 ? "" : 'colspan="2"'); ?>><label><?php echo $outputs[$j]->name; ?>:</label></td>
							<td><input type="checkbox" name="output[linear][]" value="<?php echo strtolower($outputs[$j]->name); ?>"/></td>
							<td><input type="checkbox" name="output[log][]" value="<?php echo strtolower($outputs[$j]->name); ?>"/></td>
						<?php endfor; ?>
						</tr>
					<?php endfor; ?>			
				</table>

			</div>
		  
			<div id="results">				
				<div class="but_container">
					<a href="#" class="btn_submit">Run simulation</a>					
					<div class="menu_item">
						<label for="result_select">Graph: </label>
						<select id="result_select"></select>			
					</div>			
					<div class="menu_item">
						<input id="should_superimpose" type="checkbox" />
						<label for="should_superimpose">Show custom data</label>									
					</div>							
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
