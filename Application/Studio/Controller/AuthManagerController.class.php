<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 朱亚杰 <zhuyajie@topthink.net>
// +----------------------------------------------------------------------

namespace Studio\Controller;

use Admin\Model\AuthRuleModel;
use Admin\Model\AuthGroupModel;

/**
 * 权限管理控制器
 * Class AuthManagerController
 *
 * @author 朱亚杰 <zhuyajie@topthink.net>
 */
class AuthManagerController extends AdminController
{
    private  $meta_title;
    public function index()
    {

        $groupM = M('auth_group');
		$where = " 1=1 and module = 'Studio'";
		$title = empty($_GET['title'])?'':trim($_GET['title']);//名称
		if($title){
			$where .= " and t.title like '%{$title}%'";
		}
		$status = I('status','');
		if($status){
			$where .= " and t.status ={$status} ";
		}
		
		$count = $groupM->where($where)->count;
		$page = new \Think\Page($count, 20);
		$lists = $groupM
				->alias('t')
				->where($where)
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->display();
    }

    /**
     * 添加角色
     */
    public function add()
    {
        if (IS_POST) {
            $auth_group = D('Auth_group');
            $data = $auth_group->create();
            if (empty($data['title'])) {
                $this->error(L('PLATFORM_NAME_NOT_EMPTY'));
            }
            $res = $auth_group->getByTitle($data['title']);
            if ($res) {
                $this->error(L('PLATFORM_NAME_EXISTED'));
            }
            if ($data) {
                $data['parent'] = 0;
                $res_grade = $this->getGrade($data['parent']);
                $data['grade'] = (int)$res_grade['grade'] + 1;
                $data['module'] = 'admin';
                $data['type'] = '1';
                $data['rules'] = '';
                unset($data['id']);
                $id = $auth_group->add($data);
                if ($id) {
                    $path = $this->getPid($id);
                    $auth_group->where('id = ' . $id)->save(array('path' => $path));
                    $this->success(L('ADD_SUCCESS'), Cookie('__forward__'));
//					$this->redirect('Index', Cookie('__forward__'));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error($auth_group->getError());
            }
        }else{
			$this->display();
		}
    }

    /**
     * 编辑
     */
    public function edit()
    {
        if (IS_POST) {
            $id = I('post.id');
            $group = D('auth_group');
            $data = $group->create();
            if (empty($data['title'])) {
                $this->error(L('PLATFORM_NAME_NOT_EMPTY'));
            }
            $res = $group->where('id !=' . $id)->getByTitle($data['title']);
            if ($res) {
                $this->error(L('PLATFORM_NAME_EXISTED'));
            }
            if ($data) {
                //父级去除空值取最后一个
                $parent = array_filter($data['parent']);
                $data['parent'] = end($parent);
                $res_grade = $this->getGrade($data['parent']);
                
                $data['grade'] = (int)$res_grade['grade'] + 1;

                if ($group->where('id = ' . $id)->save($data) !== false) {
                    $path = $this->getPid($id);
                    $group->where('id = ' . $id)->save(array('path' => $path));
                    $this->redirect('AuthManager/edit?id=' . $id);
                } else {
                    $this->error(L('EDIT_FAILED'));
                }
            } else {
                $this->error($group->getError());
            }
        } else {
            $id = I('get.id');
            $menuList = $this->getpro();
            $menuList = "<ul class='tree tree-lines'>" . substr($menuList, 4);
            $this->assign('menuList', $menuList);
            $groups = M('auth_group')->field(true)->select();
            $groups = D('Common/Tree')->toFormatTree1($groups, 'title', 'id');
            $groups = array_merge(array(0 => array('id' => 0, 'title_show' => '顶级角色', 'grade' => 0)), $groups);
            $this->assign('gps', $groups);
            $group = M('auth_group')->where('id = ' . $id)->field(true)->find();
            $this->assign('group', $group);
            $rules_list = [];
            if(!empty($group['rules'])){
                $rules_list = explode(',', $group['rules']);
            }
            $this->assign('rules_list', $rules_list);
            $this->meta_title = '编辑角色';
            $this->assign('id', $id);
            //权限
            $auth_group = M('AuthGroup')->where(array('status' => array('egt', '0')))->getfield('id,title,rules');//,'module'=>'admin','type'=>AuthGroupModel::TYPE_ADMIN
            $node_list = $this->returnNodes();
            $map = array('module' => 'admin', 'type' => AuthRuleModel::RULE_MAIN, 'status' => 1);
            $main_rules = M('AuthRule')->where($map)->getField('name,id');
            $map = array('module' => 'admin', 'type' => AuthRuleModel::RULE_URL, 'status' => 1);
            $child_rules = M('AuthRule')->where($map)->getField('name,id');

            $this->assign('main_rules', $main_rules);
            $this->assign('auth_rules', $child_rules);
            $this->assign('node_list', $node_list);

            $this->assign('auth_group', $auth_group);
            $this->assign('this_group', $auth_group[(int)$id]);

            //人员
            $users = M('auth_group_access')->query("select um.id,um.username,m.status,m.nickname,d.name as dname,um.mobile,um.email from ot_auth_group_access g inner join ot_ucenter_member um on g.uid=um.id inner join ot_member m on um.id = m.uid left join ot_dept d on d.did=m.dept where m.status=1 and g.group_id='" . $id . "'");
            $this->assign('users', $users);

            $root_mbx = array();
            $root_mbx[] = array('title' => '管理', 'url' => U('ProjectConfig/index'));
            $root_mbx[] = array('title' => '角色', 'url' => U('AuthManager/index'));
            $root_mbx[] = array('title' => '编辑角色', 'url' => '');
            $this->assign('root_mbx', $root_mbx);
            $this->display('edit');
        }
    }

    /**
     * 删除
     */
    public function del()
    {
        //$id = array_unique((array)I('id',0));

        $id = I('get.id');
        if (empty($id)) {
           $this->error(L('PLEASE_SELECT_DATA'));
        }
        //检测角色及子类是否有成员
        $res_ids = M('auth_group')->field('id')->where("path like CONCAT('%,',{$id},',%')")->select();
        foreach ($res_ids as $vo) {
            $where = "ag.id={$vo['id']}  and ( exists(select 1 from ot_auth_group_access aga where aga.group_id=ag.id) )";
            $res_check = M('auth_group')->alias('ag')->where($where)->find();
            if ($res_check) {
                $this->json_error('删除失败：角色或子角色有成员', false);
            }
        }
        $filter['path'] = array('like', "%$id%");
        $res = M('auth_group')->where($filter)->delete();
        if ($res) {
           $this->error(L('DELETE_SUCCESS'));
        } else {
            $this->json_error(L('DELETE_FAILED'), false);
        }
    }


    public function adduser()
    {
        if (IS_POST) {
            $id = I('id');
            if (empty($id)) {
                $this->error('请选择要操作的角色！');
            }
            $module = M('auth_group_access');
            $data = $_POST;
            $newdata = array();
            foreach ($data as $key => $value) {
                foreach ($value as $k => $v) {
                    $newdata[$k][$key] = $v;
                }
            }
            $editdata = array();
            $adddata = array();
            foreach ($newdata as $key => $value) {
                if (empty($value['uid'])) {
                    $adddata[] = $value;
                } else {
                    $editdata[] = $value;
                }
            }
            if (is_array($editdata)) {
                foreach ($editdata as $key => $vo) {
                    $module->where("group_id ={$id} and uid = {$vo['uid']}")->save(array('rlid' => $vo['rlid']));
                    M('Member')->where("uid = {$vo['uid']}")->save(array('rlid' => $vo['rlid']));
                }
            }
            $old_data = $module->where("group_id ={$id}")->select();
            if (is_array($adddata)) {
                foreach ($adddata as $key => $value) {
                    if (!empty($old_data)) {
                        foreach ($old_data as $k => $v) {
                            if ($value['role'] == $v['uid']) {
                                unset($adddata[$key]);
                            }
                        }
                    }
                }
            }
            $msg = "";
            if (is_array($adddata)) {
                foreach ($adddata as $key => $vo) {
                    if ($vo['role'] > 0) {
                        $data = array();
                        $data['uid'] = $vo['role'];
                        $data['rlid'] = $vo['rlid'];
                        $data['group_id'] = $id;
                        $username = M('member')->field('nickname')->where(array('uid' => $vo['role']))->find();
                        //			        $map_user=" not exists( select uid from ot_auth_group_access aga where aga.uid={$vo['role']}) ";
                        $result = $module->where(array('uid' => $vo['role']))->select();
                        if ($result) {
                            $msg .= '『' . $username['nickname'] . '』' . "添加失败<br/>";
                            continue;
                        }
                        $res_insert = $module->add($data);
                        if (!$res_insert) {
                            $msg .= '『' . $username['nickname'] . '』' . "添加失败<br/>";
                        }
                        M('Member')->where("uid = {$vo['role']}")->save(array('rlid' => $vo['rlid']));
                    }
                }
            }


            /* foreach ($newdata as $key => $value) {
             if(!empty($old_data)){
             foreach ($old_data as $k => $v) {
             if($value['uid']==$v['uid']){
             unset($newdata[$key]);
             }
             }
             }
             }
             $newdata = array();
             foreach ($data['role'] as $a=>$b){
             $newdata['group_id'] = $id;
             $newdata['uid'] = $b;
             $newdata['rlid'] = $b;
             M('auth_group_access')->data($newdata)->add();
             }*/
            if ($msg) {
                $this->error($msg, U('AuthManager/adduser?id=' . $id));
            } else {
                $this->success('编辑成功', U('AuthManager/adduser?id=' . $id));
                /*$this->redirect();*/
            }
        } else {
            $id = I('id');
            $menuList = $this->getpro();
            $menuList = "<ul class='tree tree-lines'>" . substr($menuList, 4);

            $users = M('auth_group_access')->query("select um.id,um.username,m.nickname,g.rlid from ot_auth_group_access g inner join ot_ucenter_member um on g.uid=um.id inner join ot_member m on um.id = m.uid where m.status=1 and g.group_id='" . $id . "'");

            //添加人员 一个人员只对应一个角色
            $map_usr = " not exists( select uid from ot_auth_group_access aga where aga.uid=um.id) ";
            $new_user = M('ucenter_member')->field('um.*,m.nickname')->alias('um')
                ->join('ot_member m on m.uid=um.id and m.status=1')
                ->where($map_usr)->select();
            $rls = M('RoleLevel')->where("agid = {$id}")->select();
            $root_mbx = array();
            $root_mbx[] = array('title' => '管理', 'url' => U('Index/index'));
            $root_mbx[] = array('title' => '角色', 'url' => U('AuthManager/index'));
            $root_mbx[] = array('title' => '添加人员', 'url' => '');
            $this->assign('rls', $rls);
            $this->assign('root_mbx', $root_mbx);
            $this->assign('users', $users);
            $this->assign('temp_user', $new_user);
            $this->assign('id', $id);
            $this->assign('menuList', $menuList);
            $this->display();
        }
    }

    public function deleteuser()
    {
        $uid = I('uid');
        $gid = I('gid');
        $ret = M('auth_group_access')->where("uid='" . $uid . "' and group_id='" . $gid . "'")->delete();
        if ($ret) {
            $this->json_result(array(), '删除成功', false);
        } else {
            $this->json_error('删除失败!', false);
        }
    }

    public function getPid($id)
    {
        static $res = '';
        $group = M('auth_group')->find($id);
        $res = $group['id'] . ',' . $res;
        if ($group['parent'] != 0) {
            return $this->getPid($group['parent']);
        }
        return ',' . $res;
    }

    public function getGrade($id)
    {
    	if($id){
        	$res = M('auth_group')->field('grade')->find($id);
    	}else{
    		$res=0;
    	}
        return $res;
    }

    public function getpro($id = 0)
    {
        global $lastMenu;
        $where = 'parent = ' . $id;
        $deptList = M('auth_group')->where($where)->order('sort_order asc')->select();
        if ($deptList) {
            $lastMenu .= "<ul>";
            foreach ($deptList as $key => $value) {
                if (M('auth_group')->where('parent=' . $value['id'])->find()) {
                    $lastMenu .= "<li> <i class='list-toggle icon'></i>" .
                        "<a id='list" . $value ['id'] . "' href=" . U('AuthManager/edit?id=' . $value['id']) . " >
                    " . $value['title'] . "</a><span style='display:inline-block;padding-left:3px;font-size:1px;'>" .
                        "<a href=" . U('AuthManager/index?id=' . $value['id']) . " style='color: rgba(97, 9, 232, 0.4);'>
                    <i class=\"icon-plus\"></i></a></span><span style='display:inline-block;padding-left:3px;font-size:1px;'>" .
                        "<a href=" . U('AuthManager/del?id=' . $value['id']) . " style='color: rgba(97, 9, 232, 0.4);' class='confirm ajax-get'>
                    <i class=\"icon-remove\"></i></a></span><span style='display:inline-block;padding-left:3px;font-size:1px;'>" .
                        "<a href=" . U('AuthManager/access?group_name=' . $value['title'] . '&group_id=' . $value['id']) .
                        " style='color: rgba(97, 9, 232, 0.4);'><i class=\"icon-key\"></i></a></span>
                    <span style='display:inline-block;padding-left:3px;font-size:1px;'><a href=" . U('AuthManager/adduser?id=' . $value['id']) .
                        " style='color: rgba(97, 9, 232, 0.4);'><i class=\"icon-group\"></i></a></span>
                     <span style='display:inline-block;padding-left:3px;font-size:1px;'><a href=" . U('AuthManager/rolelevel?id=' . $value['id']) .
                        " style='color: rgba(97, 9, 232, 0.4);'><i class=\"icon-stack\"></i></a></span>";

                    $this->getpro($value['id']);
                    $lastMenu .= "</li>";
                } else {
                    $lastMenu .= "<li>" . "<a id='list" . $value ['id'] . "' href=" . U('AuthManager/edit?id=' . $value['id']) . ">" . $value['title'] . "
                    </a><span style='display:inline-block;padding-left:3px;font-size:1px;'>" . "<a href=" . U('AuthManager/index?id=' . $value['id']) . " 
                    style='color: rgba(97, 9, 232, 0.4);'><i class=\"icon-plus\"></i></a></span><span style='display:inline-block;padding-left:3px;font-size:1px;'>" .
                        "<a href=" . U('AuthManager/del?id=' . $value['id']) . " style='color: rgba(97, 9, 232, 0.4);' class='confirm ajax-get'><i class=\"icon-remove\"></i></a>
                    </span><span style='display:inline-block;padding-left:3px;font-size:1px;'>" . "<a href=" . U('AuthManager/access?group_name=' . $value['title'] . '&group_id=' . $value['id']) . " 
                    style='color: rgba(97, 9, 232, 0.4);'><i class=\"icon-key\"></i></a></span><span style='display:inline-block;padding-left:3px;font-size:1px;'><a href=" . U('AuthManager/adduser?id=' . $value['id']) .
                        " style='color: rgba(97, 9, 232, 0.4);'><i class=\"icon-group\"></i></a></span>
                    <span style='display:inline-block;padding-left:3px;font-size:1px;'><a href=" . U('AuthManager/rolelevel?id=' . $value['id']) .
                        " style='color: rgba(97, 9, 232, 0.4);'><i class=\"icon-stack\"></i></a></span>
                    </li>";
                }
            }
            $lastMenu .= "</ul>";
        }
        return $lastMenu;
    }

    /**
     * 后台节点配置的url作为规则存入auth_rule
     * 执行新节点的插入,已有节点的更新,无效规则的删除三项任务
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function updateRules()
    {
        //需要新增的节点必然位于$nodes
        $nodes = $this->returnNodes(false);
        
        $AuthRule = M('AuthRule');
        $map = array('type' => array('in', '1,2'));//status全部取出,以进行更新
        //需要更新和删除的节点必然位于$rules
        $rules = $AuthRule->where($map)->order('name')->select();

        //构建insert数据
        $data = array();//保存需要插入和更新的新节点
        foreach ($nodes as $value) {
            $temp['name'] = $value['url'];
            $temp['title'] = $value['title'];
            $temp['module'] = $value['module'];
            if ($value['pid'] > 0) {
                $temp['type'] = AuthRuleModel::RULE_URL;
            } else {
                $temp['type'] = AuthRuleModel::RULE_MAIN;
            }
            $temp['status'] = 1;
            $data[strtolower($temp['name'] . $temp['module'] . $temp['type'])] = $temp;//去除重复项
        }

        $update = array();//保存需要更新的节点
        $ids = array();//保存需要删除的节点的id
        foreach ($rules as $index => $rule) {
            $key = strtolower($rule['name'] . $rule['module'] . $rule['type']);
            if (isset($data[$key])) {//如果数据库中的规则与配置的节点匹配,说明是需要更新的节点
                $data[$key]['id'] = $rule['id'];//为需要更新的节点补充id值
                $update[] = $data[$key];
                unset($data[$key]);
                unset($rules[$index]);
                unset($rule['condition']);
                $diff[$rule['id']] = $rule;
            } elseif ($rule['status'] == 1) {
                $ids[] = $rule['id'];
            }
        }
        if (count($update)) {
            foreach ($update as $k => $row) {
                if ($row != $diff[$row['id']]) {
                    $AuthRule->where(array('id' => $row['id']))->save($row);
                }
            }
        }
        if (count($ids)) {
            $AuthRule->where(array('id' => array('IN', implode(',', $ids))))->save(array('status' => -1));
            //删除规则是否需要从每个用户组的访问授权表中移除该规则?
        }
        if (count($data)) {
            $AuthRule->addAll(array_values($data));
        }
        if ($AuthRule->getDbError()) {
            trace('[' . __METHOD__ . ']:' . $AuthRule->getDbError());
            return false;
        } else {
            return true;
        }
    }


    /**
     * 权限管理首页
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    /* public function index(){
     $list = $this->lists('AuthGroup',array('module'=>'admin'),'id asc');
     $list = int_to_string($list);
     $this->assign( '_list', $list );
     $this->assign( '_use_tip', true );
     $this->meta_title = '权限管理';
     $this->display();
     }*/

    /**
     * 创建管理员用户组
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function createGroup()
    {
        if (empty($this->auth_group)) {
            $this->assign('auth_group', array('title' => null, 'id' => null, 'description' => null, 'rules' => null,));//排除notice信息
        }
        $this->meta_title = '新增用户组';
        $this->display('editgroup');
    }

    /**
     * 编辑管理员用户组
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function editGroup()
    {
        $auth_group = M('AuthGroup')->where(array('module' => 'admin', 'type' => AuthGroupModel::TYPE_ADMIN))
            ->find((int)$_GET['id']);
        $this->assign('auth_group', $auth_group);
        $this->meta_title = '编辑用户组';
        $this->display();
    }


    /**
     * 访问授权页面
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function access()
    {
        $name = I('get.group_name');
        $this->updateRules();
        $auth_group = M('AuthGroup')->where(array('status' => array('egt', '0')))//,'module'=>'admin','type'=>AuthGroupModel::TYPE_ADMIN
        ->getfield('id,title,rules');
        $groupID = (int)$_GET['group_id'];
        $node_list = $this->returnNodes(true,MODULE_NAME);
        $map = array('module' => 'admin',  'status' => 1);//'type' => AuthRuleModel::RULE_MAIN,
        $main_rules = M('AuthRule')->where($map)->getField('name,id');
        $map = array('module' => 'admin', 'type' => AuthRuleModel::RULE_URL, 'status' => 1);
        $child_rules = M('AuthRule')->where($map)->getField('name,id');
        $root_mbx = array();
        $root_mbx[] = array('title' => '管理', 'url' => U('Index/index'));
        $root_mbx[] = array('title' => '角色', 'url' => U('AuthManager/index'));

        $root_mbx[] = array('title' => "$name", 'url' => U("AuthManager/edit?id=".$groupID));
        $root_mbx[] = array('title' => '赋权', 'url' => '');
        $this->assign('root_mbx', $root_mbx);

        $this->assign('name', $name);
        $group = M('auth_group')->where('id = ' . $groupID)->field(true)->find();
        $rules_list = [];
        if(!empty($group['rules'])){
            $rules_list = explode(',', $group['rules']);
        }
        $this->assign('rules_list', $rules_list);
        $this->assign('main_rules', $main_rules);
        $this->assign('auth_rules', $child_rules);
        $this->assign('node_list', $node_list);
        $this->assign('auth_group', $auth_group);
        $this->assign('this_group', $auth_group[(int)$_GET['group_id']]);
        $this->meta_title = '访问授权';
        $this->display('managergroup');
    }


    /**
     * 管理员用户组数据写入/更新
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function writeGroup()
    {	
        if (isset($_POST['rules'])) {
            sort($_POST['rules']);
            $_POST['rules'] = implode(',', array_unique($_POST['rules']));
        }
        $_POST['module'] = 'admin';
        $_POST['type'] = AuthGroupModel::TYPE_ADMIN;
        $AuthGroup = D('AuthGroup');
        $data = $AuthGroup->create();
        if ($data) {
            if (empty($data['id'])) {
                $r = $AuthGroup->add();
            } else {
                $r = $AuthGroup->save();
            }
            if ($r === false) {
                $this->error('操作失败' . $AuthGroup->getError());
            } else {
                $this->redirect('AuthManager/edit?id=' . $data['id']);
            }
        } else {
            $this->error('操作失败' . $AuthGroup->getError());
        }
    }

    /**
     * 状态修改
     *
     * @param null $method
     */
    public function changeStatus($method = null)
    {
        if (empty($_REQUEST['id'])) {
            $this->error('请选择要操作的数据!');
        }
        switch (strtolower($method)) {
            case 'forbidgroup':
                $this->forbid('AuthGroup');
                break;
            case 'resumegroup':
                $this->resume('AuthGroup');
                break;
            case 'deletegroup':
                $this->delete('AuthGroup');
                break;
            default:
                $this->error($method . '参数非法');
        }
    }

    /**
     *  用户组授权用户列表
     *
     * @param $group_id
     */
    public function user($group_id)
    {
        if (empty($group_id)) {
            $this->error('参数错误');
        }

        $auth_group = M('AuthGroup')->where(array('status' => array('egt', '0'), 'module' => 'admin', 'type' => AuthGroupModel::TYPE_ADMIN))
            ->getfield('id,id,title,rules');
        $prefix = C('DB_PREFIX');
        $l_table = $prefix . (AuthGroupModel::MEMBER);
        $r_table = $prefix . (AuthGroupModel::AUTH_GROUP_ACCESS);
        $model = M()->table($l_table . ' m')->join($r_table . ' a ON m.uid=a.uid');
        $_REQUEST = array();
        $list = $this->lists($model, array('a.group_id' => $group_id, 'm.status' => array('egt', 0)), 'm.uid asc', null, 'm.uid,m.nickname,m.last_login_time,m.last_login_ip,m.status');
        int_to_string($list);
        $this->assign('_list', $list);
        $this->assign('auth_group', $auth_group);
        $this->assign('this_group', $auth_group[(int)$_GET['group_id']]);
        $this->meta_title = '成员授权';
        $this->display();
    }

    /**
     * 将分类添加到用户组的编辑页面
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function category()
    {
        $auth_group = M('AuthGroup')->where(array('status' => array('egt', '0'), 'module' => 'admin', 'type' => AuthGroupModel::TYPE_ADMIN))
            ->getfield('id,id,title,rules');
        $group_list = D('Category')->getTree();
        $authed_group = AuthGroupModel::getCategoryOfGroup(I('group_id'));
        $this->assign('authed_group', implode(',', (array)$authed_group));
        $this->assign('group_list', $group_list);
        $this->assign('auth_group', $auth_group);
        $this->assign('this_group', $auth_group[(int)$_GET['group_id']]);
        $this->meta_title = '分类授权';
        $this->display();
    }

    public function tree($tree = null)
    {
        $this->assign('tree', $tree);
        $this->display('tree');
    }

    /**
     * 将用户添加到用户组的编辑页面
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function group()
    {
        $uid = I('uid');
        $auth_groups = D('AuthGroup')->getGroups();
        $user_groups = AuthGroupModel::getUserGroup($uid);
        $ids = array();
        foreach ($user_groups as $value) {
            $ids[] = $value['group_id'];
        }
        $nickname = D('Member')->getNickName($uid);
        $this->assign('nickname', $nickname);
        $this->assign('auth_groups', $auth_groups);
        $this->assign('user_groups', implode(',', $ids));
        $this->display();
    }

    /**
     * 将用户添加到用户组,入参uid,group_id
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function addToGroup()
    {
        $uid = I('uid');
        $gid = I('group_id');
        if (empty($uid)) {
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        if (is_numeric($uid)) {
            if (is_administrator($uid)) {
                $this->error('该用户为超级管理员');
            }
            if (!M('Member')->where(array('uid' => $uid))->find()) {
                $this->error('管理员用户不存在');
            }
        }

        if ($gid && !$AuthGroup->checkGroupId($gid)) {
            $this->error($AuthGroup->error);
        }
        if ($AuthGroup->addToGroup($uid, $gid)) {
            $this->success('操作成功');
        } else {
            $this->error($AuthGroup->getError());
        }
    }

    /**
     * 将用户从用户组中移除  入参:uid,group_id
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function removeFromGroup()
    {
        $uid = I('uid');
        $gid = I('group_id');
        if ($uid == UID) {
            $this->error('不允许解除自身授权');
        }
        if (empty($uid) || empty($gid)) {
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        if (!$AuthGroup->find($gid)) {
            $this->error('用户组不存在');
        }
        if ($AuthGroup->removeFromGroup($uid, $gid)) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 将分类添加到用户组  入参:cid,group_id
     *
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function addToCategory()
    {
        $cid = I('cid');
        $gid = I('group_id');
        if (empty($gid)) {
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        if (!$AuthGroup->find($gid)) {
            $this->error('用户组不存在');
        }
        if ($cid && !$AuthGroup->checkCategoryId($cid)) {
            $this->error($AuthGroup->error);
        }
        if ($AuthGroup->addToCategory($gid, $cid)) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 将模型添加到用户组  入参:mid,group_id
     *
     * @author 朱亚杰 <xcoolcc@gmail.com>
     */
    public function addToModel()
    {
        $mid = I('id');
        $gid = I('get.group_id');
        if (empty($gid)) {
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        if (!$AuthGroup->find($gid)) {
            $this->error('用户组不存在');
        }
        if ($mid && !$AuthGroup->checkModelId($mid)) {
            $this->error($AuthGroup->error);
        }
        if ($AuthGroup->addToModel($gid, $mid)) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function rolelevel()
    {
        $id = I('id');
        if (empty($id)) {
            $this->error('请选择要操作的角色！');
        }
        $module = M('RoleLevel');
        if (IS_POST) {
            $newdata = array();
            $data = $_POST;
            foreach ($data as $key => $value) {
                foreach ($value as $k => $v) {
                    $newdata[$k][$key] = $v;
                }
            }
            $editdata = array();
            $adddata = array();
            foreach ($newdata as $key => $value) {
                if (empty($value['rlid'])) {
                    if (!empty($value['name'])) {
                        $adddata[] = $value;
                    }
                } else {
                    $editdata[] = $value;
                }
            }
            if (is_array($editdata)) {
                foreach ($editdata as $key => $vo) {
                    $module->save($vo);
                }
            }
            if (is_array($adddata)) {
                foreach ($adddata as $key => $vo) {
                    $vo['agid'] = $id;
                    $module->add($vo);
                }
            }
            $this->success('操作成功', U('AuthManager/rolelevel?id=' . $id));
        } else {
            $menuList = $this->getpro();
            $menuList = "<ul class='tree tree-lines'>" . substr($menuList, 4);

            $rls = $module->where("agid = {$id}")->select();
            $root_mbx = array();
            $root_mbx[] = array('title' => '管理', 'url' => U('Index/index'));
            $root_mbx[] = array('title' => '角色', 'url' => U('AuthManager/index'));
            $root_mbx[] = array('title' => '添加角色等级', 'url' => '');
            $this->assign('root_mbx', $root_mbx);
            $this->assign('rls', $rls);
            $this->assign('id', $id);
            $this->assign('menuList', $menuList);
            $this->display();
        }

    }

    public function deleterl()
    {
        $rlid = I('rlid');
        $ret = M('RoleLevel')->where("rlid = {$rlid}")->delete();
        if ($ret) {
            $this->json_result(array(), '删除成功', false);
        } else {
            $this->json_error('删除失败!', false);
        }
    }

    /*联动上级角色获取*/
    public function parentRole()
    {
        $pid = I('post.parent_id');
        $id = I('post.current_id');
        $result = M('auth_group')->where(array('parent=' . $pid))->select();
        $option_html = "<div width='100%' float='left'>";
        $select_html = '<select name="parent[]"  id="sub_category_id" class="parent" style="height:30px;margin-left:5px;min-width:120px;border-color:#ccc;" ><option value="" selected="selected">--请选择--</option>';
        if ($result) {
            foreach ($result as $res) {
                //过滤当前角色
                if ($res['id'] == $id) {
                    continue;
                }
                $option_html .= '<option value=' . $res['id'] . '>' . $res['title'] . '</option>';
            }
            $html = $select_html . $option_html . "</select></div>";
            echo $html;
        }

    }

    /*联动当前角色获取*/
    public function currentRole()
    {
        //当前角色下添加，角色显示带有当前角色
        $addid = I('post.current_addid');
        if ($addid) {
            $result = M('auth_group')->where(array('id=' . $addid))->find();
            $parent = explode(',', $result['path']);
            $parent_ids = array_filter($parent);
            $thtml = '';
            foreach ($parent_ids as $vo) {
                $thtml .= $this->parentRoles($vo, $id);
            }
        } else {
            //编辑当前角色显示不含本角色
            $id = I('post.current_id');
            $result = M('auth_group')->where(array('id=' . $id))->find();
            $parent = explode(',', $result['path']);
            $parent_ids = array_filter($parent);
            $thtml = '';
            foreach ($parent_ids as $vo) {
                if ($vo != $id) {
                    $thtml .= $this->parentRoles($vo, $id);
                }
            }
        }
        echo $thtml;
    }

    public function parentRoles($pid, $id)
    {
        $result = M('auth_group')->field('parent')->where(array('id=' . $pid))->find();
        $results = M('auth_group')->where(array('parent=' . $result['parent']))->select();
        $option_html = "";
        $select_html = '<select name="parent[]"  id="sub_category_id" class="parent" style="height:30px;min-width:120px;margin-right:5px;border-color:#ccc;" > <option value="">--请选择--</option>';
        if ($result) {
            foreach ($results as $res) {
                if ($res['id'] == $pid) {
                    $option_html .= '<option selected value=' . $res['id'] . ' >' . $res['title'] . '</option>';
                } else {
                    $option_html .= '<option value=' . $res['id'] . ' >' . $res['title'] . '</option>';
                }

            }

        }
        $html = $select_html . $option_html . "</select>";
        return $html;
    }

}
