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

use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        $header = [];
        //登录
        $url = "https://mposa.lakala.com/checkLogIn";
        $params = [
            'sessionId' => 'd137387a17d945f7925dc3eb8228f13b'
        ];

        $ret = http_curl($url,$params,'POST',$header);
        p($ret);

        //交易查寻
        $url = "https://mposa.lakala.com/queryTrade";
        $params = [
            'type' => 'T_01',
            'pageSize' => '10',
            'pageNo' => 1,
            'startDate' => '20171216',
            'endDate' => '20171218',
            'merchantExtCode' => '',
            'merchantCode' => '',
            'transCode' => 'P_ALL',
            'signOrg' => 330498,
            'termNo' => '',
            'sessionId' => 'd137387a17d945f7925dc3eb8228f13b',
        ];

        $ret = http_curl($url,$params,'POST',$header);
        p(\Qiniu\json_decode($ret));exit;
    }
}
