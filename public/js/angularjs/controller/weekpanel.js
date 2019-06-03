app.controller('weekPanelController', function ($scope, $http, $localStorage, API_URL) {

    console.log('weekpanel.js load success');

    $scope.storesList = {};
    $scope.selectedStoreItem = 2;

    $scope.yearsList = {};
    $scope.selectedYearsItem = "2018";

    $scope.weekList = {};
    $scope.selectedWeekItem = "3";

    $scope.allreadyInitedSelectValuesFromMasterOverview = false;

    $scope.monday = {'id': -1, 'amt': 0.00};
    $scope.tuesday = {'id': -1, 'amt': 0.00};
    $scope.wednesday = {'id': -1, 'amt': 0.00};
    $scope.thursday = {'id': -1, 'amt': 0.00};
    $scope.friday = {'id': -1, 'amt': 0.00};
    $scope.saturday = {'id': -1, 'amt': 0.00};
    $scope.sunday = {'id': -1, 'amt': 0.00};
    $scope.dailyRevenueTotal = 0.00;

    $scope.saveDays_btnDisable = true;

    //------invoices section
    $scope.invoices = [];
    $scope.invoiceNumber_add;
    $scope.invoiceName_add;
    $scope.invoiceTotal_add;

    $scope.invoiceTotal = 0.00;

    //------notes section
    $scope.notesText = '';

    //------week resume
    $scope.runningCOG = 0.00;
    $scope.targetCOG = 0.00;
    $scope.projWeeklyRev = 0.00;

    $scope.calcDailyTotal = function () {
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
                    //console.log($scope.weekList);
                    $scope.SetInitValuesToSelects();
                    if ($localStorage.weekOverview) {
                        {
                            $scope.selectedWeekItem = $localStorage.weekOverview.selectedWeekId;
                            $localStorage.weekOverview = undefined;
                        }
                    } else if (Array.isArray($scope.weekList) && $scope.weekList.length > 0)
                        $scope.selectedWeekItem = $scope.weekList[0].id;
                    $localStorage.weekOverview = undefined;

                    $scope.getWeekDataFromServer();
                }
            );
        }
    }

    $scope.getSevenDays = function () {
        // console.log("storeId: " + $scope.selectedStoreItem + " , weekId: " + $scope.selectedWeekItem )
        if ($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'daily_revenue/seven_days_week/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem,
            }).then(
                function successCallback(response) {
                    var seven_d_w = response.data.seven_days_week;
                    // console.log(seven_d_w);
                    if (Array.isArray(seven_d_w) && seven_d_w.length > 0) {
                        $scope.monday = {
                            'id': seven_d_w[0].id,
                            'amt_formatted': '$' + formatMoney(seven_d_w[0].amt),
                            'amt': parseFloat(seven_d_w[0].amt),
                            'dates_dim_date': seven_d_w[0].dates_dim_date
                        };
                        $scope.tuesday = {
                            'id': seven_d_w[1].id,
                            'amt_formatted': '$' + formatMoney(seven_d_w[1].amt),
                            'amt': parseFloat(seven_d_w[1].amt),
                            'dates_dim_date': seven_d_w[1].dates_dim_date
                        };
                        $scope.wednesday = {
                            'id': seven_d_w[2].id,
                            'amt_formatted': '$' + formatMoney(seven_d_w[2].amt),
                            'amt': parseFloat(seven_d_w[2].amt),
                            'dates_dim_date': seven_d_w[2].dates_dim_date
                        };
                        $scope.thursday = {
                            'id': seven_d_w[3].id,
                            'amt_formatted': '$' + formatMoney(seven_d_w[3].amt),
                            'amt': parseFloat(seven_d_w[3].amt),
                            'dates_dim_date': seven_d_w[3].dates_dim_date
                        };
                        $scope.friday = {
                            'id': seven_d_w[4].id,
                            'amt_formatted': '$' + formatMoney(seven_d_w[4].amt),
                            'amt': parseFloat(seven_d_w[4].amt),
                            'dates_dim_date': seven_d_w[4].dates_dim_date
                        };
                        $scope.saturday = {
                            'id': seven_d_w[5].id,
                            'amt_formatted': '$' + formatMoney(seven_d_w[5].amt),
                            'amt': parseFloat(seven_d_w[5].amt),
                            'dates_dim_date': seven_d_w[5].dates_dim_date
                        };
                        $scope.sunday = {
                            'id': seven_d_w[6].id,
                            'amt_formatted': '$' + formatMoney(seven_d_w[6].amt),
                            'amt': parseFloat(seven_d_w[6].amt),
                            'dates_dim_date': seven_d_w[6].dates_dim_date
                        };
                        $scope.calcDailyTotal();
                        $scope.saveDays_btnDisable = false;
                    } else {
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
            params: {
                monday: $scope.monday,
                tuesday: $scope.tuesday,
                wednesday: $scope.wednesday,
                thursday: $scope.thursday,
                friday: $scope.friday,
                saturday: $scope.saturday,
                sunday: $scope.sunday,
                user_id: $localStorage.currentUser.user.id
            },
        }).then(function successCallback(response) {
                // console.log(response);
            },
            function errorCallback(response) {
                console.log(response)
            }
        );
    }

    $scope.getInvoices = function () {
        $http({
            method: 'GET',
            url: API_URL + 'invoice/all/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem,
        }).then(
            function successCallback(response) {
                $scope.invoices = response.data.invoices;
                $scope.calcInvoiceTotal();
            }
        );
    }

    $scope.getNotes = function () {
        console.log('Selected week: ' + $scope.selectedWeekItem);
        $http({
            method: 'GET',
            url: API_URL + 'note/all/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem,
        }).then(
            function successCallback(response) {
                $scope.notesText = response.data.notes;
            }
        );
    }

    $scope.createInvoice = function () {
        $http({
            method: 'POST',
            url: API_URL + 'invoice/create',
            params: {
                invoice_number: $scope.invoiceNumber_add,
                invoice_name: $scope.invoiceName_add,
                total: $scope.invoiceTotal_add,
                store_id: $scope.selectedStoreItem,
                week_id: $scope.selectedWeekItem
            },
        }).then(function successCallback(response) {
                $scope.getInvoices();
                $scope.calcInvoiceTotal();
                //console.log(response);
            },
            function errorCallback(response) {
                console.log(response)
            }
        );
    }

    $scope.updateNotes = function () {
        $http({
            method: 'PUT',
            url: API_URL + 'note/update/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem,
            params: {
                text: $scope.notesText,
            },
        }).then(function successCallback(response) {
                $scope.getNotes();
            },
            function errorCallback(response) {
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
        $scope.monday = {'id': -1, 'amt': 0.00};
        $scope.tuesday = {'id': -1, 'amt': 0.00};
        $scope.wednesday = {'id': -1, 'amt': 0.00};
        $scope.thursday = {'id': -1, 'amt': 0.00};
        $scope.friday = {'id': -1, 'amt': 0.00};
        $scope.saturday = {'id': -1, 'amt': 0.00};
        $scope.sunday = {'id': -1, 'amt': 0.00};
        $scope.dailyRevenueTotal = 0.00;
        $scope.saveDays_btnDisable = true;
    }

    $scope.getWeekDataFromServer = function () {
        $scope.getSevenDays();
        $scope.getProjWeeklyRev();
        $scope.getInvoices();
        $scope.getTargetCOG();
        $scope.calcCostDifference();
        $scope.getNotes();
    }

    $scope.calcRunningCOG = function () {
        var runningCosts = $scope.invoiceTotal * 100 / $scope.dailyRevenueTotal;
        if (isNaN(runningCosts))
            $scope.runningCOG = runningCosts = 0.00;
        return $scope.runningCOG = runningCosts;
    }

    $scope.getTargetCOG = function () {
        $http({
            method: 'GET',
            url: API_URL + 'weekly_projection_percent_costs/target_cog/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem,
        }).then(
            function successCallback(response) {
                $scope.targetCOG = response.data.target_cog;
                // console.log($scope.targetCOG)
            }
        );
    }

    $scope.getTargetCOGInMoney = function () {
        return $scope.calcDailyTotal() * ($scope.targetCOG / 100);
    }

    $scope.calcCostDifference = function () {
        return $scope.targetCOG - $scope.runningCOG;
    }

    $scope.getProjWeeklyRev = function () {
        $http({
            method: 'GET',
            url: API_URL + 'weekly_projection_percent_revenue/proj_weekly_revenue/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem,
        }).then(
            function successCallback(response) {
                $scope.projWeeklyRev = response.data.proj_weekly_rev;
                //console.log(response)
            },
            function errorCallback(response) {
                console.log(response)
            }
        );
    }

    $scope.SetInitValuesToSelects = function () {
        if ($localStorage.weekOverview != undefined) {
            $scope.selectedStoreItem = $localStorage.weekOverview.selectedStoreId;
            // $scope.selectedYearsItem = $localStorage.weekOverview.selectedYear;
            $scope.selectedWeekItem = $localStorage.weekOverview.selectedWeekId;
            //console.log($scope.selectedWeekItem)
        }
    }

    $scope.confirmDeleteInvoice = function (id) {
        var isConfirmDelete = confirm('Are you sure you want to delete this record?');
        console.log(id);
        if (isConfirmDelete) {
            $http({
                method: 'DELETE',
                url: API_URL + 'invoice/delete/' + id
            }).then(function successCallback(data) {
                    $scope.getInvoices();
                }
                , function errorCallback(response) {
                    alert('This is embarassing. An error has occured.');
                }
            );
        } else {
            return false;
        }
    }

    $scope.getStores();
    $scope.getYears();
    $scope.getWeeks();
    // $scope.SetInitValuesToSelects();
    // $scope.getWeekDataFromServer();

    $("input[data-type='currency']").on({

        keyup: function () {
            formatCurrency($(this));
        },
        blur: function () {
            formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        var number = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //console.log(number);
        return number.replace(/^0+(?!\.|$)/, '');
    }


    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") {
            return;
        }

        // original length
        var original_len = input_val.length;

        // initial caret position
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = "$" + left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = "$" + input_val;

            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
        try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
            console.log(e)
        }
    };
});
