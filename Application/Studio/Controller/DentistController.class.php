<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Studio\Controller;
use User\Api\UserApi;
use Common\Common\Super\Order;
/**
 * 工作室 牙医管理控制器 : LGW
 */
class DentistController extends AdminController
{
    private $model;

    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Dentist');    // 牙医Model
    }

    /**
     *牙医管理首页
     */
    public function index()
    {
        $stuid = Order::get_stuid(UID);   // 工作室id
        $where = "1=1 and m.stuid = {$stuid}";         // 当前工作室下的牙医
		
		$filter= '';
		$name = empty($_GET['name'])?'':trim($_GET['name']);
		if($name){
			$filter .= " and d.name like '%{$name}%'";
		}
		
		$regionname = empty($_GET['regionname'])?'':trim($_GET['regionname']);//所在区域
		if($regionname){
			$filter .= " and d.regionname like '%{$regionname}%'";
		}
		$addr = empty($_GET['addr'])?'':trim($_GET['addr']);//地址
		if($addr){
			$filter .= " and d.addr like '%{$addr}%'";
		}
		$contact = empty($_GET['contact'])?'':trim($_GET['contact']);//联系人
		if($contact){
			$filter .= " and d.contact like '%{$contact}%' or d.tel like '%{$contact}%'";
		}
        $pay_type = empty($_GET['pay_type'])?'':trim($_GET['pay_type']);//是否可用
        $pay_type == 1 and  $filter .= " and d.paytype = 1";
        $pay_type == 2 and  $filter .= " and d.paytype = 0";

		$enabled = empty($_GET['enabled'])?'':trim($_GET['enabled']);//是否可用
		$enabled == 1 and  $filter .= " and d.enabled = 1";
		$enabled == 2 and  $filter .= " and d.enabled = 0";
		$where .= $filter;

		//更新排序
		if (isset($_GET['sort']) && isset($_GET['order'])) {
			$sort = strtolower(trim($_GET['sort']));
			$order = strtolower(trim($_GET['order']));
			if (!in_array($order, array('asc', 'desc'))) {
				$sort = 'd.denid';
				$order = 'desc';
			}
		} else {
			$sort = 'd.denid';
			$order = 'desc';
		}

		$count = $this->model->countNum($where);
		$page = new \Think\Page($count, 10);
		$lists = $this->model
				->alias('d')
				->join('ot_member m on d.uid = m.uid')
				->where($where)
				->order("$sort $order")
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->assign('regions', D("region")->get_options(0));
		$this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
		$this->display();
    }

    /**
     * 新增牙医
     */
    public function add()
    {
        $stuid = Order::get_stuid(UID);
		$time = time();
        if(IS_POST){
			$Model = M(); // 实例化一个空对象
			$Model->startTrans(); // 开启事务
		/*	header("Content-type: text/html; charset=utf-8");
			p($_POST);die;*/

            $username = empty($_POST['username'])?'':trim($_POST['username']);
            $password = empty($_POST['password'])?'':trim($_POST['password']);
            $nickname = empty($_POST['nickname'])?'':trim($_POST['nickname']);

			$name = empty($_POST['name'])?'':trim($_POST['name']);
			if(empty($name)){//名称不能为空
				$this->error(L('NAME_NOT_EMPTY'));
			}

			if($this->model->uniqueName($name)){//名称已存在
				$this->error(L('CLINIC_EXISTED'));
			}
			$pic = empty($_POST['pic'])?'':trim($_POST['pic']);
			$regionid = empty($_POST['regionid'])?'':trim($_POST['regionid']);
			$country = '';
			$province = '';
			$city = '';
			if($regionid){
				$arr = explode(',',$regionid);
				foreach($arr as $k => $v){
					if($k == 0){
						$country = $v;
					}elseif($k ==1 ){
						$province = $v;
					}elseif($k ==2){
						$city = $v;
					}
				}
			}
			$regionname = empty($_POST['regionname'])?'':trim($_POST['regionname']);
			$addr = empty($_POST['addr'])?'':trim($_POST['addr']);
			$tel = empty($_POST['tel'])?'':trim($_POST['tel']);
			$contact = empty($_POST['contact'])?'':trim($_POST['contact']);
			$pay_type = empty($_POST['pay_type'])?'':trim($_POST['pay_type']);
			$description = empty($_POST['description'])?'':trim($_POST['description']);
			$enabled = empty($_POST['enabled'])?0:trim($_POST['enabled']);
			
			//创建预定义诊所管理员
			$User = new UserApi;
			$email = time().'@gm.com';
			$mobile ='';
			$uid = $User->register($username, $password, $email, $mobile);
			if (0 < $uid) { //注册成功
				$user = array('uid' => $uid, 'nickname' =>$nickname, 'status' => 1,'stuid' =>$stuid,'module'=>'Dentist');
				$uid = M('Member')->add($user);
				
			} else { //注册失败，显示错误信息
				$this->error($this->showRegError($uid));
			}
				
			$data = array(
				'name' => $name,
				'pic' => $pic,
				'country' => $country,
				'province' => $province,
				'city' => $city,
				'regionname' => $regionname,
				'addr' => $addr,
				'tel' => $tel,
				'contact' => $contact,
				'paytype' => $pay_type,
				'description' => $description,
				'enabled' => $enabled,
				'addtime'=>$time,
				'adduid'=>UID,
				'uid'=>$uid,
				
			);
			$denid = $this->model->add($data);
			if($denid){
				
				//关联表
				
				M('Dentist_relation')->add(['denid'=>$denid,'stuid'=>$stuid,'addtime'=>$time,'adduid'=>UID]);
				
				$auth =  new  AuthManagerController();
                  $auth->updateRules();
                    $mlist = M('Auth_rule')->field('id')->where("module= 'Dentist'")->order('id asc')->select();

                    $ids = array_column($mlist, 'id');
                    $rules = '';
                    if(!empty($ids)){
                        $rules = implode(',', $ids);
                    }
                    $authGroup = array(
                        'module' => 'Dentist',
                        'type' => 1,
                        'title' => '诊所管理员',
                        'description' => '',
                        'rules' => $rules,
                        'grade' => 1,
                        'stuid' => $stuid,
                    );
                    $agid = M('AuthGroup')->add($authGroup);
                    if($agid && $uid){
                        $authGroupAccess = array(
                            'uid' => $uid,
                            'group_id' => $agid,
                        );
                        M('AuthGroupAccess')->add($authGroupAccess);
                    }

			}
			if (!empty($denid)) {
				action_log_new(array('outtype' => 'ot_studio', 'outkey' => $denid, 'action' => 'add', 'comment' => ''));
				$Model->commit(); // 成功则提交事务
				$this->redirect('Dentist/index');
			} else {
				$Model->rollback(); // 否则将事务回滚
				$this->error(L('ADD_ERROR'));
			}
		}else{
			$lists = array('enabled'=>1);
			$this->assign('lists', $lists);
			$this->assign('regions', D("region")->get_options(0));
			$this->display();
		}
    }

	/**
     * 获取用户注册错误信息
     *
     * @param  integer $code 错误编码
     *
     * @return string        错误信息
     */
    private function showRegError($code = 0)
    {
        switch ($code) {
            case -1:
                $error = '用户名长度必须在16个字符以内！';
                break;
            case -2:
                $error = '用户名被禁止注册！';
                break;
            case -3:
                $error = '用户名被占用！';
                break;
            case -4:
                $error = '密码长度必须在6-30个字符之间！';
                break;
            case -5:
                $error = '邮箱格式不正确！';
                break;
            case -6:
                $error = '邮箱长度必须在1-32个字符之间！';
                break;
            case -7:
                $error = '邮箱被禁止注册！';
                break;
            case -8:
                $error = '邮箱被占用！';
                break;
            case -9:
                $error = '手机格式不正确！';
                break;
            case -10:
                $error = '手机被禁止注册！';
                break;
            case -11:
                $error = '手机号被占用！';
                break;
            default:
                $error = '未知错误';
        }
        return $error;
    }

    public function check_user()
    {
        $username = $_POST['username'];
        $id = $_POST['id'];
        if ($id) {
            if (M('UcenterMember')->where("username='{$username}' and id !=" . $id)->find())
                echo 'false';
            else
                echo 'true';
        } else {
            if (M('UcenterMember')->where(['username' => $username])->find())
                echo 'false';
            else {
                echo 'true';
            }

        }

    }

    public function check_name()
    {
        //$stuid = Order::get_stuid(UID);   // 工作室id
        $name = $_POST['name'];
        $id = $_POST['id'];

        if ($id) {
            if (M('Dentist')->where("name='{$name}' and id !=" . $id)->find())
                echo 'false';
            else
                echo 'true';
        } else {
            if (M('Dentist')->where(['name' => $name])->find())
                echo 'false';
            else {
                echo 'true';
            }

        }

    }
    /**
     * 编辑牙医
     */
    public function edit()
    {
        if(IS_POST){
			$Model = M(); // 实例化一个空对象
			$Model->startTrans(); // 开启事务
			$id = empty($_POST['id'])?0:trim($_POST['id']);
			$where = "d.denid = {$id}";
			$lists =$this->model->getList($where);
			if(empty($lists)){
				$this->error(L('Data_not_exist'));
			}
			
			$name = empty($_POST['name'])?'':trim($_POST['name']);
			if(empty($name)){
				$this->error(L('NAME_NOT_EMPTY'));
			}
			
			if($this->model->uniqueName($name,$id)){
				$this->error(L('NAME_EXISTED'));
			}
            $pic = empty($_POST['pic'])?'':trim($_POST['pic']);
			$regionid = empty($_POST['regionid'])?'':trim($_POST['regionid']);
			$country = '';
			$province = '';
			$city = '';
			if($regionid){
				$arr = explode(',',$regionid);
				foreach($arr as $k => $v){
					if($k == 0){
						$country = $v;
					}elseif($k ==1 ){
						$province = $v;
					}elseif($k ==2){
						$city = $v;
					}
				}
			}
			$pay_type = empty($_POST['pay_type'])?'':trim($_POST['pay_type']);
			$regionname = empty($_POST['regionname'])?'':trim($_POST['regionname']);
			$addr = empty($_POST['addr'])?'':trim($_POST['addr']);
			$tel = empty($_POST['tel'])?'':trim($_POST['tel']);
			$contact = empty($_POST['contact'])?'':trim($_POST['contact']);
			$description = empty($_POST['description'])?'':trim($_POST['description']);
			$enabled = empty($_POST['enabled'])?0:trim($_POST['enabled']);
			$data = array(
				'denid'=>$id,
				'name' => $name,
				'pic' => $pic,
				'country' => $country,
				'province' => $province,
				'city' => $city,
				'regionname' => $regionname,
				'addr' => $addr,
				'tel' => $tel,
				'contact' => $contact,
				'paytype' => $pay_type,
				'description' => $description,
				'enabled' => $enabled,
			);
			$stuid = $this->model->save($data);
			if ($stuid !== false) {
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
                $res =  M('Member')->where('uid = ' .$_POST['uid'])->save(['nickname'=>$_POST['nickname']]); 
               
                if ($_POST['password'] != '') {
                	//		        $password=think_ucenter_md5($pwd);
                	$api = new UserApi();
                	$api->updatepassword($_POST['uid'], $_POST['password']);
                }
                

				action_log_new(array('history'=>$history, 'outtype' => 'ot_studio', 'outkey' => $id, 'action' => 'edit', 'comment' => ''));
				$Model->commit(); // 成功则提交事务
				$this->redirect('Dentist/index');
			} else {
				$Model->rollback(); // 否则将事务回滚
				$this->error(L('EDIT_ERROR'));
			}
		}else{
			$id = empty($_GET['id'])?0:$_GET['id'];
			if(empty($id)){
				$this->error(L('PLEASE_SELECT_DATA'));
			}
			$where = "d.denid = {$id}";
			$list =$this->model->getList($where);
			if(empty($list)){
				$this->error(L('Data_not_exist'));
			}
			if($list['city']){
				$list['regionid'] = $list['city'];
			}elseif($list['province']){
				$list['regionid'] = $list['province'];
			}elseif($list['country']){
				$list['regionid'] = $list['country'];
			}else{
				$list['regionid'] = 0;
			}

            $user = M("Member")->join("left join ot_ucenter_member um on um.id=ot_member.uid")
                    ->join("left join ot_dentist d on d.uid=ot_member.uid")
                ->field('d.uid,nickname,um.password,um.username')->where('d.uid='.$list['uid'])->find();
            $this->assign('user', $user);
			$this->assign('list', $list);
			$this->assign('regions', D("region")->get_options(0));
			$this->display();
		}
    }
	

    /*
     * 删除
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
        		$where = "denid = {$id}";
        		$list =$this->model->getList($where);
        		$o=M("Order")->where("denid='{$id}'")->find();
        		if($o){
        			$failmsg.="{$list['name']}".L("DEL_FAIL")."<br>";
        		}else{
        			$res = $this->model->where($where)->delete();
        			action_log_new(array('outtype' => 'ot_dentist', 'outkey' => $id, 'action' => 'delete', 'comment' => ''));
        			$sucmsg.="{$list['name']}".L("DELETE_SUCCESS")."<br>";
        		}
        	}
        	$this->json_success($failmsg.$sucmsg);
        	     
        }

}


