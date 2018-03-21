<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/21
 * Time: 下午3:50
 */

namespace app\admin\controller;


use app\admin\model\MerchantModel;
use cmf\controller\AdminBaseController;

class MerchantController extends AdminBaseController
{
    public function index(){
        $where   = [];
        $request = input('request.');

        if (!empty($request['merchant_code'])) {
            $where['merchant_code'] = intval($request['merchant_code']);
        }
        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['mobile']    = ['like', "%$keyword%"];
            $keywordComplex['merchant_name'] = ['like', "%$keyword%"];
            $keywordComplex['real_name']    = ['like', "%$keyword%"];
        }
        $list = MerchantModel::tb()->where($where)->whereOr($keywordComplex)->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}