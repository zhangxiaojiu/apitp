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
    private function getConfig(){
        return [
            'app_id' => 'wx65bd2c9f080075b4',
            'app_secret' => '3e434e007d0c14e7183e2eb7acb80627',
            'token' => 'lblk1611',
            'aes_key' => '',
        ];
    }
    public function index(){
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];

        $config = self::getConfig();
        $token = $config['token'];

        $sign = WxService::getSign($token,$timestamp,$nonce);
        if($signature == $sign){
            echo $echoStr;
        }
    }
}