$(function(){
  $('.spinnerExample').spinner({});
    $(".scenicShops button").click(function(event) {
        $(".scenicShops .button-calm").addClass("button-outline");
        $(".scenicShops .button-calm").removeClass("button-calm");
        $(this).addClass("button-calm");
        $(this).removeClass("button-outline");
    });
    $(".scenictimes button").click(function(event) {
        $(".scenictimes .button-calm").addClass("button-outline");
        $(".scenictimes .button-calm").removeClass("button-calm");
        $('#manPrice').html($(this).find('input').val());
        $('#totalPrice').html(0);
        _0('manNum');_0('childNum');
        $(this).addClass("button-calm");
        $(this).removeClass("button-outline");
    });
    var selectedDate ;
    $(".dateSelect").live("click", function() {
       var todayDate = new Date($("#today").html().replace(/-/g, '/'));
        var dateSelectDay = new Date($(this).children(".dateSelectDay").attr("id").replace(/-/g, '/'));
        var time = dateSelectDay - todayDate.getTime() ; //日期的long型值之差
        if(Math.floor(time/(24*60*60*1000)) >= 3){
            $(".selected").removeClass("selected");
            $(this).children(".dateSelectDay").addClass("selected");
            selectedDate = dateSelectDay;
        }
        var dataday = $(this).children(".dateSelectDay").html();
        if(dataday<10){
            dataday = '0'+dataday;
        }
        $('#selectedDay').val($("#currentMonth").html()+'-'+dataday);
    });
    _click('manNum');_click('childNum');
    //点击时间列表 点击函数
    function _click(id){
        $("#"+id).parent().click(function(){
            var manPrice = $('#manPrice').html()*$("#manNum").val();
            var childtotalPrice = $('#childPrice').html()*$("#childNum").val();
            var totalPrice = parseFloat(manPrice) + parseFloat(childtotalPrice);
            $('#totalPrice').html(totalPrice.toFixed(2));
        });
    }
    //出发人数初始化函数
    function _0(id){
        $("#"+id).val(0);
        $("#"+id).prev().attr('disabled', 'disabled');
    }
})