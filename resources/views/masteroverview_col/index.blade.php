@extends('contentlayout')
@section('content')
    <div ng-controller="masterOverview_ColController" class="">
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
                                        ng-change="getOverviewDataFromServer()">
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="yearsid">Select year</label>
                                <select id="yearsid" class="form-control" ng-required="true"
                                        ng-model="selectedYearsItem" ng-options="year for year in yearsList"
                                        ng-change="getOverviewDataFromServer()">
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
                        <h5 class="card-title">Master Weekly Cost of Labor</h5>
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
                                            <th class="th-sm">Proj. Hours Allowed.</th>
                                            <th class="th-sm">Target Percentage</th>
                                            <th class="th-sm">Actual Sales</th>
                                            <th class="th-sm">Scheduled Hours</th>
                                            <th class="th-sm">Difference</th>
                                            <th class="th-sm">Actions</th>
                                        </tr>
                                        </thead>
                                        <!--Table head-->

                                        <!--Table body-->
                                        <tbody>
                                        <tr ng-repeat="week in weeks" ng-class="week.difference<0?'text-danger':''">
                                            <td>@{{week.week_ending}}</td>
                                            <td>@{{week.projected_weekly_revenue | currency}}</td>
                                            <td>@{{week.projection_total_hours_allowed }}</td>
                                            <td>@{{week.target_percentage }}%</td>
                                            <td >@{{week.actual_sales | currency}}</td>
                                            <td>@{{week.total_cheduled_hours}}</td>
                                            <td ng-class="week.difference<0?'font-weight-bold':''">
                                                @{{week.difference}}
                                            </td>
                                            <td id="@{{week.week_id}}">
                                                <button type="button" class="btn btn-link btn-sm"
                                                        ng-click="goToweekControlPage(week.week_id)">View
                                                </button>
                                                <button type="button" class="btn btn-link btn-sm"
                                                        ng-click="showEditTarget(week,week.target_percentage)">Edit target
                                                </button>
                                                {{--<button type="button" class="btn btn-link btn-sm"--}}
                                                        {{--ng-click="showEditProjection(week)">Edit proj--}}
                                                {{--</button>--}}
                                            </td>
                                        </tr>
                                        </tbody>
                                        <!--Table body-->
                                    </table>
                                    <!--Table-->
                                </div>
                            </div>
                        </div>
                        {{--<hr/>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-2">--}}
                                {{--<label>AVG Actual</label>--}}
                                {{--<input type="text" class="form-control " placeholder="Value" ng-model="invoiceTotal_add">--}}
                                {{--<div>@{{avgActual | number : 2 }} %</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-2">--}}
                                {{--<label>AVG Target</label>--}}
                                {{--<input type="text" class="form-control " placeholder="Value" ng-model="invoiceTotal_add">--}}
                                {{--<div>@{{avgTarget | number : 2 }} %</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-2">--}}
                                {{--<label>AVG Difference</label>--}}
                                {{--<input type="text" class="form-control " placeholder="Value" ng-model="invoiceTotal_add">--}}
                                {{--<div>@{{avgDifference | number : 2 }} %</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
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

        <div class="modal" id="targetModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content top-info">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        {{--<h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>--}}
                    </div>
                    <div class="modal-body">
                        <form name="frmTarget" class="form-horizontal" novalidate="">
                            <div class="form-group error">
                                <label for="inputEmail3" class="col-sm-4 control-label">% Target *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control has-error" id="targetValue" name="targetValue" placeholder="Target value" value="@{{targetSelected}}"
                                           ng-model="targetSelected" ng-required="true">
                                    <span class="help-inline" ng-show="frmTarget.targetValue.$invalid && frmTarget.targetValue.$touched">Value Required</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="editTarget()" ng-disabled="frmTarget.$invalid">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="projectionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content top-info">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        {{--<h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>--}}
                    </div>
                    <div class="modal-body">
                        <form name="frmProjection" class="form-horizontal" novalidate="">
                            <div class="form-group error">
                                <label for="downValue" class="col-sm-4 control-label">% Down *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control has-error" id="downValue" name="downValue" placeholder="Down value" value="@{{downPercentSelected}}"
                                           ng-model="downPercentSelected" ng-required="true">
                                    <span class="help-inline" ng-show="frmProjection.downValue.$invalid && frmProjection.downValue.$touched">Value Required</span>
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="downValue" class="col-sm-5 control-label">Year Reference *</label>
                                <div class="col-sm-9">
                                    <select id="yearReferenceProjectionSelectedId" class="form-control" ng-required="true"
                                            ng-model="yearReferenceProjectionSelected" ng-options="year for year in yearsList" id="yearProjectionValue" name="yearProjectionValue">
                                    </select>
                                    <span class="help-inline" ng-show="frmProjection.yearProjectionValue.$invalid && frmProjection.yearProjectionValue.$touched">Value Required</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="editProjection()" ng-disabled="frmProjection.$invalid">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/angularjs/controller/masteroverview_col.js')}}"></script>
@endsection