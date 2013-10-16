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

$config['contacts_form']	=array(
              array(
                     'field'   => 'name',
                     'label'   => 'NAME*',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'aff',
                     'label'   => 'AFFILIATION',
                     'rules'   => ''
                  ),
               array(
                     'field'   => 'email',
                     'label'   => 'E-MAIL*',
                     'rules'   => 'required|valid_email'
                  ),   
               array(
                     'field'   => 'subject',
                     'label'   => 'SUBJECT',
                     'rules'   => ''
                  ),
			   array(
                     'field'   => 'msg',
                     'label'   => 'MESSAGE*',
                     'rules'   => 'required'
                  )
            );

?>
