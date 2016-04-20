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

<div ng-app="myApp">
<ion-content  class=" scroll-content loginre">
    <form ng-controller="logCtrl" name="myForm" novalidate>
    <input type="hidden" id="togoUrl" value="<?php echo ($url); ?>"/>
        <div class="card">
            <div class="list">
                <label class="item item-input">
                    <i class="icon ion-android-phone-portrait placeholder-icon loginrei"></i>
                    <input type="tel" placeholder="请输入手机号" ng-model="user.phone" required name="phone" ng-pattern="/^1\d{10}$/">
                    <span ng-show="myForm.phone.$dirty && myForm.phone.$invalid">
                    <i ng-show="myForm.phone.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    <i ng-show="myForm.phone.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <label class="item item-input">
                    <i class="icon ion-locked placeholder-icon loginrei"></i>
                    <input type="password" placeholder="请输入6到12位的密码" ng-minlength="6" ng-maxlength="12" ng-model="user.password" required name="password">
                    <span ng-show="myForm.password.$dirty && myForm.password.$invalid">
                    <i ng-show="myForm.password.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    <i ng-show="myForm.password.$error.minlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;" ></i>
                    <i ng-show="myForm.password.$error.maxlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;" ></i>
                    </span>
                </label>
                <div class="item item-text loginbutton">
                    <a>
                        <button ng-click="dologin()" ng-disabled="myForm.$invalid" class="button button-block">登&nbsp;&nbsp;录</button>
                    </a>
                    <a href="<?php echo U('Mobile/Users/psw');?>"><span>忘记密码</span></a>
                    <a href="/Mobile/Users/register?url=<?php echo ($url); ?>"><span class="registerbutton">注册账号</span></a>
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