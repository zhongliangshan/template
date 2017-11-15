<?php

namespace App\Http\Model;

use DB;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    private $_table  = null;
    private $_schame = null;
    private $_conn   = null;

    protected static $instance = null;
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // 调用魔术方法 实现 对私有变量的赋值
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function connection()
    {
        $this->_conn = DB::connection($this->_schame);
    }

    public function getAll($where = [])
    {

        $res = $this->_conn->table($this->_table)->where($where)->get();
        if (empty($res)) {
            return [];
        }
        return o2a($res);
    }

    public function getOneById($id)
    {
        $res = $this->_conn->table($this->_table)->where('id', $id)->orderBy('id', 'DESC')->first();
        if (empty($res)) {
            return [];
        }
        return o2a($res);
    }

}
