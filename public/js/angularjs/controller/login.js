app.controller('loginController', function($scope,$location, AuthenticationService,$window) {

    console.log('login.js load success');

    $scope.initController = function(){

    // reset login status
    //     AuthenticationService.Logout(function () {
    //
    //     });
        // console.log("initController")
    };

    $scope.login = function () {
        //$scope.loading = true;
        AuthenticationService.Login($scope.username, $scope.password, function (result) {
            if (result == true) {
                console.log("authenticated ok");
                //$scope.error = "login ok";
                $window.location.href = "/stores";
            } else {
                $scope.error = 'Username or password is incorrect';
                //$scope.loading = false;
            }
        });
    }
    $scope.initController();

});