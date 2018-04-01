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

class OrderModel extends Model
{
    public static function tb(){
        return Db::name('order');
    }
    public static function getListByUid($id){
        $ret = self::tb()->where(['uid'=>$id])->paginate(10);
        return $ret;
    }
}