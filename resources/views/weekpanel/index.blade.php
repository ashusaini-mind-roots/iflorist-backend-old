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
        <div class="row mb-5">
            <div class="col-12">
                <div class="card mt-5 ">
                    <div class="card-body">
                        <h5 class="card-title">Actual daily revenue</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <span>@{{monday.dates_dim_date}}</span>
                                    <label for="inputMonday">Monday</label>
                                    <input  type="text"  class="form-control form-control-plaintext" id="inputMonday" ng-model="monday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <span>@{{tuesday.dates_dim_date}}</span>
                                    <label for="inputTuesday">Tuesday</label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputTuesday" ng-model="tuesday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <span>@{{wednesday.dates_dim_date}}</span>
                                    <label for="inputWednesday">Wednesday </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputWednesday" ng-model="wednesday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <span>@{{thursday.dates_dim_date}}</span>
                                    <label for="inputThursday">Thursday  </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputThursday" ng-model="thursday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <span>@{{friday.dates_dim_date}}</span>
                                    <label for="inputFriday">Friday  </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputFriday" ng-model="friday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <span>@{{saturday.dates_dim_date}}</span>
                                    <label for="inputSaturday">Saturday  </label>
                                    <input type="text" class="form-control form-control-plaintext" id="inputSaturday" ng-model="saturday.amt" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <span>@{{sunday.dates_dim_date}}</span>
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
                        <button type="button" class="btn btn-primary" ng-click="updateDaysAmtValues()" ng-disabled="saveDays_btnDisable">Save changes</button>
                        {{--<a href="#" class="btn btn-primary" ng-click="updateDaysAmtValues()">Save changes</a>--}}

                    </div>

                </div>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">$8,539.00</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Proj. Weekly Rev.</h6>
                        {{--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                        {{--<a href="#" class="card-link">Card link</a>--}}
                        {{--<a href="#" class="card-link">Another link</a>--}}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">20%</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Target COG's.</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">@{{calcRunningCOG() | number:2}} %</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Running COG's %</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">7%</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Difference</h6>
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
                                        </tr>
                                        </thead>
                                        <!--Table head-->

                                        <!--Table body-->
                                        <tbody>
                                        <tr ng-repeat="invoice in invoices">
                                            <td>@{{invoice.invoice_number}}</td>
                                            <td>@{{invoice.invoice_name}}</td>
                                            <td>@{{invoice.total}}</td>

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
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Number" ng-model="invoiceNumber_add">
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Name" ng-model="invoiceName_add">
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Value" ng-model="invoiceTotal_add">

                            <button type="submit" class="btn btn-primary" ng-click="createInvoice()">Add invoise</button>
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