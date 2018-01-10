<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------

if (file_exists(CMF_ROOT . "data/conf/route.php")) {
    $runtimeRoutes = include CMF_ROOT . "data/conf/route.php";
} else {
    $runtimeRoutes = [];
}
$myRoutes = array
(
	'old' => 'portal/Index/old',
	'share/:id' => 'user/index/index',
    '__domain__'=>[
        'admin.wtfree.com' => 'admin',
        'www.sckemeinuo.com' => 'sckmn',
        'sckemeinuo.com' => 'sckmn',
        'www.mylabulak.com' => 'portal',
        'mylabulak.com' => 'portal',
        'scjlzf.com'      => 'lklrj',
        'www.scjlzf.com'      => 'lklrj',
        'lakala.sckemeinuo.com' => 'sckmn/lakala'
    ],
);
return array_merge($runtimeRoutes,$myRoutes);