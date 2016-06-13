<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */


require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
require_once('../../include/config.inc.php');







//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号
	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号
	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];

	$paydesc = explode(",",$_POST['extra_common_param']);

	$total_fee=$_POST['total_fee']*100;

	$notify_time=$_POST['notify_time'];

	//会员充值
	if($paydesc[0]=="money"){
		
			$uid=$paydesc[1];
			$posttime=time();
			$r_check = $dosql->GetOne("SELECT * FROM `#@__money_desc` WHERE paymentOrderId='$trade_no'");
			if(empty($r_check['id'])){
				$sql_desc = "INSERT INTO `#@__money_desc` (uid,payAmount, payDatetime, paymentOrderId,posttime) VALUES ('$uid','$total_fee', '$notify_time','$trade_no','$posttime')";
				$dosql->ExecNoneQuery($sql_desc);
				
				$row = $dosql->GetOne("SELECT * FROM `#@__money` WHERE uid=$uid");
				if(empty($row['id'])){
					$sql="INSERT `#@__money` (uid,money) VALUES ($uid,$total_fee);";
				}else{
					$moeny=$row['money']+$total_fee;
					$sql="UPDATE `#@__money` SET money=$moeny  WHERE uid=$uid";
				}
				
					if($dosql->ExecNoneQuery($sql)){
						echo "pay_success";
					}
			}else{
					echo "pay_repeat";
			}

	}
	//会员打赏
	if($paydesc[0]=="shang"){
		$gid=$paydesc[1];
		$sid=$paydesc[2];
		$guid=$paydesc[3];
		$sgid=$paydesc[4];
		$num=$paydesc[5];
		//$ordernum=$paydesc[1];
		$posttime=time();
		
		$sql="SELECT * FROM `#@__shang` WHERE paymentOrderId='$trade_no' or ordernum='$out_trade_no'";
		$row = $dosql->GetOne($sql);
		
		if(empty($row['id'])){
			$sql_shang = "INSERT INTO `#@__shang` (gid,sid,guid,ordernum,payAmount, payDatetime, paymentOrderId,posttime,sgid,num) VALUES ('$gid','$sid','$guid','$out_trade_no','$total_fee', '$notify_time','$trade_no','$posttime','$sgid','$num')";
			
			if($dosql->ExecNoneQuery($sql_shang)){
				
				$r_money = $dosql->GetOne("SELECT * FROM `#@__money` WHERE uid=$guid");
				if(empty($r_money['id'])){
					$sql="INSERT `#@__money` (uid,money) VALUES ($guid,$total_fee);";
				}else{
					$moeny=$r_money['money']+$total_fee;
					$sql="UPDATE `#@__money` SET money=$moeny  WHERE uid=$guid";
				}
				if($dosql->ExecNoneQuery($sql)){
					echo "pay_success";
				}
			}
		}else{
			echo "pay_repeat";
		}

	}


	if($paydesc[0]=="top"){
		$uid=$paydesc[1];
		$start=$paydesc[2];
		$end=$paydesc[3];
		$fl=$paydesc[4];
		$id=$paydesc[5];
		
		$hour = ($end-$start)/3600;
	
		$row = $dosql->GetOne("SELECT * FROM `#@__vip` WHERE uid=$uid");
		if(!empty($row['id'])){
			$freehour=$row['freehour'];
			$usefreehour=$row['usefreehour'];
			$freehours=$freehour-$usefreehour;
			
			if($freehours>0){
				$usefreehour=$usefreehour+$hour;
				if($usefreehour>=$freehour){
					$usefreehour=$freehour;
				}
			}
			
			$sql="UPDATE `#@__vip` SET usefreehour=$usefreehour WHERE uid=$uid";
			$dosql->ExecNoneQuery($sql);
		}
		
		
		$sql="UPDATE `#@__top` SET payAmount='$total_fee',payDatetime='$notify_time',paymentOrderId='$trade_no',paystate=1,checkinfo=2 WHERE id=$id";
		if($dosql->ExecNoneQuery($sql)){
			echo "pay_success";
		}
		
		
	}



	if($paydesc[0]=="vip"){
		$uid=$paydesc[1];
		$productId=$paydesc[2];
		$productNum=$paydesc[3];
		
		$sql_desc = "INSERT INTO `#@__vip_desc` (uid, p_how, p_num, payAmount, payDatetime, paymentOrderId) VALUES ('$uid', '$productId', '$productNum', '$total_fee', '$notify_time','$trade_no')";
		$dosql->ExecNoneQuery($sql_desc);
		
		$row = $dosql->GetOne("SELECT * FROM `#@__vip` WHERE uid=$uid");
		$onehour="3600";
		
		if(empty($row['id'])){
			$star=time();
			if($productId=="1"){
				$end=($onehour*24*365*$productNum)+$star;
				$freehour="30";
			}else if($productId=="2"){
				$end=($onehour*24*90*$productNum)+$star;
				$freehour="26";
			}else if($productId=="3"){
				$end=($onehour*24*30*$productNum)+$star;
				$freehour="24";
			}
			$userfreehour="0";
			$sql = "INSERT INTO `#@__vip` (uid, p_how, p_num, star, end,freehour,usefreehour) VALUES ('$uid', '$productId', '$productNum', '$star', '$end', '$freehour', '$userfreehour')";
		
		}else{
			$star=$row['end'];
		
			if($productId=="1"){
				$end=($onehour*24*365*$productNum)+$star;
				$freehour=$row['freehour']+30;
			}else if($productId=="2"){
				$end=($onehour*24*90*$productNum)+$star;
				$freehour=$row['freehour']+26;
			}else if($productId=="3"){
				$end=($onehour*24*30*$productNum)+$star;
				$freehour=$row['freehour']+24;
			}
			$sql="UPDATE `#@__vip` SET end=$end,freehour=$freehour WHERE `uid`=$uid";
		}
		
		if($dosql->ExecNoneQuery($sql)){
			echo "pay_success";
			exit();
		}else{
			echo "mysql_erro";
			exit();
		}
	}



    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		


    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
				
		//注意：
		//付款完成后，支付宝系统发送该交易状态通知

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
	echo "success";		//请不要修改或删除
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>