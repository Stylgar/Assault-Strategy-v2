angular.module('asV2.service.login', ['restangular'])
.factory('loginService', function (Restangular) {
    return {
        log: log,
    };
    
    function log(login, password){
        return Restangular.one("").post("login", {login: login, password: password});
    }
    
});
