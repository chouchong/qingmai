'use strict';
angular.module('gozztrip').factory('ConF',['ENV','$resource', function(ENV,$resource) {
  var ApiUrl = ENV.api+'Home/Base/Config';
  var resource=$resource(ApiUrl);
  return {
    getConfList: function () {
      return resource.get({});
    }
  }
}]);