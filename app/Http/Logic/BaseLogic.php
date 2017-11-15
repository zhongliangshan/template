<?php
namespace App\Http\Logic;

use App\Http\Library\RedisHandle as redis;
use App\Http\Library\SwooleClient as swoole_client;
use App\Http\Model\BaseModel;

class BaseLogic
{
    protected static $instance = null;
    private $_redis            = null;

    public $userInfo = null;

    const COOKIE_USERINFO     = 'userinfo';
    const COOKIE_ALL_USERINFO = 'all_userinfo';
    public function __construct()
    {
        $this->_redis = new redis();
    }

    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getUserInfo($user_name)
    {
        $this->userInfo = $this->_redis->get($user_name);
        if (!$this->userInfo) {
            $this->userInfo = \Cookie::get(self::COOKIE_USERINFO);
        }

        return is_array($this->userInfo) ? $this->userInfo : json_decode($this->userInfo, true);
    }

    public function getUserInfoFromXunlei($url, $ticket)
    {
        $url = sprintf("http://sso.sandai.net/server/serviceValidate?service=%s&ticket=%s", $url, $ticket);
        $res = trim(curl($url));
        if (false === $res) {
            return false;
        }

        preg_match('/\<cas\:user\>(.*?)\<\/cas\:user\>/', $res, $out);
        if (empty($out)) {
            return false;
        }

        $username = $out[1];
        preg_match_all('/\<cas\:value\>(.*?)\<\/cas\:value\>/', $res, $out);
        $truename       = isset($out[1][3]) ? $out[1][3] : '';
        $this->userInfo = $userinfo = ['username' => $username, 'truename' => $truename];
        \Cookie::queue(self::COOKIE_USERINFO, $userinfo);
        $this->_redis->set($username, $userinfo);
        return $userinfo;
    }

    public function getUser()
    {
        return is_array($this->userInfo) ? $this->userInfo : json_decode($this->userInfo, true);
    }
    // 登录跳转 直接跳转回当前的地址
    public function redirectLogin($url)
    {
        $goUrl = 'http://sso.sandai.net/server/login?service=' . $url;
        return header("Location: " . $goUrl);
    }

    /**
     * 触发任务
     * @param string $class_name  class类名
     * @param string $action_name 方法名
     * @param array  $req         请求参数
     */
    public function _triggerTask($host, $port, $class_name, $action_name, $req = [])
    {
        $client = new swoole_client();
        try {
            $client->_host = $host;
            $client->_port = $port;
            $client->connect();
        } catch (\Exception $e) {
            try {
                $client->close();
                $client->connect();
            } catch (\Exception $e) {
                logger_file('connect swoole error :' . $e->getMessage(), 'error');
                return false;
            }
        }
        $params = ['class_name' => $class_name, 'action_name' => $action_name, 'request' => $req];
        $client->send(json_encode($params));
        $client->close();

        return true;
    }

    public function getAll($schame, $table, $where = [])
    {
        $base          = BaseModel::getInstance();
        $base->_table  = $table;
        $base->_schame = $schame;
        $base->connection();
        return $base->getAll($where);
    }
    public function getOne($schame, $table, $id)
    {
        $base          = BaseModel::getInstance();
        $base->_table  = $table;
        $base->_schame = $schame;
        $base->connection();
        return $base->getOneById($id);
    }

    public function getAllUserInfo()
    {
        // $userInfo = $this->_redis->hget(self::COOKIE_ALL_USERINFO, date('Y-m-d'));

        // if (!empty($userInfo) && count($userInfo) > 300) {
        //     return $userInfo;
        // }
        // $this->_redis->del(self::COOKIE_ALL_USERINFO);
        $token    = getDataCenterApiToken('getuserinfo');
        $userInfo = json_decode(curl('http://mbd.xunleioa.com/api/v1/getuserinfo/' . $token), true);

        if (empty($userInfo)) {
            $userInfo = [];
        } else {
            $userInfo = $userInfo['data'];
        }
        // $this->_redis->hset(self::COOKIE_ALL_USERINFO, date('Y-m-d'), $userInfo);

        return $userInfo;
    }

    public function _checkCommonParams($params, $field = [])
    {
        if (empty($field)) {
            return false;
        }

        $flag = false;
        $msg  = '';
        foreach ($field as $key => $val) {
            if (!isset($params[$key])) {
                continue;
            }

            // 字符串 暂时只需要判断为空就好了
            if ('string' == $val['value']) {
                if (trim($params[$key]) == '') {
                    $flag = false;
                    $msg  = $val['name'] . ' 不能为空';
                    break;
                }
                $flag = true;
            } else if (preg_match('/\d+/', $val['value'])) {
                if (!is_numeric($params[$key]) || $params[$key] <= $val['value']) {
                    $flag = false;
                    $msg  = $val['name'] . ' 必须是整数且必须大于' . $val['value'];
                    break;
                }
                $flag = true;
            } else if ('array' == $val['value']) {
                if (empty($params[$key])) {
                    $flag = false;
                    $msg  = $val['name'] . ' 不能为空';
                    break;
                }
                $flag = true;
            } else {
                $msg  = '类型不对';
                $flag = false;
                break;
            }

        }

        return true === $flag ? $flag : $msg;
    }

    // 缓存模块信息
    public function getModelInfo()
    {

        $module_info = json_decode(curl('http://statweb.xunleioa.com/cmdb/model/allinfo'), true);
        $data        = [];
        if ($module_info) {
            foreach ($module_info['mod3'] as $item) {
                $data[] = [
                    'name' => $item['mod1'] . '_' . $item['mod2'] . '_' . $item['mod3'],
                    'id'   => $item['id'],
                ];
            }
        }
        // $this->_redis->hmset(self::ALARM_MODULE_INFO, $data);
        return $data;

    }
}
