<?php extend('simulation/layout.php'); ?>
	
	<?php startblock('model_description'); ?>
		<h2>Surface-potential-based AlGaN HEMT Model<sup>[1]</sup></h2>
		<p>Authors: Xiaoxu Cheng and Yan Wang
		<br/>Organization: Tsinghua University
		<br>Contact: <a href="mailto:wangy46@tsinghua.edu.cn">wangy46@tsinghua.edu.cn</a></p>
		<h4>Description</h4>
		<div class="details">
			<div class="structure-figure">
				<img src="<?php echo base_url('images/simulation/ganhemt.png');?>" />
			</div>
			<p>This is a surface potential based model for a typical AlGaN HEMTs. An accurate solution from weak inversion, through moderate inversion and finally to strong inversion region is found for the one dimensional (1D) Poisson equation and the Schrodinger equation in the triangular potential. Velocity saturation, channel length modulation, drain-induced barrier lower effect, and self-heating effect are included in the presented model. </p>
		</div>
		<h4>References</h4>
		<div class="reference clear">
			<p>
				[1] Xiaoxu Cheng, Yan Wang, "A Surface-Potential-Based Compact Model for AlGaN/GaN MODFETs," IEEE Transactions on Electron Devices, vol. 58, pp. 448-454, 2011.
				<a href="http://dx.doi.org/10.1109/TED.2010.2089690" target="_blank">(link)</a>
			</p>
		</div>
	<?php endblock(); ?>
		
	<?php startblock('model_params'); ?>
		<ul>
			<li><a href="#device_param">Device parameters</a></li>
		</ul>
			
		<div id="device_param" class="clearfix">
			<label>W (Channel width) [m]:
				<input size="4" type="text" name="w" value="1e-3"/>
			</label>
			
			<label>Lg (Channel length) [m]:
				<input size="4" type="text" name="lg" value="0.3e-6"/>
			</label>			

			<label>DD (Doped AlGaN thickness) [m]:
				<input size="4" type="text" name="dd" value="1.5e-8"/>
			</label>
			
			<label>DI (Spacer AlGaN thickness) [m]:
				<input size="4" type="text" name="di" value="2e-9"/>
			</label>
			
			<label>Nd (AlGaN doping) [1/m<sup>3</sup>]:
				<input size="4" type="text" name="nd" value="4e24"/>
			</label>
			
			<label>U0 (Channel mobility) [m<sup>2</sup>/V/s]:
				<input size="4" type="text" name="u0" value="0.1"/>
			</label>
			
			<label>P1 (Mobility for vertical field):
				<input size="4" type="text" name="p1" value="0"/>
			</label>
			
			<label>P2 (Mobility for vertical field):
				<input size="4" type="text" name="p2" value="0"/>
			</label>
			
			<label>AX (Mobility for lateral field):
				<input size="4" type="text" name="ax" value="2"/>
			</label>

			<label>ESAT (Saturation field) [V/m]:
				<input size="4" type="text" name="esat" value="1.8e7"/>
			</label>

			<label>PP0 (Saturation length):
				<input size="4" type="text" name="pp0" value="2"/>
			</label>

			<label>AlXX (x in Al(x)Ga(1-x)N)):
				<input size="4" type="text" name="alxx" value="0.15"/>
			</label>
		</div>	
	<?php endblock(); ?>

<?php end_extend(); ?>
