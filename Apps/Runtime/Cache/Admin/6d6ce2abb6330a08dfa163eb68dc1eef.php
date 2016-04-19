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
   function toggleIsShow(t,v){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/coupons/del');?>",{id:v},function(data,textStatus){
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
   }
   function del(id){
	   Plugins.confirm({title:'信息提示',content:'您确定要删除该优惠券吗?',okText:'确定',cancelText:'取消',okFun:function(){
		   Plugins.closeWindow();
		   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
		   $.post("<?php echo U('Admin/coupons/del');?>",{id:id},function(data,textStatus){
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
   <body class='wst-page'>
      <?php if(in_array('yhgl_01',$WST_STAFF['grant'])){ ?>
       <a class="btn btn-success glyphicon glyphicon-plus" href="<?php echo U('Admin/coupons/toView');?>" style='float:right'>新增</a>
      <?php } ?>
       <div class="wst-body"> 
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width="80px">序号</th>
               <th>优惠码</th> 
               <th>优惠价格</th>       
               <th>是否使用</th>
               <th>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['root'])): foreach($Page['root'] as $key=>$vo): ?><tr>
               <td><?php echo ($vo['couponsId']); ?></td>
               <td><?php echo ($vo['couponsCode']); ?></td>
               <td><?php echo ($vo['couponsPrice']); ?></td>
               <td>
               <?php if($vo['isUse'] == 0): ?>否
                 <?php else: ?>
                 是<?php endif; ?>          
               </td>
            
               <td>
                 <?php if(in_array('yhgl_01',$WST_STAFF['grant'])){ ?>
                 <a class="btn btn-default glyphicon glyphicon-pencil" href="<?php echo U('Admin/coupons/toView',array('id'=>$vo['couponsId']));?>">修改</a>&nbsp;
                 <?php } ?>
                 <?php if(in_array('yhgl_01',$WST_STAFF['grant'])){ ?>
                 <a class="btn btn-default glyphicon glyphicon-trash" href="javascript:del(<?php echo ($vo['couponsId']); ?>)">刪除</a>
                 <?php } ?>
               </td>
             </tr><?php endforeach; endif; ?>
             <tr>
                <td colspan='7' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
</html>