<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/4
 * Time: 18:20
 */

namespace app\lklrj\controller;


use app\admin\model\MerchantModel;
use app\lklrj\service\ApiService;

class MerchantController extends BaseController
{
    public function index(){
        $agent = session('lkl_user')['org_code'];
        $list = MerchantModel::tb()->where(['agent_id'=>$agent])->paginate(10);
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}