<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/27
 * Time: 下午3:45
 */

namespace app\admin\service;


use app\admin\model\TerminaModel;
use think\Db;

class TerminaService
{
    public static function getListByUid($uid,$status=null){
        $where['uid'] = $uid;
        if(!empty($status)){
            $where['status'] = $status;
        }
        $ret = TerminaModel::tb()->where($where)->select();
        return $ret;
    }
    public static function getListByPid($pid,$status=null,$is_ok=null){
        $where['pid'] = $pid;
        if(!empty($status)){
            $where['status'] = $status;
        }
        if(!empty($is_ok)){
            $is_ok = $is_ok == 1?1:0;
            $where['is_ok'] = $is_ok;
        }
        $ret = TerminaModel::tb()->where($where)->select();
        return $ret;
    }
    //终端激活处理
    public static function doActive($id,$isMoney = false)
    {
        $data['id'] = $id;
        $data['is_ok'] = 1;
        Db::startTrans();
        $ret = TerminaModel::tb()->update($data);
        if($ret > 0){
            if($isMoney){
                $row_pos = TerminaModel::tb()->find($id);
                $coin = 99;
                $data_f = [
                    'uid' => $row_pos['uid'],
                    'coin' => $coin,
                    'type' => 'activate',
                    'detail' => '激活'.$row_pos['code'].'奖励',
                    'status' => 1,
                ];
                $ret = CoinLogService::addCoinLog($data_f);
                if(!$ret){
                    Db::rollback();
                    return -1;
                }
                $retCoin = CoinService::changeCoin($row_pos['uid'],'activate',$coin);
                if(!$retCoin){
                    Db::rollback();
                    return -1;
                }
            }
            Db::commit();
            return 1;
        }else{
            return 0;
        }
    }
}