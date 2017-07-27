.TITLE My netlist
*
* The list is from i-mos.org.
* If you any question, please feel free to contact support@i-mos.org

* Circuit Definition
<?php echo $netlist?>


* Source Definition
<?php echo $source?>


* MODEL Definition
<?php
    /* Commented by Leon @ 20170510
	preg_match_all('/[^\n\r]+/m',$setup,$vals);
	//var_dump($vals);
	$result = "";
	foreach ($vals[0] as $value){
		if (substr($value, 0, 1) === "."){
			$result = $result.($value."");
		} else {
			$result = $result.($value."");
		}
	}
    */
    // Added by Leon @ 20170505
    $result = "BTI=" . $bti . " " .
                "HCI=" . $hci . " " .
                "TCYC=" . $tcyc . "n " .
                "AGEPERNUM=" . (10 * $np / $tpre) . " " .
                "STRFEDB=1 AGEXT=1 AGEXTMODE=1"; // These three value are fixed
    // Added end
	$strlen = strlen($modelCard) ;
	$temp = $modelCard ;
	$last_pos = 0 ;
	for( $i = 0; $i <= $strlen; $i++ ) {
		$char = substr( $modelCard, $i, 1 );
		if ($char == "\n") {
			echo substr($temp, $last_pos, $i-$last_pos).(' '.$result);
			echo "\n\n\n";
			$last_pos = $i + 1;
		}
	}


?>
<?php echo "\n"?>

* Analysis Definition
<?php
/*
	preg_match_all('/[^\n\r]+/m',$analyses,$vals);
	//var_dump($vals);
	foreach ($vals[0] as $value){
		if (substr($value, 0, 1) === "."){
			echo $value."\n";
		} else {
			echo '.'.$value."\n";
		}
	}
*/
    // Modified by Leon @ 20170505
    $tstop = $tcyc * $np + 1;
    echo ".tran " . $tstep . "n " . $tstop . "n\n";
?>

.CONTROL
save all

<?php
	// * Plot Definition  should be put before the <?php of the line above
	// $vals = preg_split('/$\R?^/m',$outvar);
	// foreach ($vals as $value){
	// 	echo '.PLOT '.$value."\n";
	// }
	$vals = preg_split('/$\R?^/m',$outvar);
	foreach ($vals as $value){
		echo 'save '.$value."\n";
	}
	echo 'run'."\n";
	$a = 0 ;
	foreach ($vals as $value) {
		echo 'wrdata output'.$a.'.data '.$value."\n" ;
		$a += 1 ;
	}
?>
.endc

.end
