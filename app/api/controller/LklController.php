<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/16
 * Time: 下午2:29
 */
namespace app\api\controller;

use cmf\controller\HomeBaseController;

class LklController extends HomeBaseController
{
    protected $sid;

    public function _initialize(){
        $this->sid = $this->request->param('sid',null);
        p($this->sid,0);
    }
    /*
     * 检查登录状态
     */
    public function checkLogin(){
        $where = [
            'mark' => 'checkLogIn'
        ];
        $params = [
            'sessionId' => $this->sid,
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }
}