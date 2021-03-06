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

    }
    public function test(){
        $openId = 'oBiZI08bj32o1SagokTeMMZ7k9G0';
        $type = '1';//分润
        $ret = WxService::tmpAccountChange($openId,$type,'13320990009','99');
        p($ret);
    }
    //微信用户签名
    public function auth()
    {
        $code = isset($_GET['code'])?$_GET['code']:false;
        $state = isset($_GET['state'])?$_GET['state']:1;//传递参数用
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
                        $userData['pid'] = $state;
                        $userData['user_type'] = UserModel::TYPE_LKL_AGENT;
                        $userData['user_status'] = UserModel::STATUS_UNVERIFIED;
                        $uid = UserModel::tb()->insertGetId($userData);
                        $data['user_id'] = $uid;

                        $uInfo = UserModel::tb()->find($uid);
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
                $this->redirect('index/index');
            }
        }else{
            $redirect_uri= url('wx/auth');
            $pid = isset($_GET['pid'])?$_GET['pid']:1;
            $url = WxService::getAuthUrl($redirect_uri,$pid);
            $this->redirect($url);
        }
    }
}