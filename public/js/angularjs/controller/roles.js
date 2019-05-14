app.controller('rolesController', function($scope,API_URL,$resource,$http) {

    console.log('roles.js load success');

    $scope.roles = {};

    $scope.role = {};

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
                url: API_URL + 'role/delete/' + id
            }).
            then(function successCallback(data) {
                    $http.get(API_URL+'role/all').then(
                        function successCallback(response) {
                            $scope.roles = response.data.roles;
                            console.log($scope.roles);
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
                $scope.form_title = "Add Role";
                $scope.role = {};
                break;
            case 'edit':
                $scope.form_title = "Edit Role";
                $scope.id = id;


                $http({
                    method: 'GET',
                    url: API_URL+'role/getById/' + id,

                }).then(function successCallback(response)  {
                        console.log(response.data.role);
                        $scope.role = response.data.role;
                        //location.reload();
                    }, function errorCallback(response){
                        $('#roleModal').modal('hide');
                        alert('This is embarassing. An error has occured. Please check the log for details');

                    }

                );


                break;
            default:
                break;
        }
        $('#roleModal').modal('show');
    }

    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        //append employee id to the URL if the form is in edit mode

        var url = API_URL;
        var method = '';

        if (modalstate === 'edit'){
            url += "role/update/" + id;
            method = 'PUT';
        }
        else
        {
            url += "role/create";
            method = 'POST';
        }

        console.log($scope.role.name);
        $http({
            method: method,
            url: url,
            params: {name: $scope.role.name, description: $scope.role.description},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response)  {
            console.log(response);
            //location.reload();
            $('#roleModal').modal('hide');

            $http.get(API_URL+'role/all').then(
                function successCallback(response) {
                    $scope.roles = response.data.roles;
                    console.log($scope.roles);
                }
            );
        }, function errorCallback(response){
            $('#roleModal').modal('hide');
            alert('This is embarassing. An error has occured. Please check the log for details');

            }

        );
    }


});