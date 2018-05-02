<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Model;

use Think\Model;

/**
 * 用户模型
 *
 */
class UcenterMemberModel extends Model
{

    /**
     * 通过邮箱获取信息 : LGW
     *
     * @param $email
     *
     * @return mixed
     */
    function getInformation($email)
    {
        $map['email'] = $email;
        $data = $this->field('um.id,m.uid,m.nickname,m.qq')
            ->alias('um')
            ->join('ot_member m on m.uid = um.id','INNER')
            ->where($map)
            ->find();
        return $data;

    }
    
    /*
     * 判断名称是否唯一
     */
    public function uniqueName($name,$type_id = 0)
    {
    	$where = " username = '$name'";
    	$type_id && $where .= " AND ".$this->pk." <> '" . $type_id . "'";
    	return $this->where($where)->count();
    }


}
