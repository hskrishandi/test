<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Construct error message.
 *
 * @param $type, $message
 * @return echo json
 *
 * @author Leon
 */
function getError($type, $message)
{
    $error = array();
    $error['error'] = true;
    $error['type'] = $type;
    $error['message'] = $message;
    return $error;
}
