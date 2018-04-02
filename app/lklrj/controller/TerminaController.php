<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/4
 * Time: 18:20
 */

namespace app\lklrj\controller;


use app\admin\model\OrderModel;
use app\admin\model\TerminaModel;
use app\admin\model\UserModel;
use app\admin\service\CoinLogService;
use think\Db;

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

    /*
     * 采购
     */
    public function purchase(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);
        $list = OrderModel::tb()->where(['uid'=>$uid])->order('create_time desc')->paginate(5);

        $this->assign('info',$uInfo);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /*
     *处理采购
     */
    public function doPurchase(){
        $uid = session('user')['id'];
        $uInfo = UserModel::getInfoById($uid);

        $data = $_POST;
        if($data['num'] < 1){
            $this->error('数量至少为1');
        }

        $detail = "姓名：".$data['name']."<br>电话：".$data['tel']."<br> 地址：".$data['address'];
        if(isset($data['isCoin'])){
            $money = 99*$data['num'];
            if($uInfo['coin'] < $money){
                $this->error('余额不足');
            }else{
                Db::startTrans();
                $data_o = [
                    'uid' => $uid,
                    'num' => $data['num'],
                    'money' => 99*$data['num'],
                    'detail' => $detail,
                    'status' => 1,
                    'create_time' => time(),
                ];
                OrderModel::tb()->insert($data_o);

                $data_c = [
                    'uid' => $uid,
                    'coin' => 0-99*$data['num'],
                    'type' => 'buy',
                    'detail' => '机器采购'.$data['num'].'台;'.$data['detail'],
                    'status' => 1,
                ];
                $clRet = CoinLogService::addCoinLog($data_c);
                if(!$clRet){
                    Db::rollback();
                }
                Db::commit();
            }
        }else{
            $data_o = [
                'uid' => $uid,
                'num' => $data['num'],
                'money' => 99*$data['num'],
                'detail' => $detail,
                'status' => 0,
                'create_time' => time(),
            ];
            OrderModel::tb()->insert($data_o);
        }

        $this->success('采购成功');
    }
}