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
 * 消息模型 : LGW
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class MessageModel extends Model
{
    protected $pk = 'msg_id';

    /**
     * 获取全部消息信息 带分页
     *
     * @param $where
     * @param $page
     *
     * @return mixed
     */
    public function getList($where, $page)
    {
        $list = $this
            ->field('me.*')
            ->alias('me')
            ->where($where)
            ->order("addtime desc")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        return $list;
    }
    
    /**
     * 获取总条数
     *
     * @param
     * @param
     *
     * @return mixed
     */
    public function countNum($where){
    	return $this->alias('me')->where($where)->count();
    }

    /**
     * 按条件查询一条数据
     *
     * @param $where
     *
     * @return mixed
     */
    public function getOne($where)
    {
        $one = $this->field('me.*')
            ->alias('me')
            ->where($where)
            ->find();
        return $one;
    }


}
