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
 * 患者管理控制器
 */
class PlatPatientController extends AdminController {
	private $model;
	
	// 构造函数
	public function __construct() {
		parent::__construct ();
		$this->model = D ( 'PlatPatient' );
	}
	
	/**
	 * 后台字典管理首页
	 */
	public function index() {
		$where = " 1=1 ";
		$filter = '';
		$keys= I("get.keys","");
		$keys && $filter .= " and (p.realname like '%{$keys}%' or d.name like '%{$keys}%')";
		
		$name=I("get.name","");
		$name && $filter .= " and (p.tel like '%{$name}%')";
		
		$gender=I("get.gender","");
		if($gender!==""){
			$filter .= " and p.gender = '{$gender}' ";
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
				$sort = 'p.addtime';
				$order = 'desc';
			}
		} else {
			$sort = 'p.addtime';
			$order = 'desc';
		}
		
		$count = $this->model->countNum ( $where );
		$page = new \Think\Page ( $count, 20 );
		$lists = $this->model->join("left join ot_dentist d on d.denid=p.denid")
		->alias ( 'p' )->where ( $where )->order ( "$sort $order" )->field ( "p.*,d.name as dname" )
		->limit ( $page->firstRow . ',' . $page->listRows )->select ();
		
		//var_dump($this->model->getLastSql());
		
		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$this->assign ( 'lists', $lists );
		$this->assign ( '_page', $page->show () );
		$this->assign ( 'filtered', $filter ? 1 : 0 ); // 是否有查询条件
		
		$this->display ();
	}
}
