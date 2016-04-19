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
      <script src="/Public/plugins/layer/layer.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/vue/js/vue.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <style type="text/css">
    #preview{border:1px solid #cccccc; background:#CCC;color:#fff; padding:5px; display:none; position:absolute;}
    </style>
   </head>
   <body class='wst-page'>
       <div class='wst-body'>
        <div class='wst-tbar'>
        <?php if(in_array('dpjd_01',$WST_STAFF['grant'])){ ?>
        <a class="btn btn-success glyphicon glyphicon-plus" href="<?php echo U('Admin/Hotels/toView');?>" style="float:right">新增</a>
        <?php } ?>
        </div>
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='2'>编号</th>
               <th width='180'>酒店名称</th>
               <th width='25'>酒店类型</th>
               <th width='80'>操作</th>
             </tr>
           </thead>
           <tbody>
           <?php if(is_array($Page['root'])): $i = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td><?php echo ($i); ?></td>
                <td><?php echo ($vo['hotelName']); ?></td>
                <td><?php echo ($vo['hotelType']); ?></td>
                <td>
                <?php if(in_array('dpjd_03',$WST_STAFF['grant'])){ ?>
                 <a class="btn btn-primary glyphicon" href='<?php echo U("Admin/Hotels/toView",array("id"=>$vo["hotelId"]));?>'>修改</a>
                  <?php } ?>
                 <?php if(in_array('dpjd_04',$WST_STAFF['grant'])){ ?>
                 <a class="btn btn-primary glyphicon glyphicon-pencil" onclick="delHotels(<?php echo ($vo['hotelId']); ?>)">删除</a>
                 <?php } ?>
                 </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='10' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
   <script>
   function delHotels(id){
     Plugins.confirm({title:'信息提示',content:'您确定要删除酒店?',okText:'确定',cancelText:'取消',okFun:function(){
       Plugins.closeWindow();
       Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
       $.post("<?php echo U('Admin/Hotels/delHotels');?>",{hotelId:id},function(data,textStatus){
          var json = WST.toJson(data);
          if(json.status=='1'){
            Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
               location.reload();
            }});
          }else{
            Plugins.closeWindow();
            Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
          }
        });
     }});
   }
   </script>
</html>