<h2>Charge-based Symmetric Double Gate MOSFET Model (symDG)<sup>[1]</sup></h2>
<p>Authors: Lining Zhang, J. Zhang, Y. Song, Xinnan Lin, Jin He, and Mansun Chan
<br>Organization: Peking University and HKUST
<br>Contact: <a href="mailto:mchan@ust.hk">mchan@ust.hk</a></p>
<h4>Introduction</h4>			
<div class="details">
	<div class="structure-figure">
		<img src="<?php echo base_url('images/simulation/symdg.png');?>" />
	</div>			
	<p>This is a complete charge-based model for ideal symmetric double MOSFET with structure shown in the given figure.  Its features include: 
		<ol>
			<li>Inversion charge model from week inversion to strong inversion calculated from the solution of 1D Poisson-Boltzmann equation [2] in the direction perpendicular to the gate</li>
			<li>Drain current model from the Pao-Sah’s dual integral [3]</li>
			<li>Can be applied to both intrinsic body as well has heavily doped body</li>
			<li>Source/drain charge model included based on the Ward and Dutton’s linear charge partition scheme [4]</li>
		</ol>
	</p>
	<p>Missing features:
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
		[1] L. Zhang, J. Zhang, Y. Song, X. Lin, J. He, and M. Chan, "Charge-based model for symmetric double-gate MOSFETs with inclusion of channel doping effect," Microelectronics Reliability, vol. 50, pp. 1062-1070, 2010.
		<a href="http://dx.doi.org/10.1016/j.microrel.2010.04.005" target="_blank">(link)</a><br>
		[2] H. K. Gummel, "A self-consistent iterative scheme for one-dimensional steady state transistor calculations," IEEE Transactions on Electron Devices, vol. 11, pp. 455-465, 1964.
		<a href="http://dx.doi.org/10.1109/T-ED.1964.15364" target="_blank">(link)</a><br>
		[3] H. C. Pao and C. T. Sah, "Effects of diffusion current on characteristics of metal-oxide (insulator)-semiconductor transistors," Solid-State Electronics, vol. 9, pp. 927-937, 1966.
		<a href="http://dx.doi.org/10.1016/0038-1101(66)90068-2" target="_blank">(link)</a><br>
		[4] D. E. Ward and R. W. Dutton, "A charge-oriented model for MOS transistor capacitances," Solid-State Circuits, IEEE Journal of, vol. 13, pp. 703-708, 1978.
		<a href="http://dx.doi.org/10.1109/JSSC.1978.1051123" target="_blank">(link)</a>
	</p>
</div>
