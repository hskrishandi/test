<?php extend('layout.php'); ?>

  <?php startblock('MenuBar'); ?>
  <?php endblock(); ?>

  <?php startblock('title'); ?>
    Simulation
  <?php endblock(); ?>



  <?php startblock('side_menu'); ?>
  <?php echo get_extended_block(); ?>
  <div class="block block-Title">
		<h1>Simulation</h1>
</div>
<div id="userlib" class="block model-library" style="display:none;">
			<h2><a href="#" class="action drop-down-btn icon-cog" title="Settings" data-bind="modelLibMenu: '#model-library-menu'"></a>User Library</h2>
            <ul id="model-library-menu">
				<li><font class="action new"><i class="icon-file"></i>New</font></li>
				<li><font class="action model-library-save-as"><i class="icon-download"></i>Download</font></li>
				<li><font class="action upload model-library-upload"><i class="icon-upload"></i>Upload</font></li>
			</ul>

			<ul id="model-lib-list" data-bind="foreach: tree" data-current="1">
                <li>
                    <a class="tree-icon" data-bind="css: { 'icon-caret-down': expanded(), 'icon-caret-right': expanded() == false }"> </a>
					<font class="model-page-direct" data-bind="attr: { href: id }, text: name"></font>
					<ul class="model-lib" data-bind="modelLibExpandable: expanded, foreach: library">
                        <li class="model-lib-entry" data-bind="modelLibEntry: true">
                            <font href="#" class="" data-bind="text: name"></font>
                            <a href="#" class="action model-lib-entry-remove icon-trash" title="Delete model library"></a>
                        </li>
					</ul>
				</li>
			</ul>
		</div>
<div id="SClib" class="block model-library" style="display:block;">
<h2>Component</h2>
<!-- <iframe id="targetbox" height="330" width="930" name="targetbox"  style="visibility:hidden;z-index:500;position:absolute;" src="http://eea258.ee.ust.hk/develop/kruan/imosdev2/js/txtsim/demo.html"></iframe> -->
	<!-- <label>Select a number</label> -->
	<style>
	#tool_type {
		margin-top: 10px;
		width: 120px;
	}
	.no-close .ui-dialog-titlebar-close {display: none;}
	#param_dialog label {
		margin: 1px;
		display: inline-block;
		line-height: 22px;
		width: 230px;
		min-height: 26px;
		overflow: hidden;
		vertical-align: top;
	}
	#param_dialog label span {
		display: inline-block;
		float: left;
		clear: left;
		width: 140px;
		text-align: left;
		font-size: 0.75em;
	}
	#param_dialog label input {
		display: inline-block;
		width: 80px;
		float: left;
		font-size: 0.75em;
	}
	#simulation_dialog span {
		display: inline-block;
		float: left;
		clear: left;
		width: 80px;
		text-align: left;
		font-size: 0.75em;
	}
	#simulation_dialog input {
		display: inline-block;
		width: 100px;
		float: left;
		font-size: 0.75em;
	}
	</style>
	<select name="tool_type" id="tool_type">
		<option value="2" selected="selected">2-Terminal Device</option>
		<option value="3">3-Terminal Transistor</option>
		<option value="4">4-Terminal Transistor</option>
		<option value="5">5-Terminal Transistor</option>
		<option value="6">Simulation</option>
	</select>
<div id="2_term_component" style="width:130px; height:365px; float:left; overflow:auto; display:none;">
	<svg style="width:100px; height:260px; float: left;margin:10px;">
		<g id="2toolbar" >
		</g>
	</svg>
</div>

<div id="3_term_component" style="width:130px; height:365px; float:left; overflow:auto; display:none;">
	<svg style="width:100px; height:720px; float: left;margin:10px;">
		<g id="3toolbar" >
		</g>
	</svg>
</div>

<div id="4_term_component" style="width:130px; height:365px; float:left; overflow:auto; display:none;">
	<svg style="width:100px; height:370px; float: left;margin:10px;">
		<g id="4toolbar" >
    </g>
	</svg>
</div>

<div id="5_term_component" style="width:130px; height:365px; float:left; overflow:auto; display:none;">
	<svg style="width:100px; height:100px; float: left;margin:10px;">
		<g id="5toolbar" >
		</g>
	</svg>
</div>

