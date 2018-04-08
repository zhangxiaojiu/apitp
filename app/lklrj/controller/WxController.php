<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/4/4
 * Time: 上午11:21
 */

namespace app\lklrj\controller;


use app\admin\model\ThirdPartyUserModel;
use app\admin\model\UserModel;
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
                $data['access_token'] = $ret['access_token'];
                $data['refresh_token'] = $ret['refresh_token'];
                $data['expire_time'] = time() + $ret['expires_in'];

                $userRet = WxService::getUserInfo($data['access_token'],$ret['openid']);
                $data['openid'] = $userRet['openid'];
                $data['nickname'] = $userRet['nickname'];
                $data['union_id'] = isset($userRet['unionid'])?$userRet['unionid']:'';
                //本地用户数据
                $userData['sex'] = $userRet['sex'];
                $userData['avatar'] = $userRet['headimgurl'];

                $info = ThirdPartyUserModel::tb()->where(['openid' => $data['openid']])->find();

                if(empty(session('user')['id'])){
                    if(empty($info['user_id'])) {
                        $userData['user_nickname'] = $userRet['nickname'];
                        $uid = UserModel::tb()->insertGetId($userData);
                        $data['user_id'] = $uid;

                        $uInfo = UserModel::tb()->find($info['user_id']);
                    }else{
                        $uInfo = UserModel::tb()->find($info['user_id']);
                    }
                    session('user',$uInfo);
                }else{
                    $data['user_id'] = session('user')['id'];
                    $userData['id'] = session('user')['id'];
                    UserModel::tb()->update($userData);
                }


                if (empty($info)) {
                    ThirdPartyUserModel::tb()->insert($data);
                } else {
                    ThirdPartyUserModel::tb()->where(['openid' => $data['openid']])->update($data);
                }
                $this->redirect('index/user');
            }
        }else{
            $redirect_uri= url('wx/auth');
            $url = WxService::getAuthUrl($redirect_uri);
            $this->redirect($url);
        }
    }
}