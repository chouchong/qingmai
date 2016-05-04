angular.module('starter', ['ionic', 'starter.controllers', 'starter.services'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      cordova.plugins.Keyboard.disableScroll(true);
    }
    if (window.StatusBar) {
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider) {

  $stateProvider

    .state('main', {
    url: '/main',
    // abstract: true,
    templateUrl: 'templates/main.html',
    controller:'MainCtrl'
    })   
    .state('content', {
      url: '/content',
      templateUrl: 'templates/content.html',
      controller: 'ContentCtrl'
    })
     .state('visa', {
      url: '/visa',
      templateUrl: 'templates/visa.html',
      controller: 'VisaCtrl'
    })
     .state('book', {
      url: '/book',
      templateUrl: 'templates/book.html',
      controller: 'BookCtrl'
    })
     .state('paySuccess', {
      url: '/paySuccess',
      templateUrl: 'templates/paySuccess.html',
      controller: 'PaySuccessCtrl'
    })
     .state('order', {
      url: '/order',
      templateUrl: 'templates/order.html',
      controller: 'OrderCtrl'
    })
     .state('pay', {
      url: '/pay',
      templateUrl: 'templates/pay.html',
      controller: 'PayCtrl'
    })
    .state('zjyDetail', {
      url: '/zjyList/:zjyId',
      templateUrl: 'templates/zjyDetail.html',
      controller: 'ZjyDetailCtrl'
    })
    .state('zjyList', {
      url: '/zjyList',
      templateUrl: 'templates/zjyList.html',
      controller: 'ZjyListCtrl'
    });

  $urlRouterProvider.otherwise('/main');

});