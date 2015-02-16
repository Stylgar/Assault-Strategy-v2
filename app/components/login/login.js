angular.module('asV2.login', ['toastr','asV2.service.login'])
.directive('loginDirective', function() {
  return {
    restrict: 'E',
    templateUrl: 'app/components/login/login.html',
    controller: 'loginCtrl'
    
  };
}).controller('loginCtrl', function($rootScope, $scope, toastr, loginService){
    $scope.user = {};
    
    $scope.log = function(){
        loginService.log($scope.login, $scope.password).then(function (result) {
                if (result[0].response){
                    $scope.user = { login: $scope.login }
                }
                else{
                    toastr.error('Invalid login');
                    $scope.loginError=true;
                }
            }, function () {
                console.log('Error while targeting api');
            });
    };
});