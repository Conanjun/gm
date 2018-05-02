<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com>
// +----------------------------------------------------------------------

namespace Dentist\Model;

use Think\Model;

/**
 * 付款模式模型 : LGW
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class FeeitemModel extends Model
{
    protected $pk = 'itemid';

	/*
	* 工作室总条数
	*/
	public function countNum($where){
		return $this->alias('i')->where($where)->count();
	}
	/*
	* 查询工作室 单条
	*/
	public function getList($where){
		return $this->alias('i')->where($where)->find();
	}
	/*
	* 判断工作室名称是否唯一
	*/
	public function uniqueName($name,$type_id = 0)
	{
		$where = " feename = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	/*
	* 获取编码
	*/
	public function getCode($new_code){
		if ($new_code) {
			$code = $new_code;
		} else {
			$code = $this->order("".$this->pk." desc")->getField('feecode');
		}
		
		if ($code) {
			$code = (int)$code + 1;
		} else {
			$code = '100001';
		}
		
		if ($this->where("feecode = '{$code}'")->count('1')) {
			$this->getCode($code);
		}
		return $code;
	}

}
