<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Studio\Controller;

use Common\Common\Super\Order;

/**
 * 订单管理控制器
 */
class PlatOrderController extends AdminController {
	private $model;
	
	// 构造函数
	public function __construct() {
		parent::__construct ();
		$this->model = D ( 'PlatOrder' ); // 数据字典Model
	}
	
	/**
	 * 后台字典管理首页
	 */
	public function index() {
        $stuid = Order::get_stuid(UID);   // 工作室id
		$where = " 1=1 and o.stuid = {$stuid}";
		$filter = '';
		$name = I("get.name","");
		$name && $filter .= " and (o.dename like '%{$name}%' or o.stuname like '%{$name}%' or o.pname like '%{$name}%')";
		
		$ordersn=I("get.order_sn","");
		$ordersn && $filter .= " and o.order_sn like '%{$ordersn}%' ";
		
		$state=I("get.state","");
		$state && $filter .= " and o.state = '{$state}' ";
		
		$servicetype=I("get.servicetype","");
		$servicetype && $filter .= " and o.servicetype = '{$servicetype}' ";
		
		$isurgent=I("get.isurgent","");
		if($isurgent!==""){
			$filter .= " and o.isurgent = '{$isurgent}' ";
		}
		$where .= $filter;
		
		// 更新排序
		if (isset ( $_GET ['sort'] ) && isset ( $_GET ['order'] )) {
			$sort = strtolower ( trim ( $_GET ['sort'] ) );
			$order = strtolower ( trim ( $_GET ['order'] ) );
			if (! in_array ( $order, array (
					'asc',
					'desc' 
			) )) {
				$sort = 'o.addtime';
				$order = 'desc';
			}
		} else {
			$sort = 'o.addtime';
			$order = 'desc';
		}
		
		$count = $this->model->countNum ( $where );
		$page = new \Think\Page ( $count, 20 );
		$lists = $this->model->join("left join ot_dictionary d on d.d_key=o.state and d.d_code='orderstatus'")
		->join("left join ot_dictionary d2 on d2.d_key=o.servicetype and d2.d_code='ser_type' ")
		->alias ( 'o' )->where ( $where )->order ( "$sort $order" )->field ( "d2.d_value as dv1,o.*,d.d_value" )
		->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		if($lists){
			foreach ($lists as	$k=>$v){
				$v["d_value"] && ($lists[$k]["d_value"]=L($v["d_value"]));
				$v["dv1"] && ($lists[$k]["dv1"]=L($v["dv1"]));
			}
		}
		
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$this->assign ( 'lists', $lists );
		$this->assign ( '_page', $page->show () );
		$this->assign ( 'filtered', $filter ? 1 : 0 ); // 是否有查询条件
		
		$sl = M ( "Dictionary" )->field ( "d_key,d_value" )->where ( "d_code='orderstatus'" )->order ( "d_order asc" )->select ();
		if($sl){
			foreach ($sl as $k=>$v){
				$sl[$k]["d_value"]=L($v["d_value"]);
			}
		}
		$this->assign ( 'statuslist', $sl );
		
		$st = M ( "Dictionary" )->field ( "d_key,d_value" )->where ( "d_code='ser_type'" )->order ( "d_order asc" )->select ();
		if($st){
			foreach ($st as $k=>$v){
				$st[$k]["d_value"]=L($v["d_value"]);
			}
		}
		$this->assign ( 'stypelist', $st );
		
		$this->display ();
	}
	
