(function(){
'use strict';
 angular.module('myapp', [])
 .config(['$httpProvider', function ($httpProvider) {
    // 设置post时使用urlencode编码方式;
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    // 设置x-requested-with 请求头, 宁服务器端判定为ajax请求;
    $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
    // 请求时判断数据是否为object或数组， 如果是则将对象序列化；
    $httpProvider.defaults.transformRequest = function (data) {
    return angular.isObject(data) && String(data) !== '[object File]' ? jQuery.param(data) : data;
    }
}])
.run(function($rootScope,Storage){
  $rootScope.comLogin = function(){
    Storage.set('url',window.location.href);
    window.location.href = '/login.html';
  }
  $rootScope.comReg = function(){
    Storage.set('url',window.location.href);
    window.location.href = '/register.html';
  }
})
.controller('regCtrl',['$scope','serviceHttp','Storage','$interval',function($scope,serviceHttp,Storage,$interval){
  $scope.checkbox = $("#checkbox").prop('checked');
  $scope.text="发送验证码";
  var iNow=60;
  $scope.fash = false;
  $scope.textClass = "btn-info";
  $scope.smsClass=function(){
      var timer = $interval(function () {
      $scope.fash = true;
      iNow--;
      $scope.text = iNow + '秒后重新发送';
      $scope.textClass = "";
      if(iNow==0){
        $interval.cancel(timer);
        $scope.text = '重新发送';
        $scope.fash = false;
        iNow = 60;
        $scope.textClass = "btn-info";
        }
      },1000);
  }

  $scope.sms = function()
  {
    $scope.smsClass();
    serviceHttp.smsSend($scope.user.phone)
    .success(function(data){
      layer.msg('验证码已发送，请注意查收');
    }).error(function(data){
        layer.msg('验证码获取失败');
    });
  }
  $scope.doreg = function(){
    serviceHttp.UserAdd($scope.user)
    .success( function(data){
      if(data['status'] == 1){
        layer.msg(data['msg']);
        window.location.href = Storage.get('url');
        Storage.remove('url');
      }
      if(data['status'] == -3){
        layer.msg(data['msg']);
      }
      if(data['status'] == -4){
        layer.msg(data['msg']);
      }
      if(data['status'] == -1){
        layer.msg(data['msg']);
      }
    })
    .error(function(data){
      layer.msg('注册失败');
    })
  };
  $scope.atShow = function(){
    serviceHttp.getArticle({articleId:33}).success(function(data){
      $scope.art = data;
      $('#atModal').modal('show');
    });
  }
}])
.controller('lostpasswordCtrl',['$scope','serviceHttp','$interval',function($scope,serviceHttp,$interval){
  $scope.text="发送验证码";
  var iNow=60;
  $scope.fash = false;
  $scope.textClass = "btn-info";
  $scope.smsClass=function(){
      var timer = $interval(function () {
      $scope.fash = true;
      iNow--;
      $scope.text = iNow + '秒后重新发送';
      $scope.textClass = "";
      if(iNow==0){
        $interval.cancel(timer);
        $scope.text = '重新发送';
        $scope.fash = false;
        iNow = 60;
        $scope.textClass = "btn-info";
        }
      },1000);
  }
  $scope.sms=function(){
    $scope.smsClass();
    serviceHttp.getPhone($scope.user.phone)
    .success(function(data){
      if(data['status'] == 1){
        serviceHttp.smsSend($scope.user.phone)
        .success(function(data){
          layer.msg('验证码已发送，请注意查收');
        })
        .error(function(data){
          layer.msg('验证码获取失败');
        });
      }
      if(data['status'] == -1){
        layer.msg('您尚未注册,请先注册');
        window.location.href="/register.html";
      }
    })
    .error(function(data){
      layer.msg('验证码获取失败');
    });
  }
  $scope.setpassword=function(){
    serviceHttp.setpassword($scope.user)
    .success(function(data){
      if(data['status'] == 1){
        layer.msg(data['msg']);
        window.location.href="/login.html";
      }
      if(data['status'] == -3){
        layer.msg(data['msg']);
      }
    })
    .error(function(data){
      layer.msg('提交失败');
    })
  }
  }])
.controller('loginCtrl',['$scope','serviceHttp','$interval','Storage',function($scope,serviceHttp,$interval,Storage){
  $scope.text="发送验证码";
  var iNow = 60;
  $scope.fash = false;
  $scope.textClass = "btn-info";
  $scope.smsClass = function(){
      var timer = $interval(function () {
      $scope.fash = true;
      iNow--;
      $scope.text = iNow + '秒后重新发送';
      $scope.textClass = "";
      if(iNow==0){
        $interval.cancel(timer);
        $scope.text = '重新发送';
        $scope.fash = false;
        iNow = 60;
        $scope.textClass = "btn-info";
        }
      },1000);
  }
  $scope.sms=function(){
    $scope.smsClass();
    serviceHttp.getPhone($scope.user.phone)
    .success(function(data){
      if(data['status'] == 1){
        serviceHttp.smsSend($scope.user.phone)
        .success(function(data){
          layer.msg('验证码已发送，请注意查收');
         })
        .error(function(data){
          layer.msg('验证码获取失败');
        });
      }
      if(data['status'] == -1){
        layer.msg('您尚未注册,请先注册');
        window.location.href="/register.html";
      }
    })
    .error(function(data){
      layer.msg('请求失败');
    });
  }
  $scope.userLogin=function(){
    serviceHttp.userLogin($scope.user)
    .success(function(data){
      if(data['status'] == 1){
        layer.msg('登录成功');
        if(Storage.get('url')){
          window.location.href= Storage.get('url');
          Storage.remove('url');
        }else{
           window.location.href= '/index.html';
        }
      }
      if(data['status'] == -1){
        layer.msg('登录失败');
      }
    })
    .error(function(data){
      layer.msg('登录失败');
    })
  }
}])
.controller('IndexCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  $scope.page = 0;
  $scope.dMoreCon = "加载更多";
  $scope.dlist = [];
  $scope.dMore = function(){
    serviceHttp.getDList({page:++$scope.page}).success(function(data) {
      if (data != "null") {
        $scope.dlist = $scope.dlist.concat(data);
      }else {
        $scope.dMoreCon = "加载完成";
      }
    });
  };
}])
.controller('driveCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  $scope.addGoTime = function(){
    serviceHttp.addGoTime($scope.goTime).success(function(data){
      if(data.status>0){
        $('#diyModal').modal('hide');
        layer.msg('报名成功,请等待客户的电话');
      }else{
        layer.msg('报名失败');
      }
    });
  };
  $scope.goplaces = {};
  serviceHttp.getgoPlace().success(function(data) {
    $scope.goplaces = data;
  });
  $scope.hotelModal = function(hotelId){
    serviceHttp.getHotel(hotelId).success(function(data) {
      $scope.hotel = data;
      $('#hotelModal').modal('show');
    })
  };
  $scope.visa = function(v,d){
    window.location.href = '/v/'+v+'/'+d+'.html';
  };
  $scope.pageAp = 0;
  $scope.dMoreAp = "更多评论";
  $scope.apList = [];
  $scope.apMore = function(drivesId){
    serviceHttp.getApList({drivesId:drivesId,page:++$scope.pageAp}).success(function(data) {
      if (data.ap.length != 0) {
        $scope.apList = $scope.apList.concat(data.ap);
      }else {
        $scope.dMoreAp = "加载完成";
      }
    });
  };
  $scope.drive = {};
  $scope.dAddBuy = function(){
      if($('#timeId').val() == ""){
          layer.msg('请选择出发日期');
        }else if(parseInt($('#manNum').val()) == 0){
          layer.msg('请选择出发人数');
        }else{
          serviceHttp.isLogin().success(function(data){
            if(data.status>0){
              $scope.drive.drivesId = $('#drivesId').val();
              $scope.drive.drivesDay = $('#drivesDay').html();
              $scope.drive.childPrice = $('#childPrice').html();
              $scope.drive.goodsThums = $('#drivesImg').attr('src');
              $scope.drive.drivesFrom = $('#drivesFrom').html();
              $scope.drive.goodsName = $('#drivesName').html();
              $scope.drive.drivesType = $('#drivesType').html();
              $scope.drive.timeDesc = $('#xc_timeDesc').html();
              $scope.drive.manPrice = $('#selectAdultPrice').html();
              $scope.drive.roomNum = $("#roomNum").val();
              $scope.drive.manNum = $('#manNum').val();
              var homePrice = $('#roomPrice').html();
              $scope.drive.homePrice = homePrice>0?homePrice:0;
              $scope.drive.childNum = $('#childNum').val();
              $scope.drive.totalPrice = $('#df_totelprice').html();
              $scope.drive.orderType = 1;
              $scope.drive.goodsDrvivesTime = $('#xc_timeDesc').html();
              $scope.drive.selectday = $('#df_seldate').html();
              $scope.drive.timeId = $('#timeId').val();
              $scope.drive.drivesIsCross = $('#drivesIsCross').val();
              serviceHttp.drivesForm($scope.drive)
                .success(function(data){
                  if(data['status']>0){
                    window.location.href = "/o/"+data['orderId']+'.html';
                  }else{
                    layer.msg('系统错误');
                  }
                });
            }else{
              layer.msg('您尚未登录,登录了才能预定');
            }
          })
      }
  };
}])
.controller('VisaCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  $scope.visa = {};
  $scope.visaNews = function(){
   serviceHttp.isLogin().success(function(data){
      if(data.status>0){
        $scope.visa.manNum = $("#manNum").val();
        $scope.visa.visaId = $("#visaId").html();
        $scope.visa.visaPrice = $("#visaPrice").html();
        $scope.visa.visaName = $("#visaName").html();
        var addressId = $scope.addRess.addressId;
        var check = $('input:checkbox').prop("checked");
        if($scope.visa.manNum > 0){
          if(check == true){
            if($scope.visaAddress.$invalid || $scope.visaAddress.$error.required){
                 layer.msg('请填写完整联系人信息');
            }else{
              serviceHttp.visaAddress($scope.visa)
              .success(function(data){
                if(data.status > 1){
                  window.location.href = '/p/'+data.orderId+'.html';
                }
              })
            }
          }else if(check == false && addressId == 0){
             layer.msg('请填写完整联系人信息');
          }else if(check == false && addressId > 0){
            $scope.visa.addressId = addressId;
            serviceHttp.visaAddress($scope.visa)
            .success(function(data){
              if(data.status > 1){
                window.location.href = '/p/'+data.orderId+'.html';
              }
            })
          }
        }else{
          layer.msg('办理签证人数不能为空');
        }
      }else{
        layer.msg('您尚未登录,登录了才能预定');
      }
    })
  }
  serviceHttp.getUserAddress().success(function(data) {
    $scope.addRess = data;
    if ($scope.addRess == null) {
      $("#isDef").hide();
      $(".vc_lxr").show();
      $('input:checkbox').attr('checked',true);
    }else{
      $("#isDef").show();
      $(".vc_lxr").hide();
      visa_heightchange();
      $('input:checkbox').attr('checked',false);
    }
  });
  $scope.addAddressShow = function(){
    if ($('input:checkbox').is(':checked')==false) {
      $("#isDef").hide();
      $(".vc_lxr").show();
      $('input:checkbox').attr('checked',true);
    }else{
      $("#isDef").show();
      $(".vc_lxr").hide();
      $('input:checkbox').attr('checked',false);
    }
  }
}])

