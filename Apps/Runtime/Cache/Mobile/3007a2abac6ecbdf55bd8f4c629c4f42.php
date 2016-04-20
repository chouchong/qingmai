<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>验证码登录</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />


</head>
<body>

<div ng-app="myApp" ng-controller="codeCtrl">
<!-- content -->
<ion-content class=" scroll-content loginre">
    <div class="card">
    <input type="hidden" id="tocodeUrl" value="<?php echo ($url); ?>"/>
    <form name="mycodeForm" novalidate>
        <div class="list">
            <label class="item item-input">
                <i class="icon ion-android-phone-portrait placeholder-icon loginrei"></i>
                <input type="tel" placeholder="请输入手机号" ng-model="scode.phone" required name="phone" ng-pattern="/^1\d{10}$/">
                <span ng-show="mycodeForm.phone.$dirty && mycodeForm.phone.$invalid">
                <i ng-show="mycodeForm.phone.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                <i ng-show="mycodeForm.phone.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                </span>
            </label>
            <div class="item item-input">
                <i class="icon ion-paper-airplane placeholder-icon loginreii"></i>
                <input type="text" placeholder="输入6验证码" ng-minlength="6" ng-model="scode.smscode" required name="smscode">
                <span ng-show="mycodeForm.smscode.$dirty && mycodeForm.smscode.$invalid">
                <i ng-show="mycodeForm.smscode.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                <i ng-show="mycodeForm.smscode.$error.minlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                </span>
                <span class="sendmessage"><button class="button buttonsms {{smsClass}}" style="height: 25px" ng-click="smsCode(scode.phone)" ng-disabled="mycodeForm.phone.$invalid" ng-bind="text"></button></span>
            </div>
            <div class="item item-text loginbutton">
                <a>
                    <button ng-click="dologincode(scode)" ng-disabled="mycodeForm.$invalid" class="button button-block">登&nbsp;&nbsp;录</button>
                </a>
                <a href="<?php echo U('Mobile/Users/psw');?>"><span>忘记密码</span></a>
                <a href="/Mobile/Users/register?url=<?php echo ($url); ?>"><span class="registerbutton">注册账号</span></a>
            </div>
        </div>
    </form>
    </div>
</ion-content>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>


</html>