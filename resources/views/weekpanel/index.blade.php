@extends('contentlayout')
@section('content')
    <div ng-controller="weekPanelController" class="">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label for="storesid">Select store</label>
                                <select id = "storesid" class="form-control" ng-required="true" ng-model="selectedStoreItem" ng-options="store.id as store.store_name for store in storesList">
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="yearsid">Select year</label>
                                <select id = "yearsid" class="form-control" ng-required="true" ng-model="selectedYearsItem" ng-options="year for year in yearsList" ng-change="getWeeks()">
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="weeksid">Select week</label>
                                <select id = "weeksid" class="form-control" ng-required="true" ng-model="selectedWeekItem" ng-options="week.id as week.number for week in weekList" ng-change="getWeekDataFromServer()">

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--daily revenues--}}
        <div class="row">
            <div class="col-12">
                <div class="card mt-5 ">
                    <div class="card-body">
                        <h5 class="card-title">Actual daily revenue</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputMonday">Monday</label>
                                    <input  type="text"  class="form-control form-control-plaintext" id="inputMonday" ng-model="monday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputTuesday">Tuesday</label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputTuesday" ng-model="tuesday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputWednesday">Wednesday </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputWednesday" ng-model="wednesday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputThursday">Thursday  </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputThursday" ng-model="thursday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputFriday">Friday  </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputFriday" ng-model="friday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputSaturday">Saturday  </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputSaturday" ng-model="saturday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputSunday">Sunday  </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputSunday" ng-model="sunday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputTotal">Total  </label>
                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                    <div>@{{calcDailyTotal()|currency}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="#" class="btn btn-primary" ng-click="updateDaysAmtValues()">Save changes</a>

                    </div>

                </div>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        {{--invoices--}}
        <div class="row mb-5">
            <div class="col-12">
                <div class="card mt-5 ">
                    <div class="card-body">
                        <h5 class="card-title">Invoices</h5>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">

                                    <!--Table-->
                                    <table class="table">

                                        <!--Table head-->
                                        <thead>
                                        <tr>
                                            <th class="th-sm">Number</th>
                                            <th class="th-sm">Name</th>
                                            <th class="th-sm">Value</th>
                                        </tr>
                                        </thead>
                                        <!--Table head-->

                                        <!--Table body-->
                                        <tbody>
                                        <tr ng-repeat="invoice in invoices">
                                            <td>{{invoice.invoice_number}}</td>
                                            <td>{{invoice.invoice_name}}</td>
                                            <td>{{invoice.total}}</td>
                                            <td>{{user.hobby}}</td>
                                        </tr>
                                        </tbody>
                                        <!--Table body-->

                                    </table>
                                    <!--Table-->

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <form class="form-inline">
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="Number">
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInputGroup" placeholder="Name">
                            <input type="number" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInputGroup" placeholder="Value">

                            <button type="submit" class="btn btn-primary">Add invoise</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/angularjs/controller/weekpanel.js')}}"></script>
@endsection