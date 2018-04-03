<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/13
 * Time: 上午11:01
 */

namespace app\lklrj\controller;


use app\admin\model\TradeModel;
use app\admin\service\TerminaService;

class TradeController extends BaseController
{
    public function index(){
        $uid = session('user')['id'];
        $request = input('request.');

        if (!empty($request['cl_id'])) {
            $where['cl_id'] = $request['cl_id'];
        }

        $tList = TerminaService::getListByUid($uid,1);
        $tArray = [];
        foreach ($tList as $v){
            $tArray[] = $v['code'];
        }
        $where['term_no'] = ['IN',$tArray];

        $search['where'] = $where;
        $page = input('request.page');
        if (!isset($page)) {
            session('search', null);
        }
        if (!empty($where)) {
            session('search', $search);
        }
        if ($page >= 1) {
            $where = session('search')['where'];
        }
        $list = TradeModel::tb()->where($where)->paginate(10);
        
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}