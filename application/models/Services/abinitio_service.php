<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Activities service.
 */
class Abinitio_service extends Base_service
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repositories/Abinitio_repository');
    }

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
        return $this->Abinitio_repository->checkstatus($userId);
    }

    public function addRecord($folder, $pid, $path, $pathpic)
    {
        return $this->Abinitio_repository->addRecord($folder, $pid, $path, $pathpic);
    }
}
