<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/4/4
 * Time: 上午11:21
 */

namespace app\lklrj\controller;


use app\admin\model\ThirdPartyUserModel;
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

    }
    public function auth()
    {
        $code = isset($_GET['code'])?$_GET['code']:false;
        //$state = $_GET['state'];//传递参数用
        if($code) {
            $ret = WxService::getAccessToken($code);
            if (isset($ret['errcode'])) {
                p($ret, 0);
            } else {
                $data['openid'] = $ret['openid'];
                $data['access_token'] = $ret['access_token'];
                $data['refresh_token'] = $ret['refresh_token'];
                $data['expire_time'] = time() + $ret['expires_in'];

                $userRet = WxService::getUserInfo($data['access_token'],$data['openid']);
                p($userRet);
                $data['openid'] = $userRet['openid'];
                $data['nickname'] = $userRet['nickname'];
                $data['union_id'] = $userRet['unionid'];
                $userData['sex'] = $userRet['sex'];
                $userData['avatar'] = $userRet['headimgurl'];
                p($userData);
                echo "<a href='".$userData['avatar']."'>头像</a>";

                $info = ThirdPartyUserModel::tb()->where(['openid' => $data['openid']])->find();
                if (empty($info)) {
                    ThirdPartyUserModel::tb()->insert($data);
                } else {
                    ThirdPartyUserModel::tb()->where(['openid' => $data['openid']])->update($data);
                }
            }
        }else{
            $redirect_uri= url('wx/auth');
            $url = WxService::getAuthUrl($redirect_uri);
            $this->redirect($url);
        }
    }
}