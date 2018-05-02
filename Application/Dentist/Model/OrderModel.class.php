<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Dentist\Model;
use Think\Model;
/**
 * 订单模型 : ZL
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class OrderModel extends Model {

	protected $pk               =   'order_id';
	/*
	* 订单总条数
	*/
	public function countNum($where){
		return $this->alias('o')
			->where($where)
			->count();
	}
	/*
	* 判断订单编码是否唯一
	*/
	public function uniqueCode($code,$type_id = 0)
	{
		$where = " order_sn = '$code'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
}

