<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| Post experience page vaildation crtieria
|--------------------------------------------------------------------------
*/

$config['post_exp_form_config'] = array(
			   array(
					 'field'   => 'comment',
					 'label'   => 'Comment',
					 'rules'   => 'required'
				  ),
			   array(
					 'field'   => 'quote_auth',
					 'label'   => 'Checkbox',
					 'rules'   => 'required'
				  ),
			   array(
					 'field'   => 'contact_auth',
					 'label'   => 'Checkbox',
					 'rules'   => 'required'
				  )
			);

?>