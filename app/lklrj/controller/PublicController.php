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


use app\lklrj\service\ApiService;
use app\lklrj\service\UserService;
use app\user\model\UserModel;
use cmf\controller\HomeBaseController;
use think\Db;
use think\Validate;

class PublicController extends HomeBaseController
{
    // 主页入口
    public function index(){
        return $this->fetch();
    }
    //注册页面
    public function register(){
        $pid = isset($_GET['pid'])?$_GET['pid']:1;
        //微信则直接注册
        if(cmf_is_wechat()){
            $this->redirect('wx/auth',array('pid'=>$pid));
        }
        $this->assign('pid',$pid);
        return $this->fetch();
    }
    // 登录页面
    public function login()
    {
        return $this->fetch();
    }
    //找回密码页面
    public function findPwd(){
        return $this->fetch();
    }
    //登录拉卡拉帐号
    public function doLogin(){
        $data = input('post.');
        $where = [
            'mark' => 'login'
        ];
        $params = [
            'loginName' => $data['username'],
            'userPwd' => $data['passpword'],
            'code' => $data['code']
        ];
        $res = ApiService::getApi($where,$params);

        if($res['retCode'] == 000000){
            $msg = $res['retMsg'];
            $data['sid'] = $res['retData']['sessionId'];
            $data['org_name'] = $res['retData']['compOrgName'];
            $data['org_code'] = $res['retData']['compOrgCode'];
            UserService::doLoginUser($data);
            $this->success($msg,'Index/index');
        }else{
            $msg = $res['retMsg'];
        }
        $this->error($msg);
    }
    //登录帐号
    public function loginUser(){
        if ($this->request->isPost()) {
            $rules = [
                'username'  => 'require',
                'password' => 'require',

            ];

            $validate = new Validate($rules);
            $validate->message([
                'username.require' => '手机号不能为空',
                'password.require' => '密码不能为空',
            ]);

            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            $userModel         = new UserModel();
            $user['user_pass'] = $data['password'];
            if (preg_match('/(^(13\d|15[^4\D]|17[13678]|18\d)\d{8}|170[^346\D]\d{7})$/', $data['username'])) {
                $user['mobile'] = $data['username'];
                $uInfo = Db::name('user')->where(['mobile'=>$data['username']])->find();
                if($uInfo['user_status'] == 0){
                    $this->error('用户已经被禁用');
                }
                $log            = $userModel->doMobile($user);
            } else {
                $user['user_login'] = $data['username'];
                $log                = $userModel->doName($user);
            }
            $session_login_http_referer = session('login_http_referer');
            $redirect                   = empty($session_login_http_referer) ?  cmf_get_root() . '/' : $session_login_http_referer;
            switch ($log) {
                case 0:
                    $this->success('登录成功', $redirect);
                    break;
                case 1:
                    $this->error('登录密码错误');
                    break;
                case 2:
                    $this->error('账户不存在');
                    break;
                case 3:
                    $this->error('账户被拉黑');
                    break;
                default :
                    $this->error('未受理的请求');
            }
        } else {
            $this->error("请求错误");
        }
    }
    /*
     * 注册帐号
     */
    public function registerUser(){
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
            $user['user_nickname'] = $data['username'];
            if (preg_match('/(^(13\d|15[^4\D]|17[13678]|18\d)\d{8}|170[^346\D]\d{7})$/', $data['username'])) {
                $user['mobile'] = $data['username'];
                $user['user_login'] = $data['username'];
                $user['pid'] = isset($data['pid'])?$data['pid']:1;
                $result = Db::name("user")->where('mobile', $user['mobile'])->find();

                if (empty($result)) {
                    $data = [
                        'pid' => $user['pid'],
                        'user_login' => $user['user_login'],
                        'user_email' => '',
                        'mobile' => $user['mobile'],
                        'user_nickname' => $user['user_nickname'],
                        'user_pass' => cmf_password($user['user_pass']),
                        'last_login_ip' => get_client_ip(0, true),
                        'create_time' => time(),
                        'last_login_time' => time(),
                        'user_status' => 1,
                        "user_type" => \app\admin\model\UserModel::TYPE_LKL_AGENT,
                    ];
                    $userId = Db::name("user")->insertGetId($data);
                    $data = Db::name("user")->where('id', $userId)->find();
                    cmf_update_current_user($data);
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
                    $this->success('注册成功', $redirect);
                    break;
                case 1:
                    $this->error("您的账户已注册过");
                    break;
                case 2:
                    $this->error("您输入的账号格式错误");
                    break;
                default :
                    $this->error('未受理的请求');
            }

        } else {
            $this->error("请求错误");
        }
    }
    /*
     * 找回密码
     */
    public function doFindPwd(){
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
            $uInfo = Db::name('user')->where(['mobile'=>$data['username']])->find();
            if($uInfo['user_status'] == 0){
                $this->error('用户已经被禁用');
            }

            $user['user_pass'] = cmf_password($data['password']);
            if(Db::name('user')->where(['mobile'=>$data['username']])->update($user)){
                $this->success('成功','/public/index');
            }

        } else {
            $this->error("请求错误");
        }
    }

    /*
     * 分享二维码
     */
    public function shareCode(){
        $uid = session('user')['id'];
        $uInfo = \app\admin\model\UserModel::getInfoById($uid);
        $url = url('public/register',array('pid'=>$uid));
        $qrcode = './themes/apitp/public/qrcode/qrlogo'.$uid.'.png';
        if (!file_exists($qrcode)) {
            $logo = './themes/apitp/public/assets/images/logo.png';
            crQrcode($url,$qrcode,$logo);
        }
        $imgurl = '/public/qrcode/qrlogo'.$uid.'.png';
        $this->assign('imgurl',$imgurl);
        $this->assign('user',$uInfo);
        return $this->fetch();
    }

    /*
     * 退出登录
     */
    public function logout(){
        session('user', null);
        $this->redirect('Public/index');
    }

    /*
     * 发送验证码
     */
    public function sendmsg()
    {
        $validate = new Validate([
            'username' => 'require',
        ]);

        $validate->message([
            'username.require' => '请输入手机号!',
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }
        $accountType = '';

        if (preg_match('/(^(13\d|15[^4\D]|17[13678]|18\d)\d{8}|170[^346\D]\d{7})$/', $data['username'])) {
            $accountType = 'mobile';
        } else {
            $this->error("请输入正确的手机格式!");
        }

        //TODO 限制 每个ip 的发送次数

        $code = cmf_get_verification_code($data['username']);
        if (empty($code)) {
            $this->error("验证码发送过多,请明天再试!");
        }

        if ($accountType == 'mobile') {

            $param  = ['mobile' => $data['username'], 'code' => $code];
            $result = hook_one("send_mobile_verification_code", $param);

            if ($result !== false && !empty($result['error'])) {
                $this->error($result['message']);
            }

            if ($result === false) {
                $this->error('未安装验证码发送插件,请联系管理员!');
            }

            cmf_verification_code_log($data['username'], $code);

            if (!empty($result['message'])) {
                $this->success($result['message']);
            } else {
                $this->success('验证码已经发送成功!');
            }

        }


    }
}
