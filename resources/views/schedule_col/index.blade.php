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
                                <select id = "storesid" class="form-control" ng-required="true" ng-model="selectedStoreItem" ng-options="store.id as store.store_name for store in storesList"
                                        ng-change="getWeeks()">
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

        <div class="row mt-5">
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Projected Sales</h6>
                        <h5 class="card-title ng-cloak">@{{projWeeklyRev | currency}}</h5>
                        {{--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                        {{--<a href="#" class="card-link">Card link</a>--}}
                        {{--<a href="#" class="card-link">Another link</a>--}}
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Projected Payroll</h6>
                        <h5 class="card-title  ng-cloak">@{{calcProjectedPayRol()|currency}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Scheduled Payroll</h6>
                        <h5 class="card-title ng-cloak">@{{scheduledPayroll | currency}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Target COL's.</h6>
                        <h5 class="card-title ng-cloak">@{{targetCOL | number:2}} %
                            {{--<hr>--}}
                            {{--@{{ getTargetCOGInMoney() | currency }}--}}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Difference</h6>
                        <h5 class="card-title ng-cloak" ng-class=(differenceCol<0)?'text-danger':''>
                            @{{differenceCol | currency }}
                            {{--<hr>--}}
                            {{--@{{invoiceTotal|currency}}--}}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Difference</h6>
                        <h5 class="card-title ng-cloak" ng-class="(calcCostDifference())<0?'text-danger':''">
                            @{{calcCostDifference() | number:2}}%
                            {{--<hr>--}}
                            {{--@{{getTargetCOGInMoney() - invoiceTotal | currency}}--}}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-12">
                <div class="card mt-5 ">
                    <div class="card-body">
                        <h5 class="card-title">Schedule</h5>
                        <div ng-show="category.employees.length > 0" class="row mb-5" ng-repeat="category in employeesScheduleList">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
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
                                        <button type="button" class="btn btn-primary" ng-click="updateSchedulesByCategory(category.employees,category.category_name)">Save changes</button>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group text-center">
                                                    <label for="inputTotal">Monday </label>
                                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                                    <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category,category.category_name,0)}}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group text-center">
                                                    <label for="inputTotal">Tuesday </label>
                                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                                    <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category,category.category_name,1)}}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group text-center">
                                                    <label for="inputTotal">Wednesday </label>
                                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                                    <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category,category.category_name,2)}}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group text-center">
                                                    <label for="inputTotal">Thursday </label>
                                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                                    <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category,category.category_name,3)}}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group text-center">
                                                    <label for="inputTotal">Friday </label>
                                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                                    <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category,category.category_name,4)}}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group text-center">
                                                    <label for="inputTotal">Saturday </label>
                                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                                    <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category,category.category_name,5)}}</div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group text-center">
                                                    <label for="inputTotal">Sunday </label>
                                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                                    <div class="font-weight-bold text-center">@{{calcDailyTotalHours(category,category.category_name,6)}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <table class="table">
                                                <thead class="thead-light">
                                                <tr>

                                                    <th scope="col">Name</th>
                                                    <th scope="col">Hours</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="employee_total in entities = category.employees">
                                                        <td>@{{employee_total.name}}</td>
                                                        <td>@{{employee_total.total_hours}}</td>
                                                    </tr>
                                                    <tr class="table-active">
                                                        <td>Total</td>
                                                        <td>@{{parseMinutesToHoursFormat(category.total_time)}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            {{--<div class="col-12 ml-2">--}}
                                                {{--<div class="row" ng-repeat="employee_total in entities = (entities || calcEmployeesTotalHours(category.employees))">--}}
                                                    {{--<div class="col-3">@{{employee_total.name}}</div>--}}
                                                    {{--<div class="col-3">@{{employee_total.weekly_total_hours}}</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
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