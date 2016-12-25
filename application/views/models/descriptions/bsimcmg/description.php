<p>BSIM-CMG is a physical surface-potential-based compact model for multi-gate FETs. All the important effects are captured including volume inversion effect, short channel effects (SCE), and multi-gate electrostatic control effect. A detailed introduction
    and technical manual can be found on the BSIM GROUP webpage[3]. BSIM-CMG is officially released in Verilog-A. The i-MOS online version is based on the Verilog-A code version 106.0.0 with some simplifications:</p>
<ol>
    <li>Self-heating turned off. (SHMOD=0)</li>
    <li>External source/drain resistance model turned off. (RDSMOD=0)</li>
    <li>NQS model turned off. (NQSMOD=0)</li>
    <li>Gate resistance /ge node turned off. (RGATEMOD=0)</li>
</ol>
