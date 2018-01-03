<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\lklrj\controller;


class IndexController extends BaseController
{
    /*
     * 首页
     */
    public function index()
    {
        return $this->fetch();
    }
    /*
     * 功能页
     */
    public function menu()
    {
        return $this->fetch();
    }
    /*
     * 个人中心
     */
    public function user()
    {
        return $this->fetch();
    }
}
