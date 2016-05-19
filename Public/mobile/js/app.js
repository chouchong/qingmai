(function() {
  'use strict';
  angular.module("myApp", ["ionic", "ionic-ratings"])
    .config(['$httpProvider', function($httpProvider) {
      // 设置post时使用urlencode编码方式;
      $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
      // 设置x-requested-with 请求头, 宁服务器端判定为ajax请求;
      $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
      // 请求时判断数据是否为object或数组， 如果是则将对象序列化；
      $httpProvider.defaults.transformRequest = function(data) {
        return angular.isObject(data) && String(data) !== '[object File]' ? jQuery.param(data) : data;
      }
    }])
    .run(['$ionicPlatform', '$rootScope', '$ionicPopup', '$timeout', function($ionicPlatform, $rootScope, $ionicPopup, $timeout) {
      //信息提示
      $rootScope.msg = function(msg) {
        var myPopup = $ionicPopup.show({
          title: msg,
        });
        $timeout(function() {
          myPopup.close();
        }, 1000);
      }
      $rootScope.userShow = function() {
        var traget = document.getElementById("myuser");
        if (traget.style.display == "none") {
          traget.style.display = "";
        } else {
          traget.style.display = "none";
        }
      }
      $rootScope.userLogin = function() {
        window.location.href = '/Mobile/Users/gologin?url=' + window.location.href;
      }
      $rootScope.userRegister = function() {
        window.location.href = '/Mobile/Users/register?url=' + window.location.href;
      }
      $rootScope.hiDiv = function() {
        var traget = document.getElementById("myuser");
        traget.style.display = "none";
      }
      $ionicPlatform.ready(function() {
        if (window.cordova && window.cordova.plugins.Keyboard) {
          cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
        }
        if (window.StatusBar) {
          StatusBar.styleDefault();
        }
      });
    }])
    .controller("Ixctrl", ['$scope','serviceHttp', function($scope, serviceHttp) {
      $scope.page = 0;
      $scope.dMoreCon = "加载更多精彩";
      $scope.dlist = [];
      $scope.dMore = function(){
        serviceHttp.getDrList({page:++$scope.page}).success(function(data) {
          // console.log(data != null);
          if (data != null) {
            $scope.dlist = $scope.dlist.concat(data);
          }else {
            $scope.dMoreCon = "没有更多产品了";
          }
        });
      }
    }])
    .controller("goLogCtrl", ['$rootScope', '$scope', 'serviceHttp', 'Storage', function($rootScope, $scope, serviceHttp, Storage) {
      $scope.dogologin = function(phone) {
        var url = $('#totoUrl').val();
        Storage.set('phone', phone);
        serviceHttp.getPhone(phone.phone).success(function(data) {
          if (data.status > 0) {
            serviceHttp.smsSend(phone.phone)
              .success(function(data) {
                if (data.code == 0) {
                  window.location.href = '/Mobile/Users/logincode?url=' + url;
                } else {
                  $rootScope.msg('短信发送失败');
                  window.location.href = '/Mobile/Users/logincode?url=' + url;
                }
              });
          } else {
            $rootScope.msg("你不是会员,点击立即注册");
          }
        })
      }
    }])
    .controller('logCtrl', ['$scope', '$rootScope', 'serviceHttp', function($scope, $rootScope, serviceHttp) {
      $scope.dologin = function() {
        var url = $('#togoUrl').val();
        serviceHttp.UserLogin($scope.user).success(function(data) {
          if (data.status > 0) {
            if (url == '') {
              window.location.href = '/Mobile';
            } else {
              window.location.href = url;
            }
          } else {
            $rootScope.msg("账号密码不正确");
          }
        })
      }
    }])
    .controller('regCtrl', ['$scope', '$interval', '$rootScope','$ionicPopover', 'serviceHttp', function($scope, $interval, $rootScope,$ionicPopover, serviceHttp) {
      $scope.text = '发送验证码';
      $scope.smsClass = 'messagetext';
      //短信发送
      $scope.sms = function() {
          serviceHttp.getPhone($scope.user.phone)
            .success(function(data) {
              if (data.status == 1) {
                $rootScope.msg('号码被注册');
              }
              if (data.status == -1) {
                serviceHttp.smsSend($scope.user.phone)
                  .success(function(data) {
                    if (data.code == 0) {
                      $scope.timeSms();
                    } else {
                      $rootScope.msg('短信发送失败');
                    }
                  });
              }
            }).error(function(data) {});
        }
        //短信发送倒计时
      $scope.timeSms = function() {
        var iNow = 60;
        var fash = false;
        if (fash == false) {
          $scope.text = iNow + '秒后重新发送';
          $scope.smsClass = 'messagetextnum';
          fash = true;
          var timer = $interval(function() {
            iNow--;
            $scope.text = iNow + '秒后重新发送';
            if (iNow == 0) {
              $interval.cancel(timer);
              $scope.text = '重新发送';
              fash = false;
              $scope.smsClass = 'messagetext';
              iNow = 60;
            }
          }, 1000);
        }
      }
      $scope.doreg = function() {
        var url = $('#goUrl').val();
        serviceHttp.UserAdd($scope.user).success(function(data) {
          if (data.status > 0) {
            if (url == '') {
              window.location.href = '/Mobile';
            } else {
              window.location.href = url;
            }
          } else {
            $rootScope.msg(data.msg);
          }
        })
      }
      //用户服务条款
      $ionicPopover.fromTemplateUrl('mySer.html', {
        scope: $scope
      }).then(function(popover) {
        $scope.Spopover = popover;
      });
      // 显示定制弹出框
      $scope.openSPopover = function($event) {
        serviceHttp.getArticle({articleId:33}).success(function(data){
          $scope.articles = data;
        });
        $scope.Spopover.show($event);
      };
      $scope.closeSPopover = function() {
        $scope.Spopover.hide();
      };
    }])
    .controller('userCtrl', ['$scope', '$ionicPopup', 'serviceHttp', function($scope, $ionicPopup, serviceHttp) {
      //确认是否删除
      $scope.logout = function() {
        var confirmPopup = $ionicPopup.confirm({
          title: '确认是否退出',
          cancelText: '取消', // String (默认: 'Cancel')。一个取消按钮的文字。
          okText: '确认', // String (默认: 'OK')。OK按钮的文字。
        });
        confirmPopup.then(function(res) {
          if (res) {
            serviceHttp.UserLogout().success(function(data) {
              if (data.status > 0) {
                window.location.href = '/Mobile';
              }
            })
          }
        });
      };
    }])
    .controller('pswCtrl', ['$rootScope', '$scope', '$interval', '$ionicPopup', 'serviceHttp', function($rootScope, $scope, $interval, $ionicPopup, serviceHttp) {
      var iNow = 60;
      $scope.text = '发送验证码';
      $scope.smsClass = 'messagepstext';
      var fash = false;
      $scope.smsPws = function(phone) {
        serviceHttp.smsSend(phone)
          .success(function(data) {
            console.log(data);
            if (data.code == 0) {
              $scope.timeSms();
            } else {
              $rootScope.msg('短信发送失败');
            }
          });
      }
      $scope.timeSms = function() {
        if (fash == false) {
          $scope.text = iNow + '秒后重新发送';
          $scope.smsClass = 'messagepstextnum';
          fash = true;
          var timer = $interval(function() {
            iNow--;
            $scope.text = iNow + '秒后重新发送';
            if (iNow == 0) {
              $interval.cancel(timer);
              $scope.text = '重新发送';
              fash = false;
              $scope.smsClass = 'messagepstext';
              iNow = 60;
            }
          }, 1000);
        }
      }

      $scope.dopsw = function(pws) {
        serviceHttp.UserPws(pws).success(function(data) {
          if (data.status > 0) {
            var confirmPopup = $ionicPopup.confirm({
              title: '是否登录',
              cancelText: '去首页', // String (默认: 'Cancel')。一个取消按钮的文字。
              okText: '登录', // String (默认: 'OK')。OK按钮的文字。
            });
            confirmPopup.then(function(res) {
              if (res) {
                window.location.href = '/Mobile/Users/login';
              } else {
                window.location.href = '/Mobile';
              }
            });
          } else {
            $rootScope.msg(data.msg);
          }
        })
      }
    }])
    .controller('codeCtrl', ['$scope', '$rootScope', 'serviceHttp', 'Storage', function($scope, $rootScope, serviceHttp, Storage) {
      $scope.scode = {
        phone: Storage.get('phone').phone
      };
      var iNow = 60;
      $scope.text = '重新发送验证码';
      $scope.smsClass = 'messagepstext';
      var fash = false;
      $scope.smsCode = function(phone) {
        serviceHttp.smsSend(phone)
          .success(function(data) {
            console.log(data);
            if (data.code == 0) {
              $scope.timeSms();
            } else {
              $rootScope.msg('短信发送失败');
            }
          });
      }
      $scope.timeSms = function() {
        if (fash == false) {
          $scope.text = iNow + '秒后重新发送';
          $scope.smsClass = 'messagepstextnum';
          fash = true;
          var timer = $interval(function() {
            iNow--;
            $scope.text = iNow + '秒后重新发送';
            if (iNow == 0) {
              $interval.cancel(timer);
              $scope.text = '重新发送';
              fash = false;
              $scope.smsClass = 'messagepstext';
              iNow = 60;
            }
          }, 1000);
        }
      }
      $scope.dologincode = function(scode) {
        var url = $('#tocodeUrl').val();
        serviceHttp.toCode(scode).success(function(data) {
          if (data.status == 1) {
            if (url == '') {
              window.location.href = '/Mobile';
            } else {
              window.location.href = url;
            }
          } else {
            $rootScope.msg('账号密码不正确');
          }
        });
      }
    }])
    .controller('userNmCtrl', ['$scope', '$rootScope', 'serviceHttp', function($scope, $rootScope, serviceHttp) {
      $scope.doreName = function() {
        serviceHttp.doReName($scope.username).success(function(data) {
          if (data.status == 1) {
            $rootScope.msg('修改成功');
          } else {
            $rootScope.msg('修改失败');
          }
        });
      }
    }])
    .controller("aLmctrl", ['$scope', '$rootScope', 'serviceHttp', function($scope, $rootScope, serviceHttp) {
      $scope.addAddress = function() {
        serviceHttp.addAddress($scope.user).success(function(data) {
          if (data.status == 1) {
            window.location.href = '/Mobile/Users/addressList';
          } else {
            $rootScope.msg(data.msg)
          }
        });
      }
    }])
    .controller("Lmctrl", ['$scope', '$ionicPopup', '$rootScope', 'serviceHttp', function($scope, $ionicPopup, $rootScope, serviceHttp) {
      serviceHttp.addressList().success(function(data) {
        $scope.list = data;
      });
      $scope.userIsDefault = function(addressId) {
        serviceHttp.userIsDefault(addressId).success(function(data) {
          if (data.status == 1) {
            $rootScope.msg("修改成功")
            serviceHttp.addressList().success(function(data) {
              $scope.list = data;
            });
          } else {
            $rootScope.msg("修改失败")
          }
        });
      }
      $scope.delAddress = function(addressId) {
        var confirmPopup = $ionicPopup.confirm({
          title: '确认是否删除',
          cancelText: '取消', // String (默认: 'Cancel')。一个取消按钮的文字。
          okText: '确认', // String (默认: 'OK')。OK按钮的文字。
        });
        confirmPopup.then(function(res) {
          if (res) {
            serviceHttp.delAddress(addressId).success(function(data) {
              if (data.status > 0) {
                serviceHttp.addressList().success(function(data) {
                  $scope.list = data;
                });
              } else {
                $rootScope.msg("删除失败")
              }
            })
          }
        });
      }
    }])
    .controller("drvCtrl", ['$rootScope', '$scope', '$ionicLoading', '$ionicScrollDelegate', '$timeout', '$ionicPopover', '$ionicActionSheet', 'serviceHttp', function($rootScope, $scope, $ionicLoading, $ionicScrollDelegate, $timeout, $ionicPopover, $ionicActionSheet, serviceHttp) {
      //jiazai
      // $ionicLoading.show({
      //   content: 'Loading',
      //   animation: 'fade-in',
      //   showBackdrop: true,
      //   maxWidth: 200,
      //   showDelay: 0
      // });
      //时间报名
      $ionicPopover.fromTemplateUrl('customDate.html', {
        scope: $scope
      }).then(function(popover) {
        $scope.Gpopover = popover;
      });
      // 显示定制弹出框
      $scope.openGPopover = function($event) {
        $scope.Gpopover.show($event);
      };
      $scope.closeGPopover = function() {
        $scope.Gpopover.hide();
      };
      //报名地点
      $ionicPopover.fromTemplateUrl('my-popover.html', {
        scope: $scope
      }).then(function(popover) {
        $scope.Dpopover = popover;
      });
      // 显示定制弹出框
      $scope.openDPopover = function($event) {
        serviceHttp.getgoPlace().success(function(data) {
          $scope.goplaces = data;
        })
        $scope.Dpopover.show($event);
      };
      $scope.closeDPopover = function() {
        $scope.Dpopover.hide();
      };
      //地图
      $ionicPopover.fromTemplateUrl('map.html', {
        scope: $scope
      }).then(function(popover) {
        $scope.Mpopover = popover;
      });
      // 显示定制弹出框
      $scope.openMPopover = function($event) {
        $scope.Mpopover.show($event);
      };
      $scope.closeMPopover = function() {
        $scope.Mpopover.hide();
      };
      //酒店详情
      $ionicPopover.fromTemplateUrl('hotelmsg.html', {
        scope: $scope
      }).then(function(popover) {
        $scope.popover = popover;
      });
      // 显示定制弹出框
      $scope.openPopover = function(hotelId, $event) {
        serviceHttp.getHotel(hotelId).success(function(data) {
          $scope.hotel = data;
        })
        $scope.popover.show($event);
      };
      $scope.closePopover = function() {
        $scope.popover.hide();
      };
      // $timeout(function() {
      //   $ionicLoading.hide();
      //   $ionicScrollDelegate.resize();
      // }, 3000);
      $scope.gotime = function(obj) {
        serviceHttp.goTime(obj).success(function(data) {
          if (data.status > 0) {
            $rootScope.msg("报名成功,等待电话");
            $scope.Gpopover.hide();
          } else {
            $rootScope.msg("删除失败")
          }
        })
      }
      $scope.visa = function(visaId) {
        window.location.href = '/Mobile/Visas/index/visaId/' + visaId;
      }
      $scope.drive = {};
      $scope.drivesBuy = function() {
        if (parseInt($('#totalPrice').html()) == 0) {
          $ionicScrollDelegate.$getByHandle('drivesScroll').scrollTo(0, 360);
        } else {
          $scope.drive.drivesId = $('#drivesId').val();
          $scope.drive.drivesDay = $('#drivesDay').html();
          $scope.drive.childPrice = $('#childPrice').html();
          //drivesImg,drivesName,drivesFrom,drivesDay,childPrice,homePrice
          $scope.drive.goodsThums = $('#drivesImg').attr('src');
          $scope.drive.drivesFrom = $('#drivesFrom').html();
          $scope.drive.goodsName = $('#drivesName').html();
          $scope.drive.drivesType = $('#drivesType').html();
          $scope.drive.timeDesc = $('#timeDesc').html();
          $scope.drive.manPrice = $('#manPrice').html();
          $scope.drive.roomNum = $("#roomNum").val();
          $scope.drive.manNum = $('#manNum').val();
          if (($scope.drive.roomNum * 2 - $scope.drive.manNum) > 0) {
            $scope.drive.homePrice = $('#roomPrice').html();
          }
          $scope.drive.childNum = $('#childNum').val();
          $scope.drive.totalPrice = $('#totalPrice').html();
          $scope.drive.orderType = 1;
          $scope.drive.goodsDrvivesTime = $('#timeDesc').html();
          $scope.drive.selectday = $('#selectedDay').val();
          $scope.drive.timeId = $('#timeId').val();
          $scope.drive.TOKEN_NAME = $('#TOKEN_NAME').val();
          serviceHttp.addOrder($scope.drive).success(function(data) {
            if (data.status > 0) {
              window.location.href = "/Mobile/Orders/confirmDrives/orderId/" + data.orderId;
              $scope.drive = {};
            } else {
              $rootScope.msg('请重新填写');
            }
          });
        }
      }
    }])
    .controller("visaCtrl", ['$rootScope', '$scope', '$ionicPopup', '$ionicScrollDelegate', 'serviceHttp', function($rootScope, $scope, $ionicPopup, $ionicScrollDelegate, serviceHttp) {
      $scope.showAddress = function() {
        $ionicScrollDelegate.resize();
        if ($("#uselinkman").hasClass("ion-android-radio-button-off")) {
          $("#uselinkman").addClass("ion-android-checkmark-circle");
          $("#uselinkman").removeClass("ion-android-radio-button-off");
          $(".linkmanfrom").show();
          $(".defaultaddr").hide();
        } else {
          $("#uselinkman").addClass("ion-android-radio-button-off");
          $("#uselinkman").removeClass("ion-android-checkmark-circle");
          $(".linkmanfrom").hide();
          $(".defaultaddr").show();
        }
      }
      serviceHttp.getUserAddress().success(function(data) {
        $scope.addRess = data;
        if ($scope.addRess == null) {
          $("#uselinkman").addClass("ion-android-checkmark-circle");
          $("#uselinkman").removeClass("ion-android-radio-button-off");
          $(".linkmanfrom").show();
          $(".defaultaddr").hide();
        }
      });
      $scope.isVisa = {};
      $scope.visaData = {};
      $scope.addVisa = function() {
        $scope.visaData.goodsName = $('#dvisaName').html();
        $scope.visaData.manPrice = $('#visaPrice').html();
        $scope.visaData.manNum = $('#visaNum').val();
        $scope.visaData.totalPrice = $('#totalPrice').html();
        $scope.visaData.visaId = $('#dvisaId').val();
        $scope.visaData.orderType = 3;
        $scope.visaData.addressId = $('#addressId').val();
        $scope.visaData.isUser = $scope.isVisa;
        if ($scope.visaData.addressId > 0) {
          $scope.visaAddress.$invalid = false;
        }
        if ($scope.visaAddress.$invalid == true) {
          $rootScope.msg('请完整填写联系人信息');
        } else if ($scope.visaData.totalPrice == 0) {
          $rootScope.msg("请选择人数办理");
        } else {
          serviceHttp.addOrder($scope.visaData).success(function(data) {
            if (data.status > 0) {
              var orderId = data.orderId;
              serviceHttp.isLogin().success(function(data) {
                if (data.status > 0) {
                  window.location.href = '/Mobile/Pays/payment/orderId/' + orderId;
                } else {
                  window.location.href = '/Mobile/Users/gologin?url=/Mobile/Pays/payment/orderId/' + orderId;
                }
              })
            } else {
              $rootScope.msg('出发日期没有选择');
            }
          })
        }
      }
    }])
    .controller("OrderDrvCtrl", ['$rootScope', '$scope', '$ionicScrollDelegate','$ionicPopover', 'serviceHttp', function($rootScope, $scope, $ionicScrollDelegate,$ionicPopover, serviceHttp) {

      $ionicPopover.fromTemplateUrl('Amsg.html', {
        scope: $scope
      }).then(function(popover) {
        $scope.Apopover = popover;
      });
      // 显示定制弹出框
      $scope.openAPopover = function($event) {
        serviceHttp.getArticle({articleId:32}).success(function(data){
          $scope.articles = data;
        });
        $scope.Apopover.show($event);
      };
      $scope.closeAPopover = function() {
        $scope.Apopover.hide();
      };
      $scope.isUser = {};
      $scope.showAddress = function() {
        $ionicScrollDelegate.resize();
        if ($("#uselinkman").hasClass("ion-android-radio-button-off")) {
          $("#uselinkman").addClass("ion-android-checkmark-circle");
          $("#uselinkman").removeClass("ion-android-radio-button-off");
          $(".linkmanfrom").show();
          $(".defaultaddr").hide();
        } else {
          $("#uselinkman").addClass("ion-android-radio-button-off");
          $("#uselinkman").removeClass("ion-android-checkmark-circle");
          $(".linkmanfrom").hide();
          $(".defaultaddr").show();
        }
      }
      $scope.resizeContent = function() {
        $ionicScrollDelegate.resize();
      }
      serviceHttp.getUserAddress().success(function(data) {
        $scope.addRess = data;
        if ($scope.addRess == null) {
          $("#uselinkman").addClass("ion-android-checkmark-circle");
          $("#uselinkman").removeClass("ion-android-radio-button-off");
          $(".linkmanfrom").show();
          $(".defaultaddr").hide();
        }
      });
      $scope.order = {
        Desc: ''
      };
      $scope.isChecked = {
        checked: false
      };
      $scope.isReadMe = {
        checked: true
      };
      $scope.odcf = function() {
        if (!$scope.isReadMe.checked) {
          $rootScope.msg("请详细阅读&nbsp;&nbsp;产品订购协议");
        } else {
          $scope.order.isRread = $scope.isReadMe.checked;
          $scope.order.totalPrice = $('#totalPrice').html();
          $scope.order.zMoney = $('#allZcodePrice').html();
          $scope.order.zcode = $('#allzcodes').val();
          $scope.order.orderId = $('#orderId').val();
          $scope.order.addressId = $('#addressId').val();
          $scope.order.isBigber = $scope.isChecked.checked;
          $scope.order.isUser = $scope.isUser;
          if ($scope.order.addressId > 0) {
            $scope.myAddress.$invalid = false;
          }
          if ($scope.myAddress.$invalid == true) {
            $rootScope.msg('请完整填写联系人信息');
          } else {
            serviceHttp.editOrder($scope.order).success(function(data) {
              if (data.status > 0) {
                serviceHttp.isLogin().success(function(data) {
                  if (data.status > 0) {
                    window.location.href = '/Mobile/Pays/payment/orderId/' + $scope.order.orderId;
                  } else {
                    window.location.href = '/Mobile/Users/gologin?url=/Mobile/Pays/payment/orderId/' + $scope.order.orderId;
                  }
                })
              } else {
                $rootScope.msg('信息填写错误');
              }
            });
          }
        }
      }
    }])
    .controller("goodCtrl", ['$scope', '$rootScope', '$ionicScrollDelegate', '$ionicPopup', 'serviceHttp', function($scope, $rootScope, $ionicScrollDelegate, $ionicPopup, serviceHttp) {
      $scope.showAddress = function() {
        $ionicScrollDelegate.resize();
        if ($("#uselinkman").hasClass("ion-android-radio-button-off")) {
          $("#uselinkman").addClass("ion-android-checkmark-circle");
          $("#uselinkman").removeClass("ion-android-radio-button-off");
          $(".linkmanfrom").show();
          $(".defaultaddr").hide();
        } else {
          $("#uselinkman").addClass("ion-android-radio-button-off");
          $("#uselinkman").removeClass("ion-android-checkmark-circle");
          $(".linkmanfrom").hide();
          $(".defaultaddr").show();
        }
      }
      serviceHttp.getUserAddress().success(function(data) {
        $scope.addRess = data;
        if ($scope.addRess == null) {
          $("#uselinkman").addClass("ion-android-checkmark-circle");
          $("#uselinkman").removeClass("ion-android-radio-button-off");
          $(".linkmanfrom").show();
          $(".defaultaddr").hide();
        }
      });
      $scope.isUser = {};
      $scope.good = {};
      $scope.goodOrAdd = function() {
        $scope.good.goodsId = $('#goodsId').val();
        $scope.good.goodsThums = $('img').attr('src');
        $scope.good.goodsName = $('#goodsName').html();
        $scope.good.goodsAttrName = $(".scenictimes button").find('span').html();
        $scope.good.goodsAttrPrice = $(".scenictimes button").find('input').val();
        $scope.good.goodsAttrShop = $(".scenicShops button").html();

        $scope.good.manPrice = $('#manPrice').html();
        $scope.good.manNum = $('#manNum').val();
        $scope.good.childNum = $('#childNum').val();
        $scope.good.childPrice = $('#childPrice').html();
        $scope.good.totalPrice = $('#totalPrice').html();
        $scope.good.orderType = 2;
        $scope.good.selectday = $('#selectedDay').val();
        $scope.good.addressId = $('#addressId').val();
        $scope.good.isUser = $scope.isUser;
        if ($scope.good.addressId > 0) {
          $scope.myAddress.$invalid = false;
        }
        if ($scope.myAddress.$invalid == true) {
          $rootScope.msg('请完整填写联系人信息');
        } else if ($scope.good.selectday == '') {
          $rootScope.msg("请选择订票日期");
        } else if ($scope.good.totalPrice == 0) {
          $rootScope.msg("请添加出发人数");
        } else {
          serviceHttp.addOrder($scope.good).success(function(data) {
            if (data.status > 0) {
              var orderId = data.orderId;
              serviceHttp.isLogin().success(function(data) {
                if (data.status > 0) {
                  window.location.href = '/Mobile/Pays/payment/orderId/' + orderId;
                } else {
                  window.location.href = '/Mobile/Users/gologin?url=/Mobile/Pays/payment/orderId/' + orderId;
                }
              })
            } else {
              $rootScope.msg('出发日期没有选择');
            }
          })
        }
      }
    }])
    .controller("payCtrl", ['$rootScope', '$scope', '$ionicScrollDelegate', 'serviceHttp', function($rootScope, $scope, $ionicScrollDelegate, serviceHttp) {
      var ua = navigator.userAgent.toLowerCase();
      if (ua.match(/MicroMessenger/i) == "micromessenger") {
        $scope.serverSideList = [{
          text: "微信",
          imgsrc: "img/weixin.png",
          desc: "推荐微信的用户",
          value: "2"
        }, {
          text: "银联",
          imgsrc: "img/yinlian.png",
          desc: "信用卡、网银、储蓄卡",
          value: "3"
        }];
      } else {
        $scope.serverSideList = [
          // { text: "支付宝",imgsrc:"img/zhifubao.png",desc:"推荐支付宝的用户",value: "1" },
          {
            text: "银联",
            imgsrc: "img/yinlian.png",
            desc: "信用卡、网银、储蓄卡",
            value: "3"
          }
        ];
      }
      var payments;
      var values;
      var orderId = $('#orderId').val();
      $scope.serverSideChange = function(item) {
        payments = item.text;
        values = item.value;
      };
      $scope.pay = function() {
        if (payments == undefined) {
          $rootScope.msg('请选择支付方式');
        } else {
            serviceHttp.editPayment({
              orderId: orderId,
              payment: payments,
              adultNum: $('#adultNum').html()
            }).success(function(data) {
              if (data.status == 1) {
                  if (values == 2) {
                    if (ua.match(/MicroMessenger/i) == "micromessenger") {
                      serviceHttp.wxPay({
                        orderId: orderId
                      }).success(function(data) {
                        if (data.status > 0) {
                          WeixinJSBridge.invoke('getBrandWCPayRequest', {
                            appId: data.appId,
                            timeStamp: data.timeStamp,
                            nonceStr: data.nonceStr,
                            package: data.package,
                            signType: data.signType,
                            paySign: data.paySign
                          }, function(res) {
                            //如果支付成功
                            if (res.err_msg == 'get_brand_wcpay_request:ok') {
                              //支付成功后跳转的地址
                              window.location.href = '/Mobile';
                            } else {
                              window.location.href = '/Mobile/Pays/wxPayEr/orderId/' + orderId;
                            }
                          })
                        } else {
                          window.location.href = '/Mobile/Pays/wxPayEr/orderId/' + orderId;
                        }
                      });
                    }
                  }
                  }else if (data.status == 2){
                    $rootScope.msg('库存只有'+data.num);
                  }
                  else {
                    window.location.href = '/Mobile/Pays/goPay/orderId/' + $('#orderId').val() + '/values/' + values;
                  }
            })
          }
        }
    }])
    .controller("orCtrl", ['$rootScope', '$scope','$ionicPopup', 'serviceHttp', function($rootScope, $scope, $ionicPopup, serviceHttp) {
      $scope.page = 0;
      $scope.isfresh = false;
      $scope.oList = [];
      $scope.doRefresh = function() {
        serviceHttp.OrdersList({
          page: $scope.page
        }).success(function(data) {
          $scope.page++;
          $scope.oList = $scope.oList.concat(data);
          if (data.length == 0) {
            $scope.isfresh = true;
          }
          $scope.$broadcast('scroll.infiniteScrollComplete');
        });
      };
      $scope.orDel = function(vo, index) {
        var confirmPopup = $ionicPopup.confirm({
          title: '确认是否取消订单',
          cancelText: '取消', // String (默认: 'Cancel')。一个取消按钮的文字。
          okText: '确认', // String (默认: 'OK')。OK按钮的文字。
        });
        confirmPopup.then(function(res) {
          if (res) {
            serviceHttp.orDel({
              orderId: vo.orderId
            }).success(function(data) {
              if (data.status > 0) {
                $scope.oList.splice(index, 1);
              }else{
                $rootScope.msg('取消失败');
              }
            });
          }
        });
      };
    }])
    .controller("carCtrl", ['$rootScope', '$scope', 'serviceHttp', function($rootScope, $scope, serviceHttp) {
      
      $scope.carLic = function() {
        var len = $("#len").val();
        var picZ = new Array()
        $('.picZ').each(function() {
          picZ = picZ.concat($(this).val());
        });
        var picF = new Array()
        $('.picF').each(function() {
          picF = picF.concat($(this).val());
        });
        for (var i = 0; i <= picZ.length; i++) {
          if (!picZ[i]) {
            picZ.splice(i, 1);
            break;
          }
        }
        for (var i = 0; i <= picF.length; i++) {
          if (!picF[i]) {
            picF.splice(i, 1);
            break;
          }
        }
        if (picZ.length < len || picF.length < len) {
          $rootScope.msg('三个成人需上传一份驾驶证，含正反面，以此类推');
          return false;
        } else {
          var car = {
            carzImg: picZ.join(","),
            carfImg: picF.join(","),
            orderId: $('#orderId').val()
          }
          serviceHttp.addCarLic(car).success(function(data) {
            if (data.status > 0) {
              $rootScope.msg('上传成功');
              window.location.href = '/Mobile/Orders/index';
            } else {
              $rootScope.msg('上传失败');
            }
          });
        }
      };
    }])

  .controller("userInCtrl", ['$rootScope', '$scope','$ionicPopup','serviceHttp', function($rootScope, $scope,$ionicPopup ,serviceHttp) {
      $scope.sexlist = [{
        text: "男",
        value: "1"
      }, {
        text: "女",
        value: "2"
      }];
      $scope.oUser = {
        sex: '1'
      };
      var iOrderId = $('#iOrderId').val();
      var adultNum = $('#adultNum').html();
      var childNum = $('#childNum').html();
      var cIn = 0;
      $scope.isShow = false;
      $scope.isShowadd = false;
      $scope.isShowWidth = 45;
      serviceHttp.getUserIn({
        orderId: iOrderId
      }).success(function(data) {
        $scope.inUser = data;
        if (data) {
          cIn = $scope.inUser.length;
          if(cIn == (parseInt(childNum)+parseInt(adultNum))){
            $scope.isShow = true;
          }
        }
      });
      $scope.inEdit = function(insuredId) {
        var confirmPopup = $ionicPopup.confirm({
          title: '确认是否删除被保险人',
          cancelText: '取消', // String (默认: 'Cancel')。一个取消按钮的文字。
          okText: '确认', // String (默认: 'OK')。OK按钮的文字。
        });
        confirmPopup.then(function(res) {
          if (res) {
            serviceHttp.getUserInDel({insuredId:insuredId}).success(function(data) {
              if(data.status > 0){
                serviceHttp.getUserIn({
                  orderId: iOrderId
                }).success(function(data) {
                  $scope.inUser = data;
                  cIn = $scope.inUser.length;
                  $scope.isShowadd = false;
                  $scope.isShowWidth = 45;
                });
              }
            });
          }
        });
      }
      $scope.serverSideChange = function(item) {
        $scope.oUser.sex = item.value;
      };
      $scope.addUserIn = function() {
        $scope.oUser.orderId = iOrderId;
        serviceHttp.addUserIn($scope.oUser).success(function(data) {
          if (data.status > 0) {
            $rootScope.msg('添加成功');
            serviceHttp.getUserIn({
              orderId: iOrderId
            }).success(function(data) {
              $scope.inUser = data;
              cIn = $scope.inUser.length;
              if(cIn == (parseInt(childNum)+parseInt(adultNum))){
                $scope.isShowadd = true;
                $scope.isShowWidth = 90;
              }
            });
          } else {
            $rootScope.msg('添加失败');
          }
          $scope.oUser.insuredId = 0;
          $scope.oUser.userName = '';
          $scope.oUser.userCard = '';
        })
      }
      $scope.addUserOrder = function(){
        if(cIn != (parseInt(childNum)+parseInt(adultNum))){
          $rootScope.msg('请先保存,完善资料后提交');
        }else{
          serviceHttp.addOUserIn({orderId:iOrderId}).success(function(data){
            if(data.status>0){
              window.location.href = '/Mobile/Orders/index';
            }else{
              $rootScope.msg('提交失败');
            }
          })
        }
      }
    }])
    .controller("dCommentCtrl", ['$rootScope', '$scope', 'serviceHttp', function($rootScope, $scope, serviceHttp) {
      $scope.ratingsObject = {
        iconOn: 'ion-ios-star',
        iconOff: 'ion-ios-star-outline',
        iconOnColor: 'rgb(200, 200, 100)',
        iconOffColor: 'rgb(200, 100, 100)',
        rating: 1,
        minRating: 1,
        callback: function(rating) {
          $scope.ratingsCallback(rating);
        }
      };
      var cstar = 1;
      $scope.ratingsCallback = function(rating) {
        cstar = rating;
        $("#myratings").html(rating + "分");
      };
      $scope.con = {};
      $scope.addComment = function() {
        if (cstar == 1) {
          $rootScope.msg('请评分');
        } else {
          $scope.con.drivesScore = cstar;
          $scope.con.orderId = $('#cOrderId').val();
          $scope.con.orderNo = $('#cOrderNo').html();
          serviceHttp.addComment($scope.con).success(function(data) {
            if (data.status > 0) {
              $rootScope.msg('评分成功');
              window.location.href = '/Mobile/Orders/index';
            } else {
              $rootScope.msg('评分失败,请重新填写评分');
            }
          });
        }
      }
    }])
    .controller("articleCtrl",['$scope','$ionicScrollDelegate',function($scope,$ionicScrollDelegate){
        $scope.totop = function(){
            $ionicScrollDelegate.scrollTop(true);
        };
    }])
    .service('serviceHttp', ['$http', function($http) {
      this.getDrList=function(data){
        return $http({
          url: '/Mobile/Index/getDList',
          method: "POST",
          data:data
        });
      };
      this.getArticle = function(data) {
        return $http({
          url: '/Mobile/Articles/getArticle',
          method: "POST",
          data: data
        });
      };
      this.orDel = function(data) {
        return $http({
          url: '/Mobile/Orders/orDel',
          method: "POST",
          data: data
        });
      };
      this.addOUserIn = function(data) {
        return $http({
          url: '/Mobile/Orders/addOUserIn',
          method: "POST",
          data: data
        });
      };
      this.getUserInDel = function(data) {
        return $http({
          url: '/Mobile/Orders/getUserInDel',
          method: "POST",
          data: data
        });
      };
      this.getUserIn = function(data) {
        return $http({
          url: '/Mobile/Orders/getUserIn',
          method: "POST",
          data: data
        });
      };
      this.addUserIn = function(data) {
        return $http({
          url: '/Mobile/Orders/addUserIn',
          method: "POST",
          data: data
        });
      };
      this.addComment = function(data) {
        return $http({
          url: '/Mobile/Drives/addComment',
          method: "POST",
          data: data
        });
      };
      this.getCarLic = function(data) {
        return $http({
          url: '/Mobile/Users/getCarLic',
          method: "POST",
          data: data
        });
      };
      this.addCarLic = function(data) {
        return $http({
          url: '/Mobile/Users/addCarLic',
          method: "POST",
          data: data
        });
      };
      this.OrdersList = function(data) {
        return $http({
          url: '/Mobile/Orders/OrdersList',
          method: "POST",
          data: data
        });
      };
      this.wxPay = function(data) {
        return $http({
          url: '/Mobile/Pays/wxPay',
          method: "POST",
          data: data
        });
      };
      this.isNoPay = function(data) {
        return $http({
          url: '/Mobile/Orders/isNoPay',
          method: "POST",
          data: data
        });
      };
      this.editPayment = function(data) {
        return $http({
          url: '/Mobile/Pays/editPayment',
          method: "POST",
          data: data
        });
      };
      this.editOrder = function(data) {
        return $http({
          url: '/Mobile/Orders/editOrder',
          method: "POST",
          data: data
        });
      };
      this.getUserAddress = function() {
        return $http({
          url: '/Mobile/Users/getAddress',
          method: "POST"
        });
      };
      this.addOrder = function(data) {
        return $.ajax({
          url: '/Mobile/Orders/addOrder',
          type: "POST",
          dataType: "json",
          data: data
        });
      };
      this.isLogin = function() {
        return $http({
          url: '/Mobile/Users/isgoLogin',
          method: "POST"
        });
      };
      this.goTime = function(obj) {
        return $http({
          url: '/Mobile/Gos/addGoTime',
          method: "POST",
          data: obj
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
      this.getDrivesDetail = function(drivesId) {
        return $.ajax({
          url: '/Mobile/Drives/drivesDetail',
          type: "post",
          dataType: "json",
          async: false,
          data: {
            drivesId: drivesId
          }
        });
      };
      this.getDrivesfield = function(drivesId) {
        return $.ajax({
          url: '/Mobile/Drives/getDrivesfield',
          type: "post",
          dataType: "json",
          async: false,
          data: {
            drivesId: drivesId
          }
        });
      };
      this.delAddress = function(addressId) {
        return $http({
          url: '/Mobile/Users/delAddress',
          method: "POST",
          data: {
            addressId: addressId
          }
        });
      };
      this.userIsDefault = function(addressId) {
        return $http({
          url: '/Mobile/Users/userIsDefault',
          method: "POST",
          data: {
            addressId: addressId
          }
        });
      };
      this.addressList = function() {
        return $http({
          url: '/Mobile/Users/userAddressList',
          method: "POST"
        });
      };
      this.addAddress = function(data) {
        return $http({
          url: '/Mobile/Users/addAddress',
          method: "POST",
          data: data
        });
      };
      this.UserLogin = function(data) {
        return $http({
          url: '/Mobile/Users/UserLogin',
          method: "POST",
          data: data
        });
      };
      this.toCode = function(data) {
        return $http({
          url: '/Mobile/Users/toCode',
          method: "POST",
          data: data
        });
      };
      this.getDrives = function() {
        return $.ajax({
          url: '/Api/Api/drives',
          type: "post",
          dataType: "json",
          async: false,

        });
      };
      this.getAds = function() {
        return $.ajax({
          url: '/Api/Api/getAdslist',
          type: "post",
          dataType: "json",
          async: false,
          data: {
            adPositionId: -2,
            adNum: 1
          }
        });
      };
      this.getPhone = function(phone) {
        return $http({
          url: '/Mobile/Users/regPhone',
          method: "POST",
          data: {
            'userPhone': phone
          }
        });
      };
      this.smsSend = function(phone) {
        return $http({
          url: '/Mobile/Tools/smsSend',
          method: "POST",
          data: {
            'userPhone': phone
          }
        });
      };
      this.UserPws = function(data) {
        return $http({
          url: '/Mobile/Users/UserPws',
          method: "POST",
          data: data
        });
      };
      this.UserAdd = function(data) {
        return $http({
          url: '/Mobile/Users/UserAdd',
          method: "POST",
          data: data
        });
      };
      this.UserLogout = function() {
        return $http({
          url: '/Mobile/Users/UserLogout',
          method: "POST"
        });
      };
      this.doReName = function(username) {
        return $http({
          url: '/Mobile/Users/doReName',
          method: "POST",
          data: {
            username: username
          }
        });
      };
    }])
    .filter('to_trusted', ['$sce', function($sce) {
      return function(text) {
        return $sce.trustAsHtml(text + '元/人');
      };
    }])
    .filter('to_day', ['$sce', function($sce) {
      return function(text) {
        return $sce.trustAsHtml((text - 1) + "晚" + text + "天自驾自由行");
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
    .directive('ionVolist', [
      function () {
        return {
          restrict: 'E',
          template: '<ion-item class="zjy" ng-show="dlist" ng-repeat="vo in dlist">'
                    +'<a href="">'
                    +   '<img ng-src="/{{vo.drivesImg}}"  width="100%">'
                    +   '<div class="row">'
                    +        '<div class="col col-67 ionstar" ng-bind-html="vo.drivesDesc">'
                    +        '</div>'
                    +        '<div class="col col-33 price">'
                    +            '<p>'
                    +                '<span style="color:#F77766;">&nbsp;{{vo.adultPrice}}元/人</span>'
                    +            '</p>'
                    +        '</div>'
                    +    '</div>'
                    +'</a>'
                    +'</ion-item>',
          link: function (scope, element) {
            /**
             * 初始化变量
             */
            scope.user = {};
          }
        }
      }
    ]);
    // .directive('hotlesStar', function () {
    //   return {
    //     restrict:'AE',
    //     template: '<ul class="rating">' +
    //         '<li ng-repeat="star in stars">' +
    //         '\u2605' +
    //         '</li>' +
    //         '</ul>',
    //     scope: {
    //       max: '=',
    //     },
    //     link: function (scope, elem, attrs) {
    //       var updateStars = function () {
    //         scope.stars = [];
    //         for (var i = 0; i < scope.max; i++) {
    //           scope.stars.push(i);
    //         }
    //       };
    //       updateStars();
    //     }
    //   };
    // });
}).call(this);