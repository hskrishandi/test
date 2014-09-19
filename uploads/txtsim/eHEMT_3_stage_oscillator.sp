.TITLE My netlist
*
* The list is from i-mos.org.
* If you any question, please feel free to contact support@i-mos.org

* Circuit Definition
Z11_3 d11 out1 s11 eHEMT.n1 L=10e-6 W=1e-6
Z21_3 d21 out3 s21 eHEMT.n2 L=1e-6 W=1e-6
Rd11 vdd d11 2K
Rs11 s11 out1 1K
Rd21 out1 d21 2K
Rs21 s21 0 1K
Cload1 out1 0 200p

Z12_3 d12 out2 s12 eHEMT.n1 L=10e-6 W=1e-6
Z22_3 d22 out1 s22 eHEMT.n2 L=1e-6 W=1e-6
Rd12 vdd d12 2K
Rs12 s12 out2 1K
Rd22 out2 d22 2K
Rs22 s22 0 1K
Cload2 out2 0 200p

Z13_3 d13 out3 s13 eHEMT.n1 L=10e-6 W=1e-6
Z23_3 d23 out2 s23 eHEMT.n2 L=1e-6 W=1e-6
Rd13 vdd d13 2K
Rs13 s13 out3 1K
Rd23 out3 d23 2K
Rs23 s23 0 1K
Cload3 out3 0 200p


* Source Definition
.ic v(out3)=2.5
vdd vdd 0 2.5
	

* MODEL Definition

.MODEL eHEMT.n1 ganhemt dd=2.5e-8 di=0e-9 nd=4e24 u0=0.138 p1=0.5 p2=0.15 ax=1.2 esat=3e6 pp0=12 alxx=0.25 VOFF=-2.6 SCE=0.008
.MODEL eHEMT.n2 ganhemt dd=2.5e-8 di=0e-9 nd=4e24 u0=0.138 p1=0.5 p2=0.15 ax=1.2 esat=3e6 pp0=12 alxx=0.25 VOFF=0.75 SCE=0.008


* Analysis Definition
.tran 100n 100u uic


* Plot Definition
.PLOT v(out3)


.end