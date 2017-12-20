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
namespace app\portal\model;

use think\Db;
use think\Model;

class ContactsModel extends Model
{
	public function addContacts($data)
	{
		$conTable = DB::name('contacts');
		$result = $conTable->where(['tel'=>$data['tel'],'description'=>$data['description']])->find();

		if (empty($result)) {
			$conData = array(
				'name' => $data['name'],
				'tel' => $data['tel'],
				'type' => $data['type'],
				'description' => $data['description']
				);
			$conId = $conTable->insertGetId($conData);
			return $conId;
		}
		return 0;
	}


}