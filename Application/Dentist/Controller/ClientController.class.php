<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Dentist\Controller;

/**
 * 工作室 牙医管理控制器 : LGW
 */
class ClientController extends AdminController {
	private $model;
	
	// 构造函数
	public function __construct() {
		parent::__construct ();
		$this->model = D ( 'Dentist' ); // 牙医Model
	}
	public function index() {
		$id = UID;
		if (empty ( $id )) {
			$this->error ( L ( 'PLEASE_SELECT_DATA' ) );
		}
		$list = $this->model->where ( "uid=" . $id )->find ();
		if (empty ( $list )) {
			$this->error ( L ( 'Data_not_exist' ) );
		}
		$this->assign ( 'list', $list );
		$this->assign ( 'regions', D ( "region" )->get_options ( 0 ) );
		$this->display ();
	}
	public function edit() {
		if (IS_POST) {
			$Model = M (); // 实例化一个空对象
			$Model->startTrans (); // 开启事务
			$id = empty ( $_POST ['id'] ) ? 0 : trim ( $_POST ['id'] );
			
			$lists = $this->model->where ( "uid=" . UID )->find ();
			if (empty ( $lists)) {
				$this->error ( L ( 'Data_not_exist' ) );
			}
			$logo = empty ( $_POST ['logo'] ) ? '' : trim ( $_POST ['logo'] );
			$regionid = empty ( $_POST ['regionid'] ) ? '' : trim ( $_POST ['regionid'] );
			$country = '';
			$province = '';
			$city = '';
			if ($regionid) {
				$arr = explode ( ',', $regionid );
				foreach ( $arr as $k => $v ) {
					if ($k == 0) {
						$country = $v;
					} elseif ($k == 1) {
						$province = $v;
					} elseif ($k == 2) {
						$city = $v;
					}
				}
			}
			$regionname = empty ( $_POST ['regionname'] ) ? '' : trim ( $_POST ['regionname'] );
			$addr = empty ( $_POST ['addr'] ) ? '' : trim ( $_POST ['addr'] );
			$tel = empty ( $_POST ['tel'] ) ? '' : trim ( $_POST ['tel'] );
			$contact = empty ( $_POST ['contact'] ) ? '' : trim ( $_POST ['contact'] );
			$description = empty ( $_POST ['description'] ) ? '' : trim ( $_POST ['description'] );
			$data = array (
					'denid' => $id,
					'pic' => $logo,
					'country' => $country,
					'province' => $province,
					'city' => $city,
					'regionname' => $regionname,
					'addr' => $addr,
					'tel' => $tel,
					'contact' => $contact,
					"enabled"=>I("post.enabled"),
					'description' => $description 
			);
			$stuid = $this->model->save ( $data );
			if ($stuid !== false) {
				$history = array ();
				foreach ( $data as $key => $vo ) {
					if ($vo != $lists [$key]) {
						$history [] = array (
								'field' => $key,
								'olddata' => $lists [$key],
								'newdata' => $vo 
						);
					}
				}
				action_log_new ( array (
						'history' => $history,
						'outtype' => 'ot_dentist',
						'outkey' => $id,
						'action' => 'edit',
						'comment' => '' 
				) );
				$Model->commit (); // 成功则提交事务
				$this->redirect ( 'Client/index' );
			} else {
				$Model->rollback (); // 否则将事务回滚
				$this->error ( L ( 'EDIT_ERROR' ) );
			}
		} else {
			$id = empty ( $_GET ['id'] ) ? 0 : $_GET ['id'];
			if (empty ( $id )) {
				$this->error ( L ( 'PLEASE_SELECT_DATA' ) );
			}
			$list = $this->model->where ( "uid='".UID."' and denid=" . $id )->find ();
			if (empty ( $list )) {
				$this->error ( L ( 'Data_not_exist' ) );
			}
			if ($list ['city']) {
				$list ['regionid'] = $list ['city'];
			} elseif ($list ['province']) {
				$list ['regionid'] = $list ['province'];
			} elseif ($list ['country']) {
				$list ['regionid'] = $list ['country'];
			} else {
				$list ['regionid'] = 0;
			}
			$this->assign ( 'list', $list );
			$this->assign ( 'regions', D ( "region" )->get_options ( 0 ) );
			$this->display ();
		}
	}
	
	// 异步上传图片
	public function uploadPic($files = "") {
		$c = C ( 'DOWNLOAD_UPLOAD' );
		$uploader = new \Think\Upload ( $c ); // 实例化上传类
		$method = $_SERVER ["REQUEST_METHOD"];
		$filename = I ( 'get.filename' );
		if ($method == "POST") {
			header ( "Content-Type: text/plain" );
			if ($files === '') {
				$files = $_FILES;
			}
			$info = $uploader->upload ( $files );
			$result ['success'] = true;
			$result ['uploadName'] = $c ['rootPath'] . $info ['qqfile'] ['savepath'] . $info ['qqfile'] ['savename'];
			echo json_encode ( $result );
		} else {
			header ( "HTTP/1.0 405 Method Not Allowed" );
		}
	}
}


