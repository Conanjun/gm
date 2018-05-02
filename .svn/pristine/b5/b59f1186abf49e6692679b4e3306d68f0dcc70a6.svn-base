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
class PatientModel extends Model
{
    protected $pk = 'paid';

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
            ->field('pa.denid,pa.headurl,pa.realname,pa.gender,pa.birthday,pa.addr,pa.company,pa.tel,pa.tag,pa.openid,pa.unionid,pa.addtime.pa.adduid')
            ->alias('pa')
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
        $one = $this->field('pa.denid,pa.headurl,pa.realname,pa.gender,pa.birthday,pa.addr,pa.company,pa.tel,pa.tag,pa.openid,pa.unionid,pa.addtime.pa.adduid')
            ->alias('pa')
            ->where($where)
            ->find();
        return $one;
    }


}
