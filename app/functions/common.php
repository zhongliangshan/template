<?php
/**
 * 项目更新时间
 *
 * @return integer
 */
function app_update_time()
{
    static $time = null;

    if (null === $time) {
        if ($cache = cache_get('app_update_time')) {
            return $cache;
        }

        $time = time();
        cache_set('app_update_time', $time);
    }

    return $time;
}

function cache_get($key)
{
    \Cache::get($key);
}

function cache_set($key, $value)
{
    \Cache::put($key, $value);
}
/**
 * 加载配置文件数据
 *
 *     config_file('database')
 *     config_file('database.default.adapter')
 *
 * @param  string  $name
 * @return mixed
 */
function config_file($name, $default = null)
{
    static $cached = [];

    // 移除多余的分隔符
    $name = trim($name, '.');

    if (isset($cached[$name])) {
        return null === $cached[$name] ? $default : $cached[$name];
    }

    // 获取配置名及路径
    if (strpos($name, '.') === false) {
        $paths    = [];
        $filename = $name;
    } else {
        $paths    = explode('.', $name);
        $filename = array_shift($paths);
    }

    if (isset($cached[$filename])) {
        $data = $cached[$filename];
    } else {
        // 默认优先查找 php 数组类型的配置

        // 当前配置环境路径
        $path = base_path() . '/config';
        $file = "$path/$filename.php";
        if (is_file($file)) {
            $data = include $file;
        }

        // 缓存文件数据
        $cached[$filename] = $data;
    }

    // 支持路径方式获取配置，例如：config('file.key.subkey')
    foreach ($paths as $key) {
        $data = isset($data->{$key}) ? $data->{$key} : null;
    }

    // 缓存数据
    $cached[$name] = $data;
    return null === $cached[$name] ? $default : $cached[$name];
}

function logger_file($msg, $filename = 'common', $type = 'info')
{
    $date = date('Y-m-d');
    $file = base_path() . "/logs/{$date}/{$filename}.log";
    if (!file_exists(dirname($file))) {
        mkdir(dirname($file), 0777);
    }

    $message = "{$type} [" . date('Y-m-d H:i:s') . "]: ";

    if (is_array($msg)) {
        error_log($message . PHP_EOL, 3, $file);
    } else {
        $msg = $message . $msg . PHP_EOL;
    }
    error_log(print_r($msg, 1), 3, $file);
}
/**
 * 加载函数库
 *
 *     load_functions('tag', ...)
 *     load_functions(array('tag', ...))
 *
 * @param string|array $names
 */
function load_functions($names)
{
    static $cached = ['common'];

    if (func_num_args() > 1) {
        $names = func_get_args();
    } elseif (!is_array($names)) {
        $names = [$names];
    }

    $names = array_map('strtolower', $names);

    foreach ($names as $name) {
        if (!isset($cached[$name])) {
            $file = app_path() . "/functions/{$name}.php";
            if (is_file($file)) {
                require_once $file;
            }
        }
    }
}
function getAction()
{
    $action_name = \Route::getCurrentRoute()->getActionName();
    $actions     = explode('@', $action_name);
    return isset($actions[1]) ? $actions[1] : '';
}

function getEchartsTime($from_time = '', $end_time = '', $period = 'day')
{

    if (!$period) {
        $period = 'day';
    }

    $date = [];
    if (!$end_time) {
        $end_time = time();
    } else {
        $end_time = strtotime($end_time);
    }

    switch ($period) {
        case 'day':
            if (!$from_time) {
                $from_time = strtotime('-30 day');
            } else {
                $from_time = strtotime($from_time);
            }

            while (true) {
                array_push($date, date('Y-m-d', $from_time));
                if ($from_time >= $end_time) {
                    break;
                }

                $from_time += 86400;
            }
            break;

        case 'week':
            if (!$from_time) {
                $from_time = strtotime('-1 year');
            } else {
                $from_time = strtotime($from_time);
            }

            $end_time = date('Y-W', $end_time);
            while (true) {
                $start_time = date('Y-W', $from_time);
                array_push($date, $start_time);
                if ($start_time >= $end_time) {
                    break;
                }

                $from_time = strtotime('+1 week', $from_time);
            }
            break;
    }
    return $date;
}

//时间戳转化为 Y-m-d H:i:s
function tstoymdhis($ts)
{
    return $date = date('Y-m-d H:i:s', $ts);
}
// 二元表达式
function on($first, $second, $return = true)
{
    return $first === $second ? $return : false;
}
function on_3($bool, $resTrue, $resFalse = null)
{
    return $bool ? $resTrue : $resFalse;
}

