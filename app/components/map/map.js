angular.module('asV2.map', ['ngRoute'])
.config(function ($routeProvider) {
    $routeProvider.when('/map', {
        templateUrl: 'app/components/map/map.html',
        controller: 'mapCtrl'
    });
}).controller('mapCtrl', function ($scope) {
    
});
