<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2017/12/23
 * Time: 16:49
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class ApiModel extends Model
{
    public static function tb(){
        return Db::name('api');
    }
}