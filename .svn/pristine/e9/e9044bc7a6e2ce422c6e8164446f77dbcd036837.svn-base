<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com>
// +----------------------------------------------------------------------

namespace Admin\Model;

use Think\Model;

/**
 *  种植体品牌及型号: FHC
 *
 */
class PlantingSysModel extends Model
{
    protected $pk = 'id';

	/*
	* 品牌型号总条数
	*/
	public function countNum($where){
		return $this->alias('f')->where($where)->count();
	}
	/*
	* 查询品牌型号 单条
	*/
	public function getList($where){
		return $this->alias('f')->where($where)->find();
	}
	/*
	* 判断品牌型号中文名称是否唯一
	*/
	public function uniqueZhName($name,$type_id = 0)
	{
		$where = " zh_name = '$name'";
		$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
		return $this->where($where)->count();
	}

    /*
    * 判断品牌型号英文名称是否唯一
    */
    public function uniqueEnName($name,$type_id = 0)
    {
        $where = " en_name = '$name'";
        $type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
        return $this->where($where)->count();
    }

}
