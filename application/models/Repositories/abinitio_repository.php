<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Activities Repository.
 */
class Abinitio_repository extends Base_repository
{
    /**
     * Get by user
     *
     * @param $user
     * @return $abinitio
     *
     * @author Tony
     */
    public function checkstatus($userId)
    {
        $this->db
        ->select('*')
        ->from('Abinitio')
        ->where('UserName', $userId)
        ->order_by('Abinitio.location desc');
        return $this->db->get()->result();
    }

    public function result($userId, $pid)
    {
        $this->db
        ->select('location')
        ->from('Abinitio')
        ->where('UserName', $userId)
        ->where('Pid',$pid);
        return $this->db->get()->result();
    }

    public function addRecord($folder, $pid, $path, $pathpic)
    {
        //$name = $this->db->escape_str($name);
        //$data = $this->db->escape_str($data);
        return $this->db->query("
            INSERT INTO
                Abinitio
                (UserName, Pid, location, pic, available)
            VALUES
                ('$folder', '$pid', '$path', '$pathpic', 0)
        ");
    }
}
