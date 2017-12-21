<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2017/12/21
 * Time: 19:54
 */

namespace app\admin\controller;


use cmf\controller\AdminBaseController;

class ApiController extends AdminBaseController
{
    //接口列表
    public function index(){
        return $this->fetch();
    }

    /*
     * 添加接口
     */
    public function addApi(){

    }
}