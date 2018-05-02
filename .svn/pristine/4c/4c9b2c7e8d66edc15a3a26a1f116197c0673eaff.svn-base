<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Studio\Controller;

/**
 * 工作室 收费项目管理控制器 : LGW
 */
class FeeitemController extends AdminController
{
    private $model;

    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Feeitem');    // 收费项目Model
    }

    /**
     *收费项目管理首页
     */
    public function index()
    {
        $where = " 1=1 ";
		$filter= '';
		$name = empty($_GET['name'])?'':trim($_GET['name']);//工作室名称
		if($name){
			$filter .= " and i.name like '%{$name}%'";
		}
		$code = empty($_GET['code'])?'':trim($_GET['code']);//code
		if($code){
			$filter .= " and  i.code like '%{$code}%'";
		}

		$where .= $filter;

		$count = $this->model->countNum($where);
		$page = new \Think\Page($count, 10);
		$lists = $this->model
				->alias('i')
                ->join('ot_memeber dr on dr.denid = d.denid')
				->where($where)
				//->order("$sort $order")
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
		$this->display();
    }

    /**
     * 新增收费项目
     */
    public function add()
    {
        if (IS_POST) {
            $servicetype = empty($_POST['servicetype']) ? '' : trim($_POST['servicetype']);             
            $feecode = empty($_POST['feecode']) ? '' : trim($_POST['feecode']);
            $feename = empty($_POST['feename']) ? 0 : $_POST['feename'];             
			$price = empty($_POST['price']) ? 0 : $_POST['price'];      
			$price1 = empty($_POST['price1']) ? 0 : $_POST['price1'];      
            $data = array(
                'servicetype' => $servicetype,
				'feename' => $feename,
                'feecode' => $feecode,
				'price' => $price,
                'price1' => $price1,
				'addtime' => time(),
				'adduid' => UID,

            );
            if (!M('Feeitem')->add($data)) {
                $this->error(L('ADD_ERROR'));
            } else {
                $this->success(L('ADD_SUCCESS'), U('index'));
            }
        } else {
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
            $feecode = empty($_POST['feecode']) ? '' : trim($_POST['feecode']);
            $feename = empty($_POST['feename']) ? 0 : $_POST['feename'];             
			$price = empty($_POST['price']) ? 0 : $_POST['price'];      
			$price1 = empty($_POST['price1']) ? 0 : $_POST['price1'];      
            $data = array(
				'itemid' => $id,
                'servicetype' => $servicetype,
				'feename' => $feename,
                'feecode' => $feecode,
				'price' => $price,
                'price1' => $price1,

            );
			
            if (D('Feeitem')->save($data) === false) {
                $this->error(L('EDIT_ERROR'), U('Feeitem/edit?id=' . $id));
            } else {
                $this->success(L('EDIT_SUCCESS'), U('index'));
            }
        } else {
            $data = M('Feeitem')->where("itemid=" . $id)->find();
            if (empty($data)) {
                $this->error(L('Data_not_exist'));
            }
			
            $this->assign('data', $data);
            $this->display();
        }
    }

    /*
     * 删除收费项目
     * */
    public function delete()
    {
        $id = array_unique(( array )I('id', 0));
        $id = is_array($id) ? implode(',', $id) : $id;
        if (empty ($id)) {
            $this->error(L('PLEASE_SELECT_DATA'));
        }
        $map ['itemid'] = array('in', $id);
        if (M('Feeitem')->where($map)->delete() !== false) {
            $this->success(L('DELETE_SUCCESS'), U('index'));
        } else {
            $this->error(L('DELETE_FAILED'));
        };
    }

}
