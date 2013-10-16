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
				isub:	{ column: 13, name: "Isub[A]"},
				igidl:	{ column: 15, name: "Igidl[A]"},
				igisl:	{ column: 17, name: "Igisl[A]"},
				igcs:	{ column: 19, name: "Igcs[A]"},
				igcd:	{ column: 21, name: "Igcd[A]"},
				igs:	{ column: 23, name: "Igs[A]"},
				igd:	{ column: 25, name: "Igd[A]"},
				igb:	{ column: 27, name: "Igb[A]"},
				ibs:	{ column: 29, name: "Ibs[A]"},
				ibd:	{ column: 31, name: "Ibd[A]"},
				qs:		{ column: 33, name: "Qs[C]" },
				qd:		{ column: 35, name: "Qd[C]" },
				qb:		{ column: 37, name: "Qb[C]" },
				qg:		{ column: 39, name: "Qg[C]" },
				cgg: 	{ column: 41, name: "Cgg[F]"},
				cgd: 	{ column: 43, name: "Cgd[F]"},
				cgs: 	{ column: 45, name: "Cgs[F]"},
				cbg: 	{ column: 47, name: "Cbg[F]"},
				cbd: 	{ column: 49, name: "Cbd[F]"},
				cbs: 	{ column: 51, name: "Cbs[F]"},
				cdg: 	{ column: 53, name: "Cdg[F]"},
				cdd: 	{ column: 55, name: "Cdd[F]"},
				cds: 	{ column: 57, name: "Cds[F]"}
			};
		</script>
	<?php endblock(); ?>

	<?php startblock('model_description'); ?>
		<h2>BSIMSOI Model<sup>[1][2]</sup></h2>
		<p>
			Authors: UC Berkeley Device Group
			<br/>Organization: UC Berkeley
			<br/>Source code: <a href="http://www-device.eecs.berkeley.edu/bsim/?page=BSIMSOI">http://www-device.eecs.berkeley.edu/bsim/?page=BSIMSOI</a>
			<br/>Version: 4.3.1
		</p>
		<h4>Description</h4>	
		<div class="structure-figure">
			<img src="<?php echo base_url('images/simulation/bsimsoi.png');?>" />
		</div>		
		<div class="details">			
			<p>
				BSIMSOI is a compact model for SOI (Silicon-On-Insulator) MOSFET circuit design. It is one of the BSIM series models by the UC Berkeley BSIM Research Group. In December 2001, BSIMSOI is selected by the CMC (Compact Model Council) as the standard SOI MOSFET model. A detailed introduction and technical manual can be found on the BSIM Research Group webpage [2].
			</p>
		</div>
		<h4>References</h4>
		<div class="reference">
			<p>
				[1] BSIM group, "BSIMSOIv4.3.1 MOSFET Model Users' Manual," University of California, Berkeley, 2010.
				<br/>[2] <a href="http://www-device.eecs.berkeley.edu/bsim/?page=BSIMSOI">http://www-device.eecs.berkeley.edu/bsim/?page=BSIMSOI</a>
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
			<?php $this->load->view('simulation/bsimsoi_model_params'); ?>
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
				<td><label>Isub:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="isub"/></td>
				<td><input type="checkbox" name="output[log][]" value="isub"/></td>
				<td colspan="2"><label>Igidl:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igidl"/></td>
				<td><input type="checkbox" name="output[log][]" value="igidl"/></td>
				<td colspan="2"><label>Igisl:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igisl"/></td>
				<td><input type="checkbox" name="output[log][]" value="igisl"/></td>
			</tr>
			<tr>
				<td><label>Igcs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igcs"/></td>
				<td><input type="checkbox" name="output[log][]" value="igcs"/></td>
				<td colspan="2"><label>Igcd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igcd"/></td>
				<td><input type="checkbox" name="output[log][]" value="igcd"/></td>				
			</tr>
			<tr></tr>
			<tr>
				<td ><label>Igs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igs"/></td>
				<td><input type="checkbox" name="output[log][]" value="igs"/></td>
				<td colspan="2"><label>Igd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igd"/></td>
				<td><input type="checkbox" name="output[log][]" value="igd"/></td>
				<td colspan="2"><label>Igb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="igb"/></td>
				<td><input type="checkbox" name="output[log][]" value="igb"/></td>
			</tr>
			<tr>
				<td><label>Ibs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="ibs"/></td>
				<td><input type="checkbox" name="output[log][]" value="ibs"/></td>
				<td colspan="2"><label>Ibd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="ibd"/></td>
				<td><input type="checkbox" name="output[log][]" value="ibd"/></td>
			</tr>
			<tr></tr>
			<tr>
				<td><label>Qs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qs"/></td>
				<td><input type="checkbox" name="output[log][]" value="qs"/></td>
				<td colspan="2"><label>Qd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qd"/></td>
				<td><input type="checkbox" name="output[log][]" value="qd"/></td>
			</tr>
			<tr>
				<td><label>Qb:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qb"/></td>
				<td><input type="checkbox" name="output[log][]" value="qb"/></td>
				<td colspan="2"><label>Qg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="qg"/></td>
				<td><input type="checkbox" name="output[log][]" value="qg"/></td>
			</tr>
			<tr></tr>
			<tr>
				<td><label>Cgg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgg"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgg"/></td>
				<td colspan="2"><label>Cgd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgd"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgd"/></td>
				<td colspan="2"><label>Cgs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cgs"/></td>
				<td><input type="checkbox" name="output[log][]" value="cgs"/></td>
			</tr>
			<tr>
				<td><label>Cbg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cbg"/></td>
				<td><input type="checkbox" name="output[log][]" value="cbg"/></td>
				<td colspan="2"><label>Cbd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cbd"/></td>
				<td><input type="checkbox" name="output[log][]" value="cbd"/></td>
				<td colspan="2"><label>Cbs:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cbs"/></td>
				<td><input type="checkbox" name="output[log][]" value="cbs"/></td>
			</tr>	
			<tr>
				<td><label>Cdg:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cdg"/></td>
				<td><input type="checkbox" name="output[log][]" value="cdg"/></td>
				<td colspan="2"><label>Cdd:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cdd"/></td>
				<td><input type="checkbox" name="output[log][]" value="cdd"/></td>
				<td colspan="2"><label>Cds:</label></td>
				<td><input type="checkbox" name="output[linear][]" value="cds"/></td>
				<td><input type="checkbox" name="output[log][]" value="cds"/></td>
			</tr>			
		</table>
	<?php endblock(); ?>

<?php end_extend(); ?>
