<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>我的账户</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>

<div ng-app="myApp" ng-controller="userCtrl">
    <ion-header-bar class="bar bar-light">
    <div id="myuser" style="display: none;">
        <?php if(empty($Users)): ?><div>
            <a href="<?php echo U('Mobile/Users/gologin');?>">登录</a>
        </div>
        <div style="line-height: 40px;color:#72C7DD;">
            <a href="<?php echo U('Mobile/Users/register');?>">注册</a>
        </div>
        <?php else: ?>
        <div>
            <a href="<?php echo U('Mobile/Users/index');?>">我的账户</a>
        </div>
        <div style="line-height: 40px;color:#72C7DD;">
            <a href="<?php echo U('Mobile/Orders/index');?>">我的订单</a>
        </div><?php endif; ?>
    </div>
    <a class="button button-clear" href="<?php echo U('Mobile/Index/index');?>">
        <img src="/<?php echo ($CONF['mallLogo']); ?>" height="32px" style="  color:#6CC5DC;">
    </a>
    <a class="button button-clear icon ion-navicon-round" ng-click="userShow()"></a>
</ion-header-bar>
    <!-- content -->
    <ion-content id="content-index" class=" scroll-content has-header" style="background: #f5f5f5;">
       <div class="card" style="">
           <div class="item item-text-wrap" >
                <i class="iocn ion-android-happy" ></i>&nbsp;&nbsp;用户账号
                <span style="float:right;">
                    <?php echo ($user["userPhone"]); ?>
                </span>
            </div>
           <div class="item item-text-wrap" >
                <a href="<?php echo U('Mobile/Users/reName');?>"><i class="iocn ion-android-person" ></i>&nbsp;&nbsp;修改用户名
                <span style="float:right;">
                    <?php echo ($user["userName"]); ?>
                </span></a>
            </div>
           <div class="item item-text-wrap">
                <a href="<?php echo U('Mobile/Users/addressList');?>"><i class="iocn ion-android-people" ></i>&nbsp;&nbsp;联系人管理</a>
            </div>
       </div>
    </ion-content>
    <ion-footer-bar align-title="center" class="bar-assertive">
        <h1 class="title"><a ng-click="logout()">退出登录</a></h1>
    </ion-footer-bar>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>


</html>