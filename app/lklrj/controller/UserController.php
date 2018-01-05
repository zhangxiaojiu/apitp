<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/5
 * Time: 17:25
 */

namespace app\lklrj\controller;


use app\lklrj\service\UserService;

class UserController extends BaseController
{
    /*
     * 更新账户
     */
    public function updateUser(){
        $sid = session('lkl_user')['sid'];
        UserService::getTotalInfo($sid);
        $this->success('同步成功');
    }
}