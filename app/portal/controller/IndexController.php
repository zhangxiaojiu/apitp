<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;

use cmf\controller\HomeBaseController;
use think\Validate;
use app\portal\model\ContactsModel;
use think\Db;

class IndexController extends HomeBaseController
{
    public function index()
    {
        $notice = Db::name('portal_post')->alias('p')->join("portal_category_post c","p.id=c.post_id")->where(["c.category_id"=>'9','p.is_top'=>'1','p.delete_time'=>'0'])->find();
        $notice = html_entity_decode($notice['post_content']);
        $this->assign('notice',$notice);
        $user_id = isset($_GET['user_id'])?$_GET['user_id']:0;
        $this->assign('user_id',$user_id);
        return $this->fetch(':index');
    }
    public function old()
    {
    	return $this->fetch(':index_old');
    }
    public function doContacts()
    {
        if ($this->request->isPost()) {
            $rules = [
                'name'  => 'require|chs',
                'type'  => 'require',
                'tel'     => 'require|regex:/^1[34578]{1}\d{9}$/',

            ];

            $validate = new Validate($rules);
            $validate->message([
                'name.require'     => '姓名不能为空',
                'tel.require' => '电话不能为空',
                'type.require' => '类型不能为空',
                'name.chs'     => '请填写真实姓名',
                'tel.regex'     => '请填写真实电话',
            ]);

            $data = $this->request->post();
	    if($data['user_id'] == 0){
	    	$data['user_id'] = 4;
	    }
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            $conModel = new ContactsModel();
            
	    $log = $conModel->addContacts($data);
            switch ($log) {
                case 0:
                    $this->error("已申请，请耐心等待");
                    break;
                default :
			$user_station = Db::name('user')->where(['id'=>$data['user_id']])->find();
			if($user_station){
				$mobile = Db::name('user')->where(['id'=>$user_station['pid']])->value('mobile');
				if($mobile){
					$param = [
						'mobile'=>$mobile,
						'content'=>$data['tel'].$data['name']
					];
					newMsg($param);
				}
			}
			$this->success('申请成功，工作人员会在一个工作日之内联系您');
            }

        } else {
            $this->error("请求错误");
        }

    }
}
