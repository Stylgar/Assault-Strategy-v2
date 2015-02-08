angular.module('asV2', ['asV2.home', 'asV2.common', 'asV2.login', 'asV2.signup'])
.config(function(RestangularProvider, $routeProvider){
    RestangularProvider.setBaseUrl('api/');
    $routeProvider.otherwise({redirectTo: '/'});
})
.controller('rootCtrl',function($rootScope, $scope){
});