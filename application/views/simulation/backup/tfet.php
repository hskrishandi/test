<?php extend('simulation/layout.php'); ?>

	<?php startblock('model_script'); ?>
		<script type="text/javascript">	
			var graph_map = {
				ids:	{ column: 1, name: "Ids[A]"	},
				qs:		{ column: 3, name: "Qs[C]" },
				qd:		{ column: 5, name: "Qd[C]" },
				qg: 	{ column: 7, name: "Qg[C]"}
			};
		</script>
	<?php endblock(); ?>
	
	<?php startblock('model_description'); ?>
		<h2>TFET model<sup>[1][2]</sup></h2>
		<p>Authors: device modeling team of <i>i</i>-MOS group <br>
		Organization: HKUST
		<br>Contact: <a href="mailto:lnzhang@ust.hk">lnzhang@ust.hk</a>
		<br>Source code: <a href="<?php echo base_url('images/vadownload/TFET_HKUST.zip');?>">TFET_HKUST.zip</a>
		<br>Version: Beta
		<h4>Description</h4>
		<div class="structure-figure">
			<img src="<?php echo base_url('images/simulation/tfet.png');?>" />
		</div>
		<div class="details">			
			<p>
				Tunneling field-effect-transistors (TFETs) which break the subthreshold swing limit of 60mV/dec in MOSFETs are possible solutions to the power crisis of CMOS. The TFET model here is a surface-potential-based compact model for double-gate (DG) TFETs. Descriptions of both the current-voltage and charge-voltage characteristics are included in this model.
			</p>
		</div>
		<h4>References</h4>
		<div class="reference">
			<p>
				[1] Lining Zhang, Xinnan Lin, Jin He, Mansun Chan, “An Analytical Charge Model for Double-Gate Tunnel-FETs,” in review. 
				<br/>[2] Lining Zhang, Mansun Chan, “An Analytical Current Model for Double-Gate Tunnel-FETs,” in preparation. 
        <br/>[3] Lining Zhang, Jin He and Mansun Chan, "A Compact Model for Double-Gate Tunneling Field-Effect-Transistors and Its Implications on Circuit Behaviors", 2012 IEEE International Electron Device Metting (IEDM), Dec. 10-13, 2012, San Francisco, USA
			</p>
        </div>


	<?php endblock(); ?>
	
	<?php startblock('model_params'); ?>
		<ul>
			<li><a href="#device_param">Device parameters</a></li>
		</ul>
			
		<div id="device_param" class="clearfix">
			<label>L(Gate length) [cm]: <input size="4" type="text" name="l" value="50e-7"/> </label>
			<label>W (Gate Width) [cm]: <input size="4" type="text" name="w" value="1e-4"/> </label>
			<label>Tsi (Film thickness) [cm]: <input size="4" type="text" name="tsi" value="10e-7"/> </label>
			<label>Tox (Oxide thickness) [cm]: <input size="4" type="text" name="tox" value="1e-7"/> </label>		
		</div>
	<?php endblock(); ?>

	<?php startblock('model_outputs'); ?>
		<table>
			<tr>
				<th></th>
				<th>linear</th>
				<th>log</th>
				<th colspan="2"></th>
				<th>linear</th>
				<th>log</th>
				<th colspan="2"></th>
				<th>linear</th>
				<th>log</th>
			</tr>
			<tr>
				<td><label>Ids:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="ids"/></td>
				<td><input type="checkbox" name="output[log][]" value="ids"/></td>	
				<td colspan="2"><label>Qg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qg"/></td>
				<td><input type="checkbox" name="output[log][]" value="qg"/></td>
				<td colspan="2"><label>Qd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qd"/></td>
				<td><input type="checkbox" name="output[log][]" value="qd"/></td>			
			</tr>
			<tr>				
				<td><label>Qs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qs"/></td>
				<td><input type="checkbox" name="output[log][]" value="qs"/></td>
			</tr>				
		</table>
	<?php endblock(); ?>

<?php end_extend(); ?>
