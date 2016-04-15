<?php
return array(
  /*微信支付配置*/
  define('WEB_HOST', 'http://wmk223.imwork.net'),
  'wx_config'=>array(
    'APPID'=>'wxad259a42911fa598',
    'APPSECRET'=>'039e5f26008ebdd5665a8656191ec9c2',
    'MCHID'=>'1282883901',
    'KEY'=>'QQFjaWwhLeqfgKCvqiXhYgJHFjHg9a8F',
    // 'JS_API_CALL_URL' => WEB_HOST.'/Mobile/Pays/wxNotify',
    // 'SSLCERT_PATH' => WEB_HOST.'/ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_cert.pem',
    // 'SSLKEY_PATH' => WEB_HOST.'/ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_key.pem',
    'NOTIFY_URL' =>  WEB_HOST.'/Mobile/Pays/wxNotify'
    // 'CURL_TIMEOUT' => 30
  )
);