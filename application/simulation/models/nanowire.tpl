*First simulation profile for nanowire -- WANG Hao 2012
* --- Voltage Sources ---
<?php
	$vd = 3; $vg = 1; $vs = 0; $vb = 0;
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
* nanowire(d, g, s, b)
mnw d g s b nwmodel Na=<?php echo $param["na"]; ?> tox=<?php echo $param["tox"]; ?> R=<?php echo $param["r"]; ?> L=<?php echo $param["l"]; ?>
.model nwmodel nanowire

* --- Transfer ---
.control
save @mnw[Ids] @mnw[gm] @mnw[gds] @mnw[Qs] @mnw[Qd] @mnw[Qg]
save @mnw[Csg] @mnw[Css] @mnw[Csd]
save @mnw[Cdg] @mnw[Cds] @mnw[Cdd]
save @mnw[Cgg] @mnw[Cgs] @mnw[Cgd]
save all

<?php
echo 'dc ' . $bias['v1']['type'] . ' ' . $bias['v1']['init'] . ' ' . $bias['v1']['end'] . ' ' . $bias['v1']['step'];
if (array_key_exists('v2', $bias)) {
	echo ' ' . $bias['v2']['type'] . ' ' . $bias['v2']['init'] . ' ' . $bias['v2']['end'] . ' ' . $bias['v2']['step'];
}
?>

wrdata output @mnw[Ids] @mnw[gm] @mnw[gds] @mnw[Qs] @mnw[Qd] @mnw[Qg] @mnw[Css] @mnw[Csd] @mnw[Csg] @mnw[Cds] @mnw[Cdd] @mnw[Cdg] @mnw[Cgs] @mnw[Cgd] @mnw[Cgg]

.endc

.end
