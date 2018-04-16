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
    //设置access_token  （通用）
    public static function returnSetAccessToken(){
        cache('cmf_options_lblk_access_token', null);
        $accessToken = cmf_get_option('lblk_access_token');
        $expires_in = isset($accessToken['expires_in'])?$accessToken['expires_in']:0;
        if(time() > $expires_in) {
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
            $ret = ApiService::getApi($where, $params);
            $data['access_token'] = $ret['access_token'];
            $data['expires_in'] = time() + $ret['expires_in'];
            cmf_set_option('lblk_access_token', $data);
            return $data;
        }
        return $accessToken;
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
        $accessToken = self::returnSetAccessToken();
        $token = $accessToken['access_token'];
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $ret = request_post($url,urldecode($params));
        return json_decode($ret,true);
    }
    //模版 账户变更
    public static function tmpAccountChange($openId,$type,$account,$remark){
        switch ($type){
            case 1:
                $title = '分润到账提醒';
                $type = '分润';
                break;
            case 2:
                $title = '机器激活提醒';
                $type = '激活';
                break;
            default:
        }
        $data = [
            'first' =>  ['value'=>$title,'color'=>'#000'],
            'account' =>  ['value'=>$account,'color'=>'#000'],
            'time' =>  ['value'=>date("Y-m-d H:i:s",time()),'color'=>'#00f'],
            'type' =>  ['value'=>$type,'color'=>'#000'],
            'remark' =>  ['value'=>$remark,'color'=>'#666']
        ];
        $params = [
            'touser' => $openId,
            'template_id' => 'UP0rah2nHfF1V-45IXtibp63t9Hvm4zKIM6qoIvr8mY',
            'url' => 'http://app.mylabulaka.com/wx/auth',
            'data' => $data
        ];
        $json = json_encode($params);
        $ret = WxService::sendTmpMess($json);
        return $ret;
    }
}