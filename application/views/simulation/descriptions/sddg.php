<h2>Symmetric Doped Double-Gate MOSFET model for double-gate MOSFETs and FinFETs<sup>[1]</sup></h2>
<p>Authors: Antonio Cerdeira<sup>1</sup>, Magali Estrada<sup>1</sup>, Joaquín Alvarado<sup>2</sup>,  Benjamín Iñiguez<sup>3</sup>
<br>Organization: <sup>1</sup>CINVESTAV, D.F., Mexico; <sup>2</sup>BUAP, Puebla, México; <sup>3</sup>URV, Tarragona, Spain
<br>Contact: <a href="mailto:eemuthu@ust.hk">eemuthu@ust.hk</a></p>
<h4>Introduction</h4>			
<div class="details">
	<div class="structure-figure">
		<img src="<?php echo base_url('images/simulation/symdg.png');?>" />
	</div>			
	<p>The Symmetric Doped Double-Gate MOSFET model (SDDGM) is an analytical compact model for Double-Gate MOSFETs and FinFETs, SOI or Bulk. It was validated for silicon layer concentrations from 10<sup>14</sup> and 3 x 10<sup>18</sup> cm-3, silicon thickness from 15 to 50 nm and EOT from 1 to 5 nm. This is a charge based model totally analytical and it was implemented in Verilog-A. The mobile charge density is calculated using analytical expressions obtained from modeling the surface potential and the difference of potentials at the surface and at the center of the Si doped layer without the need to solve any transcendental equations. Analytical expressions for the current–voltage characteristics are presented, as function of silicon layer impurity concentration, gate dielectric and silicon layer thickness, including variable mobility. The short channel effects included are velocity saturation, DIBL, VT roll-off, channel length shortening and series resistance. Some basic articles about SDDGM are referenced.
	</p>
</div>
<h4>References</h4>
<div class="reference clear">
	<p>
		[1]	A. Cerdeira, O. Moldovan, B. Iñiguez and M. Estrada, “Modeling of potentials and threshold voltage for symmetric doped double-gate MOSFETs”, Solid-State Electronics, 52 (2008) 830-837.
		<a href="http://dx.doi.org/10.1016/j.sse.2007.10.046" target="_blank">(link)</a>
	</p>
    <p>	
		[2] Cerdeira A, Iñiguez B, Estrada M. “Compact model for short channel symmetric doped double-gate MOSFETs” Solid-State Electronics 2008; 52: 1064-1070
		<a href="http://dx.doi.org/10.1016/j.sse.2008.03.009" target="_blank">(link)</a>
	</p>
	<p>
		[3]	J. Alvarado, B. Iñiguez, M. Estrada, D. Flandre and A. Cerdeira, “Implementation of the symmetric doped double-gate MOSFET model in Verilog-A for circuit simulation”, Int. J. Numer. Model. 2010: 23: 88-106.
		<a href="http://onlinelibrary.wiley.com/doi/10.1002/jnm.725/pdf" target="_blank">(link)</a>
	</p>
	<p>
		[4]	A. Cerdeira, I. Garduño, J. Tinoco, R. Ritzenthaler, J. Franco, M. Togo, T. Chiarella, C. Claeys, “Charge based DC compact modeling of bulk FinFET transistor”, Solid-State Electronics 87 (2013) 11-16.
		<a href="http://dx.doi.org/10.1016/j.sse.2013.04.028" target="_blank">(link)</a>
	</p>
	<p>
		[5]	Ghader Darbandy, Thomas Gneiting, Heidrum Alius, Joaquín Alvarado, Antonio Cerdeira and Benjamín Iñiguez, “Automatic parameter extraction techniques in IC-CAP for a compact double gate MOSFET model”, Semicond. Sci. Technol. 28 (2013) 055014 (1-8).
		<a href="http://iopscience.iop.org/0268-1242/28/5/055014" target="_blank">(link)</a>
	</p>
</div>
