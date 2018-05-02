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
 * 支付方式模型 : ZL
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class PaymentModel extends Model {

	protected $pk               =   'payid';
	/*
	* 总条数
	*/
	public function countNum($where){
		return $this->alias('p')->where($where)->count();
	}
	/*
	* 查询 单条
	*/
	public function getList($where){
		return $this->alias('p')->where($where)->find();
	}
	/*
	* 判断名称是否唯一
	*/
	public function uniqueName($name,$type_id = 0)
	{
		$where = " name = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	/*
	* 判断名称是否唯一
	*/
	public function uniqueCode($name,$type_id = 0)
	{
		$where = " code = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	
}