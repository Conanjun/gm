<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 行为模型
 * @author huajie <banhuajie@163.com>
 */

class HistoryModel extends Model {

    /* 自动验证规则 */
    protected $_validate = array(
        array('logid', 'require', 'logid不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('field', 'require', 'field不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('olddata', 'require', 'olddata不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('newdata', 'require', 'newdata不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /* 自动完成规则 */
    protected $_auto = array(
    );

}
