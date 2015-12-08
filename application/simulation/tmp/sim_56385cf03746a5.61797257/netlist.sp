* -- Netlist template

* --- Voltage Sources ---

Vd Vd 0 0

Vg Vg 0 0

Vs Vs 0 0

Vb Vb 0 0


* --- Transistor ---
msymdg  Vd  Vg  Vs  Vb  symdg  W=1.0e-6  L=1.0e-7 
.MODEL symdg symdg  u0=400  Tsi=1.0e-8  Tox=1.2e-9  Type=1 

* --- Transfer ---
.control

save all
save  i(vs) @msymdg[Qs] @msymdg[Qd] @msymdg[Qg] 

dc  Vd 0 1 0.1  Vg 0 1 0.1 

wrdata output  i(vs) @msymdg[Qs] @msymdg[Qd] @msymdg[Qg] 

.endc

.end