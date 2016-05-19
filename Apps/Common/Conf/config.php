<?php
 return array(
	'VAR_PAGE'=>'p',
	'PAGE_SIZE'=>15,
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'localhost',
	'DB_NAME'=>'qingmai',
	'DB_USER'=>'root',
	'DB_PWD'=>'root',
	'DB_PREFIX'=>'dt_',
	'DEFAULT_C_LAYER' =>  'Action',
	'DEFAULT_CITY' => '440100',
	'DATA_CACHE_SUBDIR'=>true,
	'DATA_PATH_LEVEL'=>2,
	'SESSION_PREFIX' => 'WSTMALL',
	'COOKIE_PREFIX'  => 'WSTMALL',
	'LOAD_EXT_CONFIG' => 'wst_config',
	'LOG_RECORD' => true, // 开启日志记录
	'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误,
	'SESSION_AUTO_START'    =>  true,
	'MODULE_ALLOW_LIST'    =>    array('Home','Admin','Mobile','Api'),
	'DEFAULT_MODULE'       =>    'Home',  // 默认模块
	'APP_SUB_DOMAIN_DEPLOY'   =>    1, // 开启子域名配置
	'APP_SUB_DOMAIN_RULES'    =>    array(
	    'm.gozztrip.com'  => 'Mobile',
	    'admin.gozztrip.com'  => 'Admin',
	),
	'TMPL_TEMPLATE_SUFFIX'  =>  '.html',     // 默认模板文件后缀
    'URL_HTML_SUFFIX'       =>  'html',  // URL伪静态后缀设置  默认为html  去除默认的 否则很多地址报错
    'URL_CASE_INSENSITIVE'  =>  true,
    'URL_MODEL' => 2,
	);
?>