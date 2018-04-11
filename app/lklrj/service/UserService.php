<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/3
 * Time: 16:45
 */
namespace app\lklrj\service;

use app\admin\model\UserModel;

class UserService
{
    /*
     * 存储登录信息
     */
    public static function doLoginUser($input){
        $where = [
            'user_login' => $input['username'],
        ];
        $info = UserModel::tb()->where($where)->find();
        $data = [
            'user_login' => $input['username'],
            'lkl_password' => $input['passpword'],
            'user_pass' => cmf_password($input['passpword']),
            'lkl_session_id' => $input['sid'],
            'user_nickname' => $input['org_name'],
            'lkl_org_code' => $input['org_code'],
            'user_type' => UserModel::TYPE_SUPER_ADMIN,
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
        session('user', $lklUser);
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

        UserModel::tb()->where(['lkl_org_code'=>session('lkl_user')['org_code']])->update($data);
    }

    private static function getApiAgent($sid,$code){
        $where = [
            'mark' => 'getSubAgentListAndDetail',
        ];
        $params = [
            'page' => 1,
            'pageSize' => 10000,
            'isChild' => 1,
            'sessionId' => $sid,
            'compOrgParent' => $code,
        ];
        $ret = ApiService::getApi($where,$params);
        return $ret;
    }

    public static function syncAgent($sid,$code){
        $ret = self::getApiAgent($sid,$code);
        if($ret['retCode'] == '000000'){
            self::perfectAgent($ret['retData']['data'],$code);
        }
    }

    /*
     * 完善代理商信息
     */
    private static function perfectAgent($list,$code){
        foreach ($list as $v){
            //当前用户跳过
            if($v['compOrgCode'] == $code){
                continue;
            }
            $info = UserModel::tb()->where(['lkl_org_code' => $v['compOrgCode']])->find();

            $data = [
                'pid' => session('lkl_user')['id'],
                'porg_code' => $code,
                'user_nickname' => isset($v['crName'])?$v['crName']:'',
                'lkl_org_code' => isset($v['compOrgCode'])?$v['compOrgCode']:'',
                'user_card' => isset($v['crLicenceNo'])?$v['crLicenceNo']:'',
                'mobile' => isset($v['detail']['telephone'])?$v['detail']['telephone']:'',
                'user_address' => isset($v['detail']['address'])?$v['detail']['address']:'',
                'user_email' => isset($v['detail']['beforeEmail'])?$v['detail']['beforeEmail']:'',
                'lkl_merchant' => isset($v['detail']['merchantNum'])?$v['detail']['merchantNum']:'',
                'lkl_termina' => isset($v['tereminaBdNum'])?$v['tereminaBdNum']:'',
                'user_type' => UserModel::TYPE_LKL_AGENT,
                'create_time' => time(),
            ];

            if($info){
                $data['id'] = $info['id'];
                UserModel::tb()->update($data);
            }else{
                UserModel::tb()->insert($data);
            }
            $ret = self::getApiAgent(session('lkl_user')['sid'],$v['compOrgCode']);
            if($ret['retCode'] == '000000' && $ret['retData']['count'] > 1){
                self::perfectAgent($ret['retData']['data'],$v['compOrgCode']);
            }
        }
    }
}