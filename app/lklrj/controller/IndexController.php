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
        $header = [
            'Accept' => 'application/json, text/plain, */*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Accept-Language' => 'zh-CN,zh;q=0.9,en;q=0.8,zh-TW;q=0.7,la;q=0.6',
            'Connection' => 'keep-alive',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Host' => 'mposa.lakala.com',
            'Origin' => 'https://mposa.lakala.com',
            'Referer' => 'https://mposa.lakala.com/',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36'
        ];
        //登录
        $url = "https://mposa.lakala.com/checkLogIn";
        $params = [
            'sessionId' => 'c84ba7c708f24d9eb917580834048f83'
        ];
        $header['Cookie'] = 'compOrgCode=330498; compOrgName=éªéå¤§ä»£çKM; SESSION=745458d8-e9cd-46d0-b702-9d581be1b6a7; sId=c84ba7c708f24d9eb917580834048f83';

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
            'sessionId' => '7847e0969c524bf69829eeb1e909bc72',
        ];
        $header = [
            'Accept' => 'application/json, text/plain, */*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Accept-Language' => 'zh-CN,zh;q=0.9,en;q=0.8,zh-TW;q=0.7,la;q=0.6',
            'Connection' => 'keep-alive',
            'Content-Length' => '179',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Cookie' => 'SESSION=ac14d1bf-7939-41ad-a36b-4353af87307f; sId=6f94525d6df347c190ad0a50c37f3442; compOrgCode=330498; compOrgName=éªéå¤§ä»£çKM',
            'Host' => 'mposa.lakala.com',
            'Origin' => 'https://mposa.lakala.com',
            'Referer' => 'https://mposa.lakala.com/',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36'
        ];
        $ret = http_curl($url,$params,'POST',$header);
        p(\Qiniu\json_decode($ret));exit;
    }
}
