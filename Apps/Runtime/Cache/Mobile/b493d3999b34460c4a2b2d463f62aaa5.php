<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title><?php echo ($drive["drivesName"]); ?></title>
<meta name="keywords" content="<?php echo ($drive['drivesKeywords']); ?>" />
<meta name="description" content="<?php echo ($drive['drivesSpec']); ?>" />

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

    <link rel="stylesheet" href="/Public/Mobile/css/jquery.spinner.css" />

</head>
<body>

<div ng-app="myApp" ng-controller="drvCtrl">
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
    <ion-content id="content-index" class="scroll-content has-header" style="background: #f5f5f5;" delegate-handle="drivesScroll">
        <input type="hidden" id="drivesId" value="<?php echo ($drivesId); ?>" />
        <input type="hidden" id="daytime" value="<?php echo ($daytime); ?>" />
        <input type="hidden" id="selectedDay" />
        <div class="row" style="background: #f5f5f5; padding: 8px;margin-bottom: 8px;">
            <a>
                <img src="/<?php echo ($drive["drivesImg"]); ?>" alt="" width="100%">
                <div class="" style="float:left; line-height: 180%;width: 100%;">
                    <p><?php echo ($drive["drivesName"]); ?></p>
                    <p>
                        <span><?php echo ($drive["drivesFrom"]); ?></span>
                        <span style="background:#FFD679;color:#fff;float:right;    padding: 0 20px;"><?php echo ($drive['drivesDay']-1); ?>晚<span><?php echo ($drive['drivesDay']); ?></span>夜跨境自驾自由行</span>
                    </p>
                    <p style="clear:both;">
                    <?php if(empty($drive["tp"])): ?><span style="color:#F77766; "><span id="drivesType"><?php echo ($drive['tp']['drivesType']); ?></span>&nbsp;<span id="tpadultPrice"><?php echo ($drive['adultPrice']); ?></span>&nbsp;元/人</span>
                    <?php else: ?>
                    <span style="color:#F77766;"><span id="drivesType"><?php echo ($drive['tp']['drivesType']); ?></span>&nbsp;<span id="tpadultPrice"><?php echo ($drive['tp']['adultPrice']); ?></span>&nbsp;元/人</span><?php endif; ?>
                        <span style="float:right;color:#38B8EF;"><span><?php echo ($drive["solaCount"]); ?></span>人已购买</span>
                    </p>
                </div>
            </a>
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
            <div class="" style="text-align: center;  font-size: 20px;  color: #11c1f3;">
                <div class=" col-14 dateday">日</div>
                <div class=" col-14 dateday">一</div>
                <div class=" col-14 dateday">二</div>
                <div class=" col-14 dateday">三</div>
                <div class=" col-14 dateday">四</div>
                <div class=" col-14 dateday">五</div>
                <div class=" col-14 dateday">六</div>
            </div>
            <div id="calendarprice" class=" responsive-break" style="text-align: center;">
                <!-- 日期价格表 -->
            </div>
            <div class="row" style="text-align: center;">
                <div class="item item-text-wrap">
                    <p>本起价是按2位成人参加2016-06-06出发的产品，并入住同一间房间的单人价格。</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div style="width:100%;">
                <a href="#order">
                    <button ng-click="openGPopover()" class="button button-block button-calm">没有合适日期或需定制</button>
                </a>
            </div>
        </div>
        <div class="row">
            <div style="width:100%;padding:5px; border:1px solid #D6D6D6;">
                <p style="text-align: center;">资讯热线0871-65096417/65096418</p>
                <p>
                    <a href="#order">
                        <button ng-click="openDPopover()" class="button button-block button-calm">用户如需前往本部报名 点击这里</button>
                    </a>
                </p>
            </div>
        </div>
        <div class="list xcapmsg">
            <div class="item item-text-wrap">
                <p style="color:#FFA209;">不同的出发日期，酒店会有不同，请仔细确认</p>
            </div>
            <div id="timeDesc">
             <?php echo (htmlspecialchars_decode($drive["tp"]["timeDesc"])); ?>
            </div>
        </div>
        <!-- 选择人数 -->
        <ion-list class="list list-inset" style="width:100%;">
            <ion-item class="">
                <div style="width:33%; float:left;">
                    成人
                </div>
                <div style="width:33%; float:left;">
                    <input id="manNum" type="text" readonly="true" class="spinnerExample" />
                    <input id="timeId" type="hidden" />
                </div>
                <div style="width:33%; float:left; text-align: right;">
                    <?php if(empty($drive["tp"])): ?><span id="manPrice"><?php echo ($drive["adultPrice"]); ?></span>
                    <?php else: ?>
                    <span id="manPrice"><?php echo ($drive["tp"]["adultPrice"]); ?></span><?php endif; ?>
                    元/人
                </div>
            </ion-item>
            <ion-item >
                <div style="width:33%; float:left;">
                    儿童
                </div>
                <div style="width:33%; float:left;">
                    <input id="childNum" type="text" readonly="true" class="spinnerExample" />
                </div>
                <div class="" style="width:33%; float:left; text-align: right;">
                    <span id="childPrice"><?php echo ($drive["childPrice"]); ?></span>&nbsp;元/人
                </div>
                <p style="font-size: 10px; margin-top: 35px;     clear: both;">12岁以下，不占床，不含早餐</p>
            </ion-item>
            <ion-item>
                <div style="width:33%; float:left;">
                    房间数
                </div>
                <div style="width:33%; float:left;">
                    <input id="roomNum" type="text" readonly="true" class="spinnerExample" />
                </div>
                <div style="width:33%; float:left;text-align: right;color: red;display: none;">
                    <span id="roomPrice" style=""><?php echo ($drive["homePrice"]); ?></span>&nbsp;元/人
                </div>
            </ion-item>
            <ion-item style="font-size: 20px;">
                总价格 <span style="float:right;color: #EC5037;">¥<span id="totalPrice">0</span>元</span>
            </ion-item>
        </ion-list>
        <div class="list card cardPS">
            <div class="item">
                <span>价格说明</span>
                <i class="icon  ion-chevron-up placeholder-icon"></i>
            </div>
            <div class="item item-body">
                <div>
                <?php echo (htmlspecialchars_decode($drive["priceDesc"])); ?>
                </div>
            </div>
        </div>
        <div class="list card cardPS">
            <div class="item">
                <span>费用包含</span>
                <i class="icon  ion-chevron-up placeholder-icon"></i>
            </div>
            <div class="item item-body">
                <div>
                <?php echo (htmlspecialchars_decode($drive["isFeeDesc"])); ?>
                </div>
            </div>
        </div>
        <div class="list card cardPS">
            <div class="item">
                <span>费用不含</span>
                <i class="icon  ion-chevron-up placeholder-icon"></i>
            </div>
            <div class="item item-body">
               <div>
                <?php echo (htmlspecialchars_decode($drive["noFeeDesc"])); ?>
                </div>
            </div>
        </div>
        <div class="list card cardPS">
            <div class="item ">
                <span>赠送项目</span>
                <i class="icon  ion-chevron-up placeholder-icon"></i>
            </div>
            <div class="item item-body">
                <div>
               <?php echo (htmlspecialchars_decode($drive["presentProject"])); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-20" style="text-align: right;">
                <img src="/Public/Mobile/img/qz.png" alt="" width="100%">
            </div>
            <div class="col col-80">
                <p style="font-size: 15px;">已有护照客人（护照有效期6个月以上、空白签证页4页）请在出行前自行办理好泰国老挝两国签证。或在出行前15日交由我社代办、详见下方惠享代办所需资料说明！</p>
            </div>
        </div>
        <div class="row">
            <div class="col col-20" style="text-align: right;">
                <img src="/Public/Mobile/img/tg.png" alt="" width="100%">
            </div>
            <div class="col col-80">
                <p style="font-size: 15px;padding-top: 6px">产品数量有限、一经确认不接受任何退改！</p>
            </div>
        </div>
        <div class="row">
            <div style="width:100%;padding:5px; border:1px solid #C4DCE2;">
                <p style="text-align: center; font-size: 14px;"><span style="font-size: 18px;
    margin: 0 20px;color: #000;">所需资料</span>护照及签证：有效期内护照及泰国老挝两国签证</p>
                <p>
                    <a ng-click="visa()">
                        <button class="button button-block button-calm">惠享400元代办两国签证 点击这里</button>
                    </a>
                </p>
                <p style="text-align: center;font-size: 14px;">
                    代办签证限报名用户 昆明三环内提供上门取件
                </p>
            </div>
        </div>
        <div class="row ">
            <span style="color: #555;font-size: 20px;">酒店信息</span>
        </div>
        <?php if(is_array($drive['noWay'])): $i = 0; $__LIST__ = $drive['noWay'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ht): $mod = ($i % 2 );++$i;?><ion-list class="hotelshow" type="list-inset" >
            <div class="hotelshows" >
                <ion-slide-box does-continue=true auto-play=true>
                    <?php if(is_array($ht['gallerys'])): $i = 0; $__LIST__ = $ht['gallerys'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$himg): $mod = ($i % 2 );++$i;?><ion-slide><img src="/<?php echo ($himg["hotelThumbs"]); ?>"></ion-slide><?php endforeach; endif; else: echo "" ;endif; ?>
                </ion-slide-box>
                <p class="passhoteltitle"><?php echo ($ht["hotelName"]); ?></p>
                <p ><?php $__FOR_START_18699__=0;$__FOR_END_18699__=$ht['hotelStar'];for($i=$__FOR_START_18699__;$i < $__FOR_END_18699__;$i+=1){ ?><i class="iocn ion-star"></i><?php } ?>
                    <span style="color:#000;">评分<?php echo ($ht["hotelStar"]); ?></span></p>
                <p class="hotelshowcon" ><?php echo (htmlspecialchars_decode($ht["hotelDesc"])); ?></p>
                <p class="detail"><a ng-click="openPopover(<?php echo ($ht['hotelId']); ?>)">查看详情</a></p>
            </div>
        </ion-list><?php endforeach; endif; else: echo "" ;endif; ?>
        <div class="row passhotel">
            <p class="passhotelsm"><span >途中酒店信息</span>
                <br/> 本行程亮点为清迈、途中仅提供经济型酒店
            </p>
        </div>
        <ion-list class="passhotellist" >
         <?php if(is_array($drive['isWay'])): $i = 0; $__LIST__ = $drive['isWay'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ht): $mod = ($i % 2 );++$i;?><div class="passhotelitem" >
                <img src="/<?php echo ($ht['hotelImg']); ?>" alt="">
                <p class="passhoteltitle" ><?php echo ($ht["hotelName"]); ?></p>
                <p ><?php echo (htmlspecialchars_decode($ht["hotelDesc"])); ?></p>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </ion-list>
        <div class="list xcjsList">
            <div class="item cardPS">行程介绍
                <i class="icon  ion-chevron-up placeholder-icon"></i>
            </div>
            <div>
                <div class="item item-text-wrap">
                    <h2>行车地图</h2>
                    <img ng-click="openMPopover()" src="/<?php echo ($drive['drivesMap']); ?>" style="margin: 5px 0;" width="100%">
                    <p style="margin: 5px 0;">以下行程已部分包含及推荐清迈必游的TOP10景点</p>
                </div>
                <?php if(is_array($drive['articles'])): $i = 0; $__LIST__ = $drive['articles'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$at): $mod = ($i % 2 );++$i;?><div class="xcmessage">
                        <span class="xcmessageTit"><?php echo ($at["articleTitle"]); ?></span>
                        <div class="xcmessageP">
                            <?php echo (htmlspecialchars_decode($at["articleContent"])); ?>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="list card">
            <div class="item">
                <h1>自驾游出游提示</h1>
            </div>
            <div class="item item-body" style="line-height: 130%;">
                <p>
                    成人价格：按照2位成人参加所选日期发出产品，并入住同一间房间价格所核算的单人价格。
                    <br/>
                    <br/> 儿童价格：12岁以下儿童仅包含行程中流浪项目，不占床位，不提供加床，不含酒店早餐的价格。（就当早餐产生费用家长自理）
                </p>
            </div>
        </div>
        <div class="card zjywarm">
            <div class="item item-divider" >
                <h2 >温馨提示</h2>
            </div>
            <div class="item item-text-wrap" style="    ">
                <p >温馨提示温馨提示温馨提示温馨提示温馨提示温馨提示温馨提示温馨提示温馨提示温馨提示</p>
            </div>
        </div>
        <div class="list card zjytjjd">
            <div class="item item-icon-right cardPS">
                <h1>景点推荐</h1>
                <i class="icon  ion-chevron-up placeholder-icon"></i>
            </div>
            <div>
            <?php if(is_array($drive['goods'])): $i = 0; $__LIST__ = $drive['goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$go): $mod = ($i % 2 );++$i;?><div class="item item-body" style="padding-top:0px;margin-top:0px">
                    <p>
                       <?php echo ($go["goodsName"]); ?>
                    </p>
                    <p>
                    <?php if($go['isRecomm'] == 1): ?><span class="jdtag">自驾游览</span><?php endif; ?>
                    <?php if($go['isBest'] == 1): ?><span class="jdtag">有趣</span><?php endif; ?>
                    <?php if($go['isNew'] == 1): ?><span class="jdtag">刺激</span><?php endif; ?>
                        <span class="jdprice">￥<?php echo ($go["adultPrice"]); ?></span></p>
                    <a href="<?php echo U('Mobile/Goods/index',array('goodsId' =>$go['goodsId']));?>"><img src="/<?php echo ($go['goodsImg']); ?>"></a>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <!-- 用户评论 -->
        <div class="list card cardPS usercomment">
            <div class="item">
                <h1>用户评论</h1>
                <span class="commentnum"><?php echo ($drive["apcount"]); ?>条用户评论</span>
                <i class="icon  ion-chevron-up placeholder-icon"></i>
            </div>
            <div>
            <?php if(is_array($drive['ap'])): $i = 0; $__LIST__ = $drive['ap'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ap): $mod = ($i % 2 );++$i;?><div class="item item-body">
                    <p class="commentmsg">
                        <span><?php echo ($ap["userName"]); ?></span>
                        <span class="commentscore"><?php echo ($ap["drivesScore"]); ?>分</span>
                        <span class="commentstarts">
                        <?php $__FOR_START_25281__=0;$__FOR_END_25281__=$ap['drivesScore'];for($i=$__FOR_START_25281__;$i < $__FOR_END_25281__;$i+=1){ ?><i class="iocn ion-star"></i><?php } ?></span>
                    </p>
                    <p class="commenttime">
                        <span><?php echo ($ap["createTime"]); ?></span>
                    </p>
                    <p class="commentcon">
                        <?php echo ($ap["content"]); ?>
                    </p>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="row">
            <div style="width:100%;">
                <a ng-click="drivesBuy()">
                    <button class="button button-block button-calm">立即预定</button>
                </a>
            </div>
        </div>
        <div name="footerme" class="row footermessage " >
            <div >
                <?php echo (htmlspecialchars_decode($CONF["mallFooter"])); ?>
            </div>
        </div>
    </ion-content>
    <script id="map.html" type="text/ng-template">
        <ion-modal-view>
            <ion-header-bar>
                <h1 class="title">详细地图</h1>
                <a class="button" style="background:#ADADAD" ng-click="closeMPopover();">关闭</a>
            </ion-header-bar>
            <ion-content style="with:500px;">
                <ion-view title="Home" hide-nav-bar="true">
                    <ion-scroll zooming="true" direction="xy" style="width: 100%; height: 100%">
                        <div style="width: 1000px; height: 1000px; background: url(/<?php echo ($drive['drivesMap']); ?>) no-repeat"></div>
                    </ion-scroll>
                </ion-view>
            </ion-content>
        </ion-modal-view>
    </script>
    <script id="customDate.html" type="text/ng-template">
        <ion-modal-view>
            <ion-header-bar>
                <h1 class="title">待出发日期</h1>
                <a class="button" style="background:#ADADAD" ng-click="closeGPopover();">关闭</a>
            </ion-header-bar>
            <ion-content>
            <form name="mygoForm" novalidate>
                <div class="card">
                    <div class="item item-input">
                    <span ng-show="mygoForm.goTime.$dirty && mygoForm.goTime.$invalid">
                     <i class="icon ion-android-alert placeholder-icon loginrei" style="display: none;"></i>
                        <i ng-show="mygoForm.goTime.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>&nbsp;&nbsp;&nbsp;
                        <input type="text" placeholder="请输入2016-12-10" ng-model="goTime.goTime" required name="goTime"></input>
                    </div>
                    <div class="item item-input">
                    <span ng-show="mygoForm.goNum.$dirty && mygoForm.goNum.$invalid">
                        <i ng-show="mygoForm.goNum.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                        <i ng-show="mygoForm.goNum.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>&nbsp;&nbsp;&nbsp;
                        <input type="text" placeholder="请输入出发人数" ng-model="goTime.goNum" required name="goNum" ng-pattern="/^[0-9]+$/"></input>
                    </div>
                    <div class="item item-input">
                    <span ng-show="mygoForm.name.$dirty && mygoForm.name.$invalid">
                        <i ng-show="mygoForm.name.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                        <i ng-show="mygoForm.name.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>&nbsp;&nbsp;&nbsp;
                        <input type="text" placeholder="请输入(只能中文)联系人姓名" ng-model="goTime.goName" required name="name" ng-pattern="/[\u4e00-\u9fa5]/"></input>
                    </div>
                    <div class="item item-input">
                   <span ng-show="mygoForm.phone.$dirty && mygoForm.phone.$invalid">
                    <i ng-show="mygoForm.phone.$error.required" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    <i ng-show="mygoForm.phone.$error.pattern" class="icon ion-android-alert placeholder-icon loginrei" style="color: red;"></i>
                    </span>&nbsp;&nbsp;&nbsp;
                        <input type="tel" placeholder="请输入联系人手机号" ng-model="goTime.goPhone" required name="phone" ng-pattern="/^1\d{10}$/"></input>
                    </div>
                    <div class="item item-text-wrap" style="text-align: center; ">
                        <button ng-disabled="mygoForm.$invalid" class="button" style="width:50%;background:#F77462;" ng-click="gotime(goTime)">提交</button>
                    </div>
                </div>
            </form>
            </ion-content>
        </ion-modal-view>
    </script>
    <script id="my-popover.html" type="text/ng-template">
        <ion-modal-view>
            <ion-header-bar>
                <h1 class="title">前往报名</h1>
                <a class="button" style="background:#ADADAD" ng-click="closeDPopover();">关闭</a>
            </ion-header-bar>
            <ion-content>
                <div class="card baoming">
                    <div class="item item-divider" style="text-align: center;">
                        <h1>亲们，可以就近报名哦！</h1>
                    </div>
                    <div class="item item-text-wrap" ng-repeat="go in goplaces">
                        <h1>{{go.placeName}}</h1>
                        <p style="text-align: right;">{{go.placePhone}}</p>
                    </div>
                    <div class="item item-text-wrap" style="text-align: center;">
                        <p>报名时间：周一至周五09:00——17:00</p>
                        <p>如需本部代办签证、请阅读惠享代办签证所需资料</p>
                    </div>
                </div>
            </ion-content>
        </ion-modal-view>
    </script>
    <script id="hotelmsg.html" type="text/ng-template">
        <ion-modal-view>
            <ion-header-bar>
                <h1 class="title">酒店信息</h1>
                <a class="button" style="background:#ADADAD" ng-click="closePopover();">关闭</a>
            </ion-header-bar>
            <ion-content class=" scroll-content has-header hotelmsg" style="    background: #f5f5f5;">
                <div class="row">
                    <div class="col-33">酒&nbsp;店：</div>
                    <div class="col-67">{{hotel.hotelName}}</div>
                </div>
                <div class="row">
                    <div class="col-33">酒店英文：</div>
                    <div class="col-67">{{hotel.hotelEnglishName}}</div>
                </div>
                <div class="row">
                    <div class="col-33">房&nbsp;&nbsp;型：</div>
                    <div class="col-67">{{hotel.hotelType}}</div>
                </div>
                <div class="row">
                    <div class="col-33">地&nbsp;&nbsp;址：</div>
                    <div class="col-67">{{hotel.hotelAddress}}</div>
                </div>
                <div class="row">
                    <div class="col-33">地址英文：</div>
                    <div class="col-67">{{hotel.hotelEnglishAddress}}</div>
                </div>
                <div class="row">
                    <div class="col-33">电&nbsp;&nbsp;话：</div>
                    <div class="col-67">{{hotel.hotelPhone}}</div>
                </div>
                <div class="row">
                    <p style="color:#000;" ng-bind-html="hotel.hotelDesc">
                    </p>
                </div>
                <p class="hotelh4"><b>酒店设施</b></p>
                <div class="row">
                    <div class="col-33">综合设施：</div>
                    <div class="col-67" ng-bind-html="hotel.hotelService"></div>
                </div>
                <div class="row">
                    <div class="col-33">服务项目：</div>
                    <div class="col-67" ng-bind-html="hotel.hotelcomplex"></div>
                </div>
                <div class="row">
                    <div class="col-33">酒店活动：</div>
                    <div class="col-67" ng-bind-html="hotel.hotelActivity"></div>
                </div>
                <div class="row">
                    <div class="col-33">网&nbsp;&nbsp;络：</div>
                    <div class="col-67">{{hotel.hotelnetwork}}</div>
                </div>
                <h4></h4>
                <p class="hotelh4"><b>房型信息</b></p>
                <div class="row">
                    <div class="col-33">客房面积：</div>
                    <div class="col-67">{{hotel.hotelRoomArea}}</div>
                </div>
                <div class="row">
                    <div class="col-33">床铺尺寸：</div>
                    <div class="col-67">{{hotel.hotelBedSize}}</div>
                </div>
                <div class="row">
                    <div class="col-33">客房设施：</div>
                    <div class="col-67" ng-bind-html="hotel.hotelRoomfacilities"></div>
                </div>
                <p class="hotelh4"><b>入住须知</b></p>
                <div class="row">
                    <div class="col-33">&nbsp;停车场：</div>
                    <div class="col-67">{{hotel.hotelpark}}</div>
                </div>
                <div class="row">
                    <div class="col-33">入住时间：</div>
                    <div class="col-67">{{hotel.hotelFromtime}}</div>
                </div>
                <div class="row">
                    <div class="col-33">退房时间：</div>
                    <div class="col-67">{{hotel.hotelTntime}}</div>
                </div>
            </ion-content>
        </ion-modal-view>
    </script>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>

<script type="text/javascript" src="/Public/Mobile/js/jquery.spinner.js"></script>
<script src="/Public/Mobile/js/datePrice.js"></script>
<script src="/Public/Mobile/js/drives.js" type="text/javascript"></script>

</html>