if (!function_exists('sidebar_build_menu')) {
    /**
     * 构造菜单选项
     *
     * @param  array    $config
     * @return string
     */
    function sidebar_build_menu(array $config, $level = 1)
    {
        $html = '';
        foreach ($config as $key => $val) {
            if (!$allowed = A($val, 'allowed', true)) {
                continue;
            }

            // 图标
            $icon = A($val, 'icon', 'arrow-circle-right');
            // 标题
            $title = A($val, 'title', 'No Title');

            if (1 === $level) {
                $title = "<span class='title'>{$title}</span>";
            }
            $url = A($val, 'url');
            if (!preg_match('/http\:\/\//', $url)) {
                // 网址
                $url = $url ? U($url) : 'javascript:;';
            }

            // 子菜单
            $arrow = $submenu = '';
            if (isset($val['submenu'])) {
                $arrow   = "<span class=\"arrow\"></span>";
                $submenu = sidebar_build_menu($val['submenu'], $level + 1);
                // 没有子菜单
                if (trim($submenu) === '') {
                    continue;
                }

                $submenu = "<ul class=\"sub-menu\">\n$submenu\n</ul>";
            }

            // 是否激活菜单选中
            // 如果子菜单存在选中，则自动选中
            $selected = '';
            if (A($val, 'active') || preg_match('~class=".*?active.*?"~', $submenu)) {
                if (isset($val['attribute']['class'])) {
                    $val['attribute']['class'] .= ' active';
                } else {
                    $val['attribute']['class'] = ' active';
                }

                // 一级菜单被选中
                if (1 === $level) {
                    $selected = '<span class="active"></span>';
                }
            }
            // 判断 当前url 是什么
            $now_url = trim(\Request::getRequestUri(), '/') ? trim(\Request::getRequestUri(), '/') : '/';
            if (A($val, 'url') == $now_url) {
                if (isset($val['attribute']['class'])) {
                    $val['attribute']['class'] .= ' active';
                } else {
                    $val['attribute']['class'] = ' active';
                }

                // 一级菜单被选中
                if (1 === $level) {
                    $selected = '<span class="active"></span>';
                }
            }

            // 属性
            $attribute = '';
            if ($attr = A($val, 'attribute')) {
                if (is_array($attr)) {
                    foreach ($attr as $k => $v) {
                        $attribute .= " {$k}=\"{$v}\"";
                    }
                } else {
                    $attribute = $attr;
                }
            }

            $html .= "<li {$attribute}>"
                . "    <a href=\"{$url}\">"
                . "        <i class=\"icon-{$icon}\"></i>"
                . "        {$title}"
                . "        {$selected}"
                . "        {$arrow}"
                . "    </a>"
                . "    {$submenu}"
                . "</li>";
        }
        return $html;
    };
}
/**
 * 返回格式化的 json 数据
 *
 * @param  array    $array
 * @param  boolean  $pretty    美化 json 数据
 * @param  boolean  $unescaped 关闭 Unicode 编码
 * @return string
 */
function json_it(array $array, $pretty = true, $unescaped = true)
{
    // php 5.4+
    if (defined('JSON_PRETTY_PRINT') && defined('JSON_UNESCAPED_UNICODE')) {
        if ($pretty && $unescaped) {
            $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;
        } elseif ($pretty) {
            $options = JSON_PRETTY_PRINT;
        } elseif ($unescaped) {
            $options = JSON_UNESCAPED_UNICODE;
        } else {
            $options = null;
        }

        return json_encode($array, $options);
    }

    if ($unescaped) {
        // convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127).
        // So such characters are being "hidden" from normal json_encoding
        $tmp = [];
        array_walk_recursive($array, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_encode_numericentity($item, [0x80, 0xffff, 0, 0xffff], 'UTF-8');
            }
        });
        $json = mb_decode_numericentity(json_encode($array), [0x80, 0xffff, 0, 0xffff], 'UTF-8');
    } else {
        $json = json_encode($array);
    }

    if ($pretty) {
        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = "\t";
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;

        for ($i = 0; $i <= $strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string
            if ('"' == $char && '\\' != $prevChar) {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element,
                // output a new line and indent the next line.
            } elseif (('}' == $char || ']' == $char) && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if ((',' == $char || '{' == $char || '[' == $char) && $outOfQuotes) {
                $result .= $newLine;
                if ('{' == $char || '[' == $char) {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        $json = $result;
    }

    return $json;
}

/**
 * 确保一个可迭代的数据类型, 可用于foreach，避免判断
 * 如果　$iterator　是一个可迭代类型则返回其本身，否则返回一个空数组
 *
 * @param  mixed   $iterator
 * @return mixed
 */
function _i($iterator)
{
    return is_array($iterator) || is_object($iterator)
    ? $iterator
    : [];
}

/**
 * 隐藏当前系统路径
 *
 *     maskroot('/web/myapp/app/config/db.php') // ~/app/config/db.php
 *
 * @param  string   $path
 * @return string
 */
function maskroot($path)
{
    return str_replace(base_path(), '~', $path);
}

/**
 * 执行 curl 请求，并返回响应内容
 *
 * @param  string   $url
 * @param  array    $data
 * @param  array    $options
 * @return string
 */
function curl($url, array $data = null, array $options = null)
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_URL            => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_RETURNTRANSFER => 1,
    ]);

    if ($data) {
        $data = http_build_query($data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-type: application/x-www-form-urlencoded',
            'Content-Length: ' . strlen($data),
        ]);
    }

    if ($options) {
        curl_setopt_array($ch, $options);
    }

    $response = curl_exec($ch);
    // 获取http状态码
    $intReturnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (200 != $intReturnCode) {
        return false;
    }

    curl_close($ch);

    return $response;
}

