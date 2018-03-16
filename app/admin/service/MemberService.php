<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/16
 * Time: 下午3:42
 */

namespace app\admin\service;


class MemberService
{
    public static function checkLogin($sid){
        $where = [
            'mark' => 'checkLogIn'
        ];
        $params = [
            'sessionId' => $sid,
        ];
        $ret = \app\lklrj\service\ApiService::getApi($where,$params);
        return $ret;
    }
}