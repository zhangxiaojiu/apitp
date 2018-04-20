<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/5
 * Time: 17:25
 */

namespace app\lklrj\controller;


use app\admin\model\UserModel;
use app\admin\service\ImageService;

class UserController extends BaseController
{
    /*
     * 个人资料
     */
    public function info(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);
        $this->assign('info',$uInfo);
        return $this->fetch();
    }

    /*
     * 账户信息
     */
    public function account(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);
        $this->assign('info',$uInfo);
        return $this->fetch();
    }

    /*
     * 上传图片
     */
    private static function uploadImg($file){
        $result = $file->validate([
            'ext'  => 'jpg,jpeg,png',
            'size' => 1024 * 1024*10
        ])->move('.' . DS . 'upload' . DS . 'userinfo' . DS);
        if ($result) {
            $saveName = str_replace('//', '/', str_replace('\\', '/', $result->getSaveName()));
            //压缩图片
            $scale = 0.2;
            $fileInfo = $file->getInfo();
            $size = $fileInfo['size'];
            if($size < 200*1024){
                $scale = 1;
            }
            $src = "./upload/userinfo/".$saveName;
            $image = new ImageService($src);
            $image->percent = $scale;
            $image->openImage();
            $image->thumpImage();
            $image->saveImage($src,true);
            return [
                'code' => 1,
                "msg"  => "上传成功",
                "data" => ['file' => $saveName],
                "url"  => ''
            ];
        } else {
            return [
                'code' => 0,
                "msg"  => $file->getError(),
                "data" => "",
                "url"  => ''
            ];
        }
    }
    /*
     * 修改资料
     */
    public function editInfo(){
        $uid = session('user')['id'];
        $data['id'] = $uid;
        if(isset($_POST['realname'])) {
            $data['realname'] = $_POST['realname'];
        }
        if(isset($_POST['user_card'])) {
            $data['user_card'] = $_POST['user_card'];
        }
        if(isset($_POST['wechat'])) {
            $data['wechat'] = $_POST['wechat'];
        }
        if(isset($_POST['alipay'])) {
            $data['alipay'] = $_POST['alipay'];
        }
        if(isset($_POST['bankname'])) {
            $data['bankname'] = $_POST['bankname'];
        }
        if(isset($_POST['bankcard'])) {
            $data['bankcard'] = $_POST['bankcard'];
        }

        if(isset($_FILES['bankcard_pic']) && $_FILES['bankcard_pic']['size']>0){
            $file   = $this->request->file('bankcard_pic');
            $ret = self::uploadImg($file);
            if($ret['code'] == 1){
                $data['bankcard_pic'] = $ret['data']['file'];
            }else{
                $this->error($ret['msg']);
            }
        }
        if(isset($_FILES['bankcardhand_pic']) && $_FILES['bankcardhand_pic']['size']>0){
            $file   = $this->request->file('bankcardhand_pic');
            $ret = self::uploadImg($file);
            if($ret['code'] == 1){
                $data['bankcardhand_pic'] = $ret['data']['file'];
            }else{
                $this->error($ret['msg']);
            }
        }
        if(isset($_FILES['user_cardup_pic']) && $_FILES['user_cardup_pic']['size']>0){
            $file   = $this->request->file('user_cardup_pic');
            $ret = self::uploadImg($file);
            if($ret['code'] == 1){
                $data['user_cardup_pic'] = $ret['data']['file'];
            }else{
                $this->error($ret['msg']);
            }
        }
        if(isset($_FILES['user_carddown_pic']) && $_FILES['user_carddown_pic']['size']>0){
            $file   = $this->request->file('user_carddown_pic');
            $ret = self::uploadImg($file);
            if($ret['code'] == 1){
                $data['user_carddown_pic'] = $ret['data']['file'];
            }else{
                $this->error($ret['msg']);
            }
        }
        if(isset($_FILES['user_cardhand_pic']) && $_FILES['user_cardhand_pic']['size']>0){
            $file   = $this->request->file('user_cardhand_pic');
            $ret = self::uploadImg($file);
            if($ret['code'] == 1){
                $data['user_cardhand_pic'] = $ret['data']['file'];
            }else{
                $this->error($ret['msg']);
            }
        }

        if(!empty($data)){
            if(UserModel::tb()->update($data)){
                $this->success('修改成功');
            }else{
                $this->error('没有改变资料');
            }
        }
    }

    public function realNameAuth(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);
        $this->assign('info',$uInfo);
        return $this->fetch();
    }
}