<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2017/12/26
 * Time: 15:01
 */

namespace app\lklrj\controller;


use app\user\model\UserModel;
use cmf\controller\HomeBaseController;

class BaseController extends HomeBaseController
{
    public function _initialize()
    {
        parent::_initialize();
        $session_user = session('lkl_user');
        if (!empty($session_user)) {
            $user = UserModel::tb()->where(['lkl_org_code' => $session_user['org_code']])->find();
            $this->assign("user", $user);
        } else {
            if ($this->request->isPost()) {
                $this->error("您还没有登录！", url("lklrj/public/login"));
            } else {
                header("Location:" . url("lklrj/public/login"));
                exit();
            }
        }
    }
}