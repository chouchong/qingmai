<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title><?php echo ($CONF['mallTitle']); ?></title>
<meta name="keywords" content="<?php echo ($CONF['mallKeywords']); ?>" />
<meta name="description" content="<?php echo ($CONF['mallDesc']); ?>" />

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>

<div ng-app="myApp"  ng-controller="Ixctrl">
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
    <ion-content overflow-scroll="false" id="content-index"class="scroll-content has-header " >
    <!-- 首图 -->
        <div>
             <?php if(is_array($Ads)): $i = 0; $__LIST__ = $Ads;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div>
                <img src="/<?php echo ($item['adFile']); ?>" alt="" width="100%">
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <!-- 前言 -->
        <div class="row " style="background: #f5f5f5; padding: 9px;font-size: 15px;">
            <p style="color:#9D9D9D;">自在旅行团队深耕目的地、打掉不必要的中间环节、我们拼尽全力只为带给您最佳的体验、以下产品也许您用尽全力DIY及挥汗攻略后所不能企及、性价比极高、售完即止、请注意开售时间！</p>
        </div>
        <!-- 自驾游列表 -->
        <ion-list class="zjylist" type="list-inset" >
            <?php if(is_array($object)): $i = 0; $__LIST__ = $object;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><ion-item class="zjy" >
                <a href="<?php echo U('Mobile/Drives/index',array('drivesId'=>$item['drivesId']));?>">
                    <img src="/<?php echo ($item['drivesImg']); ?>"  width="100%">
                    <div class="row">
                        <div class="col col-67 ionstar">
                        <?php echo (htmlspecialchars_decode($item["drivesDesc"])); ?>
                        </div>
                        <div class="col col-33 price" >
                            <p>
                                <?php if(empty($item["tp"])): ?><span style="color:#F77766; "><?php echo ($item['adultPrice']); ?>&nbsp;元/人</span>
                                <?php else: ?>
                                <span style="color:#F77766; "><?php echo ($item['tp']['adultPrice']); ?>&nbsp;元/人</span><?php endif; ?>
                            </p>
                        </div>
                    </div>
                </a>
            </ion-item><?php endforeach; endif; else: echo "" ;endif; ?>
        </ion-list>
        <!-- 旅行寄语 -->
        <fieldset style="padding:10px 20px;">
            <legend class="" style="font-size: 20px;text-align: center;border: none;width:100px;">旅行寄语</legend>
            <p>人的一生，必须有一次是为追梦而走的自驾旅途！用车轮和眼睛去发现途中始料不及的没，一路翻山越岭，看青山滴翠、赏蓝天白云、或思绪海阔天空，或体验异域风情，这段旅途是用来怀念的！</p>
        </fieldset>
        <!-- 选择我们 -->
        <div class="row" style="text-align: center;">
            <div class="col col-33">
                <hr>
            </div>
            <div class="col col-33" style="font-size: 80%;"> 为什么选择我们 </div>
            <div class="col col-33">
                <hr>
            </div>
        </div>
        <div class="row selectus" >
            <div class="col col-33" style=" ">
                <img src="/Public/Mobile/img/pic_1.png" alt="">
                <h5>自由行<br/>有保障</h5>
                <p>自由行不是去拼命，专业团队是你的后盾，让你顺畅游走天地间。</p>
            </div>
            <div class="col col-33" style="    padding: 10px;">
                <img src="/Public/Mobile/img/pic_2.png" alt="">
                <h5>旅游<br/>省心</h5>
                <p>机票、酒店、签证、攻略、目的地安排，一站式为你搞定。</p>
            </div>
            <div class="col col-33" style="    padding: 10px;">
                <img src="/Public/Mobile/img/pic_3.png" alt="">
                <h5>旅游需要<br/>升级</h5>
                <p>几国观光游，还是要和目的地进行深度对话。</p>
            </div>
        </div>
        <div class="row contents" >
            <div class="col col-33" >
                <div class="contentsdiv" >
                    <a href="" class=" " >为什么选择<br/>发现旅行</a>
                </div>
            </div>
            <div class="col col-33" >
                <div class="contentsdiv" >
                    <a href="" class=" " >常见问题<br/>与答案</a>
                </div>
            </div>
            <div class="col col-33" >
                <div class="contentsdiv" >
                    <a href="" class="oneline" >合作信息</a>
                </div>
            </div>
        </div>
        <div class="row contents" >
            <div class="col col-33" >
                <div class="contentsdiv" >
                    <a href="" class="oneline" >公司信息</a>
                </div>
            </div>
            <div class="col col-33" >
                <div class="contentsdiv" >
                    <a href="" class="oneline" >联系我们</a>
                </div>
            </div>
            <div class="col col-33" >
                <div class="contentsdiv" >
                    <a href="" class="oneline" >加入我们</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col col-50" style="    padding: 10px;">
                <img src="/Public/Mobile/img/erweima.png" alt="" width="100%">
            </div>
            <div class="col col-50" style="    padding: 10px;">
                <p>关注微信号 fanxianlvxing</p>
                <p>也可以长按二维码保存图片</p>
                <p>在微信“扫一扫”中打开图片关注</p>
            </div>
        </div>
        <div class="row" style="text-align: center;">
            <div class="col col-33">
                <hr>
            </div>
            <div class="col col-33" style="font-size: 80%;"> 为什么关注微信 </div>
            <div class="col col-33">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col col-20" style="text-align: right;">
                <img src="/Public/Mobile/img/gou.png" alt="" width="">
            </div>
            <div class="col col-80">
                <p>特色管家服务借助微信公众号和您形成互通</p>
            </div>
        </div>
        <div class="row">
            <div class="col col-20" style="text-align: right;">
                <img src="/Public/Mobile/img/gou.png" alt="" width="">
            </div>
            <div class="col col-80">
                <p>查看订单状态？预定特色项目？出行前各种疑问？</p>
            </div>
        </div>
        <div class="row">
            <div class="col col-20" style="text-align: right;">
                <img src="/Public/Mobile/img/gou.png" alt="" width="">
            </div>
            <div class="col col-80">
                <p>贴心行程、目的地突发状况反馈或给我们小红花</p>
            </div>
        </div>
        <div class="row" style="background:#F5F5F5;font-size: 14px;line-height: 120%;">
            <div style="text-align: center;    width: 100%;padding:5%;">
                <?php echo (htmlspecialchars_decode($CONF["mallFooter"])); ?>
            </div>
        </div>
    </ion-content>
</div>

</body>
<script src="/Public/Mobile/lib/ionic/js/ionic.bundle.min.js"></script>
<script src="/Public/Mobile/js/jquery-1.8.0.min.js"></script>
<script src="/Public/Mobile/js/app.js" type="text/javascript"></script>
<script src="/Public/Mobile/lib/ionic/js/ionic-ratings.js"></script>


</html>