* -- Netlist template

* --- Voltage Sources ---
{sources}
{name} {name} 0 {value}
{/sources}

* --- Transistor ---
{prefix}{iname}{suffix} {sources} {name} {/sources} {mname} {iparams} {name}={value} {/iparams}
.MODEL {mname} {type} {mparams} {name}={value} {/mparams}

* --- Transfer ---
.control

save all
save {outputs}

dc {varsources} {name} {init} {end} {step} {/varsources}

wrdata output {outputs}

.endc

.end