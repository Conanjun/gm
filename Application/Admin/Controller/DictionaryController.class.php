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
 * 后台字典管理控制器
 */
class DictionaryController extends AdminController
{
    private $model;
	
	//构造函数
	public function __construct()
	{
		parent::__construct();
		$this->model = D('Dictionary');    // 数据字典Model
	}

    /**
     *后台字典管理首页
     *
     */
    public function index()
    {
       $where = " 1=1 ";
		$filter= '';
		$name = empty($_GET['name'])?'':trim($_GET['name']);//名称
		if($name){
			$filter .= " and d.d_name like '%{$name}%'";
		}
		$code = empty($_GET['code'])?'':trim($_GET['code']);//code
		if($code){
			$filter .= " and  d.d_code like '%{$code}%'";
		}
		$d_del = empty($_GET['d_del'])?'':trim($_GET['d_del']);//是否可用
		$d_del == 1 and  $filter .= " and d.d_del = 1";
		$d_del == 2 and  $filter .= " and d.d_del = 0";
		$where .= $filter;
		
		//更新排序
		if (isset($_GET['sort']) && isset($_GET['order'])) {
			$sort = strtolower(trim($_GET['sort']));
			$order = strtolower(trim($_GET['order']));
			if (!in_array($order, array('asc', 'desc'))) {
				$sort = 'd.d_tid';
				$order = 'desc';
			}
		} else {
			$sort = 'd.d_tid';
			$order = 'desc';
		}
		
		$count = $this->model->countNum($where);
		$page = new \Think\Page($count, 20);
		$lists = $this->model
				->alias('d')
				->where($where)
				->order("$sort $order")
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
		$this->display();
    }

    /**
     * 删除数据
     */
    public function deletedata()
    {
    	$id = I('id');
    	if (!$id) {
    		$this->json_error(L('Data_not_exist'), false);
    	}
    	if (is_array($id)) {
    		$ids = $id;
    	} else {
    		$ids = (array)$id;
    	}
    	$msg = '';
    	foreach($ids as $id){
    		$where = "d_tid = {$id}";
    		$list =$this->model->getList($where);
    		if(empty($list)){
    			$failmsg.= "ID".$id.L("DELETE_FAILED")."<br/>";
    		}else{
    			$res = $this->model->where($where)->delete();
    			action_log_new(array('outtype' => 'ot_dictionary', 'outkey' => $id, 'action' => 'delete', 'comment' => ''));
    			$sucmsg.="{$list['d_name']}".L("DELETE_SUCCESS")."<br/>";
    		}
    	}
    	$this->json_success($failmsg.$sucmsg);
    	
    }

    /**
     * 新增字典
     *
     * @param string $d_code
     * @param string $d_key
     * @param string $d_value
     * @param string $d_order
     * @param string $d_del
     */
    public function add($d_code = '', $d_key = '', $d_value = '', $d_order = '',$d_name = '', $d_del = '0')
    {
        if (IS_POST) {
            /* 检测密码 */
            if (empty ($d_code)) {
                $this->error(L('DCODE_EXISTED'));
            }
            if (empty ($d_key)) {
                $this->error(L('DKEY_NOT_EMPTY'));
            }
            if (empty ($d_value)) {
                $this->error(L('DVALUE_NOT_EMPTY'));
            }
			
			if($this->model->uniqueCode($d_code)){//Code已存在
				$this->error(L('DCODE_EXISTED'));
			}
			
			if($this->model->uniqueName($d_name)){//名称已存在
				$this->error(L('DNAME_EXISTED'));
			}
            $data = array(
                'd_code' => $d_code,
                'd_key' => $d_key,
                'd_value' => $d_value,
                'd_order' => $d_order,
				'd_name' => $d_name,
                'd_del' => $d_del
            );
            if (!M('Dictionary')->add($data)) {
                $this->error(L('ADD_FAILED'));
            } else {
                $this->redirect('Dictionary/index');
            }
        } else {
            $this->assign('d', array('d_del' => 1, 'd_order' => 255));
            $this->display();
        }
    }

    /**
     * 编辑字典
     *
     * @param string $id
     * @param string $d_code
     * @param string $d_key
     * @param string $d_value
     * @param string $d_order
     * @param string $d_del
     */
    public function edit($id = '', $d_code = '', $d_key = '', $d_value = '', $d_order = '',$d_name = '', $d_del = '0')
    {
        if (empty($id)) {
            $this->error(L('Data_not_exist'));
        }
        if (IS_POST) {
			$id = empty($_POST['id'])?0:trim($_POST['id']);
			
             if (empty ($d_code)) {
                $this->error(L('DCODE_EXISTED'));
            }
            if (empty ($d_key)) {
                $this->error(L('DKEY_NOT_EMPTY'));
            }
            if (empty ($d_value)) {
                $this->error(L('DVALUE_NOT_EMPTY'));
            }
			if($this->model->uniqueCode($d_code,$id)){//Code已存在
				$this->error(L('DCODE_EXISTED'));
			}
			
			if($this->model->uniqueName($d_name,$id)){//名称已存在
				$this->error(L('DNAME_EXISTED'));
			}
			
            $data = array(
                'd_tid' => $id,
                'd_code' => $d_code,
                'd_key' => $d_key,
                'd_value' => $d_value,
                'd_order' => $d_order,
				'd_name' => $d_name,
                'd_del' => $d_del
            );
            if (D('Dictionary')->save($data) === false) {
                $this->error(L('EDIT_FAILED'), U('Dictionary/edit?id=' . $id));
            } else {
                $this->redirect('Dictionary/index');
            }
        } else {
           $id = empty($_GET['id'])?0:$_GET['id'];
			if(empty($id)){
				$this->error(L('PLEASE_SELECT_DATA'));
			}
			$where = "d_tid = {$id}";
			$list =$this->model->getList($where);
			if(empty($list)){
				$this->error(L('Data_not_exist'));
			}
            $this->assign('list', $list);
            $this->display();
        }
    }
}
