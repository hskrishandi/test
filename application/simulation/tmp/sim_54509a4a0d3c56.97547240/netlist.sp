* -- Netlist template

* --- Voltage Sources ---

Vd Vd 0 0

Vg Vg 0 0

Vs Vs 0 0

Vb Vb 0 0


* --- Transistor ---
mtfet  Vd  Vg  Vs  Vb  tfet  L=50e-9  W=1e-6 
.MODEL tfet tfet  Isrh=1.0e-7  Bkaned=21e6  Akaned=45.5e21  Bkanes=21e6  Akanes=45.5e21  Nd=1e20  Vbid=0.62  Ns=1e20  Vbis=-0.62  Vfb=-0.43  Fern=12  Tch=10e-9  Tox=2e-9  Type=1  Epsch=11.9  Nint=1.5e10  Eg=1.12 

* --- Transfer ---
.control

save all
save  i(vs) i(vd) i(vg) @mtfet[Qs] @mtfet[Qd] @mtfet[Qg] 

dc  Vd 0 1 0.1  Vd 0.8 1 0.1 

wrdata output  i(vs) i(vd) i(vg) @mtfet[Qs] @mtfet[Qd] @mtfet[Qg] 

.endc

.end