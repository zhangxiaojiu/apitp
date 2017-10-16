<?php

namespace app\user\controller;

use cmf\controller\AdminBaseController;
use think\Db;
use app\user\model\PosModel;
use app\user\model\AdminDealModel;
use app\user\model\AdminUserModel;


class AdminDealController extends AdminBaseController
{
  //交易列表
  public function index()
  {
    $where   = [];
    $request = input('request.');
    $adminId = session('ADMIN_ID');

    if(!empty($request['qyjg'])){
      $where['qyjg'] = $request['qyjg'];
    }
    if(!empty($request['code'])){
      $where['code'] = $request['code'];
    }
    if(!empty($request['date'])){
      $where['dealtime'] = $request['date'];
    }

    if($adminId != 1){
      if(session('roleName') == '大代理'){
        $where['admin_id'] = $adminId;
      }else{
        $where['qyjg'] = session('name');
      }
    }

    $list = Db::name('deal')->where($where)->order("state,paytime DESC")->paginate(20);
    // 获取分页显示
    $page = $list->render();
    $this->assign('list', $list);
    $this->assign('page', $page);
    // 渲染模板输出
    return $this->fetch();
  }

  //D0列表
  public function d0List()
  {
    $where   = [];
    $request = input('request.');
    $adminId = session('ADMIN_ID');

    if(!empty($request['qyjg'])){
        $where['qyjg'] = $request['qyjg'];
    }
    if(!empty($request['date'])){
      $likeDate = str_replace('-', '', $request['date'])."%";
      $where['time'] = array('like',$likeDate);
    }

    if($adminId != 1){
      if(session('roleName') == '大代理'){
        $where['admin_id'] = $adminId;
      }else{
        $where['qyjg'] = session('name');
      }
    }

    $list = Db::name('deal_d0')->where($where)->paginate(20);
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
    if(session('roleName') != "大代理" && session('ADMIN_ID') != 1){
      $this->error('你没有权限');
    }
    if ($_FILES["file"]["error"] > 0){
      $this->error("请选择文件 code: " . $_FILES["file"]["error"] . "<br />");
    }else{
      $admin_id = session('ADMIN_ID');
    	$type = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
      $import_type = $_POST['type'];
    	$newfile = "";
    	if($type != "xlsx" && $type != 'xls'){
    		$this->error('文件类型不符合');
    	}
    	
      $newfile = $_FILES["file"]["tmp_name"];
      if($newfile != ""){
        $arr = cmf_excel2arr($newfile);
        if($import_type == 'deal'){
          if(count($arr[1]) != 12){
            $this->error("上传文件错误");
          }
          $sql = "insert into cmf_deal (`admin_id`,`lsid`,`qyjg`,`shid`,`shname`,`zdid`,`dealtime`,`dealcoin`,`dealfee`,`cardtype`,`paytime`,`postype`,`code`) values ";
        }elseif($import_type == 'd0'){
          if(count($arr[1]) != 11){
            $this->error("上传文件错误");
          }
          $sql = "insert into cmf_deal_d0 (`admin_id`,`lsid`,`qyjg`,`postype`,`shid`,`shname`,`time`,`coin`,`fee`,`realcoin`,`transtype`,`transstate`) values ";
        }else{
          $this->error('参数错误');
        }     
     		$values = '';
     		foreach($arr as $k=>$v){
     			if($k != 1){
     				$values.= "('".$admin_id."','".implode("','", $v)."'),";
     			}
     		}
     		$values = trim($values,',');
        
        $res = Db::query($sql.$values);
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
    $where   = [];
    $request = input('request.');
    $adminId = session('ADMIN_ID');
    $qyjg = isset($request['qyjg'])?$request['qyjg']:null;
    $date = isset($request['date'])?$request['date']:null;
    $record = AdminDealModel::getRecord($adminId,$qyjg,$date);
    $res = AdminDealModel::getTotal($record);

    $d0Record = AdminDealModel::getD0Record($adminId,$qyjg,$date);
    $d0Res = AdminDealModel::getD0Total($d0Record);
    $res['d_total'] = $d0Res['total'];
    $res['d_num'] = $d0Res['num'];
    $user_conf = AdminUserModel::getConf($adminId);
    if(empty($user_conf)){
      $res['jie_fee'] = $res['die_fee'] = $res['d_fee'] = $res['all_fee'] = 0;
    }else{
      $res['jie_fee'] = $user_conf['jie_fee'];
      $res['die_fee'] = $user_conf['die_fee'];
      $res['d_fee'] = $user_conf['d_fee'];
      $res['all_fee'] = $user_conf['all_fee'];
    }
    $res['total'] = round(($res['die_total']*$res['die_fee']/100+$res['jie_total']*$res['jie_fee']/100+$res['d_total']-($res['d_num']*$res['d_fee']))*$res['all_fee'],2);   
    $res['date'] = isset($request['date'])?$request['date']:date("Y-m-d",time()-60*60*24);
    $unCash = AdminDealModel::getUnCash();
    $this->assign('un_cash', $unCash);
    $this->assign('info', $res);
    return $this->fetch();
  }
  //变现
  public function cashCoin(){
    $adminId = session('ADMIN_ID');
    $role = AdminUserModel::getRole($adminId);
    if($role['name'] == "大代理"){
      $this->error('大代理不能变现');
    }
    if(AdminDealModel::cashCoin()){
      $this->success('变现成功');
    }
  }
}