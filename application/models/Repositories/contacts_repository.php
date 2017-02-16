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
        $data = array('name' => $name, 'affiliation' => $affiliation, 'email' => $email, 'subject' => $subject, 'msg' => $message);
        return $this->db->insert('contacts', $data);
    }
}
