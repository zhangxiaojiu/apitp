<?php

namespace app\user\model;

use think\Db;
use think\Model;
use think\Validate;
use app\user\model\CoinModel;

class PosModel extends Model
{
	public function getUserCidStatus($id)
	{
		$sta = Db::name('pos')->where('cid',$id)->value('status');
		return $sta;
	}

   public function doBind($id,$uid)
   {
        $data['id'] = $id;
        $data['uid'] = $uid;
        $data['status'] = 1;
        $data['time'] = time();
        $ret = Db::name('pos')->update($data);
        if($ret > 0){
            return 1;
        }else{
            return 0;
        }
   }

   public function doUnbind($id)
   {
        $data['id'] = $id;
        $data['status'] = 0;
        $data['time'] = 0;
        $data['uid'] = 0;

        $ret = Db::name('pos')->update($data);
        if($ret > 0){
            return 1;
        }else{
            return 0;
        }
   }

   

   public function doActive($id,$isMoney = false)
   {
   		$data['id'] = $id;
   		$data['status'] = 2;

   		$ret = Db::name('pos')->update($data);
        if($ret > 0){
        	if($isMoney){
        		$m_coin = new CoinModel();
        		$row_pos = Db::name('pos')->find($id);

            $gjuserSettings    = cmf_get_option('gjuser_settings');
            $ptuserSettings    = cmf_get_option('ptuser_settings');

            $user = Db::name('user')->find($row_pos['uid']);
            if($user['user_type'] == 3){
                $fxcoin = $gjuserSettings['fx'];
            }else{
                $fxcoin = $ptuserSettings['fx'];
            }
        		$data_f = [
	                'uid' => $row_pos['uid'],
	                'coin' => $fxcoin,
	                'type' => 'active',
	                'detail' => '激活'.$row_pos['code'].'奖励',
	                'status' => 1,
	            ]; 
	            $m_coin->addCoinLog($data_f);

	            if($user['pid']>0){
                $puser = Db::name('user')->find($user['pid']);
                if($puser['user_type'] == 3){
                    $pfxcoin = $gjuserSettings['pfx'];
                }else{
                    $pfxcoin = $ptuserSettings['pfx'];
                }
	            	$data_f_p = [
		                'uid' => $user['pid'],
		                'coin' => $pfxcoin,
		                'type' => 'active',
		                'detail' => '下级激活'.$row_pos['code'].'奖励',
		                'status' => 1,
		            ]; 
		            $m_coin->addCoinLog($data_f_p);

		            if($puser['pid']>0){
                  $ppuser = Db::name('user')->find($puser['pid']);
                  if($ppuser['user_type'] == 3){
                      $ppfxcoin = $gjuserSettings['ppfx'];
                  }else{
                      $ppfxcoin = $ptuserSettings['ppfx'];
                  }
		            	$data_f_pp = [
			                'uid' => $puser['pid'],
			                'coin' => $ppfxcoin,
			                'type' => 'active',
			                'detail' => '下下级激活'.$row_pos['code'].'奖励',
			                'status' => 1,
			            ]; 
			            $m_coin->addCoinLog($data_f_pp);
			        }
	            }
        	}
            return 1;
        }else{
            return 0;
        }
   }

   public function getChildList($id)
   {
      $list = Db::name('user')->where('pid',$id)->select();
      return $list;
   }

   public function listGetPos($list,$level)
   {
      $new_list = array();
      foreach($list as $k => $v){
        $p_row = Db::name('pos')->where(['uid'=>$v['id'], 'status'=>2])->find();
        $new_list[$v['id']] = $v;
        $new_list[$v['id']]['level'] = $level;
        if($p_row){
          $new_list[$v['id']]['code'] = $p_row['code'];
          $new_list[$v['id']]['is_active'] = '已激活';
          $active_pos = Db::name('pos')->where(['uid'=>$v['id'], 'status'=>2])->select();
          $active_num = count($active_pos);
          $new_list[$v['id']]['active_num'] = $active_num;
        }else{
          $new_list[$v['id']]['code'] = "";
          $new_list[$v['id']]['is_active'] = '未激活';
          $new_list[$v['id']]['active_num'] = "";
        }
        $p_row = null;
      }
      return $new_list;
   }

}