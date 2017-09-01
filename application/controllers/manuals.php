<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class manuals extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
    }

    /**
     * Get imos manual
     *
     * @author Leon
     */
    public function imos()
    {
        force_download('i-MOS Users Manual.pdf', file_get_contents('files/manual/i-mos manual_1st rev.pdf'));
    }

    /**
     * Get realcas manual
     *
     * @author Leon
     */
    public function realcas()
    {
        force_download('Realcas Users Manual.pdf', file_get_contents('files/manual/realcas_manual.pdf'));
    }
}
