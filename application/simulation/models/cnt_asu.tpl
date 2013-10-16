* simulation profile for cnt_asu

* --- Voltage Sources ---
<?php
	$vd = 0.8; $vg = 0.8; $vs = 0; $vb = 0;
	$tmp = $bias['b1']['type'];
	$$tmp = $bias['b1']['value'];
	$tmp = $bias['b2']['type'];
	$$tmp = $bias['b2']['value'];
?>

vd d 0 <?php echo $vd; ?>

vg g 0 <?php echo $vg; ?>

vs s 0 <?php echo $vs; ?>

vb b 0 <?php echo $vb; ?>

* --- Transistor ---
mcnt d g s b CNT diameter=<?php echo $param["diameter"]; ?> angle=<?php echo $param["angle"]; ?> tins=<?php echo $param["tins"]; ?>
+ eins=<?php echo $param["eins"]; ?> tback=<?php echo $param["tback"]; ?> eback=<?php echo $param["eback"]; ?> types=<?php echo $param["types"]; ?> l=<?php echo $param["l"]; ?> 
.model CNT cnt_asu phisb=0.1 rs=0
+ rd=0 beta=16 Cc=7e-12 mob=1 Csubfit=0.4 Cp=40e-12

* --- Transfer ---
.control
save all
save @mcnt[gds] @mcnt[gm] 

<?php
echo 'dc ' . $bias['v1']['type'] . ' ' . $bias['v1']['init'] . ' ' . $bias['v1']['end'] . ' ' . $bias['v1']['step'];
if (array_key_exists('v2', $bias)) {
	echo ' ' . $bias['v2']['type'] . ' ' . $bias['v2']['init'] . ' ' . $bias['v2']['end'] . ' ' . $bias['v2']['step'];
}
?>

save (i(vs))
wrdata output (i(vs)) @mcnt[gds] @mcnt[gm]
.endc

.end
