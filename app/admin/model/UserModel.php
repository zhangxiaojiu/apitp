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
    const TYPE_SUPER_ADMIN = 1; //拉卡拉代理商
    const TYPE_LKL_AGENT = 10; //拉卡拉代理商
    const TYPE_LKL_MERCHANT = 11; //拉卡拉商户

    const STATUS_PROHIBIT = 0; //禁止状态
    const STATUS_NORMAL = 1; //正常状态
    const STATUS_UNVERIFIED = 2; //未验证状态

    public static function tb(){
        return Db::name('user');
    }

    public static function getInfoById($id){
        $ret = self::tb()->find($id);
        return $ret;
    }

    public static function getScaleById($id){
        $uInfo = self::getInfoById($id);
        $level = $uInfo['run_level'];
        $scaleArray = cmf_get_option('level_scale');
        $scale = $scaleArray[$level]/10000;
        return $scale;
    }

    public static function getListByPid($id){
        $ret = self::tb()->where(['pid'=>$id])->select();
        return $ret;
    }
    public static function getChildIds($id){
        if(!is_array($id)){
            $childIds[] = $id;
        }
        $childList = Db::name('user')->where(['pid'=>['in',$childIds]])->select();
        while(count($childList) > 0){
            $newChild = [];
            foreach ($childList as $v){
                $childIds[] = $v['id'];
                $newChild[] = $v['id'];
            }
            $childList = Db::name('user')->where(['pid'=>['in',$newChild]])->select();
        }
        return $childIds;
    }
}