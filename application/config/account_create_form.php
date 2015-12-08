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

$config['account_create_form']	=array(
              array(
                     'field'   => 'last_name',
                     'label'   => 'LAST NAME*:',
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'first_name',
                     'label'   => 'FIRST NAME*:',
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'displayname',
                     'label'   => 'DISPLAY NAME*:',
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'organization',
                     'label'   => 'COMPANY*:',
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'position',
                     'label'   => 'POSITION TITLE',
                     'rules'   => ''
                  ),   
               array(
                     'field'   => 'address',
                     'label'   => 'ADDRESS',
                     'rules'   => ''
                  ),
				array(
                     'field'   => 'tel',
                     'label'   => 'TEL',
                     'rules'   => ''
                  ),
			   array(
                     'field'   => 'fax',
                     'label'   => 'FAX*',
                     'rules'   => ''
                  ),
			   array(
                     'field'   => 'password',
                     'label'   => 'PASSWORD*',
                     'rules'   => 'required'
                  ),
			   array(
                     'field'   => 'retypepassword',
                     'label'   => 'PASSWORD RE-TYPE*:',
                     'rules'   => 'required|matches[password]'
                  ),
			   array(
                     'field'   => 'email',
                     'label'   => 'E-MAIL ADDRESS*',
                     'rules'   => 'valid_email|callback_email_check'
                  )
            );

?>
