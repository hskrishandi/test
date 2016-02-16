<?php extend('layout.php'); ?>

  <?php startblock('title'); ?>
    Simulation
  <?php endblock(); ?>

  <?php startblock('side_menu'); ?>
  <?php echo get_extended_block(); ?>
  <div class="block block-Title">
		<h1>Simulation</h1>
</div>
<div id="userlib" class="block model-library" style="z-index:50;visibility:visible;position:absolute;">
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
<div id="SClib" class="block model-library" style="z-index:50;visibility:hidden;position:absolute;">
<h2><a href="#" class="action drop-down-btn icon-cog" title="Settings" data-bind="modelLibMenu: '#model-library-menu'"></a>SC Library</h2>
<!-- <iframe id="targetbox" height="330" width="930" name="targetbox"  style="visibility:hidden;z-index:500;position:absolute;" src="http://eea258.ee.ust.hk/develop/kruan/imosdev2/js/txtsim/demo.html"></iframe> -->
<div style="width:120px; height:400px; float:left; overflow:auto;">
	<svg style="width:100px; height:400; float: left;margin:10px;">
		<g id="toolbar" >
			<text id="component_bar" x="0" y="20">Component</text>
			<g id="line" transform="translate(30,40)">
				<rect fill="#ffffff" width="40" height="10" style="opacity:0" />
				<path fill="#ffffff" stroke="#000000" d="M 0 5 L 40 5" stroke-width="1" />
			</g>
			  <g  id="gnd" class="component" transform="translate(5,120)">
				<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
				<path fill="#ffffff" stroke="#000000" d="M 20 20 L 35 20 L 20 35 L 5 20 L 20 20 L 20 0" stroke-width="1" />
				<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
			 	<text x="25" y="15" font-family="sans-serif" font-size="10px" fill="black"></text>
			</g>
			<g class="component" id="dc" transform="translate(5,60)">
				<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
				<circle fill="#ffffff" cx="20" cy="20" r="10" stroke="#000000" stroke-width="1" />
				<path fill="none" stroke="#000000" d="M 20 0 L 20 10" stroke-width="1" />
				<path fill="none" stroke="#000000" d="M 20 30 L 20 40" stroke-width="1" />
				<path fill="none" stroke="#000000" d="M 20 12.5 L 20 17.5 L 20 15 L 17.5 15 L 22.5 15"></path>
				<path fill="none" stroke="#000000" d="M 17.5 25 L 22.5 25"></path>
				<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="20" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
	      			<text x="25" y="20" font-family="sans-serif" font-size="10px" fill="black"></text>
			</g>
			<g class="component" id="resistor" transform="translate(55,60)">
				<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
				<path fill="none" stroke="#000000" d="M20 0 L20 7.5" stroke-width="1" />
				<path fill="none" stroke="#000000" d="M20 32.5 L20 40" stroke-width="1" />
				<path fill="none" stroke="#000000" d="M20 7.5 L12 11 L30 14.5 L10 18 L30 21.5 L10 25 L28 28.5 L 20 32.5" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="20" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
	      			<text x="25" y="20" font-family="sans-serif" font-size="10px" fill="black"></text>
			</g>
			<g class="component" id="NMOS-bsim3" transform="translate(55,120)">
			<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
				<line x1="20" y1="0" x2="20" y2="10"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="30" x2="20" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="10" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="20" y2="10"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="20" y1="30" x2="20" y2="40"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="10" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="0" y1="20" x2="10" y2="20"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="20" x2="40" y2="20"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="0" cy="20" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="20" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="40" cy="20" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<text x="0" y="50" font-family="sans-serif" font-size="10px" fill="black">BSIM3</text>
			</g>
			<g class="component" id="NMOS-bsim4" transform="translate(5,180)">
			<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
				<line x1="20" y1="0" x2="20" y2="10"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="30" x2="20" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="10" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="20" y2="10"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="20" y1="30" x2="20" y2="40"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="10" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="0" y1="20" x2="10" y2="20"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="20" x2="40" y2="20"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="0" cy="20" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="20" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="40" cy="20" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<text x="0" y="50" font-family="sans-serif" font-size="10px" fill="black">BSIM4</text>
			</g>
			<g class="component" id="NMOS-hisim2" transform="translate(55,180)">
			<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
				<line x1="20" y1="0" x2="20" y2="10"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="30" x2="20" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="10" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="20" y2="10"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="20" y1="30" x2="20" y2="40"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="10" x2="10" y2="30"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="0" y1="20" x2="10" y2="20"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<line x1="10" y1="20" x2="40" y2="20"
					style="fill:none;stroke:rgb(0,0,0);stroke-width:1"/>
				<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="0" cy="20" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="20" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<circle class="term" visibility="hidden" cx="40" cy="20" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
				<text x="0" y="50" font-family="sans-serif" font-size="10px" fill="black">HISIM2</text>
			</g>
			<g class="component" id="node" transform="translate(5,240)">
			<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
				<line x1="0" y1="0" x2="40" y2="0" style="stroke:#000000;stroke-width:1"/>
				<line x1="40" y1="0" x2="40" y2="20" style="stroke:#000000;stroke-width:1"/>
				<line x1="0" y1="0" x2="0" y2="40" style="fill:rgb(192,0,0);stroke:#000000;stroke-width:1"/>
				<line x1="40" y1="20" x2="0" y2="40" style="stroke:#000000;stroke-width:1"/>
				<circle class="term" visibility="hidden" cx="0" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
			</g>
			<g id="output_netlist" transform="translate(55,240)">
				<rect fill="#ffffff" width="40" height="40" stroke="#000000" />
				<text x="0" y="20" font-family="sans-serif" font-size="10px" fill="black">netlist</text>
			</g>
			<g id="delete_line" transform="translate(5,300)">
				<rect fill="#ffffff" width="40" height="20" stroke="#000000" />
				<text x="0" y="20" font-family="sans-serif" font-size="10px" fill="black">delete line</text>
			</g>
			<g id="DC_sim" transform="translate(55,300)">
				<rect fill="#ffffff" width="40" height="40" stroke="#000000" />
				<text x="0" y="20" font-family="sans-serif" font-size="10px" fill="black">DC_sim</text>
			</g>
			<g id="zoomin" transform="translate(5,360)">
				<rect fill="#ffffff" width="40" height="40" stroke="#000000" />
				<text x="0" y="20" font-family="sans-serif" font-size="10px" fill="black">Zoom in</text>
			</g>
			<g id="zoomout" transform="translate(55,360)">
				<rect fill="#ffffff" width="40" height="40" stroke="#000000" />
				<text x="0" y="20" font-family="sans-serif" font-size="10px" fill="black">Zoom out</text>
			</g>
		</g>
	</svg>
