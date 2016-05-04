<?php
return array(
  /*微信支付配置*/
  define('WEB_HOST', 'http://wmk223.imwork.net'),
  'wx_config'=>array(
    'APPID'=>'wx0aef4d2b61932fed',
    'APPSECRET'=>'bd9bb35a0b0990c64d7a68fa3f5d7939S',
    'MCHID'=>'1332805801',
    'KEY'=>'pE5isziDDFiOCVKcf1HhIC5ySr0sA9Hh',
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