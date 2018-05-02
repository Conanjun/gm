<?php

namespace Studio\Controller;
use Think\Page;
use Common\Common\Super\Order;
/**
 * 任务管理-设计师：fhc
 *
 */
class OrderTaskSjsController extends AdminController
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
        $uid = UID;
        $where = "1=1 and t.uid = {$uid} and t.tasktype = 'STUDIO_TASK_SJS' ";

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
	        //获取版本号
	        $vid = M('OrderFile')->where("oid = {$list['order_id']} and ftype = 'pro'")->order('addtime desc')->getField('vid');
	        empty($vid)?$vid = 1: $vid = $vid+1;
	        $lists[$key]['vid'] = $vid;
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
        	$vid= I('post.vid',0);
            $finishnote = empty($_POST['finishnote']) ? '' : trim($_POST['finishnote']);
            if(Order::checkorder($order_id)==0){
                $this->error(L('S_TASK_ERROR_1'));
            }
            $order = M("order")->where("order_id=".$order_id)->find();
            $task = M("order_task")->where("tastkid=".$task_id)->find();
            if($task['uid'] != UID){
                $this->error(L('S_TASK_SJS_MSG_3'));
            }
            if($task['uid'] == 0){
                $this->error(L('S_TASK_SJS_MSG_4'));
            }
            if($order['state'] < Order::ASSIGNED){
                $this->error(L('S_TASK_SJS_ERROR_1'));
            }

            if($order['canupplan'] !=1){
                $this->error(L('S_TASK_SJS_ERROR_2'));
            }

            $Model = M(); // 实例化一个空对象
            $Model->startTrans(); // 开启事务

            //上传方案
	        $order_file = M('OrderFile')->where(array('order_sn'=>$order['order_sn'],'vid'=>$vid))->save(array('oid'=>$order_id));
	        if(empty($order_file)){
		        $this->error(L('S_TASK_SJS_MSG_2'));
	        }

            //修改完成人和说明
            $res_data = array(
                'tastkid'=>$task_id,
                'finishnote'=>$finishnote,
                'finishtime'=>$time,
                'finishuid'=>UID,
                'state'=>1
            );
            $res = M('Order_task')->save($res_data);

            //给客户发消息
            $title = sprintf(L('S_TASK_TASK_PROMPT_1'),$order['order_sn']);
            $content = sprintf(L('S_TASK_TASK_PROMPT_5'),$order['stuname'],$order['order_sn'],L('UPLOADED'));
            $msg_id = Order::action_msg_log(array('fromid' => '', 'toid' =>$order['uid'], 'addtime' => $time,'title' => $title,'content' => $content, 'outtype' => 'client_order' ,'outkey'=>$order_id));

            //生成财务任务
            $tname = sprintf(L('S_TASK_TASK_PROMPT_14'),$order['order_sn']);
            $tid = Order::add_task(array('oid' => $order_id, 'tname' =>$tname, 'tasktype' => 'STUDIO_TASK_CW', 'isurgent'=>$order['isurgent'], 'uid' => '' ,'note'=>$tname));

            //写入订单操作记录
            $log_id = Order::action_order_log(array('oid' => $order_id, 'uid' =>$order['uid'], 'addtime' => $time, 'state' => Order::UPLOADED ,'note'=>$finishnote));

            //更改订单状态
            $result = M('Order')->where("order_id=".$order_id)->save(array('state'=>Order::UPLOADED));

            //写入订单操作记录，修改订单状态 设计资料已接收

            if($msg_id&&$log_id&&$tid&&$result&&$res){
                $Model->commit(); // 成功则提交事务
                $this->success(L('S_TASK_SJS_SUC'), U('index'));
            }else{
                $Model->rollback(); // 否则将事务回滚
                $this->error(L('S_TASK_SJS_ERROR'));
            }

        }
    }
	//异步上传文件
	public function fnUploadFile()
	{
		$type = I('get.type','pro');
		$oid = I('get.oid',0);
		$vid = I('get.vid',0);
		//获取订单号
		$order = M('Order')->field('order_sn,stuid')->where('order_id='.$oid)->find();
		//获取工作室code
		$code = M('Studio')->where('stuid='.$order['stuid'])->getfield('code');
		$time = time();
		$sn = $order['order_sn'] ;
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
								$parentid = M('OrderFile')->add(array('order_sn' => $sn, 'ftype' => $type, 'path' => $path[$i], 'addtime' => $time, 'grade' => $i,'vid'=>$vid));
							}
						}else{
							$paid = M('OrderFile')->where("order_sn = '{$sn}' and ftype = '{$type}' and path = '{$path[$j]}' and grade = {$j} and vid= {$vid}")->getField('fid');
							$parentid = M('OrderFile')->where("order_sn = '{$sn}' and ftype = '{$type}' and path = '{$path[$i]}' and grade = {$i} and vid= {$vid}")->getField('fid');
							if (empty($parentid)) {
								$parentid = M('OrderFile')->add(array('order_sn' => $sn, 'ftype' => $type, 'path' => $path[$i], 'addtime' => $time, 'grade' => $i,'vid'=>$vid,'parent'=>$paid));
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
					$parentid = M('OrderFile')->add(array('order_sn' => $sn, 'ftype' => $type, 'path' => 'cbct', 'addtime' => $time));
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
}
