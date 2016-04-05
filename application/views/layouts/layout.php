<?php echo doctype('html5') ?>
<html>

    <head>
        <?php $this->load->view('layouts/meta'); ?>
        <?php $this->load->view('layouts/title'); ?>
        <?php $this->load->view('layouts/css'); ?>
        <?php $this->load->view('layouts/javascript'); ?>
    </head>

    <body>
        <?php $this->load->view('layouts/header') ?>
        <?php $this->load->view('layouts/banner') ?>
        <?php $this->load->view('layouts/content') ?>
        <?php $this->load->view('layouts/footer') ?>
    </body>
</html>
