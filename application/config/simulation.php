<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| Simulation config
|--------------------------------------------------------------------------
*/

$config['backend_url'] = "http://www.i-mos.org:8080/";

$config['ngspice'] = "/local/simulation/ngspicebin/bin/ngspice";
$config['realcas'] = "/local/simulation/realcasbin/bin/ngspice";


/**
 * HCI and BTI output file name, locate @ /local/html/tmp/ngspicexxxx.xxxx/
 *
 * @author Leon @ 20170513
 */
$config['hci'] = "hci.output";
$config['bti'] = "bti.output";


?>
