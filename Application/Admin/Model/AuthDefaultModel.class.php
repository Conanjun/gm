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
/**
 * 预定义工作室角色模型 : ZL
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class AuthDefaultModel extends Model {

	protected $pk               =   'id';
	/*
	* 总条数
	*/
	public function countNum($where){
		return $this->alias('a')->where($where)->count();
	}
	/*
	* 查询 单条
	*/
	public function getList($where){
		return $this->alias('a')->where($where)->find();
	}
	/*
	* 判断工作室名称是否唯一
	*/
	public function uniqueName($name,$type_id = 0)
	{
		$where = " title = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	
}