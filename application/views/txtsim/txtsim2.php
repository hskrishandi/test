<?php extend('layout.php'); ?>

  <?php startblock('title'); ?>
    Simulation
  <?php endblock(); ?>

  <?php startblock('side_menu'); ?>
  <?php echo get_extended_block(); ?>
  <div class="block">
	<div class="Title">
		<h2>Simulation</h2>
	</div>
</div>
  <?php endblock(); ?>
  
  <?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/json2.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/jquery.blockUI.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'autosize/jquery.autosize.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'linedtextarea/jquery-linedtextarea.js'); ?>" type="text/javascript"></script>
		<script type="text/javascript">
		 $(document).ready(function(){
			var simmode= 0;
			var tabcontainer = $('#tab_container');
			tabcontainer.tabs();
			tabcontainer.bind('tabsselect', function(event, ui) {
				//Event for clicking output tab. Callback the server program.
			    if (ui.index == 3){
					alert("Call back server");
			    }
			    if ((ui.index == 2) && simmode== 0){
					$('#dialog-netlist').dialog("open");
				}
			    if (ui.index == 0 || ui.index == 1){
				simmode= 0;
			    }
			    if (ui.index == 2){
				simmode= 1;
			    }
			});

			//handling analyses Mode windows.
			var analysesMode = function ($divObj){
				$('#analyses_details div').each(function(){
					$(this).hide();
				});
				$divObj.show();	
			}
			//Intial the AnalyesMode first selection when page loaded
			$('#analyses_mode').buttonset();
			$('#analyses_mode input:first').each(function(){
					var id = $(this).attr("id");
					analysesMode($("#analyses_details #"+id));
			});
			$('#analyses_mode input').change(function(){
					var id = $(this).attr("id");
					analysesMode($("#analyses_details #"+id));
			});
		
			$('.editorCommonDesign').each(function(){
				$.data(this, "default", this.value);
			}).focus(function(){
				if(!$.data(this, 'edited'))this.value = "";
			}).change(function(){
				$.data(this, 'edited', this.value != "");
			}).blur(function(){
				if(!$.data(this, 'edited')){
					$(this).val($.data(this, 'default'));
					var height = this.scrollHeight;
					$(this).height(height);
				}
			}).autosize({append: "\n"});

			$('button.src_define').button()
			.click(function(event){
				event.preventDefault();
			});
			
		});
		$(function(){
			$('#dialog-netlist').dialog({
				resizable: true,
				width: 700,
				modal: true,
				autoOpen: false,
				buttons:{
					"Convert the settings from GUI to netlist": function(){
						$(this).dialog("close");
					},
					"Switch to netlist only": function(){
						$(this).dialog("close");
					},
					"Don 't do anything": function(){
						$(this).dialog("close");
					}
				}
			});
		});
		</script>
		<?php start_block_marker('model_script'); ?>
		<?php end_block_marker(); ?>
		
	<?php endblock(); ?>
  
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'txtsim.css'); ?>"/>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jquery.jqplot.css'); ?>" />		
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />	
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'linedtextarea/jquery-linedtextarea.css'); ?>" media="all" />
	<?php endblock(); ?>
	
  <?php startblock('content'); ?>
	<div id="simulation">
		<div id="tab_container">
			<ul>
				<li><a href="#input" class="guiMode">Input</a></li>
				<li><a href="#outputVar" class="guiMode">Output Var.</a></li>
				<li><a href="#netlistmode" class="ManualMode">Netlist</a></li>
				<li><a href="#result" class="guiMode">Result</a></li>
				<li><a href="#log">Log</a></li>
			</ul>
			<form>
				<div id="input">
					<div class="broader">
						Netlist<br />
						<textarea id="netlist" class="editorCommonDesign">Please enter the netlist.</textarea>
					</div>
					<div class="broader">
						Analyses Mode:
						<div id="analyses_mode">
							<input type="radio" id="dc" value="trans" name="mode" checked="checked"/>
							<label for="dc">DC</label>
							<input type="radio" id="ac" value="trans" name="mode" />
							<label for="ac">AC</label>
							<input type="radio" id="tran" value="trans" name="mode" />
							<label for="tran">Tran</label>
						</div>
						<div id="analyses_details">
							<div id="tran">
							<table>
								<tr>
									<td>Start</td>
									<td><input value="0"/>s</td>
								</tr>
								<tr>
									<td>Stop</td>
									<td><input value="1e-6"/>s</td>
								</tr>
								<tr>
									<td>&Delta;Step</td>
									<td><input value="1e-9"/>s</td>
								</tr>
							</table>
							</div>
							<div id="ac">
							<table>
								<tr>
									<td>&nbsp;</td>
									<td>Source 1</td>
								</tr>
								<tr>
									<td>Source</td>
									<td>(pull-down list read from Source list)</td>
								</tr>
								<tr>
									<td>Variation</td>
									<td>
										<select name="ACType">
										<option value="dec">Decade</option>
										<option value="oct">Octave</option>
										<option value="lin">Linear</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Freq. init</td>
									<td><input value="0"/>Hz</td>
								</tr>
								<tr>
									<td>Freq. end</td>
									<td><input value="1e9"/>Hz</td>
								</tr>
								<tr>
									<td>Decade/Octave:Number of points per Decade/Octave<br />Linear:Number of points</td>
									<td><input value="1e2"/>Hz</td>
								</tr>
							</table>
							</div>
							<div id="dc">
							<table>
								<tr>
									<td>&nbsp;</td>
									<td>Source 1</td>
									<td>Source 2</td>
								</tr>
								<tr>
									<td>Source</td>
									<td>(pull-down list)</td>
									<td>(pull-down list w N/A(Default))</td>
								</tr>
								<tr>
									<td>Vinit</td>
									<td><input value="0"/>V</td>
									<td><input value="0"/>V</td>
								</tr>
								<tr>
									<td>Vend</td>
									<td><input value="1"/>V</td>
									<td><input value="1"/>V</td>
								</tr>
								<tr>
									<td>&Delta;Step</td>
									<td><input value="1e-1"/>V</td>
									<td><input value="1e-1"/>V</td>
								</tr>
							</table>
							</div>
						</div>
					</div>
					<div class="broader">
					Source Defination<br />
					<div>
						<button class="src_define" id="voltage">Voltage</button>
						<button class="src_define" id="current">Current</button>
					</div>
					<textarea id="srcDefination" class="editorCommonDesign">
