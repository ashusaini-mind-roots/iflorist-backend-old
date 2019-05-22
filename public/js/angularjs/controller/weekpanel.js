app.controller('weekPanelController', function($scope,$http,$localStorage,API_URL,$resource) {

    console.log('weekpanel.js load success');

    $scope.storesList = {};
    $scope.selectedStoreItem = 2;

    $scope.yearsList = {};
    $scope.selectedYearsItem = "2018";

    $scope.weekList = {};
    $scope.selectedWeekItem = "3";

    $scope.monday = {'id':-1, 'amt': 0.00};
    $scope.tuesday = {'id':-1, 'amt': 0.00};
    $scope.wednesday = {'id':-1, 'amt': 0.00};
    $scope.thursday = {'id':-1, 'amt': 0.00};
    $scope.friday = {'id':-1, 'amt': 0.00};
    $scope.saturday = {'id':-1, 'amt': 0.00};
    $scope.sunday = {'id':-1, 'amt': 0.00};
    $scope.dailyRevenueTotal = 0.00;

    $scope.saveDays_btnDisable = true;

    //------invoices section
    $scope.invoices = [];
    $scope.invoiceNumber_add;
    $scope.invoiceName_add;
    $scope.invoiceTotal_add;


    $scope.calcDailyTotal = function()
    {
         $scope.dailyRevenueTotal =
            parseFloat($scope.monday.amt) +
            parseFloat($scope.tuesday.amt) +
            parseFloat($scope.wednesday.amt) +
            parseFloat($scope.thursday.amt) +
            parseFloat($scope.friday.amt) +
            parseFloat($scope.saturday.amt) +
            parseFloat($scope.sunday.amt);
        return $scope.dailyRevenueTotal;
    }


    $scope.getStores = function () {
        console.log(API_URL + 'store/all/' + $localStorage.currentUser.user.id + '/' + $localStorage.currentUser.user.role_name)
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
                url: API_URL + 'week/week_by_year/' + $scope.selectedYearsItem ,
            }).then(
                function successCallback(response) {
                    $scope.weekList  = response.data.weeks;
                    if(Array.isArray($scope.weekList) && $scope.weekList.length > 0)
                        $scope.selectedWeekItem = $scope.weekList[0].id;
                }
            );
        }
    }

    $scope.getSevenDays = function () {
       // console.log("storeId: " + $scope.selectedStoreItem + " , weekId: " + $scope.selectedWeekItem )
        if($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'daily_revenue/seven_days_week/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem ,
            }).then(
                function successCallback(response) {
                    var seven_d_w = response.data.seven_days_week;
                    //console.log(seven_d_w);
                    if(Array.isArray(seven_d_w) && seven_d_w.length > 0){
                        $scope.monday = {'id':seven_d_w[0].id, 'amt': parseFloat(seven_d_w[0].amt)};
                        $scope.tuesday = {'id':seven_d_w[1].id, 'amt': parseFloat(seven_d_w[1].amt)};
                        $scope.wednesday = {'id':seven_d_w[2].id, 'amt': parseFloat(seven_d_w[2].amt)};
                        $scope.thursday = {'id':seven_d_w[3].id, 'amt': parseFloat(seven_d_w[3].amt)};
                        $scope.friday = {'id':seven_d_w[4].id, 'amt': parseFloat(seven_d_w[4].amt)};
                        $scope.saturday = {'id':seven_d_w[5].id, 'amt': parseFloat(seven_d_w[5].amt)};
                        $scope.sunday = {'id':seven_d_w[6].id, 'amt': parseFloat(seven_d_w[6].amt)};
                        $scope.calcDailyTotal();
                        $scope.saveDays_btnDisable = false;
                    }
                    else {
                        $scope.clearSevenDays();
                    }

                }
            );
        }
    }

    $scope.updateDaysAmtValues = function () {
        $http({
                method: 'PUT',
                url: API_URL + 'daily_revenue/update_all_amt/',
                params: {monday:$scope.monday, tuesday:$scope.tuesday, wednesday: $scope.wednesday, thursday:$scope.thursday, friday:$scope.friday, saturday:$scope.saturday, sunday:$scope.sunday,
                    user_id:1},
            }).
            then(function successCallback(response) {
               // console.log(response);
            },
            function errorCallback(response){
                console.log(response)
            }
        );
    }

    $scope.getInvoices = function () {
        $http({
            method: 'GET',
            url: API_URL + 'invoice/all/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem ,
        }).then(
            function successCallback(response) {
                $scope.invoices = response.data.invoices;
            }
        );
    }

    $scope.createInvoice = function () {
        $http({
            method: 'POST',
            url: API_URL + 'invoice/create/',
            params: {invoice_number:$scope.invoiceNumber_add, invoice_name:$scope.invoiceName_add, total: $scope.invoiceTotal_add, store_id:$scope.selectedStoreItem, week_id:$scope.selectedWeekItem},
        }).
        then(function successCallback(response) {
                $scope.getInvoices();
                 console.log(response);
            },
            function errorCallback(response){
                console.log(response)
            }
        );
    }


    $scope.clearSevenDays = function () {
        $scope.monday = {'id':-1, 'amt': 0.00};
        $scope.tuesday = {'id':-1, 'amt': 0.00};
        $scope.wednesday = {'id':-1, 'amt': 0.00};
        $scope.thursday = {'id':-1, 'amt': 0.00};
        $scope.friday = {'id':-1, 'amt': 0.00};
        $scope.saturday = {'id':-1, 'amt': 0.00};
        $scope.sunday = {'id':-1, 'amt': 0.00};
        $scope.dailyRevenueTotal = 0.00;
        $scope.saveDays_btnDisable = true;
    }

    $scope.getWeekDataFromServer = function () {
        $scope.getSevenDays();
        $scope.getInvoices();
    }

    $scope.getStores();
    $scope.getYears();
    $scope.getWeeks();

});