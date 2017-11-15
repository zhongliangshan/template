<?php

/**
 * URL 相关函数
 */

/**
 * 获取完整的 url 地址
 *
 * @link   http://docs.phalconphp.com/zh/latest/api/Phalcon_Mvc_Url.html
 *
 * @param  string   $uri
 * @return string
 */
function url_full($uri = null)
{
    // 网址链接及非正常的 url，纯锚点 (#...) 和 (javascript:)
    if (preg_match('~^(#|javascript:|https?://|telnet://|ftp://|tencent://)~', $uri)) {
        return $uri;
    }

    return ltrim($uri, '/');
}

/**
 * 获取静态资源地址
 *
 * @link   http://docs.phalconphp.com/zh/latest/api/Phalcon_Mvc_Url.html
 *
 * @param  string   $uri
 * @param  string   $time
 * @return string
 */
function static_url($uri = null, $time = true)
{
    if (!preg_match('~t=\d+$~i', $uri) && $time) {
        $params = ['t' => DEVELOPMENT ? time() : app_update_time()];
    } else {
        $params = null;
    }

    return url_param($uri, $params);
}

/**
 * 获取包含域名在内的 url
 *
 * @param  string   $uri
 * @param  string   $base
 * @return string
 */
function baseurl($uri = null, $base = HTTP_BASE)
{
    return $base . ltrim($uri, '/');
}

/**
 * 根据 query string 参数生成 url
 *
 *     url_param('item/list', array('page' => 1)) // item/list?page=1
 *     url_param('item/list?page=1', array('limit' => 10)) // item/list?page=1&limit=10
 *
 * @param  string   $uri
 * @param  array    $params
 * @return string
 */
function url_param($uri = null, array $params = null)
{
    if (null === $uri) {
        $uri = HTTP_URL;
    }

    if (empty($params)) {
        return $uri;
    }

    $parts   = parse_url($uri);
    $queries = [];
    if (isset($parts['query']) && $parts['query']) {
        parse_str($parts['query'], $queries);
    }

    // xss 修正
    $params = array_merge($queries, $params);
    foreach ($params as $key => &$val) {
        if (Is_array($val)) {
            continue;
        }

        $val = htmlspecialchars($val, ENT_QUOTES);
    }

    // 重置 query 组件
    $parts['query'] = rawurldecode(http_build_query($params, null, '&amp;'));

    return http_build_url($uri, $parts);
}

/**
 * 使用 sprintf 对 url 进行格式化
 *
 *      furl('item/%s-%d.html', 'books', 1) // /item/books-1.html
 *
 * @return string
 */
function furl()
{
    return url(call_user_func_array('sprintf', func_get_args()));
}
