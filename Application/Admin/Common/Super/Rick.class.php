<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Admin\Common\Super;

class Rick
{
    public $level = [];
    public $grade = [];

    public function __construct()
    {
        $this->level = self::getlevel();
        $this->grade = self::getGrade();
    }

    // 获取风险优先级
    public static function getLevel()
    {
        $date = [];
        $levels = D('Risk')->getLevel();
        foreach ($levels as $k => $v) {
            $date[$v['d_value']] = $v['d_key'];
        }
        return $date;
    }

    // 获取风险影响程度
    public static function getGrade()
    {
        $date = [];
        $levels = D('Risk')->getGrade();
        foreach ($levels as $k => $v) {
            $date[$v['d_value']] = $v['d_key'];
        }
        return $date;
    }


}
