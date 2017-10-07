<?php

namespace app\user\controller;

use think\Validate;
use cmf\controller\UserBaseController;
use app\user\model\PosModel;
use app\user\model\UserModel;
use think\Db;

class PosController extends UserBaseController
{

    function _initialize()
    {
        parent::_initialize();
    }

    public function center()
    {
        $uid = session('user.id');
        $m_pos = new PosModel();

        $status = $m_pos->getUserCidStatus($uid);
        if($status == 2){
            $sta['status'] = 1;
            $sta['sta_bak'] = "<span style='color:green;'>已激活</span>";
            $sta['req_bak'] = "你已成为业务员，现在去 <a href='/share/".$uid."'>推荐好友</a> 来获得更多奖励吧";
        }else{
            $sta['status'] = 0;
            $sta['sta_bak'] = "<span style='color:orange;'>未激活</span>";
            $sta['req_bak'] = "<span style='color:green;'>申请成为业务员</span>";
        }

        //$p_r_res = Db::name('pos_request')->where(['uid'=>$uid, 'status'=>0, 'type'=>'active'])->find();
        $user_info = Db::name('user')->where(['id'=>$uid])->find();

        $re_list = Db::name('pos_request')->where(['uid'=>$uid,'status'=>0])->select();
        $pos_list = Db::name('pos')->where(['uid'=>$uid])->order('status')->select();

        //$this->assign('p_r_res', $p_r_res);
        $this->assign('user', $user_info);
        $this->assign('re_list', $re_list);
        $this->assign('pos_list', $pos_list);
        $this->assign($sta);
        return $this->fetch();
    }

    public function dorequest()
    {
        $data = $_POST;
        $data['uid'] = session("user.id");
        if(!Db::name('pos')->where('code',$data['code'])->find()){
            $this->error("机具号输入错误");
        }

        if($data['type'] == "docid"){
            if(Db::name('pos')->where(['code'=>$data['code'],'status'=>2 ])->value('cid')){
                $this->error("机具号已经使用成为业务员");
            }

            $pid = Db::name('user')->where('id',$data['uid'])->value('pid');
            $posid = Db::name('pos')->where(['code'=>$data['code'],'status'=>2 ])->value('uid');
            if($pid != $posid){
                $this->error("机具号不是推荐人");
            }else{
                $ret = Db::name('pos')->where('code',$data['code'])->setField('cid',$data['uid']);
                if($ret){
                    $m_user = new UserModel();
                    $m_user->doCreateTeam($data['uid'],true);
                   $this->success("已经成为业务员"); 
                }
                
            }
        }

        if(Db::name('pos')->where(['code'=>$data['code'],'status'=>2 ])->find()){
            $this->error('此机具号已经激活');
        }
        if(Db::name('pos_request')->where(['code'=>$data['code'] ])->find()){
            $this->error("机具号请求重复");
        }
        if($data['type'] == "active"){
            
            if(Db::name('pos')->where(['uid'=>$data['uid'],'status'=>2 ])->find()){
                $this->error('此用户已经激活过');
            }
           
            if(Db::name('pos')->where(['code'=>$data['code'],'status'=>2 ])->find()){
                $this->error('此机具号已经激活过');
            }
        }
        if($data['type'] == "bind"){
            if(Db::name('pos')->where(['code'=>$data['code'],'status'=>1 ])->find()){
                $this->error('此机具号已经绑定');
            }
        }

        $data['time'] = time();
        $data['status'] = 0;

        $ret = Db::name('pos_request')->insert($data);
        $this->success("请求成功");
        // if($ret > 0){
        //     Db::name('pos')->where("code",$data['code'])->update(['uid'=>$data['uid'],'status'=>1]);
        //     $this->success("请求成功");
        // }

    }

    public function doactive()
    {
        $code = input('param.code', 0);
        $data = [
            'status' => "0",
            'type' =>'active',
        ];
        $ret = Db::name('pos_request')->where('code',$code)->update($data);
        if($ret){
            $this->success("已提交，等待审核");
        }else{
            $this->error('不要重复提交，请耐心等待');
        }
    }

    public function team()
    {
        $uid = session('user.id');
        $m_pos = new PosModel();
        $list = $m_pos->getChildList($uid);
        $lists = $m_pos->listGetPos($list,"二级");

        
        foreach($list as $k=>$v){
            $c_a[$v['id']] = $m_pos->getChildList($v['id']);
            $lists[$v['id']]['group'] = $m_pos->listGetPos($c_a[$v['id']],"三级");
        }

        $this->assign('lists',$lists);
        return $this->fetch(); 
    }

    public function teamdetail()
    {
        $id = input('param.id', 0, 'intval');

        $pos_list = Db::name('pos')->where(['uid'=>$id, 'status'=>2])->select();

        $this->assign('pos_list',$pos_list);
        return $this->fetch(); 
    }

}