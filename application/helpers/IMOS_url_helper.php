<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

get_instance()->config->load('path');

/**
 * return the full url of a resource; can be css, script or image
*/
function resource_url($type, $file) {	
	$CI =& get_instance();	
	$type = strtolower($type);
	
	switch($type) {
	case 'css':
	case 'stylesheet':
		return base_url($CI->config->item('css_path') . $file);
	case 'js':
	case 'script':
		return base_url($CI->config->item('js_path') . $file);
	case 'img':
	case 'image':
		return base_url($CI->config->item('img_path') . $file);
	case 'user_img':
	case 'user_image':
		return base_url($CI->config->item('user_img_path') . $file);
	default:
		return base_url($file);
	}
}

/**
 * shorten a text to $length long and append '...'; useful for displaying long links 
*/
function strip_text($string, $length) {
	if (strlen($string) <= $length) {
		return $string;
	} else {
		return substr_replace($string , "...", $length);
	}
}

function imos_mark(){
	return '<span class="italic">i</span>-MOS';
}

?>
