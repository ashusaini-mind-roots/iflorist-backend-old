//var app = angular.module('employeeRecords', [])/*.constant('API_URL', 'http://localhost/angulara/public/api/v1/')*/;
var app = angular.module("app", ['ngResource'])/*.
config(function($routeProvider){
        $routeProvider
            .when("/recepciones",{
                controller:'recepcionesController',
                templateUrl: 'recepciones.blade.php'
            })

})*/.constant('API_URL', 'http://localhost:8000/api/');
