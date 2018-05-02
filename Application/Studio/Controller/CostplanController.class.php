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
 * 工作室 收费项目管理控制器 : LGW
 */
class CostplanController extends AdminController
{
    private $model;

    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Costplan');    // 收费项目Model
    }

    /**
     *收费项目管理首页
     */
    public function index()
    {
    	$stuid = Order::get_stuid(UID);   // 工作室id
        $where = " 1=1 and d_code = 'ser_type' and d_del =0 and stuid=".$stuid;
		$filter= '';
		$name = empty($_GET['name'])?'':trim($_GET['name']);
        $discount = empty($_GET['discount'])?'':trim($_GET['discount']);
		if($name){
			$filter .= " and p.pname like '%{$name}%'";
		}
        if($discount){
            $filter .= " and p.discount like '%{$discount}%'";
        }
        $servicetype = empty($_GET['servicetype'])?'':trim($_GET['servicetype']);//code
		if($servicetype){
			$filter .= " and  p.servicetype = {$servicetype}";
		}

		$where .= $filter;

		$count = $this->model->countNum($where);
		$page = new \Think\Page($count, 10);
		$lists = $this->model
				->alias('p')
                ->join('ot_costplan_sub s on p.planid = s.planid')
                ->join('ot_dictionary d on p.servicetype = d.d_key')
                ->field('p.planid,p.zh_pname,p.en_pname,p.discount,d.d_value,p.type')
				->where($where)
				->order("p.planid desc")
                ->group('p.planid')
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		foreach($lists as $key=>$v){
			$list = M('costplan_sub')->where(['planid'=>$v['planid']])->select();
			if(!empty($lists)){
				$lists[$key]['list'] =$list;
			}
		}
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);

        $dic = M('Dictionary')->where("d_code = 'ser_type' and d_del =0")->select();
        $this->assign('dic', $dic);

		$this->assign('_page', $page->show());
		$this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
		$this->display();
    }

    /**
     * 新增收费项目
     */
    public function add()
    {
    	 $stuid = Order::get_stuid(UID);   // 工作室id
        if (IS_POST) {
				
            $servicetype = empty($_POST['servicetype']) ? '' : trim($_POST['servicetype']);
            if(empty($servicetype)){
            	$this->error(L('PLAY_IN_SERVICE_TYPE'));
            }
            $discount = empty($_POST['discount']) ? '' : trim($_POST['discount']);
            $type = empty($_POST['type']) ? '' : $_POST['type'];
            $zh_pname = empty($_POST['zh_pname']) ? '' : trim($_POST['zh_pname']);
            $en_pname = empty($_POST['en_pname']) ? '' : trim($_POST['en_pname']);
            $feeitem = empty($_POST['feeitem']) ? '' : $_POST['feeitem'];
            $feecode = empty($_POST['feecode']) ? '' : $_POST['feecode'];
            $feename = empty($_POST['feename']) ? '' : $_POST['feename'];
			$price = empty($_POST['price']) ? 0 : $_POST['price'];
			$price1 = empty($_POST['price1']) ? 0 : $_POST['price1'];
			if(!empty($servicetype)){
                $dic = M('Dictionary')->where("d_code = 'ser_type' and d_del =0 and d_key = {$servicetype}")->find();
            }
            $count=count($feeitem);
            for($i=0;$i<$count;$i++){
                if((empty($price[$i]) && !empty($price1[$i])) || (!empty($price[$i]) && empty($price1[$i]))){
                    $this->error(L('THE_AMOUNT_IS_NOT_COMPLETE'));
                }
                if($price[$i]<0 || $price1[$i]<0){
                	$this->error(L('MONEY_NOT_ZERO'));
                	exit;
                }
            }
            $data = array(
                'servicetype' => $servicetype,
				'servicecode' => $dic['d_code'],
                'zh_pname' => $zh_pname,
                'en_pname' => $en_pname,
                'discount'=>$discount,
				'addtime' => time(),
				'adduid' => UID,
            	'type'=>$type,
            	'stuid'=>$stuid,

            );
			$planid = M('Costplan')->add($data);
            $insert_data=[];
            for($i=0;$i<$count;$i++){
                if((empty($price[$i]) && !empty($price1[$i])) || (!empty($price[$i]) && empty($price1[$i]))){
                    $this->error(L('THE_AMOUNT_IS_NOT_COMPLETE'));exit;
                }
                $insert_data[$i]['feeitem']=$feeitem[$i];
                $insert_data[$i]['feecode']=$feecode[$i];
                $insert_data[$i]['feename']=$feename[$i];
                $insert_data[$i]['price']=$price[$i];
                $insert_data[$i]['price1']=$price1[$i];
                $insert_data[$i]['addtime']=time();
                $insert_data[$i]['adduid']=UID;
                $insert_data[$i]['planid']=$planid;
            }

            if (!$planid) {
                $this->error(L('ADD_ERROR'));
            } else {
                M('Costplan_sub')->addAll($insert_data);

                $this->redirect('Costplan/index');
            }
        } else {
            //方案类型
            $dic = M('Dictionary')->where("d_code = 'ser_type' and d_del =0")->select();
            $this->assign('dic', $dic);
            //费用
            $fee = M('Feeitem')->where('isprive=1')->select();
            $this->assign('fee', $fee);

            $this->display();
        }
    }

    /**
     * 编辑收费项目
     */
    public function edit()
    {
		$id = empty($_GET['id'])?0:$_GET['id'];
        if (IS_POST) {
			$id = empty($_POST['id']) ? '' : trim($_POST['id']);
            $servicetype = empty($_POST['servicetype']) ? '' : trim($_POST['servicetype']);
            $type = empty($_POST['type']) ? '' : $_POST['type'];
            $discount = empty($_POST['discount']) ? '' : trim($_POST['discount']);
            $zh_pname = empty($_POST['zh_pname']) ? '' : trim($_POST['zh_pname']);
            $en_pname = empty($_POST['en_pname']) ? '' : trim($_POST['en_pname']);
            $plansubid = empty($_POST['plansubid']) ? '' : $_POST['plansubid'];
            $price = empty($_POST['price']) ? 0 : $_POST['price'];
            $price1 = empty($_POST['price1']) ? 0 : $_POST['price1'];
            $feeitem = empty($_POST['feeitem']) ? '' : $_POST['feeitem'];
            $feecode = empty($_POST['feecode']) ? '' : $_POST['feecode'];
            $feename = empty($_POST['feename']) ? '' : $_POST['feename'];
            if(!empty($servicetype)){
                $dic = M('Dictionary')->where("d_code = 'ser_type' and d_del =0 and d_key = {$servicetype}")->find();
                if(empty($dic)){

                }
            }

            $count=count($plansubid);
            for($i=0;$i<$count;$i++){
                if((empty($price[$i]) && !empty($price1[$i])) || (!empty($price[$i]) && empty($price1[$i]))){
                    $this->error(L('THE_AMOUNT_IS_NOT_COMPLETE'));
                    exit;
                }
                if($price[$i]<0 || $price1[$i]<0){
                	$this->error(L('MONEY_NOT_ZERO'));
                	exit;
                }
            }

            $data = array(
                'servicetype' => $servicetype,
                'servicecode' => $dic['d_code'],
                'zh_pname' => $zh_pname,
                'en_pname' => $en_pname,
                'discount'=>$discount,
                'adduid' => UID,
            	'type'=>$type,
                'planid'=>$id
            );
			
            if (D('Costplan')->save($data) === false) {
                $this->error(L('EDIT_ERROR'), U('Costplan/edit?id=' . $id));
            } else {
                $count=count($plansubid);
                for($i=0;$i<$count;$i++){
                    if($plansubid[$i] == -1){
                        $data2 = array(
                            'feeitem' => $feeitem[$i],
                            'feecode' => $feecode[$i],
                            'feename' => $feename[$i],
                            'price' => empty($price[$i]) ? 0 : $price[$i],
                            'price1' => empty($price1[$i]) ? 0 : $price1[$i],
                            'addtime' => time(),
                            'adduid' => UID,
                            'planid' => $id,
                        );
                        M('Costplan_sub')->add($data2);
                    }else{
                        $data1 = array(
                            'price' => $price[$i],
                            'price1' => $price1[$i],
                            'plansubid'=>$plansubid[$i],
                        );
                        M('Costplan_sub')->save($data1);
                    }
                }
                $this->redirect('Costplan/index');
            }
        } else {
            $id = empty($_GET['id'])?0:$_GET['id'];
            //方案类型
            $dic = M('Dictionary')->where("d_code = 'ser_type' and d_del =0")->select();
            $this->assign('dic', $dic);
            $data = M('Costplan')->where('planid ='.$id)->find();
            if (empty($data)) {
                $this->error(L('Data_not_exist'));
            }
            $data1 = M('Feeitem')->alias('f')->join('left join ot_costplan_sub s on f.itemid = s.feeitem and s.planid='.$id)
                ->field('f.itemid,f.feecode,f.feename,s.price,s.price1,s.plansubid')
                ->where('f.isprive=1')
                ->select();
            if (empty($data1)) {
                $this->error(L('Data_not_exist'));
            }
            $this->assign('data', $data);
            $this->assign('data1', $data1);
            $this->display();
        }
    }

    /*
     * 删除收费项目
     * */
    public function delete()
    {
    	$id = I('id');
    	if (!$id) {
    		$this->json_success(L('Data_not_exist'), false);
    	}
    	if (is_array($id)) {
    		$ids = $id;
    	} else {
    		$ids = (array)$id;
    	}
    	$msg = '';
    	foreach($ids as $id){
    		$where = "planid = {$id}";
    		$list =$this->model->getList($where);
    		if(empty($list)){
    			$failmsg.= "ID".$id.L("DELETE_FAILED")."<br/>";
    		}else{
    			$res = $this->model->where($where)->delete();
    			M('Costplan_sub')->where($map)->delete();
    			action_log_new(array('outtype' => 'ot_studio', 'outkey' => $id, 'action' => 'delete', 'comment' => ''));
    			$sucmsg.="{$list['zh_pname']}".'&nbsp;&nbsp;'."{$list['en_pname']}".L("DELETE_SUCCESS")."<br/>";
    		}
    	}
    	$this->json_success($failmsg.$sucmsg);
    }

}
