<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['mallTitle']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
      <link href="/Apps/Admin/View/css/upload.css" rel="stylesheet" type="text/css" />
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
     <script type="text/javascript" src="/Apps/Admin/View/js/upload.js"></script>
     <script src="/Public/plugins/kindeditor/kindeditor.js"></script>
     <style>
        .checkbox{
          margin-left: 25px;
        }
     </style>
   </head>
   <script>
   var ThinkPHP = window.Think = {
	        "ROOT"   : ""
	}
   var filetypes = ["gif","jpg","png","jpeg"];
   $(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			},onError:function(msg){
		}});
	   $("#friendlinkName").formValidator({onShow:"",onFocus:"网站名称至少要输入1个字符",onCorrect:"输入正确"}).inputValidator({min:1,max:20,onError:"你输入的长度不正确,请确认"});
	   $("#friendlinkUrl").formValidator({onShow:"",onFocus:"请输入网站地址",onCorrect:"输入正确"}).regexValidator({regExp:"url",dataType:"enum",onError:"网站地址不正确"});

   });
   KindEditor.ready(function(K) {
			editor1 = K.create('textarea', {
				height:'250px',
				allowFileManager : false,
				allowImageUpload : true,
				items:[
				        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
				        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
				        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
				        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image','table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
				        'anchor', 'link', 'unlink', '|', 'about'
				],
				afterBlur: function(){ this.sync(); }
			});
		});
   </script>
   <body class="wst-page">
   	   <iframe name="upload" style="display:none"></iframe>
			<form id="uploadform_Filedata" autocomplete="off" style="position:absolute;top:48px;left:140px;z-index:10;" enctype="multipart/form-data" method="POST" target="upload" action="<?php echo U('Home/Base/uploadPic');?>" >
				<div style="position:relative;">
				<input id="drivesImg" name="drivesImg" class="form-control wst-ipt" type="text" value="<?php echo ($object["drivesImg"]); ?>" readonly style="margin-right:4px;float:left;margin-left:8px;width:250px;"/>
				<div class="div1">
					<div class="div2">浏览</div>
					<input type="file" class="inputstyle" id="Filedata" name="Filedata" onchange="updfile('Filedata');" >
				</div>
				<div style="clear:both;"></div>
				<div >&nbsp;图片大小:750 x 400 (px)(格式为 gif, jpg, jpeg, png)</div>
				<input type="hidden" name="dir" value="drives">
				<input type="hidden" name="width" value="750">
        <input  type="hidden" name="height" value="400" />
				<input type="hidden" name="folder" value="Filedata">
				<input type="hidden" name="sfilename" value="drivesImg">
				<input type="hidden" name="fname" value="drivesImg">
				<input type="hidden" id="s_Filedata" name="s_Filedata" value="">
				</div>
		</form>
		<form id="uploadform_Map" autocomplete="off" style="position:absolute;top:120px;left:140px;z-index:10;" enctype="multipart/form-data" method="POST" target="upload" action="<?php echo U('Home/Base/uploadPic');?>" >
				<div style="position:relative;">
				<input id="drivesMap" name="drivesMap" class="form-control wst-ipt" type="text" value="<?php echo ($object["drivesMap"]); ?>" readonly style="margin-right:4px;float:left;margin-left:8px;width:250px;"/>
				<div class="div1">
					<div class="div2">浏览</div>
					<input type="file" class="inputstyle" id="Map" name="Map" onchange="updfile('Map');" >
				</div>
				<div style="clear:both;"></div>
				<div >&nbsp;图片大小:1500 x 1000 (px)(格式为 gif, jpg, jpeg, png)</div>
				<input type="hidden" name="dir" value="drives">
				<input type="hidden" name="width" value="1500">
        <input  type="hidden" name="height" value="1000" />
				<input type="hidden" name="folder" value="Filedata">
				<input type="hidden" name="sfilename" value="drivesMap">
				<input type="hidden" name="fname" value="drivesMap">
				<input type="hidden" id="s_Filedata" name="s_Filedata" value="">
				</div>
		</form>
       <form name="myform" method="post" id="myform" autocomplete="off">
        <input type='hidden' id='id' value='<?php echo ($object["drivesId"]); ?>'/>
        <input type='hidden' id='drivesImg' value='<?php echo ($object["drivesImg"]); ?>'/>
        <input type='hidden' id='drivesMap' value='<?php echo ($object["drivesMap"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='140' align='right'>自驾名称<font color='red'>*</font>：</th>
             <td><input type='text' id='drivesName' class="form-control wst-ipt" value='<?php echo ($object["drivesName"]); ?>' maxLength='25'/></td>
           </tr>
           <tr style="height:70px;">
             <th align='right'>自驾图<font color='red'>*</font>：</th>
             <td>
             </td>
           </tr>
           <tr style="height:70px;">
             <th align='right'>自驾行程地图<font color='red'>*</font>：</th>
             <td>
             </td>
           </tr>
           <tr>
             <th align='right'>自驾预览图：</th>
             <td height='40'>
            	<div id="preview_drivesImg">
               <img id='preview' src='/<?php echo ($object["drivesImg"]); ?>' height='152' <?php if($object['drivesImg'] =='' ): ?>style='display:none'<?php endif; ?>/>
               </div>
             </td>
           </tr>
           <tr>
             <th align='right'>自驾行程预览图：</th>
             <td height='40'>
            	<div id="preview_drivesMap">
               <img id='preview' src='/<?php echo ($object["drivesMap"]); ?>' <?php if($object['drivesMap'] =='' ): ?>style='display:none'<?php endif; ?>/>
               </div>
             </td>
           </tr>
           <tr>
             <th width='140' align='right'>自驾目的地<font color='red'>*</font>：</th>
             <td><input type='text' id='drivesFrom' class="form-control wst-ipt" value='<?php echo ($object["drivesFrom"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th width='140' align='right'>成人价格<font color='red'>*</font>：</th>
             <td><input type='text' id='adultPrice' class="form-control wst-ipt" value='<?php echo ($object["adultPrice"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th width='140' align='right'>儿童价格<font color='red'>*</font>：</th>
             <td><input type='text' id='childPrice' class="form-control wst-ipt" value='<?php echo ($object["childPrice"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th width='140' align='right'>房价差<font color='red'>*</font>：</th>
             <td><input type='text' id='homePrice' class="form-control wst-ipt" value='<?php echo ($object["homePrice"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th width='140' align='right'>自驾天数<font color='red'>*</font>：</th>
             <td><input type='text' id='drivesDay' class="form-control wst-ipt" value='<?php echo ($object["drivesDay"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th width='140' align='right'>酒店选择<font color='red'>*</font>：</th>
             <td>
             <input type="hidden" id="zhuchuHotels" value="<?php echo ($object["driveshotelsIds"]); ?>" />
             <input type="hidden" id="tuzhongHotels" value="<?php echo ($object["driveswayhotelsIds"]); ?>" />
             <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myHotels">请选择酒店</button>
             </td>
           </tr>
           <tr>
             <th width='140' align='right'>景点推荐<font color='red'>*</font>：</th>
             <td>
             <input type="hidden" id="goodsids" value="<?php echo ($object["drivesgoodsIds"]); ?>"/>
             <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myGoods">请选择景点</button>
             </td>
           </tr>
           <tr>
             <th width='140' align='right'>行程内容<font color='red'>*</font>：</th>
             <td>
             <input type="hidden" id="articlesIds" value="<?php echo ($object["drivesarticlesIds"]); ?>"/>
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myWayDays">请选择行程</button></td>
           </tr>
           <tr>
             <th width='140' align='right'>SEO关键字<font color='red'>*</font>：</th>
             <td><input style='width:40%;' type='text' id='drivesKeywords' class="form-control wst-ipt" value='<?php echo ($object["drivesKeywords"]); ?>' /></td>
           </tr>
           <tr>
             <th width='140' align='right'>SEO信息<font color='red'>*</font>：</th>
             <td><input style='width:40%;' type='text' id='drivesSpec' class="form-control wst-ipt" value='<?php echo ($object["drivesSpec"]); ?>'/></td>
           </tr>
           <tr>
               <th width='140'>自驾描述<font color='red'>*</font>：</th>
               <td>
               <textarea style='width:40%;height:200px;' id='drivesDesc' name='drivesDesc'><?php echo ($object["drivesDesc"]); ?></textarea>
               </td>
             </tr>
           <tr>
	             <th width='140'>价格说明<font color='red'>*</font>：</th>
	             <td>
	             <textarea style='width:40%;height:200px;' id='priceDesc' name='priceDesc'><?php echo ($object["priceDesc"]); ?></textarea>
	             </td>
	           </tr>
           <tr>
	             <th width='140'>费用包含<font color='red'>*</font>：</th>
	             <td>
	             <textarea style='width:40%;height:200px;' id='isFeeDesc' name='isFeeDesc'><?php echo ($object["isFeeDesc"]); ?></textarea>
	             </td>
	           </tr>
           <tr>
	             <th width='140'>费用不含<font color='red'>*</font>：</th>
	             <td>
	             <textarea style='width:40%;height:200px;' id='noFeeDesc' name='noFeeDesc'><?php echo ($object["noFeeDesc"]); ?></textarea>
	             </td>
	           </tr>
           <tr>
	             <th width='140'>赠送项目<font color='red'>*</font>：</th>
	             <td>
	             <textarea style='width:40%;height:200px;' id='presentProject' name='presentProject'><?php echo ($object["presentProject"]); ?></textarea>
	             </td>
	           </tr>
           <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button type="submit" class="btn btn-success">保&nbsp;存</button>
                 <button type="button" class="btn btn-primary" onclick='javascript:location.href="<?php echo U('Admin/Friendlinks/index');?>"'>返&nbsp;回</button>
             </td>
           </tr>
        </table>
       </form>
       <!-- Modal -->
      <div class="modal fade" id="myHotels" tabindex="-1" role="dialog" aria-labelledby="myHotelsLabel">
        <div class="modal-dialog" role="document" style="margin-left: 20%">
          <div class="modal-content" style="width: 1000px">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myHotelsLabel">酒店选择</h4>
            </div>
            <div class="modal-body">
              <div class="panel panel-default">
                <div class="panel-heading">住处酒店</div>
                <div class="panel-body">
                  <?php if(is_array($hotels)): $i = 0; $__LIST__ = $hotels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-md-3">
                      <label class="checkbox">
                        <input type="checkbox" id="dt_hotels_<?php echo ($vo['hotelId']); ?>" class="hotelzc" value="<?php echo ($vo['hotelId']); ?>"> <?php echo ($vo['hotelName']); ?>
                      </label>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading">途中酒店</div>
                <div class="panel-body">
                  <?php if(is_array($hotels)): $i = 0; $__LIST__ = $hotels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-md-3">
                      <label class="checkbox">
                        <input type="checkbox" id="dt_wayhotels_<?php echo ($vo['hotelId']); ?>" class="hoteltz" value="<?php echo ($vo['hotelId']); ?>"> <?php echo ($vo['hotelName']); ?>
                      </label>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              <button type="button" class="btn btn-primary" onclick="HotelsSelect()">选择保存</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="myWayDays" tabindex="-1" role="dialog" aria-labelledby="myWayDaysLabel">
        <div class="modal-dialog" role="document" style="margin-left: 20%">
          <div class="modal-content" style="width: 1000px">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myWayDaysLabel">行程内容</h4>
            </div>
            <div class="modal-body">
              <div class="row">
              <?php if(is_array($articles)): $i = 0; $__LIST__ = $articles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-md-3" style="height: 50px;">
                  <label class="checkbox">
                    <input type="checkbox"  id="dt_articles_<?php echo ($vo['catId']); ?>" class="articlexz" value="<?php echo ($vo['catId']); ?>"> <?php echo ($vo['catName']); ?>
                  </label>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              <button type="button" class="btn btn-primary" onclick="ArticlesSelect()">选择保存</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="myGoods" tabindex="-1" role="dialog" aria-labelledby="myGoodsLabel">
        <div class="modal-dialog" role="document" style="margin-left: 20%">
          <div class="modal-content" style="width: 1000px">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myGoodsLabel">景点推荐</h4>
            </div>
            <div class="modal-body">
              <div class="row">
              <?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-md-3">
                  <label class="checkbox">
                    <input type="checkbox" id="dt_goods_<?php echo ($vo['goodsId']); ?>" class="goodsxz" value="<?php echo ($vo['goodsId']); ?>"> <?php echo ($vo['goodsName']); ?>
                  </label>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              <button type="button" class="btn btn-primary" onclick="GoodsSelect()">选择保存</button>
            </div>
          </div>
        </div>
      </div>
   </body>
   <script>
   $(function () {
    var grant = '<?php echo ($object["driveshotelsIds"]); ?>'.split(',');
     for(var i=0;i<grant.length;i++){
      $('#dt_hotels_'+grant[i]).prop('checked',true);
     }
     var way = '<?php echo ($object["driveswayhotelsIds"]); ?>'.split(',');
     for(var i=0;i<way.length;i++){
      $('#dt_wayhotels_'+way[i]).prop('checked',true);
     }
     var goods = '<?php echo ($object["drivesgoodsIds"]); ?>'.split(',');
     for(var i=0;i<goods.length;i++){
      $('#dt_goods_'+goods[i]).prop('checked',true);
     }
     var articles = '<?php echo ($object["drivesarticlesIds"]); ?>'.split(',');
     for(var i=0;i<articles.length;i++){
      $('#dt_articles_'+articles[i]).prop('checked',true);
     }
   });
   function HotelsSelect(){
    var zc = [];
    var tz = [];
    var hotel = true;
     $('.hotelzc').each(function(){
        if($(this).prop('checked'))zc.push($(this).val());
      });
     zc.join(',');
     if(zc.length > 2){
       Plugins.Tips({title:'信息提示',icon:'error',content:'只能选择两家酒店!',timeout:1000});
       hotel = false;
       return;
     }
     $('.hoteltz').each(function(){
        if($(this).prop('checked'))tz.push($(this).val());
      });
     tz.join(',');
     if(tz.length == 0){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾途中至少一家酒店!',timeout:1000});
       hotel = false;
       return;
     }
     if(hotel == true){
      $('#zhuchuHotels').val(zc);
      $('#tuzhongHotels').val(tz);
      $('#myHotels').modal('hide');
     }
   };
   function GoodsSelect(){
    var goodsIds = [];
    var num = true;
     $('.goodsxz').each(function(){
        if($(this).prop('checked'))goodsIds.push($(this).val());
      });
     goodsIds.join(',');
     if(goodsIds.length == 0){
       Plugins.Tips({title:'信息提示',icon:'error',content:'至少选择一个景点!',timeout:1000});
       num = false;
       return;
     }
     if(num == true){
       $('#goodsids').val(goodsIds);
      $('#myGoods').modal('hide');
     }
   }
   function ArticlesSelect(){
    var articlesIds = [];
    var num = true;
     $('.articlexz').each(function(){
        if($(this).prop('checked'))articlesIds.push($(this).val());
      });
     articlesIds.join(',');
     if(articlesIds.length > 1){
       Plugins.Tips({title:'信息提示',icon:'error',content:'只能选择一个的行程!',timeout:1000});
       num = false;
       return;
     }
     if(num == true){
       $('#articlesIds').val(articlesIds);
      $('#myWayDays').modal('hide');
     }
   }
   function edit(){
     var params = {};
     params.id = $('#id').val();
     params.drivesName = $('#drivesName').val();
     params.drivesFrom = $('#drivesFrom').val();
     params.childPrice = $('#childPrice').val();
     params.adultPrice = $('#adultPrice').val();
     params.homePrice = $('#homePrice').val();
     params.drivesDay = $('#drivesDay').val();
     params.drivesSpec = $('#drivesSpec').val();
     params.drivesKeywords = $('#drivesKeywords').val();
     params.priceDesc = $('#priceDesc').val();
     params.isFeeDesc = $('#isFeeDesc').val();
     params.noFeeDesc = $('#noFeeDesc').val();
     params.presentProject = $('#presentProject').val();
     params.drivesImg = $('#drivesImg').val();
     params.drivesMap = $('#drivesMap').val();
     params.zhuchuHotels = $('#zhuchuHotels').val();
     params.tuzhongHotels = $('#tuzhongHotels').val();
     params.goodsids = $('#goodsids').val();
     params.articlesIds = $('#articlesIds').val();

      params.drivesDesc = $('#drivesDesc').val();
     if(params.drivesName==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾不能为空!',timeout:1000});
       return;
     }
     if(params.drivesMap==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾行程图没有上传!',timeout:1000});
       return;
     }
     if(params.drivesImg==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾图没有上传!',timeout:1000});
       return;
     }
     if(params.articlesIds==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'行程没有选择!',timeout:1000});
       return;
     }
     if(params.goodsids==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'景点推荐没有选择!',timeout:1000});
       return;
     }
     if(params.tuzhongHotels==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾途中酒店没有选择!',timeout:1000});
       return;
     }
     if(params.zhuchuHotels==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾住处酒店没有选择!',timeout:1000});
       return;
     }
     if(params.drivesFrom==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾目的地不能为空!',timeout:1000});
       return;
     }
     if(params.childPrice==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾成人价格不能为空!',timeout:1000});
       return;
     }
     if(params.adultPrice==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾儿童价格不能为空!',timeout:1000});
       return;
     }
     if(params.homePrice==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'房价差不能为空!',timeout:1000});
       return;
     }
     if(params.drivesDay==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾天数不能为空!',timeout:1000});
       return;
     }
     if(params.drivesSpec==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾SEO信息不能为空!',timeout:1000});
       return;
     }
     if(params.drivesKeywords==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾SEO关键词不能为空!',timeout:1000});
       return;
     }
     if(params.priceDesc==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾价格说明不能为空!',timeout:1000});
       return;
     }
     if(params.isFeeDesc==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾费用包含不能为空!',timeout:1000});
       return;
     }
     if(params.noFeeDesc==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾费用不含不能为空!',timeout:1000});
       return;
     }
     if(params.drivesDesc==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾描述不能为空!',timeout:1000});
       return;
     }
     if(params.presentProject==''){
       Plugins.Tips({title:'信息提示',icon:'error',content:'自驾赠送项目不能为空!',timeout:1000});
       return;
     }
     Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
     // console.log(params);
    $.post("<?php echo U('Admin/Drives/edit');?>",params,function(data,textStatus){
      var json = WST.toJson(data);
      if(json.status=='1'){
        Plugins.setWaitTipsMsg({ content:'操作成功',timeout:1000,callback:function(){
           location.href='<?php echo U("Admin/Drives/index");?>';
        }});
      }else{
        Plugins.closeWindow();
        Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
      }
    });
   }
   </script>
</html>