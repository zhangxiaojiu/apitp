<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\lklrj\controller;


use app\admin\model\CoinLogModel;
use app\admin\model\CoinModel;
use app\admin\model\ThirdPartyUserModel;
use app\admin\model\UserModel;
use think\Validate;

class IndexController extends BaseController
{
    /*
     * 首页
     */
    public function index()
    {
        $uid = session('user')['id'];
        $coinLog = CoinLogModel::tb()->where(['uid'=>$uid])->order('create_time desc')->paginate(5);
        $cInfo = CoinModel::getInfoById($uid);
        $total['run'] = isset($cInfo['run'])?$cInfo['run']:0;
        $total['activate'] = isset($cInfo['activate'])?$cInfo['activate']:0;

        $time = strtotime(date('Y-m-d 00:00:00',time()));
        $today['run'] = CoinLogModel::tb()->where(['uid'=>$uid,'type'=>'run','create_time'=>['>',$time]])->sum('coin');
        $today['activate'] = CoinLogModel::tb()->where(['uid'=>$uid,'type'=>'activate','create_time'=>['>',$time]])->sum('coin');
        if(empty($today['run'])){
            $today['run'] = 0;
        }
        if(empty($today['activate'])){
            $today['activate'] = 0;
        }

        $this->assign('total',$total);
        $this->assign('today',$today);
        $this->assign('menu','index');
        $this->assign('coinLog',$coinLog);
        return $this->fetch();
    }
    /*
     * 功能页
     */
    public function menu()
    {
        $this->assign('menu','menu');
        return $this->fetch();
    }
    /*
     * 个人中心
     */
    public function user()
    {
        $uid = session('user')['id'];
        $user = UserModel::tb()->where(['id' => $uid])->find();
        if(empty($user['mobile'])){
            $this->redirect('index/voidMobile');
        }
        $wxUser = ThirdPartyUserModel::tb()->where(['user_id'=>$uid])->find();
        $this->assign('wxuser',$wxUser);
        $this->assign('menu','user');
        return $this->fetch();
    }
    /*
     * 验证手机号
     */
    public function voidMobile(){
        $uid = session('user')['id'];
        $wxUser = ThirdPartyUserModel::tb()->where(['user_id'=>$uid])->find();
        $this->assign('wxuser',$wxUser);
        return $this->fetch();
    }
    public function doVoidMobile(){
        if ($this->request->isPost()) {
            $rules = [
                'username'  => 'require',
                'code'     => 'require',
                'password' => 'require|min:6|max:32',

            ];

            $validate = new Validate($rules);
            $validate->message([
                'code.require'     => '验证码不能为空',
                'username.require' => '手机号不能为空',
                'password.require' => '密码不能为空',
                'password.max'     => '密码不能超过32个字符',
                'password.min'     => '密码不能小于6个字符',
            ]);

            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }


            $errMsg = cmf_check_verification_code($data['username'], $data['code']);
            if (!empty($errMsg)) {
                $this->error($errMsg);
            }

            $user['user_pass'] = $data['password'];
            $user['mobile'] = $data['username'];
            if (preg_match('/(^(13\d|15[^4\D]|17[13678]|18\d)\d{8}|170[^346\D]\d{7})$/', $data['username'])) {
                $user['user_login'] = $data['username'];
                $result = UserModel::tb()->where('mobile', $user['mobile'])->find();

                if (empty($result)) {
                    $data = [
                        'id' => session('user')['id'],
                        'mobile' => $user['mobile'],
                        'user_pass' => cmf_password($user['user_pass']),
                        'last_login_ip' => get_client_ip(0, true),
                        'create_time' => time(),
                        'last_login_time' => time(),
                        'user_status' => UserModel::STATUS_NORMAL,
                    ];
                    UserModel::tb()->update($data);
                    $log = 0;
                }else{
                    $log = 1;
                }
            } else {
                $log = 2;
            }
            $sessionLoginHttpReferer = session('login_http_referer');
            $redirect                = empty($sessionLoginHttpReferer) ? cmf_get_root() . '/' : $sessionLoginHttpReferer;
            switch ($log) {
                case 0:
                    $this->success('成功', $redirect);
                    break;
                case 1:
                    $this->error("手机号已注册过");
                    break;
                case 2:
                    $this->error("您输入的手机号格式错误");
                    break;
                default :
                    $this->error('未受理的请求');
            }

        } else {
            $this->error("请求错误");
        }
    }
}
