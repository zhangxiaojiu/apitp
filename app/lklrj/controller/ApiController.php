<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/8
 * Time: 下午5:39
 */

namespace app\lklrj\controller;


use app\lklrj\service\ApiService;
use app\lklrj\service\MerchantService;
use app\lklrj\service\TerminaService;
use app\lklrj\service\TradeService;
use app\lklrj\service\UserService;
use app\user\model\UserModel;
use cmf\controller\HomeBaseController;

class ApiController extends HomeBaseController
{
    public function _initialize(){
        $session_user = session('lkl_user');
        if (!empty($session_user)) {
            $ret = self::checkLogin($session_user['sid']);
            if($ret['retCode'] !== '000000'){
                $this->error('登录信息过期', url("public/logout"));
            }
        }
    }
    /*
     * 检查登录状态
     */
    private static function checkLogin($sid){
        $where = [
            'mark' => 'checkLogIn'
        ];
        $params = [
            'sessionId' => $sid,
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }
    /*
     * 同步账户
     */
    public function updateUser(){
        $sid = session('lkl_user')['sid'];
        UserService::getTotalInfo($sid);
        $this->success('同步成功');
    }

    /*
     * 同步自己商户
     */
    public function syncMyMerchant(){
        $code = session('lkl_user')['org_code'];
        $sid = session('lkl_user')['sid'];
        MerchantService::syncOneMerchant($code,$sid);
        $this->success('同步成功');
    }

    /*
     * 同步下级代理所有商户
     */
    public function syncMerchant(){
        $id = session('lkl_user')['id'];
        $sid = session('lkl_user')['sid'];
        MerchantService::syncMerchant($id,$sid);
        $this->success('同步成功');
    }

    /*
     * 同步自己终端
     */
    public function syncMyTermina(){
        $sid = session('lkl_user')['sid'];
        $code = session('lkl_user')['org_code'];
        TerminaService::syncTermina($sid,$code);
        $this->success('同步成功');
    }

    /*
     * 同步下级代理所有终端
     */
    public function syncTermina(){
        $id = session('lkl_user')['id'];
        $sid = session('lkl_user')['sid'];
        TerminaService::syncAllTermina($id,$sid);
        $this->success('同步成功');
    }

    /*
     * 同步自己代理
     */
    public function syncMyAgent(){
        $sid = session('lkl_user')['sid'];
        $code = session('lkl_user')['org_code'];
        UserService::syncAgent($sid,$code);
        $this->success('同步成功');
    }

    /*
     * 同步所有代理商
     */
    public function syncAgent(){

    }


    /*
     * 同步交易记录
     */
    public function syncTrade(){
        $sid = session('lkl_user')['sid'];
        $code = session('lkl_user')['org_code'];
        TradeService::syncTrade($sid,$code);
        $this->success('同步成功');
    }
}