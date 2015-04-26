<?php extend('simulation/layout.php'); ?>

	<?php startblock('model_script'); ?>
		<script type="text/javascript">
			var graph_map = {
				ids:	{ column: 1, name: "Ids[A]"	},
				igs: 	{ column: 3, name: "Igs[A]" },
				igd: 	{ column: 5, name: "Igd[A]" },
				qg:		{ column: 7, name: "Qg[C]" },
				qd:		{ column: 9, name: "Qd[C]" },
				qs:		{ column: 11, name: "Qs[C]" },
				qb:		{ column: 13, name: "Qb[C]" }
			};
		</script>
	<?php endblock(); ?>

	<?php startblock('model_description'); ?>
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
	<?php endblock(); ?>
	
	<?php startblock('model_params'); ?>
		<ul>
			<li><a href="#instance_param">Instance parameters</a></li>
			<li><a href="#model_param">Model parameters</a></li>
		</ul>
			
		<div id="instance_param" class="clearfix">
			<label>L (Gate length) [m]:
				<input size="4" type="text" name="l" value="30e-9"/>
			</label>
			
			<label>D (Diameter of cylinder) [m]:
				<input size="4" type="text" name="d" value="40e-9"/>
			</label>
			
			<label>TFIN (Fin thickness) [m]:
				<input size="4" type="text" name="tfin" value="15e-9"/>
			</label>
			
			<label>FPITCH (Fin pitch) [m]:
				<input size="4" type="text" name="fpitch" value="80e-9"/>
			</label>
			
			<label>NF (Number of fingers):
				<input size="4" type="text" name="nf" value="1"/>
			</label>
			
			<label>NFIN (Number of fins per finger):
				<input size="4" type="text" name="nfin" value="1"/>
			</label>
			
			<label>NGCON (Number of gate contacts):
				<select name="ngcon">
					<option value="1">1</option>
					<option value="2">2</option>
				</select>
			</label>			
		</div>	
	
		<div id="model_param" class="clearfix">			
			<label>Devtype:
				<select name="devtype">		
					<option value="1">NMOS</option>			
					<option value="0">PMOS</option>					
				</select>
			</label>	

			<label>Bulkmod:
				<select name="bulkmod">
					<option value="0">SOI substrate</option>
					<option value="1">bulk substrate</option>
				</select>
			</label>		

			<label>Geomod:
				<select name="geomod">
					<option value="0">double gate</option>
					<option value="1">triple gate</option>
					<option value="2">quadruple gate</option>
					<option value="3">cylindrical gate</option>
				</select>
			</label>

			<label>Igcmod:
				<select name="igcmod">		
					<option value="0">0</option>			
					<option value="1">1</option>					
				</select>
			</label>	

			<label>Igbmod:
				<select name="igbmod">		
					<option value="0">0</option>			
					<option value="1">1</option>					
				</select>
			</label>	

			<label>Agidl:<input type="text" name="agidl" value="2.729E-12"></input></label> <label>Aigc:<input type="text" name="aigc" value="0.0136"></input></label> <label>Alpha0:<input type="text" name="alpha0" value="0"></input></label> <label>Alpha1:<input type="text" name="alpha1" value="0"></input></label>
			<label>Beta0:<input type="text" name="beta0" value="0"></input></label> <label>Bg0sub:<input type="text" name="bg0sub" value="1.12"></input></label> <label>Bgidl:<input type="text" name="bgidl" value="3.557E+08"></input></label> <label>Bigc:<input type="text" name="bigc" value="0.00171"></input></label> <label>Bulkmod:<input type="text" name="bulkmod" value="1"></input></label> 
			<label>Cdsc:<input type="text" name="cdsc" value="0.400"></input></label> <label>Cdscd:<input type="text" name="cdscd" value="0.200"></input></label> <label>Cfs:<input type="text" name="cfs" value="2.56E-11"></input></label> <label>Cfd:<input type="text" name="cfd" value="2.56E-11"></input></label> <label>Cgeomod:<input type="text" name="cgeomod" value="0"></input></label>
			<label>Cgsl:<input type="text" name="cgsl" value="1.0e-10"></input></label> <label>Cgdl:<input type="text" name="cgdl" value="1.0e-10"></input></label> <label>Cigc:<input type="text" name="cigc" value="0.075"></input></label>  <label>Cit:<input type="text" name="cit" value="6.223E-05"></input></label> 
			<label>Deltaw:<input type="text" name="deltaw" value="0"></input></label>  <label>Deltawcv:<input type="text" name="deltawcv" value="0"></input></label>  <label>Dlc:<input type="text" name="dlc" value="0"></input></label> <label>Drout:<input type="text" name="drout" value="1E+06"></input></label> <label>Dsub:<input type="text" name="dsub" value="0.4381"></input></label> 
			<label>Dvt0:<input type="text" name="dvt0" value="0"></input></label> <label>Dvt1:<input type="text" name="dvt1" value="0.3"></input></label> <label>Easub:<input type="text" name="easub" value="4.05"></input></label> <label>Egidl:<input type="text" name="egidl" value="0.2492"></input></label> <label>Eot:<input type="text" name="eot" value="1.2E-09"></input></label> 
			<label>Epsrox:<input type="text" name="epsrox" value="3.9"></input></label> <label>Epsrsub:<input type="text" name="epsrsub" value="11.9"></input></label> <label>Eta0:<input type="text" name="eta0" value="150"></input></label> <label>Etamob:<input type="text" name="etamob" value="2"></input></label> <label>Etaqm:<input type="text" name="etaqm" value="0.01"></input></label> 
			<label>Eu:<input type="text" name="eu" value="0.8"></input></label> <label>Fech:<input type="text" name="fech" value="1"></input></label> <label>Fechcv:<input type="text" name="fechcv" value="1"></input></label> <label>Gidlmod:<input type="text" name="gidlmod" value="1"></input></label> <label>Hfin:<input type="text" name="hfin" value="3E-08"></input></label> 
			<label>K1rsce:<input type="text" name="k1rsce" value="0"></input></label> <label>Ksativ:<input type="text" name="ksativ" value="0.852"></input></label> <label>L:<input type="text" name="l" value="5.5E-08"></input></label> <label>Lint:<input type="text" name="lint" value="-2.6E-08"></input></label> 
			<label>Ll:<input type="text" name="ll" value="0"></input></label> <label>Llc:<input type="text" name="llc" value="0"></input></label> <label>Lln:<input type="text" name="lln" value="1"></input></label> <label>Lpe0:<input type="text" name="lpe0" value="1E-08"></input></label> <label>Mexp:<input type="text" name="mexp" value="3.0"></input></label> <label>Nbody:<input type="text" name="nbody" value="1E+22"></input></label> 
			<label>Nc0sub:<input type="text" name="nc0sub" value="2.86E+25"></input></label> <label>Ngate:<input type="text" name="ngate" value="0"></input></label> <label>Ni0sub:<input type="text" name="ni0sub" value="1.1E+16"></input></label> <label>Nigc:<input type="text" name="nigc" value="1"></input></label> 
			<label>Nsd:<input type="text" name="nsd" value="2E+26"></input></label> <label>Pdibl1:<input type="text" name="pdibl1" value="1E-15"></input></label> <label>Pdibl2:<input type="text" name="pdibl2" value="1E-15"></input></label> <label>Phig:<input type="text" name="phig" value="4.61"></input></label>
			<label>Phin:<input type="text" name="phin" value="0.05"></input></label> <label>Pclm:<input type="text" name="pclm" value="0.00358"></input></label> <label>Pclmg:<input type="text" name="pclmg" value="1.205"></input></label> <label>Prwg:<input type="text" name="prwg" value="0"></input></label> <label>Ptwg:<input type="text" name="ptwg" value="0.1"></input></label> 
			<label>Pvag:<input type="text" name="pvag" value="0.0879"></input></label> <label>Qm0:<input type="text" name="qm0" value="0.1143"></input></label> <label>Qmfactor:<input type="text" name="qmfactor" value="0"></input></label> <label>Rdsmod:<input type="text" name="rdsmod" value="0"></input></label> <label>Rdsw:<input type="text" name="rdsw" value="15"></input></label> 
			<label>Rdswmin:<input type="text" name="rdswmin" value="95"></input></label> <label>Tfin:<input type="text" name="tfin" value="1E-08"></input></label> <label>Tnom:<input type="text" name="tnom" value="27.0"></input></label> <label>Toxp:<input type="text" name="toxp" value="1.5e-9"></input></label> <label>U0:<input type="text" name="u0" value="0.07066"></input></label> 
			<label>Ua:<input type="text" name="ua" value="0"></input></label> <label>Ucs:<input type="text" name="ucs" value="1.0"></input></label> <label>Ud:<input type="text" name="ud" value="1.0"></input></label> <label>Up:<input type="text" name="up" value="0"></input></label> <label>Vasat:<input type="text" name="vasat" value="10"></input></label> <label>Vsat:<input type="text" name="vsat" value="1.126E+05"></input></label> 
			<label>Wr:<input type="text" name="wr" value="1"></input></label> <label>Xl:<input type="text" name="xl" value="4E-08"></input></label> 			
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
				<td colspan="2"><label>Igs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igs"/></td>
				<td><input type="checkbox" name="output[log][]" value="igs"/></td>
				<td colspan="2"><label>Igd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igd"/></td>
				<td><input type="checkbox" name="output[log][]" value="igd"/></td>
			</tr>
			<tr>
				<td><label>Qg:</label></td>
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
				<td colspan="2"><label>Qb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qb"/></td>
				<td><input type="checkbox" name="output[log][]" value="qb"/></td>
			</tr>				
		</table>
	<?php endblock(); ?>

<?php end_extend(); ?>
