angular.module('asV2.login', ['asV2.service'])
.directive('loginDirective', function() {
  return {
    restrict: 'E',
    templateUrl: 'app/components/login/login.html',
    controller: 'loginCtrl'
    
  };
}).controller('loginCtrl', function($rootScope, $scope, loginService){
    $scope.user = {};
    
    $scope.log = function(){
        loginService.log($scope.login, $scope.password).then(function (result) {
                if (result){
                    $scope.user = { login: $scope.login }
                }
            }, function () {
                console.log('We could not add it.');
            });
    };
});