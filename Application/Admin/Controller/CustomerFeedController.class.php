<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;

/**
 * 客户意见反馈控制器
 */
class CustomerFeedController extends AdminController {
	private $model;
	
	// 构造函数
	public function __construct() {
		parent::__construct ();
		$this->model = D ( 'CustomerFeed' ); 
	}
	
	/**
	 * 后台字典管理首页
	 */
	public function index() {
		$where = " 1=1 ";
		$filter = '';
		$name = I("get.name","");
		$name && $filter .= " and (od.name like '%{$name}%')";
		
		$sname=I("get.sname","");
		$sname && $filter .= " and os.name like '%{$sname}%' ";
		
		$state=I("get.state","");
		if($state!==""){
			$filter .= " and f.state = '{$state}' ";
		}
		
		$servicetype=I("get.type","");
		$servicetype && $filter .= " and f.type = '{$servicetype}' ";
		
		$addtime_from=I("get.addtime_from","");
		$addtime_to=I("get.addtime_to","");
		$backtime_from=I("get.backtime_from","");
		$backtime_to=I("get.backtime_to","");
		
		$addtime_from && $filter .= " and f.addtime >= '".strtotime($addtime_from)."' ";
		$addtime_to && $filter .= " and f.addtime <= '".strtotime($addtime_to)."' ";
		$backtime_from && $filter .= " and f.backtime >= '".strtotime($backtime_from)."' ";
		$backtime_to && $filter .= " and f.backtime <= '".strtotime($backtime_to)."' ";
		
		$where .= $filter;
		
		// 更新排序
		if (isset ( $_GET ['sort'] ) && isset ( $_GET ['order'] )) {
			$sort = strtolower ( trim ( $_GET ['sort'] ) );
			$order = strtolower ( trim ( $_GET ['order'] ) );
			if (! in_array ( $order, array (
					'asc',
					'desc' 
			) )) {
				$sort = 'f.addtime';
				$order = 'desc';
			}
		} else {
			$sort = 'f.addtime';
			$order = 'desc';
		}
		
		$count = $this->model->countNum ( $where );
		$page = new \Think\Page ( $count, 20 );
		$lists = $this->model->join("left join ot_dictionary d on d.d_key=f.state and d.d_code='feed_status'")
		->join("left join ot_dictionary d1 on d1.d_key=f.type and d1.d_code='feed_type'")
		->join("left join ot_member m on m.uid=f.uid")
		->join("left join ot_studio os on os.stuid=f.stuid")
		->join("left join ot_dentist od on od.denid=f.denid")
		->alias ( 'f' )->where ( $where )->order ( "$sort $order" )->field ( "f.*,d.d_value,d1.d_value as ftype,m.nickname,os.name as sname,od.name as name" )
		->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		
		// var_dump($this->model->getLastSql());
		if($lists){
			foreach ($lists as $k=>$v){
				$lists[$k]["d_value"]=L($v["d_value"]);
				$lists[$k]["ftype"]=L($v["ftype"]);
			}
		}
		
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$this->assign ( 'lists', $lists );
		$this->assign ( '_page', $page->show () );
		$this->assign ( 'filtered', $filter ? 1 : 0 ); // 是否有查询条件
		
		$sl = M ( "Dictionary" )->field ( "d_key,d_value" )->where ( "d_code='feed_status'" )->order ( "d_order asc" )->select ();
		if($sl){
			foreach ($sl as $k=>$v){
				$sl[$k]["d_value"]=L($v["d_value"]);
			}
		}
		$this->assign ( 'feed_status', $sl );
		
		$st = M ( "Dictionary" )->field ( "d_key,d_value" )->where ( "d_code='feed_type'" )->order ( "d_order asc" )->select ();
		if($st){
			foreach ($st as $k=>$v){
				$st[$k]["d_value"]=L($v["d_value"]);
			}
		}
		$this->assign ( 'feed_type', $st );
		
		$this->display ();
	}
	
	public function view(){
		$id=I("get.id","");
		if(empty($id)){
			$this->error(L('Data_not_exist'));
		}
		
		$info=$this->model->join("left join ot_dictionary d on d.d_key=f.state and d.d_code='feed_status'")
		->join("left join ot_dictionary d1 on d1.d_key=f.type and d1.d_code='feed_type'")
		->join("left join ot_member m on m.uid=f.uid")
		->join("left join ot_member m1 on m1.uid=f.backuid")
		->join("left join ot_studio os on os.stuid=f.stuid")
		->join("left join ot_dentist od on od.denid=f.denid")
		->alias ( 'f' )->where ( "f.id='{$id}'" )->field ( "f.*,d.d_value,d1.d_value as ftype,m.nickname,os.name as sname,od.name as name,m1.nickname as snickname" )
		->find ();
		
		if(empty($info)){
			$this->error(L('Data_not_exist'));
		}
		
		$info["d_value"]=L($info["d_value"]);
		$info["ftype"]=L($info["ftype"]);
		
		$this->assign('info',$info);
		$this->display();
	}
	
}
