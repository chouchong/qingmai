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
       <!-- <script src="/Public/plugins/lazyload/jquery.lazyload.min.js?v=1.9.1"></script> -->
       <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
       <script src="/Public/js/common.js"></script>
       <script src="/Public/plugins/layer/layer.min.js"></script>
       <script src="/Public/plugins/plugins/plugins.js"></script>
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
       <script src="/Public/plugins/kindeditor/kindeditor.js"></script>
       <script src="/Public/plugins/kindeditor/lang/zh_CN.js"></script>
       <!-- <script type="text/javascript" src="/Apps/Admin/View/js/goods.js"></script> -->
       <script type="text/javascript" src="/Apps/Admin/View/js/upload.js"></script>
       <link rel="stylesheet" type="text/css" href="/Public/plugins/webuploader/style.css" />
        <link rel="stylesheet" type="text/css" href="/Public/plugins/webuploader/webuploader.css" />
        <script type="text/javascript" src="/Public/plugins/webuploader/webuploader.js"></script>
   
   </head>
   <style>
    .wst-tab-box{width:100%; height:auto; margin:0px auto;}
  .wst-tab-nav{margin:0; padding:0; height:25px; line-height:24px;position: relative;top:2px;left:3px;}
  .wst-tab-nav li{cursor:pointer;float:left; margin:0 0px; list-style:none; border:1px solid #ddd; border-bottom:none; height:24px; width:100px; text-align:center; background:#eeeeee;color:#000000;}
  .wst-tab-nav .on{background:#ffffff;color:#000000;border-bottom:0 none;}
  .wst-tab-content{padding:5px;width:99%; height:auto; border:1px solid #ddd;background:#FFF;}
    .wst-gallery-imgs{width:770px;height:auto;}
    .wst-gallery-img{width:140px;height:100px;float:left;overflow:hidden;margin:10px 5px 5px 5px;}
   </style>
   <script>
   var ablumInit = false;
   var publicurl = "/Public";
   var ThinkPHP = window.Think = {
           "ROOT"   : ""
       }
   var filetypes = ["gif","jpg","png","jpeg"];
   var UploadUrl = "<?php echo U('Home/Base/uploadPic');?>";
   function imglimouseover(obj){
  if(!$(obj).find('.file-panel').html()){
    $(obj).find('.setdel').addClass('trconb');
    $(obj).find('.setdel').css({"display":""});
  }
}

function imglimouseout(obj){
  
  $(obj).find('.setdel').removeClass('trconb');
  $(obj).find('.setdel').css({"display":"none"});
}

function imglidel(obj){
  if (confirm('是否删除图片?')) {
    $(obj).parent().remove("li");
    return;
  }
}

function imgmouseover(obj){
  $(obj).find('.wst-gallery-goods-del').show();
}
function imgmouseout(obj){
  $(obj).find('.wst-gallery-goods-del').hide();
}
function delImg(obj){
     $(obj).parent().remove();
}
   $(function () {
     $('#tab').TabPanel({tab:0,callback:function(no){
        if(no==1 && !ablumInit)uploadAblumInit();
     }});
     $.formValidator.initConfig({
       theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
             editHotels();
             return false;
      },onError:function(msg){
    }});
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
   });
   </script>
   <script type="text/javascript" src="/Apps/Admin/View/js/hotelsbatchupload.js"></script>
   <body class="wst-page">
       <div id='tab' class="wst-tab-box">
    <ul class="wst-tab-nav">
        <li>酒店信息</li>
        <!-- <li>门票属性</li> -->
        <li>酒店相册</li>
      </ul>
      <div class="wst-tab-content" style='width:98%;'>
      <div class='wst-tab-item'>
      <iframe name="upload" style="display:none"></iframe>
          <form id="uploadform_Filedata" autocomplete="off" style="top:210px;position:absolute;left:483px;z-index:10;" enctype="multipart/form-data" method="POST" target="upload" action="<?php echo U('Home/Base/uploadPic');?>" >
                <div style="position:relative;">
                <input id="hotelImg" name="hotelImg" type="text" value="<?php echo ($object["hotelImg"]); ?>" readonly style="margin-right:4px;float:left;margin-left:8px;width:140px;"/>
                <div class="div1">
                  <div class="div2">浏览</div>
                  <input type="file" class="inputstyle" id="Filedata" name="Filedata" onchange="updfile('Filedata');" >
                </div>
                <div style="clear:both;"></div>
                <div >&nbsp;图片大小:750 x 400 (px)(格式为 gif, jpg, jpeg, png)</div>
                <input type="hidden" name="dir" value="hotels">
                <input type="hidden" name="width" value="750">
                <input type="hidden" name="height" value="400">
                <input type="hidden" name="folder" value="Filedata">
                <input type="hidden" name="sfilename" value="Filedata">
                <input type="hidden" name="fname" value="hotelImg">
                <input type="hidden" id="s_Filedata" name="s_Filedata" value="">
                </div>
              </form>
          <form name="myform" method="post" id="myform">
          <input type='hidden' id='id' value='<?php echo ($object["hotelId"]); ?>'/>
          <table class="table table-hover table-striped table-bordered wst-form">
             <tr>
               <th width='120'>酒店名称<font color='red'>*</font>：</th>
               <td width='350'><input type='text' id='hotelName' name='hotelName' class="form-control wst-ipt" value='<?php echo ($object["hotelName"]); ?>' maxLength='100'/></td>
               <td rowspan='8' valign='top'>
                 <div id="preview_Filedata">
               <img id='hotelImgPreview' src='<?php if($object['hotelImg'] =='' ): ?>/<?php echo ($CONF['goodsImg']); else: ?>/<?php echo ($object['hotelImg']); endif; ?>' height='152'/><br/>
                 </div>
               </td>
             </tr>
              <tr>
               <th width='120'>酒店英文<font color='red'>*</font>：</th>
               <td width='350'><input type='text' id='hotelEnglishName' name='hotelEnglishName' class="form-control wst-ipt" value='<?php echo ($object["hotelEnglishName"]); ?>'></td>
             </tr>
             <tr>
               <th width='120'>酒店电话<font color='red'>*</font>：</th>
               <td width='350'>
                <input type='text' id='hotelPhone' name='hotelPhone' class="form-control wst-ipt" value='<?php echo ($object["hotelPhone"]); ?>'/>
               </td>
             </tr>
             <tr>
               <th width='120'>酒店星数<font color='red'>*</font>：</th>
               <td width='350'>
                <input type='text' id='hotelStar' name='hotelStar' class="form-control wst-ipt" value='<?php echo ($object["hotelStar"]); ?>'/>
               </td>
             </tr>
             <tr>
               <th width='120'>酒店类型<font color='red'>*</font>：</th>
               <td width='350'>
                <input type='text' id='hotelType' name='hotelType' class="form-control wst-ipt" value='<?php echo ($object["hotelType"]); ?>'/>
               </td>
             </tr>
             <tr>
               <th width='120'>网络连接<font color='red'>*</font>：</th>
               <td width='350'>
                <input type='text' id='hotelnetwork' name='hotelnetwork' class="form-control wst-ipt" value='<?php echo ($object["hotelnetwork"]); ?>'/>
               </td>
             </tr>
             <tr>
               <th width='120'>房间面积<font color='red'>*</font>：</th>
               <td width='350'>
                <input type='text' id='hotelRoomArea' name='hotelRoomArea' class="form-control wst-ipt" value='<?php echo ($object["hotelRoomArea"]); ?>'/>
               </td>
             </tr>
             <tr>
               <th width='120'>床铺尺寸<font color='red'>*</font>：</th>
               <td width='350'>
                <input type='text' id='hotelBedSize' name='hotelBedSize' class="form-control wst-ipt" value='<?php echo ($object["hotelBedSize"]); ?>'/>
               </td>
             </tr>
             <tr>
               <th width='120'>酒店地址<font color='red'>*</font>：</th>
               <td colspan='3'>
               <input type='text' style="width:788px" id='hotelAddress' name='hotelAddress' value='<?php echo ($object["hotelAddress"]); ?>' maxlength="200">
               </td>
             </tr>
             <tr>
               <th width='120'>酒店地址英文<font color='red'>*</font>：</th>
               <td colspan='3'>
               <input type='text' style="width:788px" id='hotelEnglishAddress' name='hotelEnglishAddress' value='<?php echo ($object["hotelEnglishAddress"]); ?>' maxlength="200">
               </td>
             </tr>
             <tr>
               <th width='120'>停车场<font color='red'>*</font>：</th>
               <td colspan='3'>
               <input type='text' style="width:788px" id='hotelpark' name='hotelpark' value='<?php echo ($object["hotelpark"]); ?>' maxlength="200">
               </td>
             </tr>
             <tr>
               <th width='120'>入住时间<font color='red'>*</font>：</th>
               <td colspan='3'>
               <input type='text' style="width:788px" id='hotelTntime' name='hotelTntime' value='<?php echo ($object["hotelTntime"]); ?>' maxlength="200">
               </td>
             </tr><tr>
               <th width='120'>退房时间<font color='red'>*</font>：</th>
               <td colspan='3'>
               <input type='text' style="width:788px" id='hotelFromtime' name='hotelFromtime' value='<?php echo ($object["hotelFromtime"]); ?>' maxlength="200">
               </td>
             </tr>
             <tr>
               <th width='120'>酒店描述<font color='red'>*</font>：</th>
               <td colspan='3'>
               <textarea style='width:80%;height:250px;' id='hotelDesc' name='hotelDesc'><?php echo ($object["hotelDesc"]); ?></textarea>
               </td>
             </tr>
             <tr>
               <th width='120'>酒店活动<font color='red'>*</font>：</th>
               <td colspan='3'>
               <textarea style='width:80%;height:250px;' id='hotelActivity' name='hotelActivity'><?php echo ($object["hotelActivity"]); ?></textarea>
               </td>
             </tr>
             <tr>
               <th width='120'>综合设施<font color='red'>*</font>：</th>
               <td colspan='3'>
               <textarea style='width:80%;height:250px;' id='hotelService' name='hotelService'><?php echo ($object["hotelService"]); ?></textarea>
               </td>
             </tr><tr>
               <th width='120'>服务项目<font color='red'>*</font>：</th>
               <td colspan='3'>
               <textarea style='width:80%;height:250px;' id='hotelcomplex' name='hotelcomplex'><?php echo ($object["hotelcomplex"]); ?></textarea>
               </td>
             </tr>
             <tr>
               <th width='120'>客房设施<font color='red'>*</font>：</th>
               <td colspan='3'>
               <textarea style='width:80%;height:250px;' id='hotelRoomfacilities' name='hotelRoomfacilities'><?php echo ($object["hotelRoomfacilities"]); ?></textarea>
               </td>
             </tr>
             <tr>
               <th width='120'>酒店内容<font color='red'>*</font>：</th>
               <td colspan='3'>
               <textarea style='width:80%;height:500px;' id='hotelContent' name='hotelContent'><?php echo ($object["hotelContent"]); ?></textarea>
               </td>
             </tr>
             <tr>
               <td colspan='3' style='padding-left:320px;'>
                   <button class='wst-btn-query' type="submit">保&nbsp;存</button>
                   <button class='wst-btn-query' type="button" onclick=''>返&nbsp;回</button>
               </td>
             </tr>
          </table>
         </form>
        </div>
        <div class='wst-tab-item'>
        <div id='galleryImgs' class='wst-gallery-imgs'>
                  <div id="tt"></div>
                  <?php if(count($object['gallery']) == 0): ?><div id="wrapper">
                           <div id="container">
            <!--头部，相册选择和格式选择-->
                              <div id="uploader">
                               <div class="queueList">
                                   <div id="dndArea" class="placeholder">
                                      <div id="filePicker"></div>
                                      </div>
                                   <ul class="filelist"></ul>
                               </div>
                             <div class="statusBar" style="display:none">
                               <div class="progress">
                                    <span class="text">0%</span>
                                    <span class="percentage"></span>
                               </div>
                                    <div class="info"></div>
                               <div class="btns">
                                 <div id="filePicker2" class="webuploader-containe webuploader-container"></div><div class="uploadBtn state-finish">开始上传</div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
               <?php else: ?>
                <div id="wrapper">
                       <div id="container">
                          <div id="uploader">
                             <div class="queueList">
                                 <div id="dndArea" class="placeholder element-invisible">
                                    <div id="filePicker" class="webuploader-container"></div>
                                    </div>
                                 <ul class="filelist">
                                  <?php if(is_array($object['gallery'])): $i = 0; $__LIST__ = $object['gallery'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="border: 1px solid rgb(59, 114, 165)" order="100" onmouseover="imglimouseover(this)" onmouseout="imglimouseout(this)">
                                      <input type="hidden" class="gallery-img" iv="<?php echo ($vo["hotelThumbs"]); ?>" v="<?php echo ($vo["hotelImg"]); ?>" />
                                      <img width="152" height="152" src="/<?php echo ($vo["hotelThumbs"]); ?>"><span class="setdef" style="display:none">默认</span><span class="setdel" onclick="imglidel(this)" style="display:none">删除</span>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </ul>
                            </div>
                            <div class="statusBar" style="">
                               <div class="progress">
                                    <span class="text"></span>
                                    <span class="percentage"></span>
                               </div>
                               <div class="info"></div>
                               <div class="btns">
                                  <div id="filePicker2" class="webuploader-containe webuploader-container"></div>
                                  <div class="uploadBtn state-finish">开始上传</div>
                               </div>
                            </div>
                        </div>
                    </div>
                 </div><?php endif; ?>
         </div>
         <div style='clear:both;'></div>
        </div>
       </div>
       </div>
   </body>
   <script>
     function editHotels(){
       var params = {};
       params.id = $('#id').val();
       params.hotelName = $('#hotelName').val();
       params.hotelImg = $('#hotelImg').val();
       params.hotelEnglishName = $('#hotelEnglishName').val();
       params.hotelPhone = $('#hotelPhone').val();
       params.hotelStar = $('#hotelStar').val();
       params.hotelType = $('#hotelType').val();
       params.hotelnetwork = $('#hotelnetwork').val();
       params.hotelRoomArea = $('#hotelRoomArea').val();
       params.hotelBedSize = $('#hotelBedSize').val();
       params.hotelAddress = $('#hotelAddress').val();
       params.hotelEnglishAddress = $('#hotelEnglishAddress').val();
       params.hotelpark = $('#hotelpark').val();
       params.hotelTntime = $('#hotelTntime').val();
       params.hotelFromtime = $('#hotelFromtime').val();
       params.hotelService = $('#hotelService').val();
       params.hotelcomplex = $('#hotelcomplex').val();
       params.hotelRoomfacilities = $('#hotelRoomfacilities').val();
       params.hotelDesc = $('#hotelDesc').val();
       params.hotelActivity = $('#hotelActivity').val();
       params.hotelContent = $('#hotelContent').val();
       var gallery = [];
       $('.gallery-img').each(function(){
         gallery.push($(this).attr('v')+'@'+$(this).attr('iv'));
       });
       if(params.hotelName==''){
         WST.msg('请输入酒店名称!', {icon: 5});
         return;
       }
    if(params.hotelEnglishName==''){
         WST.msg('请输入酒店英文!', {icon: 5});
         return;
       }
    if(params.hotelPhone==''){
         WST.msg('请输入酒店电话!', {icon: 5});
         return;
       }
    if(params.hotelStar==''){
         WST.msg('请输入酒店星数!', {icon: 5});
         return;
       }
    if(params.hotelType==''){
         WST.msg('请输入酒店类型!', {icon: 5});
         return;
       }
    if(params.hotelnetwork==''){
         WST.msg('请输入网络连接!', {icon: 5});
         return;
       }
    if(params.hotelRoomArea==''){
         WST.msg('请输入房间面积!', {icon: 5});
         return;
       }
    if(params.hotelBedSize==''){
         WST.msg('请输入床铺尺寸!', {icon: 5});
         return;
       }
    if(params.hotelAddress==''){
         WST.msg('请输入酒店地址!', {icon: 5});
         return;
       }
    if(params.hotelEnglishAddress==''){
         WST.msg('请输入酒店地址英文!', {icon: 5});
         return;
       }
    if(params.hotelpark==''){
         WST.msg('请输入停车场!', {icon: 5});
         return;
       }
    if(params.hotelTntime==''){
         WST.msg('请输入入住时间!', {icon: 5});
         return;
       }
    if(params.hotelFromtime==''){
         WST.msg('请输入退房时间!', {icon: 5});
         return;
       }
       if(params.hotelService==''){
         WST.msg('请输入综合设施!', {icon: 5});
         return;
       }
       if(params.hotelcomplex==''){
         WST.msg('请输入服务项目!', {icon: 5});
         return;
       }
       if(params.hotelRoomfacilities==''){
         WST.msg('请输入客房设施!', {icon: 5});
         return;
       }
       if(params.hotelDesc==''){
         WST.msg('请输入酒店描述!', {icon: 5});
         return;
       }
       if(params.hotelContent==''){
         WST.msg('请输入酒店内容!', {icon: 5});
         return;
       }
       if(params.hotelActivity==''){
         WST.msg('请输入酒店活动!', {icon: 5});
         return;
       }
       if(params.hotelImg==''){
         WST.msg('请上传酒店图片!', {icon: 5});
         return;
       }
       params.gallery = gallery.join(',');
       var loading = layer.load('正在提交门票信息，请稍后...', 3);
       // console.log(params);
       $.post("<?php echo U('Admin/Hotels/toEdit');?>",params,function(data,textStatus){
         layer.close(loading);
        var json = WST.toJson(data);
        if(json.status=='1'){
          WST.msg('操作成功!', {icon: 1}, function(){
              location.href="<?php echo U('Admin/Hotels/Index');?>";
          });
        }else{
         WST.msg('操作失败!', {icon: 5});
        }
       });
     }
   </script>
</html>