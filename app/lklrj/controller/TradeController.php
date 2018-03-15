<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/13
 * Time: 上午11:01
 */

namespace app\lklrj\controller;


use app\admin\model\TradeModel;

class TradeController extends BaseController
{
    public function index(){
        $agent = session('lkl_user')['org_code'];
        $list = TradeModel::tb()->where(['org_code'=>$agent])->paginate(10);
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}