<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/10
 * Time: 12:34
 */

namespace app\sckmn\controller;


use cmf\controller\HomeBaseController;

class LakalaController extends HomeBaseController
{
    public function index(){
        $this->assign('seo','拉卡拉');
        return $this->fetch();
    }
    /*
     * 手机收款宝
     */
    public function mpos(){
        $this->assign('seo','拉卡拉手机收款宝');
        return $this->fetch();
    }
    /*
     * 智能POS
     */
    public function znpos(){
        $this->assign('seo','拉卡拉智能POS');
        return $this->fetch();
    }
    /*
     * 卡果儿
     */
    public function kaguoer(){
        $this->assign('seo','拉卡拉卡果儿');
        return $this->fetch();
    }
}