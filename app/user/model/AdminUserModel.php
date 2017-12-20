<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Powerless < wzxaini9@gmail.com>
// +----------------------------------------------------------------------
namespace app\user\model;

use think\Db;
use think\Model;

class AdminUserModel extends Model
{
   /*
   *获取角色
   */
   public static function getRole($id){
      $groups = Db::name('RoleUser')
                ->alias("a")
                ->join('at_role b', 'a.role_id =b.id')
                ->where(["a.user_id" => $id, "b.status" => 1])
                ->field('a.role_id,b.name,a.user_id')
                ->find();

      return $groups;
   }

   public static function getConf($id){
      $info = Db::name('user_conf')->where(array('user_id'=>$id))->find();
      return $info;
   }
   public static function saveConf($data){
      $info = Db::name('user_conf')->where(array('user_id'=>$data['user_id']))->find();
      if($info){
        $res = Db::name('user_conf')->where(array('user_id'=>$data['user_id']))->update($data);
      }else{
        $res = Db::name('user_conf')->insert($data);
      }
      return $res;
   }


}