	public function view(){
		$id=I("get.id","");
		if(empty($id)){
			$this->error(L('Data_not_exist'));
		}
		
		$temp="";
		
		$info= $this->model->join("left join ot_dictionary d on d.d_key=o.state and d.d_code='orderstatus'")
		->join("left join ot_patient p on p.paid=o.paid")
		->join("left join ot_dictionary d2 on d2.d_key=o.servicetype and d2.d_code='ser_type' ")
		->alias ( 'o' )->where ( "order_id='{$id}'" )->field ( "o.*,d.d_value,p.gender as psex,d2.d_value as dv2" )->find ();
		
		if(empty($info)){
			$this->error(L('Data_not_exist'));
		}
		
		//服务内容相关
		$sql="select planid from ot_order_pay where oid='{$id}' group by planid";
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
		
		//订单扩展信息
		$orderext=M("OrderExt")->where("oid='{$id}'")->field("*")->find();
		$this->assign('orderext',$orderext);
		
		
		if($info["dv2"]=="PLANT"){
			//种植订单
			$temp="view";
			
			$info["dv2"]=L($info["dv2"]);
			$info["d_value"]=L($info["d_value"]);
			
			//种植订单明细
			$orderext1=M("OrderExt1")->alias("o")->join("left join ot_dictionary d1 on d1.d_key=o.isxft and d1.d_code='isxft'")
			->join("left join ot_dictionary d2 on d2.d_key=o.isyzy and d2.d_code='isyzy'")
			->join("left join ot_dictionary d3 on d3.d_key=o.issd and d3.d_code='issd'")
			->join("left join ot_dictionary d4 on d4.d_key=o.repairtype and d4.d_code='repairtype'")
			->join("left join ot_dictionary d5 on d5.d_key=o.mmodel and d5.d_code='mmodel'")
			->where("o.oid='{$id}'")->field("o.*,d1.d_value as xft,d2.d_value as yzy,d3.d_value as sd,d4.d_value as rt,d5.d_value as knmx")->find();
			if($orderext1){
				if($orderext1["xft"]){
					$orderext1["xft"]=L($orderext1["xft"]);
				}
				if($orderext1["yzy"]){
					$orderext1["yzy"]=L($orderext1["yzy"]);
				}
				if($orderext1["sd"]){
					$orderext1["sd"]=L($orderext1["sd"]);
				}
				if($orderext1["rt"]){
					$orderext1["rt"]=L($orderext1["rt"]);
				}
				if($orderext1["knmx"]){
					$orderext1["knmx"]=L($orderext1["knmx"]);
				}
			}
			$this->assign('orderext1',$orderext1);
			
			//相关文件
			$files=M("OrderFile")->alias("of")->where("of.oid='{$id}' and of.ftype='cbct'")
			->join("left join ot_file f on f.fileid=of.file_id")->field("f.savepath")->select();
			$this->assign('files',$files);
			
			$tootharray=array();
			$temparray=array_merge(Order::$lacktooth1,Order::$lacktooth2);
			if($temparray){
				foreach ($temparray as $v){
					$tootharray[]=array("h"=>0,"value"=>$v);
				}
			}
			
			$toothposition=array();
			$toothposition1=array();
			$t=explode(",",$orderext1["toothposition"]);
			$t1=explode(",",$orderext1["toothposition1"]);
			if($tootharray&&$t){
				foreach ($tootharray as $v){
					foreach ($t as $vv){
						if($vv==$v["value"]){
							$v["h"]=1;
						}
					}
					$toothposition[]=$v;
				}
			}
			
			if($tootharray&&$t1){
				foreach ($tootharray as $v){
					foreach ($t1 as $vv){
						if($vv==$v["value"]){
							$v["h"]=1;
						}
					}
					$toothposition1[]=$v;
				}
			}
			
			$this->assign('t1',$toothposition1);
			$this->assign('t',$toothposition);
			
			
		}

        //支付详情
        $order_pay = M('order_pay')->where("oid=".$id)->select();
        $this->assign('order_pay',$order_pay);
        //var_dump($order_pay);
        //操作记录
        $order_log = M('order_log') ->alias('l')->join("ot_member m on m.uid = l.uid","left")
            ->field('l.*,m.nickname')
            ->where("oid=".$id)->select();
        foreach ($order_log as $key=>$list){
            $order_log[$key]['str_state'] = L(Order::$orderState[$list['state']]);
        }
        $this->assign('order_log',$order_log);

		$this->assign('info',$info);
		$stuid = Order::get_stuid(UID);   // 工作室id
		//获取工作室code
		$code = M('Studio')->where('stuid='.$stuid)->getfield('code');
		//获取版本号
		$vid = M('OrderFile')->where("oid = {$id} and ftype = 'pro'")->order('addtime desc')->getField('vid');
		empty($vid)?$vid = 1: $vid = $vid+1;
		$this->assign('code',$code);
		$this->assign('vid',$vid);
		$this->display($temp);
	}

