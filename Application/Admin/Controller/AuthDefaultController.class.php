<?php

namespace Admin\Controller;
/**
 * 预定义工作室角色控制器 ：ZL
 *
 */
class AuthDefaultController extends AdminController
{
	private $model;
	
	//构造函数
	public function __construct()
	{
		parent::__construct();
		$this->model = D('AuthDefault');    // 预定义工作室角色Model
	}
	/*
     * 首页
     * */
	public function index(){
		$where = " 1=1 ";
		$title = empty($_GET['title'])?'':trim($_GET['title']);//名称
		if($title){
			$where .= " and a.title like '%{$title}%'";
		}
		
		$count = $this->model->countNum($where);
		$page = new \Think\Page($count, 20);
		$lists = $this->model
				->alias('a')
				->where($where)
				->order('id desc')
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->display();
	}
	/*
     * 新增工作室角色
     * */
	public function add(){
		if(IS_POST){
			$Model = M(); // 实例化一个空对象
			$Model->startTrans(); // 开启事务
			
			$title = empty($_POST['title'])?'':trim($_POST['title']);
			if(empty($title)){//名称不能为空
				$this->error(L('NAME_NOT_EMPTY'));
			}
			
			if($this->model->uniqueName($title)){//名称已存在
				$this->error(L('NAME_EXISTED'));
			}
			$rules = empty($_POST['rules'])?'':trim($_POST['rules']);
			if (empty($rules)) {
				sort($rules);
				$rules = implode(',', array_unique($_POST['rules']));
			}
            $designer = empty($_POST['designer'])? 0 :trim($_POST['designer']);
            $sort_order = empty($_POST['sort_order'])? 0 :trim($_POST['sort_order']);

			$data = array(
				'title' => $title,
				'rules' => $rules,
                'designer'=>$designer,
                'sort_order'=>$sort_order
			);

			$id = $this->model->add($data);
			if (!empty($id)) {
				action_log_new(array('outtype' => 'ot_auth_default', 'outkey' => $id, 'action' => 'add', 'comment' => ''));
				$Model->commit(); // 成功则提交事务
				$this->redirect('AuthDefault/index');
			} else {
				$Model->rollback(); // 否则将事务回滚
				$this->error(L('ADD_ERROR'));
			}
		}else{

            $map = array('module' => 'Studio','status' => 1);
            $auth =  new  AuthManagerController();
            $auth->updateRules();

            $node_list = $this->returnNodes(true,'studio');
            $main_rules = M('AuthRule')->where($map)->getField('name,id');

            $child_rules = M('AuthRule')->where($map)->getField('name,id');

            $this->assign('main_rules', $main_rules);
            $this->assign('auth_rules', $child_rules);
            $this->assign('node_list', $node_list);

            $this->display();
		}
	}
	
	/*
     * 编辑工作室角色
     * */
	public function edit(){
		if(IS_POST){
			$Model = M(); // 实例化一个空对象
			$Model->startTrans(); // 开启事务
			$id = empty($_POST['id'])?0:trim($_POST['id']);
			$where = "id = {$id}";
			$lists =$this->model->getList($where);
			if(empty($lists)){
				$this->error(L('Data_not_exist'));
			}

            $sort_order = empty($_POST['sort_order'])? 0 :trim($_POST['sort_order']);

			$title = empty($_POST['title'])?'':trim($_POST['title']);
			if(empty($title)){//名称不能为空
				$this->error(L('NAME_NOT_EMPTY'));
			}
			
			if($this->model->uniqueName($title,$id)){//名称已存在
				$this->error(L('NAME_EXISTED'));
			}
            if (isset($_POST['rules'])) {
                sort($_POST['rules']);
                $_POST['rules'] = implode(',', array_unique($_POST['rules']));
            }
            $designer = empty($_POST['designer'])? 0 :trim($_POST['designer']);
			$data = array(
				'title' => $title,
				'rules' => $_POST['rules'],
				'id' => $id,
                'designer' => $designer,
                'sort_order'=>$sort_order
			);
			$id = $this->model->save($data);
			if ($id !== false) {
				$history = array();
				foreach ($data as $key => $vo) {
					if ($vo != $lists [$key]) {
						$history [] = array(
							'field' => $key,
							'olddata' => $lists [$key],
							'newdata' => $vo
						);
					}
				}
				action_log_new(array('history'=>$history, 'outtype' => 'ot_auth_default', 'outkey' => $id, 'action' => 'edit', 'comment' => ''));
				$Model->commit(); // 成功则提交事务
				$this->redirect('AuthDefault/index');
			} else {
				$Model->rollback(); // 否则将事务回滚
				$this->error(L('EDIT_ERROR'));
			}
		}else{

            $id = empty($_GET['id'])?0:$_GET['id'];
            if(empty($id)){
                $this->error(L('PLEASE_SELECT_DATA'));
            }
            $where = "id = {$id}";
            $list =$this->model->getList($where);
            if(empty($list)){
                $this->error(L('Data_not_exist'));
            }

            $rules_list = [];
            if(!empty($list['rules'])){
                $rules_list = explode(',', $list['rules']);
            }
            $this->assign('rules_list', $rules_list);

            $map = array('module' => 'Studio','status' => 1);
            $auth =  new  AuthManagerController();
            $auth->updateRules();
            $node_list = $this->returnNodes(true,'studio');
            $main_rules = M('AuthRule')->where($map)->getField('name,id');
            $child_rules = M('AuthRule')->where($map)->getField('name,id');
            //var_dump(implode(',', array_unique($child_rules)));
            $this->assign('main_rules', $main_rules);
            $this->assign('auth_rules', $child_rules);
            $this->assign('node_list', $node_list);
            $this->assign('this_group', $list['rules']);
            $this->assign('list', $list);
			$this->display();
		}
	}

    public function check_title()
    {
        $title = $_POST['title'];
        $id = $_POST['id'];
        if ($id) {
            if (M('Auth_default')->where("title='{$title}' and id !=" . $id)->find())
                echo 'false';
            else
                echo 'true';
        } else {
            if (M('Auth_default')->where(['title' => $title])->find())
                echo 'false';
            else {
                echo 'true';
            }

        }

    }

	/*
     * 删除工作室角色
     * */
	public function delete()
	{
		$id = I('id');
		if (!$id) {
			$this->json_success(L('Data_not_exist'), false);
		}
		if (is_array($id)) {
			$ids = $id;
		} else {
			$ids = (array)$id;
		}
		$msg = '';
		foreach($ids as $id){
			$where = "id = {$id}";
			$list =$this->model->getList($where);
			if($list){
				$res = $this->model->where($where)->delete();
				if($res === false){
					$msg .= "ID".$id.L("DELETE_FAILED")."<br/>";
				}else{
					$msg .="{$list['title']}".L('DELETE_SUCCESS')."<br/>";
					action_log_new(array('outtype' => 'ot_auth_default', 'outkey' => $id, 'action' => 'delete', 'comment' => ''));
				}
			}else{
				$msg .= "ID".$id.L("DELETE_FAILED")."<br>";
			}
		}
		$this->json_success($msg);
	}

}
