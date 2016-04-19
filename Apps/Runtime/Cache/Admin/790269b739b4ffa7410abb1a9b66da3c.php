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
   <script>
   </script>
   <body class='wst-page'>
     <form method='post' action="<?php echo U('Admin/DrivesAppraises/index');?>">
       <div class='wst-tbar' style='height:25px;'>
        自驾：<input type='text' name='drivesName' id='drivesName' value='<?php echo ($drivesName); ?>'/>
      <button type='submit' class='btn btn-primary glyphicon glyphicon-search'>查询</button>
       </div>
       </form>
       <div class="wst-body">
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='40'>序号</th>
               <th colspan='2'>自驾</th>
               <th width='60'>状态</th>
               <th>自驾评分</th>
               <th width='150'>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['root'])): $i = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
               <td rowspan='2'><?php echo ($i); ?></td>
               <td rowspan='2' width='50' style='border-right:0px;'>
               <img src="/<?php echo ($vo['drivesImg']); ?>" width='50'/>
               </td>
               <td rowspan='2' width='140' style='border-left:0px;'>
               <span style='font-weight:bold;'><?php echo ($vo['drivesName']); ?></span><br/>订单：<?php echo ($vo['orderNo']); ?></td>
               <td >
               <?php if($vo['isShow'] == 1 ): ?><span class='label label-success'>显示</span>
               <?php else: ?>
               <span class='label label-warning'>隐藏</span><?php endif; ?>
               </td>
               <td>
               <div>
                  <?php $__FOR_START_22302__=0;$__FOR_END_22302__=$vo['drivesScore'];for($i=$__FOR_START_22302__;$i < $__FOR_END_22302__;$i+=1){ ?><img src="/Apps/Admin/View/img/icon_score_yes.png"/><?php } ?>&nbsp;<?php echo ($vo['drivesScore']); ?> 分
                </div>
                </td>
               <td>
               <?php if(in_array('dppl_02',$WST_STAFF['grant'])){ ?>
               <button type="button" class="btn btn-default glyphicon glyphicon-trash" onclick="javascript:del(<?php echo ($vo['id']); ?>)">刪除</button>
               <?php } ?>
               </td>
             </tr>
             <tr>
               <td colspan='4' style='word-break:break-all;'>评价[<?php echo ($vo['userName']); ?>]：<?php echo ($vo['content']); ?></td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='8' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
   <script>
   function del(id){
     Plugins.confirm({title:'信息提示',content:'您确定要删除该自驾评价吗?',okText:'确定',cancelText:'取消',okFun:function(){
       Plugins.closeWindow();
       Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
       $.post("<?php echo U('Admin/GoodsAppraises/del');?>",{id:id},function(data,textStatus){
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