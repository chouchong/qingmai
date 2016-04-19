<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ($CONF['mallTitle']); ?>后台管理中心</title>
    <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
    <script src="/Public/js/html5shiv.min.js"></script>
    <script src="/Public/js/respond.min.js"></script>
    <![endif]-->
    <script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Public/plugins/plugins/plugins.js"></script>
</head>
<body class='wst-page'>
<div class='wst-tbar' style='text-align:right;height:25px;'>
    <a class="btn btn-success glyphicon glyphicon-plus" href='<?php echo U("Admin/Weixin/addMenu");?>' style='float:right'>新增</a>
</div>
<div class="wst-body">
    <table class="table table-hover table-striped table-bordered wst-list">
        <thead>
        <tr>
            <th width='40'>ID</th>
            <th width='120'>显示名称</th>
            <th>网址</th>
            <th width='120'>类型</th>
            <th width='300'>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($key+1); ?></td>
            <td><?php if($vo["leftpin"] != 0): echo ($vo["lefthtml"]); endif; echo ($vo["we_menu_name"]); ?></td>
            <td><?php echo ($vo["we_menu_typeval"]); ?></td>
            <td>
                <?php if(($vo['we_menu_type'] == 1)): ?>URL菜单链接
                <?php else: ?>关键词回复菜单<?php endif; ?>
            </td>
            <td>
                <a class="btn btn-default glyphicon glyphicon-pencil" href='<?php echo U("Admin/Weixin/addMenu",array("id"=>$vo["id"]));?>'>修改&nbsp;</a>
                <a class="btn btn-default glyphicon glyphicon-trash" onclick="del(<?php echo ($vo["id"]); ?>)">刪除</a>
            </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <div><button><a href='<?php echo U("Admin/Wechat/createMenu");?>'>生成微信菜单</a></button></div>
</div>
</body>
<script>
    function del(id){
        var r=confirm("你确定要删除吗？")
        if (r==true){
            $.ajax({
                url:'<?php echo U("Admin/Weixin/delMenu");?>',// 跳转到 action
                data:{'id':id},
                type:"POST",
                dataType:"json",
                success:function(data){
                    if(data.ok>0){
                        window.location.href='<?php echo U("Admin/Weixin/menuList");?>';
                    }
                }
            });
        }
    }
</script>
</html>