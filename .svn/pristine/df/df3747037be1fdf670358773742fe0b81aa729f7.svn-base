<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Admin\Common\Super;

/**
 *
 * Class Project  :LGW
 *
 * @package Admin\Common\Super
 */
class Api
{
    const  OPPORTUNITY = 0;     // 销售机会
    const  CONTRACT = 1;        // 合同
    const  OFFER_BACK = 2;      // 回写报价单信息
    const  COST_TYPES = 3;      // 费用类型信息
    const  COST_SUB = 4;        // 费用类型二级分类信息
    const  S_SEND = 5;         // 企业号信息发送
    const  DXY_RCODE = 0;
    const  DXY_S = 1;
    const  DXY_OA = 2; // OA系统
    const  DXY_CRM = 3; // CRM

    /**
     * @param $parameter
     *
     * @return mixed|string|void
     */
    public static function getUrl($parameter)
    {
        switch ($parameter) {
            case Api::OPPORTUNITY :
                $url = C('DXY_CRM_URL_OPPORTUNITY');
                $method = 'get';
                break;
            case Api::CONTRACT :
                $url = C('DXY_CRM_URL_CONTRACT');
                $method = 'get';
                break;
            case Api::OFFER_BACK :
                $url = C('DXY_CRM_URL_OFFER');
                $method = 'post';
                break;
            case Api::COST_TYPES :
                $url = C('DXY_OA_COST_TYPES_URL');
                $method = 'get';
                break;
            case Api::COST_SUB :
                $url = C('DXY_OA_COST_SUB_URL');
                $method = 'get';
                break;
            case Api::S_SEND :
                $url = C('DXY_S_SEND_URL');
                $method = 'post';
                break;
            default    :
                $url = '';
                $method = '';
                return;
        }
        $urlSubmit = ['url' => $url, 'method' => $method];
        return $urlSubmit;
    }

    /**
     * 获取不同项目下的appId和appSignKey
     *
     * @param $app
     *
     * @return mixed|string|void
     */
    public static function getAppMessage($app)
    {
        switch ($app) {
            case Api::DXY_RCODE :
                $appId = C('DXY_RCODE_APPID');
                $appSignKey = C('DXY_RCODE_KEY');

                break;
            case Api::DXY_S :
                $appId = C('DXY_S_APPID');
                $appSignKey = C('DXY_S_KEY');
                break;
            case Api::DXY_OA :
                $appId = C('DXY_OA_APPID');
                $appSignKey = C('DXY_OA_KEY');
                break;
            case Api::DXY_CRM :
                $appId = C('DXY_CRM_APPID');
                $appSignKey = C('DXY_CRM_KEY');
                break;
            default    :
                $appId = '';
                $appSignKey = '';
                return;
        }
        $data = ['appId' => $appId, 'appSignKey' => $appSignKey];
        return $data;
    }

}
