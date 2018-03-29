<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/29
 * Time: 下午2:27
 */

namespace app\admin\service;


use app\admin\model\TradeModel;

class TradeService
{
    /*
     * 交易统计
     */
    public static function getTradeTotal($id,$startDate,$endDate){
        $terminalList = TerminaService::getListByUid($id);
        foreach($terminalList as $v){
            $terminalArray[] = $v['code'];
        }
        $where['term_no'] = ['IN',$terminalArray];
        $where['trans_time'] = ['between',"$startDate,$endDate"];
        $tradeList = TradeModel::tb()->where($where)->select();
        $amt = 0;
        foreach ($tradeList as $v){
            $amt += $v['trans_amt'];
        }
        $total['num'] = count($tradeList);
        $total['amt'] = $amt;
        return $total;
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