<?php

return [
    [
        'title'     => '主页',
        'url'       => '/',
        'icon'      => 'home',
        'attribute' => [
            'class' => 'index',
        ],
    ],
    [
        'title'   => '我的工单',
        'icon'    => 'user',
        'submenu' => [
            [
                'title' => '我创建的工单',
                'url'   => 'crm/my_create',
                'icon'  => 'plus',
            ],
            [
                'title' => '我的代办',
                'url'   => 'crm/my_wait_handle',
                'icon'  => 'book',
            ],
            [
                'title' => '我的已办',
                'url'   => 'crm/my_handled',
                'icon'  => 'book',
            ],
            [
                'title' => '我的关注',
                'url'   => 'crm/my_care',
                'icon'  => 'book',
            ],
        ],
    ],
    [
        'title' => '所有工单',
        'icon'  => 'user',
        'url'   => 'crm/all',
        'icon'  => 'book',
    ],
    [
        'title'   => '常用系统',
        'icon'    => 'sitemap',
        'submenu' => [
            [
                'title' => '告警系统',
                'url'   => 'http://alarmweb.xunleioa.com',
                'icon'  => 'warning-sign',
            ],
            [
                'title' => '基础运维系统',
                'url'   => 'http://statweb.xunleioa.com',
                'icon'  => 'star',
            ],
            [
                'title' => '运维操作平台',
                'url'   => 'http://auto.xunleioa.com/auto/cgi-bin/index.cgi?ticket=ST-820187-xj6d92bUEqRWBkMf9Lfc-cas',
                'icon'  => 'cogs',
            ],
        ],
    ],
];
