<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/29
 * Time: 上午10:04
 */

namespace app\admin\service;


use app\admin\model\CoinModel;

class CoinService
{
    /*
     *改变资金统计
     */
    public static function changeCoin($uid,$field,$coin){
        $info = CoinModel::tb()->where(['uid'=>$uid])->find();
        if($info){
            return CoinModel::tb()->where(['uid'=>$uid])->setInc($field,$coin);
        }else{
            return CoinModel::tb()->insert(['uid'=>$uid,$field=>$coin]);
        }
    }

}