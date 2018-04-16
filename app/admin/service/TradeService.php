<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/29
 * Time: 下午2:27
 */

namespace app\admin\service;


use app\admin\model\ThirdPartyUserModel;
use app\admin\model\TradeModel;
use app\admin\model\UserModel;
use app\lklrj\service\WxService;
use think\Db;

class TradeService
{
    /*
     * 交易统计
     */
    public static function getTradeTotal($id,$startDate,$endDate){
        $terminalList = TerminaService::getListByUid($id);
        if(count($terminalList) > 0) {
            foreach ($terminalList as $v) {
                $terminalArray[] = $v['code'];
            }
            $where['term_no'] = ['IN', $terminalArray];
            $where['trans_time'] = ['between', "$startDate,$endDate"];
            $tradeList = TradeModel::tb()->where($where)->select();
            $amt = 0;
            foreach ($tradeList as $v) {
                $amt += $v['trans_amt'];
            }
            $total['num'] = count($tradeList);
            $total['amt'] = $amt;
            return $total;
        }else{
            $total['num'] = 0;
            $total['amt'] = 0;
            return $total;
        }
    }


    /*
     * 终端是否激活
     */
    public static function isTerminalActivate($code){
        $where['term_no'] = $code;
        $where['trans_time'] = $code;
        $list = TradeModel::tb()->where($where)->select();
        return $list;
    }

    /*
     * 计算一个用户分润
     */
    public static function calculateRunByUid($id){
        $tList = TerminaService::getListByUid($id,1);
        if(count($tList) > 0) {
            foreach ($tList as $v) {
                $tArray[] = $v['code'];
            }
            $where['term_no'] = ['IN', $tArray];
            $where['status'] = 0;
            $tradeList = TradeModel::tb()->where($where)->select();
            $amt = 0;
            $num = count($tradeList);
            if ($num == 0) {
                return false;
            }
            foreach ($tradeList as $v) {
                $amt += $v['trans_amt'];
            }
            $scale = UserModel::getScaleById($id);
            $coin = round($amt * $scale, 2);

            Db::startTrans();

            $cRet = CoinService::changeCoin($id, 'run', $coin);
            if (!$cRet) {
                Db::rollback();
            }

            $data = [
                'uid' => $id,
                'coin' => $coin,
                'type' => 'run',
                'detail' => $num . '条交易记录,交易量¥' . $amt . ',结算分润得' . $coin,
                'status' => 1,
            ];
            $clRet = CoinLogService::addCoinLog($data);
            if (!$clRet) {
                Db::rollback();
            }
            TradeModel::tb()->where($where)->update(['status' => 1, 'cl_id' => $clRet]);

            $pDiffRunRet = self::addDiffRun($id, $amt);
            if (!$pDiffRunRet) {
                Db::rollback();
            }

            Db::commit();
            //微信模版消息
            $wxUser = ThirdPartyUserModel::tb()->where(['user_id'=>$id])->find();
            if(!empty($wxUser)) {
                $uInfo = UserModel::getInfoById($id);
                $openId = $wxUser['openid'];
                $type = '1';//分润
                $remark = '尊敬的会员您好，你的账户分润到账¥'.$coin.'，请及时查收。';
                WxService::tmpAccountChange($openId, $type, $uInfo['user_nickname'], $remark);
            }
        }
    }

    /*
     * 添加分润差
     */
    public static function addDiffRun($id,$money){
        $uInfo = UserModel::getInfoById($id);
        if($uInfo['pid'] != 0) {
            $scale = UserModel::getScaleById($id);
            $pScale = UserModel::getScaleById($uInfo['pid']);
            $diffScale = $pScale - $scale;
            if($diffScale > 0){
                $diffRun = round($money*$diffScale,2);
                $cRet = CoinService::changeCoin($uInfo['pid'],'diff_run',$diffRun);
                if(!$cRet){
                    Db::rollback();
                }

                $data= [
                    'uid' => $uInfo['pid'],
                    'coin' => $diffRun,
                    'type' => 'diff_run',
                    'detail' => '用户'.$uInfo['user_nickname'].',结算点'.$scale.'交易量¥'.$money.',结算分润差得'.$diffRun,
                    'status' => 1,
                ];
                $clRet = CoinLogService::addCoinLog($data);
                if(!$clRet){
                    Db::rollback();
                }
            }
            self::addDiffRun($uInfo['pid'],$money);
        }
        return true;
    }

    /*
     * 计算所有下级用户分润
     */
    public static function calculateAllRun($id){
        $uList = MemberService::getUserListByPid($id,1);
        if(count($uList) > 0){
            foreach ($uList as $v){
                $uid = $v['id'];
                self::calculateRunByUid($uid);
                self::calculateAllRun($uid);
            }
        }
    }
}