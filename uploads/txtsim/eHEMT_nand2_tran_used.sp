.TITLE My netlist
*
* The list is from i-mos.org.
* If you any question, please feel free to contact support@i-mos.org

* Circuit Definition
Z1_3 d1 in1 s1 eHEMT.n2
Z2_3 d2 in2 s2 eHEMT.n2
R vdd out 400
Rd1 out d1 20
Rs1 s1 a1 10
Rd2 a1 d2 20
Rs2 s2 0 10
Cload out 0 1p
* Rload out 0 100k

* Source Definition
vin1 in1 0 dc 0 pulse(0 2.5 2n 10n 10n 48n 100n)
* vin2 in2 0 dc 0 pulse(0 2.5 2n 10n 10n 140n 300n)
vin2 in2 0 dc 2.5
vdd vdd 0 2.5
	

* MODEL Definition

.MODEL eHEMT.n1 ganhemt dd=2.5e-8 di=0e-9 nd=4e24 u0=0.138 p1=0.5 p2=0.15 ax=1.2 esat=3e6 pp0=12 alxx=0.25 VOFF=-2.6 SCE=0.008
.MODEL eHEMT.n2 ganhemt dd=2.5e-8 di=0e-9 nd=4e24 u0=0.138 p1=0.5 p2=0.15 ax=1.2 esat=3e6 pp0=12 alxx=0.25 VOFF=0.75 SCE=0.008


* Analysis Definition
.tran 10n 300n

 
* Plot Definition
.PLOT v(in1) v(in2) v(out)


.end