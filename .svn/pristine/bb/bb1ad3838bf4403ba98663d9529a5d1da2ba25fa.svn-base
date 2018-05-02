<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Dentist\Controller;

use Think\Controller;
use Dentist\Model\AuthRuleModel;
use Dentist\Model\AuthGroupModel;

/**
 * 后台首页控制器
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class AdminController extends Controller
{
    /**
     * 后台控制器初始化
     */
    protected function _initialize()
    {
        // 获取当前用户ID
        define('UID', is_login());
        if (!UID) { // 还没登录 跳转到登录页面
            $r = str_replace('/', '%', $_SERVER['REQUEST_URI']);
            $this->redirect('Public/login', array('r' => $r));
        }
        /* 读取数据库中的配置 */
        $config = S('DB_CONFIG_DATA');
        if (!$config) {
            $config = api('Config/lists');
            S('DB_CONFIG_DATA', $config);
        }
        C($config); // 添加配置

        // 是否是超级管理员
        define('IS_ROOT', is_administrator());
        if (!IS_ROOT && C('ADMIN_ALLOW_IP')) {
            // 检查IP地址访问
            if (!in_array(get_client_ip(), explode(',', C('ADMIN_ALLOW_IP')))) {
                $this->notAuth('403:禁止访问');
            }
        }

        // 检测访问权限
        $access = $this->accessControl();

        if ($access === false) {
            $this->notAuth('403:禁止访问');
        } elseif ($access === null) {
            $dynamic = $this->checkDynamic(); // 检测分类栏目有关的各项动态权限

            if ($dynamic === null) {
                // 检测非动态权限
                $rule = strtolower(MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME);

                if (!$this->checkRule($rule, array(
                    'in',
                    '1,2'
                ))) {
                    $this->notAuth('未授权访问!');
                }
            } elseif ($dynamic === false) {
                $this->notAuth('未授权访问!');
            }
        }

        $this->assign('pageshowcount', I("pageshowcount", 20));

        $menu=$this->getMenus();
        
        
        $uid = UID;
        //工作室消息
        $count = M('Message')->where('isread=0 and toid='.$uid)->count();
        $msg_list = M('Message') ->alias('me')->join('left join ot_member m on m.uid = me.fromid')->field('me.* ,m.nickname')->where("me.isread=0 and me.toid=".$uid)
        ->order('me.msg_id desc')->limit(3)->select();
        $this->assign('count',  $count);
        $this->assign('list_s',  $msg_list);
        
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
        $url=str_replace('&lang=zh', $replace, $url);
        $url=str_replace('&lang=en', $replace, $url);
        $this->assign('_url_',$url);
        $this->assign('__MENU__',$menu);
    }

    /**
     * 权限检测
     *
     * @param        $rule       检测的规则
     * @param int    $type
     * @param string $mode       check模式
     *
     * @return bool
     */
    final protected function checkRule($rule, $type = AuthRuleModel::RULE_URL, $mode = 'url')
    {
        if (IS_ROOT) {
            return true; // 管理员允许访问任何页面
        }
        static $Auth = null;
        if (!$Auth) {
            $Auth = new \Think\Auth ();
        }
        if (!$Auth->check($rule, UID, $type, $mode)) {
            return false;
        }
        return true;
    }

    /**
     * 检测是否是需要动态判断的权限
     *
     * @return boolean|null 返回true则表示当前访问有权限
     *         返回false则表示当前访问无权限
     *         返回null，则会进入checkRule根据节点授权判断权限
     *
     * @author 朱亚杰 <xcoolcc@gmail.com>
     */
    protected function checkDynamic()
    {
        if (IS_ROOT) {
            return true; // 管理员允许访问任何页面
        }
        return null; // 不明,需checkRule
    }

    /**
     * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
     *
     * @return boolean|null 返回值必须使用 `===` 进行判断
     *
     *         返回 **false**, 不允许任何人访问(超管除外)
     *         返回 **true**, 允许任何管理员访问,无需执行节点权限检测
     *         返回 **null**, 需要继续执行节点权限检测决定是否允许访问
     * @author 朱亚杰 <xcoolcc@gmail.com>
     */
    final protected function accessControl()
    {
        if (IS_ROOT) {
            return true; // 管理员允许访问任何页面
        }
        $allow = C('ALLOW_VISIT');
        $deny = C('DENY_VISIT');
        $check = strtolower(MODULE_NAME . '/' .CONTROLLER_NAME . '/' . ACTION_NAME);
        if (!empty ($deny) && in_array_case($check, $deny)) {
            return false; // 非超管禁止访问deny中的方法
        }
        if (!empty ($allow) && in_array_case($check, $allow)) {
            return true;
        }
        return null; // 需要检测节点权限
    }

    /**
     * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
     *
     * @param string $model
     *            模型名称,供M函数使用的参数
     * @param array  $data
     *            修改的数据
     * @param array  $where
     *            查询时的where()方法的参数
     * @param array  $msg
     *            执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *            url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    final protected function editRow($model, $data, $where, $msg)
    {
        $id = array_unique(( array )I('id', 0));
        $id = is_array($id) ? implode(',', $id) : $id;
        $where = array_merge(array(
            'id' => array(
                'in',
                $id
            )
        ), ( array )$where);
        $msg = array_merge(array(
            'success' => '操作成功！',
            'error' => '操作失败！',
            'url' => '',
            'ajax' => IS_AJAX
        ), ( array )$msg);
        if (M($model)->where($where)->save($data) !== false) {
            $this->success($msg ['success'], $msg ['url'], $msg ['ajax']);
        } else {
            $this->error($msg ['error'], $msg ['url'], $msg ['ajax']);
        }
    }

    protected function setSearchConfig($config = array())
    {
        $this->assign('fieldParams1', $config ['params'] ? json_encode($config ['params']) : "{}");

        if (is_array($config) && count($config) > 0) {

            $config['params1'] = $config['params'];
            if (is_array($config['params']) && count($config['params']) > 0) {

                $field1 = I("field1", "");
                $operator1 = I("operator1", "");
                $value1 = I("value1", "");
                $date_value1 = I("date_value1", "");


                $field2 = I("field2", "");
                $operator2 = I("operator2", "");
                $value2 = I("value2", "");
                $date_value2 = I("date_value2", "");


                $field3 = I("field3", "");
                $operator3 = I("operator3", "");
                $value3 = I("value3", "");
                $date_value3 = I("date_value3", "");


                $field4 = I("field4", "");
                $operator4 = I("operator4", "");
                $value4 = I("value4", "");
                $date_value4 = I("date_value4", "");


                $field5 = I("field5", "");
                $operator5 = I("operator5", "");
                $value5 = I("value5", "");
                $date_value5 = I("date_value5", "");


                $field6 = I("field6", "");
                $operator6 = I("operator6", "");
                $value6 = I("value6", "");
                $date_value6 = I("date_value6", "");


                $temp = array();
                foreach ($config['params'] as $k => $v) {
                    if ($v ["fieldname"] == $field1) {
                        if ($v ['control'] == "input") {
                            if ($value1 == '') {
                                $v ['values'] = $date_value1;
                            } else {
                                $v ['values'] = $value1;
                            }
                        }
                        $v ['operator'] = $operator1;
                        $temp [0] = $v;
                    }
                    if ($v ["fieldname"] == $field2) {
                        if ($v ['control'] == "input") {
                            if ($value2 == '') {
                                $v ['values'] = $date_value2;
                            } else {
                                $v ['values'] = $value2;
                            }
                        }
                        $v ['operator'] = $operator2;
                        $temp [1] = $v;
                    }
                    if ($v ["fieldname"] == $field3) {
                        if ($v ['control'] == "input") {
                            if ($value3 == '') {
                                $v ['values'] = $date_value3;
                            } else {
                                $v ['values'] = $value3;
                            }
                        }
                        $v ['operator'] = $operator3;
                        $temp [2] = $v;
                    }
                    if ($v ["fieldname"] == $field4) {
                        if ($v ['control'] == "input") {
                            if ($value4 == '') {
                                $v ['values'] = $date_value4;
                            } else {
                                $v ['values'] = $value4;
                            }
                        }
                        $v ['operator'] = $operator4;
                        $temp [3] = $v;
                    }
                    if ($v ["fieldname"] == $field5) {
                        if ($v ['control'] == "input") {
                            if ($value5 == '') {
                                $v ['values'] = $date_value5;
                            } else {
                                $v ['values'] = $value5;
                            }
                        }
                        $v ['operator'] = $operator5;
                        $temp [4] = $v;
                    }
                    if ($v ["fieldname"] == $field6) {
                        if ($v ['control'] == "input") {
                            if ($value6 == '') {
                                $v ['values'] = $date_value6;
                            } else {
                                $v ['values'] = $value6;
                            }
                        }
                        $v ['operator'] = $operator6;
                        $temp [5] = $v;
                    }
                }
                if ($temp) {
                    foreach ($temp as $k => $v) {
                        if ($v) {
                            $v['fieldname'] = $config['params'][$k]['fieldname'];
                            $v['str'] = $config['params'][$k]['str'];
                            $config['params'][$k] = $v;
                        }
                    }
                }
            }
            $this->assign('groupItems', 3);
            $this->assign('actionURL', $config ['actionURL']);
            $this->assign('fieldParams', $config);
            $allc = 0;
            if ($config && $config ['params'] && count($config ['params'] > 0)) {
                $allc = count($config ['params']);
            } else {
                $this->assign('allc', 0);
            }

            $this->assign('allc', $allc);
        } else {
            $this->assign('allc', 0);
        }
    }

    protected function getCondition()
    {
        $condition = array();

        $groupAndOr = I("groupAndOr", "AND");

        $field1 = I("field1", "");
        $operator1 = I("operator1", "");
        $value1 = I("value1", "");
        $date_value1 = I("date_value1", "");
        $andOr1 = I("andOr1", "and");

        $field2 = I("field2", "");
        $operator2 = I("operator2", "");
        $value2 = I("value2", "");
        $date_value2 = I("date_value2", "");
        $andOr2 = I("andOr2", "and");

        $field3 = I("field3", "");
        $operator3 = I("operator3", "");
        $value3 = I("value3", "");
        $date_value3 = I("date_value3", "");
        $andOr3 = I("andOr3", "and");

        $field4 = I("field4", "");
        $operator4 = I("operator4", "");
        $value4 = I("value4", "");
        $date_value4 = I("date_value4", "");
        $andOr4 = I("andOr4", "and");

        $field5 = I("field5", "");
        $operator5 = I("operator5", "");
        $value5 = I("value5", "");
        $date_value5 = I("date_value5", "");
        $andOr5 = I("andOr5", "and");

        $field6 = I("field6", "");
        $operator6 = I("operator6", "");
        $value6 = I("value6", "");
        $date_value6 = I("date_value6", "");
        $andOr6 = I("andOr6", "and");


        $this->assign('field6', $field6);
        $this->assign('field5', $field5);
        $this->assign('field4', $field4);
        $this->assign('field3', $field3);
        $this->assign('field2', $field2);
        $this->assign('field1', $field1);

        $this->assign('value6', $value6);
        $this->assign('value5', $value5);
        $this->assign('value4', $value4);
        $this->assign('value3', $value3);
        $this->assign('value2', $value2);
        $this->assign('value1', $value1);

        $this->assign('andOr6', $andOr6);
        $this->assign('andOr5', $andOr6);
        $this->assign('andOr4', $andOr4);
        $this->assign('andOr3', $andOr3);
        $this->assign('andOr2', $andOr2);
        $this->assign('andOr1', $andOr1);
        $this->assign('groupAndOr', $groupAndOr);
        //

        if (($value1 != '' || $date_value1 != '') && $operator1 && $field1) {
            if ($date_value1 != '') {
                $value1 = strtotime($date_value1);
                switch ($operator1) {
                    case "=" :
                        $c1 = " $field1='{$value1}' ";
                        break;
                    case "!=" :
                        $c1 = " $field1<>'{$value1}' ";
                        break;
                    case "<" :
                        $c1 = " $field1<'{$value1}' ";
                        break;
                    case "<=" :
                        $c1 = " $field1<='{$value1}' ";
                        break;
                    case ">" :
                        $c1 = " $field1>'{$value1}' ";
                        break;
                    case ">=" :
                        $c1 = " $field1>='{$value1}' ";
                        break;
                    case "include" :
                        $c1 = " $field1 like '%{$value1}%' ";
                        break;
                }
            } else {
                switch ($operator1) {
                    case "=" :
                        $c1 = " $field1='{$value1}' ";
                        break;
                    case "!=" :
                        $c1 = " $field1<>'{$value1}' ";
                        break;
                    case "<" :
                        $c1 = " $field1<'{$value1}' ";
                        break;
                    case "<=" :
                        $c1 = " $field1<='{$value1}' ";
                        break;
                    case ">" :
                        $c1 = " $field1>'{$value1}' ";
                        break;
                    case ">=" :
                        $c1 = " $field1>='{$value1}' ";
                        break;
                    case "include" :
                        $c1 = " $field1 like '%{$value1}%' ";
                        break;
                }
            }

        } else {
            $c1 = " 1=1 ";
        }

        if (($value2 != '' || $date_value2 != '') && $operator2 && $field2) {
            if ($date_value2 != '') {
                $value2 = strtotime($date_value2);
                switch ($operator2) {
                    case "=" :
                        $c2 = " $andOr2 $field2='{$value2}' ";
                        break;
                    case "!=" :
                        $c2 = " $andOr2 $field2<>'{$value2}' ";
                        break;
                    case "<" :
                        $c2 = " $andOr2 $field2<'{$value2}' ";
                        break;
                    case "<=" :
                        $c2 = " $andOr2 $field2<='{$value2}' ";
                        break;
                    case ">" :
                        $c2 = " $andOr2 $field2>'{$value2}' ";
                        break;
                    case ">=" :
                        $c2 = " $andOr2 $field2>='{$value2}' ";
                        break;
                    case "include" :
                        $c2 = " $andOr2 $field2 like '%{$value2}%' ";
                        break;
                }
            } else {
                switch ($operator2) {
                    case "=" :
                        $c2 = " $andOr2 $field2='{$value2}' ";
                        break;
                    case "!=" :
                        $c2 = " $andOr2 $field2<>'{$value2}' ";
                        break;
                    case "<" :
                        $c2 = " $andOr2 $field2<'{$value2}' ";
                        break;
                    case "<=" :
                        $c2 = " $andOr2 $field2<='{$value2}' ";
                        break;
                    case ">" :
                        $c2 = " $andOr2 $field2>'{$value2}' ";
                        break;
                    case ">=" :
                        $c2 = " $andOr2 $field2>='{$value2}' ";
                        break;
                    case "include" :
                        $c2 = " $andOr2 $field2 like '%{$value2}%' ";
                        break;
                }
            }
        } else {
            $c2 = "";
        }

        if (($value3 != '' || $date_value3 != '') && $operator3 && $field3) {
            if ($date_value3 != '') {
                $value3 = strtotime($date_value3);
                switch ($operator3) {
                    case "=" :
                        $c3 = " $andOr3 $field3='{$value3}' ";
                        break;
                    case "!=" :
                        $c3 = " $andOr3 $field3<>'{$value3}' ";
                        break;
                    case "<" :
                        $c3 = " $andOr3 $field3<'{$value3}' ";
                        break;
                    case "<=" :
                        $c3 = " $andOr3 $field3<='{$value3}' ";
                        break;
                    case ">" :
                        $c3 = " $andOr3 $field3>'{$value3}' ";
                        break;
                    case ">=" :
                        $c3 = " $andOr3 $field3>='{$value3}' ";
                        break;
                    case "include" :
                        $c3 = " $andOr3 $field3 like '%{$value3}%' ";
                        break;
                }
            } else {
                switch ($operator3) {
                    case "=" :
                        $c3 = " $andOr3 $field3='{$value3}' ";
                        break;
                    case "!=" :
                        $c3 = " $andOr3 $field3<>'{$value3}' ";
                        break;
                    case "<" :
                        $c3 = " $andOr3 $field3<'{$value3}' ";
                        break;
                    case "<=" :
                        $c3 = " $andOr3 $field3<='{$value3}' ";
                        break;
                    case ">" :
                        $c3 = " $andOr3 $field3>'{$value3}' ";
                        break;
                    case ">=" :
                        $c3 = " $andOr3 $field3>='{$value3}' ";
                        break;
                    case "include" :
                        $c3 = " $andOr3 $field3 like '%{$value3}%' ";
                        break;
                }
            }

        } else {
            $c3 = "";
        }

        if (($value4 != '' || $date_value4 != '') && $operator4 && $field4) {
            if ($date_value4 != '') {
                $value4 = strtotime($date_value4);
                switch ($operator4) {
                    case "=" :
                        $c4 = " $field4='{$value4}' ";
                        break;
                    case "!=" :
                        $c4 = " $field4<>'{$value4}' ";
                        break;
                    case "<" :
                        $c4 = " $field4<'{$value4}' ";
                        break;
                    case "<=" :
                        $c4 = " $field4<='{$value4}' ";
                        break;
                    case ">" :
                        $c4 = " $field4>'{$value4}' ";
                        break;
                    case ">=" :
                        $c4 = " $field4>='{$value4}' ";
                        break;
                    case "include" :
                        $c4 = " $field4 like '%{$value4}%' ";
                        break;
                }
            } else {
                switch ($operator4) {
                    case "=" :
                        $c4 = " $field4='{$value4}' ";
                        break;
                    case "!=" :
                        $c4 = " $field4<>'{$value4}' ";
                        break;
                    case "<" :
                        $c4 = " $field4<'{$value4}' ";
                        break;
                    case "<=" :
                        $c4 = " $field4<='{$value4}' ";
                        break;
                    case ">" :
                        $c4 = " $field4>'{$value4}' ";
                        break;
                    case ">=" :
                        $c4 = " $field4>='{$value4}' ";
                        break;
                    case "include" :
                        $c4 = " $field4 like '%{$value4}%' ";
                        break;
                }
            }
        } else {
            $c4 = " 1=1 ";
        }

        if (($value5 != '' || $date_value5 != '') && $operator5 && $field5) {
            if ($date_value5 != '') {
                $value5 = strtotime($date_value5);
                switch ($operator5) {
                    case "=" :
                        $c5 = " $andOr5 $field5='{$value5}' ";
                        break;
                    case "!=" :
                        $c5 = " $andOr5 $field5<>'{$value5}' ";
                        break;
                    case "<" :
                        $c5 = " $andOr5 $field5<'{$value5}' ";
                        break;
                    case "<=" :
                        $c5 = " $andOr5 $field5<='{$value5}' ";
                        break;
                    case ">" :
                        $c5 = " $andOr5 $field5>'{$value5}' ";
                        break;
                    case ">=" :
                        $c5 = " $andOr5 $field5>='{$value5}' ";
                        break;
                    case "include" :
                        $c5 = " $andOr5 $field5 like '%{$value5}%' ";
                        break;
                }
            } else {
                switch ($operator5) {
                    case "=" :
                        $c5 = " $andOr5 $field5='{$value5}' ";
                        break;
                    case "!=" :
                        $c5 = " $andOr5 $field5<>'{$value5}' ";
                        break;
                    case "<" :
                        $c5 = " $andOr5 $field5<'{$value5}' ";
                        break;
                    case "<=" :
                        $c5 = " $andOr5 $field5<='{$value5}' ";
                        break;
                    case ">" :
                        $c5 = " $andOr5 $field5>'{$value5}' ";
                        break;
                    case ">=" :
                        $c5 = " $andOr5 $field5>='{$value5}' ";
                        break;
                    case "include" :
                        $c5 = " $andOr5 $field5 like '%{$value5}%' ";
                        break;
                }
            }

        } else {
            $c5 = "";
        }

        if (($value6 != '' || $date_value6 != '') && $operator6 && $field6) {
            if ($date_value6 != '') {
                $value6 = strtotime($date_value6);
                switch ($operator6) {
                    case "=" :
                        $c6 = " $andOr6 $field6='{$value6}' ";
                        break;
                    case "!=" :
                        $c6 = " $andOr6 $field6<>'{$value6}' ";
                        break;
                    case "<" :
                        $c6 = " $andOr6 $field6<'{$value6}' ";
                        break;
                    case "<=" :
                        $c6 = " $andOr6 $field6<='{$value6}' ";
                        break;
                    case ">" :
                        $c6 = " $andOr6 $field6>'{$value6}' ";
                        break;
                    case ">=" :
                        $c6 = " $andOr6 $field6>='{$value6}' ";
                        break;
                    case "include" :
                        $c6 = " $andOr6 $field6 like '%{$value6}%' ";
                        break;
                }
            } else {
                switch ($operator6) {
                    case "=" :
                        $c6 = " $andOr6 $field6='{$value6}' ";
                        break;
                    case "!=" :
                        $c6 = " $andOr6 $field6<>'{$value6}' ";
                        break;
                    case "<" :
                        $c6 = " $andOr6 $field6<'{$value6}' ";
                        break;
                    case "<=" :
                        $c6 = " $andOr6 $field6<='{$value6}' ";
                        break;
                    case ">" :
                        $c6 = " $andOr6 $field6>'{$value6}' ";
                        break;
                    case ">=" :
                        $c6 = " $andOr6 $field6>='{$value6}' ";
                        break;
                    case "include" :
                        $c6 = " $andOr6 $field6 like '%{$value6}%' ";
                        break;
                }
            }

        } else {
            $c6 = "";
        }
        $condition ['_string'] = "(($c1 $c2 $c3) $groupAndOr ($c4 $c5 $c6))";
        // 或的时候不要非空条件
        if ($groupAndOr == "or" && $c4 == " 1=1 " && !$c5 && !$c6) $condition['_string'] = "(($c1 $c2 $c3))";


        return $condition;
    }

    /**
     * 禁用条目
     *
     * @param string $model
     *            模型名称,供D函数使用的参数
     * @param array  $where
     *            查询时的 where()方法的参数
     * @param array  $msg
     *            执行正确和错误的消息,可以设置四个元素 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *            url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    protected function forbid($model, $where = array(), $msg = array('success' => '状态禁用成功！', 'error' => '状态禁用失败！'))
    {
        $data = array(
            'status' => 0
        );
        $this->editRow($model, $data, $where, $msg);
    }

    /**
     * 恢复条目
     *
     * @param string $model
     *            模型名称,供D函数使用的参数
     * @param array  $where
     *            查询时的where()方法的参数
     * @param array  $msg
     *            执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *            url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    protected function resume($model, $where = array(), $msg = array('success' => '状态恢复成功！', 'error' => '状态恢复失败！'))
    {
        $data = array(
            'status' => 1
        );
        $this->editRow($model, $data, $where, $msg);
    }

    /*
     * 禁用
     * fhc
     */
    protected function s_forbid($model, $where = array(), $msg = array('success' => '状态禁用成功！', 'error' => '状态禁用失败！'))
    {
        $data = array(
            'enabled' => 0
        );
        $this->editRow($model, $data, $where, $msg);
    }

    /**
     * 启用
     *
     * @param       $model
     * @param array $where
     * @param array $msg
     */
    protected function s_resume($model, $where = array(), $msg = array('success' => '状态启用成功！', 'error' => '状态恢复失败！'))
    {
        $data = array(
            'enabled' => 1
        );
        $this->editRow($model, $data, $where, $msg);
    }

    /**
     * 还原条目
     *
     * @param string $model
     *            模型名称,供D函数使用的参数
     * @param array  $where
     *            查询时的where()方法的参数
     * @param array  $msg
     *            执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *            url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     *
     * @author huajie <banhuajie@163.com>
     */
    protected function restore($model, $where = array(), $msg = array('success' => '状态还原成功！', 'error' => '状态还原失败！'))
    {
        $data = array(
            'status' => 1
        );
        $where = array_merge(array(
            'status' => -1
        ), $where);
        $this->editRow($model, $data, $where, $msg);
    }

    /**
     * 条目假删除
     *
     * @param string $model
     *            模型名称,供D函数使用的参数
     * @param array  $where
     *            查询时的where()方法的参数
     * @param array  $msg
     *            执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *            url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    protected function delete($model, $where = array(), $msg = array('success' => '删除成功！', 'error' => '删除失败！'))
    {
        $data ['status'] = -1;
        $data ['update_time'] = NOW_TIME;
        $this->editRow($model, $data, $where, $msg);
    }

    /**
     * 设置一条或者多条数据的状态
     *
     * @param string $Model
     */
    public function setStatus($Model = CONTROLLER_NAME)
    {
        $ids = I('request.ids');
        $status = I('request.status');
        if (empty ($ids)) {
            $this->error('请选择要操作的数据');
        }

        $map ['id'] = array(
            'in',
            $ids
        );
        switch ($status) {
            case -1 :
                $this->delete($Model, $map, array(
                    'success' => '删除成功',
                    'error' => '删除失败'
                ));
                break;
            case 0 :
                $this->forbid($Model, $map, array(
                    'success' => '禁用成功',
                    'error' => '禁用失败'
                ));
                break;
            case 1 :
                $this->resume($Model, $map, array(
                    'success' => '启用成功',
                    'error' => '启用失败'
                ));
                break;
            default :
                $this->error('参数错误');
                break;
        }
    }

    /**
     * 获取控制器菜单数组,二级菜单元素位于一级菜单的'_child'元素中
     *
     * @param string $controller
     *
     * @return mixed
     */
    final public function getMenus($controller = CONTROLLER_NAME)
    {
        // $menus = session('ADMIN_MENU_LIST'.$controller);
        if (empty ($menus)) {
            // 获取主菜单
            $where ['pid'] = 0;
            $where ['hide'] = 0;
            if (!C('DEVELOP_MODE')) { // 是否开发者模式
                $where ['is_dev'] = 0;
            }
            $where['module'] = MODULE_NAME;
            $menus ['main'] = M('Menu')->where($where)->order('sort asc')->select();
            // 高亮主菜单
            foreach ($menus ['main'] as $key => $item) {
                if (!is_array($item) || empty ($item ['title']) || empty ($item ['url'])) {
                    $this->error('控制器基类$menus属性元素配置有误');
                }
                if (stripos($item ['url'], MODULE_NAME) !== 0) {
                    $item ['url'] = MODULE_NAME . '/' . $item ['url'];
                }
                // 判断主菜单权限
                if (!IS_ROOT && !$this->checkRule($item ['url'], AuthRuleModel::RULE_MAIN, null)) {
                    unset ($menus ['main'] [$key]);
                    continue; // 继续循环
                }
                // 获取当前主菜单的子菜单项
                // 生成child树
                $groups = M('Menu')->where("pid = {$item['id']}")->distinct(true)->field("`module`")->select();
                if ($groups) {
                    $groups = array_column($groups, 'module');
                } else {
                    $groups = array();
                }
                
               
                // 获取二级分类的合法url
                $where = array();
                $where ['pid'] = $item ['id'];
                $where ['hide'] = 0;
                if (!C('DEVELOP_MODE')) { // 是否开发者模式
                    $where ['is_dev'] = 0;
                }
                $second_urls = M('Menu')->where($where)->getField('id,url');
                if (!IS_ROOT) {
                    // 检测菜单权限
                    $to_check_urls = array();
                    foreach ($second_urls as $to_check_url) {
                        if (stripos($to_check_url, MODULE_NAME) !== 0) {
                            $rule = MODULE_NAME . '/' . $to_check_url;
                        } else {
                            $rule = $to_check_url;
                        }
                        if ($this->checkRule($rule, AuthRuleModel::RULE_URL, null))
                            $to_check_urls [] = $to_check_url;
                    }
                }
                // 按照分组生成子菜单树
                foreach ($groups as $g) {
                    $map = array(
                        'group' => $g
                    );
                    if (isset ($to_check_urls)) {
                        if (empty ($to_check_urls)) {
                            // 没有任何权限
                            continue;
                        } else {
                            $map ['url'] = array(
                                'in',
                                $to_check_urls
                            );
                        }
                    }

                    $map ['pid'] = $item ['id'];
                    $map ['hide'] = 0;
                    $map ['module'] = MODULE_NAME;
                    if (!C('DEVELOP_MODE')) { // 是否开发者模式
                        $map ['is_dev'] = 0;
                    }
                    $menuList = M('Menu')->where($map)->field('id,pid,title,url,tip')->order('sort asc')->select();
                    if($menuList){
                        foreach ($menuList as $k=>$v){
                            $c=explode('/',$v['url']);
                            if($c){
                                if($c[0]==CONTROLLER_NAME){
                                    $menuList[$k]['a']='active';
                                }else{
                                    $menuList[$k]['a']='';
                                }
                            }else{
                                $menuList[$k]['a']='';
                            }
                        }
                    }



                    $menus['main'][$key]['child']= $menuList;

                }

            }

            // session('ADMIN_MENU_LIST'.$controller,$menus);
        }
        return $menus;
    }

    /**
     * 返回后台节点数据
     *
     * @param bool $tree 是否返回多维数组结构(生成菜单时用到),为false返回一维数组(生成权限节点时用到)
     *
     * @return array|mixed       注意,返回的主菜单节点数组中有'controller'元素,以供区分子节点和主节点
     */
    final protected function returnNodes($tree = true,$module='')
    {
        static $tree_nodes = array();
        if ($tree && !empty ($tree_nodes [( int )$tree])) {
            return $tree_nodes [$tree];
        }
        if (( int )$tree) {
            $sqlw=" 1=1";
            if($module){
                $sqlw.=" and module='".$module."'";
            }
            $list = M('Menu')->field('id,pid,title,url,tip,hide,module')->where($sqlw)->order('sort asc')->select();
            foreach ($list as $key => $value) {
                //if (stripos($value ['url'], MODULE_NAME) !== 0) {
                $list [$key] ['url'] = $value['module'] . '/' . $value ['url'];
                //}
            }
            $nodes = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = 'operator', $root = 0);
            foreach ($nodes as $key => $value) {
                if (!empty ($value ['operator'])) {
                    $nodes [$key] ['child'] = $value ['operator'];
                    unset ($nodes [$key] ['operator']);
                }
            }
        } else {
            $nodes = M('Menu')->field('title,url,tip,pid,module')->order('sort asc')->select();
            foreach ($nodes as $key => $value) {
                //if (stripos($value ['url'], MODULE_NAME) !== 0) {
                $nodes [$key] ['url'] = $value['module'] . '/' . $value ['url'];
                //}
            }
        }
        $tree_nodes [( int )$tree] = $nodes;
        return $nodes;
    }

    /**
     * 通用分页列表数据集获取方法
     *
     * 可以通过url参数传递where条件,例如: index.html?name=asdfasdfasdfddds
     * 可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     * 可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model
     *            模型名或模型实例
     * @param array        $where
     *            where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order
     *            排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *            请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *            否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param array        $base
     *            基本的查询条件
     * @param boolean      $field
     *            单表模型用不到该参数,要用在多表join时为field()方法指定参数
     *
     * @author 朱亚杰 <xcoolcc@gmail.com>
     *
     * @return array|false 返回数据集
     */
    protected function lists($model, $where = array(), $order = '', $base = array('status' => array('egt', 0)), $field = true)
    {
        $options = array();
        $REQUEST = ( array )I('request.');
        if (is_string($model)) {
            $model = M($model);
        }

        $OPT = new \ReflectionProperty ($model, 'options');
        $OPT->setAccessible(true);

        $pk = $model->getPk();
        if ($order === null) {
            // order置空
        } else if (isset ($REQUEST ['_order']) && isset ($REQUEST ['_field']) && in_array(strtolower($REQUEST ['_order']), array(
                'desc',
                'asc'
            ))) {
            $options ['order'] = '`' . $REQUEST ['_field'] . '` ' . $REQUEST ['_order'];
        } elseif ($order === '' && empty ($options ['order']) && !empty ($pk)) {
            $options ['order'] = $pk . ' desc';
        } elseif ($order) {
            $options ['order'] = $order;
        }
        unset ($REQUEST ['_order'], $REQUEST ['_field']);

        $options ['where'] = array_filter(array_merge(( array )$base, /*$REQUEST,*/
            ( array )$where), function ($val) {
            if ($val === '' || $val === null) {
                return false;
            } else {
                return true;
            }
        });
        if (empty ($options ['where'])) {
            unset ($options ['where']);
        }
        $options = array_merge(( array )$OPT->getValue($model), $options);
        $total = $model->where($options ['where'])->count();

        if (isset ($REQUEST ['r'])) {
            $listRows = ( int )$REQUEST ['r'];
        } else {
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 20;
        }
        $page = new \Think\Page ($total, $listRows, $REQUEST);
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p = $page->show();
        $this->assign('_page', $p ? $p : '');
        $this->assign('_total', $total);
        $options ['limit'] = $page->firstRow . ',' . $page->listRows;

        $model->setProperty('options', $options);

        return $model->field($field)->select();
    }

    //判断项目是否可以执行
    public function project_out($pid, $if_ajax)
    {
        if (empty($pid)) return false;
        $state = M('Project')->field('state')->where(array('pid' => $pid, 'del' => 0))->find();
        if (empty($state)) {
            if ($if_ajax) {
                $this->json_error('项目不存在，操作失败！', false);
            } else {
                $this->error('项目不存在，操作失败！');
            }
        } elseif ($state['state'] == 2 || $state == -1) {
            if ($if_ajax) {
                $this->json_error('项目已完成或已关闭，操作失败！', false);
            } else {
                $this->error('项目已完成或已关闭，操作失败！');
            }
        }
    }
}
