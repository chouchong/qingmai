<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>确认支付</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

  <style type="text/css">
    .spinnerExample {
        margin: 10px 0;
    }
    .item-radio .radio-icon {
        position: absolute;
        top: 10px;
        right: 0;
        z-index: 3;
        visibility: hidden;
        padding: 14px;
        height: 100%;
        font-size: 24px;
    }
    </style>

</head>
<body>

<div ng-app="myApp" ng-controller="payCtrl">
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
    <ion-content id="content-index" class=" scroll-content has-header" style="    background: #f5f5f5;">
        <div class="row" style="background: #f5f5f5; ">
        <div class="manyps" style="padding: 8px; background:#fff;">
        <input  type="hidden" id="orderId" value="<?php echo ($order['orderId']); ?>" />
                <p><?php echo ($order["goodsName"]); ?></p>
                <?php if(!empty($order["drivesTo"])): ?><p><?php echo ($order["drivesTo"]); ?></p><?php endif; ?>
                <?php if(empty($order["toTime"])): ?><p>签证时间<span><?php echo ($order["createTime"]); ?></span></p>
                <?php else: ?>
                    <p>出发时间<span><?php echo ($order["toTime"]); ?></span></p><?php endif; ?>
                <?php if(!empty($order["childNum"])): ?><p>儿童<span><?php echo ($order["childNum"]); ?>&nbsp;X&nbsp;<?php echo ($order["childPrice"]); ?>&nbsp;元/人</span></p><?php endif; ?>
                <?php if(!empty($order["adultNum"])): ?><p>成人<span><em id="adultNum"><?php echo ($order["adultNum"]); ?></em>&nbsp;X&nbsp;<?php echo ($order["adultPrice"]); ?>&nbsp;元/人</span></p><?php endif; ?>
                <?php if(!empty($order["roomNum"])): ?><p>房价差<span><?php echo ($order["roomNum"]); ?>&nbsp;X&nbsp;<?php echo ($order["roomPrice"]); ?>&nbsp;元/间</span></p><?php endif; ?>
                <?php if($order['zMoney'] > 0 ): ?><p>优惠<span><?php echo ($order["zMoney"]); ?>&nbsp;元</span></p><?php endif; ?>
        </div>
        </div>
        <div class="list list-inset">
                <div class="item">
                    选择支付方式
                </div>
              <ion-radio ng-repeat="item in serverSideList "
                   ng-value="item.value"
                   ng-click="serverSideChange(item)">
              <div width="100%">
                <img style="float:left; margin: 0 5px;" ng-src="/Public/Mobile/{{ item.imgsrc }}" alt="" width="40px" >
                <div style="line-height: 15px;">
                    <h3 ng-bind="item.text"></h3><p ng-bind="item.desc"></p>
                </div>
            </div>
            </ion-radio>
        </div>
        <div class="row " style="background:#fff ;    font-size: 20px; ">
            <div class="col col-67">
                <p class="pricecolor" style="margin: 0; line-height: 50px; font-size: 20px;">应付&nbsp;¥<span><?php echo ($order["totalMoney"]); ?></span>&nbsp;元</p>
            </div>
            <div class="col col-33" style="background:#F77462; text-align: center;">
                <a ng-click="pay()" style="display: block;text-decoration: none;">
                    <span style="margin: 0; line-height: 50px;color: #fff;">立即支付</span>
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

<script>
</script>

</html>