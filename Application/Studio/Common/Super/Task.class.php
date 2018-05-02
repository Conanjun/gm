<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Admin\Common\Super;

class Task
{
    const NOT_STARTED = 1;    // 未开始
    const ONGOING = 2;        // 进行中
    const FINISHED = 3;       // 已完成
    const COMMITTED = 4;      // 已提交
    const PAUSED = 5;         // 已暂停
    const CLOSE = -1;         // 已关闭

    public $taskState = [];

    public function __construct()
    {
        $this->taskState = self::getTaskState();
    }

    // 获取任务的状态
    public static function getTaskState()
    {
        $date = [];
        $types = D('Task')->getState();
        foreach ($types as $k => $v) {
            $date[$v['d_value']] = $v['d_key'];
        }
        return $date;
    }

}
