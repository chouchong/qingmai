<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>密码找回</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />


</head>
<body>

<div ng-app="myApp" ng-controller="pswCtrl">
<!-- content -->
<ion-content class=" scroll-content loginre">
    <div class="card">
    <form name="mypwsForm" novalidate>
        <div class="list">
            <label class="item item-input">
                <i class="icon ion-android-phone-portrait placeholder-icon loginrei"></i>
                <input type="tel" placeholder="请输入手机号" ng-model="pws.phone" required name="phone" ng-pattern="/^1\d{10}$/">
                <span ng-show="mypwsForm.phone.$dirty && mypwsForm.phone.$invalid">
                <i ng-show="mypwsForm.phone.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                <i ng-show="mypwsForm.phone.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                </span>
            </label>
            <div class="item item-input">
                <i class="icon ion-paper-airplane placeholder-icon loginreii"></i>
                <input type="text" placeholder="输入6验证码" ng-minlength="6" ng-model="pws.smscode" required name="smscode">
                <span ng-show="mypwsForm.smscode.$dirty && mypwsForm.smscode.$invalid">
                <i ng-show="mypwsForm.smscode.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                <i ng-show="mypwsForm.smscode.$error.minlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                </span>
                <span class="sendmessage"><button class="button buttonsms {{smsClass}}" style="height: 25px" ng-click="smsPws(pws.phone)" ng-disabled="mypwsForm.phone.$invalid" ng-bind="text"></button></span>
            </div>
            <label class="item item-input">
                <i class="icon ion-locked placeholder-icon loginrei"></i>
                <input type="password" placeholder="请输入6到12位的密码" ng-minlength="6" ng-maxlength="12" ng-model="pws.password" required name="password">
                <span ng-show="mypwsForm.password.$dirty && mypwsForm.password.$invalid">
                <i ng-show="mypwsForm.password.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                <i ng-show="mypwsForm.password.$error.minlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;" ></i>
                <i ng-show="mypwsForm.password.$error.maxlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;" ></i>
                </span>
            </label>
            <div class="item item-text loginbutton">
                <a>
                    <button ng-click="dopsw(pws)" ng-disabled="mypwsForm.$invalid" class="button button-block">修&nbsp;&nbsp;改</button>
                </a>
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