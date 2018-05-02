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
 * 种植体品牌及型号: FHC
 */
class PlantingSysController extends AdminController
{
    private $model;

    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->model = D('PlantingSys');    // 种植体品牌及型号Model
    }

    /**
     *种植体品牌及型号首页
     */
    public function index()
    {
        $where = " 1=1 ";
		$filter= '';
		$name = empty($_GET['name'])?'':trim($_GET['name']);//种植体品牌及型号名称
		if($name){
			$filter .= " and (f.zh_name like '%{$name}%' or f.en_name like '%{$name}%')";
		}
		$where .= $filter;
		$count = $this->model->countNum($where);
		$page = new \Think\Page($count, 10);
		$lists = $this->model
				->alias('f')
                ->join('ot_member m on f.uid = m.uid')
				->where($where)
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
		$this->display();
    }

    /**
     * 新增种植体品牌及型号
     */
    public function add()
    {
        if (IS_POST) {
            $zh_name = empty($_POST['zh_name']) ? '' : trim($_POST['zh_name']);
            $en_name = empty($_POST['en_name']) ? '' : trim($_POST['en_name']);

            if(empty($zh_name)){
                $this->error(L('zh_name_required'));
            }
            
        	if( empty($en_name)){
                $this->error(L('en_name_required'));
            }

            $data = array(
				'zh_name' => $zh_name,
                'en_name' => $en_name,
				'addtime' => time(),
				'uid' => UID,

            );
            if (!M('PlantingSys')->add($data)) {
                $this->error(L('ADD_ERROR'));
            } else {
                $this->success(L('ADD_SUCCESS'), U('index'));
            }
        } else {
            $this->display();
        }
    }

    /**
     * 编辑种植体品牌及型号
     */
    public function edit()
    {
		$id = empty($_GET['id'])?0:$_GET['id'];
        if (IS_POST) {
			$id = empty($_POST['id']) ? '' : trim($_POST['id']);

            $zh_name = empty($_POST['zh_name']) ? '' : trim($_POST['zh_name']);
            $en_name = empty($_POST['en_name']) ? '' : trim($_POST['en_name']);

        	if(empty($zh_name)){
                $this->error(L('zh_name_required'));
            }
            
        	if( empty($en_name)){
                $this->error(L('en_name_required'));
            }

            $data = array(
				'id' => $id,
				'zh_name' => $zh_name,
                'en_name' => $en_name,
            );
			
            if (D('PlantingSys')->save($data) === false) {
                $this->error(L('EDIT_ERROR'), U('PlantingSys/edit?id=' . $id));
            } else {
                $this->success(L('EDIT_SUCCESS'), U('index'));
            }
        } else {
            $data = M('PlantingSys')->where("id=" . $id)->find();
            if (empty($data)) {
                $this->error(L('Data_not_exist'));
            }
            $this->assign('data', $data);
            $this->display();
        }
    }

    /*
     * 删除种植体品牌及型号
     * */
    public function delete()
    {
        $id = array_unique(( array )I('id', 0));
        $id = is_array($id) ? implode(',', $id) : $id;
        if (empty ($id)) {
            $this->error(L('PLEASE_SELECT_DATA'));
        }
        $map ['id'] = array('in', $id);
        if (M('PlantingSys')->where($map)->delete() !== false) {
            $this->success(L('DELETE_SUCCESS'), U('index'));
        } else {
            $this->error(L('DELETE_FAILED'));
        };
    }

}
