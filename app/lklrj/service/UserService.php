<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/3
 * Time: 16:45
 */
namespace app\lklrj\service;

use app\user\model\UserModel;

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
        ];
        if($info){
            $data['id'] = $info['id'];
            $data['last_login_time'] = time();
            $data['last_login_ip'] = get_client_ip(0, true);
            UserModel::tb()->update($data);
        }else{
            $data['create_time'] = time();
            $data['last_login_time'] = time();
            $data['last_login_ip'] = get_client_ip(0, true);
            UserModel::tb()->insert($data);
        }
        $lklUser = [
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
}