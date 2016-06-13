<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝即时到账交易接口接口</title>
</head>
<?php
/* *
 * 功能：即时到账交易接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */

require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");
require_once('../../include/config.inc.php');

/**************************系统参数**************************/
	//打赏金额
	$shang_price_1="0.5"; //信封金额
	$shang_price_2="1"; //信封金额
	$shang_price_3="5"; //信封金额
	$shang_price_4="10"; //信封金额
	$shang_price_5="100"; //信封金额

	//付费会员
	$vip_nian="144"; //会员1年费用
	$vip_ji="38";	//会员1季费用
	$vip_yue="15";	//会员1月费用

	//置顶服务
	$vip_one="0.6";		//VIP每小时置顶费用
	$novip_one="1";		//非VIP每小时置顶费用





/************************************************************/






/**************************请求参数**************************/

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = "http://www.exwuwu.com/alipay/notify.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        //页面跳转同步通知页面路径
        $return_url = "http://www.exwuwu.com/alipay/return.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //商户订单号
		if(empty($_POST['WIDout_trade_no'])){
			$out_trade_no=md5(time());
		}else{
			if(!empty($_POST['WIDout_trade_no'])){
				$out_trade_no = $_POST['WIDout_trade_no'];
			}else if(!empty($_GET['WIDout_trade_no'])){
				$out_trade_no = $_GET['WIDout_trade_no'];
			}else{
				echo "没有获取订单ID";
			}
			
		} 

        //商户网站订单系统中唯一订单号，必填
        //订单名称

		if(!empty( $_POST['WIDsubject'])){
			$subject = $_POST['WIDsubject'];
		}else if(!empty( $_GET['WIDsubject'])){
			$subject = $_GET['WIDsubject'];
		}else{
			echo "没有获取订单名称";
		}

       
        //必填
   


        //必填
        //订单描述
        $body = "北京物物信息技术有限公司";
        //商品展示地址
        $show_url = "";
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数
        //客户端的IP地址
        $exter_invoke_ip = GetIP();
        //非局域网的外网IP地址，如：221.0.0.1

		
        //自定义参数
		if(!empty($_POST['extra_common_param'])){
			$extra_common_param = $_POST['extra_common_param'];
		}else if(!empty($_GET['extra_common_param'])){
			$extra_common_param = $_GET['extra_common_param'];
		}else{
			echo "没有获取自定义参数";
		}

		     
		$paydesc = explode(",",$extra_common_param);

		if($paydesc[0]=="shang"){

			if($paydesc[4]==1){
				$total_fee = $shang_price_1*$paydesc[5];
			}else if($paydesc[4]==2){
				$total_fee = $shang_price_2*$paydesc[5];
			}else if($paydesc[4]==3){
				$total_fee = $shang_price_3*$paydesc[5];
			}else if($paydesc[4]==4){
				$total_fee = $shang_price_4*$paydesc[5];
			}else if($paydesc[4]==5){
				$total_fee = $money;
			}

		}else if($paydesc[0]=="vip"){
		
			if($paydesc[2]==1){
				$total_fee=$vip_nian*$paydesc[3];
			}else if($paydesc[2]==2){
				$total_fee=$vip_ji*$paydesc[3];
			}else if($paydesc[2]==3){
				$total_fee=$vip_yue*$paydesc[3];
			}

		}else if($paydesc[0]=="top"){

			$uid=$paydesc[1];
			$r_user_vip = $dosql->GetOne("SELECT * FROM `#@__vip` WHERE uid='".$uid."'");
			$row = $dosql->GetOne("SELECT * FROM `#@__top` WHERE id='".$paydesc[5]."'");

			if(!empty($r_user_vip['id'])){
				if($r_user_vip['end']-time()>0){
					$one_price=$vip_one;				
				}else{
					$one_price=$novip_one;	
				}
			}else{
				$one_price=$novip_one;	
			}

			$start = $row['start'];
	      	$end = $row['end'];
			$syhour=$r_user_vip['freehour']-$r_user_vip['usefreehour'];
	      			
	      	$hour=($end-$start)/3600;

			$price=$one_price*($hour-$syhour);
			
			$total_fee=$price;

		}else if($paydesc[0]=="money"){
			$total_fee = $money;
		}else{
			//付款金额
			$total_fee = $_POST['WIDtotal_fee'];
		}

		//$total_fee="0.01";


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service" => "create_direct_pay_by_user",
		"partner" => trim($alipay_config['partner']),
		"seller_email" => trim($alipay_config['seller_email']),
		"payment_type"	=> $payment_type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"body"	=> $body,
		"show_url"	=> $show_url,
		"anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,
		"extra_common_param" =>$extra_common_param,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
echo $html_text;

?>
</body>
</html>