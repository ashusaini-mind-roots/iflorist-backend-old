app.controller('masterOverview_ColController', function($scope,$http,$localStorage,API_URL,$window,Utils, Spinner) {

    console.log('masteroverview_col.js load success');

    $scope.storesList = [];
    $scope.selectedStoreItem = 1;

    $scope.yearsList = [];
    $scope.selectedYearsItem;

    $scope.weeks = [];
    $scope.weekSelected = {};
    $scope.targetSelected = 0.00;

    $scope.downPercentSelected = 0.00;
    $scope.yearsPojectionToEditList = [];
    $scope.yearReferenceProjectionSelected = "2018";

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
        $scope.yearsList = Utils.GetYears();
        $scope.selectedYearsItem = Utils.GetCurrentYear();
    }

    $scope.getMasterOverviewWeekly = function () {
        if($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'master_overview_weekly/projection_col/' + $scope.selectedStoreItem + '/' + $scope.selectedYearsItem ,
            }).then(
                function successCallback(response) {
                    $scope.weeks = response.data.projection_col;
                    // $scope.calcAVGs($scope.weeks);
                    console.log($scope.weeks);
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

    $scope.showEditTarget = function(selectedWeek,target){
        $scope.weekSelected = selectedWeek;
        $scope.targetSelected = target;

        $('#targetModal').modal('show');
    }
    $scope.editTarget = function () {
        $http({
            method: "PUT",
            url: API_URL + 'target_percentage/update_target_percentage/' + $scope.selectedStoreItem + '/' + $scope.weekSelected.week_id ,
            params: {target_percentage : $scope.targetSelected }
        }).then(function successCallback(response)  {
                $scope.getMasterOverviewWeekly();
                $('#targetModal').modal('hide');
            }, function errorCallback(response){
                $('#targetModal').modal('hide');
                alert('This is embarassing. An error has occured.');
            }
        );
    }
    $scope.showEditProjection = function(selectedWeek){
        $scope.weekSelected = selectedWeek;
        console.log(String($scope.weekSelected.year_reference))
        $scope.yearReferenceProjectionSelected = String($scope.weekSelected.year_reference);
        $scope.downPercentSelected = $scope.weekSelected.down_percent;

        $('#projectionModal').modal('show');
    }
    $scope.editProjection = function () {
        console.log($scope.yearReferenceProjectionSelected)
        $http({
            method: "PUT",
            url: API_URL + 'weekly_projection_percent_revenue/update_proj_weekly_revenue/' + $scope.selectedStoreItem + '/' + $scope.weekSelected.week_id ,
            params: {percent : $scope.downPercentSelected , year_reference : $scope.yearReferenceProjectionSelected }
        }).then(function successCallback(response)  {
                $scope.getMasterOverviewWeekly();
                $('#projectionModal').modal('hide');
            }, function errorCallback(response){
                console.log(response)
                $('#projectionModal').modal('hide');
                alert('This is embarassing. An error has occured.');
            }
        );
    }

    $scope.getStores();
    $scope.getYears();
    $scope.getMasterOverviewWeekly();
    Spinner.toggle();
});

