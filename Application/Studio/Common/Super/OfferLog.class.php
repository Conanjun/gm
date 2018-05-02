<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Admin\Common\Super;

class OfferLog
{
    const NOT_STARTED = 1;    // 未开始
    const ONGOING = 2;        // 进行中
    const FINISHED = 3;       // 已完成
    const COMMITTED = 4;      // 已提交
    const PAUSED = 5;         // 已暂停
    const CLOSE = -1;         // 已关闭
    public static $fieldName = [
        'base_amount' => '基础报价合计',
        'oper_cost' => '项目管理费',
        'oper_rate' => '项目管理费税',
        'tax' => '税',
        'tax_rate' => '税率',
        'discount' => '折扣',
        'discount_rate' => '折扣率',
        'calculate_amount' => '计算报价',
        'actual_amount' => '实际报价',
    ];


}
