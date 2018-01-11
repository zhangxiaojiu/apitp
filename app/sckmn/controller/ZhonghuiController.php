<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/10
 * Time: 12:34
 */

namespace app\sckmn\controller;


use cmf\controller\HomeBaseController;

class ZhonghuiController extends HomeBaseController
{
    public function index(){
        $this->assign('seo','中汇');
        return $this->fetch();
    }
    /*
     * 手机收款宝
     */
    public function mpos(){
        $this->assign('seo','中汇掌富通');
        return $this->fetch();
    }
    /*
     * 智能POS
     */
    public function npos(){
        $this->assign('seo','中汇大POS');
        return $this->fetch();
    }
}