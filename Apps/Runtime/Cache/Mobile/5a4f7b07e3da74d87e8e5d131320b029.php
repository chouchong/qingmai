<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>订单确认</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>

<div ng-app="myApp" ng-controller="OrderDrvCtrl">
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
<form name="myAddress" novalidate>
<ion-content overflow-scroll="false" id="content-index" class="scroll-content has-header" style="    background: #f5f5f5;">
<input type="hidden" id="orderId" value="<?php echo ($orderId); ?>" />
    <div class="row" style=" padding: 8px;margin-bottom: 8px;">
        <div class="" style=" line-height: 180%;width: 100%;    background: #fff; padding:8px;">
            <p><span><strong><b><?php echo ($obj["goodsName"]); ?></b></strong></span><span style="color:#F77766;float:right;"><?php echo ($obj["drivesType"]); ?>&nbsp;<?php echo ($obj["adultPrice"]); ?>元/人</span></p>
            <p style="    clear: both;">
                <span style=""><?php echo ($obj["drivesTo"]); ?></span>
                <span style="background:#FFD679;color:#fff;float:right;    padding: 0 20px;"><?php echo ($obj['drivesDay']-1); ?>晚<?php echo ($obj['drivesDay']); ?>夜跨境自驾自由行</span>
            </p>
            <p  style="    clear: both;">
                出发时间： <span><?php echo ($obj["toTime"]); ?></span>
            </p>
            <p>
                结束时间： <span><?php echo ($obj["endTime"]); ?></span>
            </p>
        </div>
    </div>
    <div class="list" style="padding:8px;">
        <div class="item item-text-wrap">
            <p style="color:#FFA209;">不同的出发日期，酒店会有不同，请仔细确认</p>
        </div>
        <div>
            <?php echo (htmlspecialchars_decode($obj["goodsDrvivesTime"])); ?>
        </div>
    </div>
    <div class="card">
        <div class="item item-text-wrap">
            成人
            <span style="float:right;"><span id="manNum"><?php echo ($obj["adultNum"]); ?></span>人x <span><?php echo ($obj["adultPrice"]); ?></span>元/人</span>
        </div>
        <div class="item item-text-wrap">
            儿童
            <span style="float:right;"><span id="childNum"><?php echo ($obj["childNum"]); ?></span>人x <span><?php echo ($obj["childPrice"]); ?></span>元/人</span>
        </div>
        <div class="item item-text-wrap">
            用房数
            <span style="float:right;">1标准双床房</span>
        </div>
        <div class="item item-text-wrap">
            单房差
            <span style="float:right;">￥<span><?php echo ($obj['roomNum']*$obj['roomPrice']); ?></span>元</span>
        </div>
        <div class="item item-text-wrap" style="color:#F88B7D;">
            合计总价
            <span style="float:right;">￥<span id="totalMoney"><?php echo ($obj["totalMoney"]); ?></span>元</span>
        </div>
    </div>
    <div class="card">
        <p style="padding:10px;line-height: 150%;">全程酒店为标准双床房，如需安排标准大床房请勾选，我社工作人员将根据酒店情况尽量为您安排，但不保证能满足您的要求，敬请谅解！</p>
        <ion-checkbox id="bigRoom" ng-model="isChecked.checked" ng-checked="isChecked.checked">尽量安排标准大床房</ion-checkbox>
    </div>
    <div class="card" style="">
        <div class="item item-text-wrap defaultaddr">
        <h2>使用默认地址</h2>
            <input type="hidden" id="addressId" value="{{addRess.addressId}}" />
            <span>{{addRess.userName}}</span>
            <span style="float:right;">
                {{addRess.userPhone}}
            </span>
            <p><span>{{addRess.userEmail}}</span></p>
            <p><span>{{addRess.address}}</span></p>
        </div>
        <div ng-click="showAddress()" class="item item-divider">
            <span>
            <i  id="uselinkman" class="icon ion-android-radio-button-off placeholder-icon" style="color:#12f;"></i>添加新地址</span>
        </div>
    </div>
    <div class="card linkmanfrom" style="display: none;" >
        <div class="list">
            <label class="item item-input item-floating-label">
                <div style="padding:10px;">
                    <p style="font-size: 18px;">
                        联系人信息<span style="font-size: 13px;"> 一个订单一位联系人即可</span>
                    </p>
                </div>
            </label>
            <label class="item item-input item-floating-label">
                    <span>联系人</span>
                    <input type="text" placeholder="请输入(只能中文)联系人姓名" ng-model="isUser.name" required name="name" id="userName" ng-pattern="/[\u4e00-\u9fa5]/">
                    <span ng-show="myAddress.name.$dirty && myAddress.name.$invalid">
                        <i ng-show="myAddress.name.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                        <i ng-show="myAddress.name.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <label class="item item-input item-floating-label">
                    <span>联系电话</span>
                    <input type="tel" placeholder="请输入联系人电话" ng-model="isUser.phone" required name="phone" id="userPhone" ng-pattern="/^1\d{10}$/">
                    <span ng-show="myAddress.phone.$dirty && myAddress.phone.$invalid">
                        <i ng-show="myAddress.phone.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                        <i ng-show="myAddress.phone.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <label class="item item-input item-floating-label">
                    <span>联系人邮件</span>
                    <input type="email" placeholder="请输入您的邮件" ng-model="isUser.email" id="userisEmail" required name="email" >
                    <span ng-show="myAddress.email.$dirty && myAddress.email.$invalid">
                        <i ng-show="myAddress.email.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                        <i ng-show="myAddress.email.$error.email" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <label class="item item-input item-floating-label">
                    <span>您的地址&nbsp;&nbsp;<span style="font-size: 70%;color: #FF5F5F;">用于接收赠送礼盒</span></span>
                    <input type="text" placeholder="请输入您的地址"  ng-model="isUser.address" id="userisAddress" required name="address">
                    <span ng-show="myAddress.address.$dirty && myAddress.address.$invalid">
                        <i ng-show="myAddress.address.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
        </div>
    </div>
    <div class="card item-input" style="padding:16px;">
        <textarea ng-model="order.Desc" id="orderddd" placeholder="亲如有特殊要求，请在此处留言，我们会尽快与您联系"></textarea>
    </div>
    <div id="Zcode" class="card">
        <div class="item item-button-right" id="ZcodeAdd">
            我有Z码
            <button ng-click="resizeContent()" id="addZcode" class="button ">&nbsp;&nbsp;<i class="ion-plus-round"></i>&nbsp;&nbsp;</button>
        </div>
        <div  class="item " style="display:none;">
        <input id="allzcodes" type="hidden" />
            已为您优惠<span id="allZcodePrice">0</span>
        </div>
    </div>
    <div class="card">
        <ion-checkbox id="bigRoom" ng-model="isReadMe.checked" ng-checked="isReadMe.checked">已阅读并同意<a href="#" style="color: blue;">《产品订购协议》</a></ion-checkbox>
    </div>
    <div class="row footermessage ">
        <div>
            <?php echo (htmlspecialchars_decode($CONF["mallFooter"])); ?>
        </div>
    </div>
    <div class="row" style="background:#fff ;    font-size: 20px; ">
        <div class="col col-67">
            <p style="margin: 0; line-height: 50px;color: #F77462; font-size: 25px;">应付&nbsp;¥&nbsp;<span id="totalPrice"><?php echo ($obj['totalMoney']); ?></span>元</p>
        </div>
        <button ng-click="odcf()"  class="col col-33" style="background:#F77462; text-align: center;border: 1px solid #F77462; color: #fff;font-size: 20px">立即支付</button>
    </div>
</form>
</ion-content>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>

<script src="/Public/Mobile/js/cMdrives.js" type="text/javascript"></script>

</html>