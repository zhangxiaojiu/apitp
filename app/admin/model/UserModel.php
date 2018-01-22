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

class UserModel extends Model
{
    const TYPE_LKL_AGENT = 10; //拉卡拉代理商
    const TYPE_LKL_MERCHANT = 11; //拉卡拉商户

    public static function tb(){
        return Db::name('user');
    }

}