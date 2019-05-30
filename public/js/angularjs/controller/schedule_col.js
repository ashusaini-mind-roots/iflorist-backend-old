app.controller('schedule_colController', function ($scope, $http, $localStorage, API_URL) {
    console.log('schedule_col.js load success');

    $scope.storesList = {};
    $scope.selectedStoreItem = 1;

    $scope.yearsList = {};
    $scope.selectedYearsItem = "2018";

    $scope.weekList = {};
    $scope.selectedWeekItem = "1";

    $scope.getStores = function () {
        // console.log(API_URL + 'store/all/' + $localStorage.currentUser.user.id + '/' + $localStorage.currentUser.user.role_name)
        if ($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'store/all/' + $localStorage.currentUser.user.id + '/' + $localStorage.currentUser.user.role_name,
            }).then(
                function successCallback(response) {
                    $scope.storesList = response.data.stores;
                }
            );
        }
    }

    $scope.getYears = function () {
        $scope.yearsList = ["2017", "2018", "2019"];
    }

    $scope.getWeeks = function () {
        if ($localStorage.weekOverview != undefined)
            $scope.selectedYearsItem = $localStorage.weekOverview.selectedYear;
        if ($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'week/week_by_year/' + $scope.selectedYearsItem,
            }).then(
                function successCallback(response) {
                    $scope.weekList = response.data.weeks;
                    //$scope.SetInitValuesToSelects();
                    if ($localStorage.weekOverview) {
                        {
                            $scope.selectedWeekItem = $localStorage.weekOverview.selectedWeekId;
                            $localStorage.weekOverview = undefined;
                        }
                    } else if (Array.isArray($scope.weekList) && $scope.weekList.length > 0)
                        $scope.selectedWeekItem = $scope.weekList[0].id;
                    $localStorage.weekOverview = undefined;

                    //$scope.getWeekDataFromServer();
                }
            );
        }
    }


    $scope.getStores();
    $scope.getYears();
    $scope.getWeeks();

});