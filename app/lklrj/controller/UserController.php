<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/5
 * Time: 17:25
 */

namespace app\lklrj\controller;


use app\admin\model\UserModel;

class UserController extends BaseController
{
    /*
     * 我的资料
     */
    public function info(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);
        $this->assign('info',$uInfo);
        return $this->fetch();
    }

    /*
     * 修改资料
     */
    public function editInfo(){
        $data = $_POST;
        $uid = session('user')['id'];
        $data['id'] = $uid;
        if(!empty($data)){
            if(UserModel::tb()->update($data)){
                $this->success('修改成功');
            }
        }
    }
}