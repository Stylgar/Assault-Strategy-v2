angular.module('asV2.signup', ['ngRoute'])
.config(function ($routeProvider) {
    $routeProvider.when('/signup', {
        templateUrl: 'app/components/signup/signup.html',
        controller: 'signupCtrl'
    });
}).controller('signupCtrl', function($scope){
   
   $scope.enroll = function(){
       console.log('Called enroll');
       if ($scope.login !== "")
       {
           $scope.formValid = true;
       }
   };
});

