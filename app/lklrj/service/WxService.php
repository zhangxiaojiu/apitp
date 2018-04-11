<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/4/4
 * Time: 上午11:24
 */

namespace app\lklrj\service;


use app\admin\model\ApiModel;

class WxService
{
    //本地配置
    public static function getConfig(){
        return [
            'app_id' => 'wx65bd2c9f080075b4',
            'app_secret' => '3e434e007d0c14e7183e2eb7acb80627',
            'token' => 'lblk1611',
            'aes_key' => '741WZwI4qRFlZHWUTysZDdOnnlU2AebnDficlTmvNmr',
        ];
    }
    //获取签名
    public static function getSign($token,$timestamp, $nonce){
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $signStr = sha1($tmpStr);
        return $signStr;
    }
    //设置access_token
    public static function setAccessToken(){
        //配置参数
        $config = self::getConfig();
        $appId = $config['app_id'];
        $appSecret = $config['app_secret'];

        $where = [
            'mark' => 'access_token'
        ];
        $params = [
            'grant_type' => 'client_credential',
            'appid' => $appId,
            'secret' => $appSecret
        ];
        $ret = ApiService::getApi($where,$params);
        $data['access_token'] = $ret['access_token'];
        $data['expires_in'] = time()+$ret['expires_in'];
        cmf_set_option('lblk_access_token',$data);
        return $ret;
    }
    //获取授权链接
    public static function getAuthUrl($url,$state=0){
        //配置参数
        $config = self::getConfig();
        $appId = $config['app_id'];
        $wxUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".urlencode($url)."&response_type=code&scope=snsapi_userinfo&state=".$state."#wechat_redirect";
        return $wxUrl;
    }
    //获取用户accesstoken
    public static function getAccessToken($code){
        $config = self::getConfig();
        $appId = $config['app_id'];
        $appSecret = $config['app_secret'];

        $where = [
            'mark' => 'user_access_token'
        ];
        $params = [
            'appid' => $appId,
            'secret' => $appSecret,
            'code' => $code,
            'grant_type' => 'authorization_code'
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }
    //获取用户信息
    public static function getUserInfo($accessToken,$openid){
        $where = [
            'mark' => 'wx_userinfo'
        ];
        $params = [
            'access_token' => $accessToken,
            'openid' => $openid,
            'lang' => 'zh_CN'
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }
    //发送模版消息
    public static function sendTmpMess($params){
        $expires_in = isset(cmf_get_option('lblk_access_token')['expires_in'])?cmf_get_option('lblk_access_token')['expires_in']:0;
        if(time() > $expires_in){
            self::setAccessToken();
        }
        $accessToken = cmf_get_option('lblk_access_token');
        p($accessToken);
        $token = $accessToken['access_token'];
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $ret = http_curl($url,$params,'post');
        return json_decode($ret,true);
    }
}