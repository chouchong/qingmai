$(function(){
  var selectedID = "";
    var soNum = 0;
    $('.spinnerExample').spinner({});
    //初始出发人数点击
    _0('manNum');_0('childNum');_0('roomNum');
    //点击时间列表来选择时间
    $("#calendarprice div").live("click",function () {
        $('#manPrice').html(0);
        if (!$(this).hasClass("disabled")) {
            $(".selected").removeClass('selected');
            $(this).addClass("selected");
            var dataday = parseInt($(this).find(".dd").html());
            if(dataday<10){
                dataday = '0'+dataday;
            }
            $('#selectedDay').val($("#currentMonth").html()+'-'+dataday);
            $.ajax({
                url:'/Mobile/Drives/getTp',
                type:"post",
                dataType:"json",
                async:true,
                data:{
                    timeId:$('.selected').find("span").html()
                },
                success:function(data){
                    $('#drivesType').html(data.drivesType);
                    $('#tpadultPrice').html(data.adultPrice);
                    $('#timeDesc').html(data.timeDesc);
                    $('#manPrice').html(data.adultPrice);
                    $('#timeId').val(data.timeId);
                }
              });
            //点击时间列表来初始化出发人数
            _click_num('manNum');_click_num('childNum');_click_num('roomNum');
            //初始出发人数点击
            _0('childNum');_0('roomNum');$("#manNum").prev().attr('disabled', 'disabled');
            //获取出发出发人数
            soGetNum($('.selected').find("p:eq(2)").html());
            //总价清空
            $('#totalPrice').html(0);
        }
    });
    //点击+ 改变出发人数
    _click('manNum');_click('childNum');_click('roomNum');
    // 显示 隐藏卡片内容
    $(".ion-chevron-down").live("click",(function(event) {
        $(this).removeClass('ion-chevron-down');
        $(this).addClass('ion-chevron-up');
         $(this).parent().next().show();
    }));
    $(".ion-chevron-up").live("click",(function(event) {
        $(this).removeClass('ion-chevron-up');
        $(this).addClass('ion-chevron-down');
         $(this).parent().next().hide();
    }));
    //获取出发人数函数
    function soGetNum(so){
        if(so!='售罄' && so!="已售"){
          soNum = so.replace(/[^0-9]/ig,"");
        }else{
            _0('manNum');_0('childNum');_0('roomNum');
        }
    }
    //出发人数初始化函数
    function _0(id){
        $("#"+id).val(0);
        $("#"+id).next().attr('disabled', 'disabled');
        $("#"+id).prev().attr('disabled', 'disabled');
    }
    //点击时间列表 人数初始化函数
    function _click_num(id){
        $("#"+id).val(0);
        if(id=='roomNum'){
            $("#roomNum").next().attr('disabled', 'disabled');
        }else{
            $("#"+id).next().removeAttr('disabled');
        }
    }
    //点击时间列表 点击函数
    function _click(id){
        $("#"+id).parent().click(function(){
            if(id=='manNum'){
                if(parseInt($("#"+id).val())==0){
                   _0('childNum');
                   _0('roomNum');
                }
                else if(parseInt($("#"+id).val())==1){
                    $("#roomNum").next().attr('disabled', 'disabled');
                    if($("#childNum").val()>$("#"+id).val()){
                        $("#childNum").val($("#manNum").val());
                    }
                    $("#childNum").next().removeAttr('disabled');
                }
                else if($("#childNum").val()>$("#"+id).val()){
                    $("#childNum").next().attr('disabled', 'disabled');
                    $("#childNum").val($("#manNum").val());
                }
                else if($("#"+id).val()==soNum){
                    $("#"+id).next().attr('disabled', 'disabled');
                }else{
                    $("#"+id).next().removeAttr('disabled');
                    $("#roomNum").next().removeAttr('disabled');
                    $("#childNum").next().removeAttr('disabled');
                }
                if(/^\d+\.\d+$/.test(parseInt($("#"+id).val())/2)==true){
                    $('#roomPrice').parent().css('display','block');
                }else{
                    $('#roomPrice').parent().css('display','none');
                }
                $("#roomNum").val(Math.ceil(parseInt($("#"+id).val())/2));
            }else{
                if(id=='roomNum'){
                    if($("#roomNum").val()>parseInt($("#manNum").val())/2){
                        $('#roomPrice').parent().css('display','block');
                    }
                    if(Math.ceil($("#manNum").val()/2)==parseInt($("#roomNum").val())){
                        $("#roomNum").prev().attr('disabled', 'disabled');
                        $('#roomPrice').parent().css('display','none');
                    }
                    if($("#roomNum").val()<Math.ceil($("#manNum").val()/2)){
                        $("#roomNum").val(Math.ceil($("#manNum").val()/2));
                        $("#roomNum").prev().attr('disabled', 'disabled');
                    }
                }
                if($("#"+id).val()==$("#manNum").val()){
                    $("#"+id).next().attr('disabled', 'disabled');
                }else{
                    $("#"+id).next().removeAttr('disabled');
                }
            }
            var roomtotalPrice = (parseInt($("#roomNum").val())*2 - parseInt($("#manNum").val()))*parseInt($('#roomPrice').html());
            var totalPrice = parseInt($('#manPrice').html())*parseInt($("#manNum").val());
            var childtotalPrice = parseInt($('#childPrice').html())*parseInt($("#childNum").val());
            $('#totalPrice').html(childtotalPrice+totalPrice+roomtotalPrice);
        });
    }
})