.controller('goodsCtrl',['$scope','serviceHttp',function($scope,serviceHttp){

  serviceHttp.getUserAddress().success(function(data) {
    $scope.addRess = data;
    if ($scope.addRess == null) {
      $("#usemrlxr").hide();
      $("#addmrlxr").show();
      scenic_heightchange();
      $('#ismrlxr').attr('checked',false);
    }else{
      $("#usemrlxr").show(0,function(){
        setTimeout(function(){scenic_heightchange()},100);
      });
      $("#addmrlxr").hide();      
      $('#ismrlxr').attr('checked',true);
    }
  });
        // 选择套餐分店
      $(".sf_tcs").click(function(){
          $(".sf_tcc").children(".active").removeClass('active');
          $(this).addClass("active");
            $('#manPrice').html($(this).find('input').val());
            $("#ticketVal").val($(this).find('span').html());
            $("#ticketPrice").val($(this).find('input').val());
      });
      $(".sf_fds").click(function(){
          $(".sf_fdc").children(".active").removeClass('active');
          $(this).addClass("active");
          $("#ticketFendian").val($(this).children().first().html());
      });
  $scope.ticket = {};
  $scope.goodOrAdd = function(){
    serviceHttp.isLogin().success(function(data){
      if(data.status>0){
        $scope.ticket.goodsId = $("#goodsId").val();
        $scope.ticket.goodsThums = $(".s_descimg img").attr("src");
        $scope.ticket.goodsName = $(".s_descimg img").attr("alt");
        $scope.ticket.toTime = $("#goodSelectTime").val();
        $scope.ticket.ticketVal = $("#ticketVal").val();
        $scope.ticket.ticketPrice = $("#manPrice").html();
        $scope.ticket.ticketFendian = $("#ticketFendian").val();
        $scope.ticket.totalPrice = $("#sf_price").html();
        $scope.ticket.adultNum = $("#manNum").val();
        // $scope.ticket.adultPrice = $("#manPrice").html();
        $scope.ticket.childNum = $("#childNum").val();
        $scope.ticket.childPrice = $("#childPrice").html();
        var check =  $("#ismrlxr").prop("checked");
        var addressId = $("#addressId").val();
        if($scope.ticket.ticketVal == ''){
          layer.msg('请选择套餐');
        }
        if($(".sf_fds span").html() == ''){
          if($scope.ticket.ticketFendian == ''){
           layer.msg('请选择分店');
          }
        }
        if($("#manNum").val() == 0){
          layer.msg('成人数需大于1');
        }
        else if(check == false){
            if($scope.goodAddress.$invalid || $scope.goodAddress.$error.required){
                 layer.msg('请填写完整联系人信息');
            }else{
              serviceHttp.goodAddress($scope.ticket)
              .success(function(data){
                if(data.status > 1){
                  window.location.href = '/p/'+data.orderId+'.html';
                }
              })
              console.log($scope.ticket);
            }
        }else if(check == true && addressId > 0){
            $scope.ticket.addressId = $("#addressId").val();
            serviceHttp.goodAddress($scope.ticket)
            .success(function(data){
              if(data.status > 1){
                window.location.href = '/p/'+data.orderId+'.html';
              }
            })
            console.log($scope.ticket);
        }
      }
      else{
        layer.msg('您尚未登录,登录了才能预定');
      }
    })
  }
}])
// 用户中心
.controller('doReNameCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  $scope.userName = '';
  $scope.doreName=function(){
    serviceHttp.reName($scope.userName)
    .success(function(data){
      if (data['status'] > 0) {
         layer.msg('昵称修改成功');
         window.location.href = '/u.html';
      }
      else{
        layer.msg('昵称修改失败');
      }
    })
  }
}])
.controller('usersetCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  serviceHttp.uclxrShow()
  .success(function(data){
      $scope.usershow = data;
  });
  $scope.userDefault = function(id){
    serviceHttp.userDefault({addressId:id})
    .success(function(data){
      if(data['status'] == 1){
        serviceHttp.uclxrShow()
        .success(function(data){
            $scope.usershow = data;
      })
    }
    })
  }
  $scope.userAddressRemove = function(id){
    serviceHttp.userAddressRemove({addressId:id})
    .success(function(data){
      if(data['status'] == 1){
        serviceHttp.uclxrShow()
        .success(function(data){
            $scope.usershow = data;
      })
    }
    })
  }
  $scope.user = {};
  $scope.uclxr = function(){
    serviceHttp.uclxr($scope.user)
    .success(function(data){
      if(data['status'] == 1){
        layer.msg('添加联系人成功');
        serviceHttp.uclxrShow()
        .success(function(data){
            $scope.usershow = data;
            $scope.user = {};
            $(".uclxr_forms").toggle();
        })
      }
    })
  }
}])
.controller('orderConfirmCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  $scope.coAtShow = function(){
    serviceHttp.getArticle({articleId:32}).success(function(data){
      $scope.art = data;
      $('#coatModal').modal('show');
    });
  }
  serviceHttp.getUserAddress().success(function(data) {
    $scope.addRess = data;
    if (data == null) {
        $("#odf_uselxr").hide();
        $("#odf_addlxr").show();
        diverorder_heightchange();
        $('#odf_check').attr('checked',false);
        $scope.orderNews.addressId = 0;
    }else{
        $("#odf_uselxr").show(0,function(){
          setTimeout(function(){diverorder_heightchange()},100);
        });
        $("#odf_addlxr").hide();
        $('#odf_check').attr('checked',true);
        $scope.orderNews.addressId = data.addressId;
    }
  });
  $("#odf_check").click(function() {
    if (!$("#odf_check").is(":checked")) {
        $("#odf_uselxr").hide();
        $("#odf_addlxr").show();
        $scope.orderNews.addressId = 0;
    } else {
        $("#odf_uselxr").show();
        $("#odf_addlxr").hide();
        $scope.orderNews.addressId = $("#addressId").val();
    }
    diverorder_heightchange();
  });
  $scope.orderNews = {};
  $scope.orderNews.code = [];
  $scope.orderNews.orderNo = $("#orderNo").val();
  $scope.orderNews.orderId = $("#orderId").val();
  $scope.nowPay = function(){
    $scope.orderNews.userAddress = $scope.userAddress;
    $scope.orderNews.totalPrice = $("#od_prices").html();
    $scope.orderNews.codePrice = $("#codePrice").html();
    $scope.orderNews.isBig = $("#inlineCheckbox1").prop("checked");
    $scope.orderNews.isRead = $("#inlineCheckbox2").prop("checked");
    if($scope.orderNews.isBig == true){
      $scope.orderNews.isBig = 1;
    }
    else{
      $scope.orderNews.isBig = 0;
    }
    if($scope.orderNews.isRead == true){
      $scope.orderNews.isRead = 1;
    }
    else{
      $scope.orderNews.isRead = 0;
    }
    var codes = [];
    $("#odfz_codes input").each(function(){
      var codeM = $(this).parent().next().html();
      if(codeM>0){
        codes = codes.concat($(this).val());
      }
    });
    $scope.orderNews.codes = codes;
    if($scope.orderNews.addressId > 0){
      if($scope.orderNews.isRead == false){
          layer.msg('请阅读《产品订购协议》');
      }else{
      serviceHttp.payNews($scope.orderNews)
        .success(function(data){
          if(data.status > 0){
            window.location.href = '/p/'+data.orderId+'.html';
          }
        })
      }
    }else{
      if($scope.orderForm.$invalid  || $scope.orderForm.$error.required){
        layer.msg('请完整填写联系信息');
      }else{
        if($scope.orderNews.isRead == false){
         layer.msg('请阅读产品订购协议');
        }else{
        serviceHttp.payNews($scope.orderNews)
          .success(function(data){
            if(data.status > 0){
            window.location.href = '/p/'+data.orderId+'.html';
            }
          })
        }
      }
    }
  }
}])
.controller('payCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  $scope.payType = 0;
  $(".p_ways").click(function(){
      $("img[src='/Public/home/img/select.png']").attr("src","/Public/home/img/unselect.png");
      $(this).find(".p_waysel img").attr("src","/Public/home/img/select.png");
      switch($(this).attr("id"))
      {
      case 'pw_wx':
        $scope.payType = 1;
        break;
      case 'pw_yl':
        $scope.payType = 2;
        break;
      case 'pw_zfb':
        $scope.payType = 3;
        break;
      default:
        $scope.payType = 0;
      }
  });
  $scope.toPay = function(){
    if($scope.payType == 0){
      layer.msg('请选择支付方式');
    }else{
      serviceHttp.editPayment({
        orderId: $('#orderId').val(),
        payment: $scope.payType,
        adultNum: $('#adultNum').html()
      }).success(function(data) {
        if (data.status == -1) {
          layer.msg('支付失败')
        }else if (data.status == 2){
          layer.msg('库存只有'+data.num);
        }else{
          if($scope.payType == 1){
            window.location.href = '/wx/'+$('#orderId').val()+'/'+ $scope.payType+'.html';
          }
          if($scope.payType == 2){
            window.location.href = '/yl/'+$('#orderId').val()+'/'+ $scope.payType+'.html';
          }
          if($scope.payType == 3){
            window.location.href = '/zfb/'+$('#orderId').val()+'/'+ $scope.payType+'.html';
          }
        }
      })
    }
  }
}])
.controller('ordersCtrl',['$scope','serviceHttp','Storage',function($scope,serviceHttp,Storage){
  $scope.DelUserOrder = function(orderId){
    layer.confirm('确定是否取消订单', {icon: 3, title:'提示'}, function(index){
      if(index > 0){
        serviceHttp.orDel({
          orderId: orderId
        }).success(function(data) {
          if (data.status > 0) {
            location.reload();
          }
        });
        layer.close(index);
      }
    });
  }
}])
.controller('ordersInfoCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  $scope.isResh = false;
  var orderId = {orderId:$("#orderId").val()};
   serviceHttp.getCar(orderId)
     .success(function(data){
        if(data.pic.length > 0){
          $scope.isResh = true;
          $scope.carImg = data.pic;
          console.log($scope.carImg);
        }
     })
  var F = [];
  var Z = [];
  var dataCar = [];
    $scope.carSubmit = function(){
        var len = $("#len").val();
        var picZ = new Array();
        $('.picZ').each(function() {
          if($(this).val()!=""){
            picZ = picZ.concat($(this).val());
          }
        });
        var picF = new Array()
        $('.picF').each(function() {
          if($(this).val()!=""){
            picF = picF.concat($(this).val());
          }
        });
      if (picZ.length < len || picF.length < len) {
         layer.msg('三个成人需上传一份驾驶证，含正反面，以此类推');
         return false;
      } else {
          var car = {
                      carzImg: picZ,
                      carfImg: picF,
                      orderId: $('#orderId').val()
                    };
          serviceHttp.driveCar(car)
          .success(function(data){
            if (data.status > 0) {
              layer.msg('上传成功');
              window.location.href = '/order.html';
            } else {
              layer.msg('上传失败');
            }
          })
        }
  }
  $scope.addShow = false;
  $scope.isGo = false;
  serviceHttp.getOrderInfo({orderId: $("#orderId").val()})
  .success(function(data){
    if(data){
      $scope.cIn = data.length;
      if($scope.cIn == (parseInt($('#adultNum').html())+parseInt($("#childNum").html()))){
        $scope.isGo = true;
      }
      $scope.inUser = data;
    }else{
      $scope.addShow = true;
    }
  });
  $scope.addInfoShow = function(){
    if($scope.cIn == (parseInt($('#adultNum').html())+parseInt($("#childNum").html()))){
      $scope.addShow = false;
    }else{
      $scope.addShow = true;
    }
  };
  $scope.sex1 = function(){
    if($scope.info.sex1 == true){
      $scope.info.sex2 = false;
    }
  };
  $scope.sex2 = function(){
    if($scope.info.sex2 == true){
      $scope.info.sex1 = false;
    }
  };
  $scope.addInfo = function(){
    $scope.info.sex = $scope.info.sex1 == true ? 1 : 2;
    $scope.info.orderId = $("#orderId").val();
    serviceHttp.addUserIn($scope.info).success(function(data){
      if(data.status > 0){
        serviceHttp.getOrderInfo({orderId: $("#orderId").val()})
        .success(function(data){
          $scope.inUser = data;
          $scope.cIn = $scope.inUser.length;
          $scope.addShow = false;
          $scope.info = {};
        });
      }
    });
  };
  $scope.delInfo = function(id){
    layer.confirm('确定是否删除被保险人', {icon: 3, title:'提示'}, function(index){
      if(index > 0){
        serviceHttp.getUserInDel({insuredId:id}).success(function(data) {
          if(data.status > 0){
            serviceHttp.getOrderInfo({orderId: $("#orderId").val()})
            .success(function(data){
              $scope.inUser = data;
              $scope.cIn = $scope.inUser.length;
              $scope.isGo = false;
            });
          }
        })
        layer.close(index);
      }
    });
  };
  $scope.addUserInfo = function(){
    if($scope.cIn != (parseInt($('#adultNum').html())+parseInt($("#childNum").html()))){
      layer.msg('请完整填写完出境保险人信息');
    }else{
      serviceHttp.addOUserIn({orderId:$("#orderId").val()}).success(function(data){
        if(data.status>0){
          window.location.href = '/order.html';
        }else{
          layer.msg('提交失败');
        }
      });
    }
  }
}])
.controller('ordersCarCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
  $scope.isResh = false;
  var orderId = {orderId:$("#orderId").val()};
   serviceHttp.getCar(orderId)
     .success(function(data){
        if(data.pic.length > 0){
          $scope.isResh = true;
          $scope.carImg = data.pic;
        }
     })
  var F = [];
  var Z = [];
  var dataCar = [];
    $scope.carSubmit = function(){
        var len = $("#len").val();
        var picZ = new Array();
        $('.picZ').each(function() {
          if($(this).val()!=""){
            picZ = picZ.concat($(this).val());
          }
        });
        var picF = new Array()
        $('.picF').each(function() {
          if($(this).val()!=""){
            picF = picF.concat($(this).val());
          }
        });
      if (picZ.length < len || picF.length < len) {
         layer.msg('三个成人需上传一份驾驶证，含正反面，以此类推');
         return false;
      } else {
          var car = {
                      carzImg: picZ,
                      carfImg: picF,
                      orderId: $('#orderId').val()
                    };
          serviceHttp.driveCar(car)
          .success(function(data){
            if (data.status > 0) {
              layer.msg('上传成功');
              window.location.href = '/order.html';
            } else {
              layer.msg('上传失败');
            }
          })
        }
  }
}])
.controller('ordersCommentCtrl',['$scope','serviceHttp','Storage',function($scope,serviceHttp,Storage){
  $scope.mm = {};
  $scope.addComment = function(){
    if($('#drivesScore').val() == 0){
      layer.msg('请为这个自驾游评分');
      return;
    }
    if($scope.mm.conT == undefined){
      layer.msg('请为这个自驾游评论');
      return;
    }
    $scope.mm.drivesId = $('#drivesId').val();
    $scope.mm.orderId = $('#orderId').val();
    $scope.mm.orderNo = $('#orderNo').val();
    $scope.mm.drivesScore = $('#drivesScore').val();
    serviceHttp.addComment($scope.mm).success(function(data){
      if(data.status > 0){
        window.location.href = '/order.html';
      }else{
        layer.msg('评论失败,请重新评论');
      }
    });
  }
}])
.service('serviceHttp',['$http',function($http){
  //
  this.getArticle = function(data) {
    return $http({
      url: '/Mobile/Articles/getArticle',
      method: "POST",
      data: data
    });
  };
    // 获取驾驶证照片
  this.getCar = function(data) {
    return $http({
      url: '/Home/Orders/getCarLic',
      method: "POST",
      data: data
    });
  };
    // 上传驾驶证照片
  this.driveCar = function(data) {
    return $http({
      url: '/Home/Orders/addCarLic',
      method: "POST",
      data: data
    });
  };
  // 自驾游评论
  this.addComment = function(data) {
    return $http({
      url: '/Home/Drives/addComment',
      method: "POST",
      data: data
    });
  };
  // 订单删除
  this.orDel = function(data) {
    return $http({
      url: '/Mobile/Orders/orDel',
      method: "POST",
      data: data
    });
  };
  // 改变订单出行信息
  this.addOUserIn = function(data) {
    return $http({
      url: '/Home/Orders/addOUserIn',
      method: "POST",
      data: data
    });
  };
  //删除被保险人
  this.getUserInDel = function(data) {
        return $http({
          url: '/Mobile/Orders/getUserInDel',
          method: "POST",
          data: data
        });
      };
  // 添加出行被保险人
  this.addUserIn = function(data) {
    return $http({
      url: '/Mobile/Orders/addUserIn',
      method: "POST",
      data: data
    });
  };
  // 获取订单出行被保险人
  this.getOrderInfo = function(data){
    return $http({
      url: '/Mobile/Orders/getUserIn',
      method: "POST",
      data: data
    });
  };
  //获取订单列表
  this.OrdersList = function(data){
    return $http({
      url: '/Home/Orders/OrdersList',
      method: "POST",
      data:data
    });
  };
  //签证地址
  this.visaAddress = function(data){
    return $http({
      url: '/Home/Visas/visaUserNews',
      method: "POST",
      data:data
    });
  };
  //门票地址
  this.goodAddress = function(data){
    return $http({
      url: '/Home/Goods/goodsNews',
      method: "POST",
      data:data
    });
  };
  // 确认自驾
  this.payNews = function(data){
    return $http({
      url: '/Home/Orders/payNews',
      method: "POST",
      data:data
    });
  };
  // 自驾订单添加
  this.drivesForm = function(data){
    return $http({
      url: '/Home/Orders/addOrders',
      method: "POST",
      data:data
    });
  };
  // 用户是否登录
  this.isLogin = function() {
    return $http({
      url: '/home/Base/getLogin',
      method: "POST"
    });
  };
  // 用户地址删除
  this.userAddressRemove = function(data){
    return $http({
      url: '/Home/Users/userAddressRemove',
      method: "POST",
      data:data
    });
  };
  // 用户地址 默认设置
  this.userDefault = function(data){
    return $http({
      url: '/Home/Users/userDefault',
      method: "POST",
      data:data
    });
  };
  // 用户联系人
  this.uclxrShow = function(){
    return $http({
      url: '/Home/Users/usershow',
      method: "POST",
      data:''
    });
  };
  // 添加联系人
  this.uclxr = function(data){
    return $http({
      url: '/Home/Users/usersetajax',
      method: "POST",
      data:data
    });
  };
  // 用户名更新
  this.reName = function(data){
    return $http({
      url: '/Home/Users/doReNameAjax',
      method: "POST",
      data:{
        newName:data
      }
    });
  };
  // 自驾时间
  this.getApList = function(data){
    return $http({
      url: '/Api/V1/getApList',
      method: "POST",
      data:data
    });
  };
  // 酒店详情
  this.getHotel = function(HotelsId) {
    return $http({
      url: '/Home/Drives/getHotel',
      method: "POST",
      data: {
        HotelsId: HotelsId
      }
    });
  };
  // 获取报名地址
  this.getgoPlace = function() {
    return $http({
      url: '/Home/Drives/goPlace',
      method: "POST",
    });
  };
  // 报名时间
  this.addGoTime=function(data){
    return $http({
      url: '/Home/Gos/addGoTime',
      method: "POST",
      data:data
    });
  };
  // 获取自驾
  this.getDList=function(data){
    return $http({
      url: '/Api/V1/getDList',
      method: "POST",
      data:data
    });
  };
  // 获取用户默认地址
  this.getUserAddress = function() {
    return $http({
      url: '/Home/Users/getAddress',
      method: "POST"
    });
  };
  // 忘记密码
  this.setpassword=function(data){
    return $http({
      url:'/Home/Users/setpassword',
      method:"POST",
      data: data
    });
  };
  // 电话是否存在
  this.getPhone=function(data){
    return $http({
      url:'/Home/Users/getPhone',
      method:"POST",
      data: {
        'phone':data
      }
    });
  };
  // 用户登录
  this.userLogin=function(data){
    return $http({
      url:'/Home/Users/userLogin',
      method:"POST",
      data: data
    });
  };
  // 短信发送
  this.smsSend=function(data){
    return $http({
      url:'/Home/Tools/smsSend',
      method:"POST",
      data: {
        'userPhone':data
      }
    });
  };
  // 用户注册
  this.UserAdd=function(data){
    return $http({
      url:'/Home/Users/UserAdd',
      method:"POST",
      data:data
    });
  };
  // 订单支付更新
  this.editPayment = function(data) {
    return $http({
      url: '/Home/Pay/editPayment',
      method: "POST",
      data: data
    });
  };
}])
.factory('Storage', function() {
  return {
    set: function(key, data) {
      return window.localStorage.setItem(key, window.JSON.stringify(data));
    },
    get: function(key) {
      return window.JSON.parse(window.localStorage.getItem(key));
    },
    remove: function(key) {
      return window.localStorage.removeItem(key);
    }
  };
})
.filter('to_trusted', ['$sce', function($sce) {
  return function(text) {
    return $sce.trustAsHtml(text);
  };
}])
.directive('onFinishRenderFilters', function ($window,$timeout) {
  return {
    restrict: 'A',
    link: function (scope, element, attr) {
      if (scope.$last === true) {
        $timeout(function () { scope.$emit('ngRepeatFinished'); });
      }
    }
  }
})
.directive('ndComnav', [
  function () {
    return {
      restrict: 'E',
      template: '<div class="zjy" ng-show="dlist" ng-repeat="vo in dlist">'
                 +'<div class="imgplace" >'
                  +'<a href="/z/{{vo.drivesId}}.html"><img ng-src="/{{vo.pcDrivesImg}}" alt=""></a>'
                  +   '<div class="countlove"><i class="glyphicon glyphicon-star"></i>&nbsp;<span>{{vo.solaCount}}</span></div>'
                  +   '<div class="zjy_desc">'
                  +       '<p id="zjy_desc1">{{vo.drivesFrom}}</p>'
                  +       '<p id="zjy_desc3">{{vo.drivesName}}</p>'
                  +   '</div>'
                 +'</div>'
                 +'<div class="row descplace">'
                  +   '<div class="col-md-8 descplaceleft" ng-bind-html="vo.drivesDesc|to_trusted">'
                  +   '</div>'
                  +   '<div class="col-md-4 descplaceright">'
                  +       '<div class="descplacerightcon">'
                  +           '<div class="condesc"><span>{{vo.drivesDay}}</span></div>'
                  +           '<span class="conprivce">{{vo.adultPrice}}</span>元/人'
                  +       '</div>'
                  +   '</div>'
                 +'</div>'
             +'</div>',
      link: function (scope, element) {
        /**
         * 初始化变量
         */
        // scope.user = {};
      }
    }
  }
])
.directive('apApdrives', [
  function () {
    return {
      restrict: 'E',
      template: '<div class="dc_lists" ng-show="apList" ng-repeat="vo in apList">'
                +'<div class="dc_listsl">'
                +    '<p><span class="dc_name">{{vo.userName}}</span>&nbsp;&nbsp;&nbsp;'
                +       '<span star max="vo.drivesScore"></span>'
                +    '</p>'
                +    '<p>{{vo.content}}</p>'
                +'</div>'
                +'<div class="dc_listsr">'
                +    '<p>{{vo.createTime}}</p>'
                +'</div>'
                +'<hr style="clear:both;">'
                +'</div>',
      link: function (scope, element) {
      }
    }
  }
])
.directive('star', function () {
      return {
        template: '<em>'
                  +'<span class="glyphicon glyphicon-star" ng-repeat="vo in stars"></span>'
                  +'</em>',
        scope: {
          max: '=',
        },
        link: function (scope, elem, attrs) {
          var updateStars = function () {
            scope.stars = [];
            for (var i = 0; i < scope.max; i++) {
              scope.stars.push({filled: i});
            }
          };
          updateStars()
        }
      };
    });
}).call(this);
