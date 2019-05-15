//var app = angular.module('employeeRecords', [])/*.constant('API_URL', 'http://localhost/angulara/public/api/v1/')*/;
var app = angular.module("app", ['ngResource','ngStorage'])/*.
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
            //console.log($rootScope.currentUser);
        }
    })
    .constant('API_URL', 'http://localhost:8000/api/');
