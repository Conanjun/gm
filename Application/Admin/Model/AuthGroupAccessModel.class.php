<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

class AuthGroupAccessModel extends Model {

	protected $pk  =   'accid';
	// 数据表名（不包含表前缀）
	protected $tableName        =   'auth_group_access';
	/*
	* 总条数
	*/
	public function countNum($where){
		return $this->alias('o')->where($where)->count();
	}
	/*
	* 查询 单条
	*/
	public function getList($where){
		return $this->alias('o')->where($where)->find();
	}
}
