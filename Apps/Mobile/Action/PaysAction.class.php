<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 支付控制器
 */
import("secureUtil",dirname(__FILE__),".php");
use Org\Pay\UnionPay;
use Org\Pay\AliPay;
use Org\Pay\WxPay;
use Tools\YunpianSms;
class PaysAction extends BaseAction {
  /**
   * 支付选择
   */
  public function payment(){
    $this->isLogin();
    C('TOKEN_ON',false);
    $this->order = D('Mobile/Orders')->OrdersDetail()[0];

    $sms = new YunpianSms();

    $data=array(
      'tpl_id'=>'1357521',
      'tpl_value'=>('#tel#').'='.urlencode($GLOBALS['CONFIG']['phoneNo']),
      'mobile'=>session('Users')['userPhone']
    );
    $arr = array(
      'createTime'=>date('Y-m-d H:i:s'),
      'con'=>$GLOBALS['CONFIG']['phoneNo'],
      'orderId'=>I('orderId'),
      'mobile'=>session('Users')['userPhone']
    );
    $rs = D('Mobile/Logs')->addOrderSms($arr);
    if($rs['status']==0){
      $object = $sms->yp_send_tpl($data);
    }
    $this->view->display('/tpl/pay');
  }
  /**
   * 短信发送
   */
  public function smsSend($orderId)
  {
  }
  /**
   * 支付修改
   */
  public function editPayment(){
    $data=D('Mobile/Orders')->editPayment();
    $this->ajaxReturn($data);
  }
  //支付
  public function goPay(){
    $orderId = I('get.orderId');
    $values = I('get.values');
    /*根据付款方式执行不同方法*/
    if($orderId){
      switch ($values){
        case 1:
          $this->aliPay($orderId);
          break;
        case 3:
          $this->unionPay($orderId);
          break;
        default:
          break;
      }
    }
  }
  //银联支付
  public function unionPay($orderId=0){
    $Pay = D('Mobile/Pays');
    $row = $Pay->getInfo($orderId);
    $Uniopay = new UnionPay(); //实例化银联支付操作类
    $Uniopay->txnAmt = $row['totalMoney']*100;   //交易金额，必填
    $Uniopay->orderId = $row['orderNo']; //订单号，选填
    $Uniopay->pay();
  }
  //银联支付成功回调方法
  public function UnionPayBack(){
    $Uniopay = new \Org\Pay\UnionPay(); //实例化银联支付操作类
    $Pay = D('Mobile/Pays');
    if($Uniopay->Check($_POST)){    //验证
        $this->row = $Pay->getInfoNo($_POST['orderId']);
        C('TOKEN_ON',false);
        $sms = new YunpianSms();
        $data=array(
          'tpl_id'=>'1357523',
          'tpl_value'=>('#tel#').'='.urlencode($GLOBALS['CONFIG']['phoneNo']),
          'mobile'=>session('Users')['userPhone']
        );
        $object = $sms->yp_send_tpl($data);
        $this->view->display('/tpl/paySu');
    }else{
        $this->row = $Pay->getInfoNo($_POST['orderId']);
        $this->isNo = 1;
        C('TOKEN_ON',false);
        $this->view->display('/tpl/paySu');
    }
  }
  //银联支付成功
  public function UnionPayGo(){
    $Uniopay = new \Org\Pay\UnionPay();
    if($Uniopay->Check($_POST)){    //验证
      D('Mobile/Pays')->editOrder($_POST['orderId']);
    }else{
      echo "失败";
    }
  }
  //微信第一次
  public function wxSignature(){
    $WxPay = new WxPay();
    // JSSDK 相关
    $access_token = $WxPay->getAccessToken();
    $jsapi_ticket = $WxPay->getJsApiTicket($access_token);
    $noncestr = $WxPay->createNonceStr();
    $timestamp = time();
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    // 签名
    $signature = $WxPay->signature($jsapi_ticket, $noncestr, $timestamp, $url);
    // 返回微信参数
    $data['appId'] = C('wx_config.APPID');
    $data['timestamp'] = $timestamp;
    $data['nonceStr'] = $noncestr;
    $data['signature'] = $signature;
    $this->ajaxReturn($data);
  }
  //微信
  public function wxPaySu(){
    C('TOKEN_ON',false);
    $Pay = D('Mobile/Pays');
    $this->row = $Pay->getInfo(I('orderId'));
    $sms = new YunpianSms();
    $data=array(
      'tpl_id'=>'1357523',
      'tpl_value'=>('#tel#').'='.urlencode($GLOBALS['CONFIG']['phoneNo']),
      'mobile'=>session('Users')['userPhone']
    );
    $object = $sms->yp_send_tpl($data);
    $this->view->display('/tpl/paySu');
  }
  //微信
  public function wxPayEr(){
    $Pay = D('Mobile/Pays');
    $this->row = $Pay->getInfo(I('orderId'));
    $this->isNo = 1;
    C('TOKEN_ON',false);
    $this->view->display('/tpl/paySu');
  }
  //微信
  public function wxPay() {

    $Pay = D('Mobile/Pays');
    $row = $Pay->getInfo(I('orderId',9));
    vendor('Weixinpay.WxPayPubHelper');
    //使用jsapi接口
    $jsApi = new \JsApi_pub();
    $code = session('wxCode');
    $jsApi->setCode($code);
    //=========步骤1：网页授权获取用户openid============
    if(session('openid')==''){
      $this->getOpenid();
    }
    $time =time();
    //=========步骤2：使用统一支付接口，获取prepay_id============
    //使用统一支付接口
    $unifiedOrder = new \UnifiedOrder_pub();
    $total_fee = $row['totalMoney']*100;
    //$total_fee = 1;
    $body = $GLOBALS['CONFIG']['mallName'];
    $pkey = $row['orderId'];
    $unifiedOrder->setParameter("openid", session('openid'));//用户标识
    $unifiedOrder->setParameter("body", $body);//商品描述
    //自定义订单号，此处仅作举例
    $unifiedOrder->setParameter("out_trade_no", $row['orderNo']);//商户订单号
    $unifiedOrder->setParameter("total_fee", $total_fee);//总金额
    $unifiedOrder->setParameter("attach", "$pkey");//附加数据
    $unifiedOrder->setParameter("notify_url", "http://www.gozztrip.com/Mobile/Pays/wxNotify");//通知地址
    $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
    $unifiedOrder->SetParameter("input_charset", "UTF-8");
    //非必填参数，商户可根据实际情况选填
    $prepay_id = $unifiedOrder->getPrepayId();
    //=========步骤3：使用jsapi调起支付============
    $jsApi->setPrepayId($prepay_id);
    $jsApiParameters = $jsApi->getParameters();
    $wxconf = json_decode($jsApiParameters, true);
    if ($wxconf['package'] == 'prepay_id=') {
      $wxconf['status'] = -1;
    }else{
      $wxconf['status'] = 1;
    }
    $this->ajaxReturn($wxconf);
  }
  //微信返回
  public function wxNotify() {
    vendor('Weixinpay.WxPayPubHelper');
    //使用通用通知接口
    $notify = new \Notify_pub ();
    // 存储微信的回调
    $xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
    $notify->saveData ( $xml );
    // 验证签名，并回应微信。
    if ($notify->checkSign () == FALSE) {
      $notify->setReturnParameter ( "return_code", "FAIL" ); // 返回状态码
      $notify->setReturnParameter ( "return_msg", "签名失败" ); // 返回信息
    } else {
      $notify->setReturnParameter ( "return_code", "SUCCESS" ); // 设置返回码
    }
    $returnXml = $notify->returnXml ();
    // ==商户根据实际情况设置相应的处理流程=======
    if ($notify->checkSign () == TRUE) {
      if ($notify->data ["return_code"] == "FAIL") {
        // 此处应该更新一下订单状态，商户自行增删操作
      } elseif ($notify->data ["result_code"] == "FAIL") {
        // 此处应该更新一下订单状态，商户自行增删操作
      } else {
        // 此处应该更新一下订单状态，商户自行增删操作
        $order = $notify->getData();
        D('Mobile/Pays')->editOrder($order["out_trade_no"]);
      }
    }
    echo $returnXml;
  }
}