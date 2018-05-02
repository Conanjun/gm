<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Common\Common\Super;

class Order
{
    const SUBMITTED = 10;    // 已提交
    const ALREADY = 20;        // 设计资料已接收
    const DIGITIZED = 30;       // 设计资料已数字化
    const ASSIGNED = 40;      // 已分派设计师
    const UPLOADED = 50;         // 已上传方案
    const CONFIRMED = 60;          // 已确认方案
    const COST_CONFIRMED = 70;          // 已确认最终报价
    const MODEL_PRINTED = 80;         // 模型已打印
    const TAG_PRINTED = 90;         // 标签已打印
    const ACCOMPLISH = 100;         // 已完成包装
    const SHIPPED = 110;         // 已发货
    CONST RECEIVED = 120;         // 已收货
    const CANCEL = -1;         // 已取消
    const CLOSE = 130;         // 已关闭
	
	public static $orderState = array(
		'10' => 'SUBMITTED',
		'20' => 'ALREADY',
		'30' => 'DIGITIZED',
		'40' => 'ASSIGNED',
		'50' => 'UPLOADED',
		'60' => 'CONFIRMED',
        '70' => 'COST_CONFIRMED',
		'80' => 'MODEL_PRINTED',
		'90' => 'TAG_PRINTED',
		'100' => 'ACCOMPLISH',
		'110' => 'SHIPPED',
		'120' => 'RECEIVED',
		'-1' => 'CANCEL'
	);
	//牙位1
	public static $lacktooth1 = array(
		0 => 18,
		1 => 17,
		2 => 16,
		3 => 15,
		4 => 14,
		5 => 13,
		6 => 12,
		7 => 11,
		8 => 21,
		9 => 22,
		10 => 23,
		11 => 24,
		12 => 25,
		13 => 26,
		14 => 27,
		15 => 28,
	);
	//牙位2
	public static $lacktooth2 = array(
		0 => 48,
		1 => 47,
		2 => 46,
		3 => 45,
		4 => 44,
		5 => 43,
		6 => 42,
		7 => 41,
		8 => 31,
		9 => 32,
		10 => 33,
		11 => 34,
		12 => 35,
		13 => 36,
		14 => 37,
		15 => 38,
	);

	//判断订单是否存在，现付用户是否支付费用
	public function checkorder($oid){
	    $order = M("Order")->where("order_id=".$oid)->find();
	    if(empty($order)){
	        return 0;
        }
        //查询现付客户是否有未支付费用  支付状态 1-已支付 0-未支付 付费方式 0-现付 1-月付
        $pays = M('OrderPay')->where("oid=".$oid)->select();
        if(empty($pays)){
            return 0;
        }else{
            $error = 0;
            foreach ($pays as $pay){
                if($pay['paytype']==0){
                    if($pay['state']==0){
                        $error =1;
                        break;
                    }
                }
            }
            if($error==1){
                return 0;
            }
        }
        return 1;
    }

    //判断用户是否是现付用户
    public function checkdent($oid){
        $order = M("order")->where("order_id=".$oid)->find();
        $dent = M("dentist")->where("denid=".$order['denid'])->find();
        if($dent['paytype']==0){//现付
            return 1;
        }else{
            return 0;
        }
    }
    //获取用户的支付方式
    public function get_dent_paytype($oid){
        $order = M("order")->where("order_id=".$oid)->find();
        $dent = M("dentist")->where("denid=".$order['denid'])->find();
        return $dent['paytype'];
    }
    //根据用户获取工作室id
    public function get_stuid($uid){
        $user = M('Member')->where("uid=".$uid)->find();
        return $user['stuid'];
    }
    //添加任务
    public function add_task($action){
        /*oid,tname,tasktype,note,isurgent*/
        //参数检查
        if (empty($action) || !is_array($action)) {
            return L('ACTION_EMPTY');
        }
        if (empty($action['oid'])) {
            return L('ORDER_OID');
        }
        if (empty($action['tname'])) {
            return L('TASK_NAME');
        }
        if (empty($action['tasktype'])) {
            return L('TASK_TYPE');
        }
        if (empty($action['uid'])) {
            $action['uid'] = is_login();
        }
        if (empty($action['addtime'])) {
            $action['addtime'] = NOW_TIME;
        }
        $tastkid = M('OrderTask')->add($action);
        return $tastkid;
    }
    //订单操作记录
    public function action_order_log($action){
        /*oid,uid,addtime,state,note*/
        //参数检查
        if (empty($action) || !is_array($action)) {
            return L('ACTION_EMPTY');
        }
        if (empty($action['oid'])) {
            return L('ORDER_OID');
        }
        if (empty($action['state'])) {
            return L('ORDER_LOG_STATE');
        }

        if (empty($action['uid'])) {
            $action['uid'] = is_login();
        }
        if (empty($action['addtime'])) {
            $action['addtime'] = NOW_TIME;
        }
        $logid = M('OrderLog')->add($action);
        return $logid;
    }
    //消息记录
    public function action_msg_log($action){
        /*fromid,toid,addtime,title,content,outtype,ouykey*/
        //参数检查
        if (empty($action) || !is_array($action)) {
            return L('ACTION_EMPTY');
        }
        if (empty($action['toid'])) {
            return L('MSG_TOID');
        }
        if (empty($action['title'])) {
            return L('MSG_TITLE');
        }
        if (empty($action['content'])) {
            return L('MSG_CONTENT');
        }
        if (empty($action['outtype'])) {
            return L('MSG_OUTTYPE');
        }
        if (empty($action['outkey'])) {
            return L('MSG_OUTKEY');
        }

        if (empty($action['fromid'])) {
            $action['fromid'] = is_login();
        }
        if (empty($action['addtime'])) {
            $action['addtime'] = NOW_TIME;
        }
        $msg_id = M('Message')->add($action);

        return $msg_id;
    }
    //付款单号
    public function creat_paysn(){
	    $str = time();
        $num='P'.substr($str,-8);
        $ret = M("PayLog")->where("paysn=".$num)->find();
        if($ret){
            $this->creat_paysn();
        }
        return $num;
    }
    //退款单号
    public function creat_refundsn(){
        $str = time();
        $num='R'.substr($str,-8);
        $ret = M("PayLog")->where("paysn=".$num)->find();
        if($ret){
            $this->creat_paysn();
        }
        return $num;
    }
}