	//发货
	public function send(){
	    if(IS_POST){
            $id=!isset($_POST['id'])?0:intval($_POST['id']);
            $express=!isset($_POST['express'])?'':trim($_POST['express']);
            $expresscode=!isset($_POST['expresscode'])?'':trim($_POST['expresscode']);
            if(empty($id)){
                $this->error(L('Data_not_exist'));
            }
            if(empty($express) || empty($expresscode)){
                $this->error(L('EXPRESS_EMPTY'));
            }
            $order = M("Order")->where("order_id=".$id)->find();
            if(empty($order)){
                $this->error(L('Data_not_exist'));
            }
            if($order['state']!=Order::ACCOMPLISH){
                $this->error(L('STATE_NOT_SEND'));
            }
            $data = array(
                'state'=>Order::SHIPPED,
                'express'=>$express,
                'expresscode'=>$expresscode,
                'expresstime'=>NOW_TIME
            );
            $result = M("Order")->where("order_id=".$id)->save($data);
            $content = L('EXPRESS').":".$express.";".L('EXPRESSCODE').":".$expresscode;
            //写入订单操作记录
            $log_id = Order::action_order_log(array('oid' => $id, 'uid' =>'', 'addtime' => '', 'state' => Order::SHIPPED ,'note'=>$content));
            if($result===false){
                $this->error(L('SEND_ERROR'));
            }else{
                $this->success(L('SEND_SUC'),U('PlatOrder/view?id='.$id));
            }
        }else{
            $id=I("get.id");
            if(empty($id)){
                $this->error(L('Data_not_exist'));
            }
            $this->assign('id',$id);
            $this->display();
        }
    }

    //关闭订单
    public function close(){
        if(IS_POST){
            $id=!isset($_POST['id'])?0:intval($_POST['id']);
            if(empty($id)){
                $this->error(L('Data_not_exist'));
            }
            $order = M("Order")->where("order_id=".$id)->find();
            if(empty($order)){
                $this->error(L('Data_not_exist'));
            }

            if($order['state']!=Order::CANCEL){
                if($order['state']!=Order::RECEIVED && $order['hasmaking']==1){
                    $this->error(L('STATE_NOT_CLOSE'));
                }elseif($order['state']!=Order::COST_CONFIRMED && $order['hasmaking']==0 && $order['hasdesign']==1){
                    $this->error(L('STATE_NOT_CLOSE'));
                }
            }
            $data = array(
                'state'=>Order::CLOSE,
                'finishtime'=>NOW_TIME
            );
            $result = M("Order")->where("order_id=".$id)->save($data);
            $content = L('CLOSE_ORDER_STUDIO_MSG',$order['stuname'],$order['order_id']);
            //写入订单操作记录
            $log_id = Order::action_order_log(array('oid' => $id, 'uid' =>'', 'addtime' => '', 'state' => Order::CLOSE ,'note'=>$content));
            if($result===false){
                $this->error(L('CLOSE_ERROR'));
            }else{
                $this->success(L('CLOSE_SUC'),U('PlatOrder/view?id='.$id));
            }
        }
    }
    //内审
    public function verify(){
        $id=!isset($_POST['id'])?0:intval($_POST['id']);
        $note=!isset($_POST['note'])?'':trim($_POST['note']);
        if(empty($id)){
            $this->error(L('Data_not_exist'));
        }
        $order = M("Order")->where("order_id=".$id)->find();
        if(empty($order)){
            $this->error(L('Data_not_exist'));
        }

        if($order['state']!=Order::ASSIGNED){
            $this->error(L('PLAN_VERIFY_ERROR_1'));
        }
        if($order['canupplan']==1){
            $this->error(L('PLAN_VERIFY_ERROR_2'));
        }
        $data = array(
            'canupplan'=>1,
        );
        $result = M("Order")->where("order_id=".$id)->save($data);
        //写入订单操作记录
        $log_id = Order::action_order_log(array('oid' => $id, 'uid' =>'', 'addtime' => '', 'state' => Order::CLOSE ,'note'=>$note));
        if($result===false){
            $this->error(L('PLAN_VERIFY_ERROR'));
        }else{
            $this->success(L('PLAN_VERIFY_SUC'),U('PlatOrder/view?id='.$id));
        }
    }

