<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/27
 * Time: 下午3:45
 */

namespace app\admin\service;


use app\admin\model\TerminaModel;

class TerminaService
{
    public static function getListByUid($uid){
        $ret = TerminaModel::tb()->where(['uid'=>$uid])->select();
        return $ret;
    }
}