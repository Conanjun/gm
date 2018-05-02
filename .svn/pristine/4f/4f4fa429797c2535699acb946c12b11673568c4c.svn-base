<?php

namespace Studio\Controller;
use Think\Page;
use Common\Common\Super\Order;
/**
 * 任务管理-标签打印 ：fhc
 *
 */
class OrderTaskBqController extends AdminController
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
        $stuid = Order::get_stuid(UID);     // 工作室id
        $where = "1=1 and t.tasktype = 'STUDIO_TASK_BQ' and o.stuid = {$stuid}";

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
            $sort = 't.addtime';
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
            ->order ( "$sort $order,$sort1 $order" )
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

    //标签打印
    public function confirm(){
	    if(IS_POST){
            $tid = empty($_POST['tid'])?0:$_POST['tid'];
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
            if($order['state']!=Order::MODEL_PRINTED){
                $this->error ( L('S_TASK_BQ_ERROR_1'));
            }
            $Model = M(); // 实例化一个空对象
            $Model->startTrans(); // 开启事务
            //给客户发消息
            $title = sprintf(L('S_TASK_TASK_PROMPT_1'),$order['order_sn']);
            $content = sprintf(L('S_TASK_TASK_PROMPT_5'),$order['stuname'],$order['order_sn'],L('TAG_PRINTED'));
            $msg_id = Order::action_msg_log(array('fromid' => '', 'toid' =>$order['uid'], 'addtime' => '','title' => $title,'content' => $content, 'outtype' => 'client_order' ,'outkey'=>$oid));
            //生成标签打印任务
            $tname = sprintf(L('S_TASK_TASK_PROMPT_10'),$order['order_sn']);
            $newtid = Order::add_task(array('oid' => $oid, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_CP', 'uid' => '' ,'note'=>$tname,'isurgent'=>$order['isurgent']));
            //写入订单操作记录
            $log_id = Order::action_order_log(array('oid' => $oid, 'uid' =>'', 'addtime' => '', 'state' => Order::TAG_PRINTED ,'note'=>$note));
            //更改订单状态
            $result = M('Order')->where("order_id=".$oid)->save(array('state'=>Order::TAG_PRINTED));
            //更新任务状态
            $result1 = M('OrderTask')->where("tastkid=".$tid)->save(array('state'=>1,'finishuid'=>UID,'finishtime'=>NOW_TIME,'finishnote'=>$note));
            if($msg_id&&$newtid&&$log_id&&$result&&$result1){
                $Model->commit(); // 成功则提交事务
                $redrect=U('OrderTaskBq/index');
                $this->success(L('S_TASK_BQ_SUC'), $redrect);
            }else{
                $Model->rollback(); // 否则将事务回滚
                $this->error(L('S_TASK_BQ_ERROR'));
            }
        }
    }


    public function qrprint(){
	    $tid = isset($_REQUEST['tid'])?intval($_REQUEST['tid']):0;
	    if(empty($tid)){
            $this->error('Data_not_exist');
        }
        $task = M("OrderTask")->where("tastkid=".$tid)->find();
        if(empty($task)){
            $this->error('Data_not_exist');
        }
        $oid = $task['oid'];
        $order = M("Order")->where("order_id=".$oid)->find();
        if(empty($order)){
            $this->error('Data_not_exist');
        }
        $orderext=M("OrderExt")->where("oid='{$oid}'")->field("*")->find();
        $this->assign('orderext',$orderext);
        $sql="select planid from ot_order_pay where oid='{$oid}' group by planid";
        $paysub=M()->query($sql);
        if($paysub){
            foreach ($paysub as $v){
                if($v["planid"]){
                    $field="zh_pname as pname";
                    getlange() && ($field="en_pname as pname");
                    $sql="select $field,type from ot_costplan where planid='{$v["planid"]}'";
                    $plan=M()->query($sql);
                    if($plan[0]){
                        if($plan[0]["type"]==1){
                            $this->assign('os',($plan[0]["pname"]));
                        }else{
                            $this->assign('ns',($plan[0]["pname"]));
                        }
                    }
                }
            }
        }
        /*$url = QRCODE_URL.$order['order_sn'];
        $code = $this->creatqr(
            "https://www.baidu.com"
        );
        $this->assign('imgcode',$code);*/
        $this->assign('tid',$tid);
        $this->assign('info',$order);
        $this->display();
    }
    public function creatqr($url=''){
        import("phpqrcode", "../phpqrcode", ".php");
        $value = $url;                  //二维码内容

        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = 5;           //生成图片大小

        //生成二维码图片
        $filename = 'qrcode/'.microtime().'.png';
        QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);

        $QR = $filename;                //已经生成的原始二维码图片文件


        $QR = imagecreatefromstring(file_get_contents($QR));

        //输出图片
        imagepng($QR, 'qrcode.png');
        imagedestroy($QR);
        return '<img src="qrcode.png">';
    }
}
