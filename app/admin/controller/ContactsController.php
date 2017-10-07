<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小九 < wtfree@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use app\portal\model\ContactsModel;

class ContactsController extends AdminBaseController
{
	public function index()
	{
		$contactsModel = new ContactsModel();
		$contacts = $contactsModel->select();
		$this->assign('contacts',$contacts);
		return $this->fetch();
	}

	public function delete()
	{
		$id = $this->request->param('id', 0, 'intval');
        ContactsModel::destroy($id);

        $this->success("删除成功！", url("contacts/index"));
	}
}