<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/5
 * Time: 17:42
 */

namespace app\lklrj\controller;


use app\admin\model\CoinLogModel;
use app\admin\model\TerminaModel;
use app\user\model\UserModel;

class AgentController extends BaseController
{
    public function index(){
        $uid = session('user')['id'];
        $list = UserModel::tb()->where(['pid'=>$uid,'user_status'=>1])->paginate(10);
        $num = UserModel::tb()->where(['pid'=>$uid,'user_status'=>1])->count();
        // 获取分页显示
        $page = $list->render();

        $this->assign('num',$num);
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
    public function terminal(){
        $uid = isset($_REQUEST['uid'])?$_REQUEST['uid']:session('terminal_agent_uid');
        session('terminal_agent_uid',$uid);
        $uInfo = UserModel::tb()->find($uid);
        $tList = TerminaModel::tb()->where(['uid'=>$uid])->paginate(10);
        $activateNum = TerminaModel::tb()->where(['uid'=>$uid,'is_ok'=>1])->count();
        $num = TerminaModel::tb()->where(['uid'=>$uid])->count();
        $todayTime = strtotime(date('Y-m-d',time()));
        $todayActivateNum = CoinLogModel::tb()->where(['type'=>'activate','uid'=>$uid,'create_time'=>['>',$todayTime]])->count();
        $activate['num'] = $activateNum;
        $activate['today'] = $todayActivateNum;
        $this->assign('activate',$activate);
        $this->assign('info',$uInfo);
        $this->assign('num',$num);
        $this->assign('list',$tList);
        return $this->fetch();
    }
}