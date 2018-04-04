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
            'aes_key' => '741WZwI4qRFlZHWUTysZDdOnnlU2AebnDficlTmvNmr',
        ];
    }
    public function index(){
        //get参数
        $echoStr = $_GET['echostr'];
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        //配置参数
        $config = self::getConfig();
        $token = $config['token'];
        //获取签名
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $signStr = sha1($tmpStr);
        //签名正确 返回
        if($signStr == $signature){
            p($echoStr,0);
        }else{
            p($echoStr,0);
        }
    }
}