app.controller('employeesController', function($scope,API_URL,$resource,$http, Spinner) {

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
        }
    );

    $http.get(API_URL+'category/all').then(
        function successCallback(response) {
            $scope.categories = response.data.categories;
        }
    );

    $http.get(API_URL+'work_man_comp/all').then(
        function successCallback(response) {
            $scope.work_mans_comp = response.data.work_mans_comp;
        }
    );

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

        $scope.loading = true;

        $http({
            method: method,
            url: url,
            params: {name: $scope.employee.name, store_id: $scope.employee.store_id, category_id: $scope.employee.category_id, work_man_comp_id: $scope.employee.work_man_comp_id, active: $scope.employee.active, hourlypayrate: $scope.employee.hourlypayrate, overtimeelegible: $scope.employee.overtimeelegible},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response)  {
            console.log(response);
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

    Spinner.toggle();
});