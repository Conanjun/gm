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
/**
 * 设计诊所模型 : ZL
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class DentistModel extends Model {

	protected $pk               =   'denid';
	/*
	* 诊所总条数
	*/
	public function countNum($where){
		return $this->alias('d')->join('ot_member m on d.uid = m.uid')->where($where)->count();
	}
	/*
	* 查询诊所 单条
	*/
	public function getList($where){

		return $this->alias('d')->join('ot_member m on d.uid = m.uid')->where($where)->find();
	}
	/*
	* 判断诊所名称是否唯一
	*/
	public function uniqueName($name,$type_id = 0)
	{
		$where = " name = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	

	/*
	* 诊所是否可用
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

