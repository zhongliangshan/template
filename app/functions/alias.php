<?php

function A($array, $key, $default = null)
{
    return array_get_value($array, $key, $default);
}

/**
 * 加载配置文件数据
 *
 * @see config
 */
function C($name, $default = null)
{
    return Config::get($name, $default);
}

/**
 * 获取数据库表名
 *
 * @see table
 */
function T($name)
{
    return call_user_func_array('table', func_get_args());
}

/**
 * 获取完整的 url 地址
 *
 * @see url
 */
function U($uri = null)
{
    return url($uri);
}
