app.controller('masterOverviewController', function($scope,$http,$localStorage,API_URL,$window) {

    console.log('masteroverview.js load success');

    $scope.storesList = [];
    $scope.selectedStoreItem = 1;

    $scope.yearsList = [];
    $scope.selectedYearsItem = "2018";

    $scope.weeks = [];

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

    $scope.getStores();
    $scope.getYears();
    $scope.getMasterOverviewWeekly();
});