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

class DictionaryModel extends Model {

	protected $pk  =   'd_tid';
	/*
	* 总条数
	*/
	public function countNum($where){
		return $this->alias('d')->where($where)->count();
	}
	/*
	* 查询 单条
	*/
	public function getList($where){
		return $this->alias('d')->where($where)->find();
	}
	
	
	/*
	* 判断数据字典code是否唯一
	*/
	public function uniqueCode($name,$type_id = 0)
	{
		$where = " d_code = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	/*
	* 判断工作室标识是否唯一
	*/
	public function uniqueName($name,$type_id = 0)
	{
		$where = " d_name = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	
	/*
	* 数据字典是否可用
	*/
	public function enabled(){
		return array(
			0=>array(
				'id' => 1,
				'name' => '开启'
			),
			1=>array(
				'id' => 2,
				'name' => '关闭'
			),
		);
	}
	
	
}
