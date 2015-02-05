
angular.module('asV2.home', ['ngRoute', 'ngResource'])
.config(function ($routeProvider) {
    $routeProvider.when('/', {
        templateUrl: 'app/components/home/home.html',
        controller: 'homeCtrl'
    });
}).controller('homeCtrl', function ($scope,homeService) {

    homeService.query(function (data) {
        console.log(data);
        $scope.response = data[0];
    });

}).factory("homeService", function ($resource) {
    console.log("Calling api");
    return $resource("/api/");
});