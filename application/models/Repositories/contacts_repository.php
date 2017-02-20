<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contacts_repository extends Base_repository
{

    /**
     * Save contact
     *
     * @param $email, $name, $affiliation, $subject, $message
     * @return bool
     *
     * @author Leon
     */
    public function saveContact($email, $name, $affiliation, $subject, $message)
    {
        $email = $this->db->escape_str($email);
        $name = $this->db->escape_str($name);
        $affiliation = $this->db->escape_str($affiliation);
        $subject = $this->db->escape_str($subject);
        $message = $this->db->escape_str($message);
        $data = array('name' => $name, 'affiliation' => $affiliation, 'email' => $email, 'subject' => $subject, 'msg' => $message);
        return $this->db->insert('contacts', $data);
    }
}
