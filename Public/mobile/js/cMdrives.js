$(function(){
  var i = 0;
 $('#addZcode').live("click", function(event) {
    var men = parseInt($("#manNum").html());
     $("#allZcodePrice").parent().show();
    if (men  > $('#Zcode input').size()) {
        var myZcode = 'myZcode'+ (i++) ;
        $("#ZcodeAdd").after('<div class="item item-input padding "><input class="aZcode" type="text" placeholder="请输入您的Z码" id="'+myZcode+'"><span class="aZcodePrice"></span></div>');
    }
});
$(".whatZcode").click(function(){
    $(".detailZcode").show();
});
$('.aZcode').live("keyup", function(event) {
        // console.log("O1460364081".length);
        var currZ = $(this).val();
        var n = 0;
        var _t = $(this);
        var price =0;
        var totalMoney = $('#totalMoney').html();
        var totalPrice = $('#totalPrice').html();
        if (currZ != "") {
            $(".aZcode").each(function() {
                if (currZ == $(this).val()) {
                    n++;
                }
            });
        }
        if (currZ == "") {
            _t.val("");
            _t.attr("placeholder", "请输入您的Z码");
            _t.next().html("");
        } else if (n == 1) {
            if(currZ.length>=3){
            $.ajax({
              url: '/Mobile/Coupons/checkZcode',
              type: "POST" ,
              async:false,
              data:{
                'myZcode':currZ
              },
              dataType:'Json',
              success: function(data, textStatus, jqXHR ){
                if(data.status>0){
                    _t.next().html(data.couponsPrice);
                    total();
                }else{
                    _t.attr("placeholder", "请输入您的Z码");
                    _t.next().html("Z码无法使用！");
                }
              } ,
              error: function(jqXHR, textStatus, errorMsg){
                console.log(jqXHR);
                console.log(errorMsg);
              }
            });
            }else{
                _t.attr("placeholder", "请输入您的Z码");
                _t.next().html("Z码无法使用！");
                total();
            }
        } else {
            _t.attr("placeholder", "Z码不能重复");
            _t.next().html("重复！");
        }
    });
var totalMoney = $('#totalMoney').html();
function total(){
    var totalZcode = 0;
    var zcode = [];
     $(".aZcode").each(function() {
        var zcm = parseInt($(this).next().html());
        if(zcm>0){
           totalZcode +=zcm;
           zcode.push($(this).val());
        }
    });
    $('#allzcodes').val(zcode.join(","));
    $('#allZcodePrice').html(totalZcode);
    $('#totalPrice').html(parseInt(totalMoney)-totalZcode);
}
})