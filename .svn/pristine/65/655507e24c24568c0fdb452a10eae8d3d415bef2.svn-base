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
 * 费用因素
 */
class CosteleController extends AdminController
{
    private $model;

    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Costele');    // 收费项目Model
    }

    /**
     *收费项目管理首页
     */
    public function index()
    {
        $stuid = Order::get_stuid(UID);   // 工作室id
    	if(IS_POST){
    		$edis = (array)I('eleid',0);
    		$percent = (array)I('percent',0);
    		$type = (array)I('type',0);
    		$price = (array)I('price',0);
    		$price1 = (array)I('price1',0);
    		foreach($edis as $k =>$v){
    			if($type[$k] == 1){
				    $data = array(
					    'eleid' => $v,
					    'stuid'=>$stuid,
					    'percent' => 0,
					    'type' => $type[$k],
					    'price' => $price[$k],
					    'price1' => $price1[$k],
                        'uid'=>UID,
                        'addtime'=>NOW_TIME
				    );
			    }else if($type[$k] == 0){
				    $data = array(
					    'eleid' => $v,
                        'stuid'=>$stuid,
					    'percent' => $percent[$k],
					    'type' => $type[$k],
					    'price' => 0,
					    'price1' => 0,
                        'uid'=>UID,
                        'addtime'=>NOW_TIME
				    );
			    }
			    $this->model->save($data);
			    $history = array();
			    $lists = $this->model->where(array('eleid'=>$v,'stuid'=>$stuid))->find();
			    foreach ($data as $key => $vo) {
				    if ($vo != $lists [$key]) {
					    $history [] = array(
						    'field' => $key,
						    'olddata' => $lists [$key],
						    'newdata' => $vo
					    );
				    }
			    }
			    if($history){
                    $data['uid'] = UID;
			    	$data['uid'] = UID;
			    	$data['addtime'] = time();
				    $this->model->save($data);
				    action_log_new(array('history'=>$history, 'outtype' => 'ot_studio', 'outkey' => $v, 'action' => 'edit', 'comment' => ''));
			    }
		    }
		    $this->redirect('Costele/index');
	    }else{
		    $dic = M('Dictionary')->where("d_code= 'costele'")->order('d_order asc')->select();
		    $list =  $this->model->where("stuid=".$stuid)->select();
		    if($dic){
			    foreach($dic as $d){
				    $z = true;
				    $ename =  $d['d_value'];
				    $code =  $d['d_key'];
				    if(!empty($list)){
                        foreach($list as $l){
                            if($ename == $l['ename']){
                                $z = false;
                            }
                        }
                    }

				    if($z){
					    $tmp = $this->model->where("(ename = '{$ename}' or code = '{$code}') && stuid={$stuid}")->count();
					    if(empty($tmp)){
						    $data = array(
                                'stuid'=>$stuid,
							    'ename' => $d['d_value'],
							    'code' => $d['d_key'],
						    );
						    $this->model->add($data);
					    }
				    }
			    }
			    $list =  $this->model->where("stuid=".$stuid)->select();
		    }
		    $this->assign('lists', $list);
		    $this->display();
	    }
    }

}