/**
 * CURL DELETE 请求
 *
 * @param  string   $url
 * @param  array    $postdata
 * @param  array    $curl_opts
 * @return string
 */
function delete($url, $postdata = '', array $curl_opts = null)
{
    $ch = curl_init();
    if ('' !== $postdata && is_array($postdata)) {
        $postdata = http_build_query($postdata);
    }

    write_log('curl_delete', "url:' . $url,parm:" . var_export($postdata, true));
    curl_setopt_array($ch, [
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_URL            => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     => $postdata,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FAILONERROR    => 1,
        CURLOPT_CUSTOMREQUEST  => 'DELETE',
    ]);

    if (null !== $curl_opts) {
        curl_setopt_array($ch, $curl_opts);
    }

    $result = curl_exec($ch);
    // 获取http状态码
    $intReturnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    write_log('curl_delete', var_export($result, true) . ',status:' . $intReturnCode);
    curl_close($ch);

    return 200 == $intReturnCode;
}

if (!function_exists('http_build_url')) {
    define('HTTP_URL_REPLACE', 1);          // Replace every part of the first URL when there's one of the second URL
    define('HTTP_URL_JOIN_PATH', 2);        // Join relative paths
    define('HTTP_URL_JOIN_QUERY', 4);       // Join query strings
    define('HTTP_URL_STRIP_USER', 8);       // Strip any user authentication information
    define('HTTP_URL_STRIP_PASS', 16);      // Strip any password authentication information
    define('HTTP_URL_STRIP_AUTH', 32);      // Strip any authentication information
    define('HTTP_URL_STRIP_PORT', 64);      // Strip explicit port numbers
    define('HTTP_URL_STRIP_PATH', 128);     // Strip complete path
    define('HTTP_URL_STRIP_QUERY', 256);    // Strip query string
    define('HTTP_URL_STRIP_FRAGMENT', 512); // Strip any fragments (#identifier)
    define('HTTP_URL_STRIP_ALL', 1024);     // Strip anything but scheme and host

    /**
     * Build an URL
     * The parts of the second URL will be merged into the first according to the flags argument.
     *
     * @param mixed   (Part(s) of) an URL in form of a string or associative array like parse_url() returns
     * @param mixed   Same     as the first argument
     * @param integer A        bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
     * @param array   If       set, it will be filled with the parts of the composed url like parse_url() would return
     */
    function http_build_url($url, $parts = [], $flags = HTTP_URL_REPLACE, &$new_url = false)
    {
        $keys = ['user', 'pass', 'port', 'path', 'query', 'fragment'];

        // HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
        if ($flags & HTTP_URL_STRIP_ALL) {
            $flags |= HTTP_URL_STRIP_USER;
            $flags |= HTTP_URL_STRIP_PASS;
            $flags |= HTTP_URL_STRIP_PORT;
            $flags |= HTTP_URL_STRIP_PATH;
            $flags |= HTTP_URL_STRIP_QUERY;
            $flags |= HTTP_URL_STRIP_FRAGMENT;
        }
        // HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
        elseif ($flags & HTTP_URL_STRIP_AUTH) {
            $flags |= HTTP_URL_STRIP_USER;
            $flags |= HTTP_URL_STRIP_PASS;
        }

        // Parse the original URL
        $parse_url = parse_url($url);

        // Scheme and Host are always replaced
        if (isset($parts['scheme'])) {
            $parse_url['scheme'] = $parts['scheme'];
        }

        if (isset($parts['host'])) {
            $parse_url['host'] = $parts['host'];
        }

        // (If applicable) Replace the original URL with it's new parts
        if ($flags & HTTP_URL_REPLACE) {
            foreach ($keys as $key) {
                if (isset($parts[$key])) {
                    $parse_url[$key] = $parts[$key];
                }

            }
        } else {
            // Join the original URL path with the new path
            if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH)) {
                if (isset($parse_url['path'])) {
                    $parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
                } else {
                    $parse_url['path'] = $parts['path'];
                }

            }

            // Join the original query string with the new query string
            if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY)) {
                if (isset($parse_url['query'])) {
                    $parse_url['query'] .= '&' . $parts['query'];
                } else {
                    $parse_url['query'] = $parts['query'];
                }

            }
        }

        // Strips all the applicable sections of the URL
        // Note: Scheme and Host are never stripped
        foreach ($keys as $key) {
            if ($flags & (int) constant('HTTP_URL_STRIP_' . strtoupper($key))) {
                unset($parse_url[$key]);
            }

        }

        $new_url = $parse_url;

        return
            ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '') .
            ((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') . '@' : '') .
            ((isset($parse_url['host'])) ? $parse_url['host'] : '') .
            ((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '') .
            ((isset($parse_url['path'])) ? $parse_url['path'] : '') .
            ((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '') .
            ((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
        ;
    }
}

/**
 * CURL GET 请求
 *
 * @param  string   $url
 * @param  array    $curl_opts
 * @return string
 */
function get($url, array $curl_opts = null)
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_URL            => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_RETURNTRANSFER => 1,
    ]);

    if (null !== $curl_opts) {
        curl_setopt_array($ch, $curl_opts);
    }

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

/**
 * CURL POST 请求
 *
 * @param  string   $url
 * @param  array    $postdata
 * @param  array    $curl_opts
 * @return string
 */
function post($url, $postdata = '', array $curl_opts = null)
{
    $ch = curl_init();
    if ('' !== $postdata && is_array($postdata)) {
        $postdata = http_build_query($postdata);
    }

    curl_setopt_array($ch, [
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_URL            => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     => $postdata,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FAILONERROR    => 1,
    ]);

    if (null !== $curl_opts) {
        curl_setopt_array($ch, $curl_opts);
    }

    $result = curl_exec($ch);
    // 获取http状态码
    $intReturnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [
        'result'    => $result,
        'http_code' => $intReturnCode,
    ];
}

/**
 * post md5 加密数据
 */
function post_sign($url, $postdata, array $curl_opts = null)
{
    if (!isset($postdata['key'])) {
        return false;
    }
    $key             = $postdata['key'];
    $sign            = sign($postdata, $key);
    $postdata['key'] = $sign;
    $ch              = curl_init();
    if ('' !== $postdata && is_array($postdata)) {
        $postdata = http_build_query($postdata);
    }

    curl_setopt_array($ch, [
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_URL            => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     => $postdata,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FAILONERROR    => 1,
    ]);

    if (null !== $curl_opts) {
        curl_setopt_array($ch, $curl_opts);
    }

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function sign($data, $key)
{
    $unset = [
        'key',
        '_url',
    ];
    foreach ($unset as $k) {
        if (isset($data[$k])) {
            unset($data[$k]);
        }

    }
    ksort($data);
    $query = http_build_query($data);
    return md5($query . $key);
}

function create_uuid($prefix = "")
{
    return md5(uniqid(mt_rand(), true));
}

function create_str($length = 1)
{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'zUcQPaoXpZAYYfj8VYmqhbnm76UufYzTwoukpWizUtzaLJTFtmisywCgalhdSbVJCvyhJL4WF8STXc0RIsnrthT5chrtTouxbaCcoLwczTYkltuzthAzhuxwwsbcJ5SXq0sVywsRl77fiYrTTTmiph';
    $str   = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    return $str;
}

/**
 * 判断两个浮点数是否相等
 * @param  float  $num1
 * @param  float  $num2
 * @param  float  $diff
 * @return bool
 */
function float_eq($num1, $num2, $diff = 0.000001)
{
    return abs($num1 - $num2) < $diff;
}
function get_current_ip()
{
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (isset($_SERVER["REMOTE_ADDR"])) {
        $ip = $_SERVER["REMOTE_ADDR"];
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = Yii::$app->request->userIP;
    }

    return $ip;
}

function csv_header($filename)
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename . '.csv');
    header('Cache-Control: max-age=0');
    return true;
}

function csv_line($data = [])
{
    foreach ($data as $key => $item) {
        $tmp        = null;
        $tmp        = str_replace(array("\r\n", "\r", "\n", ";", " ", "；", ","), " ", $item);
        $data[$key] = mb_convert_encoding(strip_tags($tmp), 'gbk', 'utf-8');

    }

    return implode(',', array_values($data)) . PHP_EOL;
}
