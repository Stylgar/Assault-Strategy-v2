angular.module('asV2.service', ['restangular'])
.factory('loginService', function (Restangular) {
    return {
        log: log,
    };
    
    function log(login, password){
        return Restangular.post("login", {login: login, password: password});
    }
    
});
