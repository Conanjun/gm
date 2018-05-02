<?php

namespace Studio\Controller;
use Think\Page;
use Common\Common\Super\Order;
/**
 * 任务管理-财务确认：fhc
 *
 */
class OrderTaskCwController extends AdminController
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
        $stuid = Order::get_stuid(UID);    // 工作室id
        $where = "1=1 and t.tasktype = 'STUDIO_TASK_CW' and o.stuid = {$stuid}";

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

        $state = empty($_GET['state'])?'':intval($_GET['state']);//任务状态
        $state == 1 and  $filter .= " and t.state = 1";
        $state == 2 and  $filter .= " and t.state = 0";

        $isurgent = empty($_GET['isurgent'])?'':trim($_GET['isurgent']);//是否加急
        $isurgent == 1 and  $filter .= " and t.isurgent = 1";
        $isurgent == 2 and  $filter .= " and t.isurgent = 0";
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
            $sort1 = 't.addtime';
            $order = 'desc';
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
            $user_state = Order::get_dent_paytype($list['order_id']);
            $lists[$key]['prompt'] = 0;
            if($user_state==0){
                $num = M('OrderPay')->where('oid='.$list['order_id'].' and state=0')->count();
                if($num>0){
                    $lists[$key]['prompt']=1;
                }
            }
        }
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $this->assign('lists', $lists);
        $this->assign('_page', $page->show());
        $this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
        $this->display();
	}

	//财务明细
	public function feepay(){
        $tid = empty($_GET['tid'])?0:$_GET['tid'];
        if(empty($tid)){
            $this->error(L('TASK_ERROR_EMPTY'));
        }
        $task = M("OrderTask")->where('tastkid='.$tid)->find();
        if(empty($task)){
            $this->error(L('TASK_ERROR_EMPTY'));
        }
        $oid = $task['oid'];
        if(Order::checkorder($oid)==0){
            $this->error(L('S_TASK_ERROR_1'));
        }
        $order = M("order")->where("order_id=".$oid)->find();
        if($order['state']!=Order::CONFIRMED){
            $this->error(L('S_TASK_CW_ERROR_2'));
        }
        $pays = M("order_pay")->where("oid=".$oid)->select();
        $this->assign("pays",$pays);
        $m = M("order_pay")->where("oid=".$oid)->sum('money');
        $m1 = M("order_pay")->where("oid=".$oid)->sum('money1');
        $this->assign("money",$m);
        $this->assign("money1",$m1);
        $user_state = Order::get_dent_paytype($oid);
        $this->assign("user_state",$user_state);
        $this->assign("tid",$tid);
        $fees = M('Feeitem')->select();
        $this->assign("fees",$fees);
        $this->display();
    }

    //财务确认
	public function confirm(){
        if(IS_POST){//确认处理
            $tid = empty($_POST['tid'])?0:$_POST['tid'];
            $old_m = empty($_POST['m'])?0:round($_POST['m'],2);
            $old_m1 = empty($_POST['m1'])?0:round($_POST['m1'],2);
            $note = empty($_POST['finishnote'])?'':trim($_POST['finishnote']);
            if(empty($tid)){
                $this->error ( L('TASK_ERROR_EMPTY'));
            }
            $task = M("OrderTask")->where('tastkid='.$tid)->find();
            if(empty($task)){
                $this->error ( L('TASK_ERROR_EMPTY'));
            }
            $oid = $task['oid'];
            if(Order::checkorder($oid)==0){
                $this->error ( L('S_TASK_ERROR_1'));
            }
            $order = M("order")->where("order_id=".$oid)->find();
            if($order['state']!=Order::CONFIRMED){
                $this->error ( L('S_TASK_CW_ERROR_2'));
            }
            $item = empty($_POST['item'])?'':$_POST['item'];
            $pay_type = Order::get_dent_paytype($oid);
            $old = array();
            $new = array();
            $pays = M("order_pay")->where("oid=".$oid)->select();
            foreach ($pays as $k=>$v){
                $old[] = $v['opid'];
            }
            foreach ($item as $key=>$v){
                $new[] = (string)$key;
            }
            $add_data = array_diff($new,$old);
            $old_data = array_intersect($old,$new);
            $Model = M(); // 实例化一个空对象
            $Model->startTrans(); // 开启事务
            if(empty($item)){//直接处理
                //给客户发消息
                $title = sprintf(L('S_TASK_TASK_PROMPT_1'),$order['order_sn']);
                $content = sprintf(L('S_TASK_TASK_PROMPT_5'),$order['stuname'],$order['order_sn'],L('COST_CONFIRMED'));
                $msg_id = Order::action_msg_log(array('fromid' => '', 'toid' =>$order['uid'], 'addtime' => '','title' => $title,'content' => $content, 'outtype' => 'client_order' ,'outkey'=>$oid));
                if($order['hasmaking']==1){//需要生成打印任务
                    $tname =sprintf(L('S_TASK_TASK_PROMPT_4'),$order['order_sn']);
                    $newtid = Order::add_task(array('oid' => $oid, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_SD', 'uid' => '' ,'note'=>$tname,'isurgent'=>$order['isurgent']));
                }
                //写入订单操作记录
                $log_id = Order::action_order_log(array('oid' => $oid, 'uid' =>'', 'addtime' => '', 'state' => Order::COST_CONFIRMED ,'note'=>$note));
                //更改订单状态
                $result = M('Order')->where("order_id=".$oid)->save(array('state'=>Order::COST_CONFIRMED));
                //更新任务状态
                $result1 = M('OrderTask')->where("tastkid=".$tid)->save(array('state'=>1,'finishuid'=>UID,'finishtime'=>NOW_TIME,'finishnote'=>$note));
                if($order['hasmaking']==1){
                    if($msg_id&&$newtid&&$log_id&&$result&&$result1){
                        $Model->commit(); // 成功则提交事务
                        $redrect=U('OrderTaskCw/index');
                        $this->success(L('S_TASK_CW_SUC'), $redrect);
                    } else {
                        $Model->rollback(); // 否则将事务回滚
                        $this->error ( L('S_TASK_CW_ERROR'));
                    }
                }else{
                    if($msg_id&&$log_id&&$result){
                        $Model->commit(); // 成功则提交事务
                        $redrect=U('OrderTaskCw/index');
                        $this->success(L('S_TASK_CW_SUC'), $redrect);
                    } else {
                        $Model->rollback(); // 否则将事务回滚
                        $this->error ( L('S_TASK_CW_ERROR'));
                    }
                }
            }else{
                if(Order::checkdent($oid)==1){//现付用户
                    $new_m = 0;
                    $new_m1 = 0;
                    $refund_m = 0;
                    $refund_m1 = 0;
                    $pay = M("PayLog")->where("oid=".$oid)->order('paytime asc')->find();
                    if(empty($pay)){
                        $this->error ( L('S_TASK_ERROR_1'));
                    }
                    if($pay['currency']=='RMB') {
                        foreach ($item as $key => $v) {
                            if ($v['money']) {
                                $new_m += $v['money'];
                                if ($v['money'] < 0) {
                                    $refund_m += $v['money'];
                                }
                            }else{
                                $this->error ( L('S_TASK_CW_ERROR_8'));
                            }
                        }
                    }else{
                        foreach ($item as $key => $v) {
                            if ($v['money1']) {
                                $new_m1 += $v['money1'];
                                if ($v['money1'] < 0) {
                                    $refund_m1 += $v['money1'];
                                }
                            }else{
                                $this->error ( L('S_TASK_CW_ERROR_8'));
                            }
                        }
                    }
                    if($refund_m<0 || $refund_m1<0){
                        if($pay['currency']=='RMB'){
                            $pay_m =$pay['ramount'];
                            if(($refund_m<0 && abs($refund_m)>$pay_m) ){
                                $this->error ( L('S_TASK_CW_ERROR_4'));
                            }
                            if(abs($refund_m)==0){
                                $this->error ( L('S_TASK_CW_ERROR_7'));
                            }
                        }else{
                            $pay_m =$pay['ramount'];
                            if(($refund_m1<0 && abs($refund_m1)>$pay_m) ){
                                $this->error ( L('S_TASK_CW_ERROR_4'));
                            }
                            if(abs($refund_m1)==0){
                                $this->error ( L('S_TASK_CW_ERROR_7'));
                            }
                        }
                    }

                    foreach ($item as $k=>$v){
                        $order_pay = array(
                            'oid'=>$order['order_id'],
                            'feename' => $v['feename'],
                            'money' => $v['money'],
                            'money1' => $v['money1'],
                            'addtime' =>NOW_TIME,
                            'adduid' =>UID,
                            'paytype' =>$pay_type,
                            'note'=>$item[$v]['note']
                        );
                        $opid = M('OrderPay')->add($order_pay);
                        if(empty($opid)){
                            $this->error(L('S_TASK_CW_ERROR_5'));
                        }
                        if($v['money']<0 || $v['money1']<0){
                            //发起退款
                            $sn = Order::creat_refundsn();
                            if($pay['currency']=='RMB'){
                                $re_m = abs($v['money']);
                            }else{
                                $re_m = abs($v['money1']);
                            }
                            $refund = array(
                                'payid'=>$pay['payid'],
                                'resn'=>$sn,
                                'addtime'=>NOW_TIME,
                                'retype'=>$pay['pay_name'],
                                'amount'=>$re_m,
                                'currency'=>$pay['currency'],
                                'description'=>$item[$v]['note']
                            );
                            $reid = M('Refund')->add($refund);
                            if(empty($reid)){
                                $this->error(L('S_TASK_CW_ERROR_12'));
                            }
                            $out_request_no = $pay['paysn'].time();
                            if($pay['pay_name']=='alipay'){
                                include_once (ROOT_PATH.'/alipaysdk/aop/AopClient.php');
                                include_once (ROOT_PATH.'/alipaysdk/AopSdk.php');
                                $aop = new AopClient ();
                                $aop->gatewayUrl = ALIPAY_URL;
                                $aop->appId = ALIPAY_APPID;
                                $aop->rsaPrivateKey = ALIPAY_PRIVATEKEY;
                                $aop->alipayrsaPublicKey =ALIPAY_PUBLICKEY;
                                $aop->apiVersion = '1.0';
                                $aop->signType = 'RSA2';
                                $aop->postCharset='utf-8';
                                $aop->format='json';
                                $request = new AlipayTradeRefundRequest();
                                $request->setBizContent("{" .
                                    "\"out_trade_no\":\"{$pay['paysn']}\"," .
                                    "\"out_request_no\":\"{$out_request_no}\"," .
                                    "\"trade_no\":\"{$pay["out_trade_sn"]}\"," .
                                    "\"refund_amount\":{$re_m}," .
                                    "\"refund_reason\":\"{$item[$v]['note']}\"}");
                                $result = $aop->execute ( $request);
                                $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
                                $resultCode = $result->$responseNode->code;
                                if(empty($resultCode)||$resultCode != 10000){
                                    $this->error(sprintf(L('S_TASK_CW_ERROR_10'),$resultCode));
                                }
                                //退款成功回更操作
                                M('Refund')->where("reid=".$reid)->save(array('out_trade_sn'=>$result->$responseNode->trade_no,'retime'=>NOW_TIME));
                                $data=array(
                                    'addtime'=>NOW_TIME,
                                    'uid'=>UID,
                                    'amount'=>'-'.$re_m,
                                    'paytype'=>'支付宝',
                                    'stuid'=>$order['stuid'],
                                    'denid'=>$order['denid'],
                                );
                                $recid = M('Receipt')->add($data);
                                $data_sub=array(
                                    'recid'=>$recid,
                                    'opid'=>$opid,
                                    'oid'=>$oid,
                                    'feename'=>$v['feename'],
                                    'paytype'=>$pay_type,
                                    'amount'=>'-'.$re_m,
                                    'pay_amount'=>'-'.$re_m,//根据返回值重写
                                    'currency'=>$pay['currency'],
                                    'addtime'=>NOW_TIME,
                                    'uid'=>UID,
                                    'note'=>$item[$v]['note']
                                );
                                $recsubid = M('ReceiptSub')->add($data_sub);
                                //写入订单操作记录
                                $log_id = Order::action_order_log(array('oid' => $oid, 'uid' =>'', 'addtime' => '', 'state' => 0,'note'=>$item[$v]['note']));
                                if (empty($recid) || empty($recsubid) || empty($log_id)) {
                                    $this->error(L('S_TASK_CW_ERROR_13'));
                                }
                            }elseif($pay['pay_name']=='wxpay'){
                                require_once (ROOT_PATH.'/wxpayapi/lib/WxPay.Api.php');
                                $out_trade_no = $pay['paysn'];
                                $total_fee = $pay["ramount"];
                                $refund_fee = $re_m*100;
                                $input = new WxPayRefund();
                                $input->SetOut_trade_no($out_trade_no);
                                $input->SetTotal_fee($total_fee);
                                $input->SetRefund_fee($refund_fee);
                                $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));
                                $input->SetOp_user_id(WxPayConfig::MCHID);
                                $data = WxPayApi::refund($input);
                                libxml_disable_entity_loader(true);
                                $data = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
                                if($data["result_code"]!=0){
                                    $this->error(sprintf(L('S_TASK_CW_ERROR_11')));
                                }
                                //退款成功回更操作
                                M('Refund')->where("reid=".$reid)->save(array('out_trade_sn'=>$data["refund_id"],'retime'=>NOW_TIME));
                                $data=array(
                                    'addtime'=>NOW_TIME,
                                    'uid'=>UID,
                                    'amount'=>'-'.$re_m,
                                    'paytype'=>'支付宝',
                                    'stuid'=>$order['stuid'],
                                    'denid'=>$order['denid'],
                                );
                                $recid = M('Receipt')->add($data);
                                $data_sub=array(
                                    'recid'=>$recid,
                                    'opid'=>$opid,
                                    'oid'=>$oid,
                                    'feename'=>$v['feename'],
                                    'paytype'=>$pay_type,
                                    'amount'=>'-'.$re_m,
                                    'pay_amount'=>'-'.$re_m,//根据返回值重写
                                    'currency'=>$pay['currency'],
                                    'addtime'=>NOW_TIME,
                                    'uid'=>UID,
                                    'note'=>$item[$v]['note']
                                );
                                $recsubid = M('ReceiptSub')->add($data_sub);
                                //写入订单操作记录
                                $log_id = Order::action_order_log(array('oid' => $oid, 'uid' =>'', 'addtime' => '', 'state' => 0,'note'=>$item[$v]['note']));
                                if (empty($recid) || empty($recsubid) || empty($log_id)) {
                                    $this->error(L('S_TASK_CW_ERROR_13'));
                                }
                            }
                        }
                    }
                    $m = M("order_pay")->where("oid=".$oid)->sum('money');
                    $m1 = M("order_pay")->where("oid=".$oid)->sum('money1');
                    $data = array();
                    $data['amount'] = $m;
                    $data['amount1'] = $m1;
                    $result1 = M("Order")->where("order_id=".$oid)->save($data);
                    if($new_m<0 && $new_m1<0){//退款需要走退款流程
                        //给客户发退款消息
                        $title = sprintf(L('S_TASK_TASK_PROMPT_2'),$order['order_sn']);
                        $content =sprintf(L('S_TASK_TASK_PROMPT_6'),$order['stuname'],$order['order_sn'],$old_m,$m,$old_m1,$m1);
                    }else{
                        //给客户发费用增加消息
                        $title = sprintf(L('S_TASK_TASK_PROMPT_2'),$order['order_sn']);
                        $content =sprintf(L('S_TASK_TASK_PROMPT_7'),$order['stuname'],$order['order_sn'],$old_m,$m,$old_m1,$m1);
                    }
                    $msg_id = Order::action_msg_log(array('fromid' => '', 'toid' =>$order['uid'], 'addtime' => '','title' => $title,'content' => $content, 'outtype' => 'client_order' ,'outkey'=>$oid));
                    //写入订单操作记录
                    $log_id = Order::action_order_log(array('oid' => $oid, 'uid' =>'', 'addtime' => '', 'state' => Order::COST_CONFIRMED ,'note'=>$note));
                    if($order['hasmaking']==1){//需要生成打印任务
                        $tname =sprintf(L('S_TASK_TASK_PROMPT_4'),$order['order_sn']);
                        $newtid = Order::add_task(array('oid' => $oid, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_SD', 'uid' => '' ,'note'=>$tname,'isurgent'=>$order['isurgent']));
                    }
                    //更新任务状态
                    $result2 = M('OrderTask')->where("tastkid=".$tid)->save(array('state'=>1,'finishuid'=>UID,'finishtime'=>NOW_TIME,'finishnote'=>$note));
                    if($order['hasmaking']==1) {
                        if ($msg_id && $log_id && $result1 && $result2&&$newtid) {
                            $Model->commit(); // 成功则提交事务
                            $redrect = U('OrderTaskCw/index');
                            $this->success(L('S_TASK_CW_SUC'), $redrect);
                        } else {
                            $Model->rollback(); // 否则将事务回滚
                            $this->error(L('S_TASK_CW_ERROR'));
                        }
                    }else{
                        if ($msg_id && $log_id && $result1 && $result2) {
                            $Model->commit(); // 成功则提交事务
                            $redrect = U('OrderTaskCw/index');
                            $this->success(L('S_TASK_CW_SUC'), $redrect);
                        } else {
                            $Model->rollback(); // 否则将事务回滚
                            $this->error(L('S_TASK_CW_ERROR'));
                        }
                    }
                }else{//月付用户
                    //修改
                    foreach ($old_data as $k=>$v){
                        if($item[$v]['money']<1 || $item[$v]['money1']<1){
                            $this->error(L('S_TASK_CW_ERROR_6'));
                        }
                        if($item[$v]['money']>0 || $item[$v]['money1']>0){
                            $order_pay = array(
                                'opid'=>$v,
                                'oid'=>$order['order_id'],
                                'money' => $item[$v]['money'],
                                'money1' => $item[$v]['money1'],
                                'addtime' =>NOW_TIME,
                                'adduid' =>UID,
                                'paytype' =>$pay_type,
                                'note'=>$item[$v]['note']
                            );
                            $opid = M('OrderPay')->save($order_pay);
                            if(empty($opid)){
                                $this->error(L('S_TASK_CW_ERROR_5'));
                            }
                        }
                    }
                    //新增
                    foreach ($add_data as $k=>$v){
                        if($item[$v]['money']<1 || $item[$v]['money1']<1){
                            $this->error(L('S_TASK_CW_ERROR_6'));
                        }
                        if($item[$v]['money']>0 || $item[$v]['money1']>0) {
                            $order_pay = array(
                                'oid' => $order['order_id'],
                                'feename' => $item[$v]['feename'],
                                'money' => $item[$v]['money'],
                                'money1' => $item[$v]['money1'],
                                'addtime' => NOW_TIME,
                                'adduid' => UID,
                                'paytype' => $pay_type,
                                'note' => $item[$v]['note']
                            );
                            $opid = M('OrderPay')->add($order_pay);
                            if (empty($opid)) {
                                $this->error(L('S_TASK_CW_ERROR_5'));
                            }
                        }
                    }
                    $m = M("order_pay")->where("oid=".$oid)->sum('money');
                    $m1 = M("order_pay")->where("oid=".$oid)->sum('money1');
                    $data = array();
                    $data['amount'] = $m;
                    $data['amount1'] = $m1;
                    $data['state'] =Order::COST_CONFIRMED;
                    $result = M("Order")->where("order_id=".$oid)->save($data);
                    if($m！=$old_m && $m1！=$old_m1){
                        //给客户发费用变更状态变更消息
                        $title = sprintf(L('S_TASK_TASK_PROMPT_3'),$order['order_sn']);
                        $content =sprintf(L('S_TASK_TASK_PROMPT_8'),$order['stuname'],$order['order_sn'],$old_m,$m,$old_m1,$m1,L('COST_CONFIRMED'));
                    }else{
                        $title = sprintf(L('S_TASK_TASK_PROMPT_1'),$order['order_sn']);
                        $content = sprintf(L('S_TASK_TASK_PROMPT_5'),$order['stuname'],$order['order_sn'],L('COST_CONFIRMED'));
                    }
                    $msg_id = Order::action_msg_log(array('fromid' => '', 'toid' =>$order['uid'], 'addtime' => '','title' => $title,'content' => $content, 'outtype' => 'client_order' ,'outkey'=>$oid));
                    if($order['hasmaking']==1){//需要生成打印任务
                        $tname =sprintf(L('S_TASK_TASK_PROMPT_4'),$order['order_sn']);
                        $newtid = Order::add_task(array('oid' => $oid, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_SD', 'uid' => '' ,'note'=>$tname,'isurgent'=>$order['isurgent']));
                    }
                    //写入订单操作记录
                    $log_id = Order::action_order_log(array('oid' => $oid, 'uid' =>'', 'addtime' => '', 'state' => Order::COST_CONFIRMED ,'note'=>$note));

                    //更新任务状态
                    $result1 = M('OrderTask')->where("tastkid=".$tid)->save(array('state'=>1,'finishuid'=>UID,'finishtime'=>NOW_TIME,'finishnote'=>$note));
                    if($order['hasmaking']==1){
                        if($msg_id&&$newtid&&$log_id&&$result&&$result1){
                            $Model->commit(); // 成功则提交事务
                            $redrect=U('OrderTaskCw/index');
                            $this->success(L('S_TASK_CW_SUC'), $redrect);
                        } else {
                            $Model->rollback(); // 否则将事务回滚
                            $this->error ( L('S_TASK_CW_ERROR'));
                        }
                    }else{
                        if($msg_id&&$log_id&&$result){
                            $Model->commit(); // 成功则提交事务
                            $redrect=U('OrderTaskCw/index');
                            $this->success(L('S_TASK_CW_SUC'), $redrect);
                        } else {
                            $Model->rollback(); // 否则将事务回滚
                            $this->error ( L('S_TASK_CW_ERROR'));
                        }
                    }
                }
            }
        }
    }

    //删除费用明细
    public function delpay(){
        //删除pay记录并且重新计算费用并更新入订单主表
        $pid = empty($_POST['pid'])?0:$_POST['pid'];
        $pay = M("OrderPay")->where("opid=".$pid.' and state=0')->find();
        if(empty($pay)){
            $this->error ( L('S_TASK_CW_ERROR_3'));
        }
        $Model = M(); // 实例化一个空对象
        $Model->startTrans(); // 开启事务
        $result = M("OrderPay")->where("opid=".$pid)->delete();
        $m = M("order_pay")->where("oid=".$pay['oid'])->sum('money');
        $m1 = M("order_pay")->where("oid=".$pay['oid'])->sum('money1');
        $data = array();
        $data['amount'] = $m;
        $data['amount1'] = $m1;
        $result1 = M("Order")->where("order_id=".$pay['oid'])->save($data);
        if (!empty($result) && !empty($result1)) {
            $Model->commit(); // 成功则提交事务
            $redrect=U('OrderTaskCw/index');
            $this->success(L('DELETE_SUC'),$redrect);
        } else {
            $Model->rollback(); // 否则将事务回滚
            $this->error ( L('DELETE_ERROR'));
        }
    }
}
