//var app = angular.module('employeeRecords', [])/*.constant('API_URL', 'http://localhost/angulara/public/api/v1/')*/;
var app = angular.module("app", ['ngResource','ngStorage','ngAnimate'])/*.
     config(function($httpProvider){
    $httpProvider.interceptors.push(function($q) {
        return {
                'request': function(config) {
                    $('.processing-spinner').show();
                    return config;
                },
                'response': function(response) {
                    $('.processing-spinner').hide();
                    return response;
                }
            };
        });
    })*/
    .run(function($rootScope, $http, $location, $localStorage) {
        if ($localStorage.currentUser) {
            $http.defaults.headers.common.Authorization = 'Bearer ' + $localStorage.currentUser.token;
            $rootScope.rsCurrentUser = $localStorage.currentUser;
            $rootScope.rsRole = $rootScope.rsCurrentUser.user.role_name;
            //console.log($http.defaults.headers.common.Authorization);
        }
    })
    .constant('API_URL', 'http://'+AppURL+'/api/');
     //.constant('API_URL', 'http://127.0.0.1:8000/api/');
//console.log(AppURL);