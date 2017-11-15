<?php

namespace App\Http\Controllers;

use App\Http\Logic\BaseLogic;
use Cookie;

class ControllerBase extends Controller
{
    const COOKIE_USERNAME = 'username';
    const COOKIE_TICKET   = 'ticket';
    public $user          = null;
    public $url           = null;
    public function __construct()
    {
        $uri       = \Request::getRequestUri();
        $uri       = preg_replace('/&ticket=.*/', '', $uri);
        $uri       = explode('?', $uri);
        $this->url = (count($uri) <= 1) ? urlencode(\URL::current()) : urlencode(\URL::current() . '?' . $uri[1]);
        $this->requireLogin();
    }

    public function requireLogin()
    {
        $ticket = \Input::get('ticket') ? \Input::get('ticket') : Cookie::get(self::COOKIE_TICKET);
        // 存储ticket
        $base_logic = BaseLogic::getInstance();
        if (!$ticket) {
            return $base_logic->redirectLogin($this->url);
        }

        //获取用户的 username 这个必须是唯一的
        $user_name = Cookie::get(self::COOKIE_USERNAME);
        if (!$user_name) {
            // 没有用户名 就需要去 账号系统中拿取
            $user_info = $base_logic->getUserInfoFromXunlei($this->url, $ticket);
            if (false === $user_info) {
                return $base_logic->redirectLogin($this->url);
            }

            Cookie::queue(self::COOKIE_USERNAME, $user_info['username'], 86400);
            Cookie::queue(self::COOKIE_TICKET, $ticket, 86400);
        } else {
            // 获取用户的信息
            $user_info = $base_logic->getUserInfo($user_name);
        }

        $this->user = $user_info;
        return is_array($this->user) ? $this->user : json_decode($this->user, true);
    }

}
