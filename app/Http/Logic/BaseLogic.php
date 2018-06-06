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
}
