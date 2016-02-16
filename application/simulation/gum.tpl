* -- Netlist template

* --- Voltage Sources ---
{sources}
{name} {name} 0 dc={value}
{/sources}

* --- Controlled Sources ---
{ctrlsources}
{ctrlname} {bias} 0 {indsource} 0 {ctrlval}
{/ctrlsources}

* --- Transistor ---
{prefix}{iname}{suffix} {ctrlsources} {bias} {/ctrlsources} {mname} {iparams} {name}={value} {/iparams}
.MODEL {mname} {type} {mparams} {name}={value} {/mparams}

* --- Transfer ---
.control

save all
save {outputs}

dc {varsources} {name} {init} {end} {step} {/varsources}

wrdata output {outputs}

.endc

.end