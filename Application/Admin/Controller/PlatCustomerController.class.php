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
 * 客户管理控制器
 */
class PlatCustomerController extends AdminController {
	private $model;
	
	// 构造函数
	public function __construct() {
		parent::__construct ();
		$this->model = D ( 'PlatCustomer' ); // 数据字典Model
	}
	
	/**
	 * 后台字典管理首页
	 */
	public function index() {
		$where = " 1=1 ";
		$filter = '';
		$name = I("get.name","");
		$name && $filter .= " and (d.tel like '%{$name}%' or d.contact like '%{$name}%')";
		
		$keys=I("get.keys","");
		$keys && $filter .= " and (d.name like '%{$keys}%' or d.realname like '%{$keys}%' or s.name like '%{$keys}%')";
		
		$state=I("get.paytype","");
		$state && $filter .= " and d.paytype = '{$state}' ";
		
		
		$enabled=I("get.enabled","");
		if($enabled!==""){
			$filter .= " and d.enabled = '{$enabled}' ";
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
				$sort = 'd.addtime';
				$order = 'desc';
			}
		} else {
			$sort = 'd.addtime';
			$order = 'desc';
		}
		
		$count = $this->model->countNum ( $where );
		$page = new \Think\Page ( $count, 20 );
		$lists = $this->model->join("left join ot_dentist_relation r on r.denid=d.denid")
		->join("left join ot_studio s on s.stuid=r.stuid")
		->join("left join ot_dictionary p on p.d_key=d.paytype and p.d_code='paytype'")
		->alias ( 'd' )->where ( $where )->order ( "$sort $order" )->field ( "d.*,s.name as rname,p.d_value as pname" )
		->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		
		//var_dump($this->model->getLastSql());
		if($lists){
			foreach ($lists as $k=>$v){
				if($v["pname"]){
					$lists[$k]["pname"]=L($v["pname"]);
				}
			}
		}
		
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$this->assign ( 'lists', $lists );
		$this->assign ( '_page', $page->show () );
		$this->assign ( 'filtered', $filter ? 1 : 0 ); // 是否有查询条件
		
		
		$sl= M ( "Dictionary" )->field ( "d_key,d_value" )->where ( "d_code='paytype'" )->order ( "d_order asc" )->select ();
		if($sl){
			foreach ($sl as $k=>$v){
				$sl[$k]["d_value"]=L($v["d_value"]);
			}
		}
		
		$this->assign ( 'plist', $sl );
		
		
		$this->display ();
	}
}
