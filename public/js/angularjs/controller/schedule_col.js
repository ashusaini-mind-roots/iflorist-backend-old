app.controller('schedule_colController', function ($scope, $http, $localStorage, API_URL, Spinner, Utils) {
    console.log('schedule_col.js load success');

    $scope.storesList = {};
    $scope.selectedStoreItem = 1;

    $scope.yearsList = {};
    $scope.selectedYearsItem = "2018";

    $scope.weekList = {};
    $scope.selectedWeekItem = "1";

    $scope.employeesScheduleList = {};
    $scope.employeeStoreWeekId = -1;

    $scope.dayOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

    $scope.hideLoader = false;
    $scope.shrinkOnHide = false;

    $scope.toggle = function() {
        $scope.hideLoader = !$scope.hideLoader;
    }
     $scope.switchStyle = function() {
        $scope.shrinkOnHide = !$scope.shrinkOnHide;
    }

    $scope.getStores = function () {
        Spinner.toggle();
        if ($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'store/all/' + $localStorage.currentUser.user.id + '/' + $localStorage.currentUser.user.role_name,
            }).then(
                function successCallback(response) {
                    $scope.storesList = response.data.stores;
                    Spinner.toggle();
                }
            );
        }
    }

    $scope.getYears = function () {
        $scope.yearsList = ["2017", "2018", "2019"];
    }

    $scope.getWeeks = function () {
        Spinner.toggle();
        if ($localStorage.weekOverview != undefined)
            $scope.selectedYearsItem = $localStorage.weekOverview.selectedYear;
        if ($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'week/week_by_year/' + $scope.selectedYearsItem,
            }).then(
                function successCallback(response) {
                    $scope.weekList = response.data.weeks;
                    if ($localStorage.weekOverview) {
                        {
                            $scope.selectedWeekItem = $localStorage.weekOverview.selectedWeekId;
                            $localStorage.weekOverview = undefined;
                        }
                    } else if (Array.isArray($scope.weekList) && $scope.weekList.length > 0)
                        $scope.selectedWeekItem = $scope.weekList[0].id;
                    $localStorage.weekOverview = undefined;
                    Spinner.toggle();
                    $scope.getScheduleInformation();
                }
            );
        }

    }

    $scope.getScheduleInformation = function () {
        Spinner.toggle();
        $http({
            method: 'GET',
            url: API_URL + 'schedule/all/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem,
        }).then(
            function successCallback(response) {
                $scope.employeeStoreWeekId = response.data.employee_store_week_id;
                $scope.parseScheduleInformationResponse(response.data.categories_schedules);
                console.log($scope.employeesScheduleList)
                Spinner.toggle();
            }
        );
    }

    $scope.parseScheduleInformationResponse = function(categories_schedules){
        for(var i = 0 ; i < categories_schedules.length ; i++){
            for(var j = 0 ; j < categories_schedules[i].employees.length ; j++){
                for(var k = 0 ; k < categories_schedules[i].employees[j].schedule_days.length ; k++){
                    categories_schedules[i].employees[j].total_hours = Utils.ParseMinutesToHoursFormat(categories_schedules[i].employees[j].total_minutes_at_week);
                    var schedul = categories_schedules[i].employees[j].schedule_days[k];
                    if(schedul.time_in != undefined)
                        schedul.time_in = new Date(schedul.time_in);
                    if(schedul.time_out != undefined)
                        schedul.time_out = new Date(schedul.time_out);
                }
            }
        }
        return $scope.employeesScheduleList = categories_schedules;
    }

    $scope.calcTimesDifference = function (time_in, time_out, break_time) {
        var h = m = "00";
        if(time_in != undefined && time_out != undefined){
            if(break_time == undefined)
                break_time = 0;
            var minutesTotal = (diffDateTime(time_in,time_out).totalmin - break_time);

            var h = Math.floor(minutesTotal / 60);
            var m = minutesTotal % 60;
            h = h < 10 ? '0' + h : h;
            m = m < 10 ? '0' + m : m;
        }
        return h + ':' + m;
    }
    $scope.calcTimesDifferenceMinutes_Util = function (time_in,time_out,break_time)
    {
        var minutesTotal = 0;
        if(time_in != undefined && time_out != undefined){
            if(break_time == undefined) break_time = 0;
            minutesTotal = (diffDateTime(time_in,time_out).totalmin - break_time);
        }
        return minutesTotal;
    }

    $scope.updateSchedulesByCategory = function(employees,category_name){
        Spinner.toggle();
        var esw_array = new Array();

        for(var i = 0 ; i < employees.length ; i++){
            esw_array = esw_array.concat(employees[i].schedule_days);
        }
        var asw_toSend = angular.copy(esw_array, asw_toSend);
        for(var j = 0 ; j < asw_toSend.length ; j++){
            if(asw_toSend[j].time_in != undefined) {
                asw_toSend[j].time_in = asw_toSend[j].time_in.toLocaleString("en-US", { hour12: false });
            }
            if(asw_toSend[j].time_out != undefined)
                asw_toSend[j].time_out = asw_toSend[j].time_out.toLocaleString("en-US", { hour12: false });
            asw_toSend[j].category_name = category_name;
        }

        var schedule_to_send = JSON.stringify(asw_toSend);
       // console.log(schedule_to_send);
        $http({
            method: 'POST',
            url: API_URL + 'schedule/update_or_add/',
            params: {
                 year: $scope.selectedYearsItem,
                 week_id: $scope.selectedWeekItem
            },
            data: {
                schedule_days: schedule_to_send,
            }
        }).then(function successCallback(response) {
                $scope.updateSchedulesAfterSaveNewones(response.data.scheduleds_added);
                console.log(response.data.scheduleds_added);
            console.log($scope.employeesScheduleList);
                Spinner.hide_Loader();

            },
            function errorCallback(response) {
                console.log(response)
            }
        );
    }

    $scope.updateSchedulesAfterSaveNewones = function (new_schedules) {
        var sche;
        for(var i = 0 ; i < new_schedules.length ; i++){
            for(var j = 0 ; j < $scope.employeesScheduleList.length ; j++){
                if($scope.employeesScheduleList[j].category_name == new_schedules[i].category_name )
                {
                    if($scope.employeesScheduleList[j].employees != undefined)
                    for(var k = 0 ; k < $scope.employeesScheduleList[j].employees.length ; k++){
                        if($scope.employeesScheduleList[j].employees[k].schedule_days != undefined)
                        for(var l = 0 ; l < $scope.employeesScheduleList[j].employees[k].schedule_days.length ; l++){
                            sche = $scope.employeesScheduleList[j].employees[k].schedule_days[l];
                           // console.log(sche.day_of_week + "---" + new_schedules[i].day_of_week );
                            if(new_schedules[i].day_of_week == sche.day_of_week && new_schedules[i].employee_store_week_id == $scope.employeesScheduleList[j].employees[k].employee_store_week_id)
                                sche.id = new_schedules[i].id;
                        }
                    }
                }
            }
        }
    }
    
    $scope.calcDailyTotalHours = function(category,category_name, dayofweek){
        var returnTotal = 0;
        for(var i = 0 ; i < $scope.employeesScheduleList.length ; i++){
            if($scope.employeesScheduleList[i].category_name == category_name )
            {
                for(var j = 0 ; j < $scope.employeesScheduleList[i].employees.length ; j++){
                    category.total_time = $scope.calcEmployeesTotalHours($scope.employeesScheduleList[i].employees);
                    var schedule = $scope.employeesScheduleList[i].employees[j].schedule_days[dayofweek];
                    if(schedule!= undefined && schedule.time_in != undefined && schedule.time_out != undefined && schedule.break_time != undefined)
                        returnTotal += $scope.calcTimesDifferenceMinutes_Util(schedule.time_in, schedule.time_out, schedule.break_time);
                }
            }
        }
        return Utils.ParseMinutesToHoursFormat(returnTotal);
    }

    $scope.parseMinutesToHoursFormat = function (minutes) {
        return Utils.ParseMinutesToHoursFormat(minutes);
    }

    $scope.calcEmployeesTotalHours = function (employees) {
        var totalhours = 0;
        var totalTotal = 0;

        for(var i = 0 ; i < employees.length ; i++){
            totalhours = 0;
            for(var j = 0 ; j < employees[i].schedule_days.length ; j++){
                var schedule = employees[i].schedule_days[j];
                totalhours += $scope.calcTimesDifferenceMinutes_Util(schedule.time_in, schedule.time_out, schedule.break_time);
            }
            totalTotal += totalhours;
            employees[i].total_minutes_at_week = totalhours;
            employees[i].total_hours = Utils.ParseMinutesToHoursFormat(employees[i].total_minutes_at_week);
        }
        return totalTotal;
    }

    /* Function to calculate time difference between 2 datetimes (in Timestamp-milliseconds, or string English Date-Time)
     It can also be used the words: NOW for current date-time, and TOMORROW for the next day (the 0:0:1 time)
     Returns an object with this items {days, hours, minutes, seconds, totalhours, totalmin, totalsec}
     */
    function diffDateTime(startDT, endDT){
        // JavaScript & jQuery Course - https://coursesweb.net/javascript/
        // if paramerer is string, only the time hh:mm:ss (with, or without AM/PM), create Date object for current date-time,
        // and adds hour, minutes, seconds from paramerer
        //else, if the paramerer is "now", sets Date object with current date-time
        //else, if the paramerer is "tomorrow", sets Date object with current date, and the hour 24 + 1 second
        // else create Date object with date time from startDT and endDT
        if(typeof startDT == 'string' && startDT.match(/^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}[amp ]{0,3}$/i)){
            startDT = startDT.match(/^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}/);
            startDT = startDT.toString().split(':');
            var obstartDT = new Date();
            obstartDT.setHours(startDT[0]);
            obstartDT.setMinutes(startDT[1]);
            obstartDT.setSeconds(startDT[2]);
        }
        else if(typeof startDT == 'string' && startDT.match(/^now$/i)) var obstartDT = new Date();
        else if(typeof startDT == 'string' && startDT.match(/^tomorrow$/i)){
            var obstartDT = new Date();
            obstartDT.setHours(24);
            obstartDT.setMinutes(0);
            obstartDT.setSeconds(1);
        }
        else var obstartDT = new Date(startDT);

        if(typeof endDT == 'string' && endDT.match(/^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}[amp ]{0,3}$/i)){
            endDT = endDT.match(/^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}/);
            endDT = endDT.toString().split(':');
            var obendDT = new Date();
            obendDT.setHours(endDT[0]);
            obendDT.setMinutes(endDT[1]);
            obendDT.setSeconds(endDT[2]);
        }
        else if(typeof endDT == 'string' && endDT.match(/^now$/i)) var obendDT = new Date();
        else if(typeof endDT == 'string' && endDT.match(/^tomorrow$/i)){
            var obendDT = new Date();
            obendDT.setHours(24);
            obendDT.setMinutes(0);
            obendDT.setSeconds(1);
        }
        else var obendDT = new Date(endDT);

        // gets the difference in number of seconds
        // if the difference is negative, the hours are from different days, and adds 1 day (in sec.)
        var secondsDiff = (obendDT.getTime() - obstartDT.getTime()) > 0 ? (obendDT.getTime() - obstartDT.getTime()) / 1000 :  (86400000 + obendDT.getTime() - obstartDT.getTime()) / 1000;
        secondsDiff = Math.abs(Math.floor(secondsDiff));

        var oDiff = {};     // object that will store data returned by this function

        oDiff.days = Math.floor(secondsDiff/86400);
        oDiff.totalhours = Math.floor(secondsDiff/3600);      // total number of hours in difference
        oDiff.totalmin = Math.floor(secondsDiff/60);      // total number of minutes in difference
        oDiff.totalsec = secondsDiff;      // total number of seconds in difference

        secondsDiff -= oDiff.days*86400;
        oDiff.hours = Math.floor(secondsDiff/3600);     // number of hours after days

        secondsDiff -= oDiff.hours*3600;
        oDiff.minutes = Math.floor(secondsDiff/60);     // number of minutes after hours

        secondsDiff -= oDiff.minutes*60;
        oDiff.seconds = Math.floor(secondsDiff);     // number of seconds after minutes

        return oDiff;
    }

    $scope.getStores();
    $scope.getYears();
    $scope.getWeeks();
    Spinner.toggle();

});