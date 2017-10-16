<?php

namespace app\user\model;

use think\Db;
use think\Model;
use app\user\model\AdminUserModel;
use app\user\model\CoinModel;

class AdminDealModel extends Model
{
	/*
	*获取交易记录
	*adminId:大代理ID
	*qyjg:签约机构
	*code:机具号
	*date:日期
	*/
	private static function getDb(){
		return Db::name('deal');
	}
	private static function getD0(){
		return Db::name('deal_d0');
	}
	public static function getTotal($arr){
		$sumJie = 0;
		$sumDie = 0;
		foreach($arr as $val){
			if($val['cardtype'] == '借记卡'){
				$sumJie += $val['dealcoin'];
			}
			if($val['cardtype'] == '贷记卡'){
				$sumDie += $val['dealcoin'];
			}
		}

		$res['jie_total'] = $sumJie;
		$res['die_total'] = $sumDie;

		return $res;
	}
	//获取记录
	public static function getRecord($adminId=null,$qyjg=null,$date=null,$cardtype=null){
		$where = [];
		$role = AdminUserModel::getRole($adminId);
		if($role['name'] == "大代理"){
	      	$where['admin_id']  = $adminId;
	    }
	    if(!empty($qyjg)){
	    	$where['qyjg'] = $qyjg;
	    }
	    if($role['name'] == "代理商"){
	      	$where['qyjg']  = session('name');;
	    }
	    if(!empty($cardtype)){
	    	$where['cardtype'] = $cardtype;
	    }
	    if(!empty($date)){
	    	$where['dealtime'] = $date;
	    }else{
	    	$where['dealtime'] = date("Y-m-d",time()-60*60*24);
	    }
	    $res = self::getDb()->where($where)->select();
		return $res;
	}
	//获取d0记录
	public static function getD0Record($adminId=null,$qyjg=null,$date=null){
		$where = [];
		$role = AdminUserModel::getRole($adminId);
		if($role['name'] == "大代理"){
	      	$where['admin_id']  = $adminId;
	    }
	    if(!empty($qyjg)){
	    	$where['qyjg'] = $qyjg;
	    }
	    if($role['name'] == "代理商"){
	      	$where['qyjg']  = session('name');;
	    } 
	    if(!empty($date)){
	    	$likeDate = str_replace('-', '', $date)."%";
	    	$where['time'] = array('like',$likeDate);;
	    }else{
	    	$where['time'] = date("Y-m-d",time()-60*60*24);	
	    }
	    $res = self::getD0()->where($where)->select();
		return $res;
	}
	//获取d0统计
	public static function getD0Total($arr){
		$sum = 0;
		foreach($arr as $val){
			$sum += $val['fee'];
		}

		$res['total'] = $sum;
		$res['num'] = count($arr);

		return $res;
	}
	//未变现分润
	public static function getUnCash(){
		$where['state'] = 0;
		$adminId = session('ADMIN_ID');
		$role = AdminUserModel::getRole($adminId);
		if($role['name'] == "大代理"){
	      	$where['admin_id']  = $adminId;
	    }
	    if($role['name'] == "代理商"){
	      	$where['qyjg']  = session('name');;
	    }
	    $deal['cardtype'] = "借记卡";
	    $jie_total = self::getDb()->where($where)->where($deal)->sum('dealcoin');
	    $deal['cardtype'] = "贷记卡";
	    $die_total = self::getDb()->where($where)->where($deal)->sum('dealcoin');

	    $d_total = self::getD0()->where($where)->sum('fee');
	    $d_num = self::getD0()->where($where)->count();

	    $user_conf = AdminUserModel::getConf($adminId);
	    if(empty($user_conf)){
	      $res['jie_fee'] = $res['die_fee'] = $res['d_fee'] = $res['all_fee'] = 0;
	    }else{
	      $res['jie_fee'] = $user_conf['jie_fee'];
	      $res['die_fee'] = $user_conf['die_fee'];
	      $res['d_fee'] = $user_conf['d_fee'];
	      $res['all_fee'] = $user_conf['all_fee'];
	    }

	    $total = round(($die_total*$res['die_fee']/100+$jie_total*$res['jie_fee']/100+$d_total-($d_num*$res['d_fee']))*$res['all_fee'],2);
	    return $total;
	}
	//变现
	public static function cashCoin(){	
	    $coin = self::getUnCash();
	    if($coin > 0){
	    	$where['state'] = 0;
			$adminId = session('ADMIN_ID');
			$role = AdminUserModel::getRole($adminId);
			if($role['name'] == "大代理"){
		      	$where['admin_id']  = $adminId;
		    }
		    if($role['name'] == "代理商"){
		      	$where['qyjg']  = session('name');;
		    }

	    	$dealRec = self::getDb()->where($where)->select();
		    $deal_in = self::getInArr('id',$dealRec);
		    $deal_num = count($dealRec);    

		    $dRec = self::getD0()->where($where)->select();
		    $d_in = self::getInArr('id',$dRec);
		    $d_num = count($dRec);

	    	$data_f = [
	            'uid' => $adminId,
	            'coin' => $coin,
	            'type' => 'bx',
	            'detail' => "分润变现：交易列表".$deal_num."条，D0列表".$d_num."条",
	            'status' => 1,
	        ];
	        self::getDb()->where(array('id'=>array('in',$deal_in)))->update(array('state'=>1));
	        self::getD0()->where(array('id'=>array('in',$d_in)))->update(array('state'=>1));
	        $m_coin = new CoinModel();

	        $id = $m_coin->addCoinLog($data_f);
	        if($id > 0 && $coin>0){
	            return true;
	        }
	    }
	    return false;
	}
	private static function getInArr($field,$arr){
		$in = '';
		foreach ($arr as $key => $value) {
			$in .= $value[$field].',';
		}
		return trim($in,',');
	}
}