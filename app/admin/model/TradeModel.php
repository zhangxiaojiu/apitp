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

class TradeModel extends Model
{
    public static function tb(){
        return Db::name('trade');
    }
}