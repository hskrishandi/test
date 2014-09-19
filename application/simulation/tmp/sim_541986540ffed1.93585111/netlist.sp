* -- Netlist template

* --- Voltage Sources ---

Vd Vd 0 0

Vg Vg 0 1

Vs Vs 0 0

Vb Vb 0 0


* --- Transistor ---
motft  Vd  Vg  Vs  Vb  otft  W=200e-6  L=50e-6 
.MODEL otft otft  CCt=3.5e9  RC0=1e13  ETAG=0.25  ETAD=0.25  IOS=5.144e-9  QS=0.4  DVS=2  SS=3  IOL=1.006e-10  QL=0.4  DVL=2  SL=3  VT0=2.711  VAA=1.634e3  V0=0.04  TOX=3.70e-7  TNOM=27  RS=1.474e4  RD=1.474e4  M=1.475  LAMBDA=-1.3e-3  GAMMA=1.08  EPSI=2.6  EPS=6.5  ALPHASAT=0.572  TYPE=1 

* --- Transfer ---
.control

save all
save  i(vs) 

dc  Vd 0 1 0.1 

wrdata output  i(vs) 

.endc

.end