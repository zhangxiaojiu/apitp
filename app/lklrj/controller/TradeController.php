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

        $tList = TerminaService::getListByUid($uid,1);
        foreach ($tList as $v){
            $tArray[] = $v['code'];
        }
        $where['term_no'] = ['IN',$tArray];
        $list = TradeModel::tb()->where($where)->paginate(10);
        
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}