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
 * 工作室控制器
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class IndexController extends AdminController
{

	private $meta_title;

	/**
	 * 工作室首页
	 *
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function index()
	{
		if (UID) {
			$this->meta_title = '首页';



			//患者数
			$pnum=M("Patient")->where("denid='".UID."'")->count();

			$stime= strtotime(date('Ymd 00:00', time()));
			$etime= strtotime(date('Ymd 00:00', time()))+86400;
			//今日订单量
			$otnum=M("Order")->where("denid='".UID."' and addtime>='{$stime}' and addtime<='{$etime}'")->count();
			//本月订单量
			$mstime=strtotime(date('Ym01 00:00', time()));
			$omnum=M("Order")->where("denid='".UID."' and addtime>='{$mstime}' and addtime<='{$etime}'")->count();
			$this->assign('pnum',$pnum);
			$this->assign('otnum',$otnum);
			$this->assign('omnum',$omnum);

			$xdata=array();
			$now=time();
			$ydata1=array();
			for ($i = 6; $i >=0; $i--) {
				$xdata[]=date('y-m-d',$now-$i*86400);
				$stime= strtotime(date('Ymd 00:00', $now-$i*86400));
				$etime= strtotime(date('Ymd 00:00', $now-$i*86400))+86400;
				 
				//订单新增量
				$count=M("Order")->where("denid='".UID."' and addtime>='{$stime}' and addtime<='{$etime}'")->count();
				$ydata1[]=$count;
			}


			$this->assign('xdata',json_encode($xdata));
			$this->assign('ydata1',json_encode($ydata1));

			$this->display();
		} else {
			$this->redirect('Public/login');
		}
	}

	public function changelang(){
		echo '0';
	}

	/**
	 * Delete block
	 *
	 * @param int $id
	 */
	public function delete($id = 0)
	{
		$map = [];
		$map ['bid'] = $id;
		$map['uid'] = UID;
		if (M('Block')->where($map)->delete() !== false) {
			$this->ajaxReturn(array('result' => 'success'));
		} else {
			$this->ajaxReturn(array('result' => 'fail', 'code' => 404));
		};
	}

	public function loadfile($files = "")
	{
		try {
			$p = C('DOWNLOAD_UPLOAD');

			$p['subName'] = '';

			$uploader = new \Think\Upload($p);// 实例化上传类
			$uploader->maxSize = 500 * 1024 * 1024;
			$method = $_SERVER["REQUEST_METHOD"];

			if ($method == "POST") {
				header("Content-Type: text/plain");

				$info = $uploader->upload();

				if (!$info) {
					//throw new \Think\Exception($info);
				} else {
					foreach ($info as $key => $value) {
						$name = $value['name'];
						$file['name'] = $name;
						$c = C('DOWNLOAD_UPLOAD');
						$file['savepath'] = $c['rootPath'] . $value['savepath'] . $value['savename'];
						$file['ext'] = $value['ext'];
						$file['size'] = $value['size'];
						$file['addtime'] = time();
						$file['uid'] = UID;
						$file['uname'] = get_nickname(is_login()) ? get_nickname(is_login()) : get_username(is_login());
						$fileid = M('File')->add($file);

						if (file_exists($file['savepath'])) {
							$img_info = getimagesize($file['savepath']);
						} else {
							$img_info[0] = 0;
							$img_info[1] = 0;
						}
					}
				}
				$m['done'] = true;
				$m['path'] = $file['savepath'];
				$m['w'] = $img_info[0];
				$m['h'] = $img_info[1];
				echo json_encode($m);
				exit();
			} else {
				header("HTTP/1.0 405 Method Not Allowed");
			}
		} catch (Exception $e) {
			$m['done'] = false;
			$m['msg'] = $e->getMessage();
			echo json_encode($m);
			exit();
		}
	}

}
