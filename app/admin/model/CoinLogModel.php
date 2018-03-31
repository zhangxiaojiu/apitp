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

class CoinLogModel extends Model
{
    public static function tb(){
        return Db::name('coin_log');
    }

    public static function getListByType($type)
    {
        $list = self::tb()->where(['type'=>$type])->order("status, create_time")->paginate(10);
        return $list;
    }
}