<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\lklrj\controller;


use app\lklrj\service\ApiService;
use app\lklrj\service\UserService;
use cmf\controller\HomeBaseController;

class PublicController extends HomeBaseController
{
    /*
     * 登录页面
     */
    public function login()
    {
        return $this->fetch();
    }
    //登录
    public function doLogin(){
        $data = input('post.');
        $where = [
            'mark' => 'login'
        ];
        $params = [
            'loginName' => $data['username'],
            'userPwd' => $data['passpword'],
            'code' => $data['code']
        ];
        $res = ApiService::getApi($where,$params);

        if($res['retCode'] == 000000){
            $msg = $res['retMsg'];
            $data['sid'] = $res['retData']['sessionId'];
            $data['org_name'] = $res['retData']['compOrgName'];
            $data['org_code'] = $res['retData']['compOrgCode'];
            UserService::doLoginUser($data);
            $this->success($msg,'Index/index');
        }else{
            $msg = $res['retMsg'];
        }
        $this->error($msg);
    }
    /*
     * 退出登录
     */
    public function logout(){
        session('lkl_user', null);
        $this->redirect('Public/login');
    }

}
