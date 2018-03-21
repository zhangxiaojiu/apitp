<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/21
 * Time: 下午4:45
 */

namespace app\admin\controller;


use app\admin\model\TradeModel;
use cmf\controller\AdminBaseController;

class TradeController extends AdminBaseController
{
    public function index(){
        $where   = [];
        $request = input('request.');

        if (!empty($request['trans_id'])) {
            $where['trans_id'] = intval($request['trans_id']);
        }
        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['merchant_name']    = ['like', "%$keyword%"];
            $keywordComplex['merchant_code'] = ['like', "%$keyword%"];
            $keywordComplex['term_no']    = ['like', "%$keyword%"];
        }
        $list = TradeModel::tb()->where($where)->whereOr($keywordComplex)->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}