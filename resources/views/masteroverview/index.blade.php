@extends('contentlayout')
@section('content')
    <div ng-controller="masterOverviewController" class="">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label for="storesid">Select store</label>
                                <select id = "storesid" class="form-control" ng-required="true" ng-model="selectedStoreItem" ng-options="store.id as store.store_name for store in storesList" ng-change="getOverviewDataFromServer()">
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="yearsid">Select year</label>
                                <select id = "yearsid" class="form-control" ng-required="true" ng-model="selectedYearsItem" ng-options="year for year in yearsList" ng-change="getOverviewDataFromServer()">
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--master overview table--}}
        <div class="row mb-5">
            <div class="col-12">
                <div class="card mt-5 ">
                    <div class="card-body">
                        <h5 class="card-title">Master Weekly Cost of Fresh</h5>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">

                                    <!--Table-->
                                    <table class="table">

                                        <!--Table head-->
                                        <thead>
                                        <tr>
                                            <th class="th-sm">Week Ending</th>
                                            <th class="th-sm">Proj. Weekly Rev.</th>
                                            <th class="th-sm">Actual Weekly Rev.</th>
                                            <th class="th-sm">Weekly COG's Total</th>
                                            <th class="th-sm">Actual</th>
                                            <th class="th-sm">Target</th>
                                            <th class="th-sm">Difference</th>
                                            <th class="th-sm">Actions</th>
                                        </tr>
                                        </thead>
                                        <!--Table head-->

                                        <!--Table body-->
                                        <tbody>
                                        <tr ng-repeat="week in weeks">
                                            <td>@{{week.week_ending}}</td>
                                            <td>@{{week.projected_weekly_revenue | currency}}</td>
                                            <td>@{{week.actual_weekly_revenue | currency}}</td>
                                            <td>@{{week.weekly_cog_total | currency}}</td>
                                            <td>@{{week.actual}}%</td>
                                            <td>@{{week.target}}%</td>
                                            <td>@{{week.difference}}%</td>
                                            <td id="@{{week.week_id}}"><button type="button" class="btn btn-link btn-sm" ng-click="goToweekControlPage(week.week_id)" >View</button></td>
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
                                    <label>AVG Actual</label>
                                    {{--<input type="text" class="form-control " placeholder="Value" ng-model="invoiceTotal_add">--}}
                                    <div>@{{avgActual | number : 2 }} %</div>
                                </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <label>AVG Target</label>
                                {{--<input type="text" class="form-control " placeholder="Value" ng-model="invoiceTotal_add">--}}
                                <div>@{{avgTarget | number : 2 }} %</div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <label>AVG Difference</label>
                                {{--<input type="text" class="form-control " placeholder="Value" ng-model="invoiceTotal_add">--}}
                                <div>@{{avgDifference | number : 2 }} %</div>
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
    <script src="{{asset('js/angularjs/controller/masteroverview.js')}}"></script>
@endsection