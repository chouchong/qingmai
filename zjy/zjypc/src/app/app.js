angular.module('gozztrip', ['ngRoute','ngResource'])
.config(['$routeProvider',function ($routeProvider) {
  'use strict';
  $routeProvider
    .when('/login', {
      templateUrl: '/Public/app/templates/login.html',
      controller: 'LoginCtrl'
    })
    .when('/drive', {
      templateUrl: '/Public/app/templates/drive.html',
      controller: 'DiverCtrl'
    })
    .when('/', {
      templateUrl: '/Public/app/templates/home.html',
      controller: 'IndexCtrl'
    })
}])
.run(['$location', function($location) {
  $location.path('/').replace();
}]);