Please select the buttom as above for inserting code.
</textarea>
				</div>
				</div>
				<div id="outputVar">
					Output Variable
					<br /> DC/Trans
					<button class="src_define" id="voltage">Voltage</button>
					<button class="src_define" id="current">Current</button>
					<br /> AC
					<button class="src_define" id="voltage">Voltage</button>
					<button class="src_define" id="current">Vdb</button>					
					<button class="src_define" id="current">Vp</button>
					<textarea class="editorCommonDesign" id="txtOutVar">Format:
	Voltage: v(node)
	Current: i(power_source)

	Items separated by comma.

Example:
	v(2),  i(v1)</textarea>
					<br /><br />
				</div>
				<div id="netlistmode">
					<textarea class="editorCommonDesign"></textarea>
				</div>
				<div id="result">
				</div>
				<div id="log">
				</div>
			</form>
		</div>
	</div>
	<div id="dialog-netlist" title="Converts settings to Netlist mode">
	You can converts the setting to Netlist mode to<br />1) read the netlist which input to SPICES program and <br />2) run simulation directly by the netlist.
	
	The Simulation result will according by Netlist.

	Caution: Any change on netlist cannot convert to "Input" and "Output Var."
	</div>
  <?php endblock(); ?>

<?php end_extend(); ?>
