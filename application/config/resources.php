<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| Resources Display Options
|--------------------------------------------------------------------------
|
| These options are used by the resources pages for display
|
*/

define('RESOURCE_INDEX_ENTRIES_PER_BLOCK',			5);
define('RESOURCE_ENTRIES_PER_PAGE',					100);		// should be enough
define('MAX_LINK_LENGTH',							90);


/*
|--------------------------------------------------------------------------
| Article types
|--------------------------------------------------------------------------
|
| All the types available for articles
|
*/
$config['article_types']	= array(
								'books' => 'Books',
								'journals' => 'Journals'									
							);
							
/*
|--------------------------------------------------------------------------
| Device model status
|--------------------------------------------------------------------------
|
| different status of a device model
|
*/
$config['device_model_status']	= array(
								'released' => 'Released Models',
								'developing' => 'Developing Models'									
							);
							
/*
|--------------------------------------------------------------------------
| Tool types
|--------------------------------------------------------------------------
|
| different categories of a tool
|
*/
$config['tool_type']	= array(
								'device_sim' => 'Device Simulators',
								'circuit_sim' => 'Circuit Simulators',
								'param_extract' => 'Model Parameter Extractors',
								'interface' => 'Others'
							);



?>