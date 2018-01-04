<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/4
 * Time: 17:20
 */

namespace app\lklrj\service;


use app\admin\model\ApiModel;

class ApiService
{
    /*
     * 获取接口
     */
    public static function getApi($where,$data = []){
        $info = ApiModel::tb()->where($where)->find();
        $ret['url'] = $info['url'];
        $ret['type'] = $info['type'];
        $header = json_decode($info['header'], true);
        $ret['header'] = self::getParams($header);
        $params = json_decode($info['params'], true);
        $ret['params'] = self::getParams($params);

        $ret = http_curl($ret['url'],array_merge($data,$ret['params']),$ret['type'],$ret['header']);
        return json_decode($ret,true);
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
}