<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>我的订单</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

<style>
  .bb{
    background: #387ef5;
    color: #fff;
    float: right;
    padding: 5px;
    margin: 0 5px;
  }
  .bb a{
    color: #fff;
  }
</style>

</head>
<body>

<div ng-app="myApp" ng-controller="orCtrl">
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
         <div class="card gopay" ng-repeat="vo in oList">
            <div class="item item-divider">
                <element ng-switch="vo.goodsType">
                  <element ng-switch-when="1"><i class="icon ion-model-s"></i></element>
                  <element ng-switch-when="2"><i class="icon ion-android-image"></i></element>
                  <element ng-switch-when="3"><i class="icon ion-ios-bookmarks-outline"></i></element>
                  <element ng-switch-default></element>
                </element>
                <element ng-switch="vo.orderStatus">
                  <element ng-switch-when="0">
                    <span class="textright">
                        <a href="/Mobile/Pays/payment/orderId/{{vo.orderId}}">去付款</a>
                    </span>
                    <span class="textright" style="color:#f32;background:#fff;" ng-click="orDel(vo,$index)">订单取消</span>
                  </element>
                  <element ng-switch-when="1">
                    <span>待出发</span>
                    <p ng-if="vo.goodsType==1"><span ng-if="vo.isGo==0" class="bb" style="float:right;"><a  href="/Mobile/Users/UserIn/orderId/{{vo.orderId}}">被保险人</a></span>
                    <span ng-if="vo.isCar==0" class="bb" style="float:right;"><a  href="/Mobile/Users/UserCar/orderId/{{vo.orderId}}">出境车辆行驶证</a></span></p>
                  </element>
                  <element ng-switch-when="2">
                    <span>去评论</span>
                    <span ng-if="vo.goodsType==1" class="bb" style="float:right;"><a  href="/Mobile/Drives/dComment/orderId/{{vo.orderId}}">评论</a></span>
                  </element>
                  <element ng-switch-when="3">
                    <span>已完成</span>
                    <span  class="textright" style="float:right;"><a>完成</a></span>
                  </element>
                  <element ng-switch-default></element>
                </element>
            </div>
            <element ng-switch="vo.goodsType">
              <element ng-switch-when="1">
                <div class="item item-wrap orderMessage">
                    自驾游
                    <span>{{vo.goodsName}}</span>
                </div>
              </element>
              <element ng-switch-when="2">
                <div class="item item-wrap orderMessage">
                    门票
                    <span>{{vo.goodsName}}</span>
                </div>
              </element>
              <element ng-switch-when="3">
                <div class="item item-wrap orderMessage">
                    签证
                    <span>{{vo.goodsName}}</span>
                </div>
              </element>
              <element ng-switch-default></element>
            </element>
            <div class="item item-wrap orderMessage">
                订单号
                <span>{{vo.orderNo}}</span>
            </div>
             <div class="item item-wrap orderMessage" ng-if="vo.goodsType==1">
                {{vo.drivesTo}}
                <span>{{vo.drivesDay|to_day}}</span>
            </div>
            <div class="item item-wrap orderMessage" ng-if="vo.toTime">
                出发日期
                <span>{{vo.toTime}}</span>
            </div>
            <div class="item item-wrap orderMessage" ng-if="vo.goodsType==3">
                签证日期
                <span>{{vo.createTime}}</span>
            </div>
            <div class="item item-wrap orderMessage">
                成人
                <span>{{vo.adultNum}}人 x {{vo.adultPrice}}元/人</span>
            </div>
            <div class="item item-wrap orderMessage" ng-if="vo.childNum > 0">
                儿童
                <span>{{vo.childNum}}人 x {{vo.childPrice}}元/人</span>
            </div>
            <div class="item item-wrap orderMessage" ng-if="vo.roomNum > 0">
                房间
                <span>{{vo.roomNum}}房 x {{vo.roomPrice}}元/房</span>
            </div>
            <div class="item item-wrap orderMessage" ng-if="vo.zMoney > 0">
                优惠
                <span>{{vo.zMoney}} 元</span>
            </div>
            <div class="item item-text-wrap orderMessage">
                合计价格
                <span class="pricecolor">￥ {{vo.totalMoney}} 元</span>
            </div>
        </div>
    <ion-infinite-scroll
        on-infinite="doRefresh()"
        distance="3%" ng-if="!isfresh"
        refreshing-text="Refreshing!"
        refreshing-icon="ion-loading-b">
    </ion-infinite-scroll>
    </ion-content>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>

<script>
</script>

</html>