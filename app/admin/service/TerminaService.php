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
    public static function getListByUid($uid,$status=null){
        $where['uid'] = $uid;
        if(!empty($status)){
            $where['status'] = $status;
        }
        $ret = TerminaModel::tb()->where($where)->select();
        return $ret;
    }
    public static function getListByPid($pid,$status=null,$is_ok=null){
        $where['pid'] = $pid;
        if(!empty($status)){
            $where['status'] = $status;
        }
        if(!empty($is_ok)){
            $is_ok = $is_ok == 1?1:0;
            $where['is_ok'] = $is_ok;
        }
        $ret = TerminaModel::tb()->where($where)->select();
        return $ret;
    }
}