<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/29
 * Time: 上午10:07
 */

namespace app\admin\service;


use app\admin\model\CoinLogModel;
use app\admin\model\UserModel;

class CoinLogService
{
    /*
     * 资金记录
     */
    public static function addCoinLog($data){
        $data_coin = [
            'uid' => isset($data['uid'])?$data['uid']:0,
            'coin' => isset($data['coin'])?$data['coin']:0,
            'type' => isset($data['type'])?$data['type']:'',
            'detail' => isset($data['detail'])?$data['detail']:'',
            'status' => isset($data['status'])?$data['status']:0,
            'create_time' => time()
        ];

        if($data['coin'] != 0){
            $user = UserModel::tb()->where('id',$data['uid'])->find();
            $data_user = [
                "id" => $data_coin['uid'],
                'coin' => $user['coin'] + $data_coin['coin'],
            ];
            if(!UserModel::tb()->update($data_user)){
                return false;
            }
        }
        return CoinLogModel::tb()->insertGetId($data_coin);
    }

}