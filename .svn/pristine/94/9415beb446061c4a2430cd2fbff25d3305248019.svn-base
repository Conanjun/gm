<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 日志控制器
 *
 * @author huajie <banhuajie@163.com>
 */
class LogController extends AdminController
{
    public function index()
    {
        //$map ['uid'] = UID;
        if (I('sort', '') && I('order', '')) {
            $order = I("sort") . " " . I("order");
        } else {
            $order = 'logid desc';
        }

        $count = D('log')
            ->field('l.*,a.name as action_name,l.outtype as outtype_name')
            ->alias('l')
            ->join('ot_action_name a on l.action = a.code', 'LEFT')
            ->join('ot_table_name t on l.outtype = t.code', 'LEFT')
            ->where($map)->count();

        $page = new \Think\Page ($count,20);

        $list = D('log')
            ->field('l.*,a.name as action_name,l.outtype as outtype_name')
            ->alias('l')
            ->join('ot_action_name a on l.action = a.code', 'LEFT')
            ->join('ot_table_name t on l.outtype = t.code', 'LEFT')
            ->where($map)->order($order)
            ->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign('_list', $list);
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $this->assign('_page', $page->show());
        $root_mbx = array();
        $root_mbx[] = array('title' => '管理', 'url' => U('Action/index'));
        $root_mbx[] = array('title' => '日志', 'url' => '');
        $this->assign('root_mbx', $root_mbx);
        $this->meta_title = '动态';
        $this->assign('uid', UID);
        $this->display();
    }

    public function view()
    {
        $logid = I('id');
        $log = M("Log")->field(array('l.*', 'a.name as act_name'))->alias("l")->join('ot_action_name a on l.action = a.code', 'LEFT')->where("l.logid='{$logid}'")->find();
        $hs = M("History")->where("logid='{$logid}'")->select();
        $olddata = [];
        $newdata = [];
        if ($hs) {
            foreach ($hs as $kk => $vv) {
                switch ($vv['field']) {
                    case "projectname":
                        $hs[$kk]['fname'] = "项目名称";
                        break;
                    case "contacts":
                        $hs[$kk]['fname'] = "联系人";
                        break;
                    case "cid":
                        $hs[$kk]['fname'] = "客户";

                        $oldtemp = M("Customer")->where("cid='{$vv['olddata']}'")->find();
                        if ($oldtemp) {
                            $olddata = $oldtemp['name'];
                        }
                        if ($olddata) {
                            $hs[$kk]['olddata'] = $olddata;
                        }

                        $newtemp = M("Customer")->where("cid='{$vv['newdata']}'")->find();
                        if ($newtemp) {
                            $newdata = $newtemp['name'];
                        }
                        if ($newdata) {
                            $hs[$kk]['newdata'] = $newdata;
                        }

                        break;
                    case "pm":
                        $hs[$kk]['fname'] = "项目经理";

                        $oldtemp = M("Member")->where("uid='{$vv['olddata']}'")->find();
                        if ($oldtemp) {
                            $olddata = $oldtemp['nickname'];
                        }
                        if ($olddata) {
                            $hs[$kk]['olddata'] = $olddata;
                        }

                        $newtemp = M("Member")->where("uid='{$vv['newdata']}'")->find();
                        if ($newtemp) {
                            $newdata = $newtemp['nickname'];
                        }
                        if ($newdata) {
                            $hs[$kk]['newdata'] = $newdata;
                        }

                        break;
                    case "telno":
                        $hs[$kk]['fname'] = "联系电话";
                        break;
                    case "chance":
                        $hs[$kk]['fname'] = "销售机会";
                        break;
                    case "type":
                        $hs[$kk]['fname'] = "业务类型";
                        break;
                    case "signtime":
                        $hs[$kk]['fname'] = "预计签约时间";

                        $hs[$kk]['olddata'] = date('Y/m/d H:i', $hs[$kk]['olddata']);
                        $hs[$kk]['newdata'] = date('Y/m/d H:i', $hs[$kk]['newdata']);
                        break;
                    case "starttime":
                        $hs[$kk]['fname'] = "预计开始时间";

                        $hs[$kk]['olddata'] = date('Y/m/d H:i', $hs[$kk]['olddata']);
                        $hs[$kk]['newdata'] = date('Y/m/d H:i', $hs[$kk]['newdata']);
                        break;
                    case "ownner":
                        $hs[$kk]['fname'] = "所有人";
                        break;
                    case "coreservice":
                        $hs[$kk]['fname'] = "核心服务";
                        break;
                    case "oamount":
                        $hs[$kk]['fname'] = "原始金额";
                        break;
                    case "discount":
                        $hs[$kk]['fname'] = "优惠金额";
                        break;
                    case "amount":
                        $hs[$kk]['fname'] = "最终金额";
                        break;
                    case "amount_notax":
                        $hs[$kk]['fname'] = "税后金额";
                        break;
                    case "rate":
                        $hs[$kk]['fname'] = "税率";
                        $hs[$kk]['olddata'] = $hs[$kk]['olddata'] . "%";
                        $hs[$kk]['newdata'] = $hs[$kk]['newdata'] . "%";
                        break;
                    case "disoff":
                        $hs[$kk]['fname'] = "折扣";

                        $oldtemp = M("Disdefine")->where("dis='{$vv['olddata']}'")->find();
                        if ($oldtemp) {
                            $olddata = $oldtemp['name'];
                        }
                        if ($olddata) {
                            $hs[$kk]['olddata'] = $olddata;
                        }

                        $newtemp = M("Disdefine")->where("dis='{$vv['newdata']}'")->find();
                        if ($newtemp) {
                            $newdata = $newtemp['name'];
                        }
                        if ($newdata) {
                            $hs[$kk]['newdata'] = $newdata;
                        }

                        break;
                    case "step":
                        $hs[$kk]['fname'] = "销售阶段";
                        break;
                    case "possible":
                        $hs[$kk]['fname'] = "可能性";
                        $hs[$kk]['olddata'] = $hs[$kk]['olddata'] . "%";
                        $hs[$kk]['newdata'] = $hs[$kk]['newdata'] . "%";
                        break;
                    case "datafrom":
                        $hs[$kk]['fname'] = "数据来源";
                        if ($vv['olddata'] == 0) {
                            $hs[$kk]['olddata'] = "标准库引入";
                        } else if ($vv['olddata'] == 1) {
                            $hs[$kk]['olddata'] = "手动填写";
                        }
                        break;
                    default:
                        $hs[$kk]['fname'] = $vv['field'];
                }
            }
        }

        $this->assign('log', $log);
        $this->assign('hs', $hs);
        $this->display();
    }
}
