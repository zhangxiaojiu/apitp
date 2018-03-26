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
use think\Db;

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

        $uid = session('ADMIN_ID');
        $info = Db::name('user')->where(['id' => $uid])->find();
        $where['agent_id'] = $info['lkl_org_code'];

        $list = MerchantModel::tb()->where($where)->whereOr($keywordComplex)->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}