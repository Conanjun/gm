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
class PaymodeModel extends Model
{
    protected $pk = 'modeid';

    /**
     * 获取全部收费模式信息 带分页
     *
     * @param $where
     * @param $page
     *
     * @return mixed
     */
    public function getList($where, $page)
    {
        $list = $this
            ->field('p.state,p.percent,p.addtime,p.adduid')
            ->alias('p')
            ->where($where)
            ->order("addtime desc")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        return $list;
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
        $one = $this->field('p.state,p.percent,p.addtime,p.adduid')
            ->alias('p')
            ->where($where)
            ->find();
        return $one;
    }


}
