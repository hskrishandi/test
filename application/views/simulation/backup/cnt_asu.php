<?php extend('simulation/layout.php'); ?>

	<?php startblock('model_script'); ?>
		<script type="text/javascript">	
			var graph_map = {
				ids:	{ column: 1, name: "Ids[A]"	},
				gds:	{ column: 3, name: "Gds[S]" },
				gm:		{ column: 5, name: "Gm[S]" }
			};
			
			var d_angle_table = [
				[5.00E-10,  [7.5, 25.28]],
				[6.00E-10,  [0, 14, 26.3]],
				[7.00E-10,  [6, 17, 23.4]],
				[8.00E-10,  [0, 9.82, 15.2, 19, 24.5]],
				[9.00E-10,  [0, 4.3, 9, 12.7, 27.5]],
				[1.00E-09,  [0, 4, 7.6, 11.7, 19, 28]],
				[1.10E-09,  [0, 3.5, 7, 14, 22, 26]],
				[1.20E-09,  [3.2, 9.5, 16.6, 20, 26.3]],
				[1.30E-09,  [0, 5.8, 12.22, 18, 21.3, 28]],
				[1.40E-09,  [2.8, 8.5, 14, 17, 23.5, 28.5]],
				[1.50E-09,  [0, 5.2, 8, 10.3, 13, 18, 24]],
				[1.60E-09,  [0, 2.4, 5, 7.22, 9.8, 20, 24]],
				[1.70E-09,  [0, 2.3, 4.5, 7, 11.4, 16.5, 23.5]],
				[1.80E-09,  [0, 4.3, 8.57, 13.3, 20, 27.4, 29]],
				[1.90E-09,  [2, 6, 10.4, 14.5, 16.7, 20.6, 25.3]],
				[2.00E-09,  [0, 4, 8, 11.7, 14, 15.5, 17.6, 22, 29]],
				[2.10E-09,  [1.87, 5.6, 9.2, 13, 15, 19, 22.6, 24.7]],
				[2.20E-09,  [0, 3.5, 5.4, 7, 9, 10.5, 12.5, 21.8, 26, 28]],
				[2.30E-09,  [0, 1.68, 3.4, 5, 6.8, 8.3, 10, 17.2, 19, 22]],
				[2.40E-09,  [0, 1.62, 3, 4.8, 8, 11.2, 16.6, 18, 23.5, 25.3, 29]],
				[2.50E-09,  [0, 3, 6, 9.5, 12.6, 14.3, 17.3, 21, 23.7, 25.55]]
			];
			
			function load_valid_angles() {
				var angle = $('select[name="angle"]').find('option').remove().end();
				var val = $('select[name="diameter"]').val();
				for (var i = 0; i < d_angle_table.length; ++i) {
					if (val == d_angle_table[i][0]) {
						for (var j = 0; j < d_angle_table[i][1].length; ++j) {
							angle.append('<option value="' + d_angle_table[i][1][j] + '">' + d_angle_table[i][1][j] + '</option>');
						}
						break;
					}
				}
			}
			
			$(document).ready(function() {
				$('select[name="diameter"]').change(load_valid_angles);	
				load_valid_angles();
			});
		</script>
	<?php endblock(); ?>
	
	<?php startblock('model_description'); ?>
		<h2>Post Silicon PTM (CNT-FET)<sup>[1][2][3]</sup></h2>
		<p>Authors: A. Balijepalli, S. Sinha, and Y. Cao<br>
		Organization: Arizona State University
		<br>Contact: <a href="mailto:yu.cao@asu.edu">yu.cao@asu.edu</a>
		<br>Source code: <a href="http://ptm.asu.edu" target="_blank">http://ptm.asu.edu</a></p>
		<h4>Description</h4>
		<div class="details">
			<div class="structure-figure">
				<img src="<?php echo base_url('images/simulation/cnt_asu.png');?>" />
			</div>
			<p>This model is a surface potential model for carbon nanotube (CNT) FET. Both the ballistic transport and Schottky-barrier effect are incorporated. It is efficient for circuit simulation in large scale.</p>
		</div>
		<h4>References</h4>
		<div class="reference clear">
			<p>
				[1] A. Balijepalli, S. Sinha, and Y. Cao, "Compact modeling of carbon nanotube transistor for early stage process-design exploration," presented at the Proceedings of the 2007 international symposium on Low power electronics and design, Portland, OR, USA, 2007.
				<a href="http://dx.doi.org/10.1145/1283780.1283783" target="_blank">(link)</a><br>
				[2] S. Sinha, A. Balijepalli, and C. Yu, "Compact Model of Carbon Nanotube Transistor and Interconnect," Electron Devices, IEEE Transactions on, vol. 56, pp. 2232-2242, 2009.
				<a href="http://dx.doi.org/10.1109/TED.2009.2028625" target="_blank">(link)</a><br>
				[3] <a href="http://ptm.asu.edu/postsi.html" target="_blank">http://ptm.asu.edu/postsi.html</a>
			</p>
		</div>
	<?php endblock(); ?>
	
	<?php startblock('model_params'); ?>
		<ul>
			<li><a href="#device_param">Device parameters</a></li>
		</ul>
			
		<div id="device_param" class="clearfix">
			<label>D (Tube diameter) [m]: 
				<select name="diameter">
				<?php 
					for ($i = 5e-10; $i < 2.6e-09; $i += 1e-10) {
						$num = sprintf("%.2e", $i);
						echo "<option value=\"" . $num . "\">" . $num . "</option>\n";
					}
				?>
				</select>
			</label>
			
			<label>Angle (Chiral angle) [deg]: 
				<select name="angle">
					<option value="7.5">7.5</option>
					<option value="25.28">25.28</option>
				</select>
			</label>	
			
			<label>Tins (Insulator thickness) [m]: <input size="4" type="text" name="tins" value="1e-8"/></label>
			
			<label>Eins (Dielectric of insulator):	<input size="4" type="text" name="eins" value="16"/></label>
			
			<label>Tb (Back gate insulator thickness) [m]: <input size="4" type="text" name="tback" value="1.3e-7"/></label>
			
			<label>Eb (Back gate dielectric of insulator): <input size="4" type="text" name="eback" value="3.9"/></label>
			
			<label>Tube type (1 for n, -1 for p): <input size="4" type="text" name="types" value="1"/></label>
			
			<label>L (Gate length) [m]: <input size="4" type="text" name="l" value="1.15e-7"/></label>
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
				<td colspan="2"><label>Gds:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="gds"/></td>
				<td><input type="checkbox" name="output[log][]" value="gds"/></td>
				<td colspan="2"><label>Gm:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="gm"/></td>
				<td><input type="checkbox" name="output[log][]" value="gm"/></td>
			</tr>				
		</table>
	<?php endblock(); ?>

<?php end_extend(); ?>
