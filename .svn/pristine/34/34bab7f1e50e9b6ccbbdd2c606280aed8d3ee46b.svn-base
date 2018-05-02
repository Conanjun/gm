<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Dentist\Controller;
use User\Api\UserApi;
use Common\Common\Super\Order;
/**
 * 收银台：fhc
 */
class CashController extends AdminController
{
	//构造函数
	public function __construct()
	{
		parent::__construct();
	}
	
	//收银台
	public function index()
	{
		$oid = !isset($_GET['id'])?0:$_GET['id'];
		if(empty($oid)){
            $this->error(L('Data_not_exist'));
        }
		$order = M("Order")->where("oid=".$oid)->find();
		if(empty($order)){
            $this->error(L('Data_not_exist'));
        }
        if($order['state']!=10){
            $this->error(L('STATE_NOT_PAY'));
        }
        $money = M("OrderPay")->where("oid=".$oid." and state=0 and paytype=0")->sum('money');
        $money1 = M("OrderPay")->where("oid=".$oid." and state=0 and paytype=0")->sum('money1');
        $this->assign('money',$money);
        $this->assign('money1',$money1);
        $this->assign('order',$order);
		$this->display();
	}
	//支付
	public function pay(){
        $oid =  !isset($_GET['id'])?0:intval($_GET['id']);
        $pay_name =  !isset($_GET['pay_name'])?'':trim($_GET['pay_name']);
        if(empty($oid)){
            $this->error(L('Data_not_exist'));
        }
        $order = M("Order")->where("oid=".$oid)->find();
        if(empty($order)){
            $this->error(L('Data_not_exist'));
        }
        if($order['state']!=10){
            $this->error(L('STATE_NOT_PAY'));
        }

        $money = M("OrderPay")->where("oid=".$oid." and state=0 and paytype=0")->sum('money');
        $money1 = M("OrderPay")->where("oid=".$oid." and state=0 and paytype=0")->sum('money1');
        if($pay_name=='alipay' || $pay_name=='wxpay'){
            $paym = $money;
            $currency = 'RMB';
        }else{
            $paym = $money1;
            $currency = 'RSD';
        }
        $note = '';
        //发起支付
        $sn = Order::creat_paysn();
        $pay = array(
            'paysn' =>$sn,
            'oid' => $oid,
            'uid'=>UID,
            'sid'=>$order['stuid'],
            'addtime' => NOW_TIME,
            'pay_name'=>$pay_name,
            'tamount' => $paym,
            'currency' => $currency,
            'description' => $note
        );
        $payid = M('PayLog')->add($pay);
        if (empty($payid)) {
            $this->error(L('ORDER_PAY_CREATE'));
        }
        if($pay_name=='alipay' || $pay_name=='wxpay'){//
            include_once(ROOT_PATH . '/alipaysdk/aop/AopClient.php');
            include_once(ROOT_PATH . '/alipaysdk/AopSdk.php');
            $aop = new AopClient ();
            $aop->gatewayUrl = ALIPAY_PAY_URL;
            $aop->appId = ALIPAY_APPID;
            $aop->rsaPrivateKey = ALIPAY_PRIVATEKEY;
            $aop->alipayrsaPublicKey = ALIPAY_PUBLICKEY;
            $aop->apiVersion = '1.0';
            $aop->signType = 'RSA2';
            $aop->postCharset = 'utf-8';
            $aop->format = 'json';
            $request = new AlipayTradePayRequest();
            $request->setBizContent("{" .
                "\"out_trade_no\":\"{$sn}\"," .
                "\"scene\":\"bar_code\"," .
                "\"auth_code\":\"\"," .
                "\"subject\":," .
                "\"total_amount\":\"{$paym}\",".
                "\"trans_currency\":\"CNY\",".
                "}");
            $result = $aop->execute($request);
            $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
            $resultCode = $result->$responseNode->code;
            if (empty($resultCode) || $resultCode != 10000) {
                $this->error(sprintf(L('S_TASK_CW_ERROR_10'), $resultCode));
            }
        }
    }
}


