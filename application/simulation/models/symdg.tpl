*First simulation profile for symdg -- WANG Hao 2012
* --- Voltage Sources ---
vd d 0 3
vg g 0 1
vs s 0 0
vb b 0 0

* --- Transistor ---
* symdg(d, g, s, b)

.model dgmodel symdg {model_params}

msymdg vd vg vs vb dgmodel {instance_params}


* --- Transfer ---
.control

{simulate}
{output}

save (i(vs)) @msymdg[Qs] @msymdg[Qd] @msymdg[gm] @msymdg[gds]
save all

wrdata output (i(vs)) @msymdg[Qs] @msymdg[qd] @msymdg[gm] @msymdg[gds]

.endc

.end
