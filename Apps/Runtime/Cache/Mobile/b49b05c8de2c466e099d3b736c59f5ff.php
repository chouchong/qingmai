<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title><?php echo ($good["goodsName"]); ?></title>
<meta name="keywords" content="<?php echo ($good['goodsKeywords']); ?>" />
<meta name="description" content="<?php echo ($good['goodsSpec']); ?>" />

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

    <link rel="stylesheet" href="/Public/Mobile/css/jquery.spinner.css" />

</head>
<body>

<div ng-app="myApp" ng-controller="goodCtrl">
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
</ion-header-bar> >
<!-- content -->
<ion-content id="content-index" overflow-scroll="false" class=" scroll-content has-header" style="    background: #f5f5f5;">
    <div class="card">
        <div class="item item-divider">
            <input type="hidden" id="goodsId" value="<?php echo ($goodsId); ?>" />
            <p style="font-size: 18px;margin:10px;"><span id="goodsName"><?php echo ($good["goodsName"]); ?></span></p>
            <img src="/<?php echo ($good['goodsImg']); ?>" alt="" width="100%">
            <p style="color:#F77A69;padding:10px; font-size: 16px;">￥<span><?php echo ($good['adultPrice']); ?></span>&nbsp;元/人</p>
        </div>
        <div class="item item-text-wrap">
            <p>
                <?php echo (htmlspecialchars_decode($good['goodsDesc'])); ?>
            </p>
        </div>
    </div>
    <!-- 日历 -->
    <div class="card" id="" style="margin: 0;">
        <div class="item item-divider " style="background-color: #11c1f3;">
            <div class="row" style="text-align: center;    margin: 0;">
                <div class="col col-25" onclick="preMonth()"><i class="ion-chevron-left"></i></div>
                <div class="col col-50"><span id="currentMonth">2016-03</span></div>
                <div class="col col-25" onclick="nextMonth()"><i class="ion-chevron-right"></i></div>
            </div>
        </div>
        <div  style="text-align: center;  font-size: 20px;  color: #11c1f3;">
            <div class=" col-14 dateday">日</div>
            <div class=" col-14 dateday">一</div>
            <div class=" col-14 dateday">二</div>
            <div class=" col-14 dateday">三</div>
            <div class=" col-14 dateday">四</div>
            <div class=" col-14 dateday">五</div>
            <div class=" col-14 dateday">六</div>
        </div>
        <div id="calendarSelect" class="responsive-break" style="text-align: center;">
        </div>
        <div class="row" style="text-align: center;">
            <div class="item item-text-wrap">
                <p>选择日期需从今日<span id="today" style="color:#c00;"><?php echo ($datetime); ?></span>后三天起开始选择</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="item item-divider">
            选择套餐
        </div>
        <div class="item item-text-wrap scenictime">
            <?php if(is_array($good["attrPrice"])): $i = 0; $__LIST__ = $good["attrPrice"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="scenictimes" >
                <button class="button button-outline button-stable"><span><?php echo ($vo["attrVal"]); ?></span><input type="hidden" value="<?php echo ($vo['attrPrice']); ?>" /></button>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="card">
        <div class="item item-divider">
            选择分店
        </div>
        <div class="item item-text-wrap scenicShop">
        <?php if(is_array($good["attrPrice"])): $i = 0; $__LIST__ = $good["attrPrice"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="scenicShops" >
                <button class="button button-outline button-stable"><?php echo ($vo["attrVal"]); ?></button>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="card">
        <ion-item >
        <input type="hidden" id="selectedDay" />
            <div  style="width:33%; float:left;">
                成人
            </div>
            <div style="width:33%; float:left;">
                <input id="manNum" type="text" class="spinnerExample" />
            </div>
            <div  style="width:33%; float:left; text-align: right;">
                <span id="manPrice"><?php echo ($good['adultPrice']); ?></span>元/人
            </div>
        </ion-item>
        <ion-item >
            <div  style="width:33%; float:left;">
                儿童
            </div>
            <div  style="width:33%; float:left;">
                <input id="childNum" type="text" class="spinnerExample" />
            </div>
            <div  style="width:33%; float:left; text-align: right;">
                <span id="childPrice"><?php echo ($good['childPrice']); ?></span>元/人
            </div>
        </ion-item>
    </div>
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
    <form name="myAddress" novalidate>
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
            <label class="item item-input item-floating-label">
                <button ng-click="addUserAddress()" ng-disabled="myAddress.$invalid" class="button button-positive">添加</button>
            </label>
        </div>
        </form>
    </div>
    <div class="row footermessage ">
        <div>
            <?php echo (htmlspecialchars_decode($CONF["mallFooter"])); ?>
        </div>
    </div>
    <div class="row" style="background:#fff ;font-size: 20px; ">
        <div class="col col-67">
            <p style="margin: 0; line-height: 50px;color: #F77462; font-size: 25px;">总计&nbsp;¥&nbsp;<span id="totalPrice">0</span>&nbsp;元</p>
        </div>
        <div class="col col-33" style="background:#F77462; text-align: center;">
        <a ng-click="goodOrAdd()" style="display: block;    text-decoration: none;">
                <span style="margin: 0; line-height: 50px;color: #fff;">提交订单</span>
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
<script src="/Public/Mobile/js/dateSelect.js"></script>
<script src="/Public/Mobile/js/goods.js" type="text/javascript"></script>

</html>