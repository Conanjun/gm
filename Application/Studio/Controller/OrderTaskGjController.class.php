<?php

namespace Studio\Controller;
use Think\Page;
use Common\Common\Super\Order;
/**
 * 任务管理-硅胶翻模：zlx
 *
 */
class OrderTaskGjController extends AdminController
{
	private $model;
	
	//构造函数
	public function __construct()
	{
		parent::__construct();
		$this->model = D('OrderTask');    // 订单任务
	}

    //首页
    public function index(){
        $stuid = Order::get_stuid(UID);   // 工作室id
        $where = "1=1 and o.stuid = {$stuid} and t.tasktype = 'STUDIO_TASK_GJ'";

        $filter= '';

        $order_sn = empty($_GET['order_sn'])?'':trim($_GET['order_sn']);//订单编号
        if($order_sn){
            $filter .= " and o.order_sn like '%{$order_sn}%'";
        }

        $tname = empty($_GET['tname'])?'':trim($_GET['tname']);//任务名称
        if($tname){
            $filter .= " and t.tname like '%{$tname}%'";
        }

        $finishname = empty($_GET['finishname'])?'':trim($_GET['finishname']);//完成人
        if($finishname){
            $filter .= " and m.nickname like '%{$finishname}%'";
        }


        $state = empty($_GET['state'])?'':intval($_GET['state']);//任务状态
        $state == 1 and  $filter .= " and t.state = 1";
        $state == 2 and  $filter .= " and t.state = 0";

        $isurgent = empty($_GET['isurgent'])?'':trim($_GET['isurgent']);//是否加急
        $isurgent == 1 and  $filter .= " and t.isurgent = 1";
        $isurgent == 2 and  $filter .= " and t.isurgent = 0";

        if ($_GET['start_addtime']) {
            $af = gmstr2time($_GET['start_addtime']);
            $filter .= " and t.add_time>='" . $af . "'";
        }
        if ($_GET['end_addtime']) {
            $at = gmstr2time_end($_GET['end_addtime']);
            $filter .= " and t.add_time<'" . $at . "'";
        }
        if ($_GET['start_finishtime']) {
            $of = gmstr2time($_GET['start_finishtime']);
            $filter .= " and t.finishtime>='" . $of . "'";
        }
        if ($_GET['end_finishtime']) {
            $ot = gmstr2time_end($_GET['end_finishtime']);
            $filter .= " and t.finishtime<'" . $ot . "'";
        }

        // 更新排序
        if (isset ( $_GET ['sort'] ) && isset ( $_GET ['order'] )) {
            $sort = strtolower ( trim ( $_GET ['sort'] ) );
            $order = strtolower ( trim ( $_GET ['order'] ) );
            $sort1 = 't.addtime';
            if (! in_array ( $order, array (
                'asc',
                'desc'
            ) )) {
                $sort = 't.isurgent';
                $order = 'desc';
                $sort1 = 't.addtime';
            }
        } else {
            $sort = 't.isurgent';
            $order = 'desc';
            $sort1 = 't.addtime';
        }

        $where .= $filter;
        $count = $this->model->alias('t')->join("ot_order o on t.oid = o.order_id")->join("ot_member m on m.uid = t.finishuid","left")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $lists = $this->model
            ->alias('t')
            ->field('t.*,t.state as task_state,t.addtime as task_addtime,t.finishtime as task_finishtime,t.finishuid as task_finishuid,t.isurgent as task_isurgent,o.*,m.nickname as task_finishman')
            ->join("ot_order o on t.oid = o.order_id")
            ->join("ot_member m on m.uid = t.finishuid","left")
            ->where($where)
            ->order ( "$sort $order ,$sort1 $order" )
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        foreach ($lists as $key=>$list){
            $lists[$key]['str_state'] = L(Order::$orderState[$list['state']]);
        }

        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $this->assign('lists', $lists);


        $this->assign('_page', $page->show());
        $this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
        $this->display();
    }

    //接受任务
    public function confirm(){
        $order_id = empty($_POST['id']) ? '' : trim($_POST['id']);
        $task_id = empty($_POST['task_id']) ? '' : trim($_POST['task_id']);
        $time = time();
        if (IS_POST) {
            $finishnote = empty($_POST['finishnote']) ? '' : trim($_POST['finishnote']);
            if(Order::checkorder($order_id)==0){
                $this->error(L('S_TASK_ERROR_1'));
            }
            $order = M("order")->where("order_id=".$order_id)->find();
            if($order['state'] < Order::ALREADY){
                $this->error(L('S_TASK_GJ_ERROR_1'));
            }

            //是否是种植业务
            if ($order['servicetype'] != 10) {
                $this->error(L('S_TASK_ERROR_4'));
            }
            //口内模型是否是实物
            $order_ext = M('Order_ext1')->where("oid=".$order_id)->find();
            if (empty($order_ext)) {
                $this->error(L('S_TASK_ERROR_6'));
            }
            if ($order_ext['mmodel'] != 'silica_gel') {
                $this->error(L('S_TASK_ERROR_5'));
            }

            $Model = M(); // 实例化一个空对象
            $Model->startTrans(); // 开启事务

            //修改完成人和说明
            $res_data = array(
                'tastkid'=>$task_id,
                'finishnote'=>$finishnote,
                'finishtime'=>$time,
                'finishuid'=>UID,
                'state'=>1,
            );
            $res = M('Order_task')->save($res_data);

            //生成石膏数字化任务
            $tname = sprintf(L('S_TASK_TASK_PROMPT_12'),$order['order_sn']);
            $tid = Order::add_task(array('oid' => $order_id, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_SG', 'isurgent'=>$order['isurgent'], 'uid' => '' ,'note'=>$tname));

            //给客户发消息
            $title = sprintf(L('S_TASK_TASK_PROMPT_1'),$order['order_sn']);
            $content = sprintf(L('S_TASK_TASK_PROMPT_5'),$order['stuname'],$order['order_sn'],L('ALREADY'));
            $msg_id = Order::action_msg_log(array('fromid' => '', 'toid' =>$order['uid'], 'addtime' => $time,'title' => $title,'content' => $content, 'outtype' => 'client_order' ,'outkey'=>$order_id));
            //写入订单操作记录
            $log_id= Order::action_order_log(array('oid' => $order_id, 'uid' =>$order['uid'], 'addtime' => $time, 'state' => Order::ALREADY ,'note'=>$finishnote));

            //写入订单操作记录，修改订单状态 设计资料已接收
            if($msg_id&&$tid&&$log_id&&$res){
                $Model->commit(); // 成功则提交事务
                $this->success(L('S_TASK_GJ_SUC'), U('index'));
            }else{
                $Model->rollback(); // 否则将事务回滚
                $this->error(L('S_TASK_GJ_ERROR'));
            }
        }
    }

}
