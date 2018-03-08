<?php
/**
 * Created by PhpStorm.
 * User: zhjigu
 * Date: 2018/3/8
 * Time: 下午3:20
 */

namespace app\lklrj\controller;


class AcountController extends BaseController
{
    public function index(){

        return $this->fetch();
    }
}