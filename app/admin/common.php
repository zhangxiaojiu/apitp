<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2017/12/20
 * Time: 15:46
 */
/*判断推荐人是否存在*/
function cmf_pmobile_info($mobile)
{
    $res = Db::name('user')->where(['mobile' => $mobile])->find();
    if($res){
        return $res;
    }else{
        return false;
    }
}

/*获取 coin type*/
function cmf_get_coin_type($type)
{
    if($type == 'tx'){
        return "提现";
    }elseif($type == 'bind'){
        return "绑定";
    }elseif($type == 'active'){
        return "激活";
    }else{
        return "未知";
    }
}

function cmf_get_coin_status($status)
{
    if($status == 0){
        return "<span style='color:orange;'>处理中</span>";
    }elseif($status == 1){
        return "<span style='color:green;'>已完成</span>";
    }
}