</div>
</div>
  <?php endblock(); ?>

  <?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<!--<script src="<?php echo resource_url('js', 'library/jquery-ui.min.js'); ?>" type="text/javascript"></script>-->
		<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js" type="text/javascript"></script>
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








		<?php start_block_marker('model_script'); ?>
		<?php end_block_marker(); ?>

	<?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'txtsim.css'); ?>?<?php echo time(); ?>"/>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jquery.jqplot.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
		<!-- <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'node_sim.css'); ?>" media="all" /> -->
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome.min.css'); ?>">
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome-ie7.min.css'); ?>"><![endif]-->
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'lib/codemirror.css')?>">
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'lib/codemirror-ui.css')?>">

	<?php endblock(); ?>

  <?php startblock('content'); ?>
	<div id="simulation">
		<div id="tab_container">
			<ul>
				<li><a href="#netlistmode" class="guiMode" onclick="simdappear()">Netlist</a></li>
				<li><a href="#simMode" class="guiMode" onclick="simappear()">Schematic</a></li>
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
						<textarea class="editorCommonDesign clear-area-0 data-persist" name="outvar" id="txtOutVar"></textarea>
						</div>
						<br /><br />
					</div>
				</div>
			</form>

			<div id="simMode">
			<div class="button">
						<a class="action_button btn-span4"><i class="icon-columns"></i>File</a>
						<a class="action_button btn-span4"><i class="icon-columns"></i>Edit</a>
						<a class="action_button btn-span4"><i class="icon-columns"></i>Run</a>
						<a class="action_button btn-span4"><i class="icon-columns"></i>Help</a>
					</div>
				<svg style="width:755px; height:40px; float: left;">
				<g id="toolbar2">
						<g id="line2">
						<rect width="40" height="40" fill="white" stroke="gray" />
						<rect fill="#ffffff" width="40" height="10" style="opacity:0" />
						<path fill="#ffffff" stroke="#000000" d="M 0 20 L 40 20" stroke-width="1" />
						</g>

						<rect x="40" width="40" height="40" fill="white" stroke="gray" />
						<g class="component" id="gnd2" transform="translate(40,0)">
						<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
						<path fill="#ffffff" stroke="#000000" d="M 20 20 L 35 20 L 20 35 L 5 20 L 20 20 L 20 0" stroke-width="1" />
						<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
						<text x="25" y="15" font-family="sans-serif" font-size="10px" fill="black"></text>
						</g>

						<rect x="80" width="40" height="40" fill="white" stroke="gray" />
						<g class="component" id="dc2" transform="translate(80,0)">
						<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
						<circle fill="#ffffff" cx="20" cy="20" r="10" stroke="#000000" stroke-width="1" />
						<path fill="none" stroke="#000000" d="M 20 0 L 20 10" stroke-width="1" />
						<path fill="none" stroke="#000000" d="M 20 30 L 20 40" stroke-width="1" />
						<path fill="none" stroke="#000000" d="M 20 12.5 L 20 17.5 L 20 15 L 17.5 15 L 22.5 15"></path>
						<path fill="none" stroke="#000000" d="M 17.5 25 L 22.5 25"></path>
						<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
						<circle class="term" visibility="hidden" cx="20" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
						<text x="25" y="20" font-family="sans-serif" font-size="10px" fill="black"></text>
						</g>

						<rect x="120" width="40" height="40" fill="white" stroke="gray" />
						<g class="component" id="resistor2" transform="translate(120,0)">
						<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
						<path fill="none" stroke="#000000" d="M20 0 L20 7.5" stroke-width="1" />
						<path fill="none" stroke="#000000" d="M20 32.5 L20 40" stroke-width="1" />
						<path fill="none" stroke="#000000" d="M20 7.5 L12 11 L30 14.5 L10 18 L30 21.5 L10 25 L28 28.5 L 20 32.5" stroke-width="2" />
						<circle class="term" visibility="hidden" cx="20" cy="0" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
						<circle class="term" visibility="hidden" cx="20" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
						<text x="25" y="20" font-family="sans-serif" font-size="10px" fill="black"></text>
						</g>

						<rect x="160" width="40" height="40" fill="white" stroke="gray" />
						<g class="component" id="node2" transform="translate(160,0)">
						<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
						<line x1="0" y1="0" x2="40" y2="0" style="stroke:#000000;stroke-width:1"/>
						<line x1="40" y1="0" x2="40" y2="20" style="stroke:#000000;stroke-width:1"/>
						<line x1="0" y1="0" x2="0" y2="40" style="fill:rgb(192,0,0);stroke:#000000;stroke-width:1"/>
						<line x1="40" y1="20" x2="0" y2="40" style="stroke:#000000;stroke-width:1"/>
						<circle class="term" visibility="hidden" cx="0" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
						</g>

						<rect x="200" width="40" height="40" fill="white" stroke="gray" />
						<g class="component" id="vnode2" transform="translate(200,0)">
						<rect fill="#ffffff" width="40" height="40" style="opacity:0" />
						<path fill="none" stroke="#000000" d="M5 25 L0 40 L15 35" stroke-width="1" />
						<path fill="none" stroke="#000000" d="M0 40 L25 15" stroke-width="1" />
						<circle cx="30" cy="10" r="10" fill="#ffffff" stroke="#3b4449" stroke-width="1" />
						<text x="25" y="15" font-family="sans-serif" font-size="10px" fill="black">V</text>
						<circle class="term" visibility="hidden" cx="0" cy="40" r="5" fill="#999999" stroke="#3b4449" stroke-width="2" />
						</g>
					</g>
				</svg>
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
