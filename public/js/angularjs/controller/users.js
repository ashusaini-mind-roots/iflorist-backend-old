app.controller('usersController', function($scope,API_URL,$resource,$http) {

    console.log('users.js load success');

    $scope.users = {};

    $scope.stores = {};

    $scope.roles = {};

    $scope.user = {};

    $http.get(API_URL+'auth/users').then(
        function successCallback(response) {
            $scope.users = response.data.users;
            console.log($scope.users);
        }
    );

    $http.get(API_URL+'store/all').then(
        function successCallback(response) {
            $scope.stores = response.data.stores;
            console.log($scope.stores);
        }
    );

    $http.get(API_URL+'role/all').then(
        function successCallback(response) {
            $scope.roles = response.data.roles;
            console.log($scope.roles);
        }
    );



    $scope.confirmDelete = function(id) {
        var isConfirmDelete = confirm('Are you sure you want this record?');
        console.log(id);
        if (isConfirmDelete) {
            $http({
                method: 'DELETE',
                url: API_URL + 'auth/delete/' + id
            }).
            then(function successCallback(data) {
                    $http.get(API_URL+'auth/users').then(
                        function successCallback(response) {
                            $scope.users = response.data.users;
                            console.log($scope.users);
                        }
                    );

            }
            , function errorCallback(response){
                alert('This is embarassing. An error has occured. Please check the log for details');

            }
            );
        } else {
            return false;
        }
    }

    $scope.toggle = function(modalstate, id) {

        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.form_title = "Add user";
                $scope.user = {};
                break;
            case 'edit':
                $scope.form_title = "Edit user";
                $scope.id = id;


                $http({
                    method: 'GET',
                    url: API_URL+'auth/getById/' + id,

                }).then(function successCallback(response)  {
                        console.log(response.data.user);
                        $scope.user = response.data.user;
                        //location.reload();
                        $scope.$digest();
                    }, function errorCallback(response){
                        $('#userModal').modal('hide');
                        alert('This is embarassing. An error has occured. Please check the log for details');

                    }

                );


                break;
            default:
                break;
        }
        $('#userModal').modal('show');
    }

    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        //append employee id to the URL if the form is in edit mode

        var url = API_URL;
        var method = '';

        if (modalstate === 'edit'){
            url += "auth/update/" + id;
            method = 'PUT';
        }
        else
        {
            url += "auth/register";
            method = 'POST';
        }

        console.log($scope.user.name);
        $http({
            method: method,
            url: url,
            params: {name: $scope.user.name, role_id: $scope.user.role_id, store_id: $scope.user.store_id, email: $scope.user.email, password: $scope.user.password},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response)  {
            console.log(response);
            //location.reload();
            $('#userModal').modal('hide');

                $http.get(API_URL+'auth/users').then(
                    function successCallback(response) {
                        $scope.users = response.data.users;
                        console.log($scope.users);
                    }
                );
        }, function errorCallback(response){
            $('#userModal').modal('hide');
            alert('This is embarassing. An error has occured. Please check the log for details');

            }

        );
    }


});