<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>注册</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

    <style>
    .checkbox input:after,
        .checkbox-icon:after{
            top: 15%;
            left: 20%;
        }
        .buttonsms {
            min-height: 35px;
            line-height: 7px;
        }
    </style>

</head>
<body>

<div ng-app="myApp">
    <!-- content -->
    <div class="scroll-content loginre" >
    <form ng-controller="regCtrl" name="myReForm" novalidate>
    <input type="hidden" id="goUrl" value="<?php echo ($url); ?>"/>
        <div class="card">
            <div class="list">
                <label class="item item-input">
                    <i class="icon ion-android-phone-portrait placeholder-icon loginrei"></i>
                    <input type="tel" placeholder="请输入手机号" ng-model="user.phone" required name="phone" ng-pattern="/^1\d{10}$/">
                    <span ng-show="myReForm.phone.$dirty && myReForm.phone.$invalid">
                    <i ng-show="myReForm.phone.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    <i ng-show="myReForm.phone.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <label class="item item-input">
                    <i class="icon ion-locked placeholder-icon loginrei"></i>
                    <input type="password" placeholder="请输入6到12位的密码" ng-minlength="6" ng-maxlength="12" ng-model="user.password" required name="password">
                    <span ng-show="myReForm.password.$dirty && myReForm.password.$invalid">
                    <i ng-show="myReForm.password.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    <i ng-show="myReForm.password.$error.minlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;" ></i>
                    <i ng-show="myReForm.password.$error.maxlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;" ></i>
                    </span>
                </label>
                <div class="item item-input">
                    <i class="icon ion-paper-airplane placeholder-icon loginreii"></i>
                    <input type="text" placeholder="输入6验证码" ng-minlength="6" ng-model="user.smscode" required name="smscode">
                    <span ng-show="myReForm.smscode.$dirty && myReForm.smscode.$invalid">
                    <i ng-show="myReForm.smscode.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    <i ng-show="myReForm.smscode.$error.minlength" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                    <span class="sendmessage"><button class="button buttonsms {{smsClass}}" style="height: 25px" ng-click="sms()" ng-disabled="myReForm.phone.$invalid" ng-bind="text"></button></span>
                </div>
                <div class="item item-text-wrap">
                    <span class="loginread">
                        <label class="checkbox" style="width: 18px;height: 18px;padding: 2px 0px;">
                            <input type="checkbox" ng-model="user.readMe" name="readMe" required style="width: 18px;height: 18px">
                        </label>
                        <span class="loginreads" >我已经阅读并同意</span>
                    <a href="">《用户服务条款》</a>
                    </span>
                </div>
                <div class="item item-text-wrap">
                    <a>
                        <button ng-click="doreg()" ng-disabled="myReForm.$invalid" class="button button-block button-calm loginbutton">注&nbsp;&nbsp;册</button>
                    </a>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>


</html>