(function() {
'use strict';
angular.module("myApp",["ionic",'ngResource'])
.controller('DrvicesController', function(Geek,$scope,$resource,$timeout, $ionicLoading){
   $ionicLoading.show({
    content: 'Loading',
    animation: 'fade-in',
    showBackdrop: true,
    maxWidth: 200,
    showDelay: 0
  });
  var Ads = $resource("/Api/Api/getAdslist",
    {adPositionId:'@adPositionId',adNum:'@adNum'}
  );
  $timeout(function () {
    $ionicLoading.hide();
    $scope.items = Geek.query();
    $scope.ads = Ads.query({adPositionId:-2,adNum:1});
    // console.log($scope.ads);
  }, 2000);
  $scope.user =function() {
   var traget = document.getElementById("myuser");
   if (traget.style.display == "none") {
       traget.style.display = "";
   } else {
       traget.style.display = "none";
   }
 }
})
.filter('to_trusted', ['$sce', function ($sce) {
    return function (text) {
        return $sce.trustAsHtml(text);
    };
}])
.directive('errSrc', function() {
  return {
    link: function(scope, element, attrs) {
      element.bind('error', function() {
        if (attrs.src != attrs.errSrc) {
          attrs.$set('src', attrs.errSrc);
        }
      });
    }
  }
})
.factory('Geek', function($resource){
  return $resource("/Api/Api/drives", {}, {
    query: {
      method: "GET",
      params: {},
      isArray: true
    },
  });
});
}).call(this);
