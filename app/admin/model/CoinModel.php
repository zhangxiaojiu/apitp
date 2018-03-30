<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/10
 * Time: 下午2:26
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class CoinModel extends Model
{
    public static function tb(){
        return Db::name('coin');
    }
    public static function getInfoById($id){
        $ret = self::tb()->where(['uid'=>$id])->find();
        return $ret;
    }
}