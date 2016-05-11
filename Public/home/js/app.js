(function(){
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
.controller('regCtrl',['$scope','serviceHttp',function($scope,serviceHttp){ 
  $scope.checkbox=$("#checkbox").prop('checked');
  $scope.sms=function(){   
    serviceHttp.smsSend($scope.user.phone)
            .success(function(data){
              layer.msg('验证码已发送，请注意查收');
          }).error(function(data){
              layer.msg('验证码获取失败');
          });   
  }
  $scope.doreg=function(){
    serviceHttp.UserAdd($scope.user)
     .success(function(data){
      if(data['status']==1){
        layer.msg(data['msg']);
        window.location.href="/Home/Users/login";
      }
      if(data['status']==-3){
        layer.msg(data['msg']);
      }
      if(data['status']==-4){
        layer.msg(data['msg']);
      }
      if(data['status']==-1){
        layer.msg(data['msg']);
      }
     })
     .error(function(data){
       layer.msg('注册失败');
     })
  }
}])
.controller('lostpasswordCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
    $scope.sms=function(){
          serviceHttp.getPhone($scope.user.phone)
            .success(function(data){
              if(data['status']==1)
              {
                 serviceHttp.smsSend($scope.user.phone)
                    .success(function(data){
                      layer.msg('验证码已发送，请注意查收');
                     })
                    .error(function(data){
                      layer.msg('验证码获取失败');
                    });   
              }
             if(data['status']==-1){
             layer.msg('您尚未注册,请先注册');
             window.location.href="/Home/Users/register";
          }
          })
            .error(function(data){
              layer.msg('验证码获取失败');
          });   
        } 
    $scope.setpassword=function(){
        serviceHttp.setpassword($scope.user)
        .success(function(data){
         if(data['status']==1){
           layer.msg(data['msg']);
           window.location.href="/Home/Users/login";
         }
         if(data['status']==-3){
           layer.msg(data['msg']);
         }
        })
        .error(function(data){
          layer.msg('提交失败'); 
        })
    }
  }])
.controller('loginCtrl',['$scope','serviceHttp',function($scope,serviceHttp){
    $scope.sms=function(){
    serviceHttp.getPhone($scope.user.phone)
      .success(function(data){
          if(data['status']==1){
             serviceHttp.smsSend($scope.user.phone)
              .success(function(data){
                layer.msg('验证码已发送，请注意查收');
               })
              .error(function(data){
                layer.msg('验证码获取失败');
              });   
         }
          if(data['status']==-1){
             layer.msg('您尚未注册,请先注册');
             window.location.href="/Home/Users/register";
          }
      })
      .error(function(data){
              layer.msg('请求失败');
      });   
  }
  $scope.userLogin=function(){
    serviceHttp.userLogin($scope.user)
     .success(function(data){
      console.log(data);
       if(data['status']==1){
        layer.msg('登录成功');
        window.location.href="/Home/Index/index";
      }
      if(data['status']==-1){
        layer.msg('登录失败');
      }
     })
     .error(function(data){
       layer.msg('登录失败');
     })

  }

}])
.service('serviceHttp',['$http',function($http){
    this.setpassword=function(data){
     return $http({
          url:'/Home/Users/setpassword',
          method:"POST",
          data: data
      });
    }
    this.getPhone=function(data){
     return $http({
          url:'/Home/Users/getPhone',
          method:"POST",
          data: {
              'phone':data
          }
      });
    }
    this.userLogin=function(data){
     return $http({
          url:'/Home/Users/userLogin',
          method:"POST",
          data: data
      });
    }
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
; 
}).call(this);
