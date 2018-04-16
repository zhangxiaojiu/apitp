<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/27
 * Time: 下午3:45
 */

namespace app\admin\service;


use app\admin\model\TerminaModel;
use app\admin\model\ThirdPartyUserModel;
use app\admin\model\UserModel;
use app\lklrj\service\WxService;
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
            $coin = 0;
            $row_pos = TerminaModel::tb()->find($id);
            if($isMoney){
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
            //微信模版消息
            $wxUser = ThirdPartyUserModel::tb()->where(['user_id'=>$row_pos['uid']])->find();
            if(!empty($wxUser)) {
                $openId = $wxUser['openid'];
                $uInfo = UserModel::getInfoById($id);
                $type = '2';//激活机器
                $remark = '尊敬的会员您好，你的机器'.$row_pos['code'].'激活成功，返现¥'.$coin.'，请及时查收。';
                WxService::tmpAccountChange($openId, $type, $uInfo['user_nickname'], $remark);
            }
            return 1;
        }else{
            return 0;
        }
    }
}