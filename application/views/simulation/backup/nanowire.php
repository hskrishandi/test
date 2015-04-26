<?php extend('simulation/layout.php'); ?>

	<?php startblock('model_description'); ?>
		<h2>Charge-based Circular Silicon Nanowire Transistor Model (SNWT)<sup>[1]</sup></h2>
		<p>Authors: Feng Liu, Jin He, Lining Zhang, J. Zhang, J. Hu, C. Ma and Mansun Chan
		<br/>Organization: Peking University and HKUST
		<br>Contact: <a href="mailto:mchan@ust.hk">mchan@ust.hk</a></p>
		<h4>Description</h4>
		<div class="details">
			<div class="structure-figure">
				<img src="<?php echo base_url('images/simulation/nanowire.png');?>" />
			</div>
			<p>
				This is a complete charge-based model for ideal silicon nanowire transistor with structure shown in the given figure.  Its features include:
				<ol>
					<li>Inversion charge model from the Poisson's equation in a cylindrical coordinate system</li>
					<li>Drain current model from the Pao-Sah's dual integral [2]</li>
					<li>Can be applied to both intrinsic body as well has heavily doped body</li>
					<li>Source/drain charge model included based on the Ward and Dutton's linear charge partition scheme [3]</li>
				</ol>
			</p>
			<p>
				Missing features: 
				<ol>
					<li>Short channel effects</li>
					<li>Quantum effects</li>
					<li>Gate depletion effects</li>
					<li>Output resistance in saturation</li>
					<li>Mobility and velocity saturation models</li>
				</ol>
			</p>
		</div>
		<h4>References</h4>
		<div class="reference clear">					
			<p>
				[1] F. Liu, J. He, L. Zhang, J. Zhang, J. Hu, C. Ma, and M. Chan, "A Charge-Based Model for Long-Channel Cylindrical Surrounding-Gate MOSFETs From Intrinsic Channel to Heavily Doped Body," IEEE Transactions on Electron Devices, vol. 55, pp. 2187-2194, 2008.
				<a href="http://dx.doi.org/10.1109/TED.2008.926735" target="_blank">(link)</a><br>
				[2] H. C. Pao and C. T. Sah, "Effects of diffusion current on characteristics of metal-oxide (insulator)-semiconductor transistors," Solid-State Electronics, vol. 9, pp. 927-937, 1966.
				<a href="http://dx.doi.org/10.1016/0038-1101(66)90068-2" target="_blank">(link)</a><br>
				[3] D. E. Ward and R. W. Dutton, "A charge-oriented model for MOS transistor capacitances," Solid-State Circuits, IEEE Journal of, vol. 13, pp. 703-708, 1978.
				<a href="http://dx.doi.org/10.1109/JSSC.1978.1051123" target="_blank">(link)</a>
			</p>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
