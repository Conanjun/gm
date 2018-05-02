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
 * 工作室 消息管理控制器 : LGW
 */
class MessageController extends AdminController
{
    private $model;

    //构造函数
    public function __construct()
    {
        parent::__construct();
        $this->model = D('Message');    // 消息Model
    }

    /**
     *消息管理首页
     */
    public function index()
    {
    	 	
    	$where = "1=1 and me.toid =".UID;
    	
        $count = $this->model->countNum($where);
        $page = new \Think\Page($count, 10);
        $lists = $this->model
            ->alias('me')
            ->join('left join ot_member m on m.uid = me.fromid')
            ->join('left join ot_member ms on ms.uid = me.toid')
	    	->field('me.* ,m.nickname,ms.nickname as mname')
	    	->order('me.msg_id desc')
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $this->assign('lists', $lists);
        $this->assign('_page', $page->show());
        $this->display();
    }

    /**
     *消息详情
     */
    public function view()
    {
        //获取消息详情
        $id = empty($_GET['id'])?0:$_GET['id'];
        $where = ['msg_id'=>$id];
        
        $list = M('Message') ->alias('me')
        ->join('left join ot_member m on m.uid = me.fromid')
        ->join('left join ot_member ms on ms.uid = me.toid')
        ->field('me.* ,m.nickname,ms.nickname as mname')
        ->where('me.msg_id='.$id)
        ->find();
        
        if($list['isread']==0 && empty($list['readtime'])){
        	D('Message')->save(['msg_id'=>$id,'isread'=>1,'readtime'=>time()]);
        }
        
        $this->assign('list', $list);
        $this->display();
    }

}
