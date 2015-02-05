angular.module('asV2.common', [])
.directive('navbarDirective', function() {
  return {
    restrict: 'E',
    templateUrl: 'app/shared/navbar/navbar.html',
    controller: 'navbarCtrl'
    
  };
}).controller('navbarCtrl', function(){
    
});

