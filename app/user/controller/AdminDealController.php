<?php

namespace app\user\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\user\model\PosModel;


class AdminDealController extends AdminBaseController
{
  public function index()
  {
    $where   = [];
    $request = input('request.');
    $adminId = session('ADMIN_ID');
    if($adminId != 1){
      $request['qyjg'] = session('name');
    }
    if (!empty($request['qyjg'])) {
        $where['qyjg'] = $request['qyjg'];
    }
    if(!empty($request['code'])){
        $where['code'] = $request['code'];
    }

    $list = Db::name('deal')->where($where)->paginate(20);
    // 获取分页显示
    $page = $list->render();
    $this->assign('list', $list);
    $this->assign('page', $page);
    // 渲染模板输出
    return $this->fetch();
  }


  public function add()
  {
    return $this->fetch();
  }
  public function import()
  {
    return $this->fetch();
  }
  public function doImport(){
  if ($_FILES["file"]["error"] > 0){
    $this->error("Return Code: " . $_FILES["file"]["error"] . "<br />");
  }else{
  	$type = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
  	$newfile = "";
  	if($type != "xlsx" && $type != 'xls'){
  		$this->error('文件类型不符合');
  	}
  	
    $newfile = $_FILES["file"]["tmp_name"];
    if($newfile != ""){
      $arr = cmf_excel2arr($newfile);
   		$values = '';
   		foreach($arr as $k=>$v){
   			if($k != 1){
   				$values.= "('".implode("','", $v)."'),";
   			}
   		}
   		$values = trim($values,',');
      Db::query("insert into cmf_deal (`lsid`,`qyjg`,`shid`,`shname`,`zdid`,`dealtime`,`dealcoin`,`dealfee`,`cardtype`,`paytime`,`postype`,`code`) values ".$values);
      $this->success("导入成功");
   }
  }
  }
  public function doAdd()
  {
    $data = $_POST;
    if(empty($data))
    {
        $this->error("数据为空！");
    }else{
    	Db::name('deal')->insert($data);
    	$this->success("添加成功");
    }
    
    
  }

  public function doDel()
  {
    $id = input('param.id', 0, 'intval');
    if($id){
        $q_pos = Db::name('deal');
        $q_pos->delete($id);
        $this->success("删除成功");
    }else{
        $this->error("参数错误");
    }
  }

  //交易量统计
  public function total(){
    $where = [];
    $adminId = session('ADMIN_ID');
    if($adminId != 1){
    $where['qyjg'] = session('name');
    }
    //交易总统计
    $jytotal = Db::name('deal')->where($where)->sum('dealcoin');
    echo "交易总额:".$jytotal."<br/>";
    //昨日统计
    $zr = date("Y-m-d",time()-24*60*60);
    $zrtotal = Db::name('deal')->where($where)->where(array('dealtime'=>$zr))->sum('dealcoin');
    echo "昨日交易:".$zrtotal."<br/>";
  }
}