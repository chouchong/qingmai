<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['mallTitle']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/Apps/Admin/View/css/AdminLTE.css">
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script>
      function enterLicense(){
    	  location.href="<?php echo U('Admin/Index/enterLicense');?>";
      }
      $(function () {
	      WST.getWSTMAllVersion("<?php echo U('Admin/Index/getWSTMallVersion');?>");
      });
      </script>
   </head>
   <body>
      <div class='panel wst-panel-full'>
         <div class="col-xs-12 wstmall-login-tips">
             <p style='font-size:16px;'>您好，<?php echo session('WST_STAFF.staffName');?>，欢迎使用Mall商城管理。 您上次登录的时间是 <?php echo session('WST_STAFF.lastTime');?> ，IP 是 <?php echo session('WST_STAFF.lastIP');?></p>
         </div>
         <div class='row' style='padding-left:10px;margin-right:10px;'>
	         <div class="col-md-9">
	           <div class="box-header">
	             <h4 class="text-blue">一周动态</h4>
	             <table class="table table-hover table-striped table-bordered wst-form">
	                <tr>
	                   <td width="20%" align='right'>新增会员数：</td>
	                   <td width="30%"><?php echo ($weekInfo["userNew"]); ?></td>
	                </tr>
	                <tr>
	                   <td align='right'>新增订单数：</td>
	                   <td><?php echo ($weekInfo["ordersNew"]); ?></td>
	                </tr>
	             </table>
	           </div>
	           <div class="box-header">
	             <h4 class="text-blue">统计信息</h4>
	             <table class="table table-hover table-striped table-bordered wst-form">
	                <tr>
	                   <td width="20%" align='right'>会员总数：</td>
	                   <td width="30%"><?php echo ($sumInfo["userSum"]); ?></td>
	                </tr>
	                <tr>
	                   <td align='right'>订单总数：</td>
	                   <td><?php echo ($sumInfo["ordersSum"]); ?></td>
	                </tr>
	                <tr>
	                   <td width="200" align='right'>订单总金额</td>
	                   <td width="300" colspan='3'><?php echo ($sumInfo["moneySum"]); ?></td>
	                </tr>
	             </table>
	           </div>
	           <div class="box-header">
	           </div>
	        </div>
	        <div class="col-md-3">
	           <div class="box-header" style='margin-bottom:30px;'>
	             <h4 class='wstmall-intro'>走进我们</h4>
	             <div><a style='color:#000000' href="<?php echo C('WST_WEB');?>" target='_blank'><?php echo C('WST_WEB');?></a></div>
	           </div>
	           <div class="box-header" style='margin-bottom:30px;'>
	             <h4 class='wstmall-intro'>臭虫科技开发团队</h4>
	             <div>臭虫Team</div>
	           </div>
	           <div class="box-header" style='margin-bottom:30px;'>
	             <h4 class='wstmall-intro'>我们的理念</h4>
	             <div>我们愿与更多中小企业一起努力，一起成功! <br/>We Success together!</div>
	           </div>
	           <div class="box-header">
	             <h4 class='wstmall-intro'>商城定制</h4>
	             <div>电话：0871-65629528</div>
	             <div style='padding-left:5px;'>QQ：772947665</div>
	           </div>
	        </div>
	      </div>  
      </div>
   </body>
</html>