<?php

namespace Admin\Controller;
/**
 * 支付方式控制器 ：ZL
 *
 */
class PaymentController extends AdminController
{
	private $model;
	
	//构造函数
	public function __construct()
	{
		parent::__construct();
		$this->model = D('Payment');
	}
	/*
     * 首页
     * */
	public function index(){
		$count = $this->model->countNum();
		$page = new \Think\Page($count, 20);
		$lists = $this->model
				->alias('p')
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->display();
	}

    //异步修改数据
    public function ajax_col()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $column = empty($_GET['column']) ? '' : trim($_GET['column']);
        $value = isset($_GET['value']) ? trim($_GET['value']) : '';
        $data = array();

        if (in_array($column, array('enabled'))) {
            $list =$this->model->getList("payid = '$id'");
            $data[$column] = $value;
            $lists = $this->model->where('payid=' . $id)->save($data);
            if($lists){
                $history = array();
                foreach ($data as $key => $vo) {
                    if ($vo != $list [$key]) {
                        $history [] = array(
                            'field' => $key,
                            'olddata' => $list [$key],
                            'newdata' => $vo
                        );
                    }
                }
                action_log_new(array('history'=>$history, 'outtype' => 'ot_payment', 'outkey' => $id, 'action' => 'edit', 'comment' => ''));
                echo   'true';
            }else{
                return;
            }

        } else {
            return;
        }
        return;
    }
}
