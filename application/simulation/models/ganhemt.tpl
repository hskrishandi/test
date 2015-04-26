*First simulation profile for ganhemt --xiaoxu 2012
* --- Voltage Sources ---
<?php
	$vd = 5; $vg = -2; $vs = 0;
	$tmp = $bias['b1']['type'];
	$$tmp = $bias['b1']['value'];
	$tmp = $bias['b2']['type'];
	$$tmp = $bias['b2']['value'];
?>

vd d 0 <?php echo $vd; ?>

vg g 0 <?php echo $vg; ?>

vs s 0 <?php echo $vs; ?>

z2_3 d g s n1

* --- Transistor ---
.model n1 nhfet level=9
+W=<?php echo $param["w"]; ?> L=<?php echo $param["lg"]; ?>
+DD=<?php echo $param["dd"]; ?> DI=<?php echo $param["di"]; ?>
+ND=<?php echo $param["nd"]; ?> U0=<?php echo $param["u0"]; ?>
+P1=<?php echo $param["p1"]; ?> P2=<?php echo $param["p2"]; ?>
+AX=<?php echo $param["ax"]; ?> ESAT=<?php echo $param["esat"]; ?>
+PP0=<?php echo $param["pp0"]; ?> ALXX=<?php echo $param["alxx"]; ?>
+SCE=0.0

* --- Transfer ---
.control
save @z2_3[ids] @z2_3[gds] @z2_3[gm] @z2_3[qs] @z2_3[qd] @z2_3[cdd] @z2_3[cgd] @z2_3[cdg] @z2_3[cgg]

<?php
echo 'dc ' . $bias['v1']['type'] . ' ' . $bias['v1']['init'] . ' ' . $bias['v1']['end'] . ' ' . $bias['v1']['step'];
if (array_key_exists('v2', $bias)) {			
	echo ' ' . $bias['v2']['type'] . ' ' . $bias['v2']['init'] . ' ' . $bias['v2']['end'] . ' ' . $bias['v2']['step'];
}
?>

wrdata output @z2_3[ids] @z2_3[gds] @z2_3[gm] @z2_3[qs] @z2_3[qd] @z2_3[cdd] @z2_3[cgd] @z2_3[cdg] @z2_3[cgg]
.endc
*
.end
