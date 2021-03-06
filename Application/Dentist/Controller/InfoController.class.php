<?php

namespace Studio\Controller;
use Think\Page;
/**
 * 设计工作室控制器 ：ZL
 *
 */
class InfoController extends AdminController
{
	private $model;
	
	//构造函数
	public function __construct()
	{
		parent::__construct();
		$this->model = D('Info');    // 设计工作室Model
	}
	/*
     * 工作室首页
     * */
	public function index(){
		if(IS_POST){
			$Model = M(); // 实例化一个空对象
			$Model->startTrans(); // 开启事务
			$id = empty($_POST['id'])?0:trim($_POST['id']);

            $lists  = M('Studio')->where("stuid=".$id)->find();

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
			$tag = '';
			if(is_array($tags)){
				$tag = trim(implode(',',$tags),',');
			}
			$description = empty($_POST['description'])?'':trim($_POST['description']);
			$language = empty($_POST['language'])?'':trim($_POST['language']);
			$enabled = empty($_POST['enabled'])?0:trim($_POST['enabled']);
			$data = array(
				'stuid' => $id,
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
			);
			$stuid = M('Studio')->save($data);
			if ($stuid != false) {
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
				action_log_new(array('history'=>$history, 'outtype' => 'ot_studio', 'outkey' => $id, 'action' => 'edit', 'comment' => ''));
				$Model->commit(); // 成功则提交事务
				$this->redirect('Info/index');
			} else {
				$Model->rollback(); // 否则将事务回滚
				$this->error(L('EDIT_ERROR'));
			}
		}else{
		    
            //获取工作室id
            if(UID){
                $uid = UID;
                $user = M('Member')->where("uid=".$uid)->find();
                if(empty($user)){
                    $this->error(L('STUDIO_NOT'));
                }
            }else{
                $this->error(L('STUDIO_NOTIN_LOGIN'));
            }

            $id = empty($user['stuid'])?0:$user['stuid'];
			if(empty($id)){
				$this->error(L('PLEASE_SELECT_DATA'));
			}
			$list  = M('Studio')->where("stuid=".$id)->find();
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
			$this->assign('tags', $tags);
			$this->assign('list', $list);
			$this->assign('regions', D("region")->get_options(0));
			$this->display();
		}
	}
	//异步上传图片
	public function uploadPic($files = "")
	{
		$c = C('DOWNLOAD_UPLOAD');
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
}
