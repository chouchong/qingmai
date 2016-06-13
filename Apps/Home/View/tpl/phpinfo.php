<extend name="tpl:base" />
<block name="title">
    <title>{$drive.drivesName}</title>
    <meta name="keywords" content="{$drive['drivesKeywords']}" />
    <meta name="description" content="{$drive['drivesSpec']}" />
</block>
<block name="css"></block>
<block name="main">
    <nav class="navbar navbar-default header_subpage">
        <include file="tpl:comnav" />
    </nav>
<div ng-app="myapp" ng-controller="orderConfirmCtrl">
    <div class="od_content">
        <div class="od_head">
            <div class="od_title">
                <h2>请确认您的订单信息{{name}}</h2>
            </div>
        </div>
        <div class="od_form">
            <div class="od_forml">
                <div class="odf_main">
                <input type="hidden" id="orderNo" value="{$orders['orderNo']}">
                <input type="hidden" id="orderId" value="{$orders['orderId']}">
                    <span id="odf_name">{$orders['goodsName']}</span>
                    <span id="odf_price">{$orders['adultPrice']}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span id="odf_style">{$orders['drivesType']}</span>
                    <p><span>{$orders['drivesTo']}</span><span style="float: right;">6晚7天跨境自驾自由行</span></p>
                    <!--  <p>出发时间：<span>2015-15-13</span></p>
                    <p>出发时间：<span>2015-15-13</span></p> -->
                    <hr>
                </div>
                <div class="odf_xc">
                    <!--  -->
                    <div id="timeDesc">
                    {$orders['goodsDrvivesTime']|htmlspecialchars_decode}
                    </div>
                </div>
                <div class="" style="font-size: 18px;background-color: rgb(109, 197, 219);padding: 10px 20px;color: #fff;    margin: 0 -20px;">
                    <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;开始完善表单信息吧！
                </div>
                <div class="odf_lxr">
                    <div id="odf_uselxr" class="odf_lxrs" ng-show="addRess">
                        <h4>默认联系人</h4>
                        <input type="hidden" id="addressId" value="{{addRess.addressId}}">
                        <p style="margin:8px 15px;"><span ng-bind="addRess.userName"></span><span style="float:right" ng-bind="addRess.userPhone"></span></p>
                        <p style="margin:8px 15px;"><span ng-bind="addRess.userPhone"></span><span style="float:right" ng-bind="addRess.userEmail"></span></p>
                    </div>
                    <div class="odf_lxrbtn">
                        <div class="checkbox" style="float:right;">
                            <label>
                                <input id="odf_check" type="checkbox" checked="true"> <span>使用默认联系人</span>
                            </label>               
                        </div>
                    </div>
                    <!-- <h4>联系人信息</h4> -->
                    <form id="odf_addlxr" class="form-horizontal" style="display:none;" name="orderForm" novalidate>
                        <div class="form-group" ng-class="{'has-error':orderForm.name.$dirty && orderForm.name.$invalid}">
                            <label for="inputEmail3" class="col-sm-3 control-label" >联系人</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputEmail3" placeholder="联系人" ng-model="userAddress.name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{'has-error':orderForm.phone.$dirty&&orderForm.phone.$invalid}">
                            <label for="inputPassword3" class="col-sm-3 control-label">联系电话</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" id="inputPassword3" placeholder="联系电话" ng-model="userAddress.phone" name="phone" ng-pattern="/^1\d{10}$/" required>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{'has-error':orderForm.email.$dirty && orderForm.email.$invalid}">
                            <label for="inputPassword3" class="col-sm-3 control-label">联系人电子邮件</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="inputPassword3" placeholder="联系人电子邮件" ng-model="userAddress.email" name="email" required>
                            </div>
                        </div>
                        <div class="form-group" ng-class="{'has-error':orderForm.address.$dirty && orderForm.address.$invalid}">
                            <label for="inputPassword3" class="col-sm-3 control-label">联系人地址</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputPassword3" placeholder="联系人地址" ng-model="userAddress.address" name="address" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="od_forml">
                <div class="odf_l">
                    成人<span class="odf_lr"><span id="adultNum">{$orders['adultNum']}</span>人x<span>{$orders['adultPrice']}</span>元/人</span>
                </div>
                <hr>
                <div class="odf_l">
                    儿童数<span class="odf_lr"><span>{$orders['childNum']}</span>人x<span>{$orders['childPrice']}</span>元/人</span>
                </div>
                <hr>
                <div class="odf_l">
                    房间数<span class="odf_lr"><span>{$orders['roomNum']}</span></span>
                </div>
                <hr>
                <div class="odf_l">
                    单房差<span class="odf_lr"><span>{$orders['roomPrice']}</span></span>
                </div>
                <hr>
                <div class="odf_l">
                    合计总价<span class="odf_lr"><span id="odf_prices">{$orders['totalMoney']}</span></span>
                </div>
                <hr>
                <div class="" style="padding:10px;">
                    <p style="line-height: 150%;">全程酒店为标准双床房，如需安排标准大床房请勾选，我社工作人员将根据酒店情况尽量为您安排，但不保证能满足您的要求，敬请谅解！</p>
                  <label class="checkbox-inline">
                        <input type="checkbox" id="inlineCheckbox1">尽量安排大床房
                    </label>
                </div>
                <hr>
                    <textarea class="form-control" name="" placeholder="留言备注！" ng-model="orderNews.orderDesc"></textarea>

                <hr>
                <div class="odf_zcode">
                    <div class="">
                        我有Z码
                        <span class="glyphicon glyphicon-plus" style="float:right; margin-right: 20px;"></span>
                        <!-- <button class="glyphicon glyphicon-plus" style="float:right;"></button> -->
                    </div>
                    <hr id="asdfsd" style="clear:both;display:none;">
                    <div id="odfz_codes" style="overflow:hidden; clear:both">

                    </div>
                    <div class="odf_zcodepr" style="display: none;">
                        <hr style="clear:both">
                        <p>共计优惠：<span style="float:right;color:red;" id="codePrice"></span></p>
                    </div>
                </div>
                <hr style="clear:both;margin-top:0;">
                <div class="" style="padding:0 10px;">
                    <label class="checkbox-inline">
                        <input type="checkbox"  id="inlineCheckbox2">我已阅读《产品订购协议》
                    </label>
                </div>
            </div>
        </div>
        <div class="od_submit">
            <div class="od_price">
                <span id="od_prices">{$orders['totalMoney']}</span>
            </div>
                <button class="btn od_submitb" ng-click="nowPay()">立即支付</button> 
        </div>
    </div>
