<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Dentist\Controller;
use User\Api\UserApi;
use Common\Common\Super\Order;
/**
 * 牙医 订单管理 : zl
 */
class OrderController extends AdminController
{
	private $model;
	
	//构造函数
	public function __construct()
	{
		parent::__construct();
		$this->model = D('Order');    // 牙医Model
	}
	
	//订单管理首页
	public function index()
	{
		$denid = $this->get_denid(UID);    // 牙医id
		$where = "1=1 and o.denid = {$denid}";
		
		$filter= '';

        $order_sn = empty($_GET['order_sn'])?'':trim($_GET['order_sn']);//订单编号
        if($order_sn){
            $filter .= " and o.order_sn like '%{$order_sn}%'";
        }

		$pname = empty($_GET['pname'])?'':trim($_GET['pname']);//患者姓名
		if($pname){
			$filter .= " and o.pname like '%{$pname}%'";
		}

        $stuname = empty($_GET['stuname'])?'':trim($_GET['stuname']);//工作室名称
        if($stuname){
            $filter .= " and o.stuname like '%{$stuname}%'";
        }

        $servicetype = empty($_GET['servicetype'])?'':trim($_GET['servicetype']);//服务方式
        if($servicetype){
            $filter .= " and o.servicetype like '%{$servicetype}%'";
        }

        $express = empty($_GET['express'])?'':trim($_GET['express']);//快递公司
        if($express){
            $filter .= " and o.express like '%{$express}%'";
        }

		$expresscode = empty($_GET['expresscode'])?'':trim($_GET['expresscode']);//快递单号
		if($expresscode){
			$filter .= " and o.expresscode like '%{$expresscode}%'";
		}

        $state = empty($_GET['state'])?'':trim($_GET['state']);//订单状态
        if($state){
            $filter .= " and o.state = '{$state}'";
        }

		$isurgent = empty($_GET['isurgent'])?'':trim($_GET['isurgent']);//是否加急
		$isurgent == 1 and  $filter .= " and o.isurgent = 1";
		$isurgent == 2 and  $filter .= " and o.isurgent = 0";

        $isclear = empty($_GET['isclear'])?'':trim($_GET['isclear']);//是否结算
        $isclear == 1 and  $filter .= " and o.isclear = 1";
        $isclear == 2 and  $filter .= " and o.isclear = 0";
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
		$where .= $filter;
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
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->assign('filtered', $filter ? 1 : 0); //是否有查询条件

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
		$this->display();
	}
	//新增订单  服务类型选择
	public function  service_select(){
		$stuid = $this->get_stuid(UID);    // 工作室id
		//服务类型
		$types = M('StudioService')
			->alias('ss')
			->field('ss.sid,d.d_value')
			->join("ot_dictionary d on d.d_value = ss.type and d.d_code='ser_type' and d_del = 0")
			->where("ss.stuid = ".$stuid)
			->select();
		$this->assign('types',$types);
		$this->display();
	}
	
