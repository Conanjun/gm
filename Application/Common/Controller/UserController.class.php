<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Common\Controller;

use User\Api\UserApi;

/**
 * 通用注册
 *
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class UserController
{
    public function add($data)
    {
	    $User = new UserApi;
	    $uid = $User->register($data['username'], PASS_WORD);
	    if (0 < $uid) { //注册成功
		    $user = array('uid' => $uid, 'nickname' => $data['username'], 'status' => 1,'stuid' =>$data['stuid'],'module'=>$data['module']);
		    $uid = M('Member')->add($user);
		    if(0 < $uid){
			    return $uid;
		    }else{
			    return false;
		    }
	    } else { //注册失败，显示错误信息
		    return false;
	    }
    }
}
