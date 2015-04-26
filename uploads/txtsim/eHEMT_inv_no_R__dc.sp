.TITLE My netlist
*
* The list is from i-mos.org.
* If you any question, please feel free to contact support@i-mos.org

* Circuit Definition
Z1_3 d1 g1 out eHEMT.n1  
Z2_3 out in 0 eHEMT.n2 
R g1 out 0
Cload out 0 5p

* Source Definition
vin in 0 2.5
vdd d1 0 2.5
	

* MODEL Definition

.MODEL eHEMT.n1 ganhemt dd=1.75e-8 di=0e-9 nd=4e24 u0=0.103578 p1=0.124501 p2=0.084895 ax=2.293184 esat=186.860500e5 pp0=2.71151 alxx=0.26 VOFF=-2.6
.MODEL eHEMT.n2 ganhemt dd=1.75e-8 di=0e-9 nd=4e24 u0=0.103578 p1=0.124501 p2=0.084895 ax=2.293184 esat=186.860500e5 pp0=2.71151 alxx=0.26 VOFF=0.75

* Analysis Definition
.dc vin 0 10 0.01

 
* Plot Definition
.PLOT v(in) 
.PLOT v(out)

.end