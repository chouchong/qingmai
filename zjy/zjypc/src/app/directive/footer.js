/**
 * ndFooter Directives
 */
'use strict';
angular.module('gozztrip').directive('ndFooter', [
  function () {
    return {
      restrict: 'E',
      templateUrl: '/Public/app/templates/foot.html',
      link: function (scope, element) {
        /**
         * 初始化变量
         */
        scope.user = {};
      }
    }
  }
]);