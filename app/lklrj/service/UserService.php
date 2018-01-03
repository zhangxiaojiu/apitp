<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/3
 * Time: 16:45
 */
namespace app\lklrj\service;

use app\admin\model\ApiModel;
use app\user\model\UserModel;

class UserService
{
    public static function getApi($where){
        $info = ApiModel::tb()->where($where)->find();
        $ret['url'] = $info['url'];
        $ret['type'] = $info['type'];
        $header = json_decode($info['header'], true);
        $ret['header'] = self::getParams($header);
        $params = json_decode($info['params'], true);
        $ret['params'] = self::getParams($params);
        return $ret;
    }
    /*
     * 获取参数
     */
    private static function getParams($arr){
        $ret = [];
        if(!empty($arr)) {
            foreach ($arr as $v) {
                if (!empty($v['key'])) {
                    $ret[$v['key']] = $v['value'];
                }
            }
        }
        return $ret;
    }
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
}