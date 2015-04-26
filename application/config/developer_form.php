<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| contacts_form defines
|--------------------------------------------------------------------------
|
| These options are used by the resources pages for display
|
*/



/*
|--------------------------------------------------------------------------
| Article types
|--------------------------------------------------------------------------
|
| All the types available for articles
|
*/

$config['developer_form']	= array(
	'text_rule' => array(
		'step1' => array(
						array(
									 'field'   => 'title',
									 'label'   => '',
									 'rules'   => 'required'
								),
						array(
									 'field'   => 'author_list',
									 'label'   => '',
									 'rules'   => 'required'
								),
						array(
									 'field'   => 'organization',
									 'label'   => '',
									 'rules'   => 'required'
								),
						array(
									 'field'   => 'contact',
									 'label'   => '',
									 'rules'   => 'required'
								),   
						array(
									 'field'   => 'description',
									 'label'   => '',
									 'rules'   => 'required'
								),
						array(
									 'field'   => 'structure',
									 'label'   => '',
									 'rules'   => ''
								),
						array(
									 'field'   => 'reference',
									 'label'   => '',
									 'rules'   => 'required'
								)
						),
			'step2' => array(
						array(
									 'field'   => 'is_author',
									 'label'   => '',
									 'rules'   => 'required'
								),
						array(
									 'field'   => 'has_tested',
									 'label'   => '',
									 'rules'   => 'required'
								),
						array(
									 'field'   => 'pre_simulator',
									 'label'   => '',
									 'rules'   => 'required'
								),
						array(
									 'field'   => 'model_code',
									 'label'   => '',
									 'rules'   => ''
								)
						),
			'step3' => array(
				array(
									 'field'   => 'parameter_list',
									 'label'   => '',
									 'rules'   => ''
								),
				array(
									 'field'   => 'output_list',
									 'label'   => '',
									 'rules'   => ''
								)
				),
			'step4' => array()
			),
		'file_rule' => array(
			'step1' => array(
				array(
									 'field'   => 'structure',
									 'rules'   => 'required'
								)
			),
			'step2' => array(
				array(
									 'field'   => 'model_code',
									 'rules'   => 'required'
								)
			),
			'step3' => array(
				array(
									 'field'   => 'parameter_list',
									 'rules'   => 'required'
								),
				array(
									 'field'   => 'output_list',
									 'rules'   => 'required'
								)
			),
			'step4' => array()
		)
	);

?>
