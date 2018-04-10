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
        $cInfo = CoinModel::getInfoById($uid);

        $account['run'] = isset($cInfo['run'])?$cInfo['run']:0;
        $account['activate'] = isset($cInfo['activate'])?$cInfo['activate']:0;
        $account['diff_run'] = isset($cInfo['diff_run'])?$cInfo['diff_run']:0;
        $account['coin'] = $uInfo['coin'];

        $coinLog = CoinLogModel::tb()->where(['uid'=>$uid])->order('create_time desc')->limit(5)->select();

        $this->assign('list', $coinLog);
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

        if($data['coin'] < 0){
            $this->error('请输入正确金额');
        }

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

    /*
     * 资金记录
     */
    public function acountList(){
        $uid = session('user')['id'];
        $where = [];
        $where['uid'] = $uid;
        $request = input('request.');
        if (!empty($request['type'])) {
            $where['type'] = $request['type'];
        }

        $list = CoinLogModel::tb()->where($where)->order('create_time DESC')->paginate(5);
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}