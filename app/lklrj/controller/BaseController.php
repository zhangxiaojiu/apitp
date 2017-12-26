<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2017/12/26
 * Time: 15:01
 */

namespace app\lklrj\controller;


use think\Request;

class BaseController extends \cmf\controller\BaseController
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }
}