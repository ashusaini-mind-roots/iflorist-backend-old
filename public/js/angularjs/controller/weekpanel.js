app.controller('weekPanelController', function($scope,$http,$localStorage,API_URL,$resource) {

    console.log('weekpanel.js load success');

    $scope.storesList = {};
    $scope.selectedStoreItem = 2;

    $scope.yearsList = {};
    $scope.selectedYearsList = "2018";


    $scope.weekList = {};
    $scope.selectedWeekList = "02";

    $scope.monday = 0;
    $scope.tuesday = 0;
    $scope.wednesday = 0;
    $scope.thursday = 0;
    $scope.friday = 0;
    $scope.saturday = 0;
    $scope.sunday = 0;
    $scope.dailyRevenueTotal = $scope.monday + $scope.tuesday + $scope.wednesday + $scope.thursday +
        $scope.friday + $scope.saturday + $scope.sunday;


    $scope.calcDailyTotal = function()
    {
        return $scope.dailyRevenueTotal = $scope.monday + $scope.tuesday + $scope.wednesday + $scope.thursday +
            $scope.friday + $scope.saturday + $scope.sunday;
    }


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

    $scope.getWeeks = function () {
        if($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'week/week_by_year/' + $scope.selectedYearsList ,
            }).then(
                function successCallback(response) {
                    $scope.storesList = response.data.stores;
                }
            );
        }
        $scope.weekList = ["01","02","03"];
    }

    $scope.getStores();
    $scope.getYears();
    $scope.getWeeks();

});