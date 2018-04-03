<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/5
 * Time: 17:42
 */

namespace app\lklrj\controller;


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
        $uid = $_REQUEST['uid'];
        $uInfo = UserModel::tb()->find($uid);
        $tList = TerminaModel::tb()->where(['uid'=>$uid])->paginate(10);
        $this->assign('info',$uInfo);
        $this->assign('num',count($tList));
        $this->assign('list',$tList);
        return $this->fetch();
    }
}