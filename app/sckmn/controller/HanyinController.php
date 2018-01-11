<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/10
 * Time: 12:34
 */

namespace app\sckmn\controller;


use cmf\controller\HomeBaseController;

class HanyinController extends HomeBaseController
{
    public function index(){
        $this->assign('seo','瀚银');
        return $this->fetch();
    }
    /*
     * 瀚银手付通
     */
    public function mpos(){
        $this->assign('seo','瀚银手付通');
        return $this->fetch();
    }
}