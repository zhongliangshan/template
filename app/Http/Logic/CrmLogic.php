<?php
namespace App\Http\Logic;

use App\Http\Library\RedisHandle as redis;
use App\Http\Logic\BaseLogic;
use App\Http\Model\crm\CrmModel as Crm;

class CrmLogic extends BaseLogic
{
    protected static $instance = null;
    private $_redis            = null;

    public $types = [
        2 => '客户报障',
        3 => '内部报障',
        4 => '网络故障',
    ];

    public $levels = [
        1 => '一级工单',
        2 => '二级工单',
        3 => '三级工单',
        4 => '四级工单',
    ];

    public $status = [
        1 => '一线处理中',
        2 => '服务恢复',
        3 => '二线处理中',
        4 => '结单',
    ];

    public $customers = [
        '熊猫直播',
        '触手直播',
        'B站直播',
        '陌陌直播',
        '微吼直播',
        '酷我直播',
        '花椒直播',
        '快手直播',
        '八花生直播',
        '虎牙直播',
        '粉优直播',
        '长尾直播',
        '小米点播',
        '乐相点播',
        '360点播',
        '酷开点播',
        '爱奇艺点播',
        '新东方点播',
    ];

    public $timeouts = [
        'sla' => [

        ],
    ];

    public function __construct()
    {
        $this->_redis = new redis();
    }

    public function get($name)
    {
        return isset($this->{$name}) ? $this->{$name} : false;
    }

    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getMyCreate($params = [])
    {
        $crm = Crm::getInstance()->select('crm.*');

        extract($params);

        if ($start_time) {

        }

        return $crm->paginate(A($params, 'num', 20));
    }

    public function addCrm($params = [], $username)
    {
        extract($params);
        $bool = $this->_checkCommonParams($params, [
            'crm_title'     => [
                'value' => 'string',
                'name'  => '工单标题',
            ],
            'type'          => [
                'value' => -1,
                'name'  => '工单类型',
            ],
            'report_name'   => [
                'value' => 'string',
                'name'  => '报障人',
            ],
            'now_deal_name' => [
                'value' => 'string',
                'name'  => '当前处理人',
            ],
            'level'         => [
                'value' => -1,
                'name'  => '工单级别',
            ],
            'content'       => [
                'value' => 'string',
                'name'  => '工单内容',
            ],
        ]);

        if (true !== $bool) {
            return ['msg' => $bool, 'code' => 500];
        }
        $crm        = Crm::getInstance();
        $crm_number = date('YmdHis') . '_1';
        $data       = [
            'crm_number'        => $crm_number,
            'parent_crm_number' => isset($parent_crm_number) && $parent_crm_number ? $parent_crm_number : $crm_number,
            'report_name'       => $report_name,
            'report_time'       => $report_time ? strtotime($report_time) : time(),
            'type'              => isset($type) && in_array($type, [1, 2, 3, 4]) ? $type : 1,
            'content'           => $content,
            'crm_title'         => $crm_title,
            'now_deal_name'     => $now_deal_name,
            'level'             => $level,
            'status'            => 1,
            'module'            => isset($module) ? implode(',', $module) : '',
            'create_name'       => $username,
            'attention_name'    => isset($attention_name) ? implode(',', $attention_name) : '',
            'create_time'       => time(),
        ];

        $insertId = $crm->insertGetId($data);

        if ($insertId) {
            return ['msg' => '工单创建成功', 'code' => 200];
        }

        for ($i = 2; $i < 5; $i++) {
            $crm_number         = date('YmdHis') . '_' . $i;
            $data['crm_number'] = $data['parent_crm_number'] = $crm_number;
            $insertId           = $crm->insertGetId($data);

            if ($insertId) {
                return ['msg' => '工单创建成功', 'code' => 200];
            }
        }

        return ['msg' => '工单创建失败，请重试', 'code' => 500];
    }

    public function getTimeout()
    {

    }
}
