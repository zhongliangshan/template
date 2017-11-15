<?php
function get_loc_from_host($host)
{
    preg_match('/^[a-z]+[0-9][0-9][a-z]?/', $host, $match);
    if (isset($match[0])) {
        return $match[0];
    } else if (preg_match('/user/', $host)) {
        $list = preg_split('/-/', $host);
        return $list[0] . "_" . $list[1];
    } else if (preg_match('/university/', $host)) {
        $list = preg_split('/-/', $host);
        return $list[0] . "_" . $list[1];
    } else if (preg_match('/-/', $host)) {
        $list = preg_split('/-/', $host);
        return $list[0] . "_" . $list[1];
    } else {
        return "";
    }
}

function getDataCenterApiToken($apiname)
{
    $arr = explode('_', $apiname);
    return md5($arr[0] . date('Y-m-d:H'));
}
