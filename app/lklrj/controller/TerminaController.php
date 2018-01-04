<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/4
 * Time: 18:20
 */

namespace app\lklrj\controller;


use app\lklrj\service\ApiService;

class TerminaController extends BaseController
{
    public function index(){
        $page = input('get.page',1);
        if($page-1 < 0){
            $page = 1;
        }
        $sid = session('lkl_user')['sid'];
        $where = [
            'mark' => 'queryCardsByOrgCode'
        ];
        $params = [
            'sessionId' => $sid,
            'start' => ($page-1)*10,
            'limit' => 10,
            'isCallback' => false
        ];
        $ret = ApiService::getApi($where,$params);
        $list = $ret['retData']['data'];
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
}