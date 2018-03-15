<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/10
 * Time: 下午2:37
 */

namespace app\lklrj\service;


use app\admin\model\TerminaModel;
use app\user\model\UserModel;

class TerminaService
{
    public static function syncAllTermina($id,$sid){
        self::syncTermina($sid,session('lkl_user')['org_code']);
        $where = [
            'pid'=>$id,
        ];
        $list = UserModel::tb()->where($where)->select();
        foreach ($list as $v){
            $code = $v['lkl_org_code'];
            self::syncTermina($sid,$code);
        }
    }
    public static function syncTermina($sid,$code){
        $where = [
            'mark' => 'queryCardsByOrgCode',
        ];
        $params = [
            'sessionId' => $sid,
            'groupCode' => $code,
            'start' => 0,
            'isCallback' => false,
            'limit' => 10000,
        ];
        $ret = ApiService::getApi($where,$params);
        if($ret['retCode'] == '000000'){
            self::perfectTermina($ret['retData']['data']);
        }
    }
    private static function perfectTermina($list){
        foreach ($list as $v){
            $info = TerminaModel::tb()->where(['code' => $v['cardNo']])->find();

            $data = [
                'code' => isset($v['cardNo'])?$v['cardNo']:'',
                'pid' => session('lkl_user')['id'],
                'uid' => isset($v['user'])?$v['user']:'',
                'cid' => isset($v['org'])?$v['org']:session('lkl_user')['org_code'],
                'status' => isset($v['status'])?$v['status']:0,
                'detail' => isset($v['statusName'])?$v['statusName']:'未定义',
                'time' => time(),
            ];

            if($info){
                $data['id'] = $info['id'];
                TerminaModel::tb()->update($data);
            }else{
                TerminaModel::tb()->insert($data);
            }
        }
    }
}