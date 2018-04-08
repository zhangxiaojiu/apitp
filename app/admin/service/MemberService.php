<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/16
 * Time: 下午3:42
 */

namespace app\admin\service;

use app\admin\model\MerchantModel;
use app\admin\model\TerminaModel;
use app\admin\model\TradeModel;
use app\admin\model\UserModel;
use app\lklrj\service\ApiService;


class MemberService
{
    public static function checkLogin($sid){
        $where = [
            'mark' => 'checkLogIn'
        ];
        $params = [
            'sessionId' => $sid,
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }

    public static function getPidArr($uid){
        $uList = UserModel::getListByPid($uid);
        $ret[] = $uid;
        if(count($uList) >= 1){
            foreach ($uList as $v){
                $pRet = self::getPidArr($v['id']);
                $ret = array_merge($ret,$pRet);
            }
        }
        return $ret;
    }

    //返回代理接口
    public static function getApiAgent($sid,$code,$start){
        $where = [
            'mark' => 'getSubAgentListAndDetail',
        ];
        $params = [
            'page' => $start,
            'pageSize' => 10,
            'isChild' => 1,
            'sessionId' => $sid,
            'compOrgParent' => $code,
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }
    //同步代理
    public static function syncAgent($sid,$code,$pid){
        $ret = self::getApiAgent($sid,$code,1);
        if($ret['retCode'] == '000000'){
            self::perfectAgent($ret['retData']['data'],$code,$pid);
            $total = $ret['retData']['count'];
            if($total > 10) {
                self::syncOtherAgent($sid, $code, $total,$pid);
            }
        }
    }
    //同步其他代理
    public static function syncOtherAgent($sid,$code,$total,$pid){
        $num = ceil($total/10);
        for($i=1; $i<$num; $i++){
            $start = $i+1;
            $ret = self::getApiAgent($sid,$code,$start);
            if($ret['retCode'] == '000000'){
                self::perfectAgent($ret['retData']['data'],$code,$pid);
            }
        }
    }
    /*
   * 完善代理商信息
   */
    private static function perfectAgent($list,$code,$pid){
        foreach ($list as $v) {
            //当前用户跳过
            if ($v['compOrgCode'] == $code) {
                continue;
            }
            $info = UserModel::tb()->where(['lkl_org_code' => $v['compOrgCode']])->find();

            $data = [
                'pid' => $pid,
                'porg_code' => $code,
                'user_nickname' => isset($v['crName']) ? $v['crName'] : '',
                'lkl_org_code' => isset($v['compOrgCode']) ? $v['compOrgCode'] : '',
                'user_card' => isset($v['crLicenceNo']) ? $v['crLicenceNo'] : '',
                'mobile' => isset($v['detail']['telephone']) ? $v['detail']['telephone'] : '',
                'user_address' => isset($v['detail']['address']) ? $v['detail']['address'] : '',
                'user_email' => isset($v['detail']['beforeEmail']) ? $v['detail']['beforeEmail'] : '',
                'lkl_merchant' => isset($v['detail']['merchantNum']) ? $v['detail']['merchantNum'] : '',
                'lkl_termina' => isset($v['tereminaBdNum']) ? $v['tereminaBdNum'] : '',
                'user_type' => UserModel::TYPE_LKL_AGENT,
                'user_status' => UserModel::STATUS_UNVERIFIED,
                'create_time' => time(),
            ];

            if ($info) {
                //$data['id'] = $info['id'];
                //UserModel::tb()->update($data);
            } else {
                UserModel::tb()->insert($data);
            }
        }
    }

    /*
     * 获取终端接口
     */
    public static function getApiTermina($sid,$code,$start){
        $where = [
            'mark' => 'queryCardsByOrgCode',
        ];
        $params = [
            'sessionId' => $sid,
            'groupCode' => $code,
            'start' => $start,
            'isCallback' => false,
            'limit' => 500,
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }
    //同步第一页
    public static function syncTermina($sid,$code,$pid){
        $ret = self::getApiTermina($sid,$code,0);
        if($ret['retCode'] == '000000'){
            self::perfectTermina($ret['retData']['data'],$code,$pid);
            $total = $ret['retData']['totalNum'];
            if($total > 500) {
                self::syncOtherTermina($sid, $code, $total,$pid);
            }
        }
    }
    //同步其他页
    public static function syncOtherTermina($sid,$code,$total,$pid){
        $num = ceil($total/500);
        for($i=1; $i<$num; $i++){
            $start = $i*500;
            $ret = self::getApiTermina($sid,$code,$start);
            if($ret['retCode'] == '000000'){
                self::perfectTermina($ret['retData']['data'],$code,$pid);
            }
        }
    }
    private static function perfectTermina($list,$code,$pid){
        $user = UserModel::tb()->where(['lkl_org_code' => $code])->find();
        foreach ($list as $v){
            $info = TerminaModel::tb()->where(['code' => $v['cardNo']])->find();

            $data = [
                'status' => isset($v['status'])?$v['status']:0,
                'detail' => isset($v['statusName'])?$v['statusName']:'未定义',
                'time' => time(),
            ];

            if($info){
                $data['id'] = $info['id'];
                TerminaModel::tb()->update($data);
            }else{
                $data['code'] = isset($v['cardNo'])?$v['cardNo']:'';
                $data['pid'] = $pid;
                $data['uid'] = $user['id'];
                $data['cid'] = isset($v['org'])?$v['org']:'';
                TerminaModel::tb()->insert($data);
            }
        }
    }

    /*
     * 获取商户接口
     */
    public static function getApiMerchant($sid,$code,$start){
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
        return $ret;
    }
    /*
     * 同步第一页代理的商户信息
     */
    public static function syncMerchant($sid,$code,$pid){
        $ret = self::getApiMerchant($sid,$code,0);
        if($ret['retCode'] == '000000'){
            self::perfectMerchant($ret['retData']['data'],$pid);
            $total = $ret['retData']['totalNum'];
            if($total > 10) {
                self::syncOtherMerchant($sid, $code, $total,$pid);
            }
        }
    }
    /*
     * 同步剩余代理商户信息
     */
    private static function syncOtherMerchant($sid,$code,$total,$pid){
        $num = ceil($total/10);
        for($i=1; $i<$num; $i++){
            $start = $i*10;
            $ret = self::getApiMerchant($sid,$code,$start);
            if($ret['retCode'] == '000000'){
                self::perfectMerchant($ret['retData']['data'],$pid);
            }
        }
    }
    /*
     * 完善商户信息
     */
    private static function perfectMerchant($list,$pid){
        foreach ($list as $v){
            $info = MerchantModel::tb()->where(['merchant_code' => $v['posmercode']])->find();

            $data = [
                'pid' => $pid,
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
//                $data['id'] = $info['id'];
//                MerchantModel::tb()->update($data);
            }else{
                MerchantModel::tb()->insert($data);
            }
        }
    }

    /*
     * 返回交易接口
     */
    public static function getApiTrade($sid,$code,$start,$startDate,$endDate){
        $where = [
            'mark' => 'queryTrade',
        ];
        $params = [
            'sessionId' => $sid,
            'signOrg' => $code,
            'transCode' => 'P_ALL',
            'type' => 'T_01',
            'pageNo' => $start,
            'pageSize' => 10,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }
    /*
     * 同步月交易
     */
    public static function syncMonthTrade($sid,$code){
        $startDate = date('Ym').'01';
        $endDate = date('Ymd');
        $ret = self::getApiTrade($sid,$code,1,$startDate,$endDate);
        if($ret['retCode'] == 'SUCCESS'){
            self::perfectTrade($ret['retData']['content']['resultModel']['rows'],$code);
            $total = $ret['retData']['content']['resultModel']['totalPage'];
            if($total > 1){
                self::syncOtherTrade($sid,$code,$total,$startDate,$endDate);
            }
        }
    }
    //同步剩余记录
    public static function syncOtherTrade($sid,$code,$total,$startDate,$endDate){
        for($i=1;$i<$total;$i++){
            $start = $i+1;
            $ret = self::getApiTrade($sid,$code,$start,$startDate,$endDate);
            if($ret['retCode'] == 'SUCCESS') {
                self::perfectTrade($ret['retData']['content']['resultModel']['rows'],$code);
            }
        }
    }
    /*
     * 完善交易
     */
    private static function perfectTrade($list,$code){
        foreach ($list as $v){
            $info = TradeModel::tb()->where(['trans_id' => $v['transId']])->find();

            $data = [
                'org_code' => $code,
                'trans_id' => isset($v['transId'])?$v['transId']:'',
                'trans_type' => isset($v['transType'])?$v['transType']:'',
                'merchant_code' => isset($v['merchantCode'])?$v['merchantCode']:'',
                'merchant_name' => isset($v['merchantName'])?$v['merchantName']:'',
                'term_no' => isset($v['termNo'])?$v['termNo']:'',
                'trans_amt' => isset($v['transAmt'])?$v['transAmt']:'',
                'fee_amt' => isset($v['feeAmt'])?$v['feeAmt']:'',
                'card_type' => isset($v['cardType'])?$v['cardType']:'',
                'sign_image' => isset($v['signimage'])?$v['signimage']:'',
                'trans_time' => isset($v['transId'])?'20'.substr($v['transId'],0,6):'',
            ];

            if($info){
                //$data['id'] = $info['id'];
                //TradeModel::tb()->update($data);
            }else{
                TradeModel::tb()->insert($data);
            }
        }
    }

    /*
     * 获取交易统计接口
     */
    public static function getApiTradeCount($sid,$code,$startDate,$endDate){
        $where = [
            'mark' => 'queryTradeCount',
        ];
        $params = [
            'sessionId' => $sid,
            'signOrg' => $code,
            'transCode' => 'P_ALL',
            'pageNo' => 1,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }

    /*
     * 获取用户列表包括本身
     */
    public static function getUserList($id,$status){
        $ret = UserModel::tb()->where(['pid' => $id,'user_status' => $status])->whereOr(['id' => $id])->select();
        return $ret;
    }
    /*
     * 获取下级用户列表
     */
    public static function getUserListByPid($id,$status){
        $ret = UserModel::tb()->where(['pid' => $id,'user_status' => $status])->select();
        return $ret;
    }

    /*
     * 设置所有分润比例
     */
    public static function setRunScale($id){
        //一级设为最高级别
        $uInfo = UserModel::getInfoById($id);
        if($uInfo['pid'] == 0){
            self::setRunScaleByUid($id,10000000000);
        }

        $uList = self::getUserListByPid($id,1);
        $ret = 0;
        if(count($uList) > 0) {
            $time = time();
            $startDate = getBeforeMonthStart($time);
            $endDate = getBeforeMonthEnd($time);
            foreach ($uList as $v) {
                $uid = $v['id'];
                $total = TradeService::getTradeTotal($uid, $startDate, $endDate);
                $childTotal = self::setRunScale($uid);
                $allTotal = $total['amt'] + $childTotal['amt'];
                $money = floor($allTotal / 10000);
                self::setRunScaleByUid($uid, $money);
                $ret += $allTotal;
            }
        }
        return $ret;
    }

    /*
     * 设置分润比例   by uid money
     */
    public static function setRunScaleByUid($uid,$money){
        $trade = cmf_get_option('level_trade');
        $level = 0;
        foreach ($trade as $k=>$v){
            if($money>=$v){
                $level++;
            }else{
                break;
            }
        }
        $data['id'] = $uid;
        $data['run_level'] = $level;
        UserModel::tb()->update($data);
    }
}