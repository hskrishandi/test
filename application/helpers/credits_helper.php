<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

get_instance()->config->load('credits');
function credits_icons() {	
	$CI =& get_instance();	
	return $CI->config->item('credits_icons');
}

?>
