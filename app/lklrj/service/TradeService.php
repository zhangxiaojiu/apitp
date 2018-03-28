<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/10
 * Time: 下午2:37
 */

namespace app\lklrj\service;



use app\admin\model\TradeModel;

class TradeService
{
    public static function syncTrade($sid,$code){
        $where = [
            'mark' => 'queryTrade',
        ];
        $startDate = date('Ym').'01';
        $endDate = date('Ymd');
        $params = [
            'sessionId' => $sid,
            'signOrg' => $code,
            'transCode' => 'P_ALL',
            'type' => 'T_01',
            'pageNo' => 1,
            'pageSize' => 10000,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
        $ret = ApiService::getApi($where,$params);
        if($ret['retCode'] == 'SUCCESS'){
            self::perfectTrade($ret['retData']['content']['resultModel']['rows']);
        }
    }
    private static function perfectTrade($list){
        foreach ($list as $v){
            $info = TradeModel::tb()->where(['trans_id' => $v['transId']])->find();

            $data = [
                'org_code' => session('lkl_user')['org_code'],
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
                $data['id'] = $info['id'];
                //TradeModel::tb()->update($data);
            }else{
                TradeModel::tb()->insert($data);
            }
        }
    }

    /*
     * 终端是否激活
     */
    public static function isTerminalActivate($code){
        $where['term_no'] = $code;
        $where['trans_time'] = $code;
        $list = TradeModel::tb()->where($where)->select();
        return $list;
    }
}