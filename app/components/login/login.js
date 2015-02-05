angular.module('asV2.login', [])
.directive('loginDirective', function() {
  return {
    restrict: 'E',
    templateUrl: 'app/components/login/login.html',
    controller: 'loginCtrl'
    
  };
}).controller('loginCtrl', function($rootScope, $scope){
    
});