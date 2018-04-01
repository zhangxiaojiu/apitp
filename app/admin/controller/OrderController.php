<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/4/1
 * Time: 下午1:33
 */

namespace app\admin\controller;


use app\admin\model\OrderModel;
use cmf\controller\AdminBaseController;

class OrderController extends AdminBaseController
{
    /*
     * 采购列表
     */
    public function index(){
        $uid = session('ADMIN_ID');;
        $list = OrderModel::getListByUid($uid);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /*
     * 处理采购
     */
    public function  doPurchase(){
        $id = $this->request->param('id', 0, 'intval');
        $ret = OrderModel::tb()->where('id',$id)->setField('status', 1);
        if($ret > 0){
            $this->success("成功");
        }
    }

}