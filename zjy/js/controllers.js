angular.module('starter.controllers', [])

.controller('MainCtrl', function($scope, $stateParams, Zjys) {
    // alert("MainCtrl");
    $scope.zjys_tj = Zjys.tj();
})

.controller('ContentCtrl', function($scope,$stateParams, Content) {
  // alert("ContentCtrl");
  $scope.cons = Content.all();
})
.controller('VisaCtrl', function($scope,$stateParams,Visa) {
  // alert("VisaCtrl");
  // $scope.visas = Visa.all();
})
.controller('BookCtrl', function($scope,$stateParams,Book) {
  // alert("BookCtrl");
  // $scope.visas = Visa.all();
})
.controller('PayCtrl', function($scope,$stateParams,Pay) {
  // alert("BookCtrl");
  // $scope.visas = Visa.all();
})
.controller('PaySuccessCtrl', function($scope,$stateParams,PaySuccess) {
  // alert("PaySuccessCtrl");
  // $scope.visas = Visa.all();
})
.controller('OrderCtrl', function($scope,$stateParams,Order) {
  // alert("OrderCtrl");
  // $scope.visas = Visa.all();
})
//自驾游
.controller('ZjyDetailCtrl', function($scope,$stateParams, Zjys) {
  // alert("ZjyDetailCtrl");
  $scope.zjy = Zjys.get($stateParams.zjyId);
})

.controller('ZjyListCtrl', function($scope, $stateParams, Zjys) {
    // alert("ZjyListCtrl");
   $scope.zjys = Zjys.all();
});
