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
	'APP_SUB_DOMAIN_DEPLOY'  =>    1, // 开启子域名配置
	'APP_SUB_DOMAIN_RULES'   =>array(
	    'm.dt.ngrok.4kb.cn'  => 'Mobile',  // m.dt.ngrok.4kb.cn域名指向Mobile模块
	),
	);
?>