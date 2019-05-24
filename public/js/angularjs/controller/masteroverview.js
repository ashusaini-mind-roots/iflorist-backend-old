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
                url: API_URL + 'flowermar_master_weekly/flowermar_master_weekly_of_fresh/' + $scope.selectedStoreItem + '/' + $scope.selectedYearsItem ,
            }).then(
                function successCallback(response) {
                    $scope.weeks = response.data.flowermar_master_weekly_of_fresh;
                    console.log(response);
                }
            );
        }
    }

    $scope.getOverviewDataFromServer = function () {
        $scope.getMasterOverviewWeekly();
    }

    $scope.goToweekControlPage = function () {
        $localStorage.weekOverview_selectedStoreId = $scope.selectedStoreItem;
        $localStorage.weekOverview_selectedYear = $scope.selectedYearsItem;
        $localStorage.weekOverview_selectedWeekId = 106;

        $window.location.href = "/weekpanel";
    }

    $scope.getStores();
    $scope.getYears();
    $scope.getMasterOverviewWeekly();
});