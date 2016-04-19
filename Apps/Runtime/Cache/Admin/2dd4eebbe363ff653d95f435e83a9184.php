<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>微信-后台管理中心</title>
    <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="/Apps/Admin/View/css/upload.css" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
    <script src="/Public/js/html5shiv.min.js"></script>
    <script src="/Public/js/respond.min.js"></script>
    <![endif]-->
    <script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class='container-fluid'>
    <div class='tabbable tabs-left'>
        <ul class='nav nav-tabs'>
            <li class='active'><a href='#tab1' data-toggle='tab'>公众号设置</a></li>
        </ul>
        <div class='tab-content'>
            <div class='tab-pane active' id='tab1'>
                <form name="myform" method="post" id="myform" action="<?php echo U('Admin/weixin/toSet');?>">
                    <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
                <table class="table table-hover table-striped table-bordered wst-form">
                    <tr>
                        <th width="150">公众号：</th>
                        <td>
                            <input class="form-control wst-ipt" id="weixinname" name="wxname" value="<?php echo ($data["name"]); ?>" type="text">                                       </td>
                        </td>
                    </tr>
                    <tr>
                        <th width="150">token：</th>
                        <td>
                            <input  class="form-control wst-ipt" id="token" name="token" value="<?php echo ($data["token"]); ?>" type="text">                                       </td>
                        </td>
                    </tr>
                    <tr>
                        <th width="150">APPID：</th>
                        <td>
                            <input class="form-control wst-ipt" id="APPID" name="APPID" value="<?php echo ($data["appid"]); ?>" type="text">                                       </td>
                        </td>
                    </tr>
                    <tr>
                        <th width="150">APPSECRET：</th>
                        <td>
                            <input class="form-control wst-ipt" id="APPSECRET" name="APPSECRET" value="<?php echo ($data["appsecret"]); ?>" type="text">                                       </td>
                        </td>
                    </tr>
                    <td style='padding-left:250px;' colspan='2'>
                        <button type="submit" class="btn btn-primary">保&nbsp;存</button>
                        <button type="reset" class="btn btn-primary">重&nbsp;置</button>
                    </td>
                </table>
                </form>
            </div>
        </div>
    </div>

</div>
</body>
</html>