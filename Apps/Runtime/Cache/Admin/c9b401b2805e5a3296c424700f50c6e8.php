<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['mallTitle']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" media="all" href="/Public/plugins/daterangepicker/daterangepicker.css" />
      <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/layer/layer.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="/Public/plugins/daterangepicker/moment.js"></script>
      <script type="text/javascript" src="/Public/plugins/daterangepicker/daterangepicker.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      <script src="/Public/plugins/kindeditor/kindeditor.js"></script>
      <script src="/Public/plugins/kindeditor/lang/zh_CN.js"></script>
   </head>
   <script>
   $(function () {
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
   <body class='wst-page'>
    <?php if(in_array('dplb_01',$WST_STAFF['grant'])){ ?>
    <a class="btn btn-success glyphicon glyphicon-plus" href="<?php echo U('Admin/Drives/toEdit');?>" style='float:right'>新增</a>
    <?php } ?>
       <div class='wst-body'>
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='30'>序号</th>
               <th width='80'>自驾名称</th>
               <th width='80'>自驾天数</th>
               <th width='60'>时间价格</th>
               <th width='120'>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['root'])): $i = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td><?php echo ($i); ?></td>
                <td><?php echo ($vo["drivesName"]); ?></td>
                <td><?php echo ($vo['drivesDay']-1); ?>晚<?php echo ($vo['drivesDay']); ?>天自驾游</td>
                <td>
                <button id="calendar" name="calendar" readonly="readonly" onclick="AjaxTime(<?php echo ($vo[drivesId]); ?>);">查看价格榜</button>
                <button type="button" id="calendar" name="calendar" class="btn btn-info" onclick="addDrivesTimePrice(<?php echo ($vo[drivesId]); ?>)">价格添加</button>
                </td>
                <td>
                <?php if(in_array('dplb_02',$WST_STAFF['grant'])){ ?>
                  <a class="btn btn-primary glyphicon" href="<?php echo U('Admin/Drives/toEdit',array('drivesId'=>$vo[drivesId]));?>">修改</a>
                <?php } ?>
                <?php if(in_array('dplb_03',$WST_STAFF['grant'])){ ?>
                    <button type="button" class="btn btn-danger glyphicon glyphicon-pencil" onclick="javascript:changeStatus(<?php echo ($vo[drivesId]); ?>,0)">禁售</button>&nbsp;
                  <?php } ?>
                </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='5' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
      <div class="modal fade" id="drivesTimePrice" tabindex="-1" role="dialog" aria-labelledby="drivesTimePriceLabel">
        <div class="modal-dialog" role="document" style="margin-left: 20%">
          <div class="modal-content" style="width: 1000px">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="drivesTimePriceLabel">自驾日期价格</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <table class="table table-hover table-striped table-bordered wst-form">
                   <tr>
                     <th width='120' align='right'>成人价格<font color='red'>*</font>：</th>
                     <td><input id="drivesId" type="hidden" /><input type='text' id='adultPrice' class="form-control wst-ipt" maxLength='25'/></td>
                   </tr>
                   <tr>
                     <th width='120' align='right'>自驾库存<font color='red'>*</font>：</th>
                     <td><input type='text' id='drivesStock' class="form-control wst-ipt" value='' maxLength='25'/></td>
                   </tr>
                   <tr>
                     <th width='120' align='right'>自驾类型<font color='red'>*</font>：</th>
                     <td><input type='text' id='drivesType' class="form-control wst-ipt" value='' maxLength='25'/></td>
                   </tr>
                   <tr>
                   <th width='120' align='right'>日期选择<font color='red'>*</font>：</th>
                    <td>
                     <div class="form-group">
                      <input type="text" class="form-control wst-ipt" id="startDate" readonly="true" value="">
                    </div>
                    </td>
                   </tr>
                   <tr>
                     <th align='right'>酒店安排<font color='red'>*</font>：</th>
                     <td>
                     <textarea id='timeDesc' name='timeDesc' style='width:80%;height:400px;'></textarea>
                     </td>
                   </tr>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              <button type="button" class="btn btn-primary" onclick="addTP()">确认保存</button>
            </div>
          </div>
        </div>
      </div>
   </body>
   <link href="/DatePicker/css/datepicker.css" rel="stylesheet" />
   <script src="/DatePicker/js/zlDate.js"></script>
   <script>
   //查看时间价格
   function AjaxTime(id){
      $.get("<?php echo U('Admin/Drives/timePrice');?>",{drivesId:id},function(data) {
        pickerEvent.setPriceArr(eval("("+data+")"));
        pickerEvent.Init("calendar");
        pickerEvent.delTPUrl("<?php echo U('Admin/Drives/deltimePrice');?>");
      });
    }
    //时间选择
    $(document).ready(function() {
        $('#startDate').daterangepicker({singleDatePicker: true});
        updateConfig();

        function updateConfig() {
          var options = {};
          if ($('#startDate').val().length)
            options.startDate = $('#startDate').val();
        }
      });
    //时间价格
     function addDrivesTimePrice(id){
      $('#drivesTimePrice').modal('show');
      $('#drivesId').val(id);
     }
     //时间价格添加
      function addTP() {
        var params = {};
        params.drivesId = $('#drivesId').val();
        params.adultPrice = $('#adultPrice').val();
        params.drivesStock = $('#drivesStock').val();
        params.daydata = $('#startDate').val();
        params.timeDesc = $('#timeDesc').val();
        params.drivesType = $('#drivesType').val();
        $.ajax({
          url: "<?php echo U('Admin/Drives/addTimePrice');?>" ,
          type: "POST",
          async:false,
          data:params,
          dataType:'Json',
          success: function(data, textStatus, jqXHR ){
            if(data.status){
              WST.msg('保存成功!', {icon: 1});
              $('#drivesTimePrice').modal('hide');
              location.reload();
            }else{
              WST.msg(data.msg, {icon: 5});
              $('#drivesTimePrice').modal('hide');
            }
          } ,
          error: function(jqXHR, textStatus, errorMsg){
            console.log(jqXHR);
            console.log(errorMsg);
          }
        });
      }
      function changeStatus(drivesId,isSola){
        $.ajax({
          url: "<?php echo U('Admin/Drives/changeDrives');?>" ,
          type: "POST",
          async:false,
          data:{drivesId:drivesId,isSola:isSola},
          dataType:'Json',
          success: function(data, textStatus, jqXHR ){
            if(data.status){
              WST.msg('操作成功!', {icon: 1});
              location.reload();
            }else{
              WST.msg(data.msg, {icon: 5});
            }
          } ,
          error: function(jqXHR, textStatus, errorMsg){
            console.log(jqXHR);
            console.log(errorMsg);
          }
        });
      }
    </script>
</html>