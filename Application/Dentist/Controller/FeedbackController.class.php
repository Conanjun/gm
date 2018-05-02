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
 * 工作室 投诉意见管理控制器 : LGW
 */
class FeedbackController extends AdminController
{
    private $model;

    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Feedback');    // 投诉意见Model
    }

    /**
     *投诉意见管理首页
     */
    public function index()
    {

        $uid = UID;
        //获取工作室id
        $info = M('Member')->alias('m')->join('left join ot_dentist d on m.uid = d.uid ')
            ->field('m.stuid,d.denid')->where('m.uid='.$uid)
            ->find();
        $where = " 1=1 and f.denid ={$info['denid']}";
        $filter= '';
        $start_addtime = empty($_GET['start_addtime'])?'':trim($_GET['start_addtime']);
        $end_addtime = empty($_GET['end_addtime'])?'':trim($_GET['end_addtime']);

        $start_backtime = empty($_GET['start_backtime'])?'':trim($_GET['start_backtime']);
        $end_backtime = empty($_GET['end_backtime'])?'':trim($_GET['end_backtime']);
        //时间筛选
        if(!empty($start_addtime) &&  !empty($end_addtime)){
            $filter .= " and f.addtime > ".strtotime($start_addtime);
            $filter .= " and f.addtime <= ".strtotime($end_addtime."+23 hours 59 minute 59 second");
        }
        if(!empty($start_backtime) && !empty($end_backtime) ){
            $filter .= " and f.backtime > ".strtotime($start_backtime);
            $filter .= " and f.backtime <= ".strtotime($end_backtime."+23 hours 59 minute 59 second");
        }
        $feedtype = empty($_GET['feedtype'])?'':trim($_GET['feedtype']);//code
        if($feedtype){
            $filter .= " and  dic.d_key = {$feedtype}";
        }
        $feed_status = empty($_GET['feed_status'])?'':trim($_GET['feed_status']);//code
        if($feed_status){
            $filter .= " and  dicc.d_key = {$feed_status}";
        }

        $where .= $filter;

        $count = $this->model->countNum($where);
        $page = new \Think\Page($count, 10);
        $lists = $this->model
            ->alias('f')
            ->join('left join ot_studio s on f.stuid = s.stuid')
            ->join('left join ot_member m on m.uid = f.uid')
            ->join("left join ot_dictionary dic on dic.d_key = f.type and dic.d_code='feed_type'")
            ->join("left join ot_dictionary dicc on dicc.d_key = f.state and dicc.d_code='feed_status'")
            ->field('dicc.d_value as status ,dic.d_value as type,s.name as sname,m.nickname,f.content,f.addtime,f.backtime,f.id')
            ->where($where)
            ->group('f.id')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
		
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $this->assign('lists', $lists);

        $feed_type = M('Dictionary')->where("d_code = 'feed_type' and d_del =0")->select();
        $this->assign('feed_type', $feed_type);

        $feed_status = M('Dictionary')->where("d_code = 'feed_status' and d_del =0")->select();
        $this->assign('feed_status', $feed_status);

        $this->assign('_page', $page->show());
        $this->assign('filtered', $filter ? 1 : 0); //是否有查询条件
        $this->display();
    }

    /**
     * 新增投诉意见
     */
    public function add()
    {
        $uid = UID;
        if (IS_POST) {
            $type = empty($_POST['type']) ? '' : trim($_POST['type']);              // 意见类型
            $content = empty($_POST['content']) ? '' : trim($_POST['content']);     // 意见内容
            $pic = empty($_POST['pic']) ? '' : trim($_POST['pic']);     // 图片

            //获取工作室id
            $info = M('Member')->alias('m')->join('left join ot_dentist d on m.uid = d.uid ')
                ->field('m.stuid,d.denid')->where('m.uid='.$uid)
                ->find();
            $data = array(
                'type' => $type,
                'content' => $content,
                'pic'=>$pic,
                'stuid'=>$info['stuid'],
                'denid'=>$info['denid'],
                'uid'=>$uid,
                'addtime'=>time(),
                //'backtime'=>time(),
            );
            if (!M('Feedback')->add($data)) {
                $this->error(L('ADD_ERROR'));
            } else {
               $this->redirect('Feedback/index');
            }

        } else {

            $feed_type = M('Dictionary')->where("d_code = 'feed_type' and d_del =0")->select();
            $this->assign('feed_type', $feed_type);

            $feed_status = M('Dictionary')->where("d_code = 'feed_status' and d_del =0")->select();
            $this->assign('feed_status', $feed_status);


            $this->display();
        }
    }

    /**
     * 查看明细
     */
    public function info()
    {
        $id = empty($_GET['id'])?0:$_GET['id'];
        if (empty($id)) {
            $this->error('字典数据不存在！');
        }

        $data = $this->model
            ->alias('f')
            ->join('left join ot_studio s on f.stuid = s.stuid')
            ->join('left join ot_member m on m.uid = f.uid')
            ->join("left join ot_dictionary dic on dic.d_key = f.type and dic.d_code='feed_type'")
            ->join("left join ot_dictionary dicc on dicc.d_key = f.state and dicc.d_code='feed_status'")
            ->field('dicc.d_value as status ,dic.d_value as type,s.name as sname,m.nickname,f.content,f.addtime,f.backtime,f.id,f.pic')
            ->where('f.id='.$id)
            ->group('f.id')
            ->find();

        $this->assign('data', $data);

        $this->display();
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

    /*
     * 删除意见反馈
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
    		$list =$this->model->getOne($where);
    		if(empty($list)){
    			$failmsg.= "ID".$id.L("DELETE_FAILED")."<br/>";
    		}else{
    			$res = $this->model->where($where)->delete();
    			action_log_new(array('outtype' => 'ot_feedback', 'outkey' => $id, 'action' => 'delete', 'comment' => ''));
    			$sucmsg.="{$list['content']}".L("DELETE_SUCCESS")."<br/>";
    		}
    	}
    	$this->json_success($failmsg.$sucmsg);
    }

}
