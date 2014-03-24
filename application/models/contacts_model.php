<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('email');
		$this->load->library('form_validation');
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		
		

$this->email->initialize($config);
	}
	
	public function form_submit($name, $affiliation, $email, $subject,$msg)
	{
		$data = array('name' => $name, 'affiliation' => $affiliation, 'email' => $email, 'subject' => $subject, 'msg' => $msg);
		$str = $this->db->insert('contacts', $data); 
		

		$this->email->from($email, $name);
		$this->email->to('mchan@ust.hk, lnzhang@ust.hk');
		$this->email->subject("[i-MOS]".$subject);
		$this->email->message($msg."\n\nMessage From ".$name.", ".$affiliation);
		$this->email->send();
		//echo $this->email->print_debugger();
        
	}
}

?>
