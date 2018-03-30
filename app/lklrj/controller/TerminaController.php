<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/4
 * Time: 18:20
 */

namespace app\lklrj\controller;


use app\admin\model\TerminaModel;
use app\admin\model\UserModel;

class TerminaController extends BaseController
{
    public function index(){
        $uid = session('user')['id'];
        $where = [];
        $where['uid'] = $uid;
        $request = input('request.');
        if (!empty($request['status'])) {
            if($request['status'] <=1) {
                $where['status'] = $request['status'];
            }else{
                $where['is_ok'] = 1;
            }
        }
        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];
            $keywordComplex['code'] = ['like', "%$keyword%"];
        }

        $list = TerminaModel::tb()->where($where)->where($keywordComplex)->paginate(10);
        $num = TerminaModel::tb()->where($where)->count();
        // 获取分页显示
        $page = $list->render();

        $userList = UserModel::tb()->where(['pid' => $uid,'user_status' => 1])->select();
        $this->assign('userlist', $userList);

        $this->assign('num', $num);
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    /*
    * 划拨机器
    */
    public function transfer()
    {
        $data = $_POST;
        if(empty($data['checkarr'])){
            $this->error('请选择终端');
        }
        if(empty($data['uid'])){
            $this->error('请选择划拨用户');
        }
        $errorPos = 0;
        foreach($data['checkarr'] as $k=>$v){
            $pos = TerminaModel::tb()->find($k);
            if($pos['status'] > 0){
                $errorPos++;
            }else{
                $term['uid'] = $data['uid'];
                $term['id'] = $k;
                TerminaModel::tb()->update($term);
            }
        }
        if($errorPos > 0) {
            $this->success('划拨成功，有'.$errorPos.'台已绑终端不可划拨');
        }
        $this->success('全部划拨成功');
    }
}