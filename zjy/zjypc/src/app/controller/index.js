'use strict';
angular.module('gozztrip').controller('IndexCtrl',['$rootScope','$scope','ConF', function($rootScope,$scope,ConF) {
  $rootScope.conF = ConF.getConfList();
}]);