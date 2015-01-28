

var asV2 = angular.module('AsV2', ['ngResource']);


asV2.controller("HomePageCtrl", function ($scope, HomeService) {
    HomeService.query(function (data) {
        console.log(data);
        $scope.response = data[0];
    });
});

asV2.factory("HomeService", function ($resource) {
    return $resource("api/web/app_dev.php");
});

