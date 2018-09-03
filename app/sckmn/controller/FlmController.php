<?php

namespace app\sckmn\controller;

use cmf\controller\HomeBaseController;

class FlmController extends HomeBaseController
{
    public function index(){
	$this->assign('seo','付联盟');
	return $this->fetch();
    }
}
