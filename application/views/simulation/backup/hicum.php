<?php extend('simulation/layout.php'); ?>

	<?php startblock('model_script'); ?>
		<script type="text/javascript">		
			var graph_map = {
				ivc:	{ column: 1, name: "Ivs[A]"	},
				ivb: 	{ column: 3, name: "Ivb[A]" }
			};
		</script>
	<?php endblock(); ?>

	<?php startblock('model_description'); ?>
		<h2>HIgh-CUrrent Model (HICUM)</h2>
		<p>Authors: HICUM group with Prof. M. Schroter
		<br>Organization: University of Technology Dresden, Germany
		<br>Version: HICUM Level 2 Version 2.24</p>
		<h4>Description</h4>			
		<div class="details">
			<div class="structure-figure">
				<img src="<?php echo base_url('images/simulation/hicum.png');?>" />
			</div>			
			<p>
				HICUM (HIgh-CUrrent Model) is a compact model for bipolar transistor with semi-physical nature. It is emphasized especially at the operating region of high current densities. Verified for a variety of techniques of Si, SiGe, and III-V, HICUM is found to be accurate for high power transistors with BV_(CEO) values up to 15V. It has been selected as one of the standard bipolar transistor models by the CMC in 2003.
			</p>
		</div>
		<h4>References</h4>
		<div class="reference clear">
			<p>
				[1] A. Pawlak, M. Schroter, A. Mukherjee, and J. Krause, "Modeling high-speed SiGe-HBTs with HICUM/L2," CEDIC, Technische Universitat Dresden, Germany, 2012.
				<br>
				[2] M. Schroter and A. Chakravorty, "Compact hierarchical bipolar transistor modeling with hicum," World Scientific Pub Co Inc, 2010.
			</p>
		</div>
	<?php endblock(); ?>
	
	<?php startblock('model_params'); ?>
		<ul>
			<li><a href="#model_param">Model parameters</a></li>
		</ul>
		
		<div id="model_param" class="clearfix">
			<label>C10:<input type="text" name="c10" value="3.76E-32"></input></label> <label>Qp0:<input type="text" name="qp0" value="2.78e-14"></input></label> <label>Ich:<input type="text" name="ich" value="2.09e-2"></input></label> <label>Hfe:<input type="text" name="hfe" value="1.0"></input></label> <label>Hfc:<input type="text" name="hfc" value="1.0"></input></label> <label>Hjei:<input type="text" name="hjei" value="1.0"></input></label> 
			<label>Hjci:<input type="text" name="hjci" value="1.0"></input></label> <label>Tr:<input type="text" name="tr" value="0.0"></input></label> <label>Ibeis:<input type="text" name="ibeis" value="1.16E-20"></input></label> <label>Mbei:<input type="text" name="mbei" value="1.015"></input></label> <label>Ireis:<input type="text" name="ireis" value="1.16e-16"></input></label> <label>Mrei:<input type="text" name="mrei" value="2.0"></input></label> <label>Ibeps:<input type="text" name="ibeps" value="3.72e-21"></input></label>
			<label>Mbep:<input type="text" name="mbep" value="1.015"></input></label> <label>Ireps:<input type="text" name="ireps" value="1.0e-30"></input></label> <label>Mrep:<input type="text" name="mrep" value="2.0"></input></label> <label>Mcf:<input type="text" name="mcf" value="1.0"></input></label> <label>Tbhrec:<input type="text" name="tbhrec" value="250.0"></input></label> <label>Ibcis:<input type="text" name="ibcis" value="1.16e-20"></input></label> <label>Mbci:<input type="text" name="mbci" value="1.015"></input></label> <label>Ibcxs:<input type="text" name="ibcxs" value="4.39e-20"></input></label>
			<label>Mbcx:<input type="text" name="mbcx" value="1.03"></input></label> <label>Ibets:<input type="text" name="ibets" value="1.0e-20"></input></label> <label>Abet:<input type="text" name="abet" value="40.0"></input></label> <label>Tunode:<input type="text" name="tunode" value="1.0"></input></label> <label>Favl:<input type="text" name="favl" value="1.186"></input></label> <label>Qavl:<input type="text" name="qavl" value="11.1e-5"></input></label> <label>Alfav:<input type="text" name="alfav" value="0.825e-4"></input></label>
			<label>Alqav:<input type="text" name="alqav" value="0.196e-3"></input></label> <label>Rbi0:<input type="text" name="rbi0" value="71.76"></input></label> <label>Rbx:<input type="text" name="rbx" value="8.83"></input></label> <label>Fgeo:<input type="text" name="fgeo" value="0.73"></input></label> <label>Fdqr0:<input type="text" name="fdqr0" value="0.2"></input></label> <label>Fcrbi:<input type="text" name="fcrbi" value="0.0"></input></label> <label>Flcomp:<input type="text" name="flcomp" value="1"></input></label>
			<label>Fqi:<input type="text" name="fqi" value="1.0"></input></label> <label>Re:<input type="text" name="re" value="12.534"></input></label> <label>Rcx:<input type="text" name="rcx" value="9.165"></input></label> <label>Itss:<input type="text" name="itss" value="0.0"></input></label> <label>Msf:<input type="text" name="msf" value="1.05"></input></label> <label>Iscs:<input type="text" name="iscs" value="0.0"></input></label> <label>Msc:<input type="text" name="msc" value="1.0"></input></label> <label>Tsf:<input type="text" name="tsf" value="1.05"></input></label> <label>Rsu:<input type="text" name="rsu" value="0.0"></input></label> 
			<label>Csu:<input type="text" name="csu" value="0.0"></input></label> <label>Cjei0:<input type="text" name="cjei0" value="8.11e-15"></input></label> <label>Vdei:<input type="text" name="vdei" value="0.95"></input></label> <label>Zei:<input type="text" name="zei" value="0.5"></input></label> <label>Ajei:<input type="text" name="ajei" value="1.8"></input></label> <label>Cjep0:<input type="text" name="cjep0" value="2.07e-15"></input></label> <label>Vdep:<input type="text" name="vdep" value="1.05"></input></label>  
			<label>Zep:<input type="text" name="zep" value="0.4"></input></label> <label>Ajep:<input type="text" name="ajep" value="2.4"></input></label> <label>Cjci0:<input type="text" name="cjci0" value="1.16e-15"></input></label> <label>Vdci:<input type="text" name="vdci" value="0.8"></input></label> <label>Zci:<input type="text" name="zci" value="0.333"></input></label> <label>Vptci:<input type="text" name="vptci" value="46"></input></label> <label>Cjcx0:<input type="text" name="cjcx0" value="5.4e-15"></input></label> 
			<label>Vdcx:<input type="text" name="vdcx" value="0.7"></input></label> <label>Zcx:<input type="text" name="zcx" value="0.333"></input></label> <label>Vptcx:<input type="text" name="vptcx" value="100"></input></label> <label>Fbcpar:<input type="text" name="fbcpar" value="0.1526"></input></label> <label>Fbepar:<input type="text" name="fbepar" value="0.5"></input></label> <label>Cjs0:<input type="text" name="cjs0" value="0.0"></input></label> <label>Vds:<input type="text" name="vds" value="0.6"></input></label> <label>Zs:<input type="text" name="zs" value="0.447"></input></label> 
			<label>Vpts:<input type="text" name="vpts" value="100"></input></label> <label>T0:<input type="text" name="t0" value="4.75e-12"></input></label> <label>Dt0h:<input type="text" name="dt0h" value="2.1e-12"></input></label> <label>Tbvl:<input type="text" name="tbvl" value="4.0e-12"></input></label> <label>Tef0:<input type="text" name="tef0" value="1.8e-12"></input></label> <label>Gtfe:<input type="text" name="gtfe" value="1.4"></input></label> <label>Thcs:<input type="text" name="thcs" value="30.0e-12"></input></label> 
			<label>Ahc:<input type="text" name="ahc" value="0.75"></input></label> <label>Fthc:<input type="text" name="fthc" value="0.6"></input></label> <label>Rci0:<input type="text" name="rci0" value="127.8"></input></label> <label>Vlim:<input type="text" name="vlim" value="0.7"></input></label> <label>Vces:<input type="text" name="vces" value="0.1"></input></label> <label>Vpt:<input type="text" name="vpt" value="5"></input></label> <label>Cbepar:<input type="text" name="cbepar" value="1.13e-15"></input></label> <label>Cbcpar:<input type="text" name="cbcpar" value="2.97e-15"></input></label> 
			<label>Alqf:<input type="text" name="alqf" value="0.225"></input></label> <label>Alit:<input type="text" name="alit" value="0.45"></input></label> <label>Flnqs:<input type="text" name="flnqs" value="0.0"></input></label> <label>Kf:<input type="text" name="kf" value="1.43e-8"></input></label> <label>Af:<input type="text" name="af" value="2.0"></input></label> <label>Latb:<input type="text" name="latb" value="0.0"></input></label> <label>Latl:<input type="text" name="latl" value="0.0"></input></label> <label>Vgb:<input type="text" name="vgb" value="1.17"></input></label> 
			<label>Alt0:<input type="text" name="alt0" value="0.0"></input></label> <label>Kt0:<input type="text" name="kt0" value="0.0"></input></label> <label>Zetaci:<input type="text" name="zetaci" value="1.6"></input></label> <label>Alvs:<input type="text" name="alvs" value="1.0e-3"></input></label> <label>Alces:<input type="text" name="alces" value="0.4e-3"></input></label> <label>Zetarbi:<input type="text" name="zetarbi" value="0.588"></input></label> <label>Zetarbx:<input type="text" name="zetarbx" value="0.206"></input></label> 
			<label>Zetarcx:<input type="text" name="zetarcx" value="0.223"></input></label> <label>Zetare:<input type="text" name="zetare" value="0.0"></input></label> <label>Zetacx:<input type="text" name="zetacx" value="2.2"></input></label> <label>Vge:<input type="text" name="vge" value="1.1386"></input></label> <label>Vgc:<input type="text" name="vgc" value="1.1143"></input></label> <label>Vgs:<input type="text" name="vgs" value="1.15"></input></label> <label>F1vg:<input type="text" name="f1vg" value="-1.02377e-4"></input></label> 
			<label>F2vg:<input type="text" name="f2vg" value="4.3215e-4"></input></label> <label>Zetact:<input type="text" name="zetact" value="3.5"></input></label> <label>Zetabet:<input type="text" name="zetabet" value="4.0"></input></label> <label>Flsh:<input type="text" name="flsh" value="2.0"></input></label> <label>Rth:<input type="text" name="rth" value="1000.0"></input></label> <label>Cth:<input type="text" name="cth" value="1.0e-10"></input></label> <label>Tnom:<input type="text" name="tnom" value="27.0"></input></label> <label>Dt:<input type="text" name="dt" value="0.0"></input></label>
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
			</tr>
			<tr>
				<td><label>Ivc:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="ivc"/></td>
				<td><input type="checkbox" name="output[log][]" value="ivc"/></td>
				<td colspan="2"><label>Ivb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="ivb"/></td>
				<td><input type="checkbox" name="output[log][]" value="ivb"/></td>
			</tr>		
		</table>
	<?php endblock(); ?>

<?php end_extend(); ?>
