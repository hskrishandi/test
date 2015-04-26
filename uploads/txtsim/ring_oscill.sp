.TITLE My netlist
*
* The list is from i-mos.org.
* If you any question, please feel free to contact support@i-mos.org

* Circuit Definition
*TITLE First inverter

*Cload out 0 0.3f
MN1 out in 0 0 eTuT.n16 L=0.016u W=0.064u
MP1 out in vsup vsup eTuT.p16 L=0.016u W=0.128u

*inv-2
MN2 out2 out 0 0 eTuT.n16 L=0.016u W=0.064u
MP2 out2 out vsup vsup eTuT.p16 L=0.016u W=0.128u

*inv-3
*MN3 in out2 0 0 eTuT.n16 L=0.016u W=0.064u
*MP3 in out2 vsup vsup eTuT.p16 L=0.016u W=0.128u

*.ic v(in)=0.4 v(out)=0 v(out2)=0.4

* Source Definition
vdd vsup 0 dc=0.4
vin in 0 dc 0 pulse 0.0 0.4 0 200p 200p 500p 1900p


* MODEL Definition
.MODEL eTuT.n16 tfet type=1 tox=0.67e-9 tsi=5.1e-9 akane=45.5e21 bkane=21e6 fern=12 wfg=4.1
.MODEL eTuT.p16 tfet type=-1 tox=0.67e-9 tsi=5.1e-9 akane=45.5e21 bkane=21e6 fern=12 wfg=5.17

* Analysis Definition
.tran 10p 10n

 
* Plot Definition
.PLOT v(out) v(in)
.PLOT v(out2) v(out)
.PLOT *v(out3) v(out2)

.end
