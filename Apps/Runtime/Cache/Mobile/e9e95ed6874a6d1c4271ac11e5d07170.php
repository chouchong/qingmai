<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>联系人管理</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

    <style>
    .button {
        line-height: 35px;
        float: right;
        background: #6dc5cc;
        min-height: 4px;
        color: #fff;
    }
    </style>

</head>
<body>

<div ng-app="myApp" ng-controller="Lmctrl">
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
        <div class="card" ng-repeat="vo in list">
            <div class="item item-text-wrap">
                <span ng-bind="vo.userName"></span>
                <span style="float:right;" ng-bind="vo.userPhone">
                </span>
                <p><span ng-bind="vo.userEmail"></span></p>
                <p><span ng-bind="vo.address"></span></p>
            </div>
            <div class="item item-divider">
                <span ng-if="vo.isDefault == 1">
                <i class="icon ion-android-checkmark-circle placeholder-icon" style="color:#12f;"></i>默认地址</span>
                <span style="float:right;" ng-if="vo.isDefault == 1">
                <i class="iocn ion-trash-a placeholder-icon" style="font-size: 20px" ></i>
                </span>
                <a ng-click="userIsDefault(vo.addressId)"><span ng-if="vo.isDefault == 0">设置为默认地址</span></a>
                <a ng-click="delAddress(vo.addressId)"><span ng-if="vo.isDefault == 0" style="float:right;font-size: 20px"><i class="iocn ion-trash-a" ></i></span></a>
            </div>
        </div>
        <a href="<?php echo U('Mobile/Users/userAddAddress');?>">
            <div class="item item-divider positive-bg" style="text-align: center;color:#fff;">
                添加联系人
            </div>
        </a>
    </ion-content>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>


</html>