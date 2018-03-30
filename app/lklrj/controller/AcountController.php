<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/8
 * Time: 下午3:20
 */

namespace app\lklrj\controller;


use app\admin\model\CoinLogModel;
use app\admin\model\CoinModel;
use app\admin\model\UserModel;

class AcountController extends BaseController
{
    public function index(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);
        $account = CoinModel::getInfoById($uid);
        $account['coin'] = $uInfo['coin'];

        $coinLog = CoinLogModel::tb()->where(['uid'=>$uid])->paginate(5);
        $page = $coinLog->render();

        $this->assign('list', $coinLog);
        $this->assign('page', $page);
        $this->assign('account',$account);
        return $this->fetch();
    }
}