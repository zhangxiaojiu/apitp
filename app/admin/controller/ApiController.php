<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2017/12/21
 * Time: 19:54
 */

namespace app\admin\controller;


use app\admin\model\ApiModel;
use app\admin\model\ApiSortModel;
use cmf\controller\AdminBaseController;

class ApiController extends AdminBaseController
{
    //接口列表
    public function index(){
        $list = ApiModel::tb()->select();
        $sort = ApiSortModel::tb()->select();
        $this->assign('list',$list);
        $this->assign('sort',$sort);
        return $this->fetch();
    }

    /*
     * 接口信息
     */
    public function apiInfo(){
        $id = input('get.id','');
        $op = input('get.op','');
        if(!empty($id)){
            if(empty($op)){
                $this->error('参数错误');
            }
            if($op == 'edit') {
                $info = ApiModel::tb()->find($id);
            }
            if($op == 'del'){
                ApiModel::tb()->update(['id'=>$id,'state'=>0]);
                $this->success('删除成功','index');
            }
            if($op == 'up'){
                ApiModel::tb()->update(['id'=>$id,'state'=>1]);
                $this->success('启用成功','index');
            }
        }
        if(empty($info)){
            $info = [
                'id' => '',
                'sort' => '',
                'name' => '',
                'mark' => '',
                'url' => '',
                'type' => 'get',
            ];
        }
        $sort = ApiSortModel::tb()->select();
        $this->assign('info',$info);
        $this->assign('sort',$sort);
        return $this->fetch();
    }

    /*
     * 操作接口信息
     */
    public function runApiInfo(){
        $data = input('post.');
        if(empty($data['id'])){
            $data['create_time'] = date('Y-m-d H:i:s');
            ApiModel::tb()->insert($data);
            $this->success('添加成功','index');
        }else{
            ApiModel::tb()->update($data);
            $this->success('修改成功','index');
        }
    }
    /*
     * 接口配置项
     */
    public function apiOption(){
        $id = input('get.id','');
        $op = input('get.op','');
        if(empty($id)){
            $this->error('参数错误');
        }
        $info = ApiModel::tb()->find($id);
        if($op == 'option'){
            $param = json_decode($info['params'],true);
        }else if($op == 'header'){
            $param = json_decode($info['header'],true);
        }else{
            $this->error('参数错误');
        }
        if(empty($param)){
            $param[0] = ['key'=>'','value'=>''];
        }
        $this->assign('param',$param);
        $this->assign('op',$op);
        $this->assign('info',$info);
        return $this->fetch();
    }
    /*
     * 操作接口配置项
     */
    public function runApiOption(){
        $id = input('get.id','');
        $op = input('get.op','');
        if(empty($id)){
            $this->error('参数错误');
        }
        $post = input('post.');
        if(!empty($post['key']) && $post['key'] != '') {
            $key = $post['key'];
            $value = $post['value'];
            foreach ($key as $k => $v) {
                $param['key'] = $v;
                $param['value'] = $value[$k];
                $params[] = $param;
            }
            $jsonParams = json_encode($params);
        }else{
            $jsonParams = '';
        }
        $data['id'] = $id;
        if($op == 'option'){
            $data['params'] = $jsonParams;
        }
        if($op == 'header'){
            $data['header'] = $jsonParams;
        }
        ApiModel::tb()->update($data);
        $this->success('更新成功');
    }
}