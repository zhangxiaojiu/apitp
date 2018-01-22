<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/13
 * Time: 19:03
 */

namespace app\admin\model;


use think\Model;
use think\Db;

class MerchantModel extends Model
{

    public static function tb(){
        return Db::name('merchant');
    }

}