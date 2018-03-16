<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/8
 * Time: 下午5:32
 */

namespace app\lklrj\service;


use app\admin\model\MerchantModel;
use app\user\model\UserModel;

class MerchantService
{
    /*
     * 同步商户信息
     */
    public static function syncMerchant($id,$sid){
        self::syncOneMerchant(session('lkl_user')['org_code'],$sid);
        $where = [
            'pid'=>$id,
        ];
        $list = UserModel::tb()->where($where)->select();
        foreach ($list as $v){
            $code = $v['lkl_org_code'];
            self::syncOneMerchant($code,$sid);
        }
    }

    /*
     * 同步第一页代理的商户信息
     */
    public static function syncOneMerchant($code,$sid){
        $where = [
            'mark' => 'queryMerchant',
        ];
        $params = [
            'sessionId' => $sid,
            'group' => $code,
            'start' => 0,
            'limit' => 10,
        ];
        $ret = ApiService::getApi($where,$params);
        if($ret['retCode'] == '000000'){
            self::perfectMerchant($ret['retData']['data']);
            $total = $ret['retData']['totalNum'];
            if($total > 10) {
                self::syncOtherMerchant($sid, $code, $total);
            }
        }
    }
    /*
     * 同步剩余代理商户信息
     */
    private static function syncOtherMerchant($sid,$code,$total){
        $num = ceil($total/10);
        for($i=1; $i<$num; $i++){
            $start = $i*10;
            $where = [
                'mark' => 'queryMerchant',
            ];
            $params = [
                'sessionId' => $sid,
                'group' => $code,
                'start' => $start,
                'limit' => 10,
            ];
            $ret = ApiService::getApi($where,$params);
            if($ret['retCode'] == '000000'){
                self::perfectMerchant($ret['retData']['data']);
            }
        }
    }

    /*
     * 完善商户信息
     */
    private static function perfectMerchant($list){
        foreach ($list as $v){
            $info = MerchantModel::tb()->where(['merchant_code' => $v['posmercode']])->find();

            $data = [
                'pid' => session('lkl_user')['id'],
                'merchant_code' => isset($v['posmercode'])?$v['posmercode']:'',
                'merchant_name' => isset($v['merchantName'])?$v['merchantName']:'',
                'agent_id' => isset($v['group'])?$v['group']:'',
                'real_name' => isset($v['contactName'])?$v['contactName']:'',
                'mobile' => isset($v['contactMobile'])?$v['contactMobile']:'',
                'mobile' => isset($v['contactMobile'])?$v['contactMobile']:'',
                'user_card' => isset($v['userCertNo'])?$v['userCertNo']:'',
                'address' => isset($v['areaName'])?$v['areaName']:''.isset($v['address'])?$v['address']:'',
                'bank_name' => isset($v['bankName'])?$v['bankName']:'',
                'bank_user' => isset($v['accountName'])?$v['accountName']:'',
                'bank_card' => isset($v['accountNo'])?$v['accountNo']:'',
                'email' => isset($v['email'])?$v['email']:'',
                'type' => 'lkl',
                'update_time' => time(),
            ];

            if($info){
                $data['id'] = $info['id'];
                MerchantModel::tb()->update($data);
            }else{
                MerchantModel::tb()->insert($data);
            }
        }
    }
}