</div>
    <include file="tpl:footer"/>
</block>
<block name="js">
    <script src="__PUBLIC__/home/layer/layer.min.js" type="text/javascript"></script>
    <script>  
    function totalMoney(){
        var totalMoney = 0;
        $("#odfz_codes .col-sm-3").each(function(){ 
            var codesPrice = $(this).html();
            if(codesPrice > 0){
               totalMoney += parseInt(codesPrice);
            } 
        });
        $("#codePrice").html(totalMoney);
        $("#odf_prices").html();
        $("#od_prices").html($("#odf_prices").html()-$("#codePrice").html());
    }

    function k(obj){
        var currZ = $(obj).val();
        var n = 0;
        var _t = $(obj);
        if (currZ != "") {
            $("#odfz_codes input").each(function() {
                if (currZ == $(this).val()) {
                    n++;
                }
            });
        }
        if (currZ == "") {
            _t.val("");
            _t.attr("placeholder", "请输入您的Z码");
            _t.parent().next().html("");
            totalMoney();
        } else if (n == 1) {
            if(currZ.length>=3){
                $.ajax({
                    type: "POST",
                    url: "{:U('Home/Orders/coupons')}",
                    data: {codes:_t.val()},
                    dataType: "json",
                    success:function(data){
                        if(data['status'] > 0){
                            _t.parent().next().html(data['codePrice']);
                            totalMoney();
                        }else{
                            _t.parent().next().html('优惠码不存在');
                            totalMoney();
                        }
                    }
                })
            }else{
                _t.attr("placeholder", "请输入您的Z码");
                _t.parent().next().html("Z码无法使用");
                totalMoney();
            }
        } else {
            _t.attr("placeholder", "Z码不能重复");
            _t.parent().next().html("重复!");
            totalMoney();
        }
    }

    $(function() {
        diverorder_heightchange();
    });
    $(".glyphicon-plus").click(function() {
        if ($("#odfz_codes").children().length < $("#adultNum").html()) {
            $(".odf_zcodepr").show();
            $("#asdfsd").show();
            $("#odfz_codes").append('<div class="form-group odf_zcodes"><div class ="col-sm-9" ><input type="text" class = "form-control"   placeholder = "输入Z码"  onkeyup="k(this);"> </div> <span class = "col-sm-3" for = "" ></span> </div>');        
        }
        diverorder_heightchange();
    });

// alert($("#odf_check").prop("checked"));
    </script>
</block>
