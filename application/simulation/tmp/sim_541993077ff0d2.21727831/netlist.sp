* -- Netlist template

* --- Voltage Sources ---

Vd Vd 0 0

Vg Vg 0 1

Vs Vs 0 0

Vb Vb 0 0


* --- Transistor ---
mmvsg  Vd  Vg  Vs  Vb  nmos  W=25e-6  L=105e-9 
.MODEL nmos nmos  betars=1.3  ndrs=0  vthetars=0.05  Srs=0.35  delta2rs=0.30  delta1rs=1.3  Cgrs=5.0e-7  VtOrs=-2.0  vxors=1.30e7  ndrd=0  vthetard=0.05  betard=1.3  zeta=0.0  Srd=0.35  Vdibsat=2.0  delta2rd=0.30  delta1rd=1.3  Cgrd=5.0e-7  VtOrd=-2.0  vxord=1.30e7  Tnom=27.0  Cth=0  Rth=10  Rc=0.0240  lamda=0  mtheta=0  vtheta=0.05  epsilon=2.3  vzeta=3e-3  Lgd=0.46e-6  Lgs=0.46e-6  mc=5e0  alpha=3.5  VtO=-3.2894  beta=1.5  mu0=1650  vxo=1.30e7  Cofdm=40e-12  Cofsm=40e-12  Cifm=110e-12  Rsh=200  nd=0.2  S=0.14  delta1=0.10  Cg=6.5e-7  version=1.00  type=1 

* --- Transfer ---
.control

save all
save  i(vs) @mmvsg[Qs] @mmvsg[Qd] @mmvsg[Qg] 

dc  Vd 0 1 0.1 

wrdata output  i(vs) @mmvsg[Qs] @mmvsg[Qd] @mmvsg[Qg] 

.endc

.end