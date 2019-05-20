app.controller('logoutController', function($scope,$location, AuthenticationService,$window) {

    console.log('logout.js load success');

    $scope.logout = function () {
        AuthenticationService.Logout(function (result) {
            if (result == true) {
                $window.location.href = "/";
            } else {
                //$scope.error = 'Error al cerrar la sesión';
                console.log('Error to logout');
                //$scope.loading = false;
            }
        });

    }
});