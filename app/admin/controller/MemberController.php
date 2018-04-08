<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Powerless < wzxaini9@gmail.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\CoinLogModel;
use app\admin\model\UserModel;
use app\admin\service\MemberService;
use app\admin\service\TerminaService;
use app\admin\service\TradeService;
use app\lklrj\service\ApiService;
use cmf\controller\AdminBaseController;
use think\Db;
use app\user\model\CoinModel;

/**
 * Class AdminIndexController
 * @package app\user\controller
 *
 * @adminMenuRoot(
 *     'name'   =>'用户管理',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10,
 *     'icon'   =>'group',
 *     'remark' =>'用户管理'
 * )
 *
 * @adminMenuRoot(
 *     'name'   =>'用户组',
 *     'action' =>'default1',
 *     'parent' =>'user/AdminIndex/default',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'',
 *     'remark' =>'用户组'
 * )
 */
class MemberController extends AdminBaseController
{

    /**
     * 后台本站用户列表
     * @adminMenu(
     *     'name'   => '本站用户',
     *     'parent' => 'default1',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '本站用户',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $where   = [];
        $request = input('request.');
        $uid = session('ADMIN_ID');
        $where['user_status'] = 1;
        if (!empty($request['uid'])) {
            $where['id'] = intval($request['uid']);
        }

        if($uid > 1){
            //$info = Db::name('user')->where(['id' => $uid])->find();
            $pidArr = MemberService::getPidArr($uid);
            $where['pid'] = ['IN',$pidArr];
        }
        if (!empty($request['porg_code'])) {
            $porg_code = intval($request['porg_code']);
            if($request['porg_code'] == -1){
                $porg_code = 0;
            }
            $where['porg_code'] = $porg_code;
        }
        $keywordComplex = [];
        $keywordComplex['id'] = $uid;
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['mobile']    = ['like', "%$keyword%"];
            $keywordComplex['user_nickname'] = ['like', "%$keyword%"];
            $keywordComplex['user_email']    = ['like', "%$keyword%"];
        }
        $usersQuery = Db::name('user');

        $list = $usersQuery->where($where)->whereOr($keywordComplex)->order("id DESC")->paginate(10);
        if($uid == 1){
            $agentList = $usersQuery->where(['porg_code' => 0,'id' => ['>',1]])->select();
            $this->assign('uid',$uid);
            $this->assign('agentList',$agentList);
        }

        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 本站用户拉黑
     * @adminMenu(
     *     'name'   => '本站用户拉黑',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '本站用户拉黑',
     *     'param'  => ''
     * )
     */
    public function ban()
    {
        $id = input('param.id', 0, 'intval');
        if ($id) {
            $result = Db::name("user")->where(["id" => $id, "user_type" => 2])->setField('user_status', 0);
            if ($result) {
                $this->success("会员拉黑成功！", url("adminIndex/index"));
            } else {
                $this->error('会员拉黑失败,会员不存在,或者是管理员！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    /**
     * 本站用户启用
     * @adminMenu(
     *     'name'   => '本站用户启用',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '本站用户启用',
     *     'param'  => ''
     * )
     */
    public function cancelBan()
    {
        $id = input('param.id', 0, 'intval');
        if ($id) {
            Db::name("user")->where(["id" => $id, "user_type" => 2])->setField('user_status', 1);
            $this->success("会员启用成功！", '');
        } else {
            $this->error('数据传入失败！');
        }
    }

    public function edit()
    {
        $id = $this->request->param('id', 0, 'intval');
        if($id){
            $info = Db::name('user')->where(['id' => $id])->find();
            $this->assign('info',$info);
            return $this->fetch();
        }else {
            $this->error('请求错误');
        }
        
    }

    public function editPost(){
        $data['id'] = $_POST['id'];
        $data['user_type'] = $_POST['user_type'];

        if($_POST['user_pass'] != ""){
            $pass_len = strlen($_POST['user_pass']);
            if($pass_len<6 || $pass_len>18){
                $this->error("密码长度必须是6-18位");
            }
            $data['user_pass']= cmf_password($_POST['user_pass']);
        }
        if($_POST['user_login'] != ""){
            $data['user_login']= $_POST['user_login'];
        }
        $result = DB::name('user')->update($data);
        if($result){
            $this->success("保存成功");
        }else{
            $this->error('保存失败');
        }
    }

    public function withdraw()
    {
        $list = CoinLogModel::getListByType('withdraw');
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function doWithdraw()
    {
        $id = $this->request->param('id', 0, 'intval');
        $ret = CoinLogModel::tb()->where('id',$id)->setField('status', 1);
        if($ret > 0){
            $this->success("审核成功");
        }
    }

    /*
     * 同步代理数据
     */
    public function syncData(){
        $id = $this->request->param('id',0,'intval');
        if($id >= 1){
            $info = UserModel::tb()->where(['id' => $id])->find();
            $code = $info['lkl_org_code'];
            while($info['porg_code'] != 0){
                $info = UserModel::tb()->where(['lkl_org_code' => $info['porg_code']])->find();
            }
            if(empty($info['lkl_org_code'])){
                $this->assign('info',$info);
                return $this->fetch('update_lkl');
            }
            $sid = $info['lkl_session_id'];
            $pid = $info['id'];
            $ret = MemberService::checkLogin($sid);
            if($ret['retCode'] !== '000000'){
                $this->assign('info',$info);
                return $this->fetch('update_lkl');
            }

            //开始同步数据
            //同步代理
            //MemberService::syncAgent($sid,$code,$pid);
            //同步终端
            MemberService::syncTermina($sid,$code,$pid);
            //同步商户
            MemberService::syncMerchant($sid,$code,$pid);
            //同步月交易
            MemberService::syncMonthTrade($sid,$code);

            $this->success('同步成功');
        }
    }

    /*
     * 登录代理获取信息
     */
    public function updateLklPost(){
        if ($this->request->isPost()) {
            $where = [
                'mark' => 'login'
            ];
            $params = [
                'loginName' => $_POST['user_login'],
                'userPwd' => $_POST['user_pass'],
                'code' => $_POST['vcode']
            ];
            $res = ApiService::getApi($where,$params);
            if($res['retCode'] == 000000) {
                $msg = $res['retMsg'];
                $data['lkl_session_id'] = $res['retData']['sessionId'];
                $data['user_nickname'] = $res['retData']['compOrgName'];
                $data['lkl_org_code'] = $res['retData']['compOrgCode'];
                $data['id'] = $_POST['id'];
                $data['last_login_time'] = time();
                $data['last_login_ip'] = get_client_ip(0, true);
                UserModel::tb()->update($data);
                $this->success($msg.'正在同步……');
            }else{
                $msg = $res['retMsg'];
            }
            $this->error($msg);
        }
    }

    /*
     * 分享连接
     */
    public function option(){
        $id = session('ADMIN_ID');
        $info = UserModel::tb()->find($id);

        $trade = cmf_get_option('level_trade');
        $scale = cmf_get_option('level_scale');
        $level['trade'] = implode(',',$trade);
        $level['scale'] = implode(',',$scale);

        $this->assign('level',$level);
        $this->assign('info',$info);
        return $this->fetch();
    }

    /*
     * 分润级别比例
     */
    public function setLevel(){
        if ($this->request->isPost()) {
            $trade = explode(',',$this->request->param('trade'));
            $scale = explode(',',$this->request->param('scale'));

            cmf_set_option('level_trade',$trade,true);
            cmf_set_option('level_scale',$scale,true);
            $this->success("设置成功！");
        }
    }

    /*
     * 设置用户分润比例
     */
    public function setRunScale(){
        $id = $this->request->param('id',0);
        if($id == 0){
            $this->error('参数错误');
        }
        MemberService::setRunScale($id);
        $this->success('设置成功');
    }

    /*
     * 终端激活
     */
    public function activateTerminal(){
        $this->error('由于接口注册时间不准确，暂时不能统一检验是否达标，请在终端列表手动达标');
        $pid = $this->request->param('pid',0);
        if($pid == 0){
            $this->error('参数错误');
        }
        $terminalList = TerminaService::getListByPid($pid,1,2);
        foreach ($terminalList as $v){
            //$code = $v['code'];
            //$is_ok = TradeService::isTerminalActivate($code);
        }
    }

    /*
     * 核算分润
     */
    public function calculateRun(){
        $id = $this->request->param('id',0);
        if($id == 0){
            $this->error('参数错误');
        }
        TradeService::calculateRunByUid($id);
        TradeService::calculateAllRun($id);
        $this->success('核算分润成功');
    }
}
