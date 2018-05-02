<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Admin\Common\Super\Task;

/**
 * 后台首页控制器
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class IndexController extends AdminController
{

	private $meta_title;

	/**
	 * 后台首页
	 *
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function index()
	{
		if (UID) {
			//工作室数量
			$studio_num = M("Studio")->where("enabled=1")->count();
			$this->assign('studio_num',number_format($studio_num));
			$client_num = M("Dentist")->where("enabled=1")->count();
			$this->assign('client_num',number_format($client_num));
			$order_num = M("Order")->where("state>1")->count();
			$this->assign('order_num',number_format($order_num));
			$this->display();
		}
	}


	public function changelang(){
		echo '0';
	}

	public function getdata(){
		try {
			//参数验证初始化
			$k=$_POST['k'];
			switch($k){
				case 1:
					$data = M("Studio")->field("FROM_UNIXTIME(addtime,'%y-%m-%d') days,count(stuid) count")->where("enabled=1")->group('days')->limit(7)->select();
					break;
				case 2:
					$data = M("Dentist")->field("FROM_UNIXTIME(addtime,'%y-%m-%d') days,count(denid) count")->where("enabled=1")->group('days')->limit(7)->select();
					break;
				case 3:
					$data = M("Order")->field("FROM_UNIXTIME(addtime,'%y-%m-%d') days,count(order_id) count")->where("state>1")->group('days')->limit(7)->select();
					break;
				case 4:
					$data = M("Receipt")->field("FROM_UNIXTIME(addtime,'%y-%m-%d') days,sum(amount) amount")->group('days')->limit(7)->select();
					break;
			}
			$x_data = $this->get_week(time() -7*60*60*24);
			$y_data = array();
			foreach ($x_data as $key=>$value){
				$count =0;
				foreach ($data as $k=>$v){
					if($value==$v['days']){
						if(!empty( $v['count'])){
							$count = $v['count'];
						}
						break;
					}
				}
				$y_data[] = $count;
			}
			$retval =array(
                'x'=>$x_data,
                'y'=>$y_data
			);
			$this->json_result($retval,'',false);
		}catch(\Exception $e){
			$this->json_error($e->getMessage());
		}
	}

	public function block1(){
		try {
			//参数验证初始化
			$param=$this->valid();
			$k=$param['k'];
			$v=$param['v'];
			$y=$param['y'];

			$d1=0;
			if(empty($k)){
				$pmw=" and p.pmuid='".$v."'";
			}else{
				$pmw=" and EXISTS(SELECT 1 from ot_member m
				LEFT JOIN ot_dept d on d.did=m.dept 
				where m.uid=p.pmuid and d.path like '%,".$v.",%' )";
			}
			//累计管理项目合同额d1
			$d1=M("project")->alias("p")->where("p.del=0 and right(left(contract, 6),4)='".$y."'".$pmw)->sum("p.money");

			if(empty($d1))$d1=0;
			$retval=array("d1"=>fomatprice($d1));

			$this->json_result($retval);

		}catch(\Exception $e){
			$this->json_error($e->getMessage());
		}
	}

	/**
	 * 获取一周日期
	 * @param $time 时间戳
	 * @param $format 转换格式
	 */
	function get_week($time, $format = "y-m-d") {
		for ($i=0;$i<=6;$i++){
			$t = date($format,strtotime( '+'. $i+1 .' days',$time));
			$data[]=$t;
		}
		return $data;
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
