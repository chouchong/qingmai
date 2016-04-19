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
   <script>
   function changeStatus(id,v){
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Goods/changeGoodsStatus');?>",{id:id,status:v},function(data,textStatus){
				var json = WST.toJson(data);
				if(json.status=='1'){
					Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
					    location.reload();
					}});
				}else{
					Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
				}
	   });
   }
   function batchBest(v){
	   var ids = [];
	   $('.chk').each(function(){
		   if($(this).prop('checked'))ids.push($(this).val());
	   })
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Goods/changeBestStatus');?>",{id:ids.join(','),status:v},function(data,textStatus){
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
   function batchRecom(v){
	   var ids = [];
	   $('.chk').each(function(){
		   if($(this).prop('checked'))ids.push($(this).val());
	   })
	   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
	   $.post("<?php echo U('Admin/Goods/changeRecomStatus');?>",{id:ids.join(','),status:v},function(data,textStatus){
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
   function checkAll(v){
	   $('.chk').each(function(){
		   $(this).prop('checked',v);
	   })
   }
   $.fn.imagePreview = function(options){
		var defaults = {}; 
		var opts = $.extend(defaults, options);
		var t = this;
		xOffset = 5;
		yOffset = 20;
		if(!$('#preview')[0])$("body").append("<div id='preview'><img width='200' src=''/></div>");
		$(this).hover(function(e){
			   $('#preview img').attr('src',"/"+$(this).attr('img'));      
			   $("#preview").css("top",(e.pageY - xOffset) + "px").css("left",(e.pageX + yOffset) + "px").show();      
		  },
		  function(){
			$("#preview").hide();
		}); 
		$(this).mousemove(function(e){
			   $("#preview").css("top",(e.pageY - xOffset) + "px").css("left",(e.pageX + yOffset) + "px");
		});
	}
   function getCatListForEdit(objId,parentId,t,id){
     var params = {};
     params.id = parentId;
     $('#'+objId).empty();
     if(t<1){
       $('#goodsCatId3').empty();
       $('#goodsCatId3').html('<option value="">请选择</option>');
     }
     var html = [];
     $.post("<?php echo U('Admin/GoodsCats/queryByList');?>",params,function(data,textStatus){
        html.push('<option value="">请选择</option>');
      var json = WST.toJson(data);
      if(json.status=='1' && json.list){
        var opts = null;
        for(var i=0;i<json.list.length;i++){
          opts = json.list[i];
          html.push('<option value="'+opts.catId+'" '+((id==opts.catId)?'selected':'')+'>'+opts.catName+'</option>');
        }
      }
      $('#'+objId).html(html.join(''));
     });
}
   </script>
   <body class='wst-page'>
    <form method='post' action='<?php echo U("Admin/Goods/index");?>' autocomplete="off">
       <div class='wst-tbar'>
  门票分类：<select id='goodsCatId1' onchange='javascript:getCatListForEdit("goodsCatId2",this.value,0)'>
                  <option value=''>请选择</option>
                  <?php if(is_array($goodsCatsList)): $i = 0; $__LIST__ = $goodsCatsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['goodsCatId1'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
               </select>
               <select id='goodsCatId2' onchange='javascript:getCatListForEdit("goodsCatId3",this.value,1);'>
                  <option value=''>请选择</option>
               </select>
               <select id='goodsCatId3'>
                  <option value=''>请选择</option>
               </select>
   </div>
   <div class='wst-tbar'>
       门票：<input type='text' id='goodsName' name='goodsName' value='<?php echo ($goodsName); ?>' placeholder="名称" />
  <button type="submit" class="btn btn-primary glyphicon glyphicon-search">查询</button>
       </div>
       </form>
       <div class='wst-body'>
        <div class='wst-tbar'>
        <?php if(in_array('splb_01',$WST_STAFF['grant'])){ ?>
        <a class="btn btn-success glyphicon glyphicon-plus" href="<?php echo U('Admin/Goods/toView');?>" style="float:right">新增</a>
        <?php } ?>
        </div>
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='2'><input type='checkbox' name='chk' onclick='javascript:checkAll(this.checked)'/></th>
               <th width='180'>景点名称</th>
               <th width='40'>价格</th>
               <th width='25'>销量</th>
               <th width='25'>属性</th>
               <th width='80'>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['root'])): $i = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
               <td><input type='checkbox' class='chk' name='chk_<?php echo ($vo['goodsId']); ?>' value='<?php echo ($vo['goodsId']); ?>'/></td>
               <td img='<?php echo ($vo['goodsThums']); ?>' class='imgPreview'>
               <img src='/<?php echo ($vo['goodsThums']); ?>' width='50'/>
               <?php echo ($vo['goodsName']); ?>
               </td>
               <td><?php echo ($vo['adultPrice']); ?>&nbsp;</td>
               <td><?php echo ($vo['saleCount']); ?></td>
               <?php if(in_array('splb_02',$WST_STAFF['grant'])){ ?>
               <td><button type="button" class="btn btn-info" onclick="addAttr(<?php echo ($vo[goodsId]); ?>)">属性管理</button></td>
               <?php } ?>
               <td>
               <a class="btn btn-primary glyphicon" href='<?php echo U("Admin/Goods/toView",array("id"=>$vo["goodsId"]));?>'>修改</a> 
               <?php if(in_array('splb_04',$WST_STAFF['grant'])){ ?>
               <button type="button" class="btn btn-danger glyphicon glyphicon-pencil" onclick="javascript:changeStatus(<?php echo ($vo['goodsId']); ?>,0)">禁售</button>&nbsp;
               <?php } ?>
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='10' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
       <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="margin-left: 20%">
          <div class="modal-content" style="width: 1000px">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">门票属性</h4>
            </div>
            <div class="modal-body" >
            <table class="table table-hover table-striped table-bordered wst-form" id="Attr_Attr">
            <tr>
               <th width='120'>属性:</th>
               <td>套餐&nbsp;</td>
            </tr>
            <tr>
            <th width='120'></th>
               <td>
                 <table class="table wst-list" style='margin:0px;border-top:1px solid #ddd;width: 800px'>
                  <tr>
                    <th style='background:#f5f5f5'>名称</th>
                    <th style='background:#f5f5f5'>价格</th>
                    <!-- <th style='background:#f5f5f5'>推荐</th> -->
                    <!-- <th style='background:#f5f5f5'>库存</th> -->
                    <th>操作</th>
                  </tr>
                  <tr v-for="item in atprice">
                    <td>{{item.attrVal}}</td>
                    <td>{{item.attrPrice}}</td>
                    <!-- <td>3</td> -->
                    <!-- <td>{{item.attrStock}}</td> -->
                    <td><a class="btn btn-default glyphicon glyphicon-trash" @click="delAttr(item.goodsId,item.id,item.attrId)" title="删除"></a></td>
                  </tr>
                  <tr>
                    <td><input type="text" v-model="attrPrice.attrVal"/><input type="hidden" v-model="attrPrice.attrId" value="1" /></td>
                    <td><input type="text" v-model="attrPrice.attrPrice" value="0" onkeypress="return WST.isNumberdoteKey(event)"></td>
                    <!-- <td><input type="radio" name="price_isRecomm" v-model="attrPrice.attrId"/></td> -->
                   <!--  <td><input type="text" value="100" v-model="attrPrice.attrStock" onkeypress="return WST.isNumberKey(event)" maxLength="25"/></td> -->
                    <td><a class="btn btn-default glyphicon glyphicon-plus" @click="addAttrPrice()" title="保存"></a></td>
                  </tr>
                </table>
               </td>
            </tr>
            <tr>
               <th width='120'>属性:</th>
               <td>分店&nbsp;</td>
            </tr>
            <tr>
            <th width='120'></th>
               <td>
                 <table class="table wst-list" style='margin:0px;border-top:1px solid #ddd;width: 800px'>
                  <tr>
                    <th style='background:#f5f5f5'>名称</th>
                    <th>操作</th>
                  </tr>
                  <tr v-for="item in atfd">
                    <td>{{item.attrVal}}</td>
                    <td><a class="btn btn-default glyphicon glyphicon-trash" @click="delAttr(item.goodsId,item.id,item.attrId)" title="删除"></a></td>
                  </tr>
                  <tr>
                    <td><input type="text" v-model="attrFd.attrVal" /><input type="hidden" v-model="attrFd.attrId" value="2" /></td>
                    <td><a class="btn btn-default glyphicon glyphicon-plus" @click="addAttrFd()" title="保存"></a></td>
                  </tr>
                </table>
               </td>
            </tr>
            <!-- <tr>
               <th width='120'>属性:</th>
               <td>其他属性&nbsp;</td>
            </tr>
            <tr>
            <th width='120'></th>
               <td>
                 <table class="table wst-list" style='margin:0px;border-top:1px solid #ddd;width: 800px'>
                  <tr>
                    <th style='background:#f5f5f5'>名称</th>
                    <th style='background:#f5f5f5'>内容</th>
                    <th>操作</th>
                  </tr>
                  <tr v-for="item in atOther">
                    <td>{{item.attrVal}}</td>
                    <td>{{item.attrDesc}}</td>
                    <td><a class="btn btn-default glyphicon glyphicon-trash" @click="delAttr(item.goodsId,item.id,item.attrId)" title="删除"></a></td>
                  </tr>
                  <tr>
                    <td><input type="text" v-model="attrOther.attrVal" /><input type="hidden" v-model="attrOther.attrId" value="3" /></td>
                    <td><input type="text" v-model="attrOther.attrDesc" /></td>
                    <td><a class="btn btn-default glyphicon glyphicon-plus" @click="addAttrOther()" title="保存"></a></td>
                  </tr>
                </table>
               </td>
            </tr> -->
          </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" onclick="buttonhide()">Close</button>
            </div>
          </div>
        </div>
      </div>
   </body>
   <script>
    //添加门票属性
    var suibian=null;
    function addAttr(id){
      $("#myModal").modal("show");
      var goodsId = id;
      if(suibian!=null){
        suibian.atprice=findGoodsAttr(goodsId,1);
        suibian.atfd=findGoodsAttr(goodsId,2);
        // suibian.atOther=findGoodsAttr(goodsId,3);
        suibian.attrPrice.goodsId = goodsId;
        suibian.attrFd.goodsId = goodsId;
        // suibian.attrOther.goodsId = goodsId;
      }else{
        suibian = new Vue({
          el:'#Attr_Attr',
          data:{
            atprice:findGoodsAttr(goodsId,1),
            atfd:findGoodsAttr(goodsId,2),
            // atOther:findGoodsAttr(goodsId,3),
            attrPrice:{
              goodsId:goodsId
            },
            attrFd:{
              goodsId:goodsId
            },
            // attrOther:{
            //   goodsId:goodsId
            // },
          },
          methods:{
            //门票套餐添加
            addAttrPrice:function(){
              ajaxAddAttr(this.attrPrice);
              suibian.atprice = findGoodsAttr(suibian.attrPrice.goodsId,this.attrPrice.attrId);
              this.attrPrice.attrVal = null;
              this.attrPrice.attrPrice = null;
            },
            //门票分店添加
            addAttrFd:function(){
              ajaxAddAttr(this.attrFd);
              suibian.atfd = findGoodsAttr(suibian.attrFd.goodsId,this.attrFd.attrId);
              this.attrFd.attrVal = null;
            },
            //门票其他添加
            // addAttrOther:function(){
            //   ajaxAddAttr(this.attrOther);
            //   suibian.atOther = findGoodsAttr(suibian.attrOther.goodsId,this.attrOther.attrId);
            //   this.attrOther.attrVal = null;
            //   this.attrOther.attrDesc = null;
            // },
            //删除门票属性
            delAttr:function(goodsId,id,attrId){
              ajaxDelAttr(id,attrId);
              if(attrId==1){
                suibian.atprice = findGoodsAttr(goodsId,attrId);
              }
              if(attrId==2){
                suibian.atfd = findGoodsAttr(goodsId,attrId);
              }
              // if(attrId==3){
              //   suibian.atfd = findGoodsAttr(goodsId,attrId);
              // }
            }
          }
        });
      }
    }
    //获取门票属性
    function findGoodsAttr(id,attrId){
      var attrJson = null;
      $.ajax( {
          url: "<?php echo U('Admin/GoodsAttributes/findGoodsAttr');?>" ,
          type: "POST" ,
          async:false,
          data:{
            'goodsId':id,
            'attrId':attrId
          },
          dataType:'Json',
          success: function(data, textStatus, jqXHR ){
             attrJson = data;//WST.toJson(data);
          } ,
          error: function(jqXHR, textStatus, errorMsg){
            console.log(jqXHR);
            console.log(errorMsg);
          }
      });
      return attrJson;
    }
    //ajax门票属性添加
    function ajaxAddAttr(obj){
      var attrJson = null;
      $.ajax( {
          url: "<?php echo U('Admin/GoodsAttributes/addAttr');?>" ,
          type: "POST",
          async:false,
          data:obj,
          dataType:'Json',
          success: function(data, textStatus, jqXHR ){
            if(data.status){
              WST.msg('添加成功!', {icon: 1});
              attrJson = data;
            }else{
              WST.msg('添加失败!', {icon: 5});
            }
          } ,
          error: function(jqXHR, textStatus, errorMsg){
            console.log(jqXHR);
            console.log(errorMsg);
          }
      });
      return attrJson;
    }
    //ajax门票属性添加
    function ajaxDelAttr(id,attrId){
      var attrJson = null;
      $.ajax( {
          url: "<?php echo U('Admin/GoodsAttributes/delAttr');?>" ,
          type: "POST",
          async:false,
          data:{
            id:id,
            attrId:attrId
          },
          dataType:'Json',
          success: function(data, textStatus, jqXHR ){
            if(data.status){
              WST.msg('删除成功!', {icon: 1});
              attrJson = data;
            }else{
              WST.msg('删除失败!', {icon: 5});
            }
          } ,
          error: function(jqXHR, textStatus, errorMsg){
            console.log(jqXHR);
            console.log(errorMsg);
          }
      });
      return attrJson;
    }
    //关闭模态框
    function buttonhide(){
      $("#myModal").modal("hide");
    }
    </script>
</html>