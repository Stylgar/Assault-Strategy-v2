angular.module('asV2.service.user', ['restangular'])
.factory('userService', function (Restangular) {
    return {
        get: get,
        create: create
    };
    
    function get(userId){
        console.log('You called me!');
        return Restangular.one("user", userId).get();
    }
    
    function create(user){
        return Restangular.one("user").post("", {newUser: user});
    }
    
});
