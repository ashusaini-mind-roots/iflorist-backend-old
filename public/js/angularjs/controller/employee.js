app.controller('employeesController', function($scope,API_URL,$resource,$http) {

    console.log('users.js load success');

    $scope.employees = {};

    $scope.categories = {};

    $scope.actives = [
        {id:1,name:'Yes'},
        {id:0,name:'No'}
    ];

    $scope.overtimeelegibles = [
        {id:1,name:'Yes'},
        {id:0,name:'No'}
    ];

    $scope.stores = {};

    $scope.work_mans_comp = {};

    $scope.employee = {};

    $scope.loading = false;

    $http.get(API_URL+'employee/all').then(
        function successCallback(response) {
            $scope.employees = response.data.employees;
            console.log($scope.employees);
        }
    );

    $http.get(API_URL+'store/all').then(
        function successCallback(response) {
            $scope.stores = response.data.stores;
            //console.log($scope.stores);
        }
    );

    $http.get(API_URL+'category/all').then(
        function successCallback(response) {
            $scope.categories = response.data.categories;
            //console.log($scope.stores);
        }
    );

    $http.get(API_URL+'work_man_comp/all').then(
        function successCallback(response) {
            $scope.work_mans_comp = response.data.work_mans_comp;
            //console.log($scope.stores);
        }
    );


    /*$scope.confirmDelete = function(id) {
        var isConfirmDelete = confirm('Are you sure you want to delete this record?');
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
    }*/

    $scope.toggle = function(modalstate, id) {

        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.form_title = "Add Empoyee";
                $scope.employee = {};
                break;
            case 'edit':
                $scope.form_title = "Edit Employee";
                $scope.id = id;


                $http({
                    method: 'GET',
                    url: API_URL+'employee/getById/' + id,

                }).then(function successCallback(response)  {
                        console.log(response.data.employee);
                        $scope.employee = response.data.employee;
                        //location.reload();
                        /*$scope.$digest();*/
                    }, function errorCallback(response){
                        $('#employeeModal').modal('hide');
                        alert('This is embarassing. An error has occured.');
                    }

                );


                break;
            default:
                break;
        }
        $('#employeeModal').modal('show');
    }

    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        //append employee id to the URL if the form is in edit mode

        var url = API_URL;
        var method = '';

        if (modalstate === 'edit'){
            url += "employee/update/" + id;
            method = 'PUT';
        }
        else
        {
            url += "employee/create";
            method = 'POST';
        }

        //console.log($scope.user.name);

        $scope.loading = true;

        $http({
            method: method,
            url: url,
            params: {name: $scope.employee.name, store_id: $scope.employee.store_id, category_id: $scope.employee.category_id, work_man_comp_id: $scope.employee.work_man_comp_id, active: $scope.employee.active, hourlypayrate: $scope.employee.hourlypayrate, overtimeelegible: $scope.employee.overtimeelegible},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response)  {
            console.log(response);
            //location.reload();
                $scope.loading = false;
            $('#employeeModal').modal('hide');

                $http.get(API_URL+'employee/all').then(
                    function successCallback(response) {
                        $scope.employees = response.data.employees;
                        console.log($scope.employees);
                    }
                );
        }, function errorCallback(response){
            $('#userModal').modal('hide');
            alert('This is embarassing. An error has occured. Please check the log for details');

            }

        );
    }


});