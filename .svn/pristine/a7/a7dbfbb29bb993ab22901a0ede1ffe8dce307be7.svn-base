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
 *  手术工具: FHC
 *
 */
class ToolModel extends Model
{
    protected $pk = 'id';

	/*
	* 工具总条数
	*/
	public function countNum($where){
		return $this->alias('f')->where($where)->count();
	}
	/*
	* 查询工具 单条
	*/
	public function getList($where){
		return $this->alias('f')->where($where)->find();
	}
	/*
	* 判断工具中文名称是否唯一
	*/
    public function uniqueZhName($name,$type_id = 0)
    {
        $where = " zh_name = '$name'";
        $type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
        return $this->where($where)->count();
    }
    /*
    * 判断工具英文名称是否唯一
    */
    public function uniqueEnName($name,$type_id = 0)
    {
        $where = " en_name = '$name'";
        $type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
        return $this->where($where)->count();
    }

}
