<?php
return array(
	'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
        'index' => 'Home/Index/index',
        'login' => 'Home/Users/login',
        'register' => 'Home/Users/register',
        'pass' => 'Home/Users/lostpassword',
        'z/:drivesId\d'    => 'Home/Drives/diverDetail',
        'v/:visaId\d:drivesId\d' => 'Home/Visas/index',
        'm/:goodsId\d' => 'Home/Goods/index',
        'a/:catId\d' => 'Home/Articles/getContent',
    ),
);