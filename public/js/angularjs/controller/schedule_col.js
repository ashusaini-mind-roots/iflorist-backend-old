app.controller('schedule_colController', function ($scope, $http, $localStorage, API_URL) {
    console.log('schedule_col.js load success');

    $scope.example = {
        value: new Date("2019-05-31 07:00:00"),
        value1: new Date("2019-05-31 14:50:00")
    };

    $scope.storesList = {};
    $scope.selectedStoreItem = 1;

    $scope.yearsList = {};
    $scope.selectedYearsItem = "2018";

    $scope.weekList = {};
    $scope.selectedWeekItem = "1";

    $scope.employeesScheduleList = {};

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
                    $scope.getScheduleInformation();
                }
            );
        }
    }

    $scope.getScheduleInformation = function () {
        $http({
            method: 'GET',
            url: API_URL + 'schedule/all/' + $scope.selectedStoreItem + '/' + $scope.selectedWeekItem,
        }).then(
            function successCallback(response) {
                $scope.parseScheduleInformationResponse(response.data.categories_schedules);
                // $scope.employeesScheduleList = response.data.categories_schedules;
                console.log(response.data)
            }
        );
    }

    $scope.parseScheduleInformationResponse = function(categories_schedules){
        console.log(categories_schedules)
        for(var i = 0 ; i < categories_schedules.length ; i++){
            for(var j = 0 ; j < categories_schedules[i].employees.length ; j++){
                console.log("pepe"+categories_schedules[i].employees)
                for(var k = 0 ; k < categories_schedules.employees[j].schedule_days.length ; k++){
                    categories_schedules.employees.schedule_days[k].time_in = new date(categories_schedules.employees.schedule_days[k].time_in);
                    categories_schedules.employees.schedule_days[k].time_out = new date(categories_schedules.employees.schedule_days[k].time_out);
                   // console.log(categories_schedules.employees.schedule_days[k].time_in)
                }
            }
        }
        $scope.employeesScheduleList = categories_schedules;
       // console.log($scope.employeesScheduleList)
    }

    $scope.calcTimesDifference = function (time_in, time_out, break_time) {
        //var hours = (diffDateTime(time_in,time_out).totalmin - break_time) / 60;
        console.log(time_in + ' --- ' + time_out + " ---- " )
        //return hours.toFixed(2);

        // var objDiff = diffDateTime('8:35:6', '8:55:34 AM');
        // var dtdiff = objDiff.days+ ' days, '+ objDiff.hours+ ' hours, '+ objDiff.minutes+ ' minutes, '+ objDiff.seconds+ ' seconds';
        // var total_hours = 'Total Hours: '+ objDiff.totalhours;
        // var total_min = 'Total minutes: '+ objDiff.totalmin;
        return 3;
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


});