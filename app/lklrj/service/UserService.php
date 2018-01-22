<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/3
 * Time: 16:45
 */
namespace app\lklrj\service;

use app\admin\model\MerchantModel;
use app\admin\model\UserModel;

class UserService
{
    /*
     * 存储登录信息
     */
    public static function doLoginUser($input){
        $where = [
            'lkl_org_code' => $input['org_code'],
        ];
        $info = UserModel::tb()->where($where)->find();
        $data = [
            'user_login' => $input['username'],
            'lkl_password' => $input['passpword'],
            'lkl_session_id' => $input['sid'],
            'user_nickname' => $input['org_name'],
            'lkl_org_code' => $input['org_code'],
            'user_type' => UserModel::TYPE_LKL_AGENT,
        ];
        if($info){
            $data['id'] = $info['id'];
            $data['last_login_time'] = time();
            $data['last_login_ip'] = get_client_ip(0, true);
            UserModel::tb()->update($data);
            $lklId = $info['id'];
        }else{
            $data['create_time'] = time();
            $data['last_login_time'] = time();
            $data['last_login_ip'] = get_client_ip(0, true);
            $lklId = UserModel::tb()->insertGetId($data);
        }
        $lklUser = [
            'id' => $lklId,
            'name' => $input['org_name'],
            'sid' => $input['sid'],
            'org_code' => $input['org_code'],
        ];
        session('lkl_user', $lklUser);
    }
    /*
     * 获取商户、终端、代理统计
     */
    public static function getTotalInfo($sid){
        //获取终端统计
        $where = [
            'mark' => 'queryMessageTermina',
        ];
        $params = [
            'sessionId' => $sid,
        ];
        $ret = ApiService::getApi($where,$params);
        if($ret['retCode'] == '000000'){
            $data['lkl_termina'] = $ret['retData']['totalNum'];
        }
        //获取商户统计
        $where = [
            'mark' => 'queryMessageMerchant',
        ];
        $params = [
            'sessionId' => $sid,
        ];
        $ret = ApiService::getApi($where,$params);
        if($ret['retCode'] == '000000'){
            $data['lkl_merchant'] = $ret['retData']['totalNum'];
        }
        //获取下级代理
        $where = [
            'mark' => 'getSubAgentList',
        ];
        $params = [
            'sessionId' => $sid,
        ];
        $ret = ApiService::getApi($where,$params);
        if($ret['retCode'] == '000000'){
            $data['lkl_agent'] = count($ret['retData']);
        }
        //完善下级代理
        $num = $data['lkl_agent'];
        $size = 10;
        $page = ceil($num/$size);
        for($i=1;$i<=$page;$i++){
            $where = [
                'mark' => 'getSubAgentListAndDetail',
            ];
            $params = [
                'page' => $i,
                'pageSize' => $size,
                'isChild' => 1,
                'sessionId' => $sid,
            ];
            $ret = ApiService::getApi($where,$params);
            if($ret['retCode'] == '000000'){
                self::perfectAgent($ret['retData']['data']);
            }
        }

        UserModel::tb()->where(['lkl_org_code'=>session('lkl_user')['org_code']])->update($data);
    }

    /*
     * 完善代理商信息
     */
    private static function perfectAgent($list){
        foreach ($list as $v){
            //当前用户跳过
            if($v['compOrgCode'] == session('lkl_user')['org_code']){
                continue;
            }
            $info = UserModel::tb()->where(['lkl_org_code' => $v['compOrgCode']])->find();

            $data = [
                'pid' => session('lkl_user')['id'],
                'user_nickname' => isset($v['crName'])?$v['crName']:'',
                'lkl_org_code' => isset($v['compOrgCode'])?$v['compOrgCode']:'',
                'user_card' => isset($v['crLicenceNo'])?$v['crLicenceNo']:'',
                'mobile' => isset($v['detail']['telephone'])?$v['detail']['telephone']:'',
                'user_address' => isset($v['detail']['address'])?$v['detail']['address']:'',
                'user_email' => isset($v['detail']['beforeEmail'])?$v['detail']['beforeEmail']:'',
                'lkl_merchant' => isset($v['detail']['merchantNum'])?$v['detail']['merchantNum']:'',
                'lkl_termina' => isset($v['tereminaBdNum'])?$v['tereminaBdNum']:'',
                'user_type' => UserModel::TYPE_LKL_AGENT,
            ];

            if($info){
                $data['id'] = $info['id'];
                UserModel::tb()->update($data);
            }else{
                UserModel::tb()->insert($data);
            }
        }
    }

    /*
     * 同步商户信息
     */
    public static function syncMerchant($id,$sid){
        $where = [
            'pid'=>$id,
            'id' =>['>',2844],
        ];
        $list = UserModel::tb()->where($where)->select();
//        p($list,0);
        foreach ($list as $v){
            $code = $v['lkl_org_code'];
            $where = [
                'mark' => 'queryMerchant',
            ];
            $params = [
                'sessionId' => $sid,
                'group' => $code,
                'start' => 0,
                'limit' => 10000,
            ];
            $ret = ApiService::getApi($where,$params);
            if($ret['retCode'] == '000000'){
                self::perfectMerchant($ret['retData']['data']);
            }
        }
    }

    /*
     * 完善商户信息
     */
    private static function perfectMerchant($list){
        foreach ($list as $v){
            $info = MerchantModel::tb()->where(['merchant_code' => $v['posmercode']])->find();

            $data = [
                'pid' => session('lkl_user')['id'],
                'merchant_code' => isset($v['posmercode'])?$v['posmercode']:'',
                'merchant_name' => isset($v['merchantName'])?$v['merchantName']:'',
                'agent_id' => isset($v['group'])?$v['group']:'',
                'real_name' => isset($v['contactName'])?$v['contactName']:'',
                'mobile' => isset($v['contactMobile'])?$v['contactMobile']:'',
                'mobile' => isset($v['contactMobile'])?$v['contactMobile']:'',
                'user_card' => isset($v['userCertNo'])?$v['userCertNo']:'',
                'address' => isset($v['areaName'])?$v['areaName']:''.isset($v['address'])?$v['address']:'',
                'bank_name' => isset($v['bankName'])?$v['bankName']:'',
                'bank_user' => isset($v['accountName'])?$v['accountName']:'',
                'bank_card' => isset($v['accountNo'])?$v['accountNo']:'',
                'email' => isset($v['email'])?$v['email']:'',
                'type' => 'lkl',
            ];

            if($info){
                $data['id'] = $info['id'];
                MerchantModel::tb()->update($data);
            }else{
                MerchantModel::tb()->insert($data);
            }
        }
    }
}