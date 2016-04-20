<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>两国签证</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

<link rel="stylesheet" href="/Public/Mobile/css/jquery.spinner.css" />

</head>
<body>

<div ng-app="myApp" ng-controller="visaCtrl">
<ion-header-bar class="bar bar-light">
    <div id="myuser" style="display: none;">
        <div class="" style="">
            <a href="<?php echo U('Mobile/Users/index');?>">我的账户</a>
        </div>
        <div class="" style="line-height: 40px;color:#72C7DD;">
            <a href="<?php echo U('Mobile/Orders/index');?>">我的订单</a>
        </div>
    </div>
    <a class="button button-clear" href="<?php echo U('Mobile/Index/index');?>">
        <img src="/<?php echo ($CONF['mallLogo']); ?>" height="32px" style="  color:#6CC5DC;">
    </a>
    <a class="button button-clear icon ion-navicon-round" ng-click="userShow()"></a>
</ion-header-bar>
<!-- content -->
<ion-content id="content-index" overflow-scroll="false" class=" scroll-content has-header" style="    background: #f5f5f5;">
    <div class="card">
        <div class="item item-text-wrap" style="background:#6CC5DC;color:#fff;">
            泰国老挝签证基本信息说明
        </div>
        <div class="item item-text-wrap">
            签证类型
            <span style="float:right;">旅游签</span>
        </div>
        <div class="item item-text-wrap">
            有效期
            <span style="float:right;">停留期30-60天</span>
        </div>
        <div class="item item-text-wrap">
            入境次数
            <span style="float:right;">单次</span>
        </div>
    </div>
    <div class="card" id="visacard" style="">
        <div class="item item-text-wrap" style="background:#6CC5DC;color:#fff;">
            办理泰国老挝签证所需资料
        </div>
        <div class="item item-text-wrap" style="padding:0;">
            <div style="padding:10px;">
                <p>您只需准备1.【护照原件】2.【照片四张】3.【身份证】</p><br/>
                <p>
                【身份证 正反面复印件一份】
                护照完整无损、无水渍（请去掉护照套）
                </p><br/>
                <p>
                【护照原件】
                护照有效期大于6个月、成人儿童一样
                至少需有4页完整的空白签证页（不包含备注页）
                </p><br/>
                <p>
                【照片】
                证件照两张 规格35MMX45MM
                本人近6个月内彩色白底照片4张
                五官端正清晰、耳朵外露、不露肩膀、不能戴配饰
                请用圆珠笔在照片背面写上您的名字
                </p><br/>
                <p>
                建议：在送交或邮寄出护照前请复印或拍摄护照重要
                页面、以备不时之需！
                </p><br/>
                <p>
                以下情况不可办理：
                由于客人自身原因护照有DT记录/两次或多次借证记
                录/境外延期被罚款/假签证等（需要退回订单并且邮
                费自理、敬请谅解！）
                </p>
            </div>
            <span style="background:#FFD679;width:100%;display:block; padding:3px 0 0 10px;height: 35px;line-height: 30px;">办理时段</span>
            <div style="padding:10px;">
                <p style="color:#FFD679;">
                    特别提示：由于两国签证需分别办理，请于出发日期前15天递交或邮寄所需资料
                </p>
            </div>
            <span style="background:#6CC5DC;width:100%;display:block; padding:3px 0 0 10px;height: 40px;line-height: 35px;">您可以选择以下三种方式办理：</span>
            <div class="list">
                <label class="item item-input item-floating-label">
                    <div style="padding:10px;">
                        <p style="">
                            1.特别提示：由于两国签证需分别办理，请于出发日期前15天递交或邮寄所需资料
                        </p>
                    </div>
                </label>
                <!-- <hr> -->
                <label class="item item-input item-floating-label">
                    <div style="padding:10px;">
                        <p style="">
                            2.特别提示：由于两国签证需分别办理，请于出发日期前15天递交或邮寄所需资料
                        </p>
                    </div>
                </label>
                <!-- <hr> -->
                <label class="item item-input item-floating-label">
                    <div style="padding:10px;">
                        <p style="">
                            3.特别提示：由于两国签证需分别办理，请于出发日期前15天递交或邮寄所需资料
                        </p>
                        <!-- <div class="row">
                        </div> -->
                    </div>
                </label>
                <!-- <hr> -->
                <!-- <label class="item item-floating-label "> -->
                    <div class="row" style="padding:6px 0 5px 16px;">
                        <div  style="width:33%;">
                            数量
                        </div>
                        <div  style="width:33%; float:center;">
                            <input id="visaNum" type="text" class="spinnerExample" />
                        </div>
                        <div  style="width:33%;  text-align: right;">
                            <span id="visaPrice" style="color:#F88B7D">400</span>元/份
                        </div>
                    </div>
                <!-- </label> -->
                <label class="item item-input item-floating-label">
                    <div style="padding:10px 10px 10px 0px;">
                        总价格<span style="float:right; color:#F88B7D">￥<span id="totalPrice">0</span>元</span>
                    </div>
                </label>
                <div class="card" >
        <div class="item item-text-wrap defaultaddr" ng-show="addRess">
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
    <div class="card linkmanfrom" style="display: none;">
    <form name="visaAddress" novalidate>
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
                    <input type="text" placeholder="请输入(只能中文)联系人姓名" ng-model="isVisa.name" required name="name" id="userName" ng-pattern="/[\u4e00-\u9fa5]/">
                    <span ng-show="visaAddress.name.$dirty && visaAddress.name.$invalid">
                        <i ng-show="visaAddress.name.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                        <i ng-show="visaAddress.name.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <label class="item item-input item-floating-label">
                    <span>联系电话</span>
                    <input type="tel" placeholder="请输入联系人电话" ng-model="isVisa.phone" required name="phone" id="userPhone" ng-pattern="/^1\d{10}$/">
                    <span ng-show="visaAddress.phone.$dirty && visaAddress.phone.$invalid">
                        <i ng-show="visaAddress.phone.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                        <i ng-show="visaAddress.phone.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <label class="item item-input item-floating-label">
                    <span>联系人邮件</span>
                    <input type="email" placeholder="请输入您的邮件" ng-model="isVisa.email" id="userisEmail" required name="email" >
                    <span ng-show="visaAddress.email.$dirty && visaAddress.email.$invalid">
                        <i ng-show="visaAddress.email.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                        <i ng-show="visaAddress.email.$error.email" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
                <label class="item item-input item-floating-label">
                    <span>您的地址&nbsp;&nbsp;<span style="font-size: 70%;color: #FF5F5F;">用于接收赠送礼盒</span></span>
                    <input type="text" placeholder="请输入您的地址"  ng-model="isVisa.address" id="userisAddress" required name="address">
                    <span ng-show="visaAddress.address.$dirty && visaAddress.address.$invalid">
                        <i ng-show="visaAddress.address.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>
                </label>
            <label class="item item-input item-floating-label">
                <button ng-click="addUserAddress()" ng-disabled="visaAddress.$invalid" class="button button-positive">添加</button>
            </label>
        </div>
        </form>
    </div>
        <label class="item item-input item-floating-label" style="text-align: center;">
            <p>付款后请将所需资料仔细检查备齐后寄送至：</p>
            <p>昆明市穿金路白汁小区11-3栋</p>
            <p>昆明春秋国际旅行社有限公司 泰老签（收）</p>
            <p>13888222888 0871-65096386</p>
            <p>邮费自理</p>
        </label>
        </div>
    </div>
    </div>
      <div class="row">
        <div style="width:100%;">
            <a ng-click="addVisa()">
                <button class="button button-block " style="background:#F77462;color:#fff;">下一步</button>
            </a>
        </div>
    </div>
</ion-content>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>

<script type="text/javascript" src="/Public/Mobile/js/jquery.spinner.js"></script>
<script>
    $('.spinnerExample').spinner({});
    $("#visaNum").parent().click(function(){
        var totalPrice = $('#visaPrice').html()*$("#visaNum").val();
        $('#totalPrice').html(totalPrice);
    });
</script>

</html>