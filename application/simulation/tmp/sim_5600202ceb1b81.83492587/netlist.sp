* -- Netlist template

* --- Voltage Sources ---

Vd Vd 0 0

Vg Vg 0 0

Vs Vs 0 0

Vb Vb 0 0


* --- Transistor ---
motft2  Vd  Vg  Vs  Vb  otft2  np=1  W=100e-6  L=10e-6 
.MODEL otft2 otft2  eBov=1  LOV=3e-5  selectQS=1  RBS=1e+13  VTL=0  eBleak=0.5  eB=2  nSCLC=4  RGmin=1  nIC=0.75  ICmax=1e-9  RCmax=3e+5  RC=1e+5  VSS=1  Vgamma=1  gamma=0.6  uo=1e-5  VT=0  CI=0.00035 

* --- Transfer ---
.control

save all
save  i(vs) 

dc  Vd 0 1 0.1 

wrdata output  i(vs) 

.endc

.end