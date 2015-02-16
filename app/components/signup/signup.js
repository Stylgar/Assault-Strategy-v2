angular.module('asV2.signup', ['ngRoute', 'toastr', 'asV2.service.user'])
.config(function ($routeProvider) {
    $routeProvider.when('/signup', {
        templateUrl: 'app/components/signup/signup.html',
        controller: 'signupCtrl'
    });
}).controller('signupCtrl', function ($scope, userService, toastr) {
    $scope.subscribeSuccessful = false;

    $scope.submitForm = function (isValid) {
        if (isValid) {
            if ($scope.newUser.password !== $scope.newUser.password2) {
                $scope.errorIdenticalPwd = true;
            }

            userService.create($scope.newUser).then(function (result) {
                var response = result[0].response;
                if (response){
                    $scope.subscribeSuccessful = true;
                }
                else{
                    var report = result[0].report;
                    $scope.errors = {};
                    for (var i = 0; i<report.errors.length; ++i){
                        console.log(report.errors[i]);
                        if (report.errors[i] == 'ACCOUNT_LOGIN_EXISTS' ){
                            $scope.errors.loginExists = true;
                        }
                        else if (report.errors[i] == 'ACCOUNT_EMAIL_EXISTS'){
                            $scope.errors.emailExists = true;
                        }
                    }
                }
            }, function () {
                toastr.error('Error while trying to contact server', 'Error');
            });

        }
    };
});
