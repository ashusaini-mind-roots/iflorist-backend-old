app.factory('AuthenticationService', Service);

function Service($http, $localStorage, API_URL) {
    var service = {};

    service.Login = Login;
    service.Logout = Logout;

    return service;

    function Login(username, password, callback) {
      //  console.log(API_URL + 'auth/login');
        $http({
            method: 'POST',
            url: API_URL + 'auth/login',
            params: {email: username, password: password},
        }).
        then(function successCallback(response) {
            // add jwt token to auth header for all requests made by the $http service
            $http.defaults.headers.common.Authorization = 'Bearer ' + response.data.access_token;

            $http.get(API_URL+'auth/me').then(
                function successCallback(response_me) {
                    // store username and token in local storage to keep user logged in between page refreshes
                    $localStorage.currentUser = { user: response_me.data, token: response.data.access_token };
                    // execute callback with true to indicate successful login
                    callback(true);
                }, function errorCallback(response_me){
                    callback(false);
                }
            );
        }, function errorCallback(response){
            callback(false);
            }
        );


        // $http.post(API_URL+'/api/auth/login', { username: username, password: password })
        //     .success(function (response) {
        //         // login successful if there's a token in the response
        //         if (response.token) {
        //             // store username and token in local storage to keep user logged in between page refreshes
        //             $localStorage.currentUser = { username: username, token: response.access_token };
        //
        //             // add jwt token to auth header for all requests made by the $http service
        //             $http.defaults.headers.common.Authorization = 'Bearer ' + response.access_token;
        //
        //             // execute callback with true to indicate successful login
        //             callback(true);
        //         } else {
        //             // execute callback with false to indicate failed login
        //             callback(false);
        //         }
        //     });
    }

    function Logout(callback) {


        $http({
            method: 'POST',
            url: API_URL + 'auth/logout',
        }).
        then(function successCallback(response) {
            console.log("pepelogout")
            // remove user from local storage and clear http auth header
                delete $localStorage.currentUser;
                $http.defaults.headers.common.Authorization = '';
                callback(true);

            }, function errorCallback(response){
                callback(false);
            }
        );
    }
}