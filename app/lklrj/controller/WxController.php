<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/4/4
 * Time: 上午11:21
 */

namespace app\lklrj\controller;


use app\lklrj\service\WxService;
use cmf\controller\HomeBaseController;

class WxController extends HomeBaseController
{
    public function index(){
        //get参数
        $echoStr = $_GET['echostr'];
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        //配置参数
        $config = WxService::getConfig();
        $token = $config['token'];
        //获取签名
        $sign = WxService::getSign($token,$timestamp,$nonce);
        //签名正确 返回
        if($sign == $signature && $echoStr){
            echo $echoStr;
            exit;
        }else{

        }
    }
    public function test(){
        $redirect_uri= url('wx/backUrl');
        $url = WxService::getAuthUrl($redirect_uri);
        $this->redirect($url);
    }
    public function backUrl()
    {
        $code = $_GET['code'];
        //$state = $_GET['state'];//传递参数用
        $ret = WxService::getAccessToken($code);
        p($ret);
    }
}