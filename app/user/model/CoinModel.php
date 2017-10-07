<?php

namespace app\user\model;

use think\Db;
use think\Model;
use think\Validate;

class CoinModel extends Model
{
	public function getList()
	{
		$m_coin = Db::name('coin_log');
		$list = $m_coin->where('uid',session('user.id'))->order("create_time DESC")->paginate(10);
		return $list;
	}

	public function getListByType($type)
	{
		$m_coin = Db::name('coin_log');
		$list = $m_coin->where(['type'=>$type])->order("status, create_time")->paginate(10);
		return $list;
	}

	public function txPass($id){
		$m_coin = Db::name('coin_log');
		$ret = $m_coin->where('id',$id)->setField('status', 1);
		return $ret;
	}

	public function addCoinLog($data)
	{
		$m_coin = Db::name('coin_log');
		$m_user = Db::name('user');
		$data_coin = [
			'uid' => isset($data['uid'])?$data['uid']:0,
			'coin' => isset($data['coin'])?$data['coin']:0,
			'type' => isset($data['type'])?$data['type']:'',
			'detail' => isset($data['detail'])?$data['detail']:'',
			'status' => isset($data['status'])?$data['status']:0,
			'create_time' => time()
		];

		if($data['coin'] != 0){
			$user = $m_user->where('id',$data['uid'])->find();
			$data_user = [
				"id" => $data_coin['uid'],
				'coin' => $user['coin'] + $data_coin['coin'],
			];
			$m_user->update($data_user);
		}
		return $m_coin->insertGetId($data_coin);
	}
}