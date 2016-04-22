<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>我的订单</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>

<div ng-app="myApp" ng-controller="userInCtrl">
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
        <div class="card  insurance">
        <input type="hidden" id="orderId" value="<?php echo ($row['orderId']); ?>">
            <div class="item item-divider" >
                <span>订单号：<span> <?php echo ($row["orderNo"]); ?></span></span>
            </div>
            <div class="item item-text-wrap insurancepeo">
                <span id="adultNum"><?php echo ($row["adultNum"]); ?></span><span>成人</span>
                <span><?php echo ($row["childNum"]); ?></span><span>儿童</span>
            </div>
            <div class="item item-text-wrap">
                <span>被保险人信息要填下&nbsp;<em style="color: red;"><?php echo ($row["adultNum"]); ?></em>&nbsp;个人（请按护照信息录入）</span>
            </div>
        </div>
        <div ng-show="inUser">
            <div class="card" ng-repeat="vo in inUser">
                <label class="item item-divider">
                    <span class="">姓名：<span>{{vo.userName}}</span></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="">性别：
                    <span ng-if="vo.sex == 1 ">男</span>
                    <span ng-if="vo.sex == 2 ">女</span>
                    </span>
                </label>
                <label class="item item-divider">
                    <span class="input-label">护照号码：{{vo.userCard}}</span>
                </label>
                <label class="item item-divider" style="padding:0;">
                    <button ng-click="inEdit(vo)" class="button" style="float: right;color: #FB6B9C;"><i class=" ion-edit"></i>修改</button>
                </label>
            </div>
        </div>
        <div class="card">
            <label class="item item-input">
                <input type="hidden" id="iOrderId" value="<?php echo ($row['orderId']); ?>" />
                <span class="input-label">&nbsp;姓  &nbsp;名：</span>
                <input type="text" ng-model="oUser.userName">
            </label>
            <label class="item item-input">
                <span class="input-label">护照号码：</span>
                <input type="text" ng-model="oUser.userCard">
            </label>
            <label class="item item-input" style="padding:0 0 0 16px;">
                <span class="input-label">&nbsp;性  &nbsp;别：</span>
                <ion-radio ng-repeat="item in sexlist" ng-value="item.value" ng-model="oUser.sex" ng-change="serverSideChange(item)">
                    {{ item.text }}
                </ion-radio>
            </label>
        </div>
        <div class="row">
            <div style="width:100%;">
                <a ng-click="addUserIn()">
                    <button class="button button-block " style="background:#F77462;color:#fff;">提交资料</button>
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