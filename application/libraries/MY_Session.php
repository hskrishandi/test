<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session 
{

    function sess_update()
    {	
    	if ( !IS_AJAX)
       {
       	   parent::sess_update();
       }
    } 

} 