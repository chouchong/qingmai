<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">

<title>出境车辆行驶证</title>

<link href="/Public/Mobile/lib/ionic/css/ionic.css" rel="stylesheet">
<link href="/Public/Mobile/css/custom.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
.a-upload {
    padding: 4px 10px;
    height: 40px;
    line-height: 20px;
    position: relative;
    cursor: pointer;
    color: #888;
    background: #fafafa;
    border: 1px solid #ddd;
    border-radius: 4px;
    overflow: hidden;
    display: inline-block;
    *display: inline;
    *zoom: 1
}

.a-upload input {
    position: absolute;
    font-size: 100px;
    right: 0;
    top: 0;
    opacity: 0;
    filter: alpha(opacity=0);
    cursor: pointer
}
.a-upload:hover {
    color: #444;
    background: #eee;
    border-color: #ccc;
    text-decoration: none
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
                <input type="hidden" id="len" value="<?php echo ceil($row[adultNum]/3); ?>"><br/>
                <span>需上传 <b><?php echo ceil($row[adultNum]/3); ?></b> 份驾驶证</span>
            </div>
            <div class="item item-text-wrap">
                <span>凡在本行程中需要驾驶车辆的人员均提供有效驾驶证信息。用于制作驾驶证标准英文翻译件、翻译件用于在国外发生检查时提供警察查看所用</span>
            </div>
        </div>
        <div class="card">
            <label class="item item-text-wrap ">
                <p style="font-size: 18px;">
                    上传示例<p style="font-size: 13px;"> 一个订单一位联系人即可，三个成人需上传一份驾驶证，含正反面，以此类推</p>
                </p>
            </label>
            <div class="item item-text-wrap">
                <h2>驾驶证正本正面</h2>
                <div style="border: 1px solid #f2f2f2;
                min-height: 120px; text-align: center;vertical-align:middle;">
                    <?php $__FOR_START_24653__=0;$__FOR_END_24653__=ceil($row[adultNum]/3);for($i=$__FOR_START_24653__;$i < $__FOR_END_24653__;$i+=1){ ?><iframe name="upload" style="display:none"></iframe>
                        <form id="uploadform_Z<?php echo ($i); ?>" autocomplete="off" enctype="multipart/form-data"  target="upload" method="POST" action="<?php echo U('Home/Base/uploadPics');?>" >
                                <div class="div" style="padding: 10px">
                                   <a href="javascript:;" class="a-upload">
                                       <input  type="file" class="inputstyleZ<?php echo ($i); ?>" id="inputstyle1" name="Filedata" onchange="updfiles(<?php echo ($i); ?>,'Z');">
                                       <span style="font-size: 15px;float: left;padding-top:6px;">上传第<?php echo ($i+1); ?>份正面图片</span>
                                       <span style="font-size: 30px;float: left;padding-top:6px">+</span>
                                   </a>
                                   <input type="hidden" name="type" value="Z">
                                   <input type="hidden" name="len" value="<?php echo ($i); ?>">
                                   <input type="hidden" class="picZ" id="picZ<?php echo ($i); ?>" name="picZ">
                                </div>
                         </form><?php } ?>
                </div>
            </div>
            <div class="item item-text-wrap">
                <h2>驾驶证正本反面</h2>
                <div style="border: 1px solid #f2f2f2;
                min-height: 120px; text-align: center;vertical-align:middle;">
                    <?php $__FOR_START_25574__=0;$__FOR_END_25574__=ceil($row[adultNum]/3);for($i=$__FOR_START_25574__;$i < $__FOR_END_25574__;$i+=1){ ?><iframe name="upload" style="display:none"></iframe>
                        <form id="uploadform_F<?php echo ($i); ?>" autocomplete="off" enctype="multipart/form-data"  target="upload" method="POST" action="<?php echo U('Home/Base/uploadPics');?>" >
                                <div class="div" style="padding: 10px">
                                   <a href="javascript:;" class="a-upload" style="position:relative ">
                                       <input type="file" class="inputstyleF<?php echo ($i); ?>" name="Filedata" onchange="updfiles(<?php echo ($i); ?>,'F');">
                                        <span style="font-size: 15px;float: left;padding-top:6px;">上传第<?php echo ($i+1); ?>份反面图片</span>
                                       <span style="font-size: 30px;float: left;padding-top:6px">+</span>
                                   </a>
                                   <input type="hidden" name="type" value="F">
                                   <input type="hidden" name="len" value="<?php echo ($i); ?>">
                                   <input type="hidden" class="picF" id="picF<?php echo ($i); ?>" name="picF">
                                </div>
                         </form><?php } ?>
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
                <div id="preview_Z0">
                    <img src="/Public/Mobile/img/car1.png" alt="" width="100%">
                </div>
                 <?php $__FOR_START_18642__=0;$__FOR_END_18642__=ceil($row[adultNum]/3);for($i=$__FOR_START_18642__;$i < $__FOR_END_18642__;$i+=1){ ?><div id="preview_Z<?php echo ($i); ?>">
                     </div><?php } ?>
            </div>
             <div class="item item-text-wrap">
                <h2>驾驶证正本反面</h2>
                <br/>
                <div id="preview_F0">
                    <img src="/Public/Mobile/img/car2.png" alt="" width="100%">
                </div>
              <?php $__FOR_START_9624__=0;$__FOR_END_9624__=ceil($row[adultNum]/3);for($i=$__FOR_START_9624__;$i < $__FOR_END_9624__;$i+=1){ ?><div id="preview_F<?php echo ($i); ?>">
                     </div><?php } ?>
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
</script>
<script src="/Public/Mobile/js/upload.js"></script>

</html>