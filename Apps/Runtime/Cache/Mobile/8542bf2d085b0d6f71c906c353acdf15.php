<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>出境车辆行驶证</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
.div1 {
    border-radius: 2px;
    float: left;
    height: 25px;
    position: relative;
    top: 50px;
    left: 48%;
}
.div2 {
    font-size: 13px;
    line-height: 25px;
    text-align: center;
}
input[type=file] {
    display: block;
}
.inputstyle {
    cursor: pointer;
    font-size: 13px;
    height: 25px;
    left: 0px;
    opacity: 0;
    outline: medium none;
    position: absolute;
    top: 0px;
    width: 45px;
}
</style>

</head>
<body>

<div ng-app="myApp" ng-controller="carCtrl">
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
        <div class="card  insurance">
            <div class="item item-divider" >
            <input type="hidden" id="orderId" value="<?php echo ($row['orderId']); ?>">
                <span>订单号：<span><?php echo ($row["orderNo"]); ?></span></span>
            </div>
            <div class="item item-text-wrap insurancepeo">
                <span><?php echo ($row["adultNum"]); ?></span><span>成人</span>
                <span><?php echo ($row["childNum"]); ?></span><span>儿童</span>
            </div>
            <div class="item item-text-wrap">
                <span>凡在本行程中需要驾驶车辆的人员均提供有效驾驶证信息。用于制作驾驶证标准英文翻译件、翻译件用于在国外发生检查时提供警察查看所用</span>
            </div>
        </div>
        <div class="card">
            <label class="item item-text-wrap ">
                <p style="font-size: 18px;">
                    上传示例<span style="font-size: 13px;"> 一个订单一位联系人即可</span>
                </p>
            </label>
            <div class="item item-text-wrap">
                <h2>驾驶证正本正面</h2>
                <div style="border: 1px solid #f2f2f2;
                min-height: 120px; text-align: center;vertical-align:middle;">
                   <iframe name="upload" style="display:none"></iframe>
                    <form id="uploadform_Filedata" autocomplete="off"  enctype="multipart/form-data" method="POST" target="upload" action="<?php echo U('Home/Base/uploadPic');?>" >
                        <div style="position:relative;">
                        <input id="carzImg" type="hidden"/>
                        <div class="div1">
                            <div class="div2"><span style="font-size: 30px">+</span></div>
                            <input type="file" class="inputstyle" id="Filedata" name="Filedata" onchange="updfile('Filedata');" >
                        </div>
                        <div style="clear:both;"></div>
                        <input type="hidden" name="dir" value="carLicense">
                        <input type="hidden" name="width" value="416">
                        <input  type="hidden" name="height" value="264" />
                        <input type="hidden" name="folder" value="Filedata">
                        <input type="hidden" name="sfilename" value="Filedata">
                        <input type="hidden" name="fname" value="carzImg">
                        <input type="hidden" id="s_Filedata" name="s_Filedata" value="">
                        </div>
                </form>
                </div>
            </div>
            <div class="item item-text-wrap">
                <h2>驾驶证正本反面</h2>
                <div style="border: 1px solid #f2f2f2;
                min-height: 120px; text-align: center;vertical-align:middle;">
                    <form id="uploadform_CarF" autocomplete="off" enctype="multipart/form-data" method="POST" target="upload" action="<?php echo U('Home/Base/uploadPic');?>" >
                        <div style="position:relative;">
                        <input id="carfImg" type="hidden"/>
                        <div class="div1">
                            <div class="div2"><span style="font-size: 30px">+</span></div>
                            <input type="file" class="inputstyle" id="CarF" name="CarF" onchange="updfile('CarF');" >
                        </div>
                        <div style="clear:both;"></div>
                        <input type="hidden" name="dir" value="">
                        <input type="hidden" name="width" value="416">
                        <input  type="hidden" name="height" value="216" />
                        <input type="hidden" name="folder" value="Filedata">
                        <input type="hidden" name="sfilename" value="CarData">
                        <input type="hidden" name="fname" value="carfImg">
                        <input type="hidden" id="s_Filedata" name="s_Filedata" value="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <label class="item item-text-wrap ">
                <p style="font-size: 18px;">
                    <span style="font-size: 80%"> 驾驶证需在有效期、亲保证照片清晰</span>
                </p>
            </label>
             <div class="item item-text-wrap">
                <h2>驾驶证正本正面</h2>
                <br/>
                <div id="preview_Filedata">
                    <img src="/Public/Mobile/img/car1.png" alt="" width="100%">
                </div>
            </div>
             <div class="item item-text-wrap">
                <h2>驾驶证正本反面</h2>
                <br/>
                <div id="preview_CarData">
                    <img src="/Public/Mobile/img/car2.png" alt="" width="100%">
                </div>
            </div>
        </div>

        <div class="row">
            <div style="width:100%;">
                <a ng-click="carLic()">
                    <button class="button button-block" style="background:#F77462;color:#fff;">提交资料</button>
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
    var ThinkPHP = window.Think = {
        "ROOT"   : ""
    }
    var filetypes = ["gif","jpg","png","jpeg"];
</script>
<script src="/Public/Mobile/js/upload.js"></script>

</html>