<?php

namespace App\Http\Model\crm;

use App\Http\Model\BaseModel;

class CrmModel extends BaseModel
{
    // 数据库表名
    protected $table = 'crm';

    // 使用的数据库连接
    protected $connection = 'crm';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected static $instance = null;
    public static function getInstance()
    {

        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
