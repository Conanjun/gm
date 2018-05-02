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

class RegionModel extends Model {
	protected $pk = 'region_id';
	
	/**
	 * 取得地区列表
	 *
	 * @param int $parent_id
	 *        	大于等于0表示取某个地区的下级地区，小于0表示取所有地区
	 *        	* @param varchar $sort
	 *        	* @param varchar $order
	 * @return array
	 */
	public function get_list($sort, $order, $parent_id = -1) {
		if (empty ( $sort )) {
			$sort = 'region_id';
		}
		if (empty ( $order )) {
			$order = 'asc';
		}
		if ($parent_id >= 0) {
			return $this->where("parent_id='{$parent_id}'")->order("$sort $order")->select();
		} else {
			return $this->order("$sort $order")->select();
		}
	}
	
	/*
	* 判断名称是否唯一
	*/
	public function unique($region_name, $parent_id, $region_id = 0)
	{
		$where = "parent_id = '" . $parent_id . "' AND region_name = '" . $region_name . "'";
		$region_id && $where .= " AND ".$this->pk." <> '" . $region_id . "'";
		return $this->where($where)->count();
	}
	
	/**
	 * 取得options，用于下拉列表
	 */
	public function get_options($parent_id = 0)
	{
		$res = array();
		$res = $this->get_list("","desc",$parent_id);
		return $res;
	}
	
	/**
	 * 取得某地区的所有子孙地区id
	 */
	public function get_descendant($id)
	{
		$ids = array($id);
		$ids_total = array();
		$this->_get_descendant($ids, $ids_total);
		return array_unique($ids_total);
	}
	
	/**
	 * 取得某地区的所有父级地区
	 *
	 * @author Garbin
	 * @param  int $region_id
	 * @return void
	 **/
	public function get_parents($region_id)
	{
		$parents = array();
		$region = $this->field('parent_id')->where(array('region_id'=>$region_id))->find();
		if (!empty($region))
		{
			if ($region['parent_id'])
			{
				$tmp = $this->get_parents($region['parent_id']);
				$parents = array_merge($parents, $tmp);
				$parents[] = $region['parent_id'];
			}
			$parents[] = $region_id;
		}
		
		return array_unique($parents);
	}
	
	public function _get_descendant($ids, &$ids_total)
	{
		$childs = $this->field('region_id')->where(array('parent_id'=>$ids))->select();
		$ids_total = array_merge($ids_total, $ids);
		$ids = array();
		foreach ($childs as $child)
		{
			$ids[] = $child['region_id'];
		}
		if (empty($ids))
		{
			return ;
		}
		$this->_get_descendant($ids, $ids_total);
	}
}