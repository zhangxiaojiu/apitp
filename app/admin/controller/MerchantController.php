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
        $uid = session('ADMIN_ID');

        if (!empty($request['merchant_code'])) {
	    if($uid == 1){
		$where['pid'] = intval($request['merchant_code']);
	    }else{
		$where['pid'] = $uid;
		$where['merchant_code'] = intval($request['merchant_code']);
	    }
        }
        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['mobile']    = ['like', "%$keyword%"];
            $keywordComplex['merchant_name'] = ['like', "%$keyword%"];
            $keywordComplex['real_name']    = ['like', "%$keyword%"];
        }

        
	$list = MerchantModel::tb()->where($where)->whereOr($keywordComplex)->order("id DESC")->paginate(10);

	//export
	if(!empty($request['isout'])){
	    $olist =MerchantModel::tb()->where($where)->whereOr($keywordComplex)->select();
	    foreach ($olist as $v){
		$row = [];
		$row[] = $v['real_name'];
		$row[] = $v['mobile'];
		$row[] = $v['address'];
		$row[] = $v['email'];
		$row[] = $v['merchant_name'];
		$row[] = $v['merchant_code'];
		$ret[] = $row;
	    }

	    $fileName = 'lkl'.date('YmdHis').mt_rand(100,999);
	    $sheetName = "merchant";
	    $title = [
		"A" => "姓名",
		"B" => "电话",
		"C" => "地址",
		"D" => "邮箱",
		"E" => "商户名",
		"F" => "商户号"
	    ];
	    phpExcelXlsx($fileName,$sheetName,$title,$ret);
	}

        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}
