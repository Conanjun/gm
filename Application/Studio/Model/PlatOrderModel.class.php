<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Studio\Model;
use Think\Model;

class PlatOrderModel extends Model {

	protected $pk  =   'order_id';
	// 数据表名（不包含表前缀）
	protected $tableName        =   'order';
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
