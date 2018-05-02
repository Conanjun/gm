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
 * 设计工作室模型 : ZL
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class StudioModel extends Model {

	protected $pk               =   'stuid';
	/*
	* 工作室总条数
	*/
	public function countNum($where){
		return $this->alias('s')->where($where)->count();
	}
	/*
	* 查询工作室 单条
	*/
	public function getList($where){
		return $this->alias('s')->where($where)->find();
	}
	/*
	* 判断工作室名称是否唯一
	*/
	public function uniqueName($name,$type_id = 0)
	{
		$where = " name = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	/*
	* 判断工作室标识是否唯一
	*/
	public function uniqueUrlParam($name,$type_id = 0)
	{
		$where = " urlparam = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}
	/*
	* 获取工作室编码
	*/
	public function getCode($new_code){
		if ($new_code) {
			$code = $new_code;
		} else {
			$code = $this->order("".$this->pk." desc")->getField('code');
		}
		
		if ($code) {
			$code = (int)$code + 1;
		} else {
			$code = '100001';
		}
		
		if ($this->where("code = '{$code}'")->count('1')) {
			$this->getCode($code);
		}
		return $code;
	}
	/*
	* 工作室是否可用
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