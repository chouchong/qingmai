<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>登录</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>

<div ng-app="myApp" ng-controller="goLogCtrl">
    <ion-content  class=" scroll-content loginre">
    <input type="hidden" id="totoUrl" value="<?php echo ($url); ?>"/>
        <form name="mygoForm" novalidate>
        <div class="card">
            <div class="list">
                <label class="item item-input">
                    <i class="icon ion-android-phone-portrait placeholder-icon loginrei"></i>
                    <input type="tel" placeholder="请输入手机号" ng-model="gouser.phone" required name="phone" ng-pattern="/^1\d{10}$/">
                    <span ng-show="mygoForm.phone.$dirty && mygoForm.phone.$invalid">
                    <i ng-show="mygoForm.phone.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    <i ng-show="mygoForm.phone.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <div class="item item-text loginbutton">
                    <span style="float:right;"><a href="/Mobile/Users/login?url=<?php echo ($url); ?>">密码登陆</a></span>
                    <a>
                        <button ng-click="dogologin(gouser)" ng-disabled="mygoForm.$invalid" class="button button-block">发送验证码</button>
                    </a>
                    <a href="<?php echo U('Mobile/Users/psw');?>"><span>忘记密码</span></a>
                    <a href="/Mobile/Users/register?url=<?php echo ($url); ?>"><span class="registerbutton">注册</span></a>
                </div>
            </div>
        </div>
        </form>
    </ion-content>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>


</html>