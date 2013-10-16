<?php extend('simulation/layout.php'); ?>

	<?php startblock('model_script'); ?>
		<script type="text/javascript">
			var graph_map = {
				ids:	{ column: 1, name: "Ids[A]"	},
				gm: 	{ column: 3, name: "Igs[A]" },
				gds: 	{ column: 5, name: "Gds[S]" },
				gmbs:	{ column: 7, name: "Gmbs[S]" },
				vdsat:	{ column: 9, name: "Vdsat[V]" },
				vth:	{ column: 11, name: "Vth[V]" },
				qs:		{ column: 13, name: "Qs[C]" },
				qd:		{ column: 15, name: "Qd[C]" },
				qb:		{ column: 17, name: "Qb[C]" },
				qg:		{ column: 19, name: "Qg[C]" },
				cgg: 	{ column: 21, name: "Cgg[F]"},
				cgb: 	{ column: 23, name: "Cgb[F]"},
				cgd: 	{ column: 25, name: "Cgd[F]"},
				cgs: 	{ column: 27, name: "Cgs[F]"},
				cbg: 	{ column: 29, name: "Cbg[F]"},
				cbb: 	{ column: 31, name: "Cbb[F]"},
				cbd: 	{ column: 33, name: "Cbd[F]"},
				cbs: 	{ column: 35, name: "Cbs[F]"},
				cdg: 	{ column: 37, name: "Cdg[F]"},
				cdb: 	{ column: 39, name: "Cdb[F]"},
				cdd: 	{ column: 41, name: "Cdd[F]"},
				cds: 	{ column: 43, name: "Cds[F]"},
				csg: 	{ column: 45, name: "Csg[F]"},
				csb: 	{ column: 47, name: "Csb[F]"},
				csd: 	{ column: 49, name: "Csd[F]"},
				css: 	{ column: 51, name: "Css[F]"}
			};
		</script>
	<?php endblock(); ?>

	<?php startblock('model_description'); ?>
		<h2>BSIM4 model<sup>[1][2]</sup></h2>
		<p>
			Authors: UC Berkeley Device Group
			<br/>Organization: UC Berkeley
			<br/>Source code: <a href="http://www-device.eecs.berkeley.edu/bsim/?page=BSIM4">http://www-device.eecs.berkeley.edu/bsim/?page=BSIM4</a>
			<br/>Version: 4.6.5
		</p>
		<h4>Description</h4>	
		<div class="structure-figure">
			<img src="<?php echo base_url('images/simulation/bsim4.png');?>" />
		</div>		
		<div class="details">			
			<p>
				BSIM4 is a physics-based bulk MOSFET model for sub-100nm nodes. It is one of the BSIM series models by the UC Berkeley BSIM Research Group firstly released in 2000 and then approved by the CMC (Compact Model Council) as an open standard model. It has been widely used in the semiconductor industry from 0.13 um to 22 nm technology nodes. A detailed introduction and technical manual can be found on the BSIM Research Group webpage [2].
			</p>
		</div>
		<h4>References</h4>
		<div class="reference">
			<p>
				[1] Tanvir Hasan Morshed, Darsen D. Lu, Wenwei (Morgan) Yang, Mohan V. Dunga, Xuemei (Jane) Xi, Jin He, Weidong Liu, Kanyu, M. Cao, Xiaodong Jin, Jeff J. Ou, Mansun Chan, Ali M. Niknejad, and C. Hu, "BSIM4v4.7 MOSFET model," University of California, Berkeley, 2011.<br/>
				[2] <a href="http://www-device.eecs.berkeley.edu/bsim/?page=BSIM4">http://www-device.eecs.berkeley.edu/bsim/?page=BSIM4</a>
			</p>
		</div>
	<?php endblock(); ?>
	
	<?php startblock('model_params'); ?>
		<ul>
			<li><a href="#instance_param">Instance parameters</a></li>
			<li><a href="#model_param">Model parameters</a></li>
		</ul>
			
		<div id="instance_param" class="clearfix">	
			<label>L (Length) [m]:
				<input size="4" type="text" name="l" value="0.09e-6"/>
			</label>
			
			<label>W (Width) [m]:
				<input size="4" type="text" name="w" value="10e-6"/>
			</label>
			
			<label>NF (Number of device fingers):
				<input size="4" type="text" name="nf" value="5"/>
			</label>		
		</div>	
	
		<div id="model_param" class="clearfix">		
			<?php $this->load->view('simulation/bsim4_model_params'); ?>
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
				<td colspan="2"><label>Vdsat:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="vdsat"/></td>
				<td><input type="checkbox" name="output[log][]" value="vdsat"/></td>
				<td colspan="2"><label>Vth:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="vth"/></td>
				<td><input type="checkbox" name="output[log][]" value="vth"/></td>
			</tr>
			<tr>
				<td><label>Gm:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="gm"/></td>
				<td><input type="checkbox" name="output[log][]" value="gm"/></td>
				<td colspan="2"><label>Gds:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="gds"/></td>
				<td><input type="checkbox" name="output[log][]" value="gds"/></td>
				<td colspan="2"><label>Gmbs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="gmbs"/></td>
				<td><input type="checkbox" name="output[log][]" value="gmbs"/></td>
			</tr>
			<tr></tr>
			<tr>
				<td><label>Cgg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgg"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgg"/></td>
				<td colspan="2"><label>Cbg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cbg"/></td>
				<td><input type="checkbox" name="output[log][]" value="cbg"/></td>
				<td colspan="2"><label>Cdg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cdg"/></td>
				<td><input type="checkbox" name="output[log][]" value="cdg"/></td>
			</tr>
			<tr>
				<td><label>Cgb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgb"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgb"/></td>
				<td colspan="2"><label>Cbb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cbb"/></td>
				<td><input type="checkbox" name="output[log][]" value="cbb"/></td>
				<td colspan="2"><label>Cdb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cdb"/></td>
				<td><input type="checkbox" name="output[log][]" value="cdb"/></td>
			</tr>		
			<tr>
				<td><label>Cgd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgd"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgd"/></td>
				<td colspan="2"><label>Cbd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cbd"/></td>
				<td><input type="checkbox" name="output[log][]" value="cbd"/></td>
				<td colspan="2"><label>Cdd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cdd"/></td>
				<td><input type="checkbox" name="output[log][]" value="cdd"/></td>
			</tr>	
			<tr>
				<td><label>Cgs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgs"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgs"/></td>
				<td colspan="2"><label>Cbs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cbs"/></td>
				<td><input type="checkbox" name="output[log][]" value="cbs"/></td>
				<td colspan="2"><label>Cds:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cds"/></td>
				<td><input type="checkbox" name="output[log][]" value="cds"/></td>
			</tr>	
			<tr></tr>			
			<tr>
				<td><label>Csg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="csg"/></td>
				<td><input type="checkbox" name="output[log][]" value="csg"/></td>
				<td colspan="2"><label>Qg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qg"/></td>
				<td><input type="checkbox" name="output[log][]" value="qg"/></td>
			</tr>
			<tr>
				<td><label>Csb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="csb"/></td>
				<td><input type="checkbox" name="output[log][]" value="csb"/></td>
				<td colspan="2"><label>Qb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qb"/></td>
				<td><input type="checkbox" name="output[log][]" value="qb"/></td>
			</tr>		
			<tr>
				<td><label>Csd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="csd"/></td>
				<td><input type="checkbox" name="output[log][]" value="csd"/></td>
				<td colspan="2"><label>Qd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qd"/></td>
				<td><input type="checkbox" name="output[log][]" value="qd"/></td>
			</tr>	
			<tr>
				<td><label>Css:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="css"/></td>
				<td><input type="checkbox" name="output[log][]" value="css"/></td>
				<td colspan="2"><label>Qs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qs"/></td>
				<td><input type="checkbox" name="output[log][]" value="qs"/></td>
			</tr>				
		</table>
	<?php endblock(); ?>

<?php end_extend(); ?>
