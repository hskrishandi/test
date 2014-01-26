<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Simulation
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'library/jquery-ui.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.js'); ?>" type="text/javascript"></script>		
		<script src="<?php echo resource_url('js', 'library/knockout.mapping.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.validation.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.localPersist.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.scrollerTabs.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/json2.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.jsonrpc.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.blockUI.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.validate.min.js'); ?>" type="text/javascript"></script>
		<!--[if lt IE 9]><script src="<?php echo resource_url('js', 'library/excanvas.min.js'); ?>" type="text/javascript"></script><![endif]-->
		<script src="<?php echo resource_url('js', 'library/jquery.jqplot.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jqplot/jqplot.plugins.pack.js'); ?>" type="text/javascript"></script>

		<?php start_block_marker('model_script'); ?>
		<?php end_block_marker(); ?>
		
		<script src="<?php echo resource_url('js', 'txtsim/PlotToPNG.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'imos-addon.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'modelsim/utilities.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'modelsim/models.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'modelsim/graphs.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'modelsim/controllers.js'); ?>" type="text/javascript"></script>
		
		<script  src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>		
	<?php endblock(); ?>

	<?php startblock('css'); ?>
		<?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome.min.css'); ?>">
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome-ie7.min.css'); ?>"><![endif]-->

		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jquery-ui/themes/base/jquery-ui.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jquery.jqplot.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'model.css'); ?>"/>	
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
	<?php endblock(); ?>

	<?php startblock('side_menu'); ?>
		<?php echo get_extended_block(); ?>		
		<div class="block model-library">
			<h2><a href="#" class="action drop-down-btn icon-cog" title="Settings" data-bind="modelLibMenu: '#model-library-menu'"></a>User Library</h2>
			<!--<input type="hidden" value="testing" name="testing" />-->
            <ul id="model-library-menu">
				<li><font class="action new"><i class="icon-file"></i>New</font></li>

				<li><font class="action model-library-save-as"><i class="icon-download"></i>Download</font></li>

				<li><font class="action model-library-upload"><i class="icon-upload"></i>Upload</font></li>
			</ul>
			
			<ul id="model-lib-list" data-bind="foreach: tree" data-current="<?php echo $model_info->id; ?>">	
                <li>
                    <a class="tree-icon" data-bind="css: { 'icon-caret-down': expanded(), 'icon-caret-right': expanded() == false }"> </a>
					<font class="model-page-direct" data-bind="attr: { href: id }, text: name"></font>
					<ul class="model-lib" data-bind="modelLibExpandable: expanded, foreach: library">
                        <li class="model-lib-entry" data-bind="modelLibEntry: true">
                            <a href="#" title="Select model library" class="load" data-bind="text: name"></a>
                            <a href="#" class="action model-lib-entry-remove delete icon-trash" title="Delete model library"></a>
                            <!-- <a href="#" class="action rename icon-pencil" title="Edit model library"></a> -->                          
                        </li>
					</ul>
				</li>
			</ul>
		</div>
	<?php endblock(); ?>

	<?php startblock('content'); ?>
	<div id="model-page">	
		<div id="model-tabs" data-bind="tabs: selectedTab, loadingWhen: isLoading">
			<ul>
            	
				<li><a href="#description">Description</a></li>
				<li><a href="#params">Parameters</a></li>
				<li><a href="#bias">Biasing</a></li>
				<li><a href="#output">Output Filter</a></li>
				<li><a href="#results">Simulation Results</a></li>
				<li><a href="#comments">Comments</a></li>
				<li id="model_name_bar"><a id="model_name" href="#description"><?php echo $model_info->icon_name;?></a></li>
			</ul>
            
			
			<div id="description">
				<?php $this->load->view('simulation/descriptions/' . $model_info->name . '.php'); ?>
			</div>
			
			<div id="params">
				<div class="toolbar">
						<a href="#" class="action add-to-lib btn-span12" data-bind="addToLib: true, if: modelParams().length > 0" title="Include the current parameter set in user library"><i class="icon-plus"></i>Include in user library</a>
						<!--
						<a href="#" class="action param-save btn-span2" data-bind="downloadParams: true" title="Save parameter set to file"><i class="icon-download-alt"></i>Save</a>
						-->
						<a href="#" class="action param-save-as btn-span4" title="Save parameter set to file"><i class="icon-download-alt"></i>Save As</a>
						<a href="#" class="action upload model-param-load btn-span2" title="Load parameter set from file"><i class="icon-upload-alt"></i>Load</a>
						<a href="#" class="action example model-param-example btn-span4" data-bind="showExamples: true, if: hasExampleBoxFileList()" title="Load parameter set from example file"><i class="icon-upload-alt"></i>Example</a>
						<form id="search_param_form">
							<input type="text" size="5" id="search_param" placeholder="Search parameter" />
						</form>
					<!--<label class="action" data-bind="loadParams: selectedSet, if: paramSet().length > 0">Use parameter set:
						<select data-bind="options: paramSet, optionsText: 'name', optionsValue: $data, value: selectedSet, optionsCaption: 'None'"></select>
					</label>-->
				</div>
				
				<script type="text/html" id="parameter-template">
					<label><span data-bind="html: label, attr: { title: description }"></span>
						<!-- ko ifnot: valueArr-->
							<input size="4" type="text" data-bind="attr: { name: name, id: name, desc: description, class: 'param_inputs', parent: $parent.id}, value: value" />
						<!-- /ko -->
						<!-- ko if: valueArr-->
							<!-- ko if:valueArr[0].value -->
							<select data-bind="options: valueArr, optionsText:'name',optionsValue:'value', value:value, attr: { name: name, id: name, desc: description, class: 'param_inputs', parent: $parent.id}" >
							</select>
							<!-- /ko -->
							<!-- ko ifnot:valueArr[0].value -->
							<select data-bind="options: valueArr, value:value, attr: { name: name, id: name, desc: description, class: 'param_inputs', parent: $parent.id}" >
							</select>
							<!-- /ko -->
						<!-- /ko -->
					</label>

				</script>
				
				<div id="param-tabs" class="inputs" data-bind="tabs: selectedParamTab">
					<ul data-bind="foreach: modelParamsForTabs">
						<li><a data-bind="attr: {href: href}, text: title" ></a></li>
					</ul>
					
					<!--<div id="param-tab-instance" data-bind="template: { name: 'parameter-template', foreach: instanceParams }">
					</div>-->
          <!-- ko foreach: modelParamsForTabs -->
						<div data-bind="template: { name: 'parameter-template', foreach: modelParams }, attr: {id: id}">
						</div>
          <!-- /ko -->
				</div>
			</div>

			<script type="text/javascript">


			</script>

			<div id="bias" class="inputs">
				<div class="toolbar">
                    <a href="#" class="action add-var btn-span9" title="Add variable bias" data-bind='css: { disabled: variablebias().length >= 2 }, click: addVariable'>
						<i class="icon-plus"></i>Add variable bias
					</a>
                    <a href="#" class="action add-fixed btn-span8" title="Add fixed bias" data-bind='css: { disabled: fixedbias().length + variablebias().length >= biases().length }, click: addFixed'>
						<i class="icon-plus"></i>Add fixed bias
					</a>
				</div>
				
				<table class="varbias" data-bind='visible: variablebias().length > 0'>
					<caption>Variable bias</caption>
					<thead>
						<tr>
							<th/>
							<th>Node</th>
							<th>Initial voltage</th>
							<th>Final voltage</th>
							<th>Step</th>
							<th/>
						</tr>
					</thead>
					<tbody data-bind='foreach: variablebias'>
						<tr>
							<th data-bind="text: ($index() ? 'Second' : 'First')"></th>
							<td><select data-bind="options: $root.biases, optionsText: 'name', optionsValue: 'name', value: name"></select></td>
							<td><input value="0" type="text" data-bind='value: init'/></td>
							<td><input value="0" type="text" data-bind='value: end'/></td>
							<td><input value="0" type="text" data-bind='event: {change:$root.stepValueOnChange, focus:$root.stepValueOnFocus}, value: step'/></td>
							<td><a href='#' class="delete icon-trash" data-bind='click: $root.removeVariable'></a></td>
						</tr>
					</tbody>
				</table>
								
				<table class="fixedbias" data-bind='visible: fixedbias().length > 0'>
					<caption>Fixed bias</caption>
					<thead>
						<tr>
							<th>Node</th>
							<th>Value</th>
							<th/>
						</tr>
					</thead>
					<tbody data-bind='foreach: fixedbias'>
						<tr>
							<td><select data-bind="options: $root.biases, optionsText: 'name', optionsValue: 'name', value: name"></select></td>
							<td><input value="0" type="text" data-bind='value: value'/></td>
							<td><a href='#' class="delete icon-trash" data-bind='click: $root.removeFixed'></a></td>
						</tr>
					</tbody>
				</table>
				
				<p class="info">Note: All unassigned nodes will be grounded.</p>
			</div>

				<div id="output">		
					<div class="toolbar">
						<a href="#" class="action select-all btn-span4" title="Select all" data-bind="checkAll: '#output input'"><i class="icon-check"></i>Select all</a>
						<a href="#" class="action deselect-all btn-span6" title="Deselect all" data-bind="uncheckAll: '#output input'"><i class="icon-check-empty"></i>Deselect all</a>
					</div>

					<div class="inputs" data-bind="foreach: outputs">
						<span class="output-var">
							<span data-bind="text: name"></span>
							<a href="#" data-bind="checkbox: linearPlot, css: 'btn-span4'"><label><input type="checkbox" tabindex="-1" />Linear</label></a>
							<a href="#" data-bind="checkbox: logPlot"><label><input type="checkbox" tabindex="-1" />Log</label></a>
						</span>
					</div>
				</div>
		  
				<div id="results">				
					<div class="toolbar">
						<a href="#" class="action btn-submit" data-bind="click: simulate, css: 'btn-span8'"><i class="icon-play"></i>Run simulation</a>		
						<label class="action" data-bind="visible: plotData().length > 0">Graph: 
							<select id="result-select" data-bind="options: plotData, optionsText: function(g) { return g.y().name + (g.y().log ? ' (log)' : ''); }, value: selectedPlot"></select>
						</label>
						<a href="#" style="position:absolute;z-index:9999;left:80%;" class="action" data-bind="visible: $root.isSimulating, click: stopSimulationByClick"><i class="icon-off"></i>Abort</a>
				</div>
				
				<div id="result-container" data-bind="foreach: plotData">
					<div class="graph-container" data-bind="visible: $root.selectedPlot() == $data">				
						<div class="toolbar">
							<a href="#" class="action download" data-bind="downloadPlot: true, css: 'btn-span11'" title="Save raw data as file"><i class="icon-download-alt"></i>Download raw data</a>
							<a href="#" class="action upload plot-custom-data-load" data-bind="css: 'btn-span11'" title="Upload custom data from file"><i class="icon-upload-alt"></i>Upload custom data</a>                    
							<a href="#" class="action show-custom" data-bind="checkbox: showCustomData, css: 'btn-span10'"><label><input type="checkbox" tabindex="-1" />Show custom data</label></a>
							<a href="#" class="action" data-bind="click:$root.downloadPlotData, css: 'btn-span6'"><i class="icon-download-alt"></i>Save as PNG</a>
						</div>
						
						<div href="#" class="graph-area" data-bind="graph: $root.selectedPlot, replot: showCustomData">
						</div>
					</div>
				</div>
			</div>

			<div id="comments">
				<?php $this->load->view('discussion/model_comment', $comment_data); ?>
			</div>			
		</div>
	</div>
	
	<div id="loading" class="hidden">
		<img src="<?php echo base_url('images/loading.gif');?>" alt="loading" />
        <p>Press F5 to refresh if<br/>no response</p>
	</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
