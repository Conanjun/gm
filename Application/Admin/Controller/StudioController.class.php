<?php

namespace Admin\Controller;
use User\Api\UserApi;
use Think\Page;
/**
 * 设计工作室控制器 ：ZL
 *
 */
class StudioController extends AdminController
{
	private $model;
	
	//构造函数
	public function __construct()
	{
		parent::__construct();
		$this->model = D('Studio');    // 设计工作室Model
	}
	/*
     * 工作室首页
     * */
	public function index(){
		$where = " 1=1 ";
		$filter= '';
		$name = empty($_GET['name'])?'':trim($_GET['name']);//工作室名称
		if($name){
			$filter .= " and s.name like '%{$name}%'";
		}
		$code = empty($_GET['code'])?'':trim($_GET['code']);//code
		if($code){
			$filter .= " and  s.code like '%{$code}%'";
		}
		
		$addr = empty($_GET['addr'])?'':trim($_GET['addr']);//地址
		if($addr){
			$filter .= " and s.addr like '%{$addr}%'";
		}
		
		$contact= I("get.contact");;//联系人 联系电话
		if($contact){
			$filter .= " and (s.tel like '%{$contact}%' or s.contact like '%{$contact}%' )";
		}
		
		$regionname = empty($_GET['regionname'])?'':trim($_GET['regionname']);//所在区域
		if($regionname){
			$filter .= " and s.regionname like '%{$regionname}%'";
		}
		$urlparam = empty($_GET['urlparam'])?'':trim($_GET['urlparam']);//工作室标识
		if($urlparam){
			$filter .= " and s.urlparam like '%{$urlparam}%'";
		}
		$enabled = empty($_GET['enabled'])?'':trim($_GET['enabled']);//是否可用
		$enabled == 1 and  $filter .= " and s.enabled = 1";
		$enabled == 2 and  $filter .= " and s.enabled = 0";
		
		
		$pro=empty($_GET["pro"])?"":$_GET["pro"];
		if($pro){
			foreach ($pro as $v){
				$filter .=" and EXISTS (select ss.sid,ss.stuid,ss.type from ot_studio_service ss where ss.stuid=s.stuid and ss.type='{$v}') ";
			}
		}
		
		
		$where .= $filter;

		//更新排序
		if (isset($_GET['sort']) && isset($_GET['order'])) {
			$sort = strtolower(trim($_GET['sort']));
			$order = strtolower(trim($_GET['order']));
			if (!in_array($order, array('asc', 'desc'))) {
				$sort = 's.stuid';
				$order = 'desc';
			}
		} else {
			$sort = 's.stuid';
			$order = 'desc';
		}

		$count = $this->model->countNum($where);
		$page = new \Think\Page($count, 10);
		$lists = $this->model
				->alias('s')
				->where($where)
				->order("$sort $order")
				->limit($page->firstRow . ',' . $page->listRows)
				->select();
		
		if($lists){
			$ssmod=M("StudioService");
			$s="";
			foreach ($lists as $k=>$v){
				$h=$ssmod->where("stuid='{$v["stuid"]}'")->select();
				$s="";
				if($h){
					foreach ($h as $kk=>$vv){
						$s.=L($vv["type"]).",";
					}
					$lists[$k]["ss"]=trim($s,",");
				}
			}
		}
		
		$sts = M('Dictionary')->where("d_code='ser_type'")->field('*')->select();
		if($sts){
			foreach ($sts as $k=>$v){
				$sts[$k]["name"]=L($v["d_value"]);
			}
		}
		$this->assign('pvs', $sts);
				
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$this->assign('lists', $lists);
		$this->assign('_page', $page->show());
		$this->assign('regions', D("region")->get_options(0));
		$this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
		$this->display();
	}
	/*
     * 新增工作室
     * */
	public function add(){
		if(IS_POST){
			$Model = M(); // 实例化一个空对象
			$Model->startTrans(); // 开启事务
		/*	header("Content-type: text/html; charset=utf-8");
			p($_POST);die;*/
            $username = empty($_POST['username'])?'':$_POST['username'];
            $password = empty($_POST['password'])?'':$_POST['password'];
            $nickname = empty($_POST['nickname'])?'':$_POST['nickname'];

			$name = empty($_POST['name'])?'':$_POST['name'];

			if(empty($username)){
				$this->error(L('USERNAME_NOT_EMPTY'));
			}
			if(empty($password)){

				$this->error(L('PASSWORD_NOT_EMPTY'));
			}
			if(empty($nickname)){
				$this->error(L('NICKNAME_NOT_EMPTY'));
			}
			
			if(empty($name)){//名称不能为空
				$this->error(L('NAME_NOT_EMPTY'));
			}

			if($this->model->uniqueName($name)){//名称已存在
				$this->error(L('NAME_EXISTED'));
			}


			$logo = empty($_POST['logo'])?'':trim($_POST['logo']);
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
			$urlparam = empty($_POST['urlparam'])?'':trim($_POST['urlparam']);
			$tags = empty($_POST['tags'])?'':$_POST['tags'];
			if(!empty($urlparam)){
				if($this->model->uniqueUrlParam($urlparam)){//工作室标识已存在
					$this->error(L('URL_EXISTED'));
				}
			}
			$tag = '';
			if(is_array($tags)){
				$tag = trim(implode(',',$tags),',');
			}
			$description = empty($_POST['description'])?'':trim($_POST['description']);
			$language = empty($_POST['language'])?'':trim($_POST['language']);
			$enabled = empty($_POST['enabled'])?0:trim($_POST['enabled']);
			$code = $this->model->getCode();
			$data = array(
				'name' => $name,
				'logo' => $logo,
				'code'=>$code,
				'country' => $country,
				'province' => $province,
				'city' => $city,
				'regionname' => $regionname,
				'addr' => $addr,
				'tel' => $tel,
				'contact' => $contact,
				'urlparam' => $urlparam,
				'tag' => $tag,
				'description' => $description,
				'language' => $language,
				'enabled' => $enabled,
				'addtime' => time(),
			);

			$stuid = $this->model->add($data);
			if($stuid){

                //创建预定义工作室角色
                $authdefaults = M('AuthDefault')->field(true)->select();
                if($authdefaults){

                    foreach($authdefaults as $vo){
                        $authGroup = array(
                            'module' => 'Studio',
                            'type' => 1,
                            'title' => $vo['title'],
                            'description' => $name.$vo['title'],
                            'rules' => $vo['rules'],
                            'grade' => 1,
                            'stuid' => $stuid,
                            'fromadmin'=>'1',
                            'designer'=>$vo['designer'],
                        );
                        $agid = M('AuthGroup')->add($authGroup);
                    }
                }

				$ps = empty($_POST['ps'])?'':$_POST['ps'];
				if(is_array($ps)){
					foreach ($ps as $v){
						if($v){
							M("StudioService")->add(array("stuid"=>$stuid,"type"=>$v,"addtime"=>time(),"adduid"=>UID));
						}
					}
				}

				//创建预定义工作室管理员
                $User = new UserApi;
                $email = time().'@gm.com';
                $mobile ='';
                $uid = $User->register($username, $password, $email, $mobile);
                if (0 < $uid) { //注册成功
                    $user = array('uid' => $uid, 'nickname' =>$nickname, 'status' => 1,'stuid' =>$stuid,'module'=>'Studio');
                    $uid = M('Member')->add($user);
                    $auth =  new  AuthManagerController();
                    $auth->updateRules();
                    $mlist = M('Auth_rule')->field('id')->where("module= 'Studio'")->order('id asc')->select();

                    $ids = array_column($mlist, 'id');
                    $rules = '';
                    if(!empty($ids)){
                        $rules = implode(',', $ids);
                    }
                    $authGroup = array(
                        'module' => 'Studio',
                        'type' => 1,
                        'title' => '工作室管理员',
                        'description' => '',
                        'rules' => $rules,
                        'grade' => 1,
                        'stuid' => $stuid,
                        'fromadmin'=>'2',
                        'designer'=>'0',
                    );
                    $agid = M('AuthGroup')->add($authGroup);
                    if($agid && $uid){
                        $authGroupAccess = array(
                            'uid' => $uid,
                            'group_id' => $agid,
                        );
                        M('AuthGroupAccess')->add($authGroupAccess);
                    }


                } else { //注册失败，显示错误信息
                    $this->error($this->showRegError($uid));
                }

			}

			if (!empty($stuid)) {
				action_log_new(array('outtype' => 'ot_studio', 'outkey' => $stuid, 'action' => 'add', 'comment' => ''));
				$Model->commit(); // 成功则提交事务
				$this->redirect('Studio/index');
			} else {
				$Model->rollback(); // 否则将事务回滚
				$this->error(L('ADD_ERROR'));
			}
		}else{
			$lists = array('enabled'=>1);
			$tags = M("Tag")->where(array('tag_type'=>'studio'))->select();
			$this->assign('tags', $tags);
			$this->assign('lists', $lists);
			$this->assign('regions', D("region")->get_options(0));
			
			$sts = M('Dictionary')->where("d_code='ser_type'")->field('*,0 as h')->select();
			if($sts){
				foreach ($sts as $k=>$v){
					$sts[$k]["name"]=L($v["d_value"]);
				}
			}
			$this->assign('sts', $sts);
			
			
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

        $name = $_POST['name'];
        $id = $_POST['id'];
        if ($id) {
            if (M('Studio')->where("name='{$name}' and stuid !=" . $id)->find())
                echo 'false';
            else
                echo 'true';
        } else {
            if (M('Studio')->where(['name' => $name])->find())
                echo 'false';
            else {
                echo 'true';
            }

        }

    }

    public function check_url()
    {
        $urlparam = $_POST['urlparam'];
        $id = $_POST['id'];
        if ($id) {
            if (M('Studio')->where("urlparam='{$urlparam}' and stuid !=" . $id)->find())
                echo 'false';
            else
                echo 'true';
        } else {
            if (M('Studio')->where(['urlparam' => $urlparam])->find())
                echo 'false';
            else {
                echo 'true';
            }

        }

    }

	/*
     * 编辑工作室
     * */
	public function edit(){
		if(IS_POST){
			$Model = M(); // 实例化一个空对象
			$Model->startTrans(); // 开启事务
			$id = empty($_POST['id'])?0:trim($_POST['id']);
			$where = "stuid = {$id}";
			$lists =$this->model->getList($where);
			if(empty($lists)){
				$this->error(L('Data_not_exist'));
			}
			
			$password = empty($_POST['password'])?'':trim($_POST['password']);
			$nickname = empty($_POST['nickname'])?'':trim($_POST['nickname']);
			
			if(empty($nickname)){
				$this->error(L('NICKNAME_NOT_EMPTY'));
			}
			
			$name = empty($_POST['name'])?'':trim($_POST['name']);
			if(empty($name)){//工作室不存在
				$this->error(L('NAME_NOT_EMPTY'));
			}
			
			if($this->model->uniqueName($name,$id)){//工作室已存在
				$this->error(L('NAME_EXISTED'));
			}

			$logo = empty($_POST['logo'])?'':trim($_POST['logo']);
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
			$urlparam = empty($_POST['urlparam'])?'':trim($_POST['urlparam']);
            if($this->model->uniqueUrlParam($name,$id)){//工作室标识已存在
                $this->error(L('URL_EXISTED'));
            }
			$tags = empty($_POST['tags'])?'':$_POST['tags'];
			$tag = '';
			if(is_array($tags)){
				$tag = trim(implode(',',$tags),',');
			}
			$description = empty($_POST['description'])?'':trim($_POST['description']);
			$language = empty($_POST['language'])?'':trim($_POST['language']);
			$enabled = empty($_POST['enabled'])?0:trim($_POST['enabled']);
			$data = array(
				'stuid' => $id,
				'name' => $name,
				'logo' => $logo,
				'country' => $country,
				'province' => $province,
				'city' => $city,
				'regionname' => $regionname,
				'addr' => $addr,
				'tel' => $tel,
				'contact' => $contact,
				'urlparam' => $urlparam,
				'tag' => $tag,
				'description' => $description,
				'language' => $language,
				'enabled' => $enabled,
			);
			$stuid = $this->model->save($data);
			if ($stuid !== false) {
				
				M("StudioService")->where("stuid='{$id}'")->delete();
				$ps = empty($_POST['ps'])?'':$_POST['ps'];
				if(is_array($ps)){
					foreach ($ps as $v){
						if($v){
							M("StudioService")->add(array("stuid"=>$id,"type"=>$v,"addtime"=>time(),"adduid"=>UID));
						}
					}
				}
				
				
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
				
				if($password){
					$res = M('Ucenter_member')->where('id = ' . $id)->save(['password'=>$_POST['password']]);
					if ($res !== false) {
						
					} else {
						$this->error(L('EDIT_ERROR'));
					}
				}
               
                
                $re = M('Member')->where('uid = ' .$_POST['uid'])->save(['nickname'=>$_POST['nickname']]);

				action_log_new(array('history'=>$history, 'outtype' => 'ot_studio', 'outkey' => $id, 'action' => 'edit', 'comment' => ''));
				$Model->commit(); // 成功则提交事务
				$this->redirect('Studio/index');
			} else {
				$Model->rollback(); // 否则将事务回滚
				$this->error(L('EDIT_ERROR'));
			}
		}else{
			$id = empty($_GET['id'])?0:$_GET['id'];
			if(empty($id)){
				$this->error(L('PLEASE_SELECT_DATA'));
			}
			$where = "stuid = {$id}";
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
			$image_info = getimagesize($list['logo']);
			$image_data = fread(fopen($list['logo'], 'r'), filesize($list['logo']));
			//$list['logo1'] = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
			$tags = M("Tag")->field('tag_id,tag_name,0 as h')->where(array('tag_type'=>'studio'))->select();
			if ($tags && $list['tag']) {
				$tag = explode(',',$list['tag']);
				foreach ($tag as $vv) {
					foreach ($tags as $k => $v) {
						if($vv == $v['tag_name']){
							$r = M("Tag")->where("tag_type = 'studio' and '," . $vv . ",' like concat('%,',tag_name,',%')")->getField('tag_id');
							if ($r) {
								$tags[$k]['h'] = 1;
								break;
							}
						}
					}
				}
			}
			
			$sts = M('Dictionary')->where("d_code='ser_type'")->field('*,0 as h')->select();
			if($sts){
				$ssmod=M("StudioService");
				foreach ($sts as $k=>$v){
					$sts[$k]["name"]=L($v["d_value"]);
					$h=$ssmod->where("stuid='{$id}' and type='{$v['d_value']}'")->find();
					if($h){
						$sts[$k]["h"]=1;
					}
				}
			}
			$this->assign('sts', $sts);
			

            $user = M("Member")->join("left join ot_ucenter_member um on um.id=ot_member.uid")
                    ->join("left join ot_auth_group_access aga on aga.uid=ot_member.uid")
                    ->join('left join ot_auth_group ag on  ag.id=aga.group_id')
                ->field('ot_member.uid,nickname,um.password,um.username')->where('ot_member.stuid='.$id)->find();
            $this->assign('user', $user);
			$this->assign('tags', $tags);
			$this->assign('list', $list);
			$this->assign('regions', D("region")->get_options(0));
			$this->display();
		}
	}
	//异步上传图片
	public function uploadPic($files = "")
	{
		$c = C('PICTURE_UPLOAD');
		$uploader = new \Think\Upload($c);// 实例化上传类
		$method = $_SERVER["REQUEST_METHOD"];
		$filename = I('get.filename');
		if ($method == "POST") {
			header("Content-Type: text/plain");
			if($files===''){
				$files  =   $_FILES;
			}
			$info = $uploader->upload($files);
			$result['success'] = true;
			$result['uploadName'] = $c['rootPath'].$info['qqfile']['savepath'].$info['qqfile']['savename'];
			echo json_encode($result);
		} else {
			header("HTTP/1.0 405 Method Not Allowed");
		}
		
	}
	//异步修改数据
	public function ajax_col()
	{
		$id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		$column = empty($_GET['column']) ? '' : trim($_GET['column']);
		$value = isset($_GET['value']) ? trim($_GET['value']) : '';
		$data = array();

		if (in_array($column, array('enabled'))) {
			$list =$this->model->getList("studio = '$id'");
			$data[$column] = $value;
			$lists = $this->model->where('stuid=' . $id)->save($data);
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
				action_log_new(array('history'=>$history, 'outtype' => 'ot_studio', 'outkey' => $id, 'action' => 'edit', 'comment' => ''));
				echo   'true';
			}else{
				return;
			}

		} else {
			return;
		}
		return;
	}
	//删除数据
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
			$where = "stuid = {$id}";
			$list =$this->model->getList($where);
			$o=M("Order")->where("stuid='{$id}'")->find();
			if($o){
				$failmsg.="{$list['name']}".L("DEL_FAIL")."<br>";
			}else{
				$res = $this->model->where($where)->delete();
				action_log_new(array('outtype' => 'ot_studio', 'outkey' => $id, 'action' => 'delete', 'comment' => ''));
				$sucmsg.="{$list['name']}".L("DELETE_SUCCESS")."<br>";
			}
		}
		$this->json_success($failmsg.$sucmsg);
	}
	
	public function checkname(){
		$name=I("get.username","");
		$id=I("get.id","");
		
		if(D("UcenterMember")->uniqueName($name,$id)){//工作室已存在
			echo json_encode(false);
			return;
		}
		echo json_encode(true);
		
	}
	
}
