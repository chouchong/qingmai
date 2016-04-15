<?php
//银联支付操作类
namespace Org\Pay;
use Think\Controller;
import("UnionPay.funs.common",dirname(__FILE__),".php");
import("UnionPay.funs.httpClient",dirname(__FILE__),".php");
import("UnionPay.funs.PhpLog",dirname(__FILE__));
import("UnionPay.funs.PinBlock",dirname(__FILE__),".php");
import("UnionPay.funs.PublicEncrypte",dirname(__FILE__),".php");
import("UnionPay.funs.SDKConfig",dirname(__FILE__),".php");
import("UnionPay.funs.secureUtil",dirname(__FILE__),".php");

class UnionPay extends Controller{

    public function pay(){

        $merId = empty($this->merId) ? MER_ID :$this->merId;
        $orderId = empty($this->orderId) ? date('YmdHis') :$this->orderId;

        $frontUrl = empty($this->frontUrl) ? SDK_FRONT_NOTIFY_URL :$this->frontUrl;
        $backUrl = empty($this->backUrl) ? SDK_BACK_NOTIFY_URL :$this->backUrl;

        // 初始化日志
        $log = new \PhpLog( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
        $log->LogInfo ( "============处理前台请求开始===============" );
        $log->LogInfo ($this->txnAmt);
        // 初始化日志
        $params = array(
        		'version' => '5.0.0',				//版本号
        		'encoding' => 'utf-8',				//编码方式
        		'certId' => getSignCertId (),			//证书ID
        		'txnType' => '01',				//交易类型
        		'txnSubType' => '01',				//交易子类
        		'bizType' => '000201',				//业务类型
        		'frontUrl' =>  $frontUrl,  	//前台通知地址
        		'backUrl' => $backUrl,		//后台通知地址
        		'signMethod' => '01',		//签名方法
        		'channelType' => '08',		//渠道类型，07-PC，08-手机
        		'accessType' => '0',		//接入类型
        		'merId' => $merId,//商户代码，请改自己的测试商户号
        		'orderId' => $orderId,	//商户订单号
        		'txnTime' => date('YmdHis'),	//订单发送时间
        		'txnAmt' => $this->txnAmt,		//交易金额，单位分
        		'currencyCode' => '156',	//交易币种
        		'defaultPayType' => '0001',	//默认支付方式
        		//'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
        		//  'reqReserved' =>$this->reqReserved, //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
        		);

        $log->LogInfo ( "前台请求地址为>" .$params['certId'] );
        // 签名
        sign ( $params );

        // 前台请求地址
        $front_uri = SDK_FRONT_TRANS_URL;
        $log->LogInfo ( "前台请求地址为>" . $front_uri );
        // 构造 自动提交的表单
        $html_form = create_html ( $params, $front_uri );

        $log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
        //$log->LogInfo ( $html_form );
        $log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
        $log->LogInfo ( "============处理前台请求 结束===========" );

        echo $html_form;

    }
    public function Check($result){

        if(verify($result)){
            return true;
        }else{
            return false;
        }

    }
    public function logError($data){
        // 初始化日志
        $log = new \PhpLog( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
        $log->LogInfo ( "============处理logError===========" );
        $log->LogInfo($data);
    }

}
