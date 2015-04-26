.TITLE My netlist
*
* The list is from i-mos.org.
* If you any question, please feel free to contact support@i-mos.org

* Circuit Definition
<?php echo $netlist?>


* Source Definition
<?php echo $source?>


* MODEL Definition
<?php echo $modelCard?>

* Analysis Definition
<?php
	preg_match_all('/[^\n\r]+/m',$analyses,$vals);
	//var_dump($vals);
	foreach ($vals[0] as $value){
		if (substr($value, 0, 1) === "."){
			echo $value."\n";
		} else {
			echo '.'.$value."\n";
		}
	}
?>

 
* Plot Definition
<?php
	$vals = preg_split('/$\R?^/m',$outvar);
	foreach ($vals as $value){
		echo '.PLOT '.$value."\n";
	}
?>

.end
