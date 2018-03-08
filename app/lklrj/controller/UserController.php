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
     * 我的资料
     */
    public function info(){

        return $this->fetch();
    }
}