<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Return a formatted date range given 2 Unix timestamps
 */
function date_range($start, $end) {	
	$t1 = getdate($start);
	$t2 = getdate($end);
	
	if ($t1['year'] == $t2['year']) {
		if ($t1['mon'] == $t2['mon']) {
			if ($t1['mday'] == $t2['mday']) {
				return date('d M Y', $start);
			} else {
				return date('d', $start) . ' - ' . date('d', $end) . ' ' . date('M', $start) . ' ' . $t1['year'];
			}
		} else {
			return date('d M', $start) . ' - ' . date('d M', $end) . ' ' . $t1['year'];
		}
	} else {
		return date('d M Y', $start) . ' - ' . date('d M Y', $end);
	}
}

?>
