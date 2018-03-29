<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/21
 * Time: 下午4:45
 */

namespace app\admin\controller;


use app\admin\model\TradeModel;
use app\admin\model\UserModel;
use app\admin\service\MemberService;
use app\admin\service\TerminaService;
use app\admin\service\TradeService;
use cmf\controller\AdminBaseController;

class TradeController extends AdminBaseController
{
    public function index(){
        $where   = [];
        $request = input('request.');

        if(!empty($request['uid'])){
            $terminaList = TerminaService::getListByUid($request['uid']);
            foreach($terminaList as $v){
                $terminaArray[] = $v['code'];
            }
            $where['term_no'] = ['IN',$terminaArray];
        }
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

        $search['where'] = $where;
        $search['keyword'] = $keywordComplex;
        $page = input('request.page');
        if (!isset($page)) {
            session('search', null);
        }
        if (!empty($where) || !empty($keywordComplex)) {
            session('search', $search);
        }
        if ($page >= 1) {
            $where = session('search')['where'];
            $keywordComplex = session('search')['keyword'];
        }

        $list = TradeModel::tb()->where($where)->whereOr($keywordComplex)->paginate(10);
        $page = $list->render();

        $user_list = MemberService::getUserList(session('ADMIN_ID'),1);

        $this->assign('user_list',$user_list);
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    /*
     * 交易统计
     */
    public function count(){
        $uid = session('ADMIN_ID');
        $userList = MemberService::getUserList($uid,1);
        $this->assign('org_code', $userList);
        $list = [];
        $total = [];
        if ($this->request->isPost()){
            $codeArr = explode('_',$_POST['signOrg']);
            $code = $codeArr[1];
            $startDate = str_replace('-','',$_POST['startDate']);
            $endDate = str_replace('-','',$_POST['endDate']);
            if($codeArr[0] == 'sys'){

                $total = TradeService::getTradeTotal($code,$startDate,$endDate);
                $info = UserModel::getInfoById($code);
                $list[0]['maintainOrg'] = $info['user_nickname'];
                $list[0]['transCntTotal'] = $total['num'];
                $list[0]['transAmtTotal'] = $total['amt'];
            }else {
                if($code == 0){
                    $code = '';
                }
                $info = UserModel::tb()->where(['id' => $uid])->find();
                $sid = $info['lkl_session_id'];

                $ret = MemberService::checkLogin($sid);
                if ($ret['retCode'] !== '000000') {
                    $this->assign('info', $info);
                    return $this->fetch('member/update_lkl');
                }

                $ret = MemberService::getApiTradeCount($sid, $code, $startDate, $endDate);
                if ($ret['retCode'] == 'SUCCESS') {
                    if (empty($ret['retData']['content'])) {
                        $this->error('暂无数据');
                    }
                    $list = $ret['retData']['content'];
                    $total['num'] = $ret['retData']['cntTotal'];
                    $total['amt'] = $ret['retData']['amtTotal'];
                } else {
                    $this->error($ret['retMsg']);
                }
            }
        }

        $this->assign('total',$total);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /*
     * 导入记录
     */
    public function import(){
        echo "暂不需要";
    }
}