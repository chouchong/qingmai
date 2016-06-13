<?php
namespace Home\Action;
/**
 * ============================================================================
 * 支付控制器
 */
use Org\Pay\PcUnionPay;
use Org\Pay\PcAliPay;
class PayAction extends BaseAction {
	/**
	*
	**/
	public function index()
	{
		$this->isLogin();
		$this->payNews = D('Home/Pay')->index()[0];
		$this->display('tpl/pay');
	}
	/**
	* 支付修改
	*/
	public function editPayment(){
		$data=D('Home/Orders')->editPayment();
		$this->ajaxReturn($data);
	}
  /**
  *支付
  **/
  	public function goPay()
  	{
		$orderId = I('get.orderId');
		$values = I('get.values');
		/*根据付款方式执行不同方法*/
		if($orderId){
		  switch ($values){
		    case 1:
		      $this->wxPay($orderId);
		      break;
		    case 2:
		      $this->unionPay($orderId);
		      break;
		    case 3:
		      $this->aliPay($orderId);
		      break;
		    default:
		      break;
		  }
		}
  	}
  	// 支付宝
  	public function aliPay($orderId){
        $Pay = D('Home/Pay');
		$row = $Pay->getInfo($orderId);
		$dd = $Pay->getPayOrder($orderId);

        $Alipay = new \Org\Pay\PcAliPay(); //实例化银联支付操作类
        $data['subject'] = $dd['goodsName'];
		$data['out_trade_no'] = $row['orderNo'];
		$data['total_fee'] = $row['totalMoney'];
		$Alipay->alipay($data);
    }
    //支付宝
    public function aliPayNotify()
    {
    	$Alipay = new \Org\Pay\PcAliPay(); //实例化银联支付操作类
        if($Alipay->verifyNotify()){    //验证
        	$out_trade_no = $_POST['out_trade_no'];
			$trade_no = $_POST['trade_no'];
			$trade_status = $_POST['trade_status'];
			if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
				$res = D('Mobile/Pays')->editOrder($out_trade_no);
				if($res !== false){
					echo 'success';
				}
			}
        }
    }
    //支付宝
    public function aliPayReturn()
    {
    	$Alipay = new \Org\Pay\PcAliPay(); //实例化银联支付操作类
    	$Pay = D('Mobile/Pays');
        if($Alipay->verifyReturn()){    //验证
            $out_trade_no = $_GET['out_trade_no'];
			$trade_no = $_GET['trade_no'];
			$trade_status = $_GET['trade_status'];
			if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
				$this->row = $Pay->getInfoNo($out_trade_no);
		    	$this->display('/tpl/paySu');
			}else{
				$this->isNo = 1;
				$this->row = $Pay->getInfoNo($out_trade_no);
		    	$this->display('/tpl/paySu');
			}
        }
    }
  	//银联支付
	public function unionPay($orderId=0){
		$Pay = D('Home/Pay');
		$row = $Pay->getInfo($orderId);
		$Uniopay = new PcUnionPay(); //实例化银联支付操作类
		$Uniopay->txnAmt = $row['totalMoney']*100;   //交易金额，必填
		$Uniopay->orderId = $row['orderNo']; //订单号，选填
		$Uniopay->frontUrl = 'http://'.$_SERVER['HTTP_HOST'].'/Home/Pay/UnionPayBack';
		$Uniopay->backUrl = 'http://'.$_SERVER['HTTP_HOST'].'/Home/Pay/UnionPayGo';
		$Uniopay->pay();
	}
	//银联支付成功回调方法
	public function UnionPayGo(){
		$Uniopay = new PcUnionPay();
		// M('log_orders')->add(array('logContent' => '11111'));
		if($Uniopay->Check($_POST)){    //验证
		  D('Mobile/Pays')->editOrder($_POST['orderId']);
		}else{
		  echo "失败";
		}
	}
	//银联支付成功
	public function UnionPayBack(){
		$Uniopay = new PcUnionPay(); //实例化银联支付操作类
		$Pay = D('Mobile/Pays');
		if($Uniopay->Check($_POST)){    //验证
		    $this->row = $Pay->getInfoNo($_POST['orderId']);
		    $this->view->display('/tpl/paySu');
		}else{
		    $this->row = $Pay->getInfoNo($_POST['orderId']);
		    $this->isNo = 1;
		    $this->view->display('/tpl/paySu');
		}
	}
	//微信支付
	public function wxPay($orderId=0){
		$this->isLogin();
		$Pay = D('Home/Pay');
		$row = $Pay->getInfo($orderId);
		vendor('Weixinpay.WxPayPubHelper');

		$time =time();
		//=========步骤2：使用统一支付接口，获取prepay_id============
		//使用统一支付接口
		$unifiedOrder = new \UnifiedOrder_pub();
		$total_fee = $row['totalMoney']*100;
		//$total_fee = 1;
		$body = $this->CONF['mallName'];
		$pkey = $row['orderId'];
		// $unifiedOrder->setParameter("openid", session('openid'));//用户标识
		$unifiedOrder->setParameter("body", $body);//商品描述
		//自定义订单号，此处仅作举例
		$notify_url = 'http://'.$_SERVER['HTTP_HOST']."/Home/Pay/wxNotify";
		$unifiedOrder->setParameter("out_trade_no", $row['orderNo']);//商户订单号
		$unifiedOrder->setParameter("total_fee", $total_fee);//总金额
		$unifiedOrder->setParameter("attach", "$pkey");//附加数据
		$unifiedOrder->setParameter("notify_url", $notify_url);//通知地址
		$unifiedOrder->setParameter("trade_type", "NATIVE");//交易类型
		// $unifiedOrder->SetParameter("input_charset", "UTF-8");
		//非必填参数，商户可根据实际情况选填
		//获取统一支付接口结果
		$unifiedOrderResult = $unifiedOrder->getResult();
		    // var_dump($unifiedOrder);
		//商户根据实际情况设置相应的处理流程
		if ($unifiedOrderResult["return_code"] == "FAIL") 
		{
		    //商户自行增加处理流程
		    echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
		}
		elseif($unifiedOrderResult["result_code"] == "FAIL")
		{
		    //商户自行增加处理流程
		    echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
		    echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
		}
		elseif($unifiedOrderResult["code_url"] != NULL)
		{
		    //从统一支付接口获取到code_url
		    $code_url = $unifiedOrderResult["code_url"];
		    //商户自行增加处理流程
		    //......
		}
		$this->assign('totalMoney',$row['totalMoney']);
		$this->assign('out_trade_no',$row['orderNo']);
		$this->assign('code_url',$code_url);
		$this->assign('unifiedOrderResult',$unifiedOrderResult);
		$this->display('tpl/wxpay');
	}
	//微信支付成功
	public function wxSuBack(){
		$this->isLogin();
		$Pay = D('Mobile/Pays');
	    $this->row = $Pay->getInfoNo(I('orderId'));
	    $this->view->display('/tpl/paySu');
	}
	//微信支付失败
	public function wxErBack(){
		$this->isLogin();
		$Pay = D('Mobile/Pays');
	    $this->row = $Pay->getInfoNo(I('orderId'));
	    $this->isNo = 1;
	    $this->view->display('/tpl/paySu');
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
		echo $returnXml;
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
	}
  //查询订单
	public function orderQuery()
	{
		vendor('Weixinpay.WxPayPubHelper');
		// out_trade_no='+$('out_trade_no').value,
		//退款的订单号
		if (!isset($_POST["out_trade_no"]))
		{
			$out_trade_no = "";
		}else{
		    $out_trade_no = $_POST["out_trade_no"];
			//使用订单查询接口
			$orderQuery = new \OrderQuery_pub();
			//设置必填参数
			//appid已填,商户无需重复填写
			//mch_id已填,商户无需重复填写
			//noncestr已填,商户无需重复填写
			//sign已填,商户无需重复填写
			$orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号 
			//非必填参数，商户可根据实际情况选填
			//$orderQuery->setParameter("sub_mch_id","XXXX");//子商户号  
			//$orderQuery->setParameter("transaction_id","XXXX");//微信订单号
			//获取订单查询结果
			$orderQueryResult = $orderQuery->getResult();
			//商户根据实际情况设置相应的处理流程,此处仅作举例
			if ($orderQueryResult["return_code"] == "FAIL") {
				$this->error($out_trade_no);
			}
			elseif($orderQueryResult["result_code"] == "FAIL"){
			// $this->ajaxReturn('','支付失败！',0);
				$this->error($out_trade_no);
			}
			else{
			     $i=$_SESSION['i'];
			     $i--;
			     $_SESSION['i'] = $i;
			      //判断交易状态
				switch ($orderQueryResult["trade_state"])
				{
					case SUCCESS: 
					  $this->success("支付成功！");
					  break;
					case REFUND:
					  $this->error("超时关闭订单：".$i);
					  break;
					case NOTPAY:
					  $this->error("超时关闭订单：".$i);
					//	$this->ajaxReturn($orderQueryResult["trade_state"], "支付成功", 1);
					  break;
					case CLOSED:
					  $this->error("超时关闭订单：".$i);
					  break;
					case PAYERROR:
					  $this->error("支付失败".$orderQueryResult["trade_state"]);
					  break;
					default:
					  $this->error("未知失败".$orderQueryResult["trade_state"]);
					  break;
				}
			}
		}
	}
}