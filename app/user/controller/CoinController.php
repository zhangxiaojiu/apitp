<?php

namespace app\user\controller;

use think\Validate;
use cmf\controller\UserBaseController;
use app\user\model\UserModel;
use app\user\model\CoinModel;
use think\Db;

class CoinController extends UserBaseController
{

    function _initialize()
    {
        parent::_initialize();
    }

    public function center()
    {

        $m_user = new UserModel();
        $uid = session('user.id');
        $user = $m_user->getInfoById($uid);
        $this->assign($user);

        if($user['user_type'] == 3){
            $gjuserSettings    = cmf_get_option('gjuser_settings');
            $txcoin = $gjuserSettings['tx'];
        }else{
            $ptuserSettings    = cmf_get_option('ptuser_settings');
            $txcoin = $ptuserSettings['tx'];
        }
        
        $this->assign('txcoin',$txcoin);
        return $this->fetch();
    }

    public function dotopup()
    {
        $m_user = new UserModel();
        $uid = session('user.id');
        $user = $m_user->getInfoById($uid);

        $data = $_POST;
        $validate = new Validate([
            'coin' => 'require|integer',
            'account'     => 'require',
        ]);
        $validate->message([
            'coin.require' => '提现金额不能为空',
            'account.require'     => '提现账号不能为空',
            'coin.integer'       => '提现金额必须是整数',
        ]);

        $data = $this->request->post();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        if($user['user_type'] == 3){
            $gjuserSettings    = cmf_get_option('gjuser_settings');
            $txcoin = $gjuserSettings['tx'];
        }else{
            $ptuserSettings    = cmf_get_option('ptuser_settings');
            $txcoin = $ptuserSettings['tx'];
        }
        if($data['coin'] < $txcoin){
            $this->error("提现最少金额为$txcoin");
        }
        if(intval($data['coin'])%intval($txcoin) != 0){
            $this->error("提现金额必须是{$txcoin}的整数倍");
        }
        if($data['coin'] > $user['coin']){
            $this->error('您的余额不足');
        }

        $data_f = [
            'uid' => session('user.id'),
            'coin' => 0-$data['coin'],
            'type' => 'tx',
            'detail' => $data['type']."账号:".$data['account'],
            'status' => 0,
        ];
        $m_coin = new CoinModel();

        $id = $m_coin->addCoinLog($data_f);
        if($id > 0){
            $this->success("提现成功");
        }

    }

    public function dotransfer()
    {
        $m_user = new UserModel();
        $uid = session('user.id');
        $user = $m_user->getInfoById($uid);

        $data = $_POST;
        $validate = new Validate([
            'coin' => 'require|integer',
            'account'     => 'require',
        ]);
        $validate->message([
            'coin.require' => '转账金额不能为空',
            'account.require'     => '转账账号不能为空',
            'coin.integer'       => '转账金额必须是整数',
        ]);

        $data = $this->request->post();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        if($user['user_type'] == 3){
            $gjuserSettings    = cmf_get_option('gjuser_settings');
            $txcoin = $gjuserSettings['tx'];
        }else{
            $ptuserSettings    = cmf_get_option('ptuser_settings');
            $txcoin = $ptuserSettings['tx'];
        }
        if($data['coin'] < $txcoin){
            $this->error("转账最少金额为$txcoin");
        }
        if(intval($data['coin'])%intval($txcoin) != 0){
            $this->error("转账金额必须是{$txcoin}的整数倍");
        }
        if($data['coin'] > $user['coin']){
            $this->error('您的余额不足');
        }
        $touser = Db::name('user')->where('mobile',$data['account'])->find();
        if(!$touser){
            $this->error('对方账户错误');
        }

        $m_coin = new CoinModel();
        //转账out
        $data_f = [
            'uid' => session('user.id'),
            'coin' => 0-$data['coin'],
            'type' => 'zz',
            'detail' => "转账到{$touser['mobile']}",
            'status' => 1,
        ];
        $id = $m_coin->addCoinLog($data_f,true);
        //转账in

        $data_f = [
            'uid' => $touser['id'],
            'coin' => $data['coin'],
            'type' => 'zz',
            'detail' => "转账来自{$touser['mobile']}",
            'status' => 1,
        ];
        $id = $m_coin->addCoinLog($data_f,true);
        if($id > 0){
            $this->success("转账成功");
        }
    }

    public function log()
    {
        $uid = session('user.id');
        $m_coin = new CoinModel();
        $lists = $m_coin->getList();
        $this->assign('lists', $lists);
        return $this->fetch(); 
    }
}