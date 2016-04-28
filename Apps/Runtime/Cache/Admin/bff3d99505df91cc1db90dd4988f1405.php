<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['shopTitle']['fieldValue']); ?>后台管理中心</title>
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
      <form method="post" action='<?php echo U("Admin/Orders/index");?>'>

       <div class='wst-tbar'>
       订单号：<input type='text' name='orderNo' id='orderNo'/>
订单类型查询:<select name='goodsType' id='goodsType'>
             <option value='-9999'>请选择</option>
             <option value='1'>自驾游</option>
             <option value='2'>门票</option>
             <option value='3'>签证</option>
           </select>
  订单状态:<select name='orderStatus' id='orderStatus'>
             <option value='-9999'>请选择</option>
             <option value='0'>待付款</option>
             <option value='1'>待出发</option>
             <option value='2'>待评论</option>
             <option value='3'>已完成</option>
           </select>
       <button type="submit" class="btn btn-primary glyphicon glyphicon-search">查询</button> 
       </div>
       </form>
       <div class="wst-body"> 
         <table class="table table-hover table-striped table-bordered wst-list">
            <thead>
             <tr>
               <th width='2'>编号</th>
               <th width='25'>订单号</th>
               <th width='25'>用户</th>
               <th width='25'>订单类型</th>
               <th width='25'>订单金额</th>
               <th width='30'>支付类型</th>
               <th width='20'>下单时间</th>
               <th width='20'>订单状态</th>
               <th width='60'>详情</th>
             </tr>
           </thead> 
           <tbody>
                 <?php if(is_array($page['root'])): $i = 0; $__LIST__ = $page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="detailModel">
                      <td><?php echo ($i); ?></td>
                      <td><?php echo ($vo["orderNo"]); ?></td>
                      <td><?php echo ($vo["userName"]); ?></td>
                      <td><?php if($vo["goodsType"] == 1): ?>自驾游<?php endif; ?>
                          <?php if($vo["goodsType"] == 2): ?>门票<?php endif; ?>
                          <?php if($vo["goodsType"] == 3): ?>签证<?php endif; ?>
                      </td>
                      <td><?php if($vo["totalMoney"] > 0): echo ($vo["totalMoney"]); ?>元<?php endif; ?></td>
                      <td><?php if($vo["payType"] != ''): echo ($vo["payType"]); endif; ?></td>
                      <td><?php echo ($vo["createTime"]); ?></td>
                      <td><?php if($vo["orderStatus"] == 0): ?>待付款<?php endif; ?>
                          <?php if($vo["orderStatus"] == 1): ?>待出发<?php endif; ?>
                          <?php if($vo["goodsType"] == 1): if($vo["orderStatus"] == 2): ?>待评论<?php endif; endif; ?>
                          <?php if($vo["orderStatus"] == 3): ?>已完成<?php endif; ?>
                      </td>
                      <td><button class="btn btn-primary" onclick="getdetail(<?php echo ($vo[orderId]); ?>)">订单详情</button>
                     <?php if($vo["goodsType"] == 1): if($vo["orderStatus"] > 1): ?><button class="btn btn-primary" onclick="getCar(<?php echo ($vo[orderId]); ?>)">驾驶证</button> <button class="btn btn-primary" onclick="getinsureds(<?php echo ($vo[orderId]); ?>)">被保险人</button></td><?php endif; endif; ?>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
           </tbody>
             <tr>
                <td colspan='15' align='center'><?php echo ($page['pager']); ?></td>
             </tr>
          
        </table>
       </div>
       <!-- 驾驶证照片模态框 -->
       <div class="modal fade" id="getcar" tabindex="-1" role="dialog" aria-labelledby="drivesTimePriceLabel">
        <div class="modal-dialog" role="document" style="margin-left: 20%">
          <div class="modal-content" style="width: 1000px">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="drivesTimePriceLabel" style="text-align: center;">驾驶证正反面照片</h4>
            </div>
            <div class="modal-body">
              <div class="row">
               <div id="carzImg"></div>
               <div id="carfImg"></div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
          </div>
          </div>
        </div>
      <!-- 被保险人信息模态框 -->
       <div class="modal fade" id="getinsureds" tabindex="-1" role="dialog" aria-labelledby="drivesTimePriceLabel">
        <div class="modal-dialog" role="document" style="margin-left: 20%">
          <div class="modal-content" style="width:800px">
            
              <h4 class="modal-title" id="drivesTimePriceLabel"  style="margin-left: 42%;margin-top:5px">被保险人详情</h4>
          
            <div class="modal-body">
              <div class="row">
              <table class="table table-hover insuredsTb">
              </table>
              </div>
            </div>
              <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left: 92%;margin-bottom: 10px">关闭</button>
          </div>
        </div>
      </div>
   <!-- 订单详情模态框 -->
       <div class="modal fade" id="getdetail" tabindex="-1" role="dialog" aria-labelledby="drivesTimePriceLabel">
        <div class="modal-dialog" role="document" style="margin-left: 20%">
          <div class="modal-content" style="width: 1000px">
              <h4 class="modal-title" id="drivesTimePriceLabel" style="margin-left: 45%;margin-top: 10px">订单详情</h4>
            <div class="modal-body">
              <table class="table table-hover detailModelTb">
              </table>
            </div>
              <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left: 94%;margin-bottom: 10px">关闭</button>
          </div>
        </div>
      </div>
    <script type="text/javascript">
    // 驾驶证照片模态框弹出显示
      function getCar(orderId){
        $('#getcar').modal('show');
        $.ajax({
          url: "<?php echo U('Admin/Orders/getCarPic');?>",
          type: "POST",
          async:false,
          data:{orderId:orderId},
          success: function(data){
           var zarr=[];
               zarr=data[0]["carzImg"].split(",");
           var farr=[];
               farr=data[0]["carfImg"].split(",");
           var carImg=[];    
           for (var i = 0; i < zarr.length; i++) {
            carImg=carImg.concat('<h4 class="modal-title" id="drivesTimePriceLabel">&nbsp;第'+(i+1)+'份驾驶证</h4>&nbsp;&nbsp;<img width="46%" height="240" src="/'+zarr[i]+'"/>&nbsp;&nbsp;<img width="46%" height="240" src="/'+farr[i]+'"/>');
           }
           $("#carzImg").html(carImg);
          } ,
          error: function(){
            Plugins.Tips({title:'信息提示',icon:'error',content:'驾驶证照片加载失败!',timeout:2000});
          }
        });
     }
     // 被保险人信息模态框弹出显示
     function getinsureds(orderId){
        $('#getinsureds').modal('show');
        $.ajax({
          url: "<?php echo U('Admin/Orders/getInsureds');?>",
          type: "POST",
          async:false,
          data:{orderId:orderId},
          success: function(data){
          var insuredshtml=[];
          for (var i = 0; i < data.length; i++) {
            var _inhtml = '<tr><td colspan="2"><h4>第'+(i+1)+'个被保险人信息</h4></td></tr><tr><td>被保险人姓名：</td><td>'+data[i]['userName']+'</td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;性别：</td><td>';
            if(data[i]['sex']==1){
              _inhtml+='男';
            }
            if(data[i]['sex']==2){
              _inhtml+='女';
            }
            _inhtml+='</td></tr><tr><td>&nbsp;&nbsp;保险号码：</td><td>'+data[i]['userCard']+'</td></tr>';
            insuredshtml=insuredshtml.concat(_inhtml);
          }
          $(".insuredsTb").html(insuredshtml);
          },
          error: function(){
             Plugins.Tips({title:'信息提示',icon:'error',content:'被保险人信息加载失败!',timeout:2000});
          }
        });
      }
     // 订单详情模态框弹出显示
     function getdetail(orderId){
       $('#getdetail').modal('show');
       $.ajax({
          url: "<?php echo U('Admin/Orders/getDetailModel');?>",
          type: "POST",
          async:false,
          data:{orderId:orderId},
          success: function(data){
           var html = "<tr><td>&nbsp;订单号：</td><td>"+data[0]['orderNo']+"</td></tr>";
           if(data[0]['totalMoney']>0){
            html +='<tr><td>&nbsp;总金额：</td><td>¥ '+data[0]['totalMoney']+'元</td></tr>'
           }
           if(data[0]['zMoney']>0){
            html +='<tr><td>优惠金额：</td><td>¥ '+data[0]['zMoney']+'元</td></tr>'
           }
            html+='<tr><td>&nbsp;&nbsp;成人：</td><td>'+data[0]['adultNum']+'人'+'&nbsp;x&nbsp;'+data[0]['adultPrice']+'元/人'+'</td></tr>';
           if(data[0]['childNum']>0){
            html+='<tr><td>&nbsp;&nbsp;儿童：</td><td>'+data[0]['childNum']+'人'+'&nbsp;x&nbsp;'+data[0]['childPrice']+'元/人'+'</td></tr>';
           }
           if(data[0]['roomNum']>0){
            html+='<tr><td>&nbsp;用房数：</td><td>'+data[0]['roomNum']+' 间标准双床房</td></tr>';
           }
           if(data[0]['roomNum']>0){
            html+='<tr><td>&nbsp;单房差：</td><td>¥ '+((data[0]['roomNum']*2-data[0]['adultNum']))*data[0]['roomPrice']+'元'+'</td></tr>';
           }
           if(data[0]['toTime']!=''){
             html+='<tr><td>出发时间：</td><td>'+data[0]['toTime']+'</td></tr>';
           }
          if(data[0]['endTime']!=''){
            html+='tr><td>结束时间：</td><td>'+data[0]['endTime']+'</td></tr>';
          }
           $(".detailModelTb").html(html);
          } ,
          error: function(){
            Plugins.Tips({title:'信息提示',icon:'error',content:'订单详情加载失败!',timeout:2000});
          }
        });
      }
    </script>
   </body>
</html>