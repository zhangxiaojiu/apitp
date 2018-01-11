<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2018/1/9
 * Time: 15:46
 */
namespace app\sckmn\controller;

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    //首页
    public function index(){
        $this->assign('seo','【官网】');
        return $this->fetch();
    }
    public function about(){
        $this->assign('seo','【官网】');
        return $this->fetch('index');
    }
    public function lianxi(){
        $this->assign('seo','【官网】');
        return $this->fetch('index');
    }
}