	// 新增订单
	public function add()
	{
		$this->file_info1(0);
		$stuid = $this->get_stuid(UID);    // 工作室id
		$dentist = M('Dentist')->where(array('uid'=>UID))->find();
		$denid = $dentist['denid'];
		$time = time();
		//分派设计师（当前关联订单最少）
		$designer = M('auth_group') ->alias('g')
			->field("count(o.designer) as count,ag.uid")
			->join("ot_auth_group_access ag on g.id = ag.group_id")
			->join("ot_order o on ag.uid = o.designer","left")
			->where("g.designer = 1 and g.stuid ={$stuid}")
			->group('ag.uid')->order('count asc')->find();
		if(empty($designer)){
			$this->error(L('NOT_DESIGNER_ADD'),U('Order/index'));
		}
		if(IS_POST){
			$Model = M(); // 实例化一个空对象
			$Model->startTrans(); // 开启事务
			$order_sn = I('get.sn','');
			if(empty($order_sn)){
				$this->json_error(L('_ERROR_ACTION_'));
			}
			$servicetype = I('sid',0);
			if($servicetype==''){
				$this->json_error(L('P_SELECT_SERVICE'));
			}
			$processing_modem = I('processing_modem','');//加工方式
			$processing = '';
			$hasdesign = 0 ;
			$hasmaking = 0 ;
			foreach($processing_modem as $vo){
				$processing .= $vo['key'].',';
				if($vo['key'] == 'designfee'){
					$hasdesign = 1 ;
				}elseif($vo['key'] == 'makingfee'){
					$hasmaking = 1;
				}
			}
			$processing = trim($processing,',');
			if($processing==''){
				$this->json_error(L('P_SELECT_PROCESSING'));
			}
			
			$costplan = I('costplan',''); //普通服务内容
			if($costplan == ''){
				$this->json_error(L('P_SELECT_COSTPLAN'));
			}
			
			$costplan1 = I('costplan1',''); //其他服务
			
			$isurgents = I('isurgents',0);//是否加急
			$addr_id = I('addr_id',0);//邮寄地址
			if(empty($addr_id)){
				$this->json_error('请选择邮寄地址');
			}
			$addess = M('Addess')->where('addr_id = '.$addr_id)->find();
			
			$doctor = I('doctor',''); //主治医生
			if(empty($doctor)){
				$this->error('请填写主治医生');
			}
			$doctorass = I('doctorass',''); //主治医生助理
			if(empty($doctorass)){
				$this->json_error('请填写主治医生助理');
			}
			$doctor1 = I('doctor1',''); //转诊医生
			$doctorass1 = I('doctorass1',''); //转诊医生助理
			
			$doctor_tel = I('doctor_tel',0);
			$doctor1_tel =I('doctor1_tel',0);
			$doctorass_tel =I('doctorass_tel',0);
			$doctorass1_tel = I('doctorass1_tel',0);
			
			$pname = I('pname',''); //患者姓名
			if(empty($pname)){
				$this->json_error('请填写患者姓名');
			}
			$gender = I('gender',0); //性别
			$birthday = I('birthday',''); //出生日期
			if(empty($birthday)){
				$this->json_error('请选择出生日期');
			}
			$birthday = strtotime($birthday);
			//判断是否新患者
			$patient = M('Patient')->where(array('denid'=>$denid,'realname'=>$pname,'gender'=>$gender,'birthday'=>$birthday))->find();
			if(empty($patient)){
				$patient_data = array( 'realname'=>$pname,'gender'=>$gender,'birthday'=>$birthday,'denid'=>$denid,'addtime'=>time(),'adduid'=>UID );
				$paid = M('Patient')->add($patient_data);
			}else{
				$paid = $patient['paid'];
			}
			$age = I('age',0); //年龄
			$pedesc = I('pedesc',''); //患者主诉
			$note = I('note',''); //描述
			$isxft = I('isxft',0); //修复体
			$isyzy = I('isyzy',''); //牙周炎
			$issd = I('issd',''); //牙齿松动
			$repairtype = I('repairtype',''); //上部修复方式
			$surgerytime = I('surgerytime',0); //计划手术日期
			/*if(empty($surgerytime)){
				$this->json_error('请选择计划手术日期');
			}*/
			$toothposition= I('toothposition',''); //缺失牙位标记
			/*if(empty($toothposition)){
				$this->json_error('请选择计划手术日期');
			}*/
			$toothposition4 = '';
			foreach($toothposition as $vo){
				$toothposition4 .= trim(trim($vo,'inf'),'sup').',';
			}
			$toothposition = trim($toothposition4,',');
			$toothposition1 = I('toothposition1',''); //拟种植牙位
			$toothposition3 = '';
			foreach($toothposition1 as $vo){
				$toothposition3 .= trim(trim($vo,'inf'),'sup').',';
			}
			$toothposition1 = trim($toothposition3,',');
			
			$surgerysystem = I('surgerysystem',''); //种植体品牌及型号
			$surgerytool= I('surgerytool',''); //手术工具
			$mmodel = I('mmodel',''); //口内模型
			$pic1 = I('pic1',''); //患者口内照片
            if(empty($pic1)){
                $this->json_error(L('PKNZP'));
            }
            $pic2 = I('pic2',''); //患者面部照片
            if(empty($pic2)){
                $this->json_error(L('PMBZP'));
            }
			$pic3 = I('pic3','');
			if(empty($pic3) && $mmodel =='mouth_scan'){
				$this->json_error(L('PKXZP'));
			}
			$print1 = I('print1',''); //颌骨打印
			$print2 = I('print2',''); //模型打印
			$stuname = M('Studio')->where('stuid='.$stuid)->getField('name');
			
			$order_data = array(
				'order_sn' => $order_sn,
				'denid' => $denid,
				'uid' => UID,
				'dename' => empty($dentist['name'])?'':$dentist['name'],
				'stuid' => $stuid,
				'stuname' => $stuname,
				'paid' => $paid,
				'pname' => $pname,
				'servicetype' => $servicetype,
				'state' => Order::SUBMITTED,
				'addtime'=>$time,
				'isurgent'=>$isurgents,
				'hasmaking' => $hasmaking,
				'hasdesign' => $hasdesign,
			);
			$order_id = $this->model->add($order_data);
			//订单文件
			$order_file = M('OrderFile')->where(array('order_sn'=>$order_sn))->save(array('oid'=>$order_id));
			if(empty($order_file)){
				$this->json_error(L('PCBCTD'));
			}
			$order_ext = array(
				'oid' => $order_id,
				'decountry' => empty($dentist['country'])?0:$dentist['country'],
				'deprovince' => empty($dentist['province'])?0:$dentist['province'],
				'decity' => empty($dentist['city'])?0:$dentist['city'],
				'dername' => empty($dentist['name'])?'':$dentist['name'],
				'deaddr' => empty($dentist['addr'])?'':$dentist['addr'],
				'shipcountry' => empty($addess['country'])?0:$addess['country'],
				'shipprovince' => empty($addess['province'])?0:$addess['province'],
				'shipcity' => empty($addess['city'])?0:$addess['city'],
				'shiprname' => empty($addess['regionname'])?0:$addess['regionname'],
				'shipaddr' => empty($addess['addr'])?0:$addess['addr'],
				'shipuname' => empty($addess['snee'])?0:$addess['snee'],
				'shiptel' => empty($addess['snee_tel'])?0:$addess['snee_tel'],
				'doctor' => $doctor,
				'doctor1' => $doctor1,
				'doctorass' => $doctorass,
				'doctorass1' => $doctorass1,
				'doctor_tel' => $doctor_tel,
				'doctor1_tel' => $doctor1_tel,
				'doctorass_tel' => $doctorass_tel,
				'doctorass1_tel' => $doctorass1_tel,
				'peage' => $age,
				'pebirth' => $birthday,
			);
			$extid = M('OrderExt')->add($order_ext);
			$order_ext1 = array(
				'oid' => $order_id,
				'pedesc' => $pedesc,
				'note' => $note,
				'isxft' => $isxft,
				'isyzy' => $isyzy,
				'issd' => $issd,
				'repairtype' => $repairtype,
				'surgerytime' => strtotime($surgerytime),
				'toothposition' => $toothposition,
				'toothposition1' => $toothposition1,
				'surgerysystem' => $surgerysystem,
				'surgerytool' => $surgerytool,
				'mmodel' => $mmodel,
				'print1' => $print1,
				'print2' => $print2,
				'pic1' => $pic1,
				'pic2' => $pic2,
				'pic3' => $pic3,
			);
			$ext1id = M('OrderExt1')->add($order_ext1);
			$order_pay_mod = M('OrderPay');
			//普通服务
			$costplan_mod = M('Costplan');
			$modem_count = count($processing_modem);
            foreach($processing_modem as $vo){
                $costplan_data = $costplan_mod->alias('c')->join('ot_costplan_sub cs on cs.planid = c.planid ')->where(array('c.planid'=>$costplan,'cs.feecode' => $vo['key']))->find();
	            if($costplan_data){
                    if(getlange()){
                        $pt = $costplan_data['en_pname'];
                    }else{
                        $pt = $costplan_data['zh_pname'];
                    }
	                if($costplan_data['price']>0 || $costplan_data['price1']){
		                $yh = 1;
		                if($costplan_data['discount'] && $modem_count>1){
			                $yh = $costplan_data['discount']/100;
		                }
		                $order_pay1 = array(
			                'oid'=>$order_id,
			                'feename' => $costplan_data['feename'],
			                'money' => $costplan_data['price'] * $yh,
			                'money1' => $costplan_data['price1'] * $yh,
			                'addtime' =>$time,
			                'adduid' =>UID,
			                'paytype' =>$dentist['paytype'],
			                'planid' =>$costplan_data['planid'],
			                'plansubid' =>$costplan_data['plansubid'],
			                'note' =>$costplan_data['feename'].$pt,
		                );
	                }else{
		                $order_pay1 = array(
			                'oid'=>$order_id,
			                'feename' => $costplan_data['feename'],
			                'money' => $costplan_data['price'] ,
			                'money1' => $costplan_data['price1'],
			                'addtime' =>$time,
			                'state' =>1,
			                'adduid' =>UID,
			                'paytype' =>$dentist['paytype'],
			                'planid' =>$costplan_data['planid'],
			                'plansubid' =>$costplan_data['plansubid'],
			                'note' =>$costplan_data['feename'].$pt,
		                );
	                }
	                $opid = $order_pay_mod->add($order_pay1);
	                if(empty($opid)){
		                $this->json_error(L('S_TASK_CW_ERROR_5'));
	                }
                }
            }
            //特殊服务
            $costplan1 = array_filter($costplan1);
			if($costplan1){
				foreach($processing_modem as $vo){
					foreach($costplan1 as $v){
						$costplan_data = $costplan_mod->alias('c')->join('ot_costplan_sub cs on cs.planid = c.planid ')->where(array('c.planid'=>$v['key'],'cs.feecode '=>$vo['key']))->find();
                        if(getlange()){
                            $pt = $costplan_data['en_pname'];
                        }else{
                            $pt = $costplan_data['zh_pname'];
                        }
						if($costplan_data){
							if($costplan_data['price']>0 || $costplan_data['price1']>0){
								$yh = 1;
								$order_pay1 = array(
									'oid'=>$order_id,
									'feename' => $costplan_data['feename'],
									'money' => $costplan_data['price'] * $yh,
									'money1' => $costplan_data['price1'] * $yh,
									'addtime' =>$time,
									'adduid' =>UID,
									'paytype' =>$dentist['paytype'],
									'planid' =>$costplan_data['planid'],
									'plansubid' =>$costplan_data['plansubid'],
									'note' =>$costplan_data['feename'] .$pt,
								);
							}else{
								$order_pay1 = array(
									'oid'=>$order_id,
									'feename' => $costplan_data['feename'],
									'money' => $costplan_data['price'] ,
									'money1' => $costplan_data['price1'],
									'addtime' =>$time,
									'adduid' =>UID,
									'state' =>1,
									'paytype' =>$dentist['paytype'],
									'planid' =>$costplan_data['planid'],
									'plansubid' =>$costplan_data['plansubid'],
									'note' =>$costplan_data['feename'] .$pt,
								);
							}
							$opid1 = $order_pay_mod->add($order_pay1);
							if(empty($opid1)){
								$this->json_error(L('S_TASK_CW_ERROR_5'));
							}
						}
					}
				}
			}
			//特殊因素
            if($mmodel!='mouth_scan'){
                $cost_data = M('Costele')->where(array('stuid'=>$stuid,'code'=>$mmodel))->find();
                if(!empty($cost_data) && ($cost_data['price']>0 || $cost_data['price1']>0)){
                    $order_pay1 = array(
                        'oid'=>$order_id,
                        'feename' => $cost_data['ename'],
                        'money' => $cost_data['price'],
                        'money1' => $cost_data['price1'],
                        'addtime' =>$time,
                        'adduid' =>UID,
                        'paytype' =>$dentist['paytype'],
                        'eleid' =>$cost_data['eleid'],
                        'note' =>$cost_data['ename'].'-特殊因素',
                    );
                    $opid1 = $order_pay_mod->add($order_pay1);
                    if(empty($opid1)){
                        $this->json_error(L('S_TASK_CW_ERROR_5'));
                    }
                }
            }

            if($mmodel=='silica_gel'){//生成实物接受任务
                $tname = '订单'.$order_sn.'口内硅胶模型待接收';
                $tid = Order::add_task(array('oid' => $order_id, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_SW', 'isurgent'=>$isurgents,'uid' => '' ,'note'=>$tname));
            }elseif($mmodel=='plaster_scan'){
			    $tname = '订单'.$order_sn.'口内石膏模型待接收';
                $tid = Order::add_task(array('oid' => $order_id, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_SW', 'isurgent'=>$isurgents,'uid' => '' ,'note'=>$tname));
            }else{//生成设计师任务
			    $tname = '订单'.$order_sn.'资料以完善待分派设计师';
                $tid = Order::add_task(array('oid' => $order_id, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_SJS', 'isurgent'=>$isurgents,'uid' => $designer['uid'] ,'note'=>$tname));
            }
            $m = M("OrderPay")->where("oid=".$order_id)->sum('money');
            $m1 = M("OrderPay")->where("oid=".$order_id)->sum('money1');
            M("Order")->where("order_id=".$order_id)->save(array('amount'=>$m,'amount1'=>$m1));
			if (!empty($order_id) && !empty($extid) && !empty($ext1id)&&!empty($tid)) {
				//log
				M('OrderLog')->add(array('oid'=>$order_id,'uid'=>UID,'addtime'=>time(),'state'=>Order::SUBMITTED));
				action_log_new(array('outtype' => 'ot_order', 'outkey' => $order_id, 'action' => 'add', 'comment' => ''));
				$Model->commit(); // 成功则提交事务
				if($dentist['paytype']){//月结
					$url = U('Order/view?id='.$order_id);
				}else{//现付
					$url = U('Cash/index?id='.$order_id);
				}
				$this->json_success($url,false);
			} else {
				$Model->rollback(); // 否则将事务回滚
				$this->json_error(L('ADD_ERROR'),false);
			}
		}else{
			$type = I('get.type',0);
			if(empty($type)){
				$this->error(L('P_SELECT_SERVICE'),U('order/index'));
			}
			//加工方式
			$processing_modem = M('Dictionary')->where("d_code = 'feeitem' and d_del = 0")->order('d_order asc')->select();
			$this->assign('processing_modem',$processing_modem);
			//服务方案-普通
			if(getlange()){
				$field = "en_pname as pname";
				$field1 = "en_name as pname";
			}else{
				$field = "zh_pname as pname";
				$field1 = "zh_name as pname";
			}
			$costplan = M('Costplan')->field('*,'.$field)->where(array('type'=>'0','servicetype'=>'10','stuid'=>$stuid))->select();
			$this->assign('costplan',json_encode($costplan));
			if(empty($costplan)){
				$this->error(L('NOT_COSPLAN_ADD'),U('Order/index'));
			}
			//服务方案-其他
			$costplan1 = M('Costplan')->field('*,'.$field)->where(array('type'=>'1','servicetype'=>'10','stuid'=>$stuid))->select();
			$this->assign('costplan1',json_encode($costplan1));
			//牙医信息
			$dentist = M('Dentist')->where('uid='.UID)->find();
			$this->assign('dentist', json_encode($dentist));
			//邮寄地址
			$addr = M('Addess')->where('isdefault = 1 and uid = '.UID)->find();
			$this->assign('addr_id', $addr['addr_id']);
			$this->assign('addr', json_encode($addr));
			//修复体
			$isxft = M('Dictionary')->where("d_code = 'isxft' and d_del = 0")->order('d_order asc')->select();
			$this->assign('isxft', $isxft);
			//牙周炎
			$isyzy = M('Dictionary')->where("d_code = 'isyzy' and d_del = 0")->order('d_order asc')->select();
			$this->assign('isyzy', $isyzy);
			//牙齿松动
			$issd = M('Dictionary')->where("d_code = 'issd' and d_del = 0")->order('d_order asc')->select();
			$this->assign('issd', $issd);
			//上部修复方式
			$repairtype = M('Dictionary')->where("d_code = 'repairtype' and d_del = 0")->order('d_order asc')->select();
			foreach($repairtype as $key=>$vo){
				$repairtype[$key]['d_value']= L($vo['d_value']);
			}
			$this->assign('repairtype', json_encode($repairtype));
			//口内模型
			$mmodel = M('Dictionary')->where("d_code = 'mmodel' and d_del = 0")->order('d_order asc')->select();
			foreach($mmodel as $key=>$vo){
				$mmodel[$key]['d_value']= L($vo['d_value']);
			}
			if(empty($mmodel)){
				$this->success(L('NOT_MMODEL_ADD'),U('Order/index'));
			}
			$this->assign('mmodel', json_encode($mmodel));
			//种植体
            $plants = M('PlantingSys')->field("*,$field1")->select();
            $this->assign('plants', json_encode($plants));
            //工具
            $tools = M('tool')->field("*,$field1")->select();
            $this->assign('tools', json_encode($tools));
            //获取工作室code
			$code = M('Studio')->where('stuid='.$stuid)->getfield('code');
			$this->assign('code', $code);
			//获取订单
			$sn = $this->getCode(get_nickname(UID));
			$this->assign('sn', $sn);
			$this->display();
		}
	}
	
	//异步上传图片
	public function uploadPic($files = "")
	{
		$sn = I('get.sn','');
		$c = C('PICTURE_UPLOAD');
		$type = I('get.type');
		$uploader = new \Think\Upload($c);// 实例化上传类
		$method = $_SERVER["REQUEST_METHOD"];
		if ($method == "POST") {
			header("Content-Type: text/plain");
			if($files===''){
				$files  =   $_FILES;
			}
			$info = $uploader->upload($files);
			$path = $c['rootPath'] . $info['qqfile']['savepath'] . $info['qqfile']['savename'];
			$name = $info['qqfile']['name'];
			$file['name'] = $name;
			$file['savepath'] = $path;
			$file['ext'] = $info['qqfile']['ext'];
			$file['size'] = $info['qqfile']['size'];
			$file['uid'] = UID;
			$file['addtime'] = time();
			$file['path'] = $info['qqfile']['savepath'] . $info['qqfile']['savename'];
			$file['uname'] = get_nickname(is_login()) ? get_nickname(is_login()) : get_username(is_login());
			$fileid = M('File')->add($file);
			if($fileid){
				$oss_path=str_replace($c['rootPath'], '', $path);
				$data = array(
					'order_sn' => $sn,
					'file_id' => $fileid,
					'ftype' => strtoupper($type),
					'addtime' => time(),
					'uid' => UID,
					'oss_path' => $oss_path,
				);
				M('OrderFile')->add($data);
			}
			$result['success'] = true;
			$result['uploadName'] = $path;
			echo json_encode($result);
		} else {
			header("HTTP/1.0 405 Method Not Allowed");
		}
		
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
						'ftype' => strtoupper($type),
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
	
	public function delete_file(){
		$order_sn = I('get.sn','');
		if($order_sn){
			$order_file = M('OrderFile')->where("order_sn = '{$order_sn}'")->select();
			if($order_file){
				foreach($order_file as $item){
					/*$f = $item['oss_path'] ;
					if($f){
						$e=oss_exist_object($f);
						if(!$e){
							$this->json_error('删除失败1',false);
						}
						
						$res = oss_delet_object($f);
						
						if($res['status']) {
							$e=oss_exist_object($f);
							if($e){
								$this->json_error('删除失败2',false);
							}
							
						}else{
							$this->json_error($res['msg']);
						}
					}*/
					$res1 = M('File')->where('fileid = '.$item['file_id'])->delete();
					if($res1 === false){
						$this->json_error('删除失败',false);
					}
				}
				$re2 = M('OrderFile')->where("order_sn = '{$order_sn}'")->delete();
				if($re2 === false){
					$this->json_error('删除失败2',false);
				}
			}
		}
		$this->json_success();
	}
	public function file_info1($oid){
		$files  =  M('OrderFile')->alias('of')->field('f.*')->join('ot_file f on f.fileid = of.file_id')->where('of.oid = '.$oid)->select();
		$newdata = array();
		foreach($files as $key=> $vo){
			if($vo['path']){
				$paths = explode('/',$vo['path']);
				$count = count($paths);
				if($count == 1){
					$newdata[]=array(
						'size' =>  format_bytes($vo['size']),
						'uname' => $vo['uname'],
						'ext' =>  $vo['ext'],
						'name' =>  $vo['name'],
					);
				}elseif($count == 2){
					$newdata[$paths[0]]['path'] = $paths[0];
					$newdata[$paths[0]]['item'][] = array(
						'size' =>  format_bytes($vo['size']),
						'uname' => $vo['uname'],
						'ext' =>  $vo['ext'],
						'name' =>  $vo['name'],
					);
				}elseif($count == 3) {
					$newdata[$paths[0]]['path'] = $paths[0];
					$newdata[$paths[0]]['item'][$paths[1]]['path'] =$paths[1];
					$newdata[$paths[0]]['item'][$paths[1]]['item'][] = array(
						'size' => format_bytes($vo['size']),
						'uname' => $vo['uname'],
						'ext' => $vo['ext'],
						'name' => $vo['name'],
					);
				}
			}
		}
		return $newdata;
	}
	
	//工作室ID
	public function get_stuid($uid){
		$user = M('Member')->where("uid=".$uid)->find();
		return $user['stuid'];
	}

	//诊所id
	public function get_denid($uid){
        $Dentist = M('Dentist')->where("uid=".$uid)->find();
        return $Dentist['denid'];
    }
	
	//获取订单sn
	public function getCode($str){
		//删除24小时前的无用订单号
		M('OrderCode')->where(array('ifuse'=>0,'addtime'=>array('ELT',time()-24*60*60)))->delete();
		$code = '';
		if(preg_match('/[a-zA-Z ]/', $str)){
			$arr = explode(' ',$str);
			foreach($arr as $vo){
				$code .= $vo[0];
			}
		}else{
			$code =pinyin($str, $ret_format = 'first', $placeholder = '');
		}
		$code = strtoupper($code).rand(100000,999999);
		$temp = M('OrderCode')->where('code='.$code)->count();
		if($temp){
			$this->getCode($str);
		}
		$res = M('OrderCode')->add(array('code'=>$code,'addtime'=>time()));
		if($res){
			return $code;
		}else{
			$this->getCode($str);
		}
		return $code;
	}

	//订单详情
    public function view(){
	    $stuid = $this->get_stuid(UID);    // 工作室id
        $id = empty($_GET['id'])?0:$_GET['id'];//订单id
        $info = $this->model
            ->alias('o')
            ->join("ot_order_ext ext on ext.oid = o.order_id")
            ->where("order_id=".$id)->find();
        if($info['sevicetype']=='PLANT'){
            $info_item = M('order_ext1')->where("oid=".$id)->find();
        }else{
            $info_item = M('order_ext2')->where("oid=".$id)->find();
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
        $sql="select planid from ot_order_pay where oid='{$id}' and planid !=0  group by planid";
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
            
	        if(getlange()){
		        $field = "ps.en_name as surname";
		        $field1 = "t.en_name as surname1";
	        }else{
		        $field = "ps.zh_name as surname";
		        $field1 = "t.zh_name as surname1";
	        }
            //种植订单明细
            $orderext1=M("OrderExt1")
	            ->alias("o")
	            ->field("o.*,d1.d_value as xft,d2.d_value as yzy,d3.d_value as sd,d4.d_value as rt,d5.d_value as knmx,$field,$field1")
	            ->join("left join ot_dictionary d1 on d1.d_key=o.isxft and d1.d_code='isxft'")
                ->join("left join ot_dictionary d2 on d2.d_key=o.isyzy and d2.d_code='isyzy'")
                ->join("left join ot_dictionary d3 on d3.d_key=o.issd and d3.d_code='issd'")
                ->join("left join ot_dictionary d4 on d4.d_key=o.repairtype and d4.d_code='repairtype'")
                ->join("left join ot_dictionary d5 on d5.d_key=o.mmodel and d5.d_code='mmodel'")
                ->join("left join ot_planting_sys ps on ps.id= o.surgerysystem")
                ->join("left join ot_tool t on t.id = o.surgerytool")
                ->where("o.oid='{$id}'")
	            ->find();
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
        $fees = M('order_pay')->alias('p')
            ->join("ot_pay_log log on log.subid = p.opid",'left')->where("p.oid=".$id)->select();

        //订单扩展信息
        $orderext=M("OrderExt")->where("oid='{$id}'")->field("*")->find();
        $this->assign('orderext',$orderext);
        $this->assign('info',$info);
	    //获取工作室code
	    $code = M('Studio')->where('stuid='.$stuid)->getfield('code');
	    $this->assign('code', $code);
        $this->display($temp);
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
		    ->limit ("$row,20")
		    ->order('file_id asc')
		    ->select ();
	    foreach($files as $k => $v){
		    $files[$k]['ftype']= L($v['ftype']);
	    }
	    $this->assign('files',$files);
	    $stuid = $this->get_stuid(UID);    // 工作室id
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

    //确认方案
    public function confirm(){
        $id = empty($_GET['id'])?0:$_GET['id'];//订单id
        if(empty($id)){
            $this->error(L('ORDER_EMPTY'));
        }
        $order = M("Order")->where("order_id = ".$id)->find();
        if(empty($order)){
            $this->error(L('ORDER_EMPTY'));
        }
        if($order['state']!=Order::UPLOADED){
            $this->error(L('ORDER_CONFIRM_ERROR'));
        }
        $Model = M(); // 实例化一个空对象
        $Model->startTrans(); // 开启事务
        //写入订单操作记录
        $content = sprintf(L("TASK_CONFIRM_MSG"),$order['dename'],$order['order_sn']);
        $log_id = Order::action_order_log(array('oid' => $id, 'uid' =>'', 'addtime' => '', 'state' => Order::CONFIRMED ,'note'=>$content));
        //更改订单状态
        $result = M('Order')->where("order_id=".$id)->save(array('state'=>Order::CONFIRMED));
        if($log_id&&$result){
            $Model->commit(); // 成功则提交事务
            $this->success(L('TASK_CONFIRM_SUC'), U('index'));
        }else{
            $Model->rollback(); // 否则将事务回滚
            $this->error(L('TASK_CONFIRM_ERROR'));
        }
    }

    //方案变更
    public function change(){
        $id = empty($_GET['id'])?0:$_GET['id'];//订单id
        if(empty($id)){
            $this->error(L('ORDER_EMPTY'));
        }
        $order = M("Order")->where("order_id = ".$id)->find();
        if(empty($order)){
            $this->error(L('ORDER_EMPTY'));
        }
        if($order['state']<Order::CONFIRMED || $order['state']>Order::SHIPPED){
            $this->error(L('ORDER_CHANGE_ERROR'));
        }
        $Model = M(); // 实例化一个空对象
        $Model->startTrans(); // 开启事务
        $cost = M('Costele')->where("code='change_cost'")->find();
        $feename = '';
        $money = 0;
        $money1=0;
        if(!empty($cost)){
            $feename = $cost['ename'];
            if($cost['type']==1){
                $money = $cost['price'];
                $money1 = $cost['price1'];
            }elseif($cost['type']==0){
                $money = $order['amount']*$cost['percent']/100;
                $money1 = $order['amount1']*$cost['percent']/100;
            }
        }
            $pay_type = Order::get_dent_paytype($id);
            $order_pay = array(
                'oid'=>$id,
                'feename' =>$feename ,
                'money' => $money,
                'money1' => $money1,
                'addtime' =>NOW_TIME,
                'adduid' =>UID,
                'paytype' =>$pay_type,
                'note'=>L('TASK_CHANGE_ADD_FEE'),
                'eleid'=>$cost['eleid']
            );
            $opid = M('OrderPay')->add($order_pay);
            if(empty($opid)){
                $this->error(L('TASK_CHANGE_ADD_FEE_ERROR'));
            }
            $m = M("order_pay")->where("oid=".$id)->sum('money');
            $m1 = M("order_pay")->where("oid=".$id)->sum('money1');
            $data = array();
            $data['amount'] = $m;
            $data['amount1'] = $m1;
            $data['state'] = Order::ASSIGNED;
            $data['canupplan'] = 0;
            $data['haschange'] = $order['haschange']+1;
            $result = M("Order")->where("order_id=".$id)->save($data);
            //给设计师发消息
            $title = sprintf(L('TASK_CHANGE_SJS_MSG'),$order['order_sn']);
            $content =sprintf(L('TASK_CHANGE_SJS_MSG_1'),$order['dename'],$order['order_sn']);
            $msg_id = Order::action_msg_log(array('fromid' => '', 'toid' =>$order['designer'], 'addtime' => '','title' => $title,'content' => $content, 'outtype' => 'client_order' ,'outkey'=>$id));
            //重新给设计师任务
            $tname = sprintf(L('TASK_CHANGE_SJS_MSG_2'),$order['order_sn']);
            $tid = Order::add_task(array('oid' => $order['order_id'], 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_SJS', 'isurgent'=>$order['isurgent'], 'uid' => $order['designer'] ,'note'=>$tname));

            //写入订单操作记录
            $content = sprintf(L("TASK_CHANGE_MSG"),$order['dename'],$order['order_sn']);
            $log_id = Order::action_order_log(array('oid' => $id, 'uid' =>'', 'addtime' => '', 'state' => $order['state'] ,'note'=>$content));
            if($msg_id&&$log_id&&$tid&&$result!==false){
                $Model->commit(); // 成功则提交事务
                $this->success(L('TASK_CHANGE_SUC'), U('index'));
            }else{
                $Model->rollback(); // 否则将事务回滚
                $this->error(L('TASK_CHANGE_ERROR'));
            }
    }
    //确认收货
    public function confirm_goods(){
        if(IS_POST){
            $id=!isset($_POST['id'])?0:intval($_POST['id']);
            if(empty($id)){
                $this->error(L('Data_not_exist'));
            }
            $order = M("Order")->where("order_id=".$id)->find();
            if(empty($order)){
                $this->error(L('Data_not_exist'));
            }
            if($order['state']!=Order::SHIPPED){
                $this->error(L('STATE_NOT_CONFIRM'));
            }
            $data = array(
                'state'=>Order::RECEIVED,
                'receipttime'=>NOW_TIME
            );
            $result = M("Order")->where("order_id=".$id)->save($data);
            $content = sprintf(L('CONFIRM_GOODS_MSG'),$order['dename'],$order['order_sn']);
            //写入订单操作记录
            $log_id = Order::action_order_log(array('oid' => $id, 'uid' =>'', 'addtime' => '', 'state' => Order::RECEIVED ,'note'=>$content));
            if($result===false){
                $this->error(L('SEND_ERROR'));
            }else{
                $this->success(L('SEND_SUC'),U('Order/view?id='.$id));
            }
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
            $content = sprintf(L('CLOSE_ORDER_CLIENT_MSG'),$order['dename'],$order['order_sn']);
            //写入订单操作记录
            $log_id = Order::action_order_log(array('oid' => $id, 'uid' =>'', 'addtime' => '', 'state' => Order::CLOSE ,'note'=>$content));
            if($result===false){
                $this->error(L('CLOSE_ERROR'));
            }else{
                $this->success(L('CLOSE_SUC'),U('Order/view?id='.$id));
            }
        }
    }

    //获取订单金额
	public function get_order_amount(){
		$processing_modem = I('post.processing_modem','');
		$costplan = I('post.costplan','');
		$costplan1 = I('post.costplan1','');
		$mmodel = I('post.mmodel','');
		$stuid = $this->get_stuid(UID);
		//人民币价格
		$price = 0;
		//美元价格
		$price1 = 0;
		//普通服务
		$costplan_mod = M('Costplan');
		$modem_count = count($processing_modem);
		foreach($processing_modem as $vo){
			$costplan_data = $costplan_mod->alias('c')->join('ot_costplan_sub cs on cs.planid = c.planid ')->where(array('c.planid'=>$costplan,'cs.feecode' => $vo['key']))->find();
			if($costplan_data){
				$yh = 1;
				if($costplan_data['discount'] && $modem_count>1){
					$yh = $costplan_data['discount']/100;
				}
				$price +=$costplan_data['price']* $yh;
				$price1 +=$costplan_data['price1']* $yh;
			}
			
		}
		//特殊服务
		$costplan1 = array_filter($costplan1);
		if($costplan1){
			foreach($processing_modem as $vo){
				foreach($costplan1 as $v){
					$costplan_data = $costplan_mod->alias('c')->join('ot_costplan_sub cs on cs.planid = c.planid ')->where(array('c.planid'=>$v['key'],'cs.feecode '=>$vo['key']))->find();
					$price +=$costplan_data['price'];
					$price1 +=$costplan_data['price1'];
				}
			}
		}
		//特殊因素
		if($mmodel!='mouth_scan'){
			$cost_data = M('Costele')->where(array('stuid'=>$stuid,'code'=>$mmodel))->find();
			if(!empty($cost_data) && ($cost_data['price']>0 || $cost_data['price1']>0)){
				$price +=$cost_data['price'];
				$price1 +=$cost_data['price1'];
			}
		}
		$this->json_success(array('price'=>$price,'price1'=>$price1));
	}
	//模板下载
	public function  file_download(){
		if(I('type',0) ==1){
			$file=fopen('download/kxjpg.jpg',"r");
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Accept-Length: ".filesize('./download/ct.rar'));
			header("Content-Disposition: attachment; filename= kxjpg.jpg");
			echo fread($file,filesize('download/kxjpg.jpg'));
			fclose($file);
		}else{
			$file=fopen('download/ct.rar',"r");
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Accept-Length: ".filesize('./download/ct.rar'));
			header("Content-Disposition: attachment; filename= ct.rar");
			echo fread($file,filesize('download/ct.rar'));
			fclose($file);
		}
	}
	//文档下载
	public function  file_download1(){
		$fileid = I('fileid',0);
		$files = M('File')->alias('f')->field('of.alyfile,of.oss_file,f.savepath,f.name')->join('ot_order_file of on of.file_id =f.fileid','left')->where('f.fileid='.$fileid)->find();
		if($files['alyfile']){
		
		}else{
			$file=fopen($files['savepath'],"r");
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Accept-Length: ".filesize($files['savepath']));
			header("Content-Disposition: attachment; filename= ".$files['name']);
			echo fread($file,filesize($files['savepath']));
			fclose($file);
		}
	}


    //获取患者信息
    public function get_pname(){
        $pname = I('get.pname','');
        if($pname){
        	$denid = M('Dentist')->where('uid='.UID)->getfield('denid');
            $data = M('Patient')->field('realname,birthday,gender')->where("denid = {$denid} and realname like '%{$pname}%'")->select();
            if($data){
            	foreach($data as $k => $v){
		            $data[$k]['birthday'] = date('Y/m/d',$v['birthday']);
				}
				echo json_encode(array('done'=>true,'retval'=>$data));
            }else{
				echo json_encode(array('done'=>false,'retval'=>$data));
            }
        }else{
            $this->json_error();
        }
    }
}


