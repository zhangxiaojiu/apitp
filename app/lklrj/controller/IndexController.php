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
        $wxUser = ThirdPartyUserModel::tb()->where(['user_id'=>$uid])->find();
        $this->assign('wxuser',$wxUser);
        $this->assign('menu','user');
        return $this->fetch();
    }
    /*
     * 验证手机号
     */
    public function voidMobile(){
        $this->fetch();
    }
}
