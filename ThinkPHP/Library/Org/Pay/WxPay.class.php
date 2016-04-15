<?php
//微信支付操作类

namespace Org\Pay;
use Think\Controller;

class WxPay extends Controller{
    // JSSDK签名
  public function signature($jsapi_ticket, $noncestr, $timestamp, $url) {
    $string = "jsapi_ticket=$jsapi_ticket&noncestr=$noncestr&timestamp=$timestamp&url=$url";
    $signature = sha1($string);
    return $signature;
  }

  // 获取Openid
  public function getOpenid($code) {
    $url = 'https://api.weixin.qq.com/sns/oauth2/access_token'.
                  '?appid=' . C('wx_config.APPID') .
                  '&secret=' . C('wx_config.APPSECRET') .
                  '&code=' . $code .
                  '&grant_type=authorization_code';

    $data = $this->http_get($url);
    $json = json_decode($data);

    return $json->openid;
  }

  // 获取AccessToken
  public function getAccessToken() {
    $m = M('wxconfig');
    $dd = $m->field('access_token,time')->where(array('id'=>1))->find();
    if($dd['time']+7200<time()) {
      return $dd['access_token'];
    }else{
      $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential'.
                  '&appid=' . C('wx_config.APPID') .
                  '&secret=' . C('wx_config.APPSECRET');

      $data = $this->http_get($url);
      $json = json_decode($data);
      $m->where(array('id'=>1))->save(array('access_token'=>$json->access_token,'time'=>time()));
      return $json->access_token;
    }
  }

  public function getJsApiTicket($access_token) {

    if($jsapi_ticket != '') {
      return $jsapi_ticket;
    }

    $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket' .
                '?access_token=' . $access_token .
                '&type=jsapi';

    $data = $this->http_get($url);
    $json = json_decode($data);

    if(!isset($json->ticket)) {
      return '';
    }

    return $json->ticket;
  }

  /**
 * GET 请求
 * @param string $url
 */
public function http_get($url){
  $oCurl = curl_init();
  if(stripos($url,"https://")!==FALSE){
    curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
  }
  curl_setopt($oCurl, CURLOPT_URL, $url);
  curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
  $sContent = curl_exec($oCurl);
  $aStatus = curl_getinfo($oCurl);
  curl_close($oCurl);
  if(intval($aStatus["http_code"])==200){
    return $sContent;
  }else{
    return false;
  }
}

/**
 * POST 请求
 * @param string $url
 * @param array $param
 * @param boolean $post_file 是否文件上传
 * @return string content
 */
public function http_post($url,$param,$post_file=false){
  $oCurl = curl_init();
  if(stripos($url,"https://")!==FALSE){
    curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
  }
  if (is_string($param) || $post_file) {
    $strPOST = $param;
  } else {
    $aPOST = array();
    foreach($param as $key=>$val){
      $aPOST[] = $key."=".urlencode($val);
    }
    $strPOST =  join("&", $aPOST);
  }
  curl_setopt($oCurl, CURLOPT_URL, $url);
  curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt($oCurl, CURLOPT_POST,true);
  curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
  $sContent = curl_exec($oCurl);
  $aStatus = curl_getinfo($oCurl);
  curl_close($oCurl);
  if(intval($aStatus["http_code"])==200){
    return $sContent;
  }else{
    return false;
  }
}
  // 创建随机数
  public function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  // 微信支付签名
  public function wxPayData($body, $out_trade_no, $total_fee, $openid) {
    $appid = C('wx_config.APPID');
    $mch_id = C('wx_config.MCHID');
    $nonce_str = $this->createNonceStr();
    $spbill_create_ip = $_SERVER["REMOTE_ADDR"];
    $notify_url = 'http://' . $_SERVER['HTTP_HOST'] . '/Mobile/Pays/wxNotify';
    $time_start = date("YmdHis");
    $time_expire = date("YmdHis", time() + 900);
    $trade_type = 'JSAPI';

    // 生成预处理签名
    $stringA = "appid=$appid&body=$body&mch_id=$mch_id&nonce_str=$nonce_str&notify_url=$notify_url" .
              "&openid=$openid&out_trade_no=$out_trade_no&spbill_create_ip=$spbill_create_ip" .
              "&time_expire=$time_expire&time_start=$time_start&total_fee=$total_fee&trade_type=$trade_type";

    $stringSignTemp = $stringA . '&key=' . C('wx_config.KEY');
    $sign = strtoupper(md5($stringSignTemp));

    $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    $xmlTpl = "<xml>
                <appid><![CDATA[%s]]></appid>
                <body><![CDATA[%s]]></body>
                <mch_id><![CDATA[%s]]></mch_id>
                <nonce_str><![CDATA[%s]]></nonce_str>
                <notify_url><![CDATA[%s]]></notify_url>
                <out_trade_no><![CDATA[%s]]></out_trade_no>
                <spbill_create_ip><![CDATA[%s]]></spbill_create_ip>
                <time_start><![CDATA[%s]]></time_start>
                <time_expire><![CDATA[%s]]></time_expire>
                <total_fee><![CDATA[%s]]></total_fee>
                <trade_type><![CDATA[%s]]></trade_type>
                <sign><![CDATA[%s]]></sign>
                <openid><![CDATA[%s]]></openid>
              </xml>";

    $post_data = sprintf($xmlTpl, $appid, $body, $mch_id, $nonce_str, $notify_url, $out_trade_no,
                      $spbill_create_ip, $time_start, $time_expire, $total_fee, $trade_type, $sign, $openid);

    $return_data = $this->http_post($url, $post_data);

    libxml_disable_entity_loader(true);
    $data = simplexml_load_string($return_data, 'SimpleXMLElement', LIBXML_NOCDATA);

    // 重新签名
    $timeStamp = time();
    $nonceStr = $this->createNonceStr();
    $package = 'prepay_id=' . $data->prepay_id;
    $signType = 'MD5';

    $stringA = "appId=$appid&nonceStr=$nonceStr&package=$package&signType=$signType&timeStamp=$timeStamp";
    $stringSignTemp = $stringA . '&key=' . C('wx_config.KEY');
    $sign = strtoupper(md5($stringSignTemp));

    // 返回相关参数
    $data['timestamp'] = $timeStamp;
    $data['nonceStr'] = $nonceStr;
    $data['package'] = $package;
    $data['signType'] = $signType;
    $data['paySign'] = $sign;

    $data['status'] = 0;
    $data['message'] = '返回成功';

    return $data;
  }
}
