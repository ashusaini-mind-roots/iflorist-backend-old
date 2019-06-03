@extends('contentlayout')
@section('content')
    <style>

    </style>
    <div ng-controller="weekPanelController" class="">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label for="storesid">Select store</label>
                                <select id="storesid" class="form-control" ng-required="true"
                                        ng-model="selectedStoreItem"
                                        ng-options="store.id as store.store_name for store in storesList"
                                        ng-change="getWeekDataFromServer()">
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="yearsid">Select year</label>
                                <select id="yearsid" class="form-control" ng-required="true"
                                        ng-model="selectedYearsItem" ng-options="year for year in yearsList"
                                        ng-change="getWeeks()">
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="weeksid">Select week</label>
                                <select id="weeksid" class="form-control" ng-required="true" ng-model="selectedWeekItem"
                                        ng-options='week.id as (week.number+"-"+week.week_end_day) for week in weekList'
                                        ng-change="getWeekDataFromServer()">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--daily revenues--}}
        <div class="row mb-5">
            <div class="col-12">
                <div class="card mt-5 ">
                    <div class="card-body">
                        <h5 class="card-title">Actual daily revenue</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-group text-center">
                                    <span>@{{monday.dates_dim_date | date:'MM/dd/yyyy'}}</span><br>
                                    <label for="inputMonday">Monday</label>
                                    <input type="text"
                                           class="form-control form-control-plaintext text-center font-weight-bold"
                                           id="inputMonday" ng-model="monday.amt_formatted"
                                           data-type="currency"
                                    >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group text-center">
                                    <span>@{{tuesday.dates_dim_date | date:'MM/dd/yyyy'}}</span><br>
                                    <label for="inputTuesday">Tuesday</label>
                                    <input type="text"
                                           class="form-control form-control-plaintext text-center font-weight-bold"
                                           id="inputTuesday" ng-model="tuesday.amt_formatted">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group text-center">
                                    <span>@{{wednesday.dates_dim_date | date:'MM/dd/yyyy'}}</span><br>
                                    <label for="inputWednesday">Wednesday </label>
                                    <input type="text"
                                           class="form-control form-control-plaintext text-center font-weight-bold"
                                           id="inputWednesday" ng-model="wednesday.amt_formatted">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group text-center">
                                    <span>@{{thursday.dates_dim_date | date:'MM/dd/yyyy'}}</span><br>
                                    <label for="inputThursday">Thursday </label>
                                    <input type="text"
                                           class="form-control form-control-plaintext text-center font-weight-bold"
                                           id="inputThursday" ng-model="thursday.amt_formatted">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group text-center">
                                    <span>@{{friday.dates_dim_date | date:'MM/dd/yyyy'}}</span><br>
                                    <label for="inputFriday">Friday </label>
                                    <input type="text"
                                           class="form-control form-control-plaintext text-center font-weight-bold"
                                           id="inputFriday" ng-model="friday.amt_formatted">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group text-center">
                                    <span>@{{saturday.dates_dim_date | date:'MM/dd/yyyy'}}</span><br>
                                    <label for="inputSaturday">Saturday </label>
                                    <input type="text"
                                           class="form-control form-control-plaintext text-center font-weight-bold"
                                           id="inputSaturday" ng-model="saturday.amt_formatted">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group text-center">
                                    <span>@{{sunday.dates_dim_date | date:'MM/dd/yyyy'}}</span><br>
                                    <label for="inputSunday">Sunday</label>
                                    <input type="text"
                                           class="form-control form-control-plaintext text-center font-weight-bold"
                                           id="inputSunday" ng-model="sunday.amt_formatted">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group text-center">
                                    <label for="inputTotal">Total </label>
                                    {{--<input hidden type="text" class="form-control" id="inputTotal" ng-model="dailyRevenueTotal" value = @{{calcDailyTotal()}} >--}}
                                    <div class="font-weight-bold text-center">@{{calcDailyTotal()|currency}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary" ng-click="updateDaysAmtValues()"
                                ng-disabled="saveDays_btnDisable">Save changes
                        </button>
                        {{--<a href="#" class="btn btn-primary" ng-click="updateDaysAmtValues()">Save changes</a>--}}

                    </div>

                </div>
                {{--<div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>--}}
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Proj. Weekly Rev.</h6>
                        <h5 class="card-title">@{{projWeeklyRev | currency}}</h5>
                        {{--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                        {{--<a href="#" class="card-link">Card link</a>--}}
                        {{--<a href="#" class="card-link">Another link</a>--}}
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Current Rev.</h6>
                        <h5 class="card-title">@{{calcDailyTotal()|currency}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Proj. Purch. Budget.</h6>
                        <h5 class="card-title">@{{projWeeklyRev * (targetCOG/100) | currency}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Target COG's.</h6>
                        <h5 class="card-title">@{{targetCOG | number:2}} %
                            <hr>
                            @{{ getTargetCOGInMoney() | currency }}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Running COG's</h6>
                        <h5 class="card-title" ng-class=(targetCOG<calcRunningCOG())?'text-danger':''>
                            @{{calcRunningCOG() | number:2}} %
                            <hr>
                            @{{invoiceTotal|currency}}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Difference</h6>
                        <h5 class="card-title" ng-class="(calcCostDifference())<0?'text-danger':''">
                            @{{calcCostDifference() | number:2}}%
                            <hr>
                            @{{getTargetCOGInMoney() - invoiceTotal | currency}}
                        </h5>
                    </div>
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
                                            <th class="th-sm">Actions</th>
                                        </tr>
                                        </thead>
                                        <!--Table head-->

                                        <!--Table body-->
                                        <tbody ng-cloak>
                                        <tr ng-repeat="invoice in invoices">
                                            <td>@{{invoice.invoice_number}}</td>
                                            <td>@{{invoice.invoice_name}}</td>
                                            <td>@{{invoice.total | currency}}</td>
                                            <td>
                                                <button class="btn btn-danger btn-xs btn-delete"
                                                        ng-click="confirmDeleteInvoice(invoice.id)">Delete
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <!--Table body-->
                                    </table>
                                    <!--Table-->
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">

                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-2">

                                <label>Total value</label>
                                {{--<input type="text" class="form-control " placeholder="Value" ng-model="invoiceTotal_add">--}}
                                <div>@{{invoiceTotal|currency}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <form class="form-inline">
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Number"
                                   ng-model="invoiceNumber_add">
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Name"
                                   ng-model="invoiceName_add">
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Value"
                                   ng-model="invoiceTotal_add">

                            <button type="submit" class="btn btn-primary" ng-click="createInvoice()">Add invoise
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--notes--}}
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Notes</h5>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                                <textarea rows="7" class="form-control mb-2 mr-sm-2 mb-sm-0"
                                          ng-model="notesText"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" ng-click="updateNotes()">Update notes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/angularjs/controller/weekpanel.js')}}"></script>
@endsection
