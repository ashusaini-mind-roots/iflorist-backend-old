app.controller('logoutController', function($scope,$location, AuthenticationService,$window) {

    console.log('logout.js load success');

    $scope.logout = function () {
        AuthenticationService.Logout();
        $window.location.href = "/";
    }
});