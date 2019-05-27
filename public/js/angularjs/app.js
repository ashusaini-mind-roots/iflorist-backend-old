//var app = angular.module('employeeRecords', [])/*.constant('API_URL', 'http://localhost/angulara/public/api/v1/')*/;
var app = angular.module("app", ['ngResource','ngStorage'/*,'money-mask'*/])/*.
 config(function($routeProvider){
 $routeProvider
 .when("/recepciones",{
 controller:'recepcionesController',
 templateUrl: 'recepciones.blade.php'
 })

 })*/
    .run(function($rootScope, $http, $location, $localStorage) {
        if ($localStorage.currentUser) {
            $http.defaults.headers.common.Authorization = 'Bearer ' + $localStorage.currentUser.token;
            $rootScope.rsCurrentUser = $localStorage.currentUser;
            $rootScope.rsRole = $rootScope.rsCurrentUser.user.role_name;
            //console.log($http.defaults.headers.common.Authorization);
        }
    })
    // .constant('API_URL', 'http://35.224.17.33:80/api');
    .constant('API_URL', 'http://127.0.0.1:8000/api/');