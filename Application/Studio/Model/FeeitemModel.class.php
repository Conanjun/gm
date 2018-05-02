<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com>
// +----------------------------------------------------------------------

namespace Studio\Model;

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
    * 费用总条数
    */
    public function countNum($where){
        return $this->alias('f')->where($where)->count();
    }
    /*
    * 查询费用 单条
    */
    public function getList($where){
        return $this->alias('f')->where($where)->find();
    }
    /*
    * 判断费用名称是否唯一
    */
    public function uniqueName($name,$type_id = 0)
    {
        $where = " feename = '$name'";
        $type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
        return $this->where($where)->count();
    }
    /*
    * 判断费用编码是否唯一
    */

    public function uniqueCode($name,$type_id = 0)
    {
        $where = " feecode = '$name'";
        $type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
        return $this->where($where)->count();
    }


}
