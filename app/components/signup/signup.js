angular.module('asV2.signup', ['ngRoute', 'asV2.service.user'])
.config(function ($routeProvider) {
    $routeProvider.when('/signup', {
        templateUrl: 'app/components/signup/signup.html',
        controller: 'signupCtrl'
    });
}).controller('signupCtrl', function ($scope, userService) {
    $scope.subscribeSuccessful = false;

    $scope.submitForm = function (isValid) {
        if (isValid) {
            if ($scope.newUser.password !== $scope.newUser.password2) {
                $scope.errorIdenticalPwd = true;
            }

            userService.create($scope.newUser).then(function (result) {
                if (result){
                    $scope.subscribeSuccessful = true;
                }
            }, function () {
                console.log('We could not add it.');
            });

        }
    };
});
