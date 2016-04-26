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
  ),
  'TOKEN_ON'=>true,  // 是否开启令牌验证
  'TOKEN_NAME'=>'__hash__',    // 令牌验证的表单隐藏字段名称
  'TOKEN_TYPE'=>'md5',  //令牌哈希验证规则 默认为MD5
  'TOKEN_RESET'=>true,  //令牌验证出错后是否重置令牌 默认为true
);