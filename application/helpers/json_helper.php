<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Output Json
 *
 * @param $data
 * @return echo json
 *
 * @author Leon
 */
function outputJson($data)
{
    echo json_encode($data);
}
