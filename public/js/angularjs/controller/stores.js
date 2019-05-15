app.controller('storesController', function($scope,API_URL,$resource,$http,$localStorage) {

    console.log('stores.js load success');

    $scope.stores = {};

    $scope.store = {};

    if($localStorage.currentUser) {
        $http({
            method: 'GET',
            url: API_URL + 'store/all/' + $localStorage.currentUser.user.id + '/' + $localStorage.currentUser.user.role_name ,
           // params: {user_id: $localStorage.currentUser.user.id, rol_name: $localStorage.currentUser.user.role_name},
        }).then(
            function successCallback(response) {
                $scope.stores = response.data.stores;
                console.log($scope.stores);
            }
        );
    }

    $scope.confirmDelete = function(id) {
        var isConfirmDelete = confirm('Are you sure you want to delete this record?');
        console.log(id);
        if (isConfirmDelete) {
            $http({
                method: 'DELETE',
                url: API_URL + 'store/delete/' + id
            }).
            then(function successCallback(data) {
                    $http.get(API_URL+'store/all').then(
                        function successCallback(response) {
                            $scope.stores = response.data.stores;
                            console.log($scope.stores);
                        }
                    );

            }
            , function errorCallback(response){
                alert('This is embarassing. An error has occured.');

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
                $scope.form_title = "Add store";
                $scope.store = {};
                break;
            case 'edit':
                $scope.form_title = "Edit store";
                $scope.id = id;


                $http({
                    method: 'GET',
                    url: API_URL+'store/getById/' + id,

                }).then(function successCallback(response)  {
                        console.log(response.data.store);
                        $scope.store = response.data.store;
                        //location.reload();
                    }, function errorCallback(response){
                        $('#storeModal').modal('hide');
                        alert('This is embarassing. An error has occured.');
                    }

                );


                break;
            default:
                break;
        }
        $('#storeModal').modal('show');
    }

    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        //append employee id to the URL if the form is in edit mode

        var url = API_URL;
        var method = '';

        if (modalstate === 'edit'){
            url += "store/update/" + id;
            method = 'PUT';
        }
        else
        {
            url += "store/create";
            method = 'POST';
        }

        console.log($scope.store.name);
        $http({
            method: method,
            url: url,
            params: {store_name: $scope.store.store_name, contact_email: $scope.store.contact_email, contact_phone: $scope.store.contact_phone, zip_code: $scope.store.zip_code, address: $scope.store.address},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response)  {
            console.log(response);
            //location.reload();
            $('#storeModal').modal('hide');

            $http.get(API_URL+'store/all').then(
                function successCallback(response) {
                    $scope.stores = response.data.stores;
                    console.log($scope.stores);
                }
            );
        }, function errorCallback(response){
            $('#storeModal').modal('hide');
            alert('This is embarassing. An error has occured.');

            }

        );
    }


});