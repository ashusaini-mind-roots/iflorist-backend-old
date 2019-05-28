app.controller('masterOverviewController', function($scope,$http,$localStorage,API_URL,$window) {

    console.log('masteroverview.js load success');

    $scope.storesList = [];
    $scope.selectedStoreItem = 1;

    $scope.yearsList = [];
    $scope.selectedYearsItem = "2018";

    $scope.weeks = [];
    $scope.weekSelected = {};

    $scope.avgActual = 0.00;
    $scope.avgTarget = 0.00;
    $scope.avgDifference = 0.00;



    $scope.getStores = function () {
        if($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'store/all/' + $localStorage.currentUser.user.id + '/' + $localStorage.currentUser.user.role_name ,
            }).then(
                function successCallback(response) {
                    $scope.storesList = response.data.stores;
                }
            );
        }
    }

    $scope.getYears = function () {
        $scope.yearsList = ["2017","2018","2019"];
    }

    $scope.getMasterOverviewWeekly = function () {
        if($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'master_overview_weekly/master_overview_weekly_of_fresh/' + $scope.selectedStoreItem + '/' + $scope.selectedYearsItem ,
            }).then(
                function successCallback(response) {
                    $scope.weeks = response.data.master_overview_weekly;
                    $scope.calcAVGs($scope.weeks);
                    console.log(response);
                }
            );
        }
    }

    $scope.getOverviewDataFromServer = function () {
        $scope.getMasterOverviewWeekly();
    }

    $scope.goToweekControlPage = function (week_id) {
        $localStorage.weekOverview = {
            selectedStoreId : $scope.selectedStoreItem,
            selectedYear : $scope.selectedYearsItem,
            selectedWeekId : week_id
        };
        $localStorage.weekOverview

        $window.location.href = "/weekpanel";
    }

    $scope.calcAVGs = function (master_overview_weekly) {
        var sum = 0;
        $scope.avgActual = 0.00;
        $scope.avgTarget = 0.00;
        $scope.avgDifference = 0.00;
        var count = master_overview_weekly.length;
        for (var i = 0; i < count; i++) {
            $scope.avgActual = $scope.avgActual + parseFloat(master_overview_weekly[i].actual);
            $scope.avgTarget = $scope.avgTarget +parseFloat( master_overview_weekly[i].target);
            $scope.avgDifference = $scope.avgDifference + parseFloat(master_overview_weekly[i].difference);
        }

        console.log($scope.avgActual);
        console.log($scope.avgTarget);
        console.log($scope.avgDifference);

        $scope.avgActual = $scope.avgActual / count;
        $scope.avgTarget = $scope.avgTarget / count;
        $scope.avgDifference = $scope.avgDifference / count;


    }

    $scope.showEditTarget = function(selectedWeek){
        $scope.weekSelected = selectedWeek;
        console.log($scope.weekSelected)
        $('#targetModal').modal('show');
    }
    $scope.editTarget = function () {
        $http({
            method: PUT,
            url: API_URL + 'weekly_projection_percent_costs/update_target_cog/' + $scope.selectedStoreItem + '/' + weekSelected.id ,
            params: {target_cog:weekSelected.target }
        }).then(function successCallback(response)  {
                console.log(response);
                //location.reload();
                $('#targetModal').modal('hide');

                // $http.get(API_URL+'auth/users').then(
                //     function successCallback(response) {
                //         $scope.users = response.data.users;
                //         console.log($scope.users);
                //     }
                // );
            }, function errorCallback(response){
                $('#targetModal').modal('hide');
                alert('This is embarassing. An error has occured.');

            }

        );
    }

    $scope.getStores();
    $scope.getYears();
    $scope.getMasterOverviewWeekly();
});