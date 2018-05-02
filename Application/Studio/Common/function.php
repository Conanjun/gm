<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------


/**
 * 后台公共文件
 * 主要定义后台公共函数库
 */

/**
 * 获取数量
 *
 * @param $model
 * @param $where
 *
 * @return \Think\Page
 */
function getCount($model, $where)
{
    return new \Think\Page($model->where($where)->count(), 20);
}

/**
 * 判断权限
 *
 * @param       $rule
 * @param array $ids
 * @param       $pid
 *
 * @return bool
 */
function cando($rule, $ids = null, $pid = 0)
{
    if ($pid) {
        $state = M('Project')->field('state')->where(array('pid' => $pid, 'del' => 0))->find();
        if (empty($state)) {
            return false;
        } elseif ($state['state'] == 2 || $state['state'] == -1) {
            return false;
        }
    }
    $access = superrule($rule);
    if ($access === false) {
        return false;
    } elseif ($access === null) {
        if ($ids !== null) {
            if (!cando1($ids)) {
                return false;
            }
        }
        if (!apprule($rule, array('in', '1,2'))) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;

    }
}

function cando1($ids)
{
    if (is_administrator()) {
        return true; // 管理员允许访问任何页面
    }
    if (!in_array(UID, $ids)) {
        return false;
    } else {
        return true;
    }
}

function superrule($role)
{
    if (is_administrator()) {
        return true; // 管理员允许访问任何页面
    }
    $allow = C('ALLOW_VISIT');
    $deny = C('DENY_VISIT');
    $check = strtolower($role);
    if (!empty ($deny) && in_array_case($check, $deny)) {
        return false;
    }
    if (!empty ($allow) && in_array_case($check, $allow)) {
        return true;
    }
    return null; // 需要检测节点权限
}

function apprule($rule, $type = AuthRuleModel::RULE_URL, $mode = 'url')
{
    if (IS_ROOT) {
        return true; // 管理员允许访问任何页面
    }
    static $Auth = null;
    if (!$Auth) {
        $Auth = new \Think\Auth ();
    }
    if (!$Auth->check(MODULE_NAME . '/' . $rule, UID, $type, $mode)) {
        return false;
    }
    return true;
}
