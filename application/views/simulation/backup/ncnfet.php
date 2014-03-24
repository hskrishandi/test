<?php extend('simulation/layout.php'); ?>

	<?php startblock('model_script'); ?>
		<script type="text/javascript">	
			var graph_map = {
				ids:	{ column: 1, name: "Ids[A]"	},
				csg:	{ column: 3, name: "Csg[F]" },
				cdg:	{ column: 5, name: "Cdg[F]" },
				cbg: 	{ column: 7, name: "Cbg[F]" },
				cgs:	{ column: 9, name: "Cgs[F]" },
				cgd:	{ column: 11, name: "Cgd[F]"},
				csb:	{ column: 13, name: "Csb[F]" },
				cdb:	{ column: 15, name: "Cdb[F]" },
				cdj: 	{ column: 17, name: "Cdj[F]" }
			};
		</script>
	<?php endblock(); ?>
	
	<?php startblock('model_description'); ?>
		<h2>Stanford CNFET Model (N type, Level 1, Version 2.1.1)</h2>
		<p>Authors: Jie Deng, H.-S. Philip Wong<br>
		Organization: Stanford University
		<br>Contact: <a href="mailto:jdeng@stanford.edu">jdeng@stanford.edu</a>, <a href="mailto:hspwong@stanford.edu">hspwong@stanford.edu</a>
		<br>Source code: <a href="http://nano.stanford.edu/model_stan_cnt.htm" target="_blank">http://nano.stanford.edu/model_stan_cnt.htm</a></p>
		<h4>Description</h4>
		<div class="details">
			<div class="structure-figure">
				<img src="<?php echo base_url('images/simulation/ncnfet.png');?>" />
			</div>
			<p>The Stanford University CNFET Model is a SPICE-compatible compact model which describes enhancement-mode, unipolar MOSFETs with semiconducting single-walled carbon nanotubes as channels. Each device may have one or more carbon nanotubes with user-specified chirality, and the effects of channel length scaling can be accurately modeled down to 20nm. The model is based on a quasi-ballistic transport picture and includes an accurate description of the capacitor network in a CNFET. It accounts for several practical non-idealities, including the scattering of carriers due to the acoustic and optical phonons in the nanotubes, the parasitic capacitance between the gate and the source/drain formed by multiple 1D nanotubes, the gate-to-gate and gate-to-contact-plug capacitances, the charge screening among the adjacent nanotubes, the access resistance of the source/drain extension regions, the Schottky-barrier resistance at the metal-nanotube contact interfaces, and the band-to-band leakage current. The model has been used to perform circuit-performance comparison with the standard digital library cells between CMOS random logic and CNFET random logic. In addition, by including a full transcapacitance network, it also produces better predictions of the dynamic performance and transient response. The CNFET model can be instantiated directly in SPICE netlists to explore the impacts of CNFETs on the circuit performance. It is an accurate and handy tool for design exploration and verification of CNT circuits.</p>
		</div>
		<h4>References</h4>
		<div class="reference clear">
			<p>
				[1] J. Deng and H.-S. P. Wong, "A Compact SPICE Model for Carbon-Nanotube Field-Effect Transistors Including Nonidealities and Its Application Part I: Model of the Intrinsic Channel Region," IEEE Transactions on Electron Devices, vol. 54, pp. 3186-3194, 2007.
				<a href="http://dx.doi.org/10.1109/TED.2007.909030" target="_blank">(link)</a><br>
                [2] J. Deng, H.-S. P. Wong, “A Compact SPICE Model for Carbon-Nanotube Field-Effect Transistors Including Nonidealities and Its Application - Part II: Full Device Model and Circuit Performance Benchmarking,” IEEE Trans. Electron Devices, vol. 54, pp. 3195-3205, 2007.
				<a href="http://dx.doi.org/10.1109/TED.2007.909043" target="_blank">(link)</a><br>
				[3] J. Deng and H.-S. P. Wong, "Modeling and Analysis of Planar Gate Capacitance for 1-D FET with Multiple Cylindrical Conducting Channels", IEEE Transactions on Electron Devices, vol. 54, pp. 2377-2385, 2007.
				<a href="http://dx.doi.org/10.1109/TED.2007.902047" target="_blank">(link)</a>
                
        <h4>Examples of analyses using the Stanford CNFET SPICE Model</h4><br>
        
                [4] N. Patil, J. Deng, S. Mitra and H.-S. P. Wong, "Circuit-Level Performance Benchmarking and Scalability Analysis of Carbon Nanotube Transistor Circuits," IEEE Transactions on Nanotechnology, vol.8, no.1, pp.37-45, Jan. 2009.
				<a href="http://dx.doi.org/10.1109/TNANO.2008.2006903" target="_blank">(link)</a><br>
                [5] J. Zhang, A. Lin, N. Patil, H. Wei, L. Wei, H.-S.P. Wong, and S. Mitra, "Carbon Nanotube Robust Digital VLSI," IEEE Transactions on Computer-Aided Design of Integrated Circuits and Systems, vol.31, no.4, pp.453-471, April 2012.
				<a href="http://dx.doi.org/10.1109/TCAD.2012.2187527" target="_blank">(link)</a><br>
			</p>
        </div>


	<?php endblock(); ?>
	
	<?php startblock('model_params'); ?>
		<ul>
			<li><a href="#device_param">Device parameters</a></li>
		</ul>
			
		<div id="device_param" class="clearfix">
			<label>Lg(Gate length) [m]: <input size="4" type="text" name="lg" value="32e-9"/> </label>
			
			<label>Lss(Source length) [m]: <input size="4" type="text" name="lss" value="32e-9"/></label>	
			
			<label>Ldd(Drain length) [m]: <input size="4" type="text" name="ldd" value="32e-9"/></label>
			
			<label>Efi(Fermi level of source/drain) [eV]:	<input size="4" type="text" name="efi" value="0.6"/></label>
			
			<label>Kgate(Gate dielectric constant): <input size="4" type="text" name="kgate" value="16"/></label>
			
			<label>Tox(Gate oxide thickness) [m]: <input size="4" type="text" name="tox" value="4e-9"/></label>
			
			<label>Vfbn (Flatband voltage) [eV]: <input size="4" type="text" name="vfbn" value="0"/></label>
			
			<label>n1 (Chirality vector 1): <input size="4" type="text" name="n1" value="19"/></label>
			
			<label>n2 (Chirality vector 2): <input size="4" type="text" name="n2" value="0"/></label>
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
				<td colspan="2"><label>Cgd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgd"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgd"/></td>
				<td colspan="2"><label>Cgs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgs"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgs"/></td>						
			</tr>
			<tr>
				<td><label>Cdg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cdg"/></td>
				<td><input type="checkbox" name="output[log][]" value="cdg"/></td>
				<td colspan="2"><label>Cdb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cdb"/></td>
				<td><input type="checkbox" name="output[log][]" value="cdb"/></td>
				<td colspan="2"><label>Cdj:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cdj"/></td>
				<td><input type="checkbox" name="output[log][]" value="cdj"/></td>
			</tr>
			<tr>	
				<td><label>Cbg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cbg"/></td>
				<td><input type="checkbox" name="output[log][]" value="cbg"/></td>
				<td colspan="2"><label>Csg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="csg"/></td>
				<td><input type="checkbox" name="output[log][]" value="csg"/></td>
				<td colspan="2"><label>Csb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="csb"/></td>
				<td><input type="checkbox" name="output[log][]" value="csb"/></td>
			</tr>					
		</table>
	<?php endblock(); ?>

<?php end_extend(); ?>
