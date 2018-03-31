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
use app\admin\service\CoinLogService;

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

    public function withdraw(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);

        $this->assign('info',$uInfo);
        return $this->fetch();
    }

    /*
     * 提现
     */
    public function doWithdraw(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);
        $data = $_POST;

        if($data['coin'] > $uInfo['coin']){
            $this->error('余额不足');
        }

        $remark = empty($data['detail'])?'无':$data['detail'];
        $data_f= [
            'uid' => $uid,
            'coin' => 0-$data['coin'],
            'type' => 'withdraw',
            'detail' => '(备注:'.$remark.')提现到'.$data['type'],
            'status' => 0,
        ];
        $clRet = CoinLogService::addCoinLog($data_f);
        if($clRet) {
            $this->success('提现成功,请等待审核');
        }
    }
}