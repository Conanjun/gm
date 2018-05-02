<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Studio\Controller;
use Common\Common\Super\Order;


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
		$stuid = Order::get_stuid(UID);   // 工作室id
		if (UID) {
			$this->meta_title = '首页';

			//客户量
			$customercount=M("DentistRelation")->join('inner join ot_dentist d on dr.denid = d.denid')->alias('dr')->where("dr.stuid='".UID."'")->count();
			$this->assign('customercount',$customercount);

			$stime= strtotime(date('Ymd 00:00', time()));
			$etime= strtotime(date('Ymd 00:00', time()))+86400;
			//今日订单
			$ordernum=M("Order")->where("stuid='".UID."' and addtime<='{$etime}' and addtime>='{$stime}' ")->count();
			$this->assign('ordernum',$ordernum);

			//今日收入
			$instr="";
			$row=M("Receipt")->where("stuid='".UID."'")->field("sum(amount) as m")->find();
			if($row&&$row["m"]){
				$instr=$row["m"];
			}else{
				$instr="-";
			}
			$this->assign('income',$instr);

			$xdata=array();
			$now=time();
			$ydata1=array();
			$ydata2=array();
			$ydata3=array();
			for ($i = 6; $i >=0; $i--) {
				$xdata[]=date('y-m-d',$now-$i*86400);
				$stime= strtotime(date('Ymd 00:00', $now-$i*86400));
				$etime= strtotime(date('Ymd 00:00', $now-$i*86400))+86400;
				 
				//客户新增量
				$count=M("DentistRelation")->join('inner join ot_dentist d on dr.denid = d.denid')->alias('dr')
				->where("dr.stuid='".UID."' and dr.addtime<='{$etime}' and dr.addtime>='{$stime}' ")->count();
				$ydata1[]=$count;
				 
				//订单新增量
				$ordernum=M("Order")->where("stuid='".UID."' and addtime<='{$etime}' and addtime>='{$stime}' ")->count();
				$ydata2[]=$ordernum;
				 
				$row=M("Receipt")->where("stuid='".UID."' and addtime<='{$etime}' and addtime>='{$stime}'")->field("sum(amount) as m")->find();
				if($row&&$row["m"]){
					$ydata3[]=$row["m"];
				}else{
					$ydata3[]=0;
				}
				 
			}

			$this->assign('xdata',json_encode($xdata));
			$this->assign('ydata1',json_encode($ydata1));
			$this->assign('ydata2',json_encode($ydata2));
			$this->assign('ydata3',json_encode($ydata3));


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
