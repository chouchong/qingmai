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
.run(function($rootScope){
  $rootScope.comLogin = function(){
    console.log('ddd');
  }
})
.controller('regCtrl',['$scope','serviceHttp','$interval',function($scope,serviceHttp,$interval){ 
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
        window.location.href = "/login.html";
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
.controller('loginCtrl',['$scope','serviceHttp','$interval',function($scope,serviceHttp,$interval){
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
        window.location.href="/index.html";
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
    serviceHttp.isLogin().success(function(data){
      if(data.status>0){
        $scope.drive.drivesId = $('#drivesId').val();
        $scope.drive.drivesDay = $('#drivesDay').html();
        $scope.drive.childPrice = $('#childPrice').html();
        //drivesImg,drivesName,drivesFrom,drivesDay,childPrice,homePrice
        $scope.drive.goodsThums = $('#drivesImg').attr('src');
        $scope.drive.drivesFrom = $('#drivesFrom').html();
        $scope.drive.goodsName = $('#drivesName').html();
        $scope.drive.drivesType = $('#drivesType').html();
        $scope.drive.timeDesc = $('#xc_timeDesc').html();
        $scope.drive.manPrice = $('#selectAdultPrice').html();
        $scope.drive.roomNum = $("#roomNum").val();
        $scope.drive.manNum = $('#manNum').val();
        if (($scope.drive.roomNum * 2 - $scope.drive.manNum) > 0) {
          $scope.drive.homePrice = $('#roomPrice').html();
        }
        $scope.drive.childNum = $('#childNum').val();
        $scope.drive.totalPrice = $('#df_totelprice').html();
        $scope.drive.orderType = 1;
        $scope.drive.goodsDrvivesTime = $('#xc_timeDesc').html();
        $scope.drive.selectday = $('#df_seldate').html();
        $scope.drive.timeId = $('#timeId').val();
        if($scope.drive.timeId == ""){
          layer.msg('请选择出发日期');
        }else{
          console.log($scope.drive);
        }
      }else{
        layer.msg('您尚未登录,登录了才能预定');
      }
    })
  }
}])
.controller('VisaCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
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
      $("#usemrlxr").show();
      $("#addmrlxr").hide();
      scenic_heightchange();
      $('#ismrlxr').attr('checked',true);
    }
  });
  $scope.goodOrAdd = function() {
    console.log($scope.goodAddress);
  }
}])
.service('serviceHttp',['$http',function($http){
  this.isLogin = function() {
    return $http({
      url: '/home/Base/getLogin',
      method: "POST"
    });
  };
  this.getApList=function(data){
    return $http({
      url: '/Api/V1/getApList',
      method: "POST",
      data:data
    });
  };
  this.getHotel = function(HotelsId) {
    return $http({
      url: '/Mobile/Drives/getHotel',
      method: "POST",
      data: {
        HotelsId: HotelsId
      }
    });
  };
  this.getgoPlace = function() {
    return $http({
      url: '/Mobile/Drives/goPlace',
      method: "POST",
    });
  };
  this.addGoTime=function(data){
    return $http({
      url: '/Mobile/Gos/addGoTime',
      method: "POST",
      data:data
    });
  };
  this.getDList=function(data){
    return $http({
      url: '/Api/V1/getDList',
      method: "POST",
      data:data
    });
  };
  this.getUserAddress = function() {
    return $http({
      url: '/Mobile/Users/getAddress',
      method: "POST"
    });
  };
  this.setpassword=function(data){
    return $http({
      url:'/Home/Users/setpassword',
      method:"POST",
      data: data
    });
  };
  this.getPhone=function(data){
    return $http({
      url:'/Home/Users/getPhone',
      method:"POST",
      data: {
        'phone':data
      }
    });
  };
  this.userLogin=function(data){
    return $http({
      url:'/Home/Users/userLogin',
      method:"POST",
      data: data
    });
  };
  this.smsSend=function(data){
    return $http({
      url:'/Home/Tools/smsSend',
      method:"POST",
      data: {
        'userPhone':data
      }
    });
  };
  this.UserAdd=function(data){
    return $http({
      url:'/Home/Users/UserAdd',
      method:"POST",
      data:data
    });
  };
}])
.filter('to_trusted', ['$sce', function($sce) {
  return function(text) {
    return $sce.trustAsHtml(text);
  };
}])
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
                +       '<span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span>'
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
]);
}).call(this);
