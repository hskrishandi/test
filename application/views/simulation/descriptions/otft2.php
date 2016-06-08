<h2>Organic Thin-Film Transistors(3-terminal)</sup></h2>
<p>Authors:Ognian Marinov, M. J. Deen
<br>Organization: McMaster University, Hamilton, ON, Canada
<br>Source code: <a href="https://nanohub.org/publications/63/1" target="_blank">
       Organic Thin-Film Transistors(3-terminal)</a>
<h4>Introduction</h4>			
<div class="details">
	<div class="structure-figure">
		<img src="<?php echo base_url('images/simulation/otft2.png');?>" />
		<img src="<?php echo base_url('images/simulation/otft2b.png');?>" />
	</div>			
	<p>The oTFT compact models are aimed to support the bias enhancement of the charge carrier mobility and the significant contact effect in organic thin-film transistors (OTFTs). 
	The oTFT compact model level 2 also supports other effects, such as channel conductance modulation (analogous to the channel length modulation in MOS transistors) and Ohmic and non-linear leakages.
    The distinct difference between TFT models and models for crystalline semiconductor field-effect transistors is that the mobility μ in TFT increases at higher bias as a power-law function
    </p>
    <p>
	<img src="<?php echo base_url('images/simulation/otft3eqt.png');?>" />
	</p>
	<p>
	where the mobility enhancement factor γ>0 (gamma in the oTFT compact model) is in the exponent of the power-law function, and μo is a known value of the mobility at given overdrive voltage Vγ.
	</p>
	<p> 
	The low-field mobility μo is denoted with “uo” in the oTFT compact model, and μo and Vγ are model parameters. 
	VG stands for gate bias voltage and the threshold voltage VT of the OTFT is also a parameter in the oTFT compact model.
	The oTFT model is a “mirror” of the OTFT structure as depicted in the figure. Conceptually, the oTFT model is arranged so that the sub-model components can be changed, replaced, removed or upgraded, as the needs evolve.
	The oTFT model is hierarchical. The top hierarchical level is module oTFT, in which there are “rails” for interconnection of the sub-models and instantiations of the sub-models between the rails. The “rails” are:
	</p>
	<p>
	1. Terminal nodes G, S and D for gate, source and drain, respectively. The oTFT model is connected in circuits by these nodes G, S and D;
	</p>
	<p>
	2. Intrinsic nodes GI, SI and DI. The semiconducting film of the OTFT is between SI and DI, and GI represents the interface of the gate dielectric with the gate conductor. 
	Contact resistances and other terminal effects (such as geometric capacitances) are placed between rails S-SI, D-DI and G-GI. 
	The intrinsic OTFT (semiconducting film and gate dielectric) is placed between the intrinsic nodes SI, DI, and GI;
	</p>
	<p>
	3.Control nodes GTS, GTD are conveying values of effective overdrive voltages. VGTS≈(VG−VT−VS) and VGTD≈(VG−VT−VD) are effective overdrive voltages at the source and drain ends of the intrinsic channel. 
    </p>
    <p>
	These VGTS, VGTD are generated by a model for effective overdrive voltage, and VGTS, VGTD control many sub-model components, including the TFT generic charge drift DC model and the quasi-static charge model. 
	VG, VS and VD are the potentials of the intrinsic nodes GI, SI, DI, and VT is the threshold voltage of the OTFT. 
	The use of the control “rail” GTS, GTD makes the oTFT model symmetric and independent of the reference potential of electrical ground.
	The adoption of the above three “rails” provides advantages and convenience. For example, one clearly identifies sub-models for channel or for contacts, 
	and can easily replace a sub-model (or even ignore it in simplifications during experimental characterizations), without destructing the behavior of the oTFT model. 
	The “rails” also allow the sub-models to be simple, well related to physical interpretations and minimizes the number of model parameters and interferences between parameters. 
	In fact, the oTFT model is a circuit with manageable components, instead of fixed “rigid” template of characteristic equations.
	The oTFT model is based on several publications on DC and quasi-static compact modeling of organic thin-film transistors (OTFTs). 
    </p>
    <p>
	This implementation is coded in Verilog-A and can be regarded as level 2 of the oTFT compact models. The version of the model is oTFT 2.04.01
	The Verilog-A code of the oTFT model and user manual for its use are available in [7]
	</p>
</div>
<h4>References</h4>
<div class="reference clear">
	<p>
		[1]	O. Marinov, M. J. Deen, U. Zschieschang, H. Klauk, "Organic Thin-Film Transistors: Part I-Compact DC Modeling", IEEE Trans. Electron Devices, 56(12), 2952-2961, 2009 ; DOI: 10.1109/TED.2009.2033308
	</p>
    <p>	
		[2]M. J. Deen, O. Marinov, U. Zschieschang, H. Klauk, "Organic Thin-Film Transistors: Part II-Parameter Extraction", IEEE Trans. Electron Devices, 56(12), 2962-2968, 2009 ; DOI: 10.1109/TED.2009.2033309
	</p>
	<p>
		[3]	O. Marinov, M. J. Deen, J. Tejada, B. Iniguez, "Impact of the Fringing Capacitance at the Back of Thin-Film Transistors", Organic Electronics, 12(6), 936-949, 2011 ; DOI: 10.1016/j.orgel.2011.02.020
	</p>
	<p>
		[4]	O. Marinov, M. J. Deen, "Quasistatic Compact Modelling of Organic Thin-Film Transistors", Organic Electronics, 14(1), 295-311, 2013 ;  DOI: 10.1016/j.orgel.2012.10.031
	</p>
	<p>
		[5]	O. Marinov, M. J. Deen, C. Feng, Y. Wu, "Precise Parameter Extraction Technique for Organic Thin-Film Transistors Operating in the Linear Regime", Journal of Applied Physics, 115(3), 034506-1 to -10, 2014 ; DOI: 10.1063/1.4862043
	</p>
	<p>
		[6]	O. Marinov, "Compact Models for Organic Thin-Film Transistors: Similarities, Differences, and Principles and Philosophy behind the Models", unpublished reviews and derivations, 127 pages, 2010
	</p>
	<p>
		[7] O. Marinov, “Verilog-A Implementation of the Compact Model for Organic Thin-Film Transistors oTFT”, nanoHUB. June 2015; DOI: 10.4231/D3R785Q3B
	</p>
</div>
