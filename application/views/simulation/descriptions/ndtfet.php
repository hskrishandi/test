<h2>UniversalTFET model<sup>[1][2]</sup></h2>
<p>Authors: Hao LU*, Trond Ytterdal# and Alan Swabaugh* <br>
Organization: *University of Notre Dame, #Norwegian Univeristy of Science and Technology
<br>Source code: <a href="https://nanohub.org/publications/31" target="_blank">
        Universal TFET model 1.6.8</a>
<?php if ($model_info->version != null && $versions != null) : ?>
<br>Version: <select name="version" id="version" onchange="onVersionSelectionChanged(this)">
<?php foreach ($versions as $key => $version) : ?>
	<?php if ($version->version == $model_info->version) : ?>
		<option selected value="<?php echo $version->id ?>"><?php echo $version->version ?></option>
	<?php else : ?>
		<option value="<?php echo $version->id ?>"><?php echo $version->version ?></option>
	<?php endif; ?>
<?php endforeach; ?>
</select>
<?php endif; ?>
</p>
<h4>Introduction</h4>
<div class="structure-figure">
	<img src="<?php echo base_url('images/simulation/ndtfet.png');?>" />
</div>
<div class="details">			
	<p>
		To gain more insights into the benefits of tunnel FETs in low power circuit applications and make performance projections, 
		a universal analytical TFET SPICE model that captures the essential features of the tunneling process has been developed. 
		The model is valid in all four operating quadrants of the TFET. Based on the Kane-Sze formula for tunneling, 
		the model captures the distinctive features of TFETs such as bias-dependent subthreshold swing, 
		superlinear drain current onset, ambipolar conduction, and negative differential resistance (NDR). 
		A simple analytic capacitance model of the gate drain capacitance has also been developed and validated on 
		two different TFET structures: a planar InAs double-gate TFET and an AlGaSb/InAs in-line TFET, 
		and good agreement is observed between the model and published simulations. 
		The model is implemented in SPICE simulators using Verilog-A and in native AIM-Spice, 
		available on Mac, Windows, Android, and iOS. 	</p>
</div>
<h4>References</h4>
<div class="reference">
	<p>
		[1] H. Lu, J. W. Kim, D. Esseni, and A. Seabaugh, “Continuous semiempirical model for the current-voltage characteristics of tunnel FETs,” in Proc. 15th Int. Conf. ULIS, 2014, pp. 25-28.
		<br/>
		[2] H. Lu, D. Esseni, and A. Seabaugh, “Universal analytic model for tunnel FET circuit simulation,” Solid-State Electronics, 2015, in press.
		
	</p>
</div>