    //取消
    public function cancle()
    {
        $tid = empty($_POST['tid']) ? '' : trim($_POST['tid']);
        $task = M("OrderTask")->where("tastkid=" . $tid)->find();
        $order_id = $task['oid'];
        $order = M("Order")->where("order_id=" . $order_id)->find();
        $user_state = Order::get_dent_paytype($order_id);
        if(UID!=$order['designer']){
            $this->error(L('S_TASK_SJS_MSG_8'));
        }
        //0现付-已付的退款1月付
        if ($user_state == 0) {
            $pays = M("PayLog")->where("oid=" . $order_id)->select();
            if (!empty($pays)) {
                foreach ($pays as $k => $v) {
                    //发起退款
                    $sn = Order::creat_refundsn();
                    $note = L('S_TASK_SJS_MSG_5');
                    if ($v['currency'] == 'RMB') {
                        $re_m = $v['ramount'];
                    }
                    $refund = array(
                        'payid' => $v['payid'],
                        'resn' => $sn,
                        'addtime' => NOW_TIME,
                        'retype' => $v['pay_name'],
                        'amount' => $re_m,
                        'currency' => $v['currency'],
                        'description' => $note
                    );
                    $reid = M('Refund')->add($refund);
                    if (empty($reid)) {
                        $this->error(L('S_TASK_CW_ERROR_12'));
                    }
                    $out_request_no = $v['paysn'] . time();
                    if ($v['pay_name'] == 'alipay') {
                        include_once(ROOT_PATH . '/alipaysdk/aop/AopClient.php');
                        include_once(ROOT_PATH . '/alipaysdk/AopSdk.php');
                        $aop = new AopClient ();
                        $aop->gatewayUrl = ALIPAY_URL;
                        $aop->appId = ALIPAY_APPID;
                        $aop->rsaPrivateKey = ALIPAY_PRIVATEKEY;
                        $aop->alipayrsaPublicKey = ALIPAY_PUBLICKEY;
                        $aop->apiVersion = '1.0';
                        $aop->signType = 'RSA2';
                        $aop->postCharset = 'utf-8';
                        $aop->format = 'json';
                        $request = new AlipayTradeRefundRequest();
                        $request->setBizContent("{" .
                            "\"out_trade_no\":\"{$v['paysn']}\"," .
                            "\"out_request_no\":\"{$out_request_no}\"," .
                            "\"trade_no\":\"{$v["out_trade_sn"]}\"," .
                            "\"refund_amount\":{$re_m}," .
                            "\"refund_reason\":\"{$note}\"}");
                        $result = $aop->execute($request);
                        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
                        $resultCode = $result->$responseNode->code;
                        if (empty($resultCode) || $resultCode != 10000) {
                            $this->error(sprintf(L('S_TASK_CW_ERROR_10'), $resultCode));
                        }
                        //退款成功回更操作
                        M('Refund')->where("reid=" . $reid)->save(array('out_trade_sn' => $result->$responseNode->trade_no, 'retime' => NOW_TIME));
                        $data = array(
                            'addtime' => NOW_TIME,
                            'uid' => UID,
                            'amount' => '-' . $re_m,
                            'paytype' => '支付宝',
                            'stuid' => $order['stuid'],
                            'denid' => $order['denid'],
                        );
                        $recid = M('Receipt')->add($data);
                        $data_sub = array(
                            'recid' => $recid,
                            'opid' => $v['payid'],
                            'oid' => $v['oid'],
                            'feename' => $v['feename'],
                            'paytype' => $user_state,
                            'amount' => '-' . $re_m,
                            'pay_amount' => '-' . $re_m,//根据返回值重写
                            'currency' => $v['currency'],
                            'addtime' => NOW_TIME,
                            'uid' => UID,
                            'note' => $note
                        );
                        $recsubid = M('ReceiptSub')->add($data_sub);

                        //写入订单操作记录
                        $log_id = Order::action_order_log(array('oid' => $order_id, 'uid' => '', 'addtime' => '', 'state' => Order::CANCEL, 'note' => $note));
                        if (empty($recid) || empty($recsubid) || empty($log_id)) {
                            $this->error(L('S_TASK_CW_ERROR_13'));
                        }
                    } elseif ($v['pay_name'] == 'wxpay') {
                        require_once(ROOT_PATH . '/wxpayapi/lib/WxPay.Api.php');
                        $out_trade_no = $v['paysn'];
                        $total_fee = $v["ramount"];
                        $refund_fee = $re_m * 100;
                        $input = new WxPayRefund();
                        $input->SetOut_trade_no($out_trade_no);
                        $input->SetTotal_fee($total_fee);
                        $input->SetRefund_fee($refund_fee);
                        $input->SetOut_refund_no(WxPayConfig::MCHID . date("YmdHis"));
                        $input->SetOp_user_id(WxPayConfig::MCHID);
                        $data = WxPayApi::refund($input);
                        libxml_disable_entity_loader(true);
                        $data = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
                        if ($data["result_code"] != 0) {
                            $this->error(sprintf(L('S_TASK_CW_ERROR_11')));
                        }
                        //退款成功回更操作
                        M('Refund')->where("reid=" . $reid)->save(array('out_trade_sn' => $data["refund_id"], 'retime' => NOW_TIME));
                        $data = array(
                            'addtime' => NOW_TIME,
                            'uid' => UID,
                            'amount' => '-' . $re_m,
                            'paytype' => '支付宝',
                            'stuid' => $order['stuid'],
                            'denid' => $order['denid'],
                        );
                        $recid = M('Receipt')->add($data);
                        $data_sub = array(
                            'recid' => $recid,
                            'opid' => $v['payid'],
                            'oid' => $v['oid'],
                            'feename' => $v['feename'],
                            'paytype' => $user_state,
                            'amount' => '-' . $re_m,
                            'pay_amount' => '-' . $re_m,//根据返回值重写
                            'currency' => $v['currency'],
                            'addtime' => NOW_TIME,
                            'uid' => UID,
                            'note' => $note
                        );
                        $recsubid = M('ReceiptSub')->add($data_sub);
                        //写入订单操作记录
                        $log_id = Order::action_order_log(array('oid' => $order_id, 'uid' => '', 'addtime' => '', 'state' => Order::CANCEL, 'note' => $note));
                        if (empty($recid) || empty($recsubid) || empty($log_id)) {
                            $this->error(L('S_TASK_CW_ERROR_13'));
                        }
                    }
                }
            }
        }
        $result = M("Order")->where("order_id=" . $order_id)->save(array('state' => Order::CANCEL));
        if($result===false){
            $this->error(L('S_TASK_SJS_MSG_6'));
        }
        $this->success(L('S_TASK_SJS_MSG_7'), U('index'));
    }
	//文件详情 format_bytes
	public function file_info(){
		//获取方案
		$oid = I('get.oid',0);
		$pid = I('get.pid',0);
		$limit = I('get.limit',0);
		$row =  20 * $limit;
		$count =  M('OrderFile')
			->alias('of')
			->join('ot_file f  on f.fileid = of.file_id','left')
			->where(array('oid'=>$oid,'parent'=>$pid))->count();
		$files = M('OrderFile')
			->alias('of')
			->field("*,FROM_UNIXTIME(f.addtime,'%y-%m-%d %H:%i') addtime")
			->join('ot_file f  on f.fileid = of.file_id','left')
			->where(array('oid'=>$oid,'parent'=>$pid))
			->order('file_id asc,of.addtime asc')
			->limit ("$row,20")
			->select ();
		foreach($files as $k => $v){
			$files[$k]['ftype']= L($v['ftype']);
		}
		$this->assign('files',$files);
		$stuid = Order::get_stuid(UID);   // 工作室id
		//获取工作室code
		$code = M('Studio')->where('stuid='.$stuid)->getfield('code');
		//获取订单号
		$sn = M('Order')->where('order_id='.$oid)->getfield('order_sn');
		//获取版本号
		$vid = M('OrderFile')->where("oid = {$oid} and ftype = 'pro'")->order('addtime desc')->getField('vid');
		empty($vid)?$vid = 1: $vid = $vid+1;
		$pages =  ceil($count/20);
		echo json_encode(array('sn'=>$sn,'count'=>$count,'oid'=>$oid,'pid'=>$pid,'code'=>$code,'files'=>$files,'limit'=>$limit,'vid'=>$vid,'pages'=>$pages));
	}
	//异步上传文件
	public function uploadFile()
	{
		$code = I('get.code','');
		$sn = I('get.sn','');
		$type = I('get.type','');
		$vid = I('get.vid','');
		$oid = I('get.oid',0);
		$time = time();
		//获取版本号
		if($code && $sn && $type){
			if($type == 'pro'){
				$vname = "ver_".$vid;
				$path = explode(',',I('get.path'));
				array_shift($path);
				array_unshift($path,$vname);
				if($path){
					for($i=0;$i<count($path);$i++) {
						$j = $i-1;
						if($i == 0){
							$parentid = M('OrderFile')->where("order_sn = '{$sn}' and ftype = '{$type}' and path = '{$path[$i]}' and grade = {$i} and vid= {$vid}")->getField('fid');
							if (empty($parentid)) {
								$parentid = M('OrderFile')->add(array('order_sn' => $sn, 'ftype' => $type, 'path' => $path[$i], 'addtime' => $time, 'grade' => $i,'vid'=>$vid,'oid'=>$oid));
							}
						}else{
							$paid = M('OrderFile')->where("order_sn = '{$sn}' and ftype = '{$type}' and path = '{$path[$j]}' and grade = {$j} and vid= {$vid}")->getField('fid');
							$parentid = M('OrderFile')->where("order_sn = '{$sn}' and ftype = '{$type}' and path = '{$path[$i]}' and grade = {$i} and vid= {$vid}")->getField('fid');
							if (empty($parentid)) {
								$parentid = M('OrderFile')->add(array('order_sn' => $sn, 'ftype' => $type, 'path' => $path[$i], 'addtime' => $time, 'grade' => $i,'vid'=>$vid,'parent'=>$paid,'oid'=>$oid));
							}
						}
						
					}
					$paths = implode('/',$path);
					$subName = $code.'/'.$sn.'/'.$type.'/'.$paths;
				}else{
					$subName = $code.'/'.$sn.'/'.$type.'/'.$vname;
				}
			}else{
				$parentid = M('OrderFile')->where("order_sn = '{$sn}' and ftype = '{$type}' and path = 'cbct'")->getField('fid');
				if (empty($parentid)) {
					$parentid = M('OrderFile')->add(array('order_sn' => $sn, 'ftype' => $type, 'path' => 'cbct', 'addtime' => $time,'oid'=>$oid));
				}
				$subName = $code.'/'.$sn.'/'.$type;
			}
			
		}else{
			$this->json_error();
		}
		$p=C('DOWNLOAD_UPLOAD');
		$uploader = new \Think\Upload($p);
		$uploader->maxSize = 500 * 1024 * 1024;
		$uploader->autoSub=true;
		$uploader->saveName='';
		$uploader->subName=$subName;
		$info = $uploader->upload();
		
		
		if(!$info){
			// 上传错误提示错误信息
			$this->json_error($uploader->getError(),false);
		}else{
			// 上传成功 获取上传文件信息
			$res = array();
			foreach ($info as $key => $value) {
				$path = $p['rootPath'] . $value['savepath'] . $value['savename'];
				$name = $value['name'];
				$file['name'] = $name;
				$file['savepath'] = $path;
				$file['ext'] = $value['ext'];
				$file['size'] = $value['size'];
				$file['uid'] = UID;
				$file['addtime'] = $time;
				$file['uname'] = get_nickname(is_login()) ? get_nickname(is_login()) : get_username(is_login());
				$fileid = M('File')->add($file);
				if($fileid){
					$oss_path=str_replace($p['rootPath'], '', $path);
					$res = oss_upload($path,$oss_path);
					$alyfile = '';
					if($res['status']) {
						$alyfile = get_oss_url($oss_path);
					}
					$data = array(
						'order_sn' => $sn,
						'oid' => $oid,
						'file_id' => $fileid,
						'ftype' => $type,
						'addtime' => $time,
						'uid' => UID,
						'alyfile' => $alyfile,
						'oss_path' => $oss_path,
						'vid' => $vid,
						'parent' => empty($parentid)?0:$parentid,
					);
					M('OrderFile')->add($data);
					$path = iconv( "utf-8", "gb2312",$path);
					unlink($path);
				}
				$res= array(
					'ext' => $value['ext'],
					'size' => $value['size'],
					'fid' => $fileid,
					'addtime' => date('Y-m-d H:i:s',$time),
				);
			}
			echo json_encode(array('done'=>true,'msg'=>$res));
		}
	}
}
