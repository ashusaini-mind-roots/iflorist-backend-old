app.controller('weekPanelController', function($scope,$http,$localStorage,API_URL) {

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

    $scope.invoiceTotal = 0.00;

    //------week resume
    $scope.runningCOG = 0.00;
    $scope.targetCOG = 0.00;
    $scope.projWeeklyRev = 0.00;

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
                    $scope.weekList = response.data.weeks;
                    if ($localStorage.weekOverview) {
                        $scope.selectedWeekItem = $localStorage.weekOverview_selectedWeekId;
                    } else if (Array.isArray($scope.weekList) && $scope.weekList.length > 0)
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
                    console.log(seven_d_w);
                    if(Array.isArray(seven_d_w) && seven_d_w.length > 0){
                        $scope.monday = {'id':seven_d_w[0].id, 'amt': parseFloat(seven_d_w[0].amt),'dates_dim_date':seven_d_w[0].dates_dim_date };
                        $scope.tuesday = {'id':seven_d_w[1].id, 'amt': parseFloat(seven_d_w[1].amt),'dates_dim_date':seven_d_w[1].dates_dim_date};
                        $scope.wednesday = {'id':seven_d_w[2].id, 'amt': parseFloat(seven_d_w[2].amt),'dates_dim_date':seven_d_w[2].dates_dim_date};
                        $scope.thursday = {'id':seven_d_w[3].id, 'amt': parseFloat(seven_d_w[3].amt),'dates_dim_date':seven_d_w[3].dates_dim_date};
                        $scope.friday = {'id':seven_d_w[4].id, 'amt': parseFloat(seven_d_w[4].amt),'dates_dim_date':seven_d_w[4].dates_dim_date};
                        $scope.saturday = {'id':seven_d_w[5].id, 'amt': parseFloat(seven_d_w[5].amt),'dates_dim_date':seven_d_w[5].dates_dim_date};
                        $scope.sunday = {'id':seven_d_w[6].id, 'amt': parseFloat(seven_d_w[6].amt),'dates_dim_date':seven_d_w[6].dates_dim_date};
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
                    user_id:$localStorage.currentUser.user.id},
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
                $scope.calcInvoiceTotal();
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
                $scope.calcInvoiceTotal();
                 //console.log(response);
            },
            function errorCallback(response){
                console.log(response)
            }
        );
    }

    $scope.calcInvoiceTotal = function () {
        $scope.invoiceTotal = 0.00;
        for (var i = 0; i < $scope.invoices.length; i++) {
            $scope.invoiceTotal += parseFloat($scope.invoices[i].total);
        }
        return $scope.invoiceTotal;
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
        $scope.getProjWeeklyRev();
        $scope.getInvoices();
        $scope.getTargetCOG();
        $scope.calcCostDifference();
    }

    $scope.calcRunningCOG = function () {
        var runningCosts = $scope.invoiceTotal * 100 / $scope.dailyRevenueTotal;
        if(isNaN(runningCosts) )
            $scope.runningCOG = runningCosts = 0.00;
        return $scope.runningCOG = runningCosts;
    }

    $scope.getTargetCOG = function () {
        $http({
            method: 'GET',
            url: API_URL + 'weekly_projection_percent_costs/target_cog/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem ,
        }).then(
            function successCallback(response) {
                $scope.targetCOG = response.data.target_cog;
                console.log($scope.targetCOG)
            }
        );
    }

    $scope.calcCostDifference = function () {
        return Math.abs($scope.targetCOG - $scope.runningCOG);
    }

    $scope.getProjWeeklyRev = function () {
        $http({
            method: 'GET',
            url: API_URL + 'weekly_projection_percent_revenue/proj_weekly_revenue/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem ,
        }).then(
            function successCallback(response) {
                $scope.projWeeklyRev = response.data.proj_weekly_rev;
                console.log(response)
            },
            function errorCallback(response){
                console.log(response)
            }
        );
    }

    $scope.SetInitValuesToSelects = function () {
        if($localStorage.weekOverview){
            $scope.selectedStoreItem = $localStorage.weekOverview_selectedStoreId;
            $scope.selectedYearsItem = $localStorage.weekOverview_selectedYear;
            $scope.selectedWeekItem = $localStorage.weekOverview_selectedWeekId;
        }
    }

    $scope.getStores();
    $scope.getYears();
    $scope.getWeeks();
    $scope.SetInitValuesToSelects();
    $scope.getWeekDataFromServer();
});