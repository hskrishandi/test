<h2>BSIMCMG model<sup>[1][2][3]</sup></h2>
<p>
	Authors: UC Berkeley Device Group
	<br/>Organization: UC Berkeley
	<br/>Source code: <a href="http://www-device.eecs.berkeley.edu/bsim/?page=BSIMCMG">http://www-device.eecs.berkeley.edu/bsim/?page=BSIMCMG</a>
	<br/>Version: with some simplification based on BSIMCMG 106.0.0
</p>
<h4>Description</h4>			
<div class="details">
	<div class="structure-figure full">
		<img src="<?php echo base_url('images/simulation/bsimcmg.png');?>" />
	</div>
	<p>BSIM-CMG is a physical surface-potential-based compact model for multi-gate FETs. All the important effects are captured including volume inversion effect, short channel effects (SCE), and multi-gate electrostatic control effect. A detailed introduction and technical manual can be found on the BSIM GROUP webpage[3]. BSIM-CMG is officially released in Verilog-A. The i-MOS online version is based on the Verilog-A code version 106.0.0 with some simplifications:</p>
	<ol>
		<li>Self-heating turned off. (SHMOD=0)</li>
		<li>External source/drain resistance model turned off. (RDSMOD=0)</li>
		<li>NQS model turned off. (NQSMOD=0)</li>
		<li>Gate resistance /ge node turned off. (RGATEMOD=0)</li>
	</ol>
</div>
<h4>References</h4>
<div class="reference clear">
	<p>
		[1] M. V. Dunga, C.-H. Lin, D. D. Lu, W. Xiong, C. R. Cleavelin, P. Patruno, J.-R. Huang, F.-L. Yang, A. M. Niknejad, and C. Hu, BSIM-MG: A Versatile Multi-Gate FET Model for Mixed-Signal Design," in 2007 Symposium on VLSI Technology, 2007.<br/>
		[2] D. Lu, M. V. Dunga, C.-H. Lin, A. M. Niknejad, and C. Hu, A multi-gate MOS-FET compact model featuring independent-gate operation," in IEDM Technical Digest, 2007, p. 565.<br/>
		[3] <a href="http://www-device.eecs.berkeley.edu/bsim/">http://www-device.eecs.berkeley.edu/bsim/</a>
	</p>
</div>