<div id="6_term_component" style="width:130px; height:365px; float:left; overflow:auto; display:none;">
	<div><span>&nbsp; DC Simulation</span><input class="simsim" id="dc_sim" type="checkbox" size="10" value="0"/> </div>
	<div><span>&nbsp; AC Simulation</span><input class="simsim" id="ac_sim" type="checkbox" size="10" value="0"/> </div>
	<div><span>Tran Simulation</span><input class="simsim" id="tran_sim" type="checkbox" size="10" value="0"/> </div>
</div>

</div>
  <?php endblock(); ?>

  <?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<!--<script src="<?php echo resource_url('js', 'library/jquery-ui.min.js'); ?>" type="text/javascript"></script>-->
		<script src="https://code.jquery.com/ui/1.9.1/jquery-ui.js" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.mapping.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.validation.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/knockout.localPersist.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/json2.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.blockUI.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/codemirror/codemirror.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/codemirror/codemirror-ui.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/codemirror/codemirror-ui-find.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/codemirror/jquery.codemirror.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/codemirror/selection/active-line.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/codemirror/search/searchcursor.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'autosize/jquery.autosize.js'); ?>" type="text/javascript"></script>
		<!--[if lt IE 9]><script src="<?php echo resource_url('js', 'library/excanvas.min.js'); ?>" type="text/javascript"></script><![endif]-->
		<script src="<?php echo resource_url('js', 'txtsim/plot_new.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/plot_script_new.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/dist/jquery.jqplot.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/dist/plugins/jqplot.canvasTextRenderer.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/dist/plugins/jqplot.canvasAxisTickRenderer.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/dist/plugins/jqplot.canvasAxisLabelRenderer.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/dist/plugins/jqplot.highlighter.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/dist/plugins/jqplot.logAxisRenderer.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/dist/plugins/jqplot.cursor.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/dist/plugins/jqplot.logAxisRenderer.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'imos-addon.js') . "?" . time(); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'modelsim/utilities.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'modelsim/models.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/doc_ready.js') . "?" . time(); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/param_set.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/PlotToPNG.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/helper.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/sc_control.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/buckets.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'txtsim/FileSaver.js'); ?>" type="text/javascript"></script>


		<?php start_block_marker('model_script'); ?>
		<?php end_block_marker(); ?>

        <script src="<?php echo resource_url('js', 'scripts.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo resource_url('js', 'menuBar.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php //echo resource_url('js', 'login.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo resource_url('js', 'constant.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php //echo resource_url('js', 'layouts/header.js'); ?>" type="text/javascript" charset="utf-8"></script>
        <?php /*$this->load->view('layouts/header');*/ // Remove header?>

	<?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'txtsim.css'); ?>?<?php echo time(); ?>"/>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jquery.jqplot.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
		<!-- <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'node_sim.css'); ?>" media="all" /> -->
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome.min.css'); ?>">
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome-ie7.min.css'); ?>"><![endif]-->
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'lib/codemirror.css')?>">
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'lib/codemirror-ui.css')?>">


        <?php $this->load->view('layouts/css') ?>
	<?php endblock(); ?>

  <?php startblock('content'); ?>
	<div id="simulation">
		<div id="tab_container">
			<ul>
				<li><a href="#netlistmode" class="guiMode" onclick="simdappear()">Netlist</a></li>
				<li class="ui-tabs-active ui-state-active"><a href="#simMode" class="guiMode" onclick="simappear()">Schematic</a></li>
				<li><a href="#textMode" class="guiMode" onclick="simdappear()">Raw Input</a></li>
				<li><a href="#rawResult" class="guiMode" onclick="simdappear()">Raw Data</a></li>
				<li><a href="#graphResult" class="guiMode" onclick="simdappear()">Graph Result</a></li>
				<li><a href="#log">Log</a></li>
			</ul>
			<form id="netlistModeForm">
				<div id="netlistmode">
					<div class="button">
						<a id="runNetlistModeSim" class="runSim action_button btn-span8"><i class="icon-play"></i>Run Simulation</a>
						<a class="action_button netlist-save-as btn-span4"><i class="icon-download-alt"></i>Save As</a>
						<a id="functionNetlistLoad" class="action_button load_params netlist-load btn-span2"><i class="icon-upload-alt"></i>Load</a>
						<a class="action_button clear-button-0 btn-span2"><i class="icon-columns"></i>Clear</a>
						<a href="#" style="position:absolute;z-index:9999;left:80%;display:none;" class="action stop-simulation"><i class="icon-off"></i>Abort</a>
					</div>
					<div class="formContent">
						<input name="mode" value="netlist" type="hidden"/>
						<div class="broader">
							Circuit<br />
							<textarea id="srcNetlist" name="netlist" class="editorCommonDesign clear-area-0 data-persist"></textarea>
						</div>
						<div class="broader">
						Source Definition<br />
						<textarea id="srcDefination" name="source" class="editorCommonDesign clear-area-0 data-persist"></textarea>
						<div id="Source_helper" class="helper">
							<!--<div class="helperbutton">Helper</div>-->
							<div class="interface">
								<div class="item">
									<label>Type:</label>
									<select id="src_type">
										<option value="V">Voltage</option>
										<option value="I">Current</option>
									</select>
								</div>
								<div class="item clearfix"><label>Postfix:</label><input id="src_postfix" type="text" size="3" value="1"/></div>
								<div class="item"><label>Node+:</label><input id="node_plus" type="text" size="3" value="0"/> </div>
								<div class="item"><label>Node-:</label><input id="node_minus" type="text" size="3" value="0"/></div>
								<div class="item"><label>DC:</label><input id="dc_val" type="text" value="0" size="3"/>V</div>
								<div class="item clearfix"><label>AC function:</label><select id="ac_function" class="selectbox">
									<option value="none">NONE</option>
									<option value="sin">sin</option>
									<option value="pulse">pulse</option>
								</select></div>
								<div id="ac_function_select" class="select_windows">
									<div id="none"></div>
									<div id="sin">
										<div class="item"><label>Offset:</label><input id="sin_offset" type="text" size="3" value="0"/> </div>
										<div class="item"><label>Amplitude:</label><input id="sin_amplitude" type="text" size="3" value="1"/> </div>
										<div class="item"><label>Frequency:</label><input id="sin_amplitude" type="text" size="3" value="1e3"/>Hz</div>
									</div>
									<div id="pulse">
										<div class="item"><label>Initial value:</label><input id="pulse_init" type="text" size="3" value="0"/></div>
										<div class="item"><label>Pulsed value:</label><input id="pulse_pulse" type="text" size="3" value="1"/> </div>
										<div class="item"><label>Delay time:</label><input id="pulse_delay" type="text" size="3" value="0ns"/>  </div>
										<div class="item"><label>Rise time:</label><input id="pulse_rise" type="text" size="3" value="0ns"/>  </div>
										<div class="item"><label>Fall time:</label><input id="pulse_fall" type="text" size="3" value="0ns"/>  </div>
										<div class="item"><label>Pulse width:</label><input id="pulse_pulse" type="text" size="3" value="0ns"/>  </div>
										<div class="item"><label>Period:</label><input id="pulse_period" type="text" size="3" value="0ns"/> </div>
									</div>
								</div>
								<div class="item clearfix"><button type="button" id="src_insert">Insert</button></div>
							</div>
						</div>
						</div>
						<div class="broader">
							Analysis<br />
							<textarea id="srcAnalyses" name="analyses" class="editorCommonDesign clear-area-0 data-persist"></textarea>
							<div id="Analyses_helper" class="helper">
								<!--<div class="helperbutton">Helper</div>-->
								<div class="interface">
									<div class="item">
									<label>Type:</label>
									<select id="analyses_type" class="selectbox">
										<option value="AC">AC</option>
										<option value="DC">DC</option>
										<option value="TRAN">TRAN</option>
									</select>
									</div>
									<div id="analyses_type_select" class="select_windows">
										<div id="AC">
											<div class="item">
											<label>Variation:</label>
											<select id="ACSIM">
												<option value="LIN">LIN</option>
												<option value="DEC">DEC</option>
											</select>
											</div>
											<div class="item"><label>Number of points:</label><input id="AC_Points" type="text" size="5" value="100"/></div>
											<div class="item"><label>Starting frequency:</label><input id="AC_Start" type="text" size="5" value="1"/></div>
											<div class="item"><label>Final frequency:</label><input id="AC_End" type="text" size="5" value="1k"/></div>

										</div>
										<div id="DC">
											<div class="item"><label>Source1:</label><input id="DC_Src1" type="text" size="3" value="0"/></div>
											<div class="item"><label>VStart1:</label> <input id="DC_Vstart1" type="text" size="3" value="0"/>V</div>
											<div class="item"><label>VStop1:</label> <input id="DC_Vstop1" type="text" size="3" value="1"/>V</div>
											<div class="item"><label>VStep1:</label> <input id="DC_Vend1" type="text" size="3" value="0.1"/>V</div>
											<div class="item clearfix">Optional:</div>
											<div class="item clearfix"><label>Source2:</label> <input id="DC_Src2" type="text" size="3" value=""/></div>
											<div class="item"><label>VStart2:</label> <input id="DC_Vstart2" type="text" size="3" value=""/>V</div>
											<div class="item"><label>VStop2:</label> <input id="DC_Vstop2" type="text" size="3" value=""/>V</div>
											<div class="item"><label>VStep2:</label> <input id="DC_Vend2" type="text" size="3" value=""/>V</div>
										</div>
										<div id="TRAN">
											<div class="item"><label>Time of Step:</label> <input id="TRAN_step" type="text" size="3" value="10n"/>s</div>
											<div class="item"><label>Stop Time:</label> <input id="TRAN_Stop" type="text" size="3" value="10u"/>s</div>
										</div>
									</div>
									<div class="item clearfix"><button type="button" id="analyses_insert">Insert</button></div>
								</div>
							</div>
						</div>
						<div class="broader">
						Output Variable
                        <br />
						<textarea class="editorCommonDesign clear-area-0 data-persist" name="outvar" id="txtOutVar"></textarea>
						</div>
						<br /><br />
					</div>
				</div>
			</form>

			<div id="simMode">
			<!-- <div class="button"> -->
						<!-- <a class="action_button btn-span4"><i class="icon-columns"></i>File</a> -->
						<!-- <a class="action_button btn-span4"><i class="icon-columns"></i>Edit</a> -->
						<!-- <a class="action_button btn-span4"><i class="icon-columns"></i>Run</a> -->
						<!-- <a class="action_button btn-span4"><i class="icon-columns"></i>Help</a> -->
					<!-- </div> -->
				<span id="span_tmp" style="display:none;"></span>
				<input id="loadsvg" type="file" accept=".isc" style="display:none;" />
				<svg style="width:755px; height:50px; float: left;">
				  <g id="toolbar2">
					</g>
				</svg>
				<div id="save_test" class="svg-persist">
				<svg style="width:755px; height:400px; float: left;">
					<defs>
						<pattern id="smallGrid" width="10" height="10" patternUnits="userSpaceOnUse">
							<path d="M 10 0 L 0 0 0 10" fill="none" stroke="gray" stroke-width="0.5"/>
						</pattern>
						<pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
							<rect width="100" height="100" fill="url(#smallGrid)"/>
							<path d="M 50 0 L 0 0 0 50" fill="none" stroke="gray" stroke-width="1"/>
						</pattern>
					</defs>

					<g id="workspace">
						<rect id="gridsystem" width="100%" height="100%" fill="url(#grid)" />
					</g>
				</svg>
				</div>
			</div>

			<form id="RAWModeForm">
				<div id="textMode">
					<div class="button">
						<!-- <div class="button" onclick="startf();"> -->
							<a id="schematicConv" class="action_button btn-span8"><i class="icon-play"></i>Convert from schematic</a>
                        <!-- </div> -->
						<a id="functionConv" class="action_button btn-span8"><i class="icon-play"></i>Convert from netlist</a>
						<a id="runTextModeSim" class="runSim action_button btn-span8"><i class="icon-play"></i>Run Simulation</a>
						<a class="action_button raw-input-save-as btn-span4"><i class="icon-download-alt"></i>Save As</a>
						<a id="functionRAWLoad" class="action_button load_params raw-input-load btn-span2"><i class="icon-upload-alt"></i>Load</a>
						<a class="action_button clear-button-1"><i class="icon-columns"></i>Clear</a>
						<a href="#" style="position:absolute;z-index:9999;left:80%;display:none;" class="action stop-simulation"><i class="icon-off"></i>Abort</a>
					</div>
					<div class="formContent">
						<input name="mode" value="RAW" type="hidden"/>
						<span>Raw Input</span>
						<textarea id="textModeList" class="editorCommonDesign clear-area-1 data-persist code-mirror" name="RAWlist"></textarea>
						<br /> <br />
					</div>
				</div>
			</form>
				<div id="rawResult">
				</div>
				<div id="graphResult">
				</div>
				<div id="log">
					<textarea id="txtlog" class="editorCommonDesign"></textarea>
				</div>

		</div>
	</div>
	<div id="loading" class="hidden" style="">
		<img src="<?php echo base_url('images/loading.gif'); ?>"><p>
		Press F5 to refresh if<br>no response</p>
	</div>
  <?php endblock(); ?>

<?php end_extend(); ?>

<?php /*$this->load->view('layouts/footer');*/ //Remove  ?>
