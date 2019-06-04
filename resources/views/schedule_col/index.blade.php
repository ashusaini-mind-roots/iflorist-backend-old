@extends('contentlayout')
@section('content')
    <div ng-controller="schedule_colController" class="">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label for="storesid">Select store</label>
                                <select id = "storesid" class="form-control" ng-required="true" ng-model="selectedStoreItem" ng-options="store.id as store.store_name for store in storesList"  >
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="yearsid">Select year</label>
                                <select id = "yearsid" class="form-control" ng-required="true" ng-model="selectedYearsItem" ng-options="year for year in yearsList" ng-change="getWeeks()">
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="weeksid">Select week</label>
                                <select id = "weeksid" class="form-control" ng-required="true" ng-model="selectedWeekItem" ng-options="week.id as week.number for week in weekList" ng-change="getScheduleInformation()">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <div class="card mt-5 ">
                    <div class="card-body">
                        <h5 class="card-title">Schedule</h5>
                        <div ng-show="category.employees.length > 0" class="row mb-5" ng-repeat="category in employeesScheduleList">
                            <div class="col">
                                <div class="table-responsive mb-5" >
                                    <span>@{{category.category_name}}</span>
                                    <!--Table-->
                                    <table class="table">
                                        <!--Table head-->
                                        <thead>
                                        <tr>
                                            <th class="th-sm"></th>
                                            <th class="th-sm">Monday</th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm">Tuesday</th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm">Wednesday</th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm">Thursday</th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm">Friday</th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm">Saturday</th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm">Sunday</th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                        </tr>
                                        <tr>
                                            <th class="th-sm">Employee</th>
                                            <th class="th-sm">Time In</th>
                                            <th class="th-sm">Brake</th>
                                            <th class="th-sm">Time Out</th>
                                            <th class="th-sm">Total Hours</th>

                                            <th class="th-sm">Time In</th>
                                            <th class="th-sm">Brake</th>
                                            <th class="th-sm">Time Out</th>
                                            <th class="th-sm">Total Hours</th>

                                            <th class="th-sm">Time In</th>
                                            <th class="th-sm">Brake</th>
                                            <th class="th-sm">Time Out</th>
                                            <th class="th-sm">Total Hours</th>

                                            <th class="th-sm">Time In</th>
                                            <th class="th-sm">Brake</th>
                                            <th class="th-sm">Time Out</th>
                                            <th class="th-sm">Total Hours</th>

                                            <th class="th-sm">Time In</th>
                                            <th class="th-sm">Brake</th>
                                            <th class="th-sm">Time Out</th>
                                            <th class="th-sm">Total Hours</th>

                                            <th class="th-sm">Time In</th>
                                            <th class="th-sm">Brake</th>
                                            <th class="th-sm">Time Out</th>
                                            <th class="th-sm">Total Hours</th>

                                            <th class="th-sm">Time In</th>
                                            <th class="th-sm">Brake</th>
                                            <th class="th-sm">Time Out</th>
                                            <th class="th-sm">Total Hours</th>
                                        </tr>
                                        </thead>
                                        <!--Table head-->

                                        <!--Table body-->
                                        <tbody>
                                        <tr ng-repeat="employee in category.employees">
                                            <td>@{{employee.name}}</td>
                                            {{--<td ng-repeat-start="schedule_day in employee.schedule_days">--}}
                                            <td ng-repeat-start="x in [].constructor(7) track by $index" >
                                                <input type="time" ng-model="employee.schedule_days[$index].time_in" placeholder="HH:mm" >
                                            </td>
                                            <td>
                                                <input type="number" style="max-width:60px;" ng-model="employee.schedule_days[$index].break_time" placeholder="min" >
                                                min</td>
                                            <td>
                                                <input type="time" ng-model="employee.schedule_days[$index].time_out" placeholder="HH:mm" >
                                            </td>
                                            <td ng-repeat-end>@{{calcTimesDifference(employee.schedule_days[$index].time_in | date: "HH:mm:ss",employee.schedule_days[$index].time_out|date:"HH:mm:ss",employee.schedule_days[$index].break_time)}}</td>
                                        </tr>
                                        {{--<tr>--}}
                                            {{--<td></td>--}}
                                            {{--<td ng-repeat-start="schedule_day in employee.schedule_days"></td>--}}
                                            {{--<td></td>--}}
                                            {{--<td></td>--}}
                                            {{--<td ng-repeat-end>25</td>--}}
                                        {{--</tr>--}}
                                        </tbody>
                                        <!--Table body-->
                                    </table>
                                    <!--Table-->
                                </div>
                                <button type="button" class="btn btn-primary" ng-click="updateSchedulesByCategory(category.employees)" ng-disabled="saveDays_btnDisable">Save changes</button>
                                <hr>
                            </div>
                            <div class="row ml-1">
                                <div class="col">
                                    <div class="form-group text-center">
                                        <label for="inputTotal">Monday </label>
                                        {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                        <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category.category_name,0)}}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group text-center">
                                        <label for="inputTotal">Tuesday </label>
                                        {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                        <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category.category_name,1)}}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group text-center">
                                        <label for="inputTotal">Wednesday </label>
                                        {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                        <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category.category_name,2)}}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group text-center">
                                        <label for="inputTotal">Thursday </label>
                                        {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                        <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category.category_name,3)}}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group text-center">
                                        <label for="inputTotal">Friday </label>
                                        {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                        <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category.category_name,4)}}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group text-center">
                                        <label for="inputTotal">Saturday </label>
                                        {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                        <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category.category_name,5)}}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group text-center">
                                        <label for="inputTotal">Sunday </label>
                                        {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                        <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category.category_name,6)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    {{--<div class="card-footer text-right">--}}
                    {{--<form class="form-inline">--}}
                    {{--<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Number" ng-model="invoiceNumber_add">--}}
                    {{--<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Name" ng-model="invoiceName_add">--}}
                    {{--<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Value" ng-model="invoiceTotal_add">--}}

                    {{--<button type="submit" class="btn btn-primary" ng-click="createInvoice()">Add invoise</button>--}}
                    {{--</form>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>



    </div>
@endsection

@section('js')
    <script src="{{asset('js/angularjs/controller/schedule_col.js')}}"></script>
@endsection