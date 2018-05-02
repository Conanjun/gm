<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Admin\Common\Super;

/**
 *
 * Class Project  :LGW
 *
 * @package Admin\Common\Super
 */
class Bug
{
    const UNSOLVED = -1;    // 未解决
    const ONGOING = 1;      // 进行中
    const RESOLVED = 4;    // 已解决
    const CLOSE = 6;       // 已关闭
    const THEREFORE = '';  // 所有

    public static $projectState = [
        '0' => '新建',
        '1' => '进行中',
        '2' => '发布测试',
        '3' => '预发',
        '4' => '已解决',
        '5' => '反馈',
        '6' => '已关闭',
        '7' => '已拒绝',
        '8' => '暂停',
    ];
}
