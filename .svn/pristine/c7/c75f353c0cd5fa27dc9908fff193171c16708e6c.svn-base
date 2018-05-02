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
 * 工作室 费用模式管理控制器 : LGW
 */
class FeemodeController extends AdminController
{
    private $model;

    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Feemode');    // 费用模式Model
    }

    /**
     *费用模式管理首页
     */
    public function index()
    {
        $where = "1=1";
        $page = getCount($this->model, $where);
        $dentists = $this->model->getList($where, $page);
        $page->setConfig('theme', PAGE_CONFIG);
        $this->assign('list', $dentists);
        $this->assign('_page', $page->show());
        $this->display();
    }

    /**
     * 新增费用模式
     */
    public function add()
    {
        if (IS_POST) {
            $custype = empty($_POST['custype']) ? '' : trim($_POST['custype']);             // 客户类型
            $servicetype = empty($_POST['servicetype']) ? '' : trim($_POST['servicetype']); // 服务类别
            $feemode = empty($_POST['feemode']) ? 0 : $_POST['feemode'];              // 计费模式

            $data = array(
                'custype' => $custype,
                'servicetype' => $servicetype,

            );
            if (!M('Dictionary')->add($data)) {
                $this->error('字典添加失败！');
            } else {
                $this->success('字典添加成功！', U('index'));
            }
        } else {
            $this->display();
        }
    }

    /**
     * 编辑费用模式
     */
    public function edit()
    {
        if (empty($id)) {
            $this->error('字典数据不存在！');
        }
        if (IS_POST) {
            if (empty ($d_code)) {
                $this->error('字典编码不能为空');
            }
            if (empty ($d_key)) {
                $this->error('字典名称不能为空');
            }
            if (empty ($d_value)) {
                $this->error('字典值不能为空');
            }
            if (empty ($d_order)) {
                $this->error('字典序号不能为空');
            }

            $data = array(
                'd_tid' => $id,
                'd_code' => $d_code,
                'd_key' => $d_key,
                'd_value' => $d_value,
                'd_order' => $d_order,
                'd_del' => $d_del
            );
            if (D('Dictionary')->save($data) === false) {
                $this->error('字典编辑失败！', U('Dictionary/edit?id=' . $id));
            } else {
                $this->success('字典编辑成功！', U('index'));
            }
        } else {
            $data = M('Dictionary')->where("d_tid=" . $id)->find();
            if (empty($data)) {
                $this->error('字典数据不存在！');
            }
            $this->assign('d', $data);
            $this->display();
        }